<?php

namespace App\Services\PaymentGateways;

class PaymentResult
{
    public function __construct(
        public bool $success,
        public string $status, // 'paid', 'pending_verification', 'pending', 'failed', 'refunded'
        public ?string $transactionId = null,
        public ?string $redirectUrl = null,
        public ?string $message = null,
        public array $rawResponse = [],
        public ?string $receiptImage = null
    ) {}

    public static function success(string $status = 'paid', ?string $transactionId = null, ?string $message = null, array $rawResponse = []): self
    {
        return new self(
            success: true,
            status: $status,
            transactionId: $transactionId,
            redirectUrl: null,
            message: $message ?? 'Payment processed successfully',
            rawResponse: $rawResponse
        );
    }

    public static function redirect(string $redirectUrl, ?string $transactionId = null, ?string $message = null, array $rawResponse = []): self
    {
        return new self(
            success: true,
            status: 'pending',
            transactionId: $transactionId,
            redirectUrl: $redirectUrl,
            message: $message ?? 'Redirecting to payment gateway...',
            rawResponse: $rawResponse
        );
    }

    public static function pendingVerification(?string $transactionId = null, ?string $message = null, ?string $receiptImage = null, array $rawResponse = []): self
    {
        return new self(
            success: true,
            status: 'pending_verification',
            transactionId: $transactionId,
            redirectUrl: null,
            message: $message ?? 'Payment proof submitted. Awaiting manual verification.',
            rawResponse: $rawResponse,
            receiptImage: $receiptImage
        );
    }

    public static function failed(string $message, array $rawResponse = []): self
    {
        return new self(
            success: false,
            status: 'failed',
            transactionId: null,
            redirectUrl: null,
            message: $message,
            rawResponse: $rawResponse
        );
    }
}
