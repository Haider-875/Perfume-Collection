<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'user'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('tracking_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->paginate(15)->withQueryString();

        // City & Province statistics for filter dropdowns
        $cities = Order::select('city')->distinct()->pluck('city')->filter();
        $provinces = Order::select('province')->distinct()->pluck('province')->filter();

        return view('admin.orders.index', compact('orders', 'cities', 'provinces'));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);

        $couriers = [
            'TCS' => 'https://www.tcsexpress.com/tracking?track=',
            'Leopards Courier' => 'https://www.leopardscourier.com/tracking?track_numbers=',
            'PostEx' => 'https://postex.pk/tracking?order_id=',
            'Trax Logistics' => 'https://trax.pk/tracking?tracking_number=',
            'M&P Express' => 'https://mulphilog.com/tracking?consignmentNo=',
            'BlueEx' => 'https://www.blue-ex.com/tracking?cn=',
            'Call Courier' => 'https://callcourier.com.pk/tracking/?tc=',
        ];

        return view('admin.orders.show', compact('order', 'couriers'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,unpaid,pending_verification,paid,failed,refunded',
            'courier_name' => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'tracking_link' => 'nullable|url|max:255',
            'order_notes' => 'nullable|string',
        ]);

        $oldStatus = $order->order_status;
        $oldPaymentStatus = $order->payment_status;

        // Auto-populate tracking link if known courier
        $trackingLink = $request->tracking_link;
        if ($request->filled('courier_name') && $request->filled('tracking_number') && empty($trackingLink)) {
            $couriers = [
                'TCS' => 'https://www.tcsexpress.com/tracking?track=' . $request->tracking_number,
                'Leopards Courier' => 'https://www.leopardscourier.com/tracking?track_numbers=' . $request->tracking_number,
                'PostEx' => 'https://postex.pk/tracking?order_id=' . $request->tracking_number,
                'Trax Logistics' => 'https://trax.pk/tracking?tracking_number=' . $request->tracking_number,
                'M&P Express' => 'https://mulphilog.com/tracking?consignmentNo=' . $request->tracking_number,
                'BlueEx' => 'https://www.blue-ex.com/tracking?cn=' . $request->tracking_number,
                'Call Courier' => 'https://callcourier.com.pk/tracking/?tc=' . $request->tracking_number,
            ];
            $trackingLink = $couriers[$request->courier_name] ?? null;
        }

        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'courier_name' => $request->courier_name,
            'tracking_number' => $request->tracking_number,
            'tracking_link' => $trackingLink,
            'order_notes' => $request->order_notes,
        ]);

        // Send email to customer if status changed and email exists
        if ($order->customer_email && ($oldStatus !== $order->order_status || $oldPaymentStatus !== $order->payment_status)) {
            try {
                Mail::to($order->customer_email)->send(new OrderStatusUpdatedMail($order));
            } catch (\Exception $e) {
                // Ignore mail failure on shared host if SMTP not configured
            }
        }

        ActivityLog::record(
            'order_updated',
            "Updated order #{$order->order_number} status to '{$order->order_status}' and payment to '{$order->payment_status}'",
            $order,
            ['old_status' => $oldStatus, 'new_status' => $order->order_status]
        );

        return redirect()->route('admin.orders.show', $order->id)->with('success', "Order #{$order->order_number} updated successfully.");
    }

    public function approveReceipt($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => 'paid',
            'order_status' => $order->order_status === 'pending' ? 'confirmed' : $order->order_status,
        ]);

        if ($order->customer_email) {
            try {
                Mail::to($order->customer_email)->send(new OrderStatusUpdatedMail($order));
            } catch (\Exception $e) {}
        }

        ActivityLog::record('receipt_approved', "Approved payment receipt for order #{$order->order_number}", $order);

        return redirect()->route('admin.orders.show', $order->id)->with('success', "Payment receipt approved and order confirmed.");
    }

    public function rejectReceipt(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => 'failed',
        ]);

        ActivityLog::record('receipt_rejected', "Rejected payment receipt for order #{$order->order_number}", $order);

        return redirect()->route('admin.orders.show', $order->id)->with('warning', "Payment receipt rejected. Marked as failed.");
    }

    public function invoice($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }

    public function packingSlip($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.packing-slip', compact('order'));
    }

    public function exportCsv(Request $request)
    {
        $query = Order::with(['items', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        $orders = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="perfumes_collection_orders_' . date('Y_m_d_His') . '.csv"',
        ];

        ActivityLog::record('orders_exported', "Exported {$orders->count()} orders to CSV");

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Order Number',
                'Date',
                'Customer Name',
                'Customer Email',
                'Phone',
                'Address',
                'City',
                'Province',
                'Items Summary',
                'Subtotal (PKR)',
                'Discount (PKR)',
                'Shipping (PKR)',
                'Total (PKR)',
                'Payment Method',
                'Payment Status',
                'Order Status',
                'Courier',
                'Tracking Number'
            ]);

            foreach ($orders as $order) {
                $itemsStr = $order->items->map(function ($item) {
                    return "{$item->product_name} ({$item->size}) x{$item->quantity}";
                })->implode('; ');

                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->shipping_address . ' ' . $order->area,
                    $order->city,
                    $order->province,
                    $itemsStr,
                    $order->subtotal,
                    $order->discount_amount,
                    $order->shipping_cost,
                    $order->total_amount,
                    $order->payment_method,
                    $order->payment_status,
                    $order->order_status,
                    $order->courier_name ?? 'N/A',
                    $order->tracking_number ?? 'N/A',
                ]);
            }
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
