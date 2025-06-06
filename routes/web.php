<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController; // <-- NUEVO
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;


/* ---------- Landing y páginas públicas ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::view('/about',   'about')->name('about');
Route::view('/insiders','insiders')->name('insiders');
Route::view('/chefs',   'chefs')->name('chefs');
Route::view('/wholesale','wholesale')->name('wholesale');

/* ---------- Catálogo y carrito ---------- */
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::delete('/admin/products/images/{id}', [App\Http\Controllers\Admin\ProductImageController::class, 'destroy'])->name('admin.products.images.destroy');

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
    Route::prefix('admin')->group(function () {
    Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categorias/crear', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
});
});

/* ---------- CRUD de productos (solo usuarios logueados) ---------- */
Route::middleware(['auth'])
      ->prefix('admin')
      ->name('admin.')
      ->group(function () {
          Route::resource('products', ProductController::class)->except(['show']);
});
// Rutas del carrito
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'add'])->name('add');
    Route::patch('/{rowId}', [CartController::class, 'update'])->name('update');
    Route::delete('/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    
    // Rutas AJAX
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::get('/info', [CartController::class, 'info'])->name('info');
    Route::post('/check-stock', [CartController::class, 'checkStock'])->name('check-stock');
    
    // Rutas de descuentos
    Route::post('/discount', [CartController::class, 'applyDiscount'])->name('apply-discount');
    Route::delete('/discount', [CartController::class, 'removeDiscount'])->name('remove-discount');
});
require __DIR__.'/auth.php';
