<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BankTransferGateway implements PaymentGatewayInterface
{
    public function getKey(): string
    {
        return 'bank_transfer';
    }

    public function getTitle(): string
    {
        return 'Direct Bank Transfer / Raast';
    }

    public function getDescription(): string
    {
        return 'Transfer to our official corporate bank account via Online Banking, ATM, or Raast instant transfer.';
    }

    public function isEnabled(): bool
    {
        return env('GATEWAY_BANK_TRANSFER_ENABLED', true) && Setting::get('payment_bank_enabled', '1') !== '0';
    }

    public function getBankDetails(): array
    {
        return [
            'bank_name' => Setting::get('bank_name', env('BANK_NAME', 'Bank Alfalah Limited')),
            'account_title' => Setting::get('bank_account_title', env('BANK_ACCOUNT_TITLE', 'Perfumes Collection (Pvt) Ltd')),
            'account_number' => Setting::get('bank_account_number', env('BANK_ACCOUNT_NUMBER', '0142-1007894561')),
            'iban' => Setting::get('bank_iban', env('BANK_IBAN', 'PK36ALFH01421007894561')),
            'raast_id' => Setting::get('bank_raast_id', env('BANK_RAAST_ID', '03001234567')),
            'branch' => Setting::get('bank_branch', env('BANK_BRANCH', 'Main Boulevard Gulberg, Lahore')),
        ];
    }

    public function initiate(Order $order, array $data = []): PaymentResult
    {
        $transactionId = $data['transaction_id'] ?? null;
        $receiptPath = null;

        if (isset($data['receipt_file']) && $data['receipt_file'] instanceof \Illuminate\Http\UploadedFile) {
            $file = $data['receipt_file'];
            $filename = 'bank_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Hostinger shared hosting safe upload to public/uploads/receipts
            $destinationPath = public_path('uploads/receipts');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $filename);
            $receiptPath = 'uploads/receipts/' . $filename;
        }

        return PaymentResult::pendingVerification(
            transactionId: $transactionId,
            message: 'Bank transfer receipt/transaction details received. Your order is placed under verification.',
            receiptImage: $receiptPath,
            rawResponse: [
                'bank_details' => $this->getBankDetails(),
                'transaction_id' => $transactionId,
                'receipt_path' => $receiptPath,
            ]
        );
    }

    public function verifyCallback(Request $request): PaymentResult
    {
        return PaymentResult::failed('Manual bank transfer requires manual administrative verification.');
    }
}
