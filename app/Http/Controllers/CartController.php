<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;                   // Facade de anayarojo/shoppingcart

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        Cart::add([
            'id'      => $product->id,
            'name'    => $product->name,
            'qty'     => $request->qty ?? 1,
            'price'   => $product->price,
            'options' => [
                'image' => $product->image,
            ],
        ])->associate(Product::class);  // Para poder usar $row->model en la vista

        return back()->with('success', 'Producto añadido 🚀');
    }

    public function update(Request $request, $rowId)
    {
        // qty = 0 elimina el ítem
        Cart::update($rowId, $request->qty);
        return back()->with('success', 'Carrito actualizado');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success', 'Producto eliminado');
    }
}