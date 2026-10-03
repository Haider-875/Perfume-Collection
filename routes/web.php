<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes - Perfumes Collection Haute Parfumerie (Pakistan)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Collections
Route::get('/collections', [CollectionController::class, 'show'])->name('collections.index');
Route::get('/collections/{slug}', [CollectionController::class, 'show'])->name('collections.show');

// Vault & Product Detail Page (PDP)
Route::get('/vault', [ProductController::class, 'index'])->name('shop.index');
Route::get('/perfume/{slug}', [ProductController::class, 'show'])->name('shop.show');
Route::post('/perfume/{id}/review', [ProductController::class, 'storeReview'])->name('reviews.store');

// Fragrance Chronicles (Blogs)
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// Brand Heritage & Concierge Pages
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/collaborations', [PageController::class, 'collaborations'])->name('pages.collaborations');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/search', [PageController::class, 'search'])->name('pages.search');
Route::get('/maison/olfactory-guide', [PageController::class, 'about'])->name('pages.guide');

// Policy Pages
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('policies.privacy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('policies.terms');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('policies.refund');
Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('policies.shipping');

// Inquiries & Newsletters
Route::post('/consultation/store', [PageController::class, 'storeInquiry'])->name('inquiry.store');
Route::post('/newsletter/subscribe', [PageController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/drawer', [CartController::class, 'getDrawer'])->name('cart.drawer');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout & Orders
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/coupon/apply', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
Route::get('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');
Route::post('/checkout/shipping/calculate', [CheckoutController::class, 'calculateShipping'])->name('checkout.shipping.calculate');
Route::get('/order/confirmed/{order_number}', [CheckoutController::class, 'confirmed'])->name('order.confirmed');

// Order Tracking
Route::get('/order-tracking', [OrderTrackingController::class, 'index'])->name('order.tracking');

// Payment Gateway Callbacks & Webhooks (CSRF Exempted in VerifyCsrfToken middleware)
Route::match(['get', 'post'], '/payments/callback/{gateway}', [PaymentCallbackController::class, 'handleCallback'])->name('payment.callback');
Route::get('/payments/redirect/jazzcash', [PaymentCallbackController::class, 'redirectJazzCash'])->name('payment.redirect.jazzcash');
Route::get('/payments/redirect/easypaisa', [PaymentCallbackController::class, 'redirectEasyPaisa'])->name('payment.redirect.easypaisa');

// Patron Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Patron Account Suite
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{order_number}', [AccountController::class, 'orderDetail'])->name('order.show');
    Route::post('/orders/{order_number}/receipt', [AccountController::class, 'uploadReceipt'])->name('order.receipt');
    
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    Route::post('/addresses/store', [AccountController::class, 'storeAddress'])->name('address.store');
    Route::post('/addresses/{id}/default', [AccountController::class, 'setDefaultAddress'])->name('address.default');
    Route::delete('/addresses/{id}', [AccountController::class, 'deleteAddress'])->name('address.delete');
    
    Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist/toggle', [AccountController::class, 'toggleWishlist'])->name('wishlist.toggle');
    
    Route::get('/reviews', [AccountController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/store', [AccountController::class, 'storeReview'])->name('review.store');
});
