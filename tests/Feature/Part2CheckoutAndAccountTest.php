<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\PaymentGateways\JazzCashHostedGateway;
use App\Services\PaymentGateways\PaymentGatewayManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Part2CheckoutAndAccountTest extends TestCase
{
    public function test_cart_page_renders_successfully()
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_order_tracking_page_renders_successfully()
    {
        $response = $this->get('/order-tracking');
        $response->assertStatus(200);
    }

    public function test_checkout_redirects_if_cart_empty()
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/collections');
    }

    public function test_auth_login_and_register_pages_render()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    public function test_full_cart_checkout_and_order_placement_flow()
    {
        $user = User::first() ?? User::factory()->create();
        $product = Product::first();
        $this->assertNotNull($product, 'Product must exist in database');

        // 1. Add product to cart as authenticated patron
        $cartResponse = $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);
        $cartResponse->assertStatus(200);

        // 2. Test Checkout Page Renders with item in bag
        $checkoutResponse = $this->actingAs($user)->get('/checkout');
        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertSee($product->name);

        // 3. Test Coupon Application
        $couponResponse = $this->actingAs($user)->postJson('/checkout/coupon/apply', [
            'coupon_code' => 'ROYAL10'
        ]);
        $couponResponse->assertStatus(200);
        $couponResponse->assertJson(['success' => true]);

        // 4. Place Order via COD
        $initialStock = $product->stock;
        $orderData = [
            'customer_name' => 'Syed Daniyal Ahmed',
            'customer_email' => 'daniyal.test@perfumescollection.pk',
            'customer_phone' => '03001234567',
            'shipping_address' => 'House 14, Street 2, Sector F-7/2',
            'area' => 'F-7 Markaz',
            'landmark' => 'Near Jinnah Super Market',
            'province' => 'Islamabad Capital Territory',
            'city' => 'Islamabad',
            'postal_code' => '44000',
            'payment_method' => 'cod',
            'order_notes' => 'Ring bell twice, luxury fragile delivery.',
        ];

        $checkoutProcessResponse = $this->actingAs($user)->post('/checkout/process', $orderData);
        $checkoutProcessResponse->assertRedirect();

        // 5. Verify Order in Database
        $order = Order::where('customer_email', 'daniyal.test@perfumescollection.pk')->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('cod', $order->payment_method);
        $this->assertEquals('confirmed', $order->order_status);
        $this->assertEquals('unpaid', $order->payment_status);
        $this->assertEquals('Islamabad', $order->city);
        $this->assertCount(1, $order->items);

        // 6. Verify Stock Decrement
        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->stock);

        // 7. Verify Order Confirmation Page Renders
        $confirmationResponse = $this->get('/order/confirmed/' . $order->order_number);
        $confirmationResponse->assertStatus(200);
        $confirmationResponse->assertSee($order->order_number);
        $confirmationResponse->assertSee('Syed Daniyal Ahmed');

        // 8. Verify Order Tracking Page Look up
        $trackingResponse = $this->get('/order-tracking?order_number=' . $order->order_number . '&phone=03001234567');
        $trackingResponse->assertStatus(200);
        $trackingResponse->assertSee($order->order_number);
        $trackingResponse->assertSee('Consignment Progress');
    }

    public function test_bank_transfer_order_and_receipt_upload_flow()
    {
        $user = User::first() ?? User::factory()->create();
        $product = Product::first();

        $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $file = UploadedFile::fake()->create('bank_receipt.png', 200, 'image/png');

        $orderData = [
            'customer_name' => 'Mirza Asim Beg',
            'customer_email' => 'asim.beg@perfumescollection.pk',
            'customer_phone' => '03219876543',
            'shipping_address' => 'Plaza 14, MM Alam Road, Gulberg III',
            'province' => 'Punjab',
            'city' => 'Lahore',
            'payment_method' => 'bank_transfer',
            'transaction_id' => 'FT-ALFALAH-998822',
            'receipt_file' => $file,
        ];

        $response = $this->actingAs($user)->post('/checkout/process', $orderData);
        $response->assertRedirect();

        $order = Order::where('customer_email', 'asim.beg@perfumescollection.pk')->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('bank_transfer', $order->payment_method);
        $this->assertEquals('pending_verification', $order->order_status);
        $this->assertEquals('pending_verification', $order->payment_status);
        $this->assertEquals('FT-ALFALAH-998822', $order->bank_transaction_id);
        $this->assertNotNull($order->payment_receipt);

        // Test Patron Order Detail view
        $orderDetailResponse = $this->actingAs($user)->get('/account/orders/' . $order->order_number);
        $orderDetailResponse->assertStatus(200);
        $orderDetailResponse->assertSee('FT-ALFALAH-998822');
    }

    public function test_wallet_transfer_checkout_flow()
    {
        $user = User::first() ?? User::factory()->create();
        $product = Product::first();

        $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $orderData = [
            'customer_name' => 'Hamza Tariq',
            'customer_email' => 'hamza.tariq@perfumescollection.pk',
            'customer_phone' => '03451122334',
            'shipping_address' => 'Clifton Block 4, Sea View Avenue',
            'province' => 'Sindh',
            'city' => 'Karachi',
            'payment_method' => 'wallet_transfer',
            'wallet_type' => 'easypaisa',
            'transaction_id' => 'EP-TRX-776655',
        ];

        $response = $this->actingAs($user)->post('/checkout/process', $orderData);
        $response->assertRedirect();

        $order = Order::where('customer_email', 'hamza.tariq@perfumescollection.pk')->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('wallet_transfer', $order->payment_method);
        $this->assertEquals('pending_verification', $order->order_status);
        $this->assertEquals('pending_verification', $order->payment_status);
    }

    public function test_jazzcash_gateway_signature_verification_and_callback()
    {
        $orderNumber = 'PC-' . rand(100000, 999999);
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => 'Usman Ghani',
            'customer_email' => 'usman@domain.pk',
            'customer_phone' => '03001234567',
            'shipping_address' => 'DHA Phase 6',
            'city' => 'Lahore',
            'province' => 'Punjab',
            'subtotal' => 15000,
            'total_amount' => 15000,
            'payment_method' => 'jazzcash',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $jazzcash = new JazzCashHostedGateway();
        $params = [
            'pp_ResponseCode' => '000',
            'pp_ResponseMessage' => 'Transaction Completed Successfully',
            'pp_BillReference' => $order->order_number,
            'pp_TxnRefNo' => 'T2026100312345',
            'pp_Amount' => '1500000',
            'pp_RetreivalReferenceNo' => 'RRN998877',
        ];
        $params['pp_SecureHash'] = $jazzcash->calculateHash($params);

        $callbackResponse = $this->post('/payments/callback/jazzcash', $params);
        $callbackResponse->assertRedirect('/order/confirmed/' . $order->order_number);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('confirmed', $order->order_status);
        $this->assertEquals('T2026100312345', $order->bank_transaction_id);
    }

    public function test_customer_registration_and_account_suite_flow()
    {
        // 1. Register Patron
        $email = 'patron_' . time() . '@perfumescollection.pk';
        $registerResponse = $this->post('/register', [
            'name' => 'Mirza Asim Beg',
            'email' => $email,
            'phone' => '03219876543',
            'city' => 'Lahore',
            'password' => 'RoyalVault2026!',
            'password_confirmation' => 'RoyalVault2026!',
        ]);
        $registerResponse->assertRedirect('/account');

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);

        // 2. Patron Dashboard
        $dashboardResponse = $this->actingAs($user)->get('/account');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Mirza Asim Beg');

        // 3. Add Delivery Address
        $addressResponse = $this->actingAs($user)->post('/account/addresses/store', [
            'recipient_name' => 'Mirza Asim Beg',
            'phone' => '03219876543',
            'street_address' => 'Bungalow 88, Main Boulevard Gulberg III',
            'city' => 'Lahore',
            'province' => 'Punjab',
            'postal_code' => '54660',
            'is_default' => 1,
        ]);
        $addressResponse->assertRedirect();
        $this->assertEquals(1, $user->addresses()->count());

        // 4. Toggle Wishlist
        $product = Product::first();
        $wishlistResponse = $this->actingAs($user)->postJson('/account/wishlist/toggle', [
            'product_id' => $product->id
        ]);
        $wishlistResponse->assertStatus(200);
        $wishlistResponse->assertJson(['in_wishlist' => true]);

        // 5. Wishlist Page
        $wishlistPageResponse = $this->actingAs($user)->get('/account/wishlist');
        $wishlistPageResponse->assertStatus(200);
        $wishlistPageResponse->assertSee($product->name);
    }
}
