<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

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
        $countries = Country::with('cities')->get();
        $categories = Category::all();
        return view('admin.products.create', compact('categories','countries'));
    }

    /*──────────────────────── STORE ───────────────────────*/
public function store(Request $request)
{
    // 🔥 CONFIGURACIÓN AGRESIVA PARA EVITAR TIMEOUT
    ignore_user_abort(true);
    set_time_limit(0);
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    ini_set('max_input_time', 600);
    
    // 🔥 VALIDACIÓN REDUCIDA
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'pais' => 'required|string|max:100',
        'descuento' => 'nullable|numeric|min:0|max:100',
        
        'images' => 'nullable|array|max:5',
        'images.*' => 'image|max:2048',
        'certifications' => 'nullable|array|max:5',
        'certifications.*' => 'image|max:2048',
    ]);

    try {
        // Crear producto primero
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'price' => $request->price,
            'stock' => $request->stock,
            'avg_weight' => $request->avg_weight ?? '',
            'category_id' => $request->category_id,
            'pais' => $request->pais,
            'descuento' => $request->descuento ?? 0,
        ]);

        // 🔥 PROCESAR IMÁGENES - USANDO STORAGE CORRECTO
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                try {
                    // 🔥 USAR STORAGE DE LARAVEL (esto funciona con el enlace simbólico)
                    $path = $file->store('products', 'public');
                    
                    // Guardar en BD
                    $product->images()->create(['image' => $path]);
                    
                    // Liberación de memoria
                    unset($file);
                    gc_collect_cycles();
                    
                    // Pausa entre archivos
                    sleep(1);
                    
                } catch (\Exception $e) {
                    \Log::error("Error imagen {$index}: " . $e->getMessage());
                    continue;
                }
            }
        }

        // 🔥 PROCESAR CERTIFICACIONES - USANDO STORAGE CORRECTO
        if ($request->hasFile('certifications')) {
            foreach ($request->file('certifications') as $index => $file) {
                try {
                    // 🔥 USAR STORAGE DE LARAVEL (esto funciona con el enlace simbólico)
                    $path = $file->store('certifications', 'public');
                    
                    // Guardar en BD
                    $product->certifications()->create(['image' => $path]);
                    
                    // Liberación de memoria
                    unset($file);
                    gc_collect_cycles();
                    
                    // Pausa entre archivos
                    sleep(1);
                    
                } catch (\Exception $e) {
                    \Log::error("Error certificación {$index}: " . $e->getMessage());
                    continue;
                }
            }
        }

        // Procesar precios
        if (!empty($request->prices)) {
            foreach ($request->prices as $priceData) {
                if (!empty($priceData['country_id'])) {
                    $product->prices()->create([
                        'country_id' => $priceData['country_id'],
                        'city_id' => $priceData['city_id'] ?? null,
                        'interest' => $priceData['interest'] ?? 0,
                        'shipping' => $priceData['shipping'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
                        ->with('success', 'Producto creado exitosamente ✅');

    } catch (\Exception $e) {
        \Log::error('Error creating product: ' . $e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Error: Intenta con menos archivos o archivos más pequeños.');
    }
}
    /*──────────────────────── EDIT ────────────────────────*/
public function edit($id)
{
    $product = Product::with(['images', 'prices'])->findOrFail($id);
    $categories = Category::all();
    $countries = Country::with('cities')->get(); // 🔴 Necesitamos las ciudades también

    return view('admin.products.edit', compact('product', 'categories', 'countries'));
}

/*──────────────────────── UPDATE ──────────────────────*/
public function update(Request $request, Product $product)
{
    // 🔥 CONFIGURACIÓN AGRESIVA PARA EVITAR TIMEOUT
    ignore_user_abort(true);
    set_time_limit(0);
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    ini_set('max_input_time', 600);

    // Validación reducida
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'avg_weight' => 'nullable|string|max:50',
        'category_id' => 'required|exists:categories,id',
        'pais' => 'string|max:255',
        'descuento' => 'nullable|numeric|min:0|max:100',
        
        'images' => 'nullable|array|max:5',
        'images.*' => 'nullable|image|max:2048',
        'certifications' => 'nullable|array|max:5',
        'certifications.*' => 'nullable|image|max:2048',
        
        'prices' => 'nullable|array',
        'prices.*.country_id' => 'required_with:prices.*|exists:countries,id',
        'prices.*.city_id' => 'nullable|exists:cities,id',
        'prices.*.interest' => 'nullable|numeric|min:0|max:100',
        'prices.*.shipping' => 'nullable|numeric|min:0',
    ]);

    try {
        // Actualizar producto base
        $productData = collect($validatedData)->except(['images', 'prices', 'certifications'])->toArray();
        $product->update($productData);

        // Manejar precios
        if ($request->has('prices') && is_array($request->prices)) {
            $product->prices()->delete();

            foreach ($request->prices as $priceData) {
                if (!empty($priceData['country_id'])) {
                    $product->prices()->create([
                        'country_id' => $priceData['country_id'],
                        'city_id' => !empty($priceData['city_id']) ? $priceData['city_id'] : null,
                        'interest' => $priceData['interest'] ?? 0,
                        'shipping' => $priceData['shipping'] ?? 0,
                    ]);
                }
            }
        }

        // 🔥 PROCESAR NUEVAS IMÁGENES - USANDO STORAGE CORRECTO
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                try {
                    // 🔥 USAR STORAGE DE LARAVEL
                    $path = $file->store('products', 'public');
                    
                    // Guardar en BD
                    $product->images()->create(['image' => $path]);
                    
                    // Liberación de memoria
                    unset($file);
                    gc_collect_cycles();
                    
                    // Pausa entre archivos
                    sleep(1);
                    
                } catch (\Exception $e) {
                    \Log::error("Error updating image {$index}: " . $e->getMessage());
                    continue;
                }
            }
        }

        // 🔥 PROCESAR NUEVAS CERTIFICACIONES - USANDO STORAGE CORRECTO
        if ($request->hasFile('certifications')) {
            foreach ($request->file('certifications') as $index => $file) {
                try {
                    // 🔥 USAR STORAGE DE LARAVEL
                    $path = $file->store('certifications', 'public');
                    
                    // Guardar en BD
                    $product->certifications()->create(['image' => $path]);
                    
                    // Liberación de memoria
                    unset($file);
                    gc_collect_cycles();
                    
                    // Pausa entre archivos
                    sleep(1);
                    
                } catch (\Exception $e) {
                    \Log::error("Error updating certification {$index}: " . $e->getMessage());
                    continue;
                }
            }
        }

        return back()->with('success', 'Producto actualizado exitosamente ✔️');

    } catch (\Exception $e) {
        \Log::error('Error updating product: ' . $e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Error: Intenta con menos archivos o archivos más pequeños.');
    }
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
 public function show(Product $product)
    {
        // Cargar relaciones necesarias
        $product->load(['images', 'category']);
        
        // Productos relacionados de la misma categoría (8 productos)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->with('images')
            ->take(8)
            ->get();
        
        // Productos populares/destacados (8 productos adicionales)
        $featuredProducts = Product::where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->with('images')
            ->inRandomOrder() // o puedes usar ->orderBy('created_at', 'desc') para los más recientes
            ->take(8)
            ->get();

        return view('products.show', compact('product', 'relatedProducts', 'featuredProducts'));
    }
}
