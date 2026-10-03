<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PakistanGeoService;
use App\Services\PaymentGateways\BankTransferGateway;
use App\Services\PaymentGateways\PaymentGatewayManager;
use App\Services\PaymentGateways\WalletTransferGateway;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected PaymentGatewayManager $paymentGatewayManager
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request);

        if ($cart->items->isEmpty()) {
            return redirect()->route('collections.index')->with('warning', 'Your fragrance bag is empty. Please select your bespoke creations before proceeding to checkout.');
        }

        $user = auth()->user();
        $savedAddresses = $user ? $user->addresses : collect();
        $defaultAddress = $savedAddresses->where('is_default', true)->first() ?? $savedAddresses->first();

        $provinces = PakistanGeoService::getProvinces();
        $gateways = $this->paymentGatewayManager->getAvailableGateways();

        // Bank details and wallet details for checkout accordions
        $bankGateway = new BankTransferGateway();
        $bankDetails = $bankGateway->getBankDetails();

        $walletGateway = new WalletTransferGateway();
        $walletDetails = $walletGateway->getWalletDetails();

        $shippingCost = $this->cartService->calculateShipping($cart);
        $grandTotal = max(0, $cart->subtotal - $cart->discount_amount + $shippingCost);

        return view('pages.checkout', compact(
            'cart',
            'user',
            'savedAddresses',
            'defaultAddress',
            'provinces',
            'gateways',
            'bankDetails',
            'walletDetails',
            'shippingCost',
            'grandTotal'
        ));
    }

    public function process(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCart($request);

        if ($cart->items->isEmpty()) {
            return redirect()->route('collections.index')->with('error', 'Your fragrance bag is empty.');
        }

        try {
            $data = $request->validated();
            
            // If customer checked 'save_address' and is logged in, save to user addresses
            if ($request->boolean('save_address') && auth()->check()) {
                Address::create([
                    'user_id' => auth()->id(),
                    'recipient_name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                    'street_address' => $data['shipping_address'] . ($data['area'] ? ', ' . $data['area'] : ''),
                    'city' => $data['city'],
                    'province' => $data['province'],
                    'postal_code' => $data['postal_code'] ?? null,
                    'is_default' => !auth()->user()->addresses()->exists(),
                ]);
            }

            // Handle file upload if present
            if ($request->hasFile('receipt_file')) {
                $data['receipt_file'] = $request->file('receipt_file');
            }

            $result = $this->orderService->createOrder($cart, $data, auth()->id());
            $order = $result['order'];
            $paymentResult = $result['payment_result'];

            // Store order in session for guest confirmation access
            session(['last_placed_order' => $order->order_number]);

            if ($paymentResult->redirectUrl) {
                return redirect()->away($paymentResult->redirectUrl);
            }

            return redirect()->route('order.confirmed', ['order_number' => $order->order_number])
                ->with('success', $paymentResult->message);

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Checkout error: ' . $e->getMessage());
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $cart = $this->cartService->getCart($request);

        $result = $this->cartService->applyCoupon($cart, $request->input('coupon_code'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('error', $result['message']);
    }

    public function removeCoupon(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $this->cartService->removeCoupon($cart);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Coupon removed successfully.']);
        }

        return back()->with('success', 'Coupon privilege removed.');
    }

    public function calculateShipping(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $city = $request->input('city');
        $shipping = $this->cartService->calculateShipping($cart, $city);

        $subtotal = $cart->subtotal;
        $discount = $cart->discount_amount;
        $total = max(0, $subtotal - $discount + $shipping);

        return response()->json([
            'shipping' => $shipping,
            'formatted_shipping' => $shipping == 0 ? 'FREE' : 'Rs. ' . number_format($shipping, 0),
            'subtotal' => 'Rs. ' . number_format($subtotal, 0),
            'discount' => 'Rs. ' . number_format($discount, 0),
            'total' => 'Rs. ' . number_format($total, 0),
        ]);
    }

    public function confirmed(string $order_number)
    {
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();

        // Bank and wallet details if manual transfer
        $bankGateway = new BankTransferGateway();
        $bankDetails = $bankGateway->getBankDetails();

        $walletGateway = new WalletTransferGateway();
        $walletDetails = $walletGateway->getWalletDetails();

        // Build WhatsApp share link
        $storePhone = Setting::get('whatsapp', '923001234567');
        $whatsappMsg = urlencode("Salam Perfumes Collection! I just placed order #{$order->order_number} for Rs. " . number_format($order->total_amount, 0) . ". Looking forward to delivery.");
        $whatsappUrl = "https://wa.me/{$storePhone}?text={$whatsappMsg}";

        return view('pages.order-confirmed', compact('order', 'bankDetails', 'walletDetails', 'whatsappUrl'));
    }
}
