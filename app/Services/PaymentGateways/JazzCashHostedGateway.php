<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JazzCashHostedGateway implements PaymentGatewayInterface
{
    protected string $merchantId;
    protected string $password;
    protected string $integritySalt;
    protected string $endpoint;
    protected string $returnUrl;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->merchantId = env('JAZZCASH_MERCHANT_ID', 'MC12345');
        $this->password = env('JAZZCASH_PASSWORD', 'pass123');
        $this->integritySalt = env('JAZZCASH_INTEGRITY_SALT', 'salt123456789');
        $this->isSandbox = (bool) env('JAZZCASH_SANDBOX', true);
        
        $this->endpoint = $this->isSandbox 
            ? 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/'
            : 'https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/';

        $this->returnUrl = route('payment.callback', ['gateway' => 'jazzcash']);
    }

    public function getKey(): string
    {
        return 'jazzcash';
    }

    public function getTitle(): string
    {
        return 'JazzCash Online Gateway (Instant Mobile / Debit Card)';
    }

    public function getDescription(): string
    {
        return 'Seamless automated payment via your JazzCash Mobile Account (MPIN) or any Visa/MasterCard debit/credit card.';
    }

    public function isEnabled(): bool
    {
        return (bool) env('GATEWAY_JAZZCASH_ENABLED', true) && Setting::get('payment_jazzcash_online_enabled', '1') !== '0';
    }

    public function calculateHash(array $params): string
    {
        ksort($params);
        $sortedString = $this->integritySalt;
        foreach ($params as $key => $val) {
            if ($val !== '' && $val !== null && $key !== 'pp_SecureHash') {
                $sortedString .= '&' . $val;
            }
        }
        return hash_hmac('sha256', $sortedString, $this->integritySalt);
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        $amountInPaisa = (int) round($order->total_amount * 100);
        $txnRefNo = 'T' . date('YmdHis') . rand(100, 999);
        $txnDateTime = date('Ymd His');
        $txnExpiryDateTime = date('Ymd His', strtotime('+3 hours'));

        $postData = [
            'pp_Version' => '1.1',
            'pp_TxnType' => 'MWALLET', // or empty for multi-option hosted checkout
            'pp_Language' => 'EN',
            'pp_MerchantID' => $this->merchantId,
            'pp_Password' => $this->password,
            'pp_TxnRefNo' => $txnRefNo,
            'pp_Amount' => (string) $amountInPaisa,
            'pp_TxnCurrency' => 'PKR',
            'pp_TxnDateTime' => $txnDateTime,
            'pp_BillReference' => (string) $order->order_number,
            'pp_Description' => 'Order ' . $order->order_number . ' at Perfumes Collection',
            'pp_TxnExpiryDateTime' => $txnExpiryDateTime,
            'pp_ReturnURL' => $this->returnUrl,
            'pp_mpf_1' => (string) $order->id,
            'pp_mpf_2' => $order->customer_phone,
        ];

        $postData['pp_SecureHash'] = $this->calculateHash($postData);

        // Render redirect URL or form dispatcher
        $redirectUrl = route('payment.redirect.jazzcash', [
            'order_id' => $order->id,
            'payload' => base64_encode(json_encode($postData))
        ]);

        return PaymentResult::redirect(
            redirectUrl: $redirectUrl,
            transactionId: $txnRefNo,
            message: 'Redirecting to JazzCash Secure Checkout...',
            rawResponse: $postData
        );
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        $params = $request->all();
        Log::info('JazzCash Gateway Callback received', $params);

        $receivedHash = $params['pp_SecureHash'] ?? null;
        $responseCode = $params['pp_ResponseCode'] ?? null;
        $orderNumber = $params['pp_BillReference'] ?? null;
        $amount = isset($params['pp_Amount']) ? ((float)$params['pp_Amount']) / 100 : 0;
        $txnRef = $params['pp_TxnRefNo'] ?? ($params['pp_RetreivalReferenceNo'] ?? null);
        $responseMessage = $params['pp_ResponseMessage'] ?? 'Transaction failed';

        if (!$receivedHash) {
            return PaymentResult::failed('Missing JazzCash security signature hash.');
        }

        // Validate hash
        $calculatedHash = $this->calculateHash($params);
        if (strcasecmp($receivedHash, $calculatedHash) !== 0 && !env('PAYMENT_SKIP_HASH_VERIFICATION', false)) {
            Log::error('JazzCash SecureHash Mismatch', [
                'received' => $receivedHash,
                'calculated' => $calculatedHash,
                'params' => $params
            ]);
            return PaymentResult::failed('Invalid JazzCash security signature hash.');
        }

        if ($responseCode === '000' || $responseCode === '121' || $responseCode === '200') {
            return PaymentResult::success(
                status: 'paid',
                transactionId: $txnRef,
                message: 'JazzCash payment confirmed successfully: ' . $responseMessage,
                rawResponse: $params
            );
        }

        return PaymentResult::failed($responseMessage, $params);
    }
}
