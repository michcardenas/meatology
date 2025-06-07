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


    public function about()
        {
            return view('about');
        }

        public function partnerChefs()
{
    return view('partner-chefs');
}

public function submitPartnerChefs(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255', 
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'company_name' => 'required|string|max:255',
        'company_website' => 'nullable|url|max:255',
        'company_address' => 'required|string|max:500',
        'years_in_business' => 'required|integer|min:0',
    ]);
    
    // Aquí puedes guardar en base de datos o enviar email
    // Por ejemplo, enviar notificación por email
    
    return redirect()->back()->with('success', 'Thank you for your interest! We will contact you within 24 business hours.');
}
}