<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;

use Illuminate\Support\Facades\Log;

use Square\SquareClient;
use Square\Payments\Requests\CreatePaymentRequest;
use Square\Types\Money;
use Square\Types\Currency;



class ShopController extends Controller
{

public function index(Request $request) 
{
    $query = Product::query()->with(['images', 'category']);

    $selectedCategory = null;
    $countryFilter = $request->filled('country') ? trim($request->country) : null;

    if ($request->filled('category')) {
        $categoryId = $request->category;
        $query->where('category_id', $categoryId);

        $selectedCategory = \App\Models\Category::withCount([
            'products as products_count' => function ($q) use ($countryFilter) {
                if ($countryFilter) $q->where('pais', $countryFilter);
            }
        ])->find($categoryId);
    }

    if ($countryFilter) {
        $query->where('pais', $countryFilter);
    }

    switch ($request->get('sort')) {
        case 'price_low':  $query->orderBy('price', 'asc'); break;
        case 'price_high': $query->orderBy('price', 'desc'); break;
        case 'name':       $query->orderBy('name', 'asc');   break;
        default:           $query->latest();                 break;
    }

    $products = $query->paginate(9)->appends($request->query());

    // Cargar categorías (con conteo si quieres)
    $categories = \App\Models\Category::query()
        ->withCount([
            'products as products_count' => function ($q) use ($countryFilter) {
                if ($countryFilter) $q->where('pais', $countryFilter);
            }
        ])
        ->orderBy('name')
        ->get();

    // HERO: si NO hay categoría seleccionada, elige una al azar.
    // Preferir una que tenga imagen; si no hay, cualquiera.
    $heroCategory = $selectedCategory;
    if (!$heroCategory) {
        $withImage = $categories->filter(fn($c) => !empty($c->image));
        $heroCategory = $withImage->isNotEmpty()
            ? $withImage->random()
            : ($categories->isNotEmpty() ? $categories->random() : null);
    }

    $countries = \App\Models\Product::query()
        ->select('pais')->whereNotNull('pais')->where('pais', '!=', '')
        ->distinct()->orderBy('pais')->pluck('pais');

    return view('shop.index', compact(
        'products', 'categories', 'countries', 'selectedCategory', 'heroCategory'
    ));
}






public function checkout() 
{
    // Verificar que el carrito no esté vacío
    if (Cart::count() == 0) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add some products before checkout.');
    }

    // Obtener información del carrito
    $cartItems = Cart::content();
         
    // Enriquecer items del carrito con información de descuento desde la BD (igual que en CartController)
    foreach ($cartItems as $item) {
        $product = Product::find($item->id);
                 
        if ($product && $product->descuento > 0) {
            // Calcular información de descuento del producto
            $originalPrice = ($product->price ?? 0) + ($product->interest ?? 0);
            $discountAmount = ($originalPrice * $product->descuento) / 100;
                         
            // Agregar información de descuento a las opciones del item
            $newOptions = $item->options->merge([
                'descuento' => $product->descuento,
                'original_price' => $originalPrice,
                'discount_amount' => $discountAmount,
            ]);
                         
            // Actualizar las opciones del item en el carrito
            Cart::update($item->rowId, [
                'options' => $newOptions->toArray()
            ]);
        }
    }
         
    // Obtener items actualizados
    $cartItems = Cart::content();
         
    // Calcular subtotal y ahorros de productos (NO tax)
    $subtotal = 0;
    $totalSavings = 0;
    $originalSubtotal = 0;
         
    foreach ($cartItems as $item) {
        $subtotal += floatval($item->total);
                 
        // Si tiene descuento, calcular ahorros
        if (isset($item->options['descuento']) && $item->options['descuento'] > 0) {
            $originalItemTotal = $item->options['original_price'] * $item->qty;
            $originalSubtotal += $originalItemTotal;
            $totalSavings += ($item->options['discount_amount'] * $item->qty);
        } else {
            $originalSubtotal += floatval($item->total);
        }
    }

    // 🚨 DEBUG: Para verificar los valores con descuentos
    \Log::info('Checkout Debug with Product Discounts:', [
        'cart_subtotal_method' => Cart::subtotal(),
        'manual_subtotal' => $subtotal,
        'original_subtotal' => $originalSubtotal,
        'total_product_savings' => $totalSavings,
        'cart_count' => Cart::count(),
    ]);

    // Verificar si el usuario está autenticado
    $user = Auth::user();

    // Obtener países y ciudades para el envío
    $countries = Country::with('cities')->orderBy('name')->get();

    // Datos para la vista (SIN tax aquí, se calculará por ciudad)
    $checkoutData = [
        'cartItems' => $cartItems,
        'subtotal' => $subtotal,
        'originalSubtotal' => $originalSubtotal,
        'totalSavings' => $totalSavings,
        'countries' => $countries,
        'isAuthenticated' => $user ? true : false,
        'user' => $user
    ];

