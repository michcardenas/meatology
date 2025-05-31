<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /*──────────────────────────────── INDEX ────────────────────────────────*/
    public function index()
    {
        $products = Product::latest()->paginate(10);        // 10 por página
        return view('admin.products.index', compact('products'));
    }

    /*──────────────────────────────── CREATE ───────────────────────────────*/
    public function create()
    {
        return view('admin.products.create');
    }

    /*──────────────────────────────── STORE ────────────────────────────────*/
    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                     ->store('products', 'public'); // storage/app/public/products
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Producto creado ✅');
    }

    /*──────────────────────────────── EDIT ─────────────────────────────────*/
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /*──────────────────────────────── UPDATE ───────────────────────────────*/
    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            // borra la anterior
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Producto actualizado ✔️');
    }

    /*──────────────────────────────── DESTROY ──────────────────────────────*/
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Producto eliminado 🗑️');
    }

    /*───────────────────────────── HELPER DE VALIDACIÓN ────────────────────*/
    private function validated(Request $request): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
