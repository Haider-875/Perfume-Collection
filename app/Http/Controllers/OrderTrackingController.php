<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $orderNumber = trim($request->input('order_number', ''));
        $phone = trim($request->input('phone', ''));
        $order = null;
        $searched = false;

        if ($orderNumber || $phone) {
            $searched = true;
            $query = Order::with(['items', 'user']);

            if ($orderNumber) {
                $query->where('order_number', $orderNumber);
            }

            if ($phone) {
                // Normalize phone search (strip spaces, dashes, +92/03)
                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                $query->where(function($q) use ($phone, $cleanPhone) {
                    $q->where('customer_phone', 'like', '%' . substr($cleanPhone, -9))
                      ->orWhere('customer_phone', $phone);
                });
            }

            $order = $query->first();
        }

        // WhatsApp concierge support link
        $storePhone = Setting::get('whatsapp', '923001234567');
        $whatsappUrl = "https://wa.me/{$storePhone}?text=" . urlencode("Salam Perfumes Collection Concierge! I need assistance tracking my order dossier.");

        return view('pages.order-tracking', compact('order', 'searched', 'orderNumber', 'phone', 'whatsappUrl'));
    }
}
