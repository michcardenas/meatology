<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    /**
     * Mostrar lista de descuentos
     */
    public function index()
    {
        $discounts = Discount::with(['producto', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        
        return view('admin.discounts.create', compact('products', 'categories'));
    }

    /**
     * Guardar nuevo descuento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'codigo' => 'required|string|max:50|unique:descuentos,codigo',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'numero_descuentos' => 'nullable|integer|min:1',
            'tipo_descuento' => 'required|in:global,producto,categoria',
            'id_producto' => 'nullable|exists:products,id',
            'id_categoria' => 'nullable|exists:categories,id',
        ]);

        // Limpiar campos según tipo
        if ($validated['tipo_descuento'] === 'global') {
            $validated['id_producto'] = null;
            $validated['id_categoria'] = null;
        } elseif ($validated['tipo_descuento'] === 'producto') {
            $validated['id_categoria'] = null;
        } elseif ($validated['tipo_descuento'] === 'categoria') {
            $validated['id_producto'] = null;
        }

        // Remover campo temporal
        unset($validated['tipo_descuento']);

        Discount::create($validated);

        return redirect()->route('admin.orders.discounts')
            ->with('success', '✅ Descuento creado exitosamente');
    }



    /**
 * Mostrar formulario de edición
 */
public function edit(Discount $discount)
{
    $products = Product::orderBy('name')->get();
    $categories = Category::orderBy('name')->get();
    
    return view('admin.discounts.edit', compact('discount', 'products', 'categories'));
}

/**
 * Actualizar descuento
 */
public function update(Request $request, Discount $discount)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:500',
        'codigo' => 'required|string|max:50|unique:descuentos,codigo,' . $discount->id,
        'porcentaje' => 'required|numeric|min:0|max:100',
        'numero_descuentos' => 'nullable|integer|min:1',
        'tipo_descuento' => 'required|in:global,producto,categoria',
        'id_producto' => 'nullable|exists:products,id',
        'id_categoria' => 'nullable|exists:categories,id',
    ]);

    // Limpiar campos según tipo
    if ($validated['tipo_descuento'] === 'global') {
        $validated['id_producto'] = null;
        $validated['id_categoria'] = null;
    } elseif ($validated['tipo_descuento'] === 'producto') {
        $validated['id_categoria'] = null;
    } elseif ($validated['tipo_descuento'] === 'categoria') {
        $validated['id_producto'] = null;
    }

    // Remover campo temporal
    unset($validated['tipo_descuento']);

    $discount->update($validated);

    return redirect()->route('admin.orders.discounts')
        ->with('success', '✅ Descuento actualizado exitosamente');
}

/**
 * Eliminar descuento
 */
public function destroy(Discount $discount)
{
    $discount->delete();

    return redirect()->route('admin.orders.discounts')
        ->with('success', '🗑️ Descuento eliminado exitosamente');
}

/**
 * Validar código de descuento
 */
public function validateDiscount(Request $request)
{
    $request->validate([
        'codigo' => 'required|string',
        'subtotal' => 'required|numeric',
        'cart_items' => 'required|array'
    ]);

    $codigo = strtoupper($request->codigo);
    $subtotal = $request->subtotal;
    $cartItems = $request->cart_items;

    // Buscar el descuento
    $descuento = Discount::codigo($codigo)->first();

    if (!$descuento) {
        return response()->json([
            'success' => false,
            'message' => '❌ Código de descuento no válido'
        ]);
    }

    // Verificar si tiene usos disponibles (aquí puedes agregar lógica de conteo de usos)
    // Por ahora, asumimos que está disponible

    // Calcular descuento aplicable
    $descuentoTotal = 0;
    $productosConDescuento = [];

    if ($descuento->esGlobal()) {
        // Descuento global - aplica a todo el subtotal
        $descuentoTotal = $descuento->calcularMonto($subtotal);
        $productosConDescuento = ['Todos los productos'];
        
    } elseif ($descuento->esPorCategoria()) {
        // Descuento por categoría - solo productos de esa categoría
        foreach ($cartItems as $item) {
            if (isset($item['options']['category_id']) && 
                $item['options']['category_id'] == $descuento->id_categoria) {
                $itemTotal = $item['price'] * $item['qty'];
                $descuentoTotal += $descuento->calcularMonto($itemTotal);
                $productosConDescuento[] = $item['name'];
            }
        }
        
    } elseif ($descuento->esPorProducto()) {
        // Descuento por producto específico
        foreach ($cartItems as $item) {
            if ($item['id'] == $descuento->id_producto) {
                $itemTotal = $item['price'] * $item['qty'];
                $descuentoTotal += $descuento->calcularMonto($itemTotal);
                $productosConDescuento[] = $item['name'];
            }
        }
    }

    if ($descuentoTotal == 0) {
        return response()->json([
            'success' => false,
            'message' => '❌ Este descuento no aplica a los productos en tu carrito'
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => '✅ Descuento aplicado correctamente',
        'descuento' => [
            'codigo' => $descuento->codigo,
            'nombre' => $descuento->nombre,
            'porcentaje' => $descuento->porcentaje,
            'monto' => $descuentoTotal,
            'productos' => $productosConDescuento,
            'tipo' => $descuento->esGlobal() ? 'Global' : 
                     ($descuento->esPorCategoria() ? 'Categoría' : 'Producto')
        ]
    ]);
}
}