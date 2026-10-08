@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100 border-bottom border-gold-20" style="background-color: #050203;">
    <div class="container px-3 px-lg-4" style="max-width: 900px;">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-5">
            <div class="rounded-circle bg-wine-dark border border-success d-flex align-items-center justify-content-center text-success mx-auto mb-3 shadow-lg" style="width: 64px; height: 64px;">
                <i class="fas fa-check fs-3"></i>
            </div>

            <span class="d-inline-block text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">
                Order Received
            </span>
            <h1 class="font-serif display-5 text-light-parchment fw-normal mb-2">Thank You, {{ $order->customer_name }}</h1>
            <p class="text-muted-parchment mx-auto mb-0" style="font-size: 0.95rem; max-width: 520px;">
                Your bespoke fragrance order has been received. A detailed dispatch confirmation has been sent to <strong class="text-light-parchment">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl d-flex flex-column gap-4 mb-4">
            <!-- Order Reference Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4 border-bottom border-gold-20">
                <div>
                    <span class="text-muted-parchment d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">Order Tracking Number</span>
                    <span class="font-serif fs-3 text-gold-soft fw-bold">{{ $order->order_number }}</span>
                </div>
                <div class="text-end">
                    <span class="text-muted-parchment d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">Payment Method</span>
                    <span class="text-xs text-uppercase px-3 py-1 bg-wine-dark border border-gold-30 text-light-parchment rounded-pill fw-semibold">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="bg-wine-accent border border-gold-30 p-3 rounded-3 text-xs d-flex flex-column gap-2 text-light-parchment">
                    <div class="d-flex align-items-center gap-2 font-serif fs-6 fw-bold text-gold-soft">
                        <i class="fas fa-info-circle text-gold"></i>
                        <span>Payment Verification in Progress</span>
                    </div>
                    <p class="text-muted-parchment lh-base mb-0">
                        If you have already transferred the payment, our concierge team will verify your transaction reference / screenshot and confirm your order shortly.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-1">
                            <a href="{{ route('account.order.show', $order->order_number) }}" class="btn-gold py-2 px-3 text-xs fw-semibold text-uppercase tracking-wider rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none">
                                <span>Upload Payment Screenshot</span>
                                <i class="fas fa-upload" style="font-size: 11px;"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown -->
            <div>
                <h3 class="text-gold fw-semibold mb-2" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase;">Items Ordered</h3>
                <div class="bg-wine-dark rounded-3 border border-gold-20 overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-20' : '' }}">
                            <div>
                                <h4 class="font-serif fs-6 fw-bold text-light-parchment mb-0">{{ $item->product_name }}</h4>
                                <p class="text-muted-parchment mb-0" style="font-size: 11px;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-end font-mono text-white fw-bold" style="color: #ffffff !important;">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="border-top border-gold-20 pt-3 d-flex flex-column gap-2 text-xs">
                <div class="d-flex justify-content-between text-muted-parchment">
                    <span>Subtotal:</span>
                    <span class="font-mono text-white" style="color: #ffffff !important;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between text-gold-soft fw-semibold">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between text-muted-parchment">
                    <span>Express Courier Delivery:</span>
                    <span class="font-mono text-gold">{{ $order->shipping_cost == 0 ? 'FREE' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-2 border-top border-gold-20">
                    <span class="font-serif fs-5 text-light-parchment fw-bold">Total Amount:</span>
                    <span class="font-serif fs-3 text-white font-mono fw-bold" style="color: #ffffff !important;">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="row g-3 pt-3 border-top border-gold-20 text-xs">
                <div class="col-12 col-md-6">
                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1">
                        <h4 class="text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Delivery Address</h4>
                        <p class="fw-bold text-light-parchment mb-0">{{ $order->customer_name }}</p>
                        <p class="text-muted-parchment mb-0">{{ $order->shipping_address }}</p>
                        @if($order->area)<p class="text-muted-parchment mb-0">Area: {{ $order->area }}</p>@endif
                        <p class="text-muted-parchment mb-0">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="text-gold font-mono mb-0">Phone: {{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1">
                        <h4 class="text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Order Status & Instructions</h4>
                        <p class="text-muted-parchment mb-0"><strong class="text-light-parchment">Status:</strong> <span class="text-capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span></p>
                        <p class="text-muted-parchment mb-0"><strong class="text-light-parchment">Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} (<span class="text-capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</span>)</p>
                        @if($order->order_notes)
                            <p class="text-muted-parchment fst-italic mt-1 mb-0">"{{ $order->order_notes }}"</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Share & Track Order -->
            <div class="row g-3 pt-3 border-top border-gold-20">
                <div class="col-12 col-sm-6">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-100 py-3 btn-whatsapp fw-semibold text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none">
                        <i class="fab fa-whatsapp fs-5"></i>
                        <span>Send Order Slip to WhatsApp</span>
                    </a>
                </div>

                <div class="col-12 col-sm-6">
                    <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                       class="w-100 py-3 btn-gold fw-semibold text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none">
                        <i class="fas fa-truck-fast"></i>
                        <span>Track Live Courier Consignment</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('collections.show', 'all') }}" class="text-xs text-uppercase tracking-widest text-gold fw-semibold text-decoration-none text-gold-hover">
                &larr; Continue Shopping at Perfumes Collection
            </a>
        </div>
    </div>
</div>
@endsection
