<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class HomeController extends Controller
{
    public function index()
    {
        // Obtener productos destacados (puedes ajustar la lógica según tus necesidades)
        $featuredProducts = Product::with(['category', 'images'])
            ->where('stock', '>', 0) // Solo productos en stock
            ->limit(8) // Limitar a 8 productos
            ->get();
            
        // Obtener categorías para navegación
        $categories = Category::with('products')->get();
        
        return view('welcome', compact('featuredProducts', 'categories'));
    }
}