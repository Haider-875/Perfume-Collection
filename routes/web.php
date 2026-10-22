<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
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
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminBundleController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminHeroSlideController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - Perfumes Collection Haute Parfumerie (Pakistan)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Collections & Bundles
Route::get('/collections/bundles', [CollectionController::class, 'show'])->defaults('slug', 'bundles')->name('bundles.index');
Route::get('/collections', [CollectionController::class, 'show'])->name('collections.index');
Route::get('/collections/{slug}', [CollectionController::class, 'show'])->name('collections.show');

// Vault & Product Detail Page (PDP)
Route::get('/vault', [ProductController::class, 'index'])->name('shop.index');
Route::get('/perfume/{slug}', [ProductController::class, 'show'])->name('shop.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('shop.products.show');
Route::get('/collections/{collection}/products/{slug}', [ProductController::class, 'show'])->name('shop.collection.product.show');
Route::post('/perfume/{id}/review', [ProductController::class, 'storeReview'])->name('reviews.store');

// Fragrance Chronicles (Blogs)
Route::redirect('/blogs', '/')->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// Brand Heritage & Concierge Pages
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::redirect('/contact', '/')->name('pages.contact');
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

    // Patron Security & Profile
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::put('/settings/password', [AccountController::class, 'updatePassword'])->name('password.update')->middleware('throttle:6,1');
    Route::put('/settings/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
});

