@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-4 py-md-5 min-vh-100" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;">
    <div class="container px-3 px-sm-4" style="max-width: 820px;">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2.5 shadow-sm" style="width: 50px; height: 50px; background-color: #DEF7EC; border: 1px solid #31C48D; color: #0E9F6E;">
                <i class="fas fa-check" style="font-size: 1.15rem;"></i>
            </div>

            <span class="d-inline-block fw-semibold px-2.5 py-0.5 rounded-pill mb-1.5" style="font-size: 10px; letter-spacing: 0.24em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Order Received
            </span>
            <h1 class="font-serif fw-normal mb-1.5" style="font-size: clamp(1.25rem, 2.5vw, 1.6rem); color: #211D1E;">
                Thank You, {{ $order->customer_name }}
            </h1>
            <p class="mx-auto mb-0" style="font-size: 0.85rem; max-width: 480px; color: #6B605B; line-height: 1.5;">
                Your bespoke fragrance order has been received. A detailed dispatch confirmation has been sent to <strong style="color: #211D1E;">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="p-3.5 p-sm-4 p-md-4 rounded-4 shadow-sm d-flex flex-column gap-3.5 mb-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <!-- Order Reference Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2.5 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                <div>
                    <span class="d-block mb-0.5 text-uppercase fw-medium" style="font-size: 10px; letter-spacing: 0.06em; color: #6B605B;">Order Tracking Number</span>
                    <span class="font-serif fs-5 fw-bold font-mono" style="color: #541B29;">{{ $order->order_number }}</span>
                </div>
                <div class="text-sm-end">
                    <span class="d-block mb-0.5 text-uppercase fw-medium" style="font-size: 10px; letter-spacing: 0.06em; color: #6B605B;">Payment Status</span>
                    <span class="text-uppercase px-2.5 py-1 rounded-pill fw-semibold d-inline-block" style="font-size: 10.5px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="p-3 rounded-3 d-flex flex-column gap-1.5" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; font-size: 12px; color: #211D1E;">
                    <div class="d-flex align-items-center gap-2 fw-bold" style="font-size: 12.5px; color: #541B29;">
                        <i class="fas fa-info-circle" style="color: #9E7D3B;"></i>
                        <span>Payment Verification in Progress</span>
                    </div>
                    <p class="lh-base mb-0" style="color: #6B605B; font-size: 11.5px;">
                        If you have already transferred the payment, our concierge team will verify your transaction reference / screenshot and confirm your order shortly.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-1">
                            <a href="{{ route('account.order.show', $order->order_number) }}" 
                               class="py-2 px-3 fw-semibold text-uppercase tracking-wider rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none shadow-sm" 
                               style="font-size: 11px; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border-radius: 6px;">
                                <span>Upload Payment Screenshot</span>
                                <i class="fas fa-upload" style="font-size: 10.5px;"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown -->
            <div>
                <h3 class="fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.06em; text-transform: uppercase; color: #541B29;">Items Ordered</h3>
                <div class="rounded-3 overflow-hidden" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                    @foreach($order->items as $item)
                        <div class="p-2.5 p-sm-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                            <div class="min-w-0">
                                <h4 class="font-serif fw-semibold mb-0 text-truncate" style="font-size: 13.5px; color: #211D1E;">{{ $item->product_name }}</h4>
                                <p class="mb-0 mt-0.5" style="font-size: 11px; color: #6B605B;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-end font-mono fw-bold flex-shrink-0" style="font-size: 12.5px; color: #541B29 !important;">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="pt-2.5 d-flex flex-column gap-2 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex justify-content-between" style="color: #6B605B; font-size: 12px;">
                    <span>Subtotal:</span>
                    <span class="font-mono fw-semibold" style="color: #211D1E;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between fw-semibold" style="color: #541B29; font-size: 12px;">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center" style="color: #6B605B; font-size: 12px;">
                    <span>Express Courier Delivery:</span>
                    @if($order->shipping_cost == 0)
                        <span class="badge px-2 py-0.5 rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 10px; font-weight: 700;">
                            FREE
                        </span>
                    @else
                        <span class="font-mono fw-semibold" style="color: #541B29;">
                            Rs. {{ number_format($order->shipping_cost, 0) }}
                        </span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-2" style="border-top: 1px solid #E8E0DA;">
                    <span class="font-serif fw-bold" style="font-size: 14.5px; color: #211D1E;">Total Amount:</span>
                    <span class="font-serif font-mono fw-bold" style="font-size: 1.25rem; color: #541B29 !important;">
                        Rs. {{ number_format($order->total_amount, 0) }}
                    </span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="row g-2.5 pt-2.5 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; font-size: 11.5px;">
                        <h4 class="mb-1 fw-semibold" style="font-size: 10.5px; letter-spacing: 0.06em; text-transform: uppercase; color: #541B29;">Delivery Address</h4>
                        <p class="fw-bold mb-0" style="color: #211D1E;">{{ $order->customer_name }}</p>
                        <p class="mb-0" style="color: #6B605B;">{{ $order->shipping_address }}</p>
                        @if($order->area)<p class="mb-0" style="color: #6B605B;">Area: {{ $order->area }}</p>@endif
                        <p class="mb-0" style="color: #6B605B;">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="font-mono mb-0 fw-semibold" style="color: #541B29;">Phone: {{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; font-size: 11.5px;">
                        <h4 class="mb-1 fw-semibold" style="font-size: 10.5px; letter-spacing: 0.06em; text-transform: uppercase; color: #541B29;">Order Status & Instructions</h4>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #211D1E;">Status:</strong> <span class="text-capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span></p>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #211D1E;">Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} (<span class="text-capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</span>)</p>
                        @if($order->order_notes)
                            <p class="fst-italic mt-1 mb-0" style="color: #6B605B;">"{{ $order->order_notes }}"</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Slip & Live Consignment Track -->
            <div class="row g-2.5 pt-3" style="border-top: 1px solid #E8E0DA;">
                <!-- WhatsApp Button (Signature Green Gradient) -->
                <div class="col-12 col-sm-6">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2 text-decoration-none transition shadow-sm"
                       style="height: 44px; padding: 0 16px; font-size: 11.5px; letter-spacing: 0.06em; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%) !important; color: #FFFFFF !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; border-radius: 8px; box-shadow: 0 3px 12px rgba(18, 140, 126, 0.35) !important;">
                        <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                        <span>Send Slip to WhatsApp</span>
                    </a>
                </div>

                <!-- Live Tracking Button (Signature Wine/Ruby Luxury Gradient) -->
                <div class="col-12 col-sm-6">
                    <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                       class="w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2 text-decoration-none transition shadow-sm"
                       style="height: 44px; padding: 0 16px; font-size: 11.5px; letter-spacing: 0.06em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: none !important; border-radius: 8px; box-shadow: 0 3px 12px rgba(122, 28, 51, 0.3) !important;">
                        <i class="fas fa-truck-fast" style="font-size: 14px;"></i>
                        <span>Track Live Consignment</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center pt-1">
            <a href="{{ route('collections.show', 'all') }}" class="text-uppercase tracking-wider fw-semibold text-decoration-none d-inline-flex align-items-center gap-1.5" style="font-size: 11.5px; color: #541B29;">
                <i class="fas fa-arrow-left-long" style="font-size: 10.5px;"></i>
                <span>Continue Shopping at Perfumes Collection</span>
            </a>
        </div>
    </div>
</div>
@endsection