    return view('shop.checkout', $checkoutData);
}
public function calculateCosts(Request $request)
{
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'city_id' => 'nullable|exists:cities,id',
        'subtotal' => 'required|numeric|min:0'
    ]);

    $countryId = $request->country_id;
    $cityId = $request->city_id;
    $subtotal = floatval($request->subtotal);

    // Costos base
    $tax = 0;
    $shipping = 0;

    try {
        // Calcular tax basado en la ciudad (si se seleccionó)
        if ($cityId) {
            $city = City::find($cityId);
            if ($city && $city->tax > 0) {
                $tax = ($subtotal * $city->tax) / 100;
            }
        }

        // Calcular shipping basado en el país (puedes ajustar esta lógica)
        $country = Country::find($countryId);
        if ($country) {
            // Ejemplo de lógica de shipping (ajusta según tus necesidades)
            switch ($country->name) {
                case 'Colombia':
                case 'Bogotá D.C.':
                    $shipping = $subtotal > 100 ? 0 : 15; // Envío gratis sobre $100
                    break;
                case 'United States':
                    $shipping = $subtotal > 150 ? 0 : 25;
                    break;
                default:
                    $shipping = $subtotal > 200 ? 10 : 35; // Shipping internacional
                    break;
            }
        }

        // Log para debugging
        \Log::info('Cost Calculation:', [
            'country_id' => $countryId,
            'city_id' => $cityId,
            'subtotal' => $subtotal,
            'tax_percentage' => $cityId ? ($city->tax ?? 0) : 0,
            'tax_amount' => $tax,
            'shipping' => $shipping
        ]);

        return response()->json([
            'success' => true,
            'tax_raw' => $tax,
            'tax_formatted' => number_format($tax, 2),
            'shipping_raw' => $shipping,
            'shipping_formatted' => number_format($shipping, 2),
            'total_raw' => $subtotal + $tax + $shipping,
            'total_formatted' => number_format($subtotal + $tax + $shipping, 2),
            'city_tax_percentage' => $cityId ? ($city->tax ?? 0) : 0
        ]);

    } catch (\Exception $e) {
        \Log::error('Error calculating costs: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error calculating shipping costs'
        ], 500);
    }
}
        // 🔴 Nuevo método para calcular costos dinámicamente
        public function calculateShippingAndTax(Request $request)
        {
            $countryId = $request->country_id;
            $cityId = $request->city_id;
            
            $cartItems = Cart::content();
            $subtotal = floatval(str_replace(',', '', Cart::subtotal(2, '', '')));
            
            $totalTax = 0;
            $shipping = 0;
            $shippingApplied = false;
            
            foreach ($cartItems as $item) {
                // Buscar configuración de precio para este producto y ubicación
                $priceConfig = \App\Models\Price::where('product_id', $item->id)
                    ->where('country_id', $countryId)
                    ->when($cityId, function($query) use ($cityId) {
                        return $query->where('city_id', $cityId);
                    })
                    ->first();
                
                if ($priceConfig) {
                    // Calcular impuesto por producto (interest como porcentaje)
                    $productTax = ($item->price * $item->qty * $priceConfig->interest) / 100;
                    $totalTax += $productTax;
                    
                    // Shipping se cobra solo una vez
                    if (!$shippingApplied) {
                        $shipping = $priceConfig->shipping;
                        $shippingApplied = true;
                    }
                }
            }
            
            $total = $subtotal + $totalTax + $shipping;
            
            return response()->json([
                'subtotal' => number_format($subtotal, 2),
                'tax' => number_format($totalTax, 2),
                'shipping' => number_format($shipping, 2),
                'total' => number_format($total, 2),
                'tax_raw' => $totalTax,
                'shipping_raw' => $shipping,
                'total_raw' => $total
            ]);
        }



        // En tu controlador (ShopController o donde tengas checkout)

        public function processOrder(Request $request)
        {
            // Validación
            $rules = [
                'country_id' => 'required|exists:countries,id',
                'city_id' => 'nullable|exists:cities,id',
                'total' => 'required|numeric',
                'tax' => 'required|numeric',
                'shipping' => 'required|numeric',
                'phone' => 'required|string',
                'address' => 'required|string',
                'notes' => 'nullable|string',
            ];

            // Validación adicional para guests
            if (!Auth::check()) {
                $rules['name'] = 'required|string|max:255';
                $rules['email'] = 'required|email|max:255';
            }

            $validatedData = $request->validate($rules);

            // Verificar que el carrito no esté vacío
            if (Cart::count() == 0) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            DB::beginTransaction();
            
            try {
                // Datos del cliente
                $user = Auth::user();
                $customerData = [
                    'customer_name' => $user ? $user->name : $validatedData['name'],
                    'customer_email' => $user ? $user->email : $validatedData['email'],
                    'customer_phone' => $validatedData['phone'],
                    'customer_address' => $validatedData['address'],
                ];

                // Crear la orden
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => $user ? $user->id : null, // 🔴 NULL para guests
                    ...$customerData,
                    'country_id' => $validatedData['country_id'],
                    'city_id' => $validatedData['city_id'],
                    'subtotal' => floatval(str_replace(',', '', Cart::subtotal(2, '', ''))),
                    'tax_amount' => $validatedData['tax'],
                    'shipping_amount' => $validatedData['shipping'],
                    'total_amount' => $validatedData['total'],
                    'notes' => $validatedData['notes'],
                    'status' => 'pending',
                    'payment_status' => 'pending',
                ]);

                // Crear items de la orden
                foreach (Cart::content() as $cartItem) {
                    // Calcular impuesto para este item específico
                    $priceConfig = Price::where('product_id', $cartItem->id)
                        ->where('country_id', $validatedData['country_id'])
                        ->when($validatedData['city_id'], function($query) use ($validatedData) {
                            return $query->where('city_id', $validatedData['city_id']);
                        })
                        ->first();

                    $taxRate = $priceConfig ? $priceConfig->interest : 0;
                    $itemTaxAmount = ($cartItem->price * $cartItem->qty * $taxRate) / 100;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->id,
                        'product_name' => $cartItem->name,
                        'product_price' => $cartItem->price,
                        'quantity' => $cartItem->qty,
                        'total_price' => $cartItem->total,
                        'tax_rate' => $taxRate,
                        'tax_amount' => $itemTaxAmount,
                    ]);
                }

                DB::commit();

                // Limpiar carrito
                Cart::destroy();

                // Redirigir a pasarela de pago
                return redirect()->route('payment.gateway', ['order' => $order->id])
                                ->with('success', 'Order created successfully! Order #' . $order->order_number);

            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'Error creating order: ' . $e->getMessage());
            }
        }

 public function paymentGateway(Order $order)
{
    // Verificar que la orden exista y esté pendiente
    if ($order->payment_status !== 'pending') {
        return redirect()->route('shop.index')->with('error', 'Order not found or already processed.');
    }

    return view('payment.gateway', compact('order'));
}
public function processPayment(Request $request, Order $order)
{
    // Verificar que la orden esté pendiente
    if ($order->payment_status !== 'pending') {
        return redirect()->route('shop.index')->with('error', 'Order already processed.');
    }

    try {
        // Validar datos del pago
        $request->validate(['source_id' => 'required|string']);

        \Log::info('Processing payment for order', [
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'source_id' => $request->source_id
        ]);

        // Crear pago usando cURL (método que funciona)
        $paymentData = [
            'idempotency_key' => 'order_' . $order->id . '_' . time(),
            'source_id' => $request->source_id,
            'amount_money' => [
                'amount' => $order->total_amount * 100, // Convertir a centavos
                'currency' => 'USD'
            ],
            'location_id' => config('square.location_id'),
            'note' => 'Order #' . $order->order_number
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://connect.squareupsandbox.com/v2/payments');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . config('square.access_token'),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = isset($errorData['errors'][0]['detail']) 
                ? $errorData['errors'][0]['detail'] 
                : 'Payment processing failed';
            
            \Log::error('Square payment failed', [
                'http_code' => $httpCode,
                'response' => $response
            ]);
            
            return back()->with('error', 'Payment failed: ' . $errorMessage);
        }

        // Pago exitoso
        $paymentResult = json_decode($response, true);
        $transactionId = $paymentResult['payment']['id'];
        
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed', 
            'payment_method' => 'square',
            'transaction_id' => $transactionId,
            'paid_at' => now()
        ]);

        \Log::info('Payment successful', [
            'order_id' => $order->id,
            'transaction_id' => $transactionId
        ]);
        
        return redirect()->route('payment.success', $order)
            ->with('success', 'Payment processed successfully!');

    } catch (\Exception $e) {
        \Log::error('Payment processing error: ' . $e->getMessage());
        return back()->with('error', 'Payment processing failed. Please try again.');
    }
}
public function paymentSuccess(Order $order) 
{
    // Verificar que el pago haya sido exitoso
    if ($order->payment_status !== 'paid') {
        return redirect()->route('shop.index')->with('error', 'Order not found or payment not completed.');
    }

    // NO cargar relaciones por ahora - usar datos simples
    \Log::info('Payment success for order', [
        'order_id' => $order->id,
        'transaction_id' => $order->transaction_id
    ]);

    return view('payment.success', compact('order'));
}      
}
