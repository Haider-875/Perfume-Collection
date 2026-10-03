<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * Unique key for this payment method (e.g. 'cod', 'bank_transfer', 'jazzcash', 'easypaisa', 'safepay')
     */
    public function getKey(): string;

    /**
     * Human readable title
     */
    public function getTitle(): string;

    /**
     * Short luxury descriptive instructions
     */
    public function getDescription(): string;

    /**
     * Check if this gateway is enabled via .env / settings
     */
    public function isEnabled(): bool;

    /**
     * Initiate payment processing for an order
     *
     * @param Order $order
     * @param array $data Form data including transaction_id, receipt file, etc.
     * @return PaymentResult
     */
    public function initiate(Order $order, array $data = []): PaymentResult;

    /**
     * Handle return/webhook callbacks from the payment gateway
     *
     * @param Request $request
     * @return PaymentResult
     */
    public function verifyCallback(Request $request): PaymentResult;
}
