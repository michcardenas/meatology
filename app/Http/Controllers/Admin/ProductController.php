<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /*──────────────────────── INDEX ───────────────────────*/
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /*──────────────────────── CREATE ──────────────────────*/
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /*──────────────────────── STORE ───────────────────────*/
public function store(Request $request)
{
    $data = $this->validated($request);

    try {
        DB::beginTransaction();
        
        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        DB::commit();
        return redirect()->route('admin.products.index')
                        ->with('success', 'Producto creado ✅');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al crear el producto');
    }
}

    /*──────────────────────── EDIT ────────────────────────*/
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /*──────────────────────── UPDATE ──────────────────────*/
    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);
        $product->update($data);

        // Agregar nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        return back()->with('success', 'Producto actualizado ✔️');
    }

    /*──────────────────────── DESTROY ─────────────────────*/
public function destroy(Product $product)
{
    try {
        DB::beginTransaction();
        
        // Eliminar imágenes del storage
        $product->images->each(function ($img) {
            Storage::disk('public')->delete($img->image);
        });
        
        // Laravel elimina automáticamente las imágenes de la BD por la relación
        $product->delete();
        
        DB::commit();
        return back()->with('success', 'Producto eliminado 🗑️');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al eliminar el producto');
    }
}

    /*──────────────────── VALIDACIÓN CENTRAL ──────────────*/
 private function validated(Request $request): array
{
    return $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price'       => ['required', 'numeric', 'min:0'],
        'stock'       => ['required', 'integer', 'min:0'],
        'category_id' => ['required', 'exists:categories,id'],
        'images.*'    => ['nullable', 'image', 'max:2048'],
    ]);
}

}
