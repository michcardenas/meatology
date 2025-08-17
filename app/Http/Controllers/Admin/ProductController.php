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
    // 🔥 SOLO ESTAS 3 LÍNEAS PARA EVITAR TIMEOUT
    set_time_limit(300);
    ini_set('memory_limit', '256M');
    ini_set('max_execution_time', 300);

    $data = $this->validated($request);

    try {
        DB::beginTransaction();

        // Crear el producto (sin los precios por ubicación, imágenes y certificaciones)
        $productData = collect($data)->except(['images', 'prices', 'certifications'])->toArray();
        $product = Product::create($productData);

        // 🔥 CAMBIO MÍNIMO: Procesar imágenes una por una + liberar memoria
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
                
                // 🔥 ESTO ES LO IMPORTANTE: liberar memoria
                unset($file);
                
                // 🔥 PAUSA MINI para evitar sobrecarga
                if ($index > 0 && $index % 3 == 0) {
                    usleep(100000); // 0.1 segundos cada 3 imágenes
                }
            }
        }

        // 🔥 NUEVO: Procesar certificaciones (mismo patrón que las imágenes)
        if ($request->hasFile('certifications')) {
            foreach ($request->file('certifications') as $index => $file) {
                $path = $file->store('certifications', 'public');
                $product->certifications()->create(['image' => $path]);
                
                // 🔥 Liberar memoria
                unset($file);
                
                // 🔥 PAUSA MINI para evitar sobrecarga
                if ($index > 0 && $index % 3 == 0) {
                    usleep(100000); // 0.1 segundos cada 3 certificaciones
                }
            }
        }

        // Manejar precios por ubicación (sin cambios)
        if (!empty($data['prices'])) {
            foreach ($data['prices'] as $priceData) {
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

        DB::commit();
        return redirect()->route('admin.products.index')
                        ->with('success', 'Producto creado ✅');
                        
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al crear el producto: ' . $e->getMessage());
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
    // 🔥 Optimización para evitar timeout
    set_time_limit(300);
    ini_set('memory_limit', '256M');
    ini_set('max_execution_time', 300);

    // Validación manual con todos los campos incluyendo certificaciones
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'avg_weight' => 'nullable|string|max:50',
        'category_id' => 'required|exists:categories,id',
        'pais' => 'string|max:255',
        
        // Validación para imágenes del producto
        'images' => 'nullable|array|max:10',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        
        // 🔥 NUEVA VALIDACIÓN PARA CERTIFICACIONES
        'certifications' => 'nullable|array|max:10',
        'certifications.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        
        // Validaciones para precios por ubicación
        'prices' => 'nullable|array',
        'prices.*.country_id' => 'required_with:prices.*|exists:countries,id',
        'prices.*.city_id' => 'nullable|exists:cities,id',
        'prices.*.interest' => 'nullable|numeric|min:0|max:100',
        'prices.*.shipping' => 'nullable|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        // Actualizar el producto base (excluyendo images, prices y certificaciones)
        $productData = collect($validatedData)->except(['images', 'prices', 'certifications'])->toArray();
        $product->update($productData);

        // Manejar configuraciones de precios por ubicación
        if ($request->has('prices') && is_array($request->prices)) {
            // Eliminar configuraciones anteriores
            $product->prices()->delete();

            // Crear nuevas configuraciones
            foreach ($request->prices as $priceData) {
                // Solo crear si tiene al menos un país seleccionado
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

        // Agregar nuevas imágenes del producto
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image' => $path]);
                
                // 🔥 Liberar memoria
                unset($file);
                
                // 🔥 PAUSA MINI para evitar sobrecarga
                if ($index > 0 && $index % 3 == 0) {
                    usleep(100000); // 0.1 segundos cada 3 imágenes
                }
            }
        }

        // 🔥 NUEVO: Agregar nuevas certificaciones
        if ($request->hasFile('certifications')) {
            foreach ($request->file('certifications') as $index => $file) {
                $path = $file->store('certifications', 'public');
                $product->certifications()->create(['image' => $path]);
                
                // 🔥 Liberar memoria
                unset($file);
                
                // 🔥 PAUSA MINI para evitar sobrecarga
                if ($index > 0 && $index % 3 == 0) {
                    usleep(100000); // 0.1 segundos cada 3 certificaciones
                }
            }
        }

        DB::commit();
        return back()->with('success', 'Producto actualizado ✔️');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
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
