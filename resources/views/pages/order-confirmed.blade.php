@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;">
    <div class="container px-3 px-lg-4" style="max-width: 900px;">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-5">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 64px; height: 64px; background-color: #DEF7EC; border: 1px solid #31C48D; color: #0E9F6E;">
                <i class="fas fa-check fs-3"></i>
            </div>

            <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Order Received
            </span>
            <h1 class="font-serif display-5 fw-normal mb-2" style="color: #211D1E;">Thank You, {{ $order->customer_name }}</h1>
            <p class="mx-auto mb-0" style="font-size: 0.95rem; max-width: 520px; color: #6B605B;">
                Your bespoke fragrance order has been received. A detailed dispatch confirmation has been sent to <strong style="color: #211D1E;">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="p-4 p-md-5 rounded-4 shadow-sm d-flex flex-column gap-4 mb-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <!-- Order Reference Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4" style="border-bottom: 1px solid #E8E0DA;">
                <div>
                    <span class="d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em; color: #6B605B;">Order Tracking Number</span>
                    <span class="font-serif fs-3 fw-bold" style="color: #541B29;">{{ $order->order_number }}</span>
                </div>
                <div class="text-end">
                    <span class="d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em; color: #6B605B;">Payment Method</span>
                    <span class="text-xs text-uppercase px-3 py-1 rounded-pill fw-semibold" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="p-3 rounded-3 text-xs d-flex flex-column gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                    <div class="d-flex align-items-center gap-2 font-serif fs-6 fw-bold" style="color: #541B29;">
                        <i class="fas fa-info-circle" style="color: #9E7D3B;"></i>
                        <span>Payment Verification in Progress</span>
                    </div>
                    <p class="lh-base mb-0" style="color: #6B605B;">
                        If you have already transferred the payment, our concierge team will verify your transaction reference / screenshot and confirm your order shortly.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-1">
                            <a href="{{ route('account.order.show', $order->order_number) }}" class="btn-gold py-2 px-3 text-xs fw-semibold text-uppercase tracking-wider rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none" style="border-radius: 8px;">
                                <span>Upload Payment Screenshot</span>
                                <i class="fas fa-upload" style="font-size: 11px;"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown -->
            <div>
                <h3 class="fw-semibold mb-2" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Items Ordered</h3>
                <div class="rounded-3 overflow-hidden" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                    @foreach($order->items as $item)
                        <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                            <div>
                                <h4 class="font-serif fs-6 fw-bold mb-0" style="color: #211D1E;">{{ $item->product_name }}</h4>
                                <p class="mb-0" style="font-size: 11px; color: #6B605B;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-end font-mono fw-bold" style="color: #541B29 !important;">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="pt-3 d-flex flex-column gap-2 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex justify-content-between" style="color: #6B605B;">
                    <span>Subtotal:</span>
                    <span class="font-mono fw-semibold" style="color: #211D1E;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between fw-semibold" style="color: #541B29;">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between" style="color: #6B605B;">
                    <span>Express Courier Delivery:</span>
                    <span class="font-mono fw-semibold" style="color: #541B29;">{{ $order->shipping_cost == 0 ? 'FREE' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-2" style="border-top: 1px solid #E8E0DA;">
                    <span class="font-serif fs-5 fw-bold" style="color: #211D1E;">Total Amount:</span>
                    <span class="font-serif fs-3 font-mono fw-bold" style="color: #541B29 !important;">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="row g-3 pt-3 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Delivery Address</h4>
                        <p class="fw-bold mb-0" style="color: #211D1E;">{{ $order->customer_name }}</p>
                        <p class="mb-0" style="color: #6B605B;">{{ $order->shipping_address }}</p>
                        @if($order->area)<p class="mb-0" style="color: #6B605B;">Area: {{ $order->area }}</p>@endif
                        <p class="mb-0" style="color: #6B605B;">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="font-mono mb-0" style="color: #541B29;">Phone: {{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Order Status & Instructions</h4>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #211D1E;">Status:</strong> <span class="text-capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span></p>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #211D1E;">Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} (<span class="text-capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</span>)</p>
                        @if($order->order_notes)
                            <p class="fst-italic mt-1 mb-0" style="color: #6B605B;">"{{ $order->order_notes }}"</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Share & Track Order -->
            <div class="row g-3 pt-3" style="border-top: 1px solid #E8E0DA;">
                <div class="col-12 col-sm-6">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-100 py-3 btn-whatsapp fw-semibold text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none">
                        <i class="fab fa-whatsapp fs-5"></i>
                        <span>Send Order Slip to WhatsApp</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6">
                    <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                       class="w-100 py-3 btn-gold fw-semibold text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none" style="border-radius: 8px;">
                        <i class="fas fa-truck-fast"></i>
                        <span>Track Live Courier Consignment</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('collections.show', 'all') }}" class="text-xs text-uppercase tracking-widest fw-semibold text-decoration-none" style="color: #541B29;">
                &larr; Continue Shopping at Perfumes Collection
            </a>
        </div>
    </div>
</div>
@endsection
