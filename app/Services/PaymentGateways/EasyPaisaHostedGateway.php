<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EasyPaisaHostedGateway implements PaymentGatewayInterface
{
    protected string $storeId;
    protected string $hashKey;
    protected string $endpoint;
    protected string $postBackUrl;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->storeId = env('EASYPAISA_STORE_ID', '12345');
        $this->hashKey = env('EASYPAISA_HASH_KEY', 'EP_HASH_KEY_SECRET');
        $this->isSandbox = (bool) env('EASYPAISA_SANDBOX', true);

        $this->endpoint = $this->isSandbox
            ? 'https://easypaystg.easypaisa.com.pk/easypay/Index.jsf'
            : 'https://easypay.easypaisa.com.pk/easypay/Index.jsf';

        $this->postBackUrl = route('payment.callback', ['gateway' => 'easypaisa']);
    }

    public function getKey(): string
    {
        return 'easypaisa';
    }

    public function getTitle(): string
    {
        return 'EasyPaisa Online Gateway (Mobile Account / Card)';
    }

    public function getDescription(): string
    {
        return 'Direct instant checkout with EasyPaisa Mobile Account or any debit/credit card.';
    }

    public function isEnabled(): bool
    {
        return (bool) env('GATEWAY_EASYPAISA_ENABLED', true) && Setting::get('payment_easypaisa_online_enabled', '1') !== '0';
    }

    public function calculateHash(array $params): string
    {
        // EasyPaisa Hash formula: AES / HMAC or sorted key sequence depending on merchant API tier
        ksort($params);
        $sortedString = '';
        foreach ($params as $k => $v) {
            if ($k !== 'hash' && $v !== null && $v !== '') {
                $sortedString .= $k . '=' . $v . '&';
            }
        }
        $sortedString .= 'key=' . $this->hashKey;
        return hash('sha256', $sortedString);
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        $orderRefNum = 'EP-' . $order->order_number . '-' . time();
        $amount = number_format($order->total_amount, 2, '.', '');
        $expiryDate = date('Ymd His', strtotime('+3 hours'));

        $postData = [
            'storeId' => $this->storeId,
            'orderId' => (string) $order->order_number,
            'transactionAmount' => $amount,
            'transactionType' => 'MA', // MA = Mobile Account, CC = Credit Card, OTC = Over the counter
            'mobileNum' => $order->customer_phone,
            'emailAddr' => $order->customer_email,
            'postBackURL' => $this->postBackUrl,
            'autoRedirect' => '1',
            'orderRefNum' => $orderRefNum,
            'expiryDate' => $expiryDate,
        ];

        $postData['hash'] = $this->calculateHash($postData);

        $redirectUrl = route('payment.redirect.easypaisa', [
            'order_id' => $order->id,
            'payload' => base64_encode(json_encode($postData))
        ]);

        return PaymentResult::redirect(
            redirectUrl: $redirectUrl,
            transactionId: $orderRefNum,
            message: 'Redirecting to EasyPaisa Hosted Checkout...',
            rawResponse: $postData
        );
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        $params = $request->all();
        Log::info('EasyPaisa Gateway Callback received', $params);

        $responseCode = $params['resCode'] ?? ($params['responseCode'] ?? ($params['status'] ?? null));
        $txnId = $params['transactionId'] ?? ($params['orderRefNum'] ?? ($params['txnid'] ?? null));
        $receivedHash = $params['hash'] ?? null;
        $desc = $params['desc'] ?? ($params['message'] ?? 'Transaction processed');

        // Check success codes (0000 = success in EasyPaisa API)
        if ($responseCode === '0000' || $responseCode === '000' || $responseCode === 'PAID' || $responseCode === 'success') {
            return PaymentResult::success(
                status: 'paid',
                transactionId: $txnId,
                message: 'EasyPaisa payment confirmed: ' . $desc,
                rawResponse: $params
            );
        }

        return PaymentResult::failed('EasyPaisa transaction was not completed: ' . $desc, $params);
    }
}
