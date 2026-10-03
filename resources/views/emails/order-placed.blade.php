<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation #{{ $order->order_number }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #080304; color: #F5EFE6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; max-width: 640px; margin: 0 auto; background-color: #0d0608; border: 1px solid rgba(201, 162, 75, 0.3); border-radius: 4px; overflow: hidden; }
        .header { text-align: center; padding: 40px 20px 30px; background: linear-gradient(180deg, #15080a 0%, #0d0608 100%); border-bottom: 1px solid rgba(201, 162, 75, 0.2); }
        .brand-title { font-family: Georgia, serif; font-size: 24px; letter-spacing: 4px; color: #E6C77A; text-transform: uppercase; margin: 10px 0 4px; font-weight: normal; }
        .brand-subtitle { font-size: 10px; letter-spacing: 3px; color: rgba(245, 239, 230, 0.6); text-transform: uppercase; }
        .content { padding: 36px 30px; }
        .greeting { font-family: Georgia, serif; font-size: 20px; color: #F5EFE6; margin-bottom: 16px; }
        .status-box { background: rgba(201, 162, 75, 0.08); border-left: 3px solid #C9A24B; padding: 16px 20px; margin: 24px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin: 28px 0; }
        .items-table th { text-align: left; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #C9A24B; padding: 12px 0; border-bottom: 1px solid rgba(201, 162, 75, 0.2); }
        .items-table td { padding: 16px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.06); font-size: 14px; color: #F5EFE6; }
        .total-row { font-family: Georgia, serif; font-size: 16px; color: #E6C77A; }
        .btn-gold { display: inline-block; background: linear-gradient(135deg, #C9A24B 0%, #E6C77A 100%); color: #080304 !important; font-weight: bold; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; padding: 14px 28px; text-decoration: none; border-radius: 2px; margin-top: 20px; }
        .footer { text-align: center; padding: 30px 20px; background-color: #060203; border-top: 1px solid rgba(201, 162, 75, 0.15); font-size: 11px; color: rgba(245, 239, 230, 0.4); line-height: 1.6; }
    </style>
</head>
<body>
    <div style="padding: 20px 10px;">
        <div class="wrapper">
            <div class="header">
                <div class="brand-title">Perfumes Collection</div>
                <div class="brand-subtitle">Haute Parfumerie • Pakistan</div>
            </div>

            <div class="content">
                <div class="greeting">Distinguished Patron, {{ $order->customer_name }}</div>
                <p style="font-size: 14px; line-height: 1.6; color: rgba(245, 239, 230, 0.8);">
                    We are privileged to confirm the receipt of your bespoke fragrance order. Our master artisans and logistics concierges are preparing your flacons with utmost care.
                </p>

                <div class="status-box">
                    <div style="font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: #C9A24B; margin-bottom: 4px;">Order Dossier</div>
                    <div style="font-size: 18px; font-weight: bold; color: #E6C77A;">{{ $order->order_number }}</div>
                    <div style="font-size: 13px; color: rgba(245, 239, 230, 0.7); margin-top: 4px;">
                        Payment: <strong>{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</strong> • 
                        Status: <strong>{{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</strong>
                    </div>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Perfume Creation</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong><br>
                                    <span style="font-size: 12px; color: rgba(245, 239, 230, 0.5);">{{ $item->variant_label ?? 'Standard Flacon' }}</span>
                                </td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">Rs. {{ number_format($item->total, 0) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" style="text-align: right; padding-top: 14px; color: rgba(245, 239, 230, 0.6);">Subtotal</td>
                            <td style="text-align: right; padding-top: 14px;">Rs. {{ number_format($order->subtotal, 0) }}</td>
                        </tr>
                        @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="2" style="text-align: right; color: #C9A24B;">Coupon Privilege ({{ $order->coupon_code }})</td>
                                <td style="text-align: right; color: #C9A24B;">- Rs. {{ number_format($order->discount_amount, 0) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="2" style="text-align: right; color: rgba(245, 239, 230, 0.6);">White-Glove Courier Delivery</td>
                            <td style="text-align: right;">{{ $order->shipping_cost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" style="text-align: right; font-weight: bold; border-top: 1px solid rgba(201, 162, 75, 0.3); padding-top: 14px;">Grand Total</td>
                            <td style="text-align: right; font-weight: bold; border-top: 1px solid rgba(201, 162, 75, 0.3); padding-top: 14px; font-size: 18px;">Rs. {{ number_format($order->total_amount, 0) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); padding: 18px; border-radius: 4px; margin-top: 24px; font-size: 13px; line-height: 1.6;">
                    <div style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #C9A24B; margin-bottom: 6px;">Delivery Destination</div>
                    <div style="color: #F5EFE6;"><strong>{{ $order->customer_name }}</strong> ({{ $order->customer_phone }})</div>
                    <div style="color: rgba(245, 239, 230, 0.7);">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }}</div>
                    @if($order->landmark)
                        <div style="color: rgba(245, 239, 230, 0.5); font-size: 12px;">Landmark: {{ $order->landmark }}</div>
                    @endif
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/order-tracking?order_number=' . $order->order_number . '&phone=' . urlencode($order->customer_phone)) }}" class="btn-gold">
                        Track Fragrance Consignment
                    </a>
                </div>
            </div>

            <div class="footer">
                <div>Perfumes Collection • MM Alam Road, Gulberg III, Lahore • Clifton, Karachi • F-7, Islamabad</div>
                <div style="margin-top: 8px;">Concierge WhatsApp: +92 300 1234567 • Email: concierge@perfumescollection.pk</div>
                <div style="margin-top: 12px; color: rgba(245, 239, 230, 0.25);">© {{ date('Y') }} Perfumes Collection. All Rights Reserved.</div>
            </div>
        </div>
    </div>
</body>
</html>
