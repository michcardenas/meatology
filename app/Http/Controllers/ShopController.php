<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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

}
