<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CouponController as AdminCoupon;
use App\Http\Controllers\Admin\ReturnRequestController as AdminReturn;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\ReviewController as AdminReview;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/api/search-suggestions', [ProductController::class, 'searchSuggestions'])->name('api.search-suggestions');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::resource('categories', AdminCategory::class)->names([
        'index' => 'categories.index',
        'store' => 'categories.store',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);
    
    Route::resource('products', AdminProduct::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'store' => 'products.store',
        'edit' => 'products.edit',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]);
    
    Route::resource('orders', AdminOrder::class)->only(['index', 'show', 'destroy']);
    Route::get('/orders-export', [AdminOrder::class, 'exportCSV'])->name('orders.export');
    Route::post('/orders/update-status/{order}', [AdminOrder::class, 'updateStatus'])->name('orders.update-status');
    
    Route::resource('users', AdminUser::class)->only(['index', 'show', 'destroy']);
    Route::post('/users/toggle-block/{user}', [AdminUser::class, 'toggleBlock'])->name('users.toggle-block');
    
    Route::resource('coupons', AdminCoupon::class)->names([
        'index' => 'coupons.index',
        'store' => 'coupons.store',
        'update' => 'coupons.update',
        'destroy' => 'coupons.destroy',
    ]);
    
    Route::resource('returns', AdminReturn::class)->only(['index', 'show', 'destroy']);
    Route::post('/returns/update-status/{return}', [AdminReturn::class, 'updateStatus'])->name('returns.update-status');
    
    Route::resource('reviews', AdminReview::class)->only(['index', 'destroy']);
    Route::get('/reviews/pending', [AdminReview::class, 'pending'])->name('reviews.pending');
    Route::post('/reviews/{review}/approve', [AdminReview::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReview::class, 'reject'])->name('reviews.reject');
    
    Route::get('/reports', [AdminReport::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReport::class, 'exportOrders'])->name('reports.export');

    Route::post('/products/featured-toggle/{product}', [AdminProduct::class, 'toggleFeatured'])->name('products.toggle-featured');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/api/addresses', [CheckoutController::class, 'saveAddress']);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/return', [OrderController::class, 'showReturnForm'])->name('orders.return.form');
    Route::post('/orders/{order}/return', [OrderController::class, 'requestReturn'])->name('orders.return');
    Route::post('/returns/{return}/cancel', [OrderController::class, 'cancelReturn'])->name('returns.cancel');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
