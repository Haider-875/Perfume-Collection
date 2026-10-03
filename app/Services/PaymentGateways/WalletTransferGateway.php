<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WalletTransferGateway implements PaymentGatewayInterface
{
    public function getKey(): string
    {
        return 'wallet_transfer';
    }

    public function getTitle(): string
    {
        return 'Mobile Wallets (JazzCash / EasyPaisa / SadaPay / NayaPay)';
    }

    public function getDescription(): string
    {
        return 'Send payment from your personal JazzCash, EasyPaisa, SadaPay, or NayaPay app and enter the Transaction ID (TID) / upload screenshot.';
    }

    public function isEnabled(): bool
    {
        return env('GATEWAY_WALLET_TRANSFER_ENABLED', true) && Setting::get('payment_wallet_enabled', '1') !== '0';
    }

    public function getWalletDetails(): array
    {
        return [
            'easypaisa' => [
                'title' => 'EasyPaisa',
                'account_title' => Setting::get('easypaisa_account_title', env('EASYPAISA_ACCOUNT_TITLE', 'Perfumes Collection')),
                'account_number' => Setting::get('easypaisa_number', env('EASYPAISA_NUMBER', '03001234567')),
            ],
            'jazzcash' => [
                'title' => 'JazzCash',
                'account_title' => Setting::get('jazzcash_account_title', env('JAZZCASH_ACCOUNT_TITLE', 'Perfumes Collection')),
                'account_number' => Setting::get('jazzcash_number', env('JAZZCASH_NUMBER', '03001234567')),
            ],
            'sadapay' => [
                'title' => 'SadaPay',
                'account_title' => Setting::get('sadapay_account_title', env('SADAPAY_ACCOUNT_TITLE', 'Perfumes Collection')),
                'account_number' => Setting::get('sadapay_number', env('SADAPAY_NUMBER', '03001234567')),
                'iban' => Setting::get('sadapay_iban', env('SADAPAY_IBAN', 'PK89SADA00000003001234567')),
            ],
            'nayapay' => [
                'title' => 'NayaPay',
                'account_title' => Setting::get('nayapay_account_title', env('NAYAPAY_ACCOUNT_TITLE', 'Perfumes Collection')),
                'nayapay_id' => Setting::get('nayapay_id', env('NAYAPAY_ID', '@perfumescollection')),
                'account_number' => Setting::get('nayapay_number', env('NAYAPAY_NUMBER', '03001234567')),
            ],
        ];
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        $walletType = $data['wallet_type'] ?? 'easypaisa';
        $transactionId = $data['transaction_id'] ?? null;
        $receiptPath = null;

        if (isset($data['receipt_file']) && $data['receipt_file'] instanceof \Illuminate\Http\UploadedFile) {
            $file = $data['receipt_file'];
            $filename = 'wallet_' . $walletType . '_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/receipts');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $filename);
            $receiptPath = 'uploads/receipts/' . $filename;
        }

        return PaymentResult::pendingVerification(
            transactionId: $transactionId,
            message: 'Wallet transfer transaction proof submitted. Verification in progress.',
            receiptImage: $receiptPath,
            rawResponse: [
                'wallet_type' => $walletType,
                'transaction_id' => $transactionId,
                'receipt_path' => $receiptPath,
            ]
        );
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        return PaymentResult::failed('Manual wallet transfer requires manual administrative verification.');
    }
}
