<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }} - Perfumes Collection</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 30px;
            background: #fff;
            font-size: 13.5px;
            line-height: 1.5;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #C9A24B;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .brand-title {
            font-size: 22px;
            font-weight: bold;
            color: #080304;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 13px;
            color: #777;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .meta-table td {
            vertical-align: top;
            width: 50%;
            font-size: 13.5px;
            line-height: 1.6;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background: #f9f7f2;
            color: #444;
            text-align: left;
            padding: 10px;
            font-size: 13px;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13.5px;
        }
        .totals {
            width: 320px;
            margin-left: auto;
            margin-bottom: 30px;
            font-size: 13.5px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .totals-row.grand {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #C9A24B;
            padding-top: 10px;
            color: #080304;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        @media print {
            body { padding: 0; }
            .invoice-container { border: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 20px; text-align: right;">
        <button onclick="window.print()" style="background: #C9A24B; color: #000; font-weight: bold; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-size: 14px;">
            Print / Save as PDF
        </button>
    </div>

    <div class="invoice-container">
        <div class="header">
            <div>
                <div class="brand-title">Perfumes Collection</div>
                <div class="brand-sub">Haute Parfumerie &bull; Pakistan</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 18px; font-weight: bold; color: #C9A24B;">INVOICE</div>
                <div style="font-family: monospace; font-size: 14px;">#{{ $order->order_number }}</div>
                <div style="color: #666; font-size: 13px;">Date: {{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <table class="meta-table">
            <tr>
                <td>
                    <strong style="text-transform: uppercase; font-size: 13px; color: #888;">Billed & Shipped To:</strong><br>
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    @if($order->area) Area: {{ $order->area }}<br> @endif
                    <strong>{{ $order->city }}, {{ $order->province }}</strong><br>
                    Phone: {{ $order->customer_phone }}<br>
                    Email: {{ $order->customer_email }}
                </td>
                <td style="text-align: right;">
                    <strong style="text-transform: uppercase; font-size: 13px; color: #888;">Payment Summary:</strong><br>
                    Payment Method: <strong style="text-transform: uppercase;">{{ $order->payment_method }}</strong><br>
                    Payment Status: <strong style="text-transform: uppercase; color: {{ $order->payment_status === 'paid' ? 'green' : 'orange' }};">{{ $order->payment_status }}</strong><br>
                    @if($order->courier_name)
                        Courier: <strong>{{ $order->courier_name }}</strong><br>
                        Tracking #: <strong>{{ $order->tracking_number ?? 'Pending' }}</strong><br>
                    @endif
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Item / Fragrance</th>
                    <th>Volume</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->product_name }}</strong></td>
                        <td>{{ $item->size }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rs. {{ number_format($item->price, 0) }}</td>
                        <td style="text-align: right; font-weight: bold;">Rs. {{ number_format($item->total, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>{{ $order->formatted_subtotal }}</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="totals-row" style="color: green;">
                    <span>Privilege Discount ({{ $order->coupon_code }}):</span>
                    <span>- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                </div>
            @endif
            <div class="totals-row">
                <span>Shipping Charges:</span>
                <span>{{ $order->formatted_shipping }}</span>
            </div>
            <div class="totals-row grand">
                <span>Total Amount (PKR):</span>
                <span>{{ $order->formatted_total }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>Perfumes Collection Haute Parfumerie</strong>.</p>
            <p>For concierge inquiries, contact concierge@perfumecollectionpk.com or WhatsApp +92 336 3685732</p>
        </div>
    </div>
</body>
</html>
