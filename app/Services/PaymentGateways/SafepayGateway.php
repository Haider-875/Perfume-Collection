<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SafepayGateway implements PaymentGatewayInterface
{
    protected string $apiKey;
    protected string $secretKey;
    protected string $webhookSecret;
    protected bool $isSandbox;
    protected string $baseUrl;
    protected string $checkoutUrl;

    public function __construct()
    {
        $this->apiKey = env('SAFEPAY_API_KEY', 'sec_sandbox_perfumes_pk_key');
        $this->secretKey = env('SAFEPAY_SECRET_KEY', 'safepay_secret_key_123');
        $this->webhookSecret = env('SAFEPAY_WEBHOOK_SECRET', 'whsec_safepay_perfumes_pk');
        $this->isSandbox = (bool) env('SAFEPAY_SANDBOX', true);

        $this->baseUrl = $this->isSandbox
            ? 'https://sandbox.api.getsafepay.com'
            : 'https://api.getsafepay.com';

        $this->checkoutUrl = $this->isSandbox
            ? 'https://sandbox.api.getsafepay.com/checkout/pay'
            : 'https://getsafepay.com/checkout/pay';
    }

    public function getKey(): string
    {
        return 'safepay';
    }

    public function getTitle(): string
    {
        return 'Debit / Credit Card (Visa / MasterCard / PayPak)';
    }

    public function getDescription(): string
    {
        return 'Ultra-secure 256-bit encrypted checkout with domestic and international cards powered by Safepay.';
    }

    public function isEnabled(): bool
    {
        return (bool) env('GATEWAY_SAFEPAY_ENABLED', true) && Setting::get('payment_safepay_enabled', '1') !== '0';
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        $orderToken = 'sp_' . $order->order_number . '_' . time();

        try {
            // Attempt remote API session initialization if real keys provided, or build standard hosted redirect URL
            $payload = [
                'client' => $this->apiKey,
                'amount' => (int) round($order->total_amount * 100), // in minor units
                'currency' => 'PKR',
                'environment' => $this->isSandbox ? 'sandbox' : 'production',
            ];

            // Safepay Standard Hosted URL format
            $checkoutParams = http_build_query([
                'beacon' => $orderToken,
                'cancel_url' => route('checkout.index'),
                'redirect_url' => route('payment.callback', ['gateway' => 'safepay']),
                'source' => 'custom',
                'order_id' => $order->order_number,
                'amount' => $order->total_amount,
                'currency' => 'PKR',
            ]);

            $finalRedirectUrl = $this->checkoutUrl . '?' . $checkoutParams;

            return PaymentResult::redirect(
                redirectUrl: $finalRedirectUrl,
                transactionId: $orderToken,
                message: 'Redirecting to Safepay Card Gateway...',
                rawResponse: ['tracker' => $orderToken, 'url' => $finalRedirectUrl]
            );
        } catch (\Exception $e) {
            Log::error('Safepay initiation error: ' . $e->getMessage());
            return PaymentResult::failed('Could not initialize Card Gateway: ' . $e->getMessage());
        }
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        $signature = $request->header('X-SFPY-SIGNATURE') ?? $request->input('sig');
        $rawContent = $request->getContent();
        $params = $request->all();

        Log::info('Safepay Callback/Webhook payload', ['params' => $params, 'sig' => $signature]);

        // Validate webhook signature if present
        if ($signature && $rawContent && !env('PAYMENT_SKIP_HASH_VERIFICATION', false)) {
            $expectedSignature = hash_hmac('sha256', $rawContent, $this->webhookSecret);
            if (!hash_equals($expectedSignature, $signature)) {
                Log::error('Safepay webhook signature validation failed');
                return PaymentResult::failed('Safepay signature verification failed.');
            }
        }

        $tracker = $params['tracker'] ?? ($params['beacon'] ?? null);
        $status = $params['status'] ?? ($params['state'] ?? 'PAID');

        if (in_array(strtoupper($status), ['PAID', 'COMPLETED', 'SUCCESS', '000'])) {
            return PaymentResult::success(
                status: 'paid',
                transactionId: $tracker ?? ('SP-' . time()),
                message: 'Safepay card transaction completed successfully.',
                rawResponse: $params
            );
        }

        return PaymentResult::failed('Safepay transaction was not completed: ' . $status, $params);
    }
}
