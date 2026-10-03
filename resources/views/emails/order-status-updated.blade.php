<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Status Update #{{ $order->order_number }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #080304; color: #F5EFE6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; max-width: 640px; margin: 0 auto; background-color: #0d0608; border: 1px solid rgba(201, 162, 75, 0.3); border-radius: 4px; overflow: hidden; }
        .header { text-align: center; padding: 40px 20px 30px; background: linear-gradient(180deg, #15080a 0%, #0d0608 100%); border-bottom: 1px solid rgba(201, 162, 75, 0.2); }
        .brand-title { font-family: Georgia, serif; font-size: 24px; letter-spacing: 4px; color: #E6C77A; text-transform: uppercase; margin: 10px 0 4px; font-weight: normal; }
        .brand-subtitle { font-size: 10px; letter-spacing: 3px; color: rgba(245, 239, 230, 0.6); text-transform: uppercase; }
        .content { padding: 36px 30px; }
        .greeting { font-family: Georgia, serif; font-size: 20px; color: #F5EFE6; margin-bottom: 16px; }
        .status-box { background: rgba(201, 162, 75, 0.08); border-left: 3px solid #C9A24B; padding: 18px 20px; margin: 24px 0; }
        .status-title { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #C9A24B; margin-bottom: 4px; }
        .status-val { font-size: 20px; font-weight: bold; color: #E6C77A; text-transform: uppercase; }
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
                    We are pleased to inform you that your bespoke fragrance consignment #<strong style="color: #E6C77A;">{{ $order->order_number }}</strong> has advanced to a new stage of fulfillment.
                </p>

                <div class="status-box">
                    <div class="status-title">Current Consignment Status</div>
                    <div class="status-val">{{ strtoupper(str_replace('_', ' ', $newStatus)) }}</div>
                    @if($comment)
                        <div style="font-size: 13px; color: rgba(245, 239, 230, 0.8); margin-top: 8px; font-style: italic;">
                            "{{ $comment }}"
                        </div>
                    @endif
                </div>

                @if($order->courier_name || $order->tracking_number)
                    <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(201, 162, 75, 0.3); padding: 18px; border-radius: 4px; margin: 20px 0; font-size: 13px;">
                        <div style="font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #C9A24B; margin-bottom: 6px;">Express Courier Partner</div>
                        <div style="color: #F5EFE6; font-weight: bold; font-size: 15px;">{{ $order->courier_name ?? 'TCS Express Logistics' }}</div>
                        <div style="color: rgba(245, 239, 230, 0.7); font-family: monospace; margin-top: 4px;">
                            Consignment Note (CN): <strong style="color: #E6C77A;">{{ $order->tracking_number ?? 'In Transit' }}</strong>
                        </div>
                    </div>
                @endif

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/order-tracking?order_number=' . $order->order_number . '&phone=' . urlencode($order->customer_phone)) }}" class="btn-gold">
                        Track Live Consignment
                    </a>
                </div>
            </div>

            <div class="footer">
                <div>Perfumes Collection • MM Alam Road, Gulberg III, Lahore • Clifton, Karachi • F-7, Islamabad</div>
                <div style="margin-top: 8px;">Concierge WhatsApp: +92 300 1234567 • Email: concierge@perfumescollection.pk</div>
            </div>
        </div>
    </div>
</body>
</html>
