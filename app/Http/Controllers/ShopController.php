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



use Square\SquareClient;
use Square\Payments\Requests\CreatePaymentRequest;
use Square\Types\Money;
use Square\Types\Currency;



class ShopController extends Controller
{

        public function index(Request $request)
        {
            $query = Product::query()->with('images', 'category');

            // Filtro por categoría
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Filtro por precio mínimo
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            // Filtro por precio máximo
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            $products = $query->latest()->paginate(9);
            $categories = Category::withCount('products')->get(); // ← actualizado

            return view('shop.index', compact('products', 'categories'));
        }


        public function checkout() 
        {
            // Verificar que el carrito no esté vacío
            if (Cart::count() == 0) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add some products before checkout.');
            }

            // Obtener información del carrito
            $cartItems = Cart::content();
            $cartSubtotal = Cart::subtotal(2, '', ''); // Sin formato
            
            // Verificar si el usuario está autenticado
            $user = Auth::user();
            
            // 🔴 Obtener países y ciudades para el envío
            $countries = Country::with('cities')->orderBy('name')->get();
            
            // Datos para la vista
            $checkoutData = [
                'cartItems' => $cartItems,
                'subtotal' => floatval(str_replace(',', '', $cartSubtotal)), // Convertir a número
                'countries' => $countries, // 🔴 Agregar países
                'isAuthenticated' => $user ? true : false,
                'user' => $user
            ];

            return view('shop.checkout', $checkoutData);
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
        // Debug: Log de todos los datos recibidos
        \Log::info('Payment processing started', [
            'order_id' => $order->id,
            'request_data' => $request->all()
        ]);

        // Validar datos del pago
        $request->validate([
            'source_id' => 'required|string'
        ]);

        \Log::info('Validation passed, source_id received', [
            'source_id' => $request->source_id
        ]);

        // Configurar Square Client (SDK v43.0.1)
        $client = new SquareClient(config('square.access_token'));

        // Crear el objeto Money
        $amountMoney = new Money([
            'amount' => $order->total_amount * 100, // Convertir a centavos
            'currency' => Currency::Usd->value
        ]);

        // Crear la petición de pago
        $createPaymentRequest = new CreatePaymentRequest([
            'idempotencyKey' => 'order_' . $order->id . '_' . time(),
            'sourceId' => $request->source_id,
            'amountMoney' => $amountMoney,
            'locationId' => config('square.location_id'),
            'note' => 'Order #' . $order->order_number
        ]);

        \Log::info('About to call Square API', [
            'amount' => $order->total_amount * 100,
            'location_id' => config('square.location_id')
        ]);

        // ✅ PROCESAR EL PAGO - SINTAXIS CORRECTA PARA SDK v43.0.1
        $response = $client->payments->create(
            request: $createPaymentRequest
        );

        \Log::info('Square API response received', [
            'is_error' => $response->isError()
        ]);

        if ($response->isError()) {
            $errors = $response->getErrors();
            \Log::error('Square payment failed', ['errors' => $errors]);
            return back()->with('error', 'Payment failed: ' . $errors[0]->getDetail());
        }

        // Pago exitoso - actualizar la orden
        $payment = $response->getResult()->getPayment();
        
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'payment_method' => 'square',
            'transaction_id' => $payment->getId(),
            'paid_at' => now()
        ]);

        \Log::info('Payment successful', [
            'order_id' => $order->id,
            'transaction_id' => $payment->getId()
        ]);
        
        return redirect()->route('payment.success', $order)->with('success', 'Payment processed successfully!');

    } catch (\Exception $e) {
        \Log::error('Square payment error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Payment processing failed. Please try again.');
    }
}
public function paymentSuccess(Order $order)
{
    // Verificar que el pago haya sido exitoso
    if ($order->payment_status !== 'paid') {
        return redirect()->route('shop.index')->with('error', 'Order not found or payment not completed.');
    }

    return view('payment.success', compact('order'));
}
        
}