// ==========================================
// Admin Authentication (Public /admin/login)
// ==========================================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ==========================================
// Admin Control Center (Restricted to role=admin)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Overview Dashboard & Live Analytics
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/cache/purge', [AdminDashboardController::class, 'purgeCache'])->name('cache.purge');

    // Products Management Suite
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{productId}/gallery-images/{imageId}', [AdminProductController::class, 'destroyGalleryImage'])->name('products.gallery-images.destroy');
    Route::post('/products/{productId}/remove-image', [AdminProductController::class, 'removeSpecialImage'])->name('products.remove-image');
    Route::get('/products/unused-images', [AdminProductController::class, 'unusedImagesIndex'])->name('products.unused-images');
    Route::post('/products/unused-images/purge', [AdminProductController::class, 'purgeUnusedImages'])->name('products.unused-images.purge');
    Route::post('/products/{id}/quick-stock', [AdminProductController::class, 'quickStock'])->name('products.quick-stock');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk');
    Route::get('/products/import', [AdminProductController::class, 'importView'])->name('products.import');
    Route::post('/products/import', [AdminProductController::class, 'importProcess'])->name('products.import.process');
    Route::post('/products/import/preview', [AdminProductController::class, 'importPreview'])->name('products.import.preview');
    Route::post('/products/import/confirm', [AdminProductController::class, 'importConfirm'])->name('products.import.confirm');
    Route::get('/products/sample-csv', [AdminProductController::class, 'sampleCsv'])->name('products.sample-csv');
    Route::get('/products/sample-excel', [AdminProductController::class, 'sampleExcel'])->name('products.sample-excel');
    Route::get('/products/import/error-report', [AdminProductController::class, 'downloadErrorReport'])->name('products.import.error-report');
    Route::get('/products/export-csv', [AdminProductController::class, 'exportCsv'])->name('products.export-csv');

    // Bundles Suite
    Route::get('/bundles', [AdminBundleController::class, 'index'])->name('bundles.index');
    Route::get('/bundles/create', [AdminBundleController::class, 'create'])->name('bundles.create');
    Route::post('/bundles', [AdminBundleController::class, 'store'])->name('bundles.store');
    Route::get('/bundles/{id}/edit', [AdminBundleController::class, 'edit'])->name('bundles.edit');
    Route::put('/bundles/{id}', [AdminBundleController::class, 'update'])->name('bundles.update');
    Route::delete('/bundles/{id}', [AdminBundleController::class, 'destroy'])->name('bundles.destroy');

    // Categories & Collections
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/{id}/products', [AdminCategoryController::class, 'updateProducts'])->name('categories.products.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders Management & Receipt Verification
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{id}/approve-receipt', [AdminOrderController::class, 'approveReceipt'])->name('orders.approve-receipt');
    Route::post('/orders/{id}/reject-receipt', [AdminOrderController::class, 'rejectReceipt'])->name('orders.reject-receipt');
    Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/{id}/packing-slip', [AdminOrderController::class, 'packingSlip'])->name('orders.packing-slip');
    Route::get('/orders-export-csv', [AdminOrderController::class, 'exportCsv'])->name('orders.export-csv');

    // Customers Intelligence
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('customers.show');

    // Blogs & Olfactory Journal
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [AdminBlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');

    // Hero Showcase Carousel Slides
    Route::get('/hero-slides', [AdminHeroSlideController::class, 'index'])->name('hero-slides.index');
    Route::post('/hero-slides', [AdminHeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::put('/hero-slides/{id}', [AdminHeroSlideController::class, 'update'])->name('hero-slides.update');
    Route::delete('/hero-slides/{id}', [AdminHeroSlideController::class, 'destroy'])->name('hero-slides.destroy');

    // Privilege Coupons & Vouchers
    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{id}', [AdminCouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

    // Settings & Payment Gateways
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Staff & Roles Permissions Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Activity Logs & Audit Trail
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');

    // Personal Administrator Profile & Security
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password')->middleware('throttle:6,1');
    Route::put('/profile/info', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Wasmer / Serverless Environment Utility Routes (No-Terminal Access)
|--------------------------------------------------------------------------
| Directly trigger migrations and production catalog seeder via browser URL.
*/
Route::get('/sync-hero-slides', function () {
    $slides = \App\Http\Controllers\HomeController::syncHeroBanners();
    return response()->json([
        'status' => 'success',
        'message' => 'Hero slides synchronized with 3 high-definition video banners',
        'slides' => $slides->map(fn($s) => ['id' => $s->id, 'title' => $s->title, 'image' => $s->image, 'sort_order' => $s->sort_order]),
    ]);
});

Route::get('/seed-bundles', function (\Illuminate\Http\Request $request) {
    try {
        $seeder = new \Database\Seeders\BundleSeeder();
        $seeder->run();
        $bundles = \App\Models\Bundle::with('items.product')->get();
        return response()->json([
            'status' => 'success',
            'environment' => 'Wasmer / Serverless',
            'count' => $bundles->count(),
            'bundles' => $bundles->map(fn($b) => [
                'name' => $b->name,
                'slug' => $b->slug,
                'price' => $b->bundle_price,
                'items_count' => $b->items->count(),
            ]),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'environment' => 'Wasmer / Serverless',
            'message' => $e->getMessage(),
        ], 500);
    }
});
// Route::get('');

Route::get('/seed-production-migrate', function (\Illuminate\Http\Request $request) {
    Artisan::call('migrate', ['--force' => true]);
    dd('d');

});
Route::get('/seed-production-catalog', function (\Illuminate\Http\Request $request) {
    $executedSteps = [];
    $startTime = microtime(true);

    // 1. Run migrations if requested or if tables missing
    if ($request->boolean('migrate') || !Schema::hasTable('products')) {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $executedSteps[] = 'Executed database migrations: ' . (trim(Artisan::output()) ?: 'OK');
        } catch (\Throwable $e) {
            $executedSteps[] = 'Migration Notice: ' . $e->getMessage();
        }
    }

    // 1b. Sync Hero Slides with video banners
    try {
        \App\Http\Controllers\HomeController::syncHeroBanners();
        $executedSteps[] = 'Hero slides synchronized with 3 high-definition video banners.';
    } catch (\Throwable $e) {
        $executedSteps[] = 'Hero slides sync notice: ' . $e->getMessage();
    }

    // 2. Execute ProductionCatalogSeeder safely
    try {
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\ProductionCatalogSeeder',
            '--force' => true,
        ]);
        $seederOutput = trim(Artisan::output());
        $executedSteps[] = $seederOutput ?: 'ProductionCatalogSeeder executed successfully.';
    } catch (\Throwable $e) {
        if ($request->wantsJson() || $request->query('format') === 'json') {
            return response()->json([
                'status' => 'error',
                'environment' => 'Wasmer / Serverless',
                'message' => $e->getMessage(),
                'steps' => $executedSteps,
            ], 500);
        }

        return response("<html><body style='font-family:sans-serif; background:#120508; color:#fff; padding:40px;'><h2 style='color:#ef4444;'>Error Executing Seeder</h2><pre style='background:#1f1315; padding:20px; border-radius:8px;'>{$e->getMessage()}</pre></body></html>", 500);
    }

    $elapsed = round(microtime(true) - $startTime, 2);
    $totalProducts = \App\Models\Product::count();
    $totalCategories = \App\Models\Category::count();
    $totalVariants = \App\Models\ProductVariant::count();
    $catalogProducts = \App\Models\Product::where('sku', 'like', 'RVH-%')
        ->orWhere('sku', 'like', 'PC-%')
        ->with('category')
        ->orderBy('id', 'asc')
        ->get();
    if ($catalogProducts->isEmpty()) {
        $catalogProducts = \App\Models\Product::with('category')->orderBy('id', 'desc')->get();
    }

    // JSON response for API / curl
    if ($request->wantsJson() || $request->query('format') === 'json') {
        return response()->json([
            'status' => 'success',
            'environment' => 'Wasmer / Serverless',
            'execution_time_seconds' => $elapsed,
            'steps' => $executedSteps,
            'total_products_in_db' => $totalProducts,
            'catalog_products_count' => $catalogProducts->count(),
            'products' => $catalogProducts->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'impression_of' => $p->impression_of,
                    'category' => $p->category?->name,
                    'sku' => $p->sku,
                    'price' => $p->price,
                    'sale_price' => $p->sale_price,
                    'thumbnail_image' => $p->thumbnail_image,
                    'hover_image' => $p->hover_image,
                    'url' => url('/perfume/' . $p->slug),
                ];
            }),
        ]);
    }

    // Luxury Dark-Theme HTML response for direct browser visit
    $rowsHtml = '';
    foreach ($catalogProducts as $idx => $p) {
        $num = $idx + 1;
        $price = number_format($p->price, 0);
        $sale = $p->sale_price ? number_format($p->sale_price, 0) : null;
        $cat = htmlspecialchars($p->category?->name ?? 'Haute Parfumerie');
        $name = htmlspecialchars($p->name);
        $impression = htmlspecialchars($p->impression_of ?? 'Luxury Extrait');
        $img = asset($p->thumbnail_image);
        $pUrl = url('/perfume/' . $p->slug);

        $priceDisplay = $sale
            ? "<span style='color:#F59E0B; font-weight:bold;'>Rs. {$sale}</span> <del style='color:#78716C; font-size:12px; margin-left:6px;'>Rs. {$price}</del>"
            : "<span style='color:#F59E0B; font-weight:bold;'>Rs. {$price}</span>";

        $rowsHtml .= "
        <tr style='border-bottom: 1px solid rgba(212,175,55,0.15); transition: background 0.2s;'>
            <td style='padding:12px 14px; text-align:center; color:#A8A29E; font-size:13px;'>{$num}</td>
            <td style='padding:12px 14px; text-align:center;'>
                <a href='{$pUrl}' target='_blank'>
                    <img src='{$img}' alt='{$name}' style='width:46px; height:46px; object-fit:contain; border-radius:6px; background:#1C1418; border:1px solid rgba(212,175,55,0.3); padding:2px;'>
                </a>
            </td>
            <td style='padding:12px 14px;'>
                <a href='{$pUrl}' target='_blank' style='color:#FFF; text-decoration:none; font-weight:600; font-size:15px; display:block;'>{$name}</a>
                <span style='color:#C5A059; font-size:12px;'>{$impression}</span>
            </td>
            <td style='padding:12px 14px;'>
                <span style='background:rgba(212,175,55,0.12); color:#FDE047; padding:4px 10px; border-radius:20px; font-size:12px; border:1px solid rgba(212,175,55,0.25); white-space:nowrap;'>{$cat}</span>
            </td>
            <td style='padding:12px 14px; color:#9CA3AF; font-size:13px; font-family:monospace;'>{$p->sku}</td>
            <td style='padding:12px 14px; font-size:14px; white-space:nowrap;'>{$priceDisplay}</td>
            <td style='padding:12px 14px; text-align:center;'>
                <a href='{$pUrl}' target='_blank' style='display:inline-block; padding:5px 12px; background:#541B29; color:#FFEAA7; text-decoration:none; border-radius:4px; font-size:12px; border:1px solid #D4AF37;'>View PDP &rarr;</a>
            </td>
        </tr>";
    }

    $vaultUrl = url('/vault');
    $adminUrl = url('/admin/products');
    $homeUrl = url('/');
    $now = date('d M Y, h:i A');

    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Catalog Seeded • Perfumes Collection</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            background: #0B0406;
            color: #EDE8E1;
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            padding: 30px 20px 60px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .header-card {
            background: linear-gradient(135deg, #1C0A10 0%, #2A0E18 50%, #15060B 100%);
            border: 1px solid rgba(212,175,55,0.4);
            border-radius: 12px;
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        .badge-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #064E3B;
            color: #34D399;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #059669;
            margin-bottom: 10px;
        }
        .badge-env {
            display: inline-block;
            background: rgba(212,175,55,0.15);
            color: #FDE047;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            border: 1px solid rgba(212,175,55,0.3);
            margin-left: 8px;
        }
        h1 {
            font-family: 'Cinzel', serif;
            font-size: 26px;
            color: #FFF;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #14070A;
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 8px;
            padding: 18px 20px;
        }
        .stat-val {
            font-family: 'Cinzel', serif;
            font-size: 28px;
            font-weight: bold;
            color: #FFEAA7;
            margin-bottom: 4px;
        }
        .stat-lbl {
            font-size: 12px;
            color: #A8A29E;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-gold {
            background: linear-gradient(135deg, #D4AF37, #AA7C11);
            color: #1A0D00;
            border: none;
        }
        .btn-gold:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-outline {
            background: transparent;
            color: #EDE8E1;
            border: 1px solid rgba(212,175,55,0.4);
        }
        .btn-outline:hover { background: rgba(212,175,55,0.1); }
        .table-wrap {
            background: #13070A;
            border: 1px solid rgba(212,175,55,0.3);
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th {
            background: #1D0A11;
            padding: 14px;
            font-family: 'Cinzel', serif;
            font-size: 12px;
            letter-spacing: 1px;
            color: #D4AF37;
            border-bottom: 1px solid rgba(212,175,55,0.3);
        }
        tr:hover { background: rgba(255,255,255,0.03); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-card">
            <div>
                <div class="badge-success">
                    <span>&#10003;</span> Successfully Executed
                    <span class="badge-env">Wasmer / No-Terminal</span>
                </div>
                <h1>Production Catalog Seeded</h1>
                <p style="color:#A8A29E; font-size:13px; margin-top:4px;">
                    All 26 luxury perfume impressions, categories, flacon images & variants are live. Executed at {$now} ({$elapsed}s).
                </p>
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                <a href="{$vaultUrl}" class="btn btn-gold">&#128717; Open Storefront / Vault</a>
                <a href="{$adminUrl}" class="btn btn-outline">&#9881; Admin Products</a>
                <a href="{$homeUrl}" class="btn btn-outline">&#8962; Homepage</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-val">{$catalogProducts->count()}</div>
                <div class="stat-lbl">Seeded Catalog Items</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">{$totalProducts}</div>
                <div class="stat-lbl">Total Products in Database</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">{$totalVariants}</div>
                <div class="stat-lbl">Flacon Variants (50ml & 100ml)</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">{$totalCategories}</div>
                <div class="stat-lbl">Active Fragrance Categories</div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center; width:45px;">#</th>
                        <th style="text-align:center; width:65px;">Flacon</th>
                        <th>Product & Impression</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Price (PKR)</th>
                        <th style="text-align:center; width:110px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {$rowsHtml}
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
HTML;

    return response($html);
})->name('system.seed-catalog');

Route::get('/run-production-seeder', function () {
    return redirect()->route('system.seed-catalog');
});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
    \Illuminate\Support\Facades\Cache::flush();
    return response()->json([
        'status' => 'success',
        'message' => 'Blade views, application, and config caches cleared successfully for Wasmer/production.'
    ]);
});

Route::get('/sync-categories', function () {
    \App\Http\Controllers\Admin\AdminCategoryController::ensureCoreCategoriesExist();
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
    \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
    \Illuminate\Support\Facades\Cache::flush();
    return response()->json([
        'status' => 'success',
        'message' => 'Core categories (Men, Women, Unisex, Exclusive) synchronized and cache flushed successfully on Wasmer.'
    ]);
});


