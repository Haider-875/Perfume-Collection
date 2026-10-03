<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class CashOnDeliveryGateway implements PaymentGatewayInterface
{
    public function getKey(): string
    {
        return 'cod';
    }

    public function getTitle(): string
    {
        return 'Cash on Delivery (COD)';
    }

    public function getDescription(): string
    {
        return 'Pay with cash upon delivery at your doorstep across Pakistan via TCS, Leopards, or PostEx.';
    }

    public function isEnabled(): bool
    {
        return env('GATEWAY_COD_ENABLED', true) && Setting::get('payment_cod_enabled', '1') !== '0';
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        // COD orders are automatically placed in confirmed status with unpaid payment status
        return PaymentResult::success(
            status: 'unpaid',
            transactionId: 'COD-' . $order->order_number,
            message: 'Your luxury order is confirmed for Cash on Delivery. Prepare exact cash upon courier arrival.',
            rawResponse: ['method' => 'cod', 'cod_fee' => 0]
        );
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        return PaymentResult::failed('COD does not support external webhooks.');
    }
}
