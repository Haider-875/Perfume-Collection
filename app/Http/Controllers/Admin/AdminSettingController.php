<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'store_logo']);

        // Handle logo upload if provided
        if ($request->hasFile('store_logo')) {
            $file = $request->file('store_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/settings');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            Setting::set('store_logo', 'uploads/settings/' . $filename, 'general');
        }

        // Handle boolean toggles that might not be present in request if unchecked
        $toggleKeys = [
            'payment_cod_enabled',
            'payment_bank_enabled',
            'payment_easypaisa_enabled',
            'payment_jazzcash_enabled',
            'payment_safepay_enabled',
            'announcement_bar_enabled',
            'maintenance_mode',
        ];

        foreach ($toggleKeys as $key) {
            $value = $request->has($key) ? '1' : '0';
            $group = str_starts_with($key, 'payment_') ? 'payments' : 'general';
            Setting::set($key, $value, $group);
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $toggleKeys)) continue;

            $group = 'general';
            if (str_starts_with($key, 'payment_') || str_contains($key, 'jazzcash') || str_contains($key, 'safepay') || str_contains($key, 'easypaisa') || str_contains($key, 'bank_')) {
                $group = 'payments';
            } elseif (str_starts_with($key, 'shipping_')) {
                $group = 'shipping';
            } elseif (str_starts_with($key, 'social_') || str_contains($key, 'whatsapp')) {
                $group = 'social';
            }

            Setting::set($key, $value ?? '', $group);
        }

        ActivityLog::record('settings_updated', 'Updated brand configuration and payment gateway parameters');

        return redirect()->route('admin.settings.index')->with('success', 'Maison settings and gateway configurations synchronized.');
    }
}
