<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentGateways\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function __construct(
        protected PaymentGatewayManager $paymentGatewayManager,
        protected OrderService $orderService
    ) {}

    /**
     * Universal gateway callback / webhook handler
     */
    public function handleCallback(Request $request, string $gateway)
    {
        Log::info("Payment callback received for gateway [{$gateway}]", [
            'query' => $request->query(),
            'body' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        try {
            $paymentGateway = $this->paymentGatewayManager->get($gateway);
            $result = $paymentGateway->verifyCallback($request);

            // Locate order number from various gateway parameter names
            $orderNumber = $request->input('pp_BillReference') 
                ?? $request->input('orderId') 
                ?? $request->input('order_id') 
                ?? $request->input('order_number')
                ?? session('last_placed_order');

            $order = null;
            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
            }

            if ($result->success && $result->status === 'paid' && $order) {
                $this->orderService->markOrderPaid(
                    $order, 
                    $result->transactionId ?? ('TXN-' . time()), 
                    $result->rawResponse
                );

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Order marked as paid successfully.',
                        'order_number' => $order->order_number
                    ]);
                }

                return redirect()->route('order.confirmed', ['order_number' => $order->order_number])
                    ->with('success', 'Payment verified and captured successfully!');
            }

            // Webhook asynchronous call
            if ($request->expectsJson() || $request->is('api/*') || $request->is('payments/webhook/*')) {
                return response()->json([
                    'status' => $result->success ? 'success' : 'failed',
                    'message' => $result->message
                ], $result->success ? 200 : 400);
            }

            if ($order) {
                return redirect()->route('order.confirmed', ['order_number' => $order->order_number])
                    ->with($result->success ? 'success' : 'warning', $result->message);
            }

            return redirect()->route('home')->with('info', $result->message);

        } catch (\Exception $e) {
            Log::error("Payment callback exception for [{$gateway}]: " . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }

            return redirect()->route('home')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    /**
     * JazzCash Hosted Form Auto-Dispatcher
     */
    public function redirectJazzCash(Request $request)
    {
        $payloadRaw = $request->input('payload');
        $payload = json_decode(base64_decode($payloadRaw), true) ?? [];
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);

        $isSandbox = (bool) env('JAZZCASH_SANDBOX', true);
        $endpoint = $isSandbox 
            ? 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/'
            : 'https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/';

        return view('pages.payment-redirect', [
            'gatewayName' => 'JazzCash Merchant Portal',
            'endpoint' => $endpoint,
            'fields' => $payload,
            'order' => $order,
        ]);
    }

    /**
     * EasyPaisa Hosted Form Auto-Dispatcher
     */
    public function redirectEasyPaisa(Request $request)
    {
        $payloadRaw = $request->input('payload');
        $payload = json_decode(base64_decode($payloadRaw), true) ?? [];
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);

        $isSandbox = (bool) env('EASYPAISA_SANDBOX', true);
        $endpoint = $isSandbox
            ? 'https://easypaystg.easypaisa.com.pk/easypay/Index.jsf'
            : 'https://easypay.easypaisa.com.pk/easypay/Index.jsf';

        return view('pages.payment-redirect', [
            'gatewayName' => 'EasyPaisa Secure Checkout',
            'endpoint' => $endpoint,
            'fields' => $payload,
            'order' => $order,
        ]);
    }
}
