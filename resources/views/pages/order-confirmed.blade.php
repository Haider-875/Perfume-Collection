@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-4 py-md-5 min-vh-100" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;">
    <div class="container px-3 px-sm-4" style="max-width: 840px;">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-4 mb-md-5">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 58px; height: 58px; background-color: #DEF7EC; border: 1px solid #31C48D; color: #0E9F6E;">
                <i class="fas fa-check" style="font-size: 1.35rem;"></i>
            </div>

            <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2.5" style="font-size: 10.5px; letter-spacing: 0.25em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Order Received
            </span>
            <h1 class="font-serif fw-normal mb-2.5" style="font-size: clamp(1.4rem, 2.8vw, 1.85rem); color: #211D1E; letter-spacing: 0.01em;">
                Thank You, {{ $order->customer_name }}
            </h1>
            <p class="mx-auto mb-0" style="font-size: 0.9rem; max-width: 540px; color: #6B605B; line-height: 1.75; letter-spacing: 0.01em;">
                Your bespoke fragrance order has been received. A detailed dispatch confirmation has been sent to <strong style="color: #211D1E;">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="p-4 p-sm-4 p-md-5 rounded-4 shadow-sm mb-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <!-- Order Reference Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
                <div>
                    <span class="d-block mb-1.5 text-uppercase fw-medium" style="font-size: 11px; letter-spacing: 0.08em; color: #6B605B;">Order Tracking Number</span>
                    <span class="font-serif fs-4 fw-bold font-mono" style="color: #541B29; letter-spacing: 0.02em;">{{ $order->order_number }}</span>
                </div>
                <div class="text-sm-end">
                    <span class="d-block mb-1.5 text-uppercase fw-medium" style="font-size: 11px; letter-spacing: 0.08em; color: #6B605B;">Payment Status</span>
                    <span class="text-uppercase px-3 py-1.5 rounded-pill fw-semibold d-inline-block" style="font-size: 11px; letter-spacing: 0.04em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="p-3.5 p-md-4 rounded-3 d-flex flex-column gap-2.5 mb-4" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; font-size: 12.5px; color: #211D1E;">
                    <div class="d-flex align-items-center gap-2 fw-bold" style="font-size: 13.5px; color: #541B29;">
                        <i class="fas fa-info-circle" style="color: #9E7D3B;"></i>
                        <span>Payment Verification in Progress</span>
                    </div>
                    <p class="mb-0" style="color: #6B605B; font-size: 12px; line-height: 1.7;">
                        If you have already transferred the payment, our concierge team will verify your transaction reference / screenshot and confirm your order shortly.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-2">
                            <a href="{{ route('account.order.show', $order->order_number) }}" 
                               class="py-2.5 px-4 fw-semibold text-uppercase tracking-wider rounded-3 d-inline-flex align-items-center gap-2 text-decoration-none shadow-sm" 
                               style="font-size: 11.5px; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border-radius: 8px;">
                                <span>Upload Payment Screenshot</span>
                                <i class="fas fa-upload" style="font-size: 11px;"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown (Spacious, Guaranteed Padding, Small Font Size) -->
            <div class="mb-4 pb-2">
                <h3 class="fw-semibold mb-3.5" style="font-size: 11.5px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">Items Ordered</h3>
                <div class="rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; overflow: hidden;">
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-start justify-content-between {{ !$loop->last ? 'border-bottom' : '' }}" 
                             style="padding: 14px 18px !important; gap: 14px; {{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                            <div class="flex-grow-1 min-w-0" style="padding-right: 8px;">
                                <h4 class="font-serif fw-semibold mb-1" style="font-size: 13px; color: #211D1E; line-height: 1.4; word-break: break-word;">{{ $item->product_name }}</h4>
                                <p class="mb-0" style="font-size: 11px; color: #6B605B; line-height: 1.5;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-end font-mono fw-bold flex-shrink-0 text-nowrap" style="font-size: 13px; color: #541B29 !important; white-space: nowrap; padding-top: 2px;">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="pt-4 mb-4 d-flex flex-column gap-3" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex justify-content-between align-items-center py-1" style="color: #6B605B; font-size: 13px;">
                    <span>Subtotal:</span>
                    <span class="font-mono fw-semibold" style="color: #211D1E;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between align-items-center py-1 fw-semibold" style="color: #541B29; font-size: 13px;">
                        <span>Discount Savings ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center py-1" style="color: #6B605B; font-size: 13px;">
                    <span>Express Courier Delivery:</span>
                    @if($order->shipping_cost == 0)
                        <span class="badge px-2.5 py-1 rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 11px; font-weight: 700;">
                            FREE
                        </span>
                    @else
                        <span class="font-mono fw-semibold" style="color: #541B29;">
                            Rs. {{ number_format($order->shipping_cost, 0) }}
                        </span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-3.5 mt-1" style="border-top: 1px solid #E8E0DA;">
                    <span class="font-serif fw-bold" style="font-size: 16px; color: #211D1E;">Total Amount:</span>
                    <span class="font-serif font-mono fw-bold" style="font-size: 1.45rem; color: #541B29 !important;">
                        Rs. {{ number_format($order->total_amount, 0) }}
                    </span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="row g-3 g-md-4 pt-4 mb-4" style="border-top: 1px solid #E8E0DA;">
                <!-- Left: Delivery Address with Centered Icon Badges & Proper Spacing -->
                <div class="col-12 col-md-6">
                    <div class="p-4 p-md-4.5 rounded-3 d-flex flex-column gap-3 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-bold" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">Delivery Address</h4>
                        
                        <div class="fw-bold mb-1" style="font-size: 14px; color: #211D1E;">
                            {{ $order->customer_name }}
                        </div>
                        
                        <div class="d-flex align-items-start" style="font-size: 12.5px; color: #6B605B; line-height: 1.7;">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-circle me-3 mt-0.5 shadow-xs" 
                                  style="width: 30px; height: 30px; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">
                                <i class="fas fa-location-dot" style="font-size: 12px; color: #541B29;"></i>
                            </span>
                            <span class="pt-0.5 flex-grow-1" style="word-break: break-word;">
                                {{ $order->shipping_address }}{{ $order->area ? ', ' . $order->area : '' }}, {{ $order->city }}, {{ $order->province }}
                            </span>
                        </div>

                        <div class="d-flex align-items-center pt-2.5 mt-auto" style="border-top: 1px solid #E8E0DA; font-size: 12.5px;">
                            <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-circle me-3 shadow-xs" 
                                  style="width: 30px; height: 30px; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">
                                <i class="fas fa-phone" style="font-size: 11px; color: #541B29;"></i>
                            </span>
                            <span class="font-mono fw-bold pt-0.5" style="color: #541B29; font-size: 13.5px;">
                                {{ $order->customer_phone }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Status & Instructions -->
                <div class="col-12 col-md-6">
                    <div class="p-4 p-md-4.5 rounded-3 d-flex flex-column gap-2.5 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-bold" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">Order Status &amp; Info</h4>
                        
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #E8E0DA; font-size: 12px;">
                            <span style="color: #6B605B;">Order Status:</span>
                            <span class="fw-semibold text-capitalize px-2.5 py-0.5 rounded" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E; font-size: 11.5px;">{{ str_replace('_', ' ', $order->order_status) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #E8E0DA; font-size: 12px;">
                            <span style="color: #6B605B;">Payment Method:</span>
                            <span class="fw-semibold text-uppercase" style="color: #211D1E;">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center py-2" style="font-size: 12px;">
                            <span style="color: #6B605B;">Payment Status:</span>
                            <span class="fw-bold text-capitalize" style="color: {{ $order->payment_status === 'paid' ? '#047857' : '#541B29' }};">{{ str_replace('_', ' ', $order->payment_status) }}</span>
                        </div>

                        @if($order->order_notes)
                            <div class="mt-2 p-3 rounded" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B; font-size: 11.5px; line-height: 1.65;">
                                <span class="fw-semibold d-block text-uppercase mb-1" style="font-size: 10px; color: #541B29;">Delivery Notes:</span>
                                <em>"{{ $order->order_notes }}"</em>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Slip & Live Consignment Track -->
            <div class="row g-3 g-sm-4 pt-4 mt-2" style="border-top: 1px solid #E8E0DA;">
                <!-- WhatsApp Button (Signature Green Gradient) -->
                <div class="col-12 col-sm-6">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center text-decoration-none transition shadow-sm"
                       style="height: 50px; padding: 0 24px; font-size: 12px; letter-spacing: 0.08em; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%) !important; color: #FFFFFF !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; border-radius: 8px; box-shadow: 0 4px 14px rgba(18, 140, 126, 0.35) !important;">
                        <i class="fab fa-whatsapp flex-shrink-0" style="font-size: 19px; margin-right: 12px !important;"></i>
                        <span>Send Slip to WhatsApp</span>
                    </a>
                </div>

                <!-- Live Tracking Button (Signature Wine/Ruby Luxury Gradient) -->
                <div class="col-12 col-sm-6">
                    <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                       class="w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center text-decoration-none transition shadow-sm"
                       style="height: 50px; padding: 0 24px; font-size: 12px; letter-spacing: 0.08em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: none !important; border-radius: 8px; box-shadow: 0 4px 14px rgba(122, 28, 51, 0.3) !important;">
                        <i class="fas fa-truck-fast flex-shrink-0" style="font-size: 16px; margin-right: 12px !important;"></i>
                        <span>Track Live Consignment</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Continue Shopping Luxury Button (Arrow Removed) -->
        <div class="text-center pt-3 pb-3">
            <a href="{{ route('collections.show', 'all') }}" 
               class="fw-bold text-uppercase tracking-wider text-decoration-none d-inline-flex align-items-center justify-content-center shadow-xs transition" 
               style="height: 48px; min-width: 260px; padding: 0 32px; font-size: 12px; letter-spacing: 0.12em; background-color: #FAF7F2; border: 1.5px solid #541B29; color: #541B29; border-radius: 8px;"
               onmouseover="this.style.background='linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%)'; this.style.color='#FFFFFF'; this.style.borderColor='transparent';"
               onmouseout="this.style.background='#FAF7F2'; this.style.color='#541B29'; this.style.borderColor='#541B29';">
                <span>Continue Shopping</span>
            </a>
        </div>
    </div>
</div>
@endsection
