<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    /**
     * Get or set settings from database with key alias resolution
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        if (is_null($key)) {
            return Setting::all()->pluck('value', 'key')->toArray();
        }

        try {
            $val = Setting::get($key);
            if ($val !== null && $val !== '') {
                return $val;
            }

            // Key aliases mapping
            $aliases = [
                'site_name' => ['store_name'],
                'store_name' => ['site_name'],
                'site_whatsapp' => ['whatsapp', 'store_whatsapp'],
                'whatsapp' => ['site_whatsapp', 'store_whatsapp'],
                'site_phone' => ['phone', 'store_phone'],
                'phone' => ['site_phone', 'store_phone'],
                'site_email' => ['email', 'store_email'],
                'email' => ['site_email', 'store_email'],
                'site_address' => ['address_lahore', 'store_address'],
                'store_address' => ['site_address', 'address_lahore'],
            ];

            if (isset($aliases[$key])) {
                foreach ($aliases[$key] as $aliasKey) {
                    $aliasVal = Setting::get($aliasKey);
                    if ($aliasVal !== null && $aliasVal !== '') {
                        return $aliasVal;
                    }
                }
            }

            return $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (!function_exists('format_pkr')) {
    /**
     * Format currency in PKR
     *
     * @param float|int $amount
     * @return string
     */
    function format_pkr($amount)
    {
        return 'Rs. ' . number_format((float)$amount, 0);
    }
}

if (!function_exists('ravaha_whatsapp_url')) {
    /**
     * Generate direct WhatsApp link with message
     *
     * @param string $message
     * @return string
     */
    function ravaha_whatsapp_url($message = 'Assalam o Alaikum! I would like to inquire about RAVAHA Parfums.')
    {
        $rawNumber = settings('site_whatsapp', '+92 336 3685732');
        $cleanNumber = preg_replace('/[^0-9]/', '', $rawNumber);
        if (str_starts_with($cleanNumber, '03')) {
            $cleanNumber = '92' . substr($cleanNumber, 1);
        }
        return 'https://wa.me/' . $cleanNumber . '?text=' . urlencode($message);
    }
}
