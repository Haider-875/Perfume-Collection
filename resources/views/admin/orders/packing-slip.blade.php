<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Packing Slip #{{ $order->order_number }} - Perfumes Collection</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 30px;
            background: #fff;
            font-size: 12px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px dashed #bbb;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table th {
            background: #eee;
            text-align: left;
            padding: 8px;
            border: 1px solid #ccc;
            font-size: 11px;
            text-transform: uppercase;
        }
        .table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 20px;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 20px; text-align: right;">
        <button onclick="window.print()" style="background: #000; color: #fff; font-weight: bold; border: none; padding: 10px 20px; cursor: pointer;">
            Print Packing Slip
        </button>
    </div>

    <div class="container">
        <div class="header">
            <div>
                <div class="title">PACKING SLIP / DISPATCH</div>
                <div style="font-size: 11px; color: #666;">Perfumes Collection Haute Parfumerie</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 16px; font-weight: bold; font-family: monospace;">#{{ $order->order_number }}</div>
                <div style="font-size: 11px;">Courier: {{ $order->courier_name ?? 'Standard Courier' }}</div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div style="width: 50%;">
                <strong style="text-transform: uppercase; font-size: 10px;">Ship To Patron:</strong><br>
                <div style="font-size: 14px; font-weight: bold; margin-top: 5px;">{{ $order->customer_name }}</div>
                <div style="margin-top: 5px;">
                    {{ $order->shipping_address }}<br>
                    @if($order->area) Area: {{ $order->area }}<br> @endif
                    <strong>{{ $order->city }}, {{ $order->province }}</strong><br>
                    Phone: <strong>{{ $order->customer_phone }}</strong>
                </div>
            </div>
            <div style="width: 50%; text-align: right;">
                <strong style="text-transform: uppercase; font-size: 10px;">Payment Term:</strong><br>
                <div style="font-size: 14px; font-weight: bold; color: {{ $order->payment_method === 'cod' ? '#d9534f' : '#5cb85c' }};">
                    {{ strtoupper($order->payment_method) }}
                    @if($order->payment_method === 'cod')
                        - COLLECT PKR {{ number_format($order->total_amount, 0) }}
                    @else
                        - PREPAID / PAID
                    @endif
                </div>
                <div style="margin-top: 10px; font-size: 11px;">
                    Order Date: {{ $order->created_at->format('d M Y') }}
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">[ &check; ]</th>
                    <th>Product / Fragrance</th>
                    <th>Volume / Variant</th>
                    <th style="text-align: center; width: 60px;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="text-align: center; font-size: 16px;">&square;</td>
                        <td><strong>{{ $item->product_name }}</strong></td>
                        <td>{{ $item->size }}</td>
                        <td style="text-align: center; font-weight: bold; font-size: 13px;">{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($order->order_notes)
            <div class="box">
                <strong style="text-transform: uppercase; font-size: 10px;">Patron Order Instructions:</strong>
                <p style="margin: 5px 0 0;">{{ $order->order_notes }}</p>
            </div>
        @endif

        <div style="margin-top: 30px; display: flex; justify-content: space-between; font-size: 11px; border-top: 1px solid #ccc; padding-top: 10px;">
            <div>Packed By: ___________________</div>
            <div>Verified By: ___________________</div>
            <div>Date: ____ / ____ / 2026</div>
        </div>
    </div>
</body>
</html>
