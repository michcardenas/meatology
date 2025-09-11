<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController; // <-- NUEVO
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SeoController;



/* ---------- Landing y páginas públicas ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::view('/about',   'about')->name('about');
Route::view('/insiders','insiders')->name('insiders');//


Route::view('/recipes', 'recipes')->name('recipes');
//los de dentro de recipes
Route::get('/wholesale', [WholesaleController::class, 'index'])->name('wholesale.form');
Route::post('/wholesale', [WholesaleController::class, 'submit'])->name('wholesale.submit');

Route::view('/chefs',   'chefs')->name('chefs');
Route::view('/wholesale','wholesale')->name('wholesale');

/* ---------- Catálogo y carrito ---------- */
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::delete('/admin/products/images/{id}', [App\Http\Controllers\Admin\ProductImageController::class, 'destroy'])->name('admin.products.images.destroy');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/calculate', [ShopController::class, 'calculateShippingAndTax'])->name('checkout.calculate');
Route::post('/order/process', [ShopController::class, 'processOrder'])->name('order.process');
Route::patch('/admin/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])
     ->name('admin.orders.update-status');
     
// Ruta para la pasarela de pago
Route::get('/payment/gateway/{order}', [App\Http\Controllers\ShopController::class, 'paymentGateway'])->name('payment.gateway');
Route::post('/payment/process/{order}', [App\Http\Controllers\ShopController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success/{order}', [App\Http\Controllers\ShopController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');
Route::get('/subscribe/confirm/{token}', [SubscriptionController::class, 'confirm'])->name('subscribe.confirm');
Route::get('/unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe'])->name('subscribe.unsubscribe');
  Route::put('/admin/seo/pages/{pagina}', [\App\Http\Controllers\SeoController::class, 'update'])
        ->name('admin.seo.update');

Route::post('/cart',           [CartController::class, 'add'])->name('cart.add');
Route::get('/cart',            [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/{rowId}',  [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/partner-chefs', [HomeController::class, 'partnerChefs'])->name('partner.chefs');
Route::post('/partner-chefs', [HomeController::class, 'submitPartnerChefs'])->name('partner.chefs.submit');
Route::get('/shipping-policy', function () {
    return view('policies.shipping');
})->name('shipping.policy');

Route::get('/return-policy', function () {
    return view('policies.return');
})->name('return.policy');

Route::get('/refund-policy', function () {
    return view('policies.refund');
})->name('refund.policy');

Route::get('/terms-conditions', function () {
    return view('policies.terms');
})->name('terms.conditions');
/* ---------- Dashboard y perfil ---------- */
Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('admin')->group(function () {
    Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categorias/crear', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
});
// Agregar estas rutas a tu archivo de rutas
Route::get('/admin/cities/{city}/edit', [LocationController::class, 'citiesEdit'])->name('admin.cities.edit');
Route::put('/admin/cities/{city}', [LocationController::class, 'citiesUpdate'])->name('admin.cities.update');
Route::post('/checkout/calculate', [ShopController::class, 'calculateCosts'])->name('checkout.calculate');
Route::get('/admin/testimonials', [SubscriptionController::class, 'testimonials'])->name('admin.testimonials');
Route::post('/admin/testimonials', [SubscriptionController::class, 'testimonialsStore'])->name('admin.testimonials.store');
Route::get('/admin/testimonials/{id}/edit', [SubscriptionController::class, 'testimonialsEdit'])->name('admin.testimonials.edit');
Route::put('/admin/testimonials/{id}', [SubscriptionController::class, 'testimonialsUpdate'])->name('admin.testimonials.update');
Route::delete('/admin/testimonials/{id}', [SubscriptionController::class, 'testimonialsDestroy'])->name('admin.testimonials.destroy');Route::resource('categories', CategoryController::class);
   
    Route::get('/admin/subscriptions', [SubscriptionController::class, 'showSubscribers'])->name('admin.subscriptions');
    Route::get('/admin/users', [SubscriptionController::class, 'showAllUsers'])->name('admin.users');
    Route::post('/admin/subscription/toggle/{user}', [SubscriptionController::class, 'toggleSubscription'])->name('admin.subscription.toggle');
    Route::delete('/admin/user/{user}', [SubscriptionController::class, 'deleteUser'])->name('admin.user.delete');
       Route::get('/admin/seo/pages', [SeoController::class, 'index'])->name('admin.seo.pages');
    Route::get('/admin/seo/pages/{pagina}', [SeoController::class, 'edit'])->name('admin.seo.edit');

Route::prefix('admin')->group(function () {
    // Countries
    Route::get('/countries', [LocationController::class, 'countriesIndex'])->name('admin.countries.index');
    Route::post('/countries', [LocationController::class, 'countriesStore'])->name('admin.countries.store');
    Route::delete('/countries/{id}', [LocationController::class, 'countriesDestroy'])->name('admin.countries.destroy');

    // Cities
    Route::get('/cities', [LocationController::class, 'citiesIndex'])->name('admin.cities.index');
    Route::post('/cities', [LocationController::class, 'citiesStore'])->name('admin.cities.store');
    Route::delete('/cities/{id}', [LocationController::class, 'citiesDestroy'])->name('admin.cities.destroy');

//descuentos
 Route::get('/admin/discounts', [App\Http\Controllers\AdminDiscountController::class, 'index'])
        ->name('admin.orders.discounts');
    Route::get('/admin/discounts/create', [App\Http\Controllers\AdminDiscountController::class, 'create'])
        ->name('admin.discounts.create');
    Route::post('/admin/discounts', [App\Http\Controllers\AdminDiscountController::class, 'store'])
        ->name('admin.discounts.store');
    Route::get('/admin/discounts/{discount}/edit', [App\Http\Controllers\AdminDiscountController::class, 'edit'])
        ->name('admin.discounts.edit');
    Route::put('/admin/discounts/{discount}', [App\Http\Controllers\AdminDiscountController::class, 'update'])
        ->name('admin.discounts.update');
    Route::delete('/admin/discounts/{discount}', [App\Http\Controllers\AdminDiscountController::class, 'destroy'])
        ->name('admin.discounts.destroy');
        // Ruta para validar descuentos en checkout
    Route::post('/checkout/validate-discount', [App\Http\Controllers\AdminDiscountController::class, 'validateDiscount'])
        ->name('checkout.validate-discount');
    
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
