<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;


class DashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();
    
    if ($user->hasRole('admin')) {
        return view('dashboard.admin');
    }
    
    // Si es comprador, buscamos sus órdenes con items y productos
    $orders = Order::where('user_id', $user->id)
                   ->with(['items.product', 'country', 'city']) // Cargar relaciones
                   ->orderBy('created_at', 'desc')
                   ->get();
    
    return view('dashboard.comprador', compact('user', 'orders'));
}
}
