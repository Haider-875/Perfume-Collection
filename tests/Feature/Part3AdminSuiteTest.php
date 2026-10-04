<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PageVisit;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class Part3AdminSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $customerUser;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic settings
        Setting::set('store_name', 'Perfumes Collection', 'general');
        Setting::set('shipping_cost', '250', 'shipping');
        Setting::set('free_shipping_threshold', '10000', 'shipping');

        $this->adminUser = User::create([
            'name' => 'Maison Admin',
            'email' => 'admin@perfumescollection.pk',
            'password' => bcrypt('admin123456'),
            'role' => 'admin',
        ]);

        $this->customerUser = User::create([
            'name' => 'Tariq Patron',
            'email' => 'patron@example.pk',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $this->category = Category::create([
            'name' => 'Exclusive Edition',
            'slug' => 'exclusive-edition',
            'is_active' => true,
        ]);
    }

    public function test_guest_and_customer_cannot_access_admin_panel()
    {
        // Unauthenticated guest
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));

        // Normal customer
        $response = $this->actingAs($this->customerUser)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_and_see_kpis()
    {
        // Record a visit
        PageVisit::create([
            'ip_address' => '127.0.0.1',
            'page_url' => 'http://127.0.0.1:8000/',
            'path' => '/',
            'device_type' => 'desktop',
            'visited_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Maison Overview & Intelligence');
        $response->assertSee('Live Boutique Traffic Telemetry');
    }

    public function test_admin_can_manage_products_and_variants()
    {
        $response = $this->actingAs($this->adminUser)->post('/admin/products', [
            'name' => 'Royal Amber Extrait',
            'sku' => 'PC-ROYAL-AMB',
            'price' => 14500,
            'compare_at_price' => 17000,
            'stock' => 30,
            'category_id' => $this->category->id,
            'description' => 'A masterwork of ambergris and royal saffron.',
            'is_active' => '1',
            'variant_size' => ['50ml', '100ml'],
            'variant_sku' => ['PC-ROYAL-AMB-50', 'PC-ROYAL-AMB-100'],
            'variant_price' => [14500, 22000],
            'variant_stock' => [15, 15],
            'top_notes' => 'Saffron, Bergamot',
            'heart_notes' => 'Taif Rose',
            'base_notes' => 'Cambodian Amber',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['sku' => 'PC-ROYAL-AMB', 'price' => 14500]);
        $this->assertDatabaseHas('product_variants', ['sku' => 'PC-ROYAL-AMB-50']);

        // Check activity log
        $this->assertDatabaseHas('activity_logs', ['action' => 'product_created']);
    }

    public function test_admin_can_download_sample_csv_and_export_products()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.products.sample-csv'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)->get(route('admin.products.export-csv'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_orders_and_approve_payment_receipts()
    {
        $order = Order::create([
            'order_number' => 'ORD-TEST-999',
            'user_id' => $this->customerUser->id,
            'customer_name' => 'Ali Khan',
            'customer_email' => 'ali@example.pk',
            'customer_phone' => '03001234567',
            'shipping_address' => 'House 12, Street 4, DHA Phase 5',
            'city' => 'Lahore',
            'province' => 'Punjab',
            'subtotal' => 12500,
            'shipping_cost' => 0,
            'total_amount' => 12500,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending_verification',
            'payment_receipt' => 'uploads/receipts/test_receipt.jpg',
            'order_status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'Oud Royale',
            'size' => '50ml',
            'price' => 12500,
            'quantity' => 1,
            'total' => 12500,
        ]);

        // Order detail view
        $response = $this->actingAs($this->adminUser)->get(route('admin.orders.show', $order->id));
        $response->assertStatus(200);
        $response->assertSee('ORD-TEST-999');
        $response->assertSee('Uploaded Payment Receipt');

        // Approve Receipt
        $response = $this->actingAs($this->adminUser)->post(route('admin.orders.approve-receipt', $order->id));
        $response->assertRedirect(route('admin.orders.show', $order->id));

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('confirmed', $order->order_status);

        // Update Courier & Tracking
        $response = $this->actingAs($this->adminUser)->put(route('admin.orders.update-status', $order->id), [
            'order_status' => 'shipped',
            'payment_status' => 'paid',
            'courier_name' => 'TCS',
            'tracking_number' => '78291039123',
        ]);
        $response->assertRedirect(route('admin.orders.show', $order->id));

        $order->refresh();
        $this->assertEquals('shipped', $order->order_status);
        $this->assertEquals('78291039123', $order->tracking_number);
        $this->assertStringContainsString('tcsexpress.com', $order->tracking_link);

        // Printable Invoice & Packing Slip
        $invoiceRes = $this->actingAs($this->adminUser)->get(route('admin.orders.invoice', $order->id));
        $invoiceRes->assertStatus(200);
        $invoiceRes->assertSee('INVOICE');

        $packingSlipRes = $this->actingAs($this->adminUser)->get(route('admin.orders.packing-slip', $order->id));
        $packingSlipRes->assertStatus(200);
        $packingSlipRes->assertSee('PACKING SLIP');
    }

    public function test_admin_can_update_store_and_gateway_settings()
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.settings.update'), [
            'store_name' => 'Perfumes Collection Haute Parfumerie',
            'payment_cod_enabled' => '1',
            'payment_bank_enabled' => '1',
            'payment_easypaisa_enabled' => '1',
            'bank_name' => 'Meezan Bank Luxury Private',
            'easypaisa_number' => '03009876543',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('Perfumes Collection Haute Parfumerie', Setting::get('store_name'));
        $this->assertEquals('Meezan Bank Luxury Private', Setting::get('bank_name'));
    }

    public function test_sitemap_and_visitor_prune_console_commands()
    {
        $sitemapCode = Artisan::call('sitemap:generate');
        $this->assertEquals(0, $sitemapCode);
        $this->assertFileExists(public_path('sitemap.xml'));

        $pruneCode = Artisan::call('visitors:prune', ['--days' => 60]);
        $this->assertEquals(0, $pruneCode);
    }
}
