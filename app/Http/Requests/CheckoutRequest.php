<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['required', 'string', 'regex:/^((\+92)|(0092)|(0))?3[0-9]{2}[0-9]{7}$/'],
            'shipping_address' => ['required', 'string', 'max:300'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:150'],
            'landmark' => ['nullable', 'string', 'max:150'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'order_notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'string', 'in:cod,bank_transfer,wallet_transfer,jazzcash,easypaisa,safepay,card'],
            'wallet_type' => ['nullable', 'string', 'in:easypaisa,jazzcash,sadapay,nayapay'],
            'transaction_id' => ['nullable', 'string', 'max:100'],
            'receipt_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Please provide your full name.',
            'customer_email.required' => 'A valid email address is required for dispatch notifications.',
            'customer_phone.required' => 'Please provide your active Pakistani mobile contact number.',
            'customer_phone.regex' => 'Please enter a valid Pakistani mobile number (e.g. 03001234567 or +923001234567).',
            'shipping_address.required' => 'Please specify your exact street address or house/bungalow number.',
            'city.required' => 'Please select your destination city in Pakistan.',
            'province.required' => 'Please select your province.',
            'payment_method.required' => 'Please select your preferred luxury payment method.',
            'receipt_file.max' => 'Payment receipt file size must not exceed 5MB.',
        ];
    }
}
