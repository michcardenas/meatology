<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController; // <-- NUEVO

/* ---------- Landing y páginas públicas ---------- */
Route::view('/',        'welcome')->name('home');
Route::view('/about',   'about')->name('about');
Route::view('/insiders','insiders')->name('insiders');
Route::view('/chefs',   'chefs')->name('chefs');
Route::view('/wholesale','wholesale')->name('wholesale');

/* ---------- Catálogo y carrito ---------- */
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::post('/cart',           [CartController::class, 'add'])->name('cart.add');
Route::get('/cart',            [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/{rowId}',  [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('cart.remove');

/* ---------- Dashboard y perfil ---------- */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ---------- CRUD de productos (solo usuarios logueados) ---------- */
Route::middleware(['auth'])
      ->prefix('admin')
      ->name('admin.')
      ->group(function () {
          Route::resource('products', ProductController::class)->except(['show']);
});

require __DIR__.'/auth.php';
