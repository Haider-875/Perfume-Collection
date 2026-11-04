@extends('layouts.app')

@section('title', 'Secure Checkout — Perfumes Collection')

@push('styles')
<style>
    /* ==========================================================================
       PERFUMES COLLECTION — HAUTE PARFUMERIE LUXURY CHECKOUT MOTION & DESIGN
       ========================================================================== */

    :root {
        --lux-burgundy: #541B29;
        --lux-burgundy-light: #7A1C33;
        --lux-rose: #B83A58;
        --lux-rose-glow: rgba(184, 58, 88, 0.18);
        --lux-gold: #9E7D3B;
        --lux-gold-light: #D4AF37;
        --lux-cream: #FAF7F2;
        --lux-silk: #F7F3EE;
        --lux-border: #E8E0DA;
        --lux-charcoal: #211D1E;
        --lux-muted: #6B605B;
        --ease-luxury: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        --ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* --- Keyframe Animations --- */
    @keyframes luxuryFadeUp {
        0% {
            opacity: 0;
            transform: translateY(22px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes luxuryFadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @keyframes luxuryBadgePulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(84, 27, 41, 0.12);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(84, 27, 41, 0);
        }
    }

    @keyframes luxuryShimmer {
        0% {
            transform: translateX(-150%) skewX(-20deg);
        }
        100% {
            transform: translateX(250%) skewX(-20deg);
        }
    }

    @keyframes luxurySpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes luxuryFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    @keyframes luxuryRadioPop {
        0% {
            transform: scale(0.4);
            opacity: 0;
        }
        60% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* --- Staggered Entrance Animations --- */
    .anim-reveal {
        animation: luxuryFadeUp 0.75s var(--ease-luxury) forwards;
        opacity: 0;
        will-change: transform, opacity;
    }
    .anim-delay-header  { animation-delay: 0.04s; }
    .anim-delay-step-1  { animation-delay: 0.12s; }
    .anim-delay-step-2  { animation-delay: 0.20s; }
    .anim-delay-step-3  { animation-delay: 0.28s; }
    .anim-delay-submit  { animation-delay: 0.36s; }
    .anim-delay-summary { animation-delay: 0.18s; }

    /* --- Header Badge --- */
    .luxury-header-badge {
        animation: luxuryBadgePulse 3.5s infinite ease-in-out;
        transition: transform 0.3s var(--ease-luxury), box-shadow 0.3s ease;
    }
    .luxury-header-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(84, 27, 41, 0.12);
    }

    /* --- Checkout Step Cards --- */
    .checkout-step-card {
        border-radius: 14px !important;
        position: relative;
        background: #FFFFFF;
        transition: transform 0.35s var(--ease-luxury), box-shadow 0.35s var(--ease-luxury), border-color 0.3s ease;
    }
    .checkout-step-card:hover {
        box-shadow: 0 10px 30px rgba(84, 27, 41, 0.05) !important;
    }

    .checkout-step-badge {
        transition: transform 0.3s var(--ease-bounce), background-color 0.3s ease;
    }
    .checkout-step-card:hover .checkout-step-badge {
        transform: scale(1.08);
    }

    /* --- Form Controls & Inputs Polish --- */
    .checkout-address-fields {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .luxury-input-group {
        display: flex;
        flex-direction: column;
    }

    .luxury-input-group label {
        margin-bottom: 7px !important;
        font-size: 11px !important;
        letter-spacing: 0.05em;
        color: #541B29;
    }

    .checkout-input, 
    .checkout-select,
    textarea.checkout-input {
        width: 100%;
        font-size: 12.5px !important;
        background-color: #FAF7F2 !important;
        border: 1.5px solid #E8E0DA !important;
        border-radius: 9px !important;
        color: #211D1E !important;
        outline: none !important;
        transition: border-color 0.25s var(--ease-luxury), 
                    background-color 0.25s var(--ease-luxury), 
                    box-shadow 0.25s var(--ease-luxury), 
                    transform 0.25s var(--ease-luxury) !important;
    }

    .checkout-input {
        height: 42px !important;
        padding: 0 14px !important;
    }

    textarea.checkout-input {
        padding: 10px 14px !important;
        resize: vertical;
        min-height: 60px;
    }

    .checkout-select {
        height: 40px !important;
        min-height: 40px !important;
        max-height: 40px !important;
        font-size: 12px !important;
        padding: 0 32px 0 14px !important;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23541B29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 11px 9px !important;
    }

    .checkout-input:hover,
    .checkout-select:hover,
    textarea.checkout-input:hover {
        border-color: #D4C7BD !important;
        background-color: #FCFAF7 !important;
    }

    .checkout-input:focus, 
    .checkout-select:focus, 
    textarea.checkout-input:focus {
        background-color: #FFFFFF !important;
        border-color: #541B29 !important;
        transform: translateY(-1px);
        box-shadow: 0 0 0 3.5px rgba(84, 27, 41, 0.09), 0 3px 10px rgba(84, 27, 41, 0.04) !important;
    }

    .tid-input::placeholder,
    .checkout-input::placeholder {
        font-size: 11.5px !important;
        color: #9CA3AF !important;
        opacity: 0.75;
        letter-spacing: normal;
    }

    /* --- Payment Gateway Options --- */
    .payment-option-card {
        border-radius: 10px;
        transition: transform 0.25s var(--ease-luxury), 
                    border-color 0.25s var(--ease-luxury), 
                    background-color 0.25s var(--ease-luxury), 
                    box-shadow 0.25s var(--ease-luxury);
        cursor: pointer;
        user-select: none;
        position: relative;
        overflow: hidden;
    }
    .payment-option-card:hover {
        transform: translateY(-2px);
        border-color: #9E7D3B !important;
        box-shadow: 0 6px 18px rgba(84, 27, 41, 0.06) !important;
    }
    .payment-option-card.is-active {
        border: 2px solid #541B29 !important;
        background-color: #FAF7F2 !important;
        box-shadow: 0 4px 16px rgba(84, 27, 41, 0.07) !important;
    }

    .payment-radio-indicator {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #D4C7BD;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.25s ease, background-color 0.25s ease, transform 0.25s var(--ease-bounce);
        flex-shrink: 0;
        margin-top: 2px;
        background: #FFFFFF;
    }
    .payment-radio-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #541B29;
        transform: scale(0);
        transition: transform 0.25s var(--ease-bounce);
    }
    .payment-option-card.is-active .payment-radio-indicator {
        border-color: #541B29;
        transform: scale(1.06);
    }
    .payment-option-card.is-active .payment-radio-dot {
        transform: scale(1);
        animation: luxuryRadioPop 0.3s var(--ease-bounce);
    }

    /* --- Bank Details Card & Copy Button --- */
    .bank-details-drawer {
        padding: 20px;
    }
    .bank-details-card {
        padding: 16px 18px;
    }
    .luxury-copy-btn {
        height: 36px;
        min-width: 76px;
        padding: 0 12px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important;
        color: #FFFFFF !important;
        border: none !important;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(122, 28, 51, 0.28) !important;
        cursor: pointer;
        transition: transform 0.2s var(--ease-bounce), box-shadow 0.2s ease, background 0.25s ease !important;
    }
    .luxury-copy-btn:hover {
        transform: translateY(-1px) scale(1.02);
        box-shadow: 0 4px 12px rgba(122, 28, 51, 0.42) !important;
        filter: brightness(1.05);
    }
    .luxury-copy-btn:active {
        transform: scale(0.96);
    }
    .luxury-copy-btn.is-copied {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        box-shadow: 0 2px 8px rgba(4, 120, 87, 0.35) !important;
    }

    .receipt-upload-box {
        transition: border-color 0.25s ease, background-color 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease;
    }
    .receipt-upload-box:hover {
        border-color: #541B29 !important;
        background-color: #FFFFFF !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(84, 27, 41, 0.05);
    }

    /* --- Place Confirmed Order Button --- */
    .btn-place-order {
        position: relative;
        overflow: hidden;
        height: 50px;
        border-radius: 9px;
        border: none !important;
        background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important;
        color: #FFFFFF !important;
        box-shadow: 0 5px 20px rgba(122, 28, 51, 0.36) !important;
        transition: transform 0.25s var(--ease-luxury), box-shadow 0.25s var(--ease-luxury), filter 0.25s ease !important;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 0.12em;
    }
    .btn-place-order::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.24), transparent);
        animation: luxuryShimmer 3.8s infinite ease-in-out;
        pointer-events: none;
    }
    .btn-place-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(122, 28, 51, 0.48) !important;
        filter: brightness(1.03);
    }
    .btn-place-order:active {
        transform: scale(0.985);
    }
    .btn-place-order:disabled {
        opacity: 0.85;
        cursor: not-allowed;
        transform: none !important;
    }

    .luxury-spinner {
        display: inline-block;
        width: 17px;
        height: 17px;
        border: 2px solid rgba(255, 255, 255, 0.32);
        border-radius: 50%;
        border-top-color: #FFFFFF;
        animation: luxurySpin 0.7s linear infinite;
        vertical-align: middle;
    }

    /* --- Order Summary & Product Rows --- */
    .checkout-order-summary-card {
        border-radius: 14px !important;
        transition: box-shadow 0.35s var(--ease-luxury);
    }
    .checkout-order-summary-card:hover {
        box-shadow: 0 12px 34px rgba(84, 27, 41, 0.07) !important;
    }

    .product-item-row {
        transition: transform 0.2s var(--ease-luxury), background-color 0.2s ease;
        border-radius: 8px;
        padding: 6px 8px;
        margin: 0 -8px;
    }
    .product-item-row:hover {
        background-color: #FCFAF7;
        transform: translateX(2px);
    }
    .product-item-thumb img {
        transition: transform 0.35s var(--ease-luxury);
    }
    .product-item-row:hover .product-item-thumb img {
        transform: scale(1.08);
    }

    .btn-gold,
    .btn-gradient {
        background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important;
        color: #FFFFFF !important;
        border: none !important;
        box-shadow: 0 4px 14px rgba(122, 28, 51, 0.3) !important;
        transition: transform 0.25s var(--ease-luxury), box-shadow 0.25s var(--ease-luxury), filter 0.25s ease !important;
    }
    .btn-gold:hover,
    .btn-gradient:hover {
        background: linear-gradient(135deg, #C94363 0%, #8D213C 50%, #541B29 100%) !important;
        color: #FFFFFF !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(122, 28, 51, 0.4) !important;
    }

    /* --- Assurance Badges Hover --- */
    .assurance-badge-col {
        transition: transform 0.25s var(--ease-luxury), color 0.2s ease;
        cursor: default;
    }
    .assurance-badge-col:hover {
        transform: translateY(-2px);
        color: #211D1E !important;
    }
    .assurance-badge-col:hover i {
        transform: scale(1.18);
        color: #541B29 !important;
    }
    .assurance-badge-col i {
        transition: transform 0.25s var(--ease-bounce), color 0.25s ease;
    }

    /* --- Free Delivery Motivational Card Float --- */
    .gift-float-icon {
        animation: luxuryFloat 3s infinite ease-in-out;
    }

    /* =========================================================
       --- Mobile Screen Responsive Polish (Badges & Buttons) ---
       ========================================================= */
    @media (max-width: 767.98px) {
        /* Badges: smaller font, refined paddings & margins */
        .luxury-header-badge {
            font-size: 9px !important;
            letter-spacing: 0.16em !important;
            padding: 3.5px 10px !important;
            margin-bottom: 6px !important;
        }

        .checkout-step-badge {
            width: 24px !important;
            height: 24px !important;
            font-size: 10.5px !important;
        }

        .badge {
            font-size: 9px !important;
            padding: 2.5px 6.5px !important;
            letter-spacing: 0.02em !important;
            line-height: 1.2 !important;
            margin: 0 2px !important;
        }

        .badge.rounded-pill {
            padding: 2.5px 7.5px !important;
        }

        .badge-official {
            font-size: 8.5px !important;
            padding: 2px 6px !important;
        }

        .card-brand-badge {
            font-size: 8px !important;
            padding: 1px 4.5px !important;
            letter-spacing: 0.02em !important;
        }

        .checkout-step-card h2 {
            font-size: 1.12rem !important;
        }

        /* Buttons on Mobile */
        .btn-place-order {
            height: 48px !important;
            font-size: 11.5px !important;
            letter-spacing: 0.08em !important;
            padding: 0 14px !important;
            border-radius: 8px !important;
        }

        .free-delivery-cta-btn {
            width: 100% !important;
            height: 38px !important;
            margin-top: 6px;
        }

        .luxury-copy-btn {
            height: 34px !important;
            min-width: 68px !important;
            padding: 0 10px !important;
            font-size: 10.5px !important;
            letter-spacing: 0.03em !important;
            border-radius: 6px !important;
        }

        /* Bank Details Drawer & Card on Mobile */
        .bank-details-drawer {
            padding: 14px 12px !important;
        }
        .bank-details-card {
            padding: 12px 14px !important;
        }

        /* Assurance Badges on Mobile */
        .assurance-badge-col {
            font-size: 10px !important;
            gap: 5px !important;
        }
        .assurance-badge-col i {
            font-size: 11.5px !important;
        }
    }

    /* --- Accessibility Reduced Motion --- */
    @media (prefers-reduced-motion: reduce) {
        *, ::before, ::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
        .anim-reveal {
            opacity: 1 !important;
            transform: none !important;
        }
        .btn-place-order::before {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="py-5 min-vh-100" 
     style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;"
     x-data="{
        province: '{{ old('province', '') }}',
        city: '{{ old('city', '') }}',
        paymentMethod: '{{ old('payment_method', 'cod') }}',
        shippingCost: {{ $shippingCost }},
        subtotal: {{ $cart->subtotal }},
        discount: {{ $cart->discount_amount }},
        couponCode: '',
        couponLoading: false,
        couponMessage: '',
        couponSuccess: null,
        orderSubmitting: false,
        provincesData: {{ json_encode($provinces) }},
        getCities() {
            return this.provincesData[this.province] || [];
        },
        copyText(text) {
            navigator.clipboard.writeText(text);
        },
        applyCoupon() {
            if (!this.couponCode) return;
            this.couponLoading = true;
            this.couponMessage = '';
            fetch('{{ route('checkout.coupon.apply') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ coupon_code: this.couponCode })
            })
            .then(res => res.json())
            .then(data => {
                this.couponLoading = false;
                this.couponSuccess = data.success;
                this.couponMessage = data.message;
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(err => {
                this.couponLoading = false;
                this.couponSuccess = false;
                this.couponMessage = 'Failed to apply coupon. Please retry.';
            });
        }
     }">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <!-- Header -->
        <div class="text-center mb-5 anim-reveal anim-delay-header">
            <span class="luxury-header-badge fw-semibold px-3 py-1 rounded-pill d-inline-block mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                <i class="fas fa-lock me-1.5" style="color: #9E7D3B;"></i> SSL Secured 256-Bit Checkout
            </span>
            <h1 class="font-serif display-5 fw-normal mb-1" style="color: #211D1E; letter-spacing: -0.01em;">Complete Your Order</h1>
            <p class="mb-0" style="font-size: 0.95rem; color: #6B605B;">Authentic artisan impressions hand-poured in Pakistan</p>
        </div>

        @if(session('error'))
            <div class="alert rounded-3 p-3 mb-4 d-flex align-items-center gap-3 anim-reveal" style="background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #9B1C1C;">
                <i class="fas fa-exclamation-circle fs-5" style="color: #C81E1E;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert rounded-3 p-3 mb-4 anim-reveal" style="background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #9B1C1C;">
                <div class="fw-semibold mb-1 d-flex align-items-center gap-2">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span>Please review the following fields:</span>
                </div>
                <ul class="mb-0 ps-3 text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" @submit="orderSubmitting = true">
            @csrf

            <div class="row g-4 g-lg-5">
                <!-- Left Column: Checkout Steps (col-12 col-lg-7) -->
                <div class="col-12 col-lg-7 d-flex flex-column gap-4">
                    
                    <!-- Step 1: Customer Contact & Delivery Address -->
                    <div class="p-3 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card anim-reveal anim-delay-step-1" style="border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="checkout-step-badge rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">1</span>
                            <div>
                                <h2 class="font-serif fw-normal mb-0" style="font-size: 1.25rem; color: #211D1E;">Contact & Delivery Address</h2>
                                <span class="d-block text-muted" style="font-size: 11px; margin-top: 2px;">Where should we dispatch your luxury fragrance order?</span>
                            </div>
                        </div>

                        <!-- Saved Address Quick Selector for logged in user -->
                        @if(auth()->check() && $savedAddresses->isNotEmpty())
                            <div class="mb-4 p-3 rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <label class="d-block text-uppercase tracking-wider mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Select Saved Address</label>
                                <div class="row g-2">
                                    @foreach($savedAddresses as $addr)
                                        <div class="col-12 col-md-6">
                                            <button type="button" 
                                                    @click="
                                                        province = '{{ $addr->province }}';
                                                        city = '{{ $addr->city }}';
                                                        document.getElementById('input_name').value = '{{ $addr->recipient_name }}';
                                                        document.getElementById('input_phone').value = '{{ $addr->phone }}';
                                                        document.getElementById('input_address').value = '{{ $addr->street_address }}';
                                                    "
                                                    class="text-start p-3 rounded-3 w-100 shadow-sm transition btn" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                                                <div class="fw-semibold" style="color: #211D1E; font-size: 12.5px;">{{ $addr->recipient_name }}</div>
                                                <div class="text-truncate text-muted" style="font-size: 11.5px;">{{ $addr->street_address }}</div>
                                                <div style="color: #541B29; font-weight: 500; font-size: 11px;">{{ $addr->city }}, {{ $addr->province }}</div>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="checkout-address-fields">
                            <!-- Full Name & Email -->
                            <div class="row g-3" style="row-gap: 20px;">
                                <div class="col-12 col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="d-block text-uppercase tracking-wider fw-semibold">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" id="input_name" name="customer_name" required 
                                               value="{{ old('customer_name') }}" 
                                               placeholder="e.g. Muhammad Ali"
                                               class="form-control checkout-input">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="d-block text-uppercase tracking-wider fw-semibold">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="customer_email" required 
                                               value="{{ old('customer_email') }}" 
                                               placeholder="e.g. name@example.com"
                                               class="form-control checkout-input">
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Contact -->
                            <div class="luxury-input-group">
                                <label class="d-block text-uppercase tracking-wider fw-semibold">Pakistani Mobile Contact (03XX-XXXXXXX) <span class="text-danger">*</span></label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone') }}" 
                                       placeholder="e.g. 03001234567"
                                       class="form-control font-mono checkout-input">
                                <small class="d-block text-muted" style="font-size: 11px; margin-top: 6px;">
                                    <i class="fas fa-info-circle me-1" style="color: #541B29;"></i>Courier rider will call you on this active number prior to doorstep delivery.
                                </small>
                            </div>

                            <!-- Province & City -->
                            <div class="row g-3" style="row-gap: 20px;">
                                <div class="col-12 col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="d-block text-uppercase tracking-wider fw-semibold">Province / Region <span class="text-danger">*</span></label>
                                        <select name="province" x-model="province" required 
                                                class="form-select checkout-select">
                                            <option value="" disabled :selected="!province">Select Province</option>
                                            @foreach($provinces as $prov => $cities)
                                                <option value="{{ $prov }}">{{ $prov }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="d-block text-uppercase tracking-wider fw-semibold">City in Pakistan <span class="text-danger">*</span></label>
                                        <select name="city" x-model="city" required 
                                                class="form-select checkout-select">
                                            <option value="" disabled :selected="!city">Select City</option>
                                            <template x-for="c in getCities()" :key="c">
                                                <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div class="luxury-input-group">
                                <label class="d-block text-uppercase tracking-wider fw-semibold">Street Address / House / Flat Number <span class="text-danger">*</span></label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address') }}" 
                                       placeholder="e.g. House #, Street #, Apartment"
                                       class="form-control checkout-input">
                            </div>

                            <!-- Area / Sector / Landmark -->
                            <div class="luxury-input-group">
                                <label class="d-block text-uppercase tracking-wider fw-semibold">Area / Sector / Landmark <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span></label>
                                <input type="text" name="area" value="{{ old('area') }}" 
                                       placeholder="e.g. Area, Sector, Block or Nearest Landmark"
                                       class="form-control checkout-input">
                            </div>

                            <!-- Special Delivery Instructions -->
                            <div class="luxury-input-group">
                                <label class="d-block text-uppercase tracking-wider fw-semibold">Special Delivery Instructions <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span></label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Call before arrival or leave with security gate"
                                          class="form-control checkout-input">{{ old('order_notes') }}</textarea>
                            </div>

                            @if(auth()->check())
                                <div class="pt-2 d-flex align-items-center gap-2">
                                    <input type="checkbox" id="save_address" name="save_address" value="1" class="form-check-input m-0" style="border-color: #D4C7BD; width: 16px; height: 16px; accent-color: #541B29; cursor: pointer;">
                                    <label for="save_address" class="cursor-pointer mb-0" style="font-size: 12px; color: #6B605B;">Save this address to my account for faster checkout next time</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Delivery & Shipping Options -->
                    <div class="p-3.5 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card anim-reveal anim-delay-step-2" style="border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center gap-3">
                                <span class="checkout-step-badge rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">2</span>
                                <div>
                                    <h2 class="font-serif fw-normal mb-0" style="font-size: 1.25rem; color: #211D1E;">Delivery Method</h2>
                                    <span class="d-block text-muted" style="font-size: 11px; margin-top: 2px;">Insured express delivery across Pakistan (2-4 Working Days)</span>
                                </div>
                            </div>
                            @if($cart->subtotal >= 5000)
                                <span class="badge px-2.5 py-1 rounded-pill d-none d-sm-inline-flex align-items-center gap-1" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 11px; font-weight: 700;">
                                    <i class="fas fa-check-circle"></i> Free Delivery Unlocked
                                </span>
                            @endif
                        </div>

                        @if($cart->subtotal >= 5000)
                            <!-- Option A: Free Delivery (Active & Selected) -->
                            <div class="rounded-3 p-3 p-sm-4 d-flex align-items-start gap-3 position-relative transition" 
                                 style="border: 2px solid #047857; background-color: #F0FDF4; box-shadow: 0 4px 14px rgba(4, 120, 87, 0.08); border-radius: 10px;">
                                <input type="radio" name="shipping_method_option" value="free" checked class="form-check-input mt-1 flex-shrink-0" style="accent-color: #047857; width: 18px; height: 18px; cursor: pointer;">
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold" style="font-size: 14px; color: #064E3B;">Complimentary Express Delivery</span>
                                            <span class="badge rounded-pill px-2.5 py-0.5" style="background-color: #047857; color: #FFFFFF; font-size: 10px; letter-spacing: 0.05em;">FREE</span>
                                        </div>
                                        <span class="font-mono fw-bold text-success fs-6">Rs. 0</span>
                                    </div>
                                    <p class="mb-2 text-muted" style="font-size: 12px; line-height: 1.5; color: #374151;">
                                        Fast, tracked delivery via premium couriers (TCS / PostEx / Leopards). Complimentary because your subtotal is Rs. 5,000 or above.
                                    </p>
                                    <div class="d-flex align-items-center gap-2 pt-2" style="border-top: 1px dashed #A7F3D0; font-size: 11px; color: #047857;">
                                        <i class="fas fa-shield-halved"></i>
                                        <span>Fully insured transit with tamper-proof luxury packaging</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Option B: Standard Delivery Rs. 399 (Active & Selected) -->
                            <div class="d-flex flex-column gap-3" style="gap: 16px;">
                                <div class="rounded-3 p-3 p-sm-4 d-flex align-items-start gap-3 transition" 
                                     style="border: 2px solid #541B29; background-color: #FAF7F2; box-shadow: 0 4px 14px rgba(84,27,41,0.06); border-radius: 10px;">
                                    <input type="radio" name="shipping_method_option" value="standard" checked class="form-check-input mt-1 flex-shrink-0" style="accent-color: #541B29; width: 18px; height: 18px; cursor: pointer;">
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold" style="font-size: 14px; color: #211D1E;">Standard Express Delivery</span>
                                                <span class="badge rounded px-2 py-0.5" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29; font-size: 9.5px;">All Pakistan</span>
                                            </div>
                                            <span class="font-mono fw-bold fs-6" style="color: #541B29;">Rs. 399</span>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.5; color: #6B605B;">
                                            Nationwide express courier dispatch within 2-4 working days via TCS / PostEx / Leopards. Standard delivery charges of Rs. 399 apply on orders under Rs. 5,000.
                                        </p>
                                    </div>
                                </div>

                                <!-- Free Delivery Motivational Nudge Card -->
                                <div class="rounded-3 p-3 p-sm-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 transition" 
                                     style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border: 1px solid #FDE68A; border-radius: 10px; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.08);">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="gift-float-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #F59E0B; color: #FFFFFF; box-shadow: 0 3px 8px rgba(245, 158, 11, 0.35);">
                                            <i class="fas fa-gift" style="font-size: 14px;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: 13px; color: #92400E;">Want FREE Delivery?</div>
                                            <div style="font-size: 12px; color: #78350F; line-height: 1.45;">
                                                Add only <strong class="fw-bold" style="color: #92400E;">Rs. {{ number_format(5000 - $cart->subtotal, 0) }}</strong> more to unlock <strong>FREE Nationwide Delivery</strong>!
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('collections.show', 'all') }}" class="btn btn-sm text-uppercase fw-semibold flex-shrink-0 text-decoration-none d-inline-flex align-items-center justify-content-center btn-gradient free-delivery-cta-btn" 
                                       style="height: 36px; padding: 0 18px; font-size: 11.5px; border-radius: 6px;">
                                        Add Flacon
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Step 3: Payment Methods -->
                    <div class="p-3 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card anim-reveal anim-delay-step-3" style="border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="checkout-step-badge rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">3</span>
                            <div>
                                <h2 class="font-serif fw-normal mb-0" style="font-size: 1.25rem; color: #211D1E;">Select Payment Method</h2>
                                <span class="d-block text-muted" style="font-size: 11px; margin-top: 2px;">Encrypted, safe and verified payment channels</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="payment-option-card rounded-3"
                                 :class="paymentMethod === 'cod' ? 'is-active' : ''"
                                 :style="paymentMethod === 'cod' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="d-none">
                                    <div class="payment-radio-indicator">
                                        <div class="payment-radio-dot"></div>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Cash on Delivery (COD)</span>
                                            <span class="text-uppercase fw-bold px-2 py-0.5 rounded flex-shrink-0" style="font-size: 9.5px; letter-spacing: 0.05em; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">Nationwide</span>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">Pay cash in hand to the courier rider upon delivery at your doorstep</p>
                                    </div>
                                </div>
                            </div>

                            @if(\App\Models\Setting::get('payment_bank_enabled', '1') !== '0')
                            <!-- 2. Direct Bank Transfer (Bank Al Habib / All Banks / Raast) -->
                            <div class="payment-option-card rounded-3"
                                 :class="paymentMethod === 'bank_transfer' ? 'is-active' : ''"
                                 :style="paymentMethod === 'bank_transfer' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3" @click="paymentMethod = 'bank_transfer'">
                                    <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="d-none">
                                    <div class="payment-radio-indicator">
                                        <div class="payment-radio-dot"></div>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Bank Transfer</span>
                                            <span class="text-uppercase fw-bold px-2 py-0.5 rounded flex-shrink-0" style="font-size: 9.5px; letter-spacing: 0.05em; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">All Banks / IBAN</span>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">Transfer payment directly to our corporate bank account via any banking app or ATM</p>
                                    </div>
                                </div>

                                <!-- Bank Transfer Drawer with Smooth Transition -->
                                <div x-show="paymentMethod === 'bank_transfer'" 
                                     x-cloak 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 transform translate-y-0"
                                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                                     class="p-3 p-sm-4 d-flex flex-column gap-3 bank-details-drawer" 
                                     style="background-color: #FFFFFF; border-top: 1px solid #E8E0DA;">
                                    
                                    <!-- Bank Account Details Card -->
                                    <div class="rounded-3 shadow-xs d-flex flex-column gap-2 bank-details-card" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-building-columns" style="color: #541B29; font-size: 13px;"></i>
                                                <span class="fw-bold text-uppercase" style="font-size: 11.5px; letter-spacing: 0.04em; color: #541B29;">Bank Account Details</span>
                                            </div>
                                            <span class="badge badge-official bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5" style="font-size: 10px;">Official</span>
                                        </div>

                                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-1.5 gap-1" style="border-bottom: 1px solid #E8E0DA; font-size: 12px;">
                                            <span style="color: #6B605B; font-size: 11px;">Bank Name:</span>
                                            <span class="fw-semibold" style="color: #211D1E; font-size: 12px;">{{ $bankDetails['bank_name'] ?? 'BANK AL HABIB LIMITED' }}</span>
                                        </div>

                                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center py-1.5 gap-1" style="border-bottom: 1px solid #E8E0DA; font-size: 12px;">
                                            <span style="color: #6B605B; font-size: 11px;">Account Title:</span>
                                            <span class="fw-semibold text-uppercase" style="color: #211D1E; font-size: 12px;">{{ $bankDetails['account_title'] ?? 'PERFUMES COLLECTION' }}</span>
                                        </div>

                                        <div class="py-2" style="border-bottom: 1px solid #E8E0DA;">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span style="color: #6B605B; font-size: 11px; font-weight: 500;">IBAN (Bank Account):</span>
                                                <span class="text-muted d-none d-sm-inline" style="font-size: 10px;">Tap to copy</span>
                                            </div>
                                            <div class="d-flex align-items-stretch gap-1.5" x-data="{ copied: false }">
                                                <span class="font-mono fw-bold px-2.5 py-1.5 rounded flex-grow-1 text-break d-flex align-items-center" 
                                                      style="background-color: #FFFFFF; border: 1.5px solid #E8E0DA; color: #211D1E; font-size: 12px; letter-spacing: 0.03em; min-height: 36px;">
                                                    {{ $bankDetails['iban'] ?? 'PK04 BAHL 1209 0981 0030 0001' }}
                                                </span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ str_replace(' ', '', $bankDetails['iban'] ?? 'PK04BAHL1209098100300001') }}'); copied = true; setTimeout(() => { copied = false }, 2000)" 
                                                        class="btn text-uppercase fw-semibold luxury-copy-btn d-inline-flex align-items-center justify-content-center flex-shrink-0"
                                                        :class="{ 'is-copied': copied }"
                                                        title="Copy IBAN">
                                                    <span x-show="!copied" class="d-inline-flex align-items-center gap-1">
                                                        <i class="far fa-copy" style="font-size: 11px;"></i>
                                                        <span>Copy</span>
                                                    </span>
                                                    <span x-show="copied" x-cloak class="d-inline-flex align-items-center gap-1">
                                                        <i class="fas fa-check" style="font-size: 11px;"></i>
                                                        <span>Copied</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>

                                        @if(!empty($bankDetails['raast_id']))
                                        <div class="pt-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span style="color: #6B605B; font-size: 11px; font-weight: 500;">Raast ID:</span>
                                            </div>
                                            <div class="d-flex align-items-stretch gap-1.5" x-data="{ copied: false }">
                                                <span class="font-mono fw-semibold px-2.5 py-1.5 rounded flex-grow-1 text-break d-flex align-items-center" 
                                                      style="background-color: #FFFFFF; border: 1.5px solid #E8E0DA; color: #211D1E; font-size: 12px; min-height: 34px;">
                                                    {{ $bankDetails['raast_id'] }}
                                                </span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $bankDetails['raast_id'] }}'); copied = true; setTimeout(() => { copied = false }, 2000)" 
                                                        class="btn text-uppercase fw-semibold luxury-copy-btn d-inline-flex align-items-center justify-content-center flex-shrink-0"
                                                        :class="{ 'is-copied': copied }">
                                                    <span x-show="!copied" class="d-inline-flex align-items-center gap-1">
                                                        <i class="far fa-copy" style="font-size: 10.5px;"></i>
                                                        <span>Copy</span>
                                                    </span>
                                                    <span x-show="copied" x-cloak class="d-inline-flex align-items-center gap-1">
                                                        <i class="fas fa-check" style="font-size: 10.5px;"></i>
                                                        <span>Copied</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- TID & Custom File Upload Inputs Row -->
                                    <div class="row g-3 pt-2">
                                        <!-- TID Input -->
                                        <div class="col-12 col-md-6">
                                            <div class="luxury-input-group">
                                                <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; color: #541B29;">
                                                    Bank Reference / Transaction ID (TID)
                                                </label>
                                                <input type="text" name="transaction_id" placeholder="e.g. Bank Ref / Transaction ID"
                                                       :disabled="paymentMethod !== 'bank_transfer'"
                                                       class="form-control font-mono checkout-input tid-input">
                                                <small class="d-block mt-1 text-muted" style="font-size: 10.5px;">Enter bank transfer reference number from your receipt/app.</small>
                                            </div>
                                        </div>

                                        <!-- Custom File Upload UI -->
                                        <div class="col-12 col-md-6" x-data="{ fileName: '' }">
                                            <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; color: #541B29;">
                                                Payment Screenshot <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span>
                                            </label>
                                            <div class="position-relative">
                                                <label class="receipt-upload-box d-flex align-items-center justify-content-between rounded-3 cursor-pointer w-100 m-0"
                                                       style="height: 42px; padding: 0 8px 0 14px; background-color: #FAF7F2; border: 1.5px dashed #D4C7BD; border-radius: 9px;">
                                                    <input type="file" name="receipt_file" accept="image/*,.pdf" 
                                                           :disabled="paymentMethod !== 'bank_transfer'"
                                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" 
                                                           style="z-index: 2;"
                                                           @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                                    <div class="d-flex align-items-center gap-2 overflow-hidden pe-2" style="z-index: 1;">
                                                        <i :class="fileName ? 'fas fa-check-circle text-success' : 'fas fa-paperclip'" 
                                                           :style="fileName ? 'font-size: 13px;' : 'color: #541B29; font-size: 13px;'"></i>
                                                        <span class="text-truncate" style="font-size: 12px; color: #211D1E;" 
                                                              x-text="fileName ? fileName : 'Upload receipt (Image / PDF)'">
                                                            Upload receipt (Image / PDF)
                                                        </span>
                                                    </div>
                                                    <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 fw-semibold text-uppercase transition btn-gradient" 
                                                           style="height: 28px; padding: 0 12px; font-size: 10.5px; letter-spacing: 0.05em; border-radius: 6px; z-index: 1;"
                                                           x-text="fileName ? 'Change' : 'Browse'">
                                                        Browse
                                                    </span>
                                                </label>
                                            </div>
                                            <small class="d-block mt-1 text-muted" style="font-size: 10.5px;">Attach screenshot of transfer or PDF receipt.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 3. Debit / Credit Card (Visa / MasterCard / PayPak) -->
                            <div class="payment-option-card rounded-3"
                                 :class="paymentMethod === 'safepay' ? 'is-active' : ''"
                                 :style="paymentMethod === 'safepay' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3">
                                    <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="d-none">
                                    <div class="payment-radio-indicator">
                                        <div class="payment-radio-dot"></div>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Debit / Credit Card</span>
                                            <div class="d-flex align-items-center gap-1 font-mono fw-bold flex-shrink-0" style="font-size: 9.5px; color: #541B29;">
                                                <span class="card-brand-badge px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">VISA</span>
                                                <span class="card-brand-badge px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">MC</span>
                                                <span class="card-brand-badge px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">PAYPAK</span>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">256-bit encrypted card checkout powered by Safepay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="anim-reveal anim-delay-submit">
                        <button type="submit" 
                                :disabled="orderSubmitting"
                                class="w-100 btn-place-order text-xs fw-semibold text-uppercase tracking-widest d-flex align-items-center justify-content-center gap-2">
                            <span x-show="!orderSubmitting" class="d-inline-flex align-items-center gap-2">
                                <i class="fas fa-lock" style="font-size: 11px; opacity: 0.9;"></i>
                                <span>Place Confirmed Order</span>
                                <i class="fas fa-arrow-right ms-1" style="font-size: 11px; opacity: 0.9;"></i>
                            </span>
                            <span x-show="orderSubmitting" x-cloak class="d-inline-flex align-items-center gap-2">
                                <span class="luxury-spinner"></span>
                                <span>Securing & Placing Order...</span>
                            </span>
                        </button>
                        <p class="text-center mt-3 mb-0" style="font-size: 11px; color: #6B605B;">
                            <i class="fas fa-shield-halved me-1" style="color: #9E7D3B;"></i>
                            By placing this order, you confirm acceptance of our delivery policies and 7-day scent satisfaction guarantee.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Order Summary & Coupon (col-12 col-lg-5) -->
                <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                    <div class="p-3 p-sm-4 p-md-5 rounded-4 shadow-sm sticky-top checkout-order-summary-card anim-reveal anim-delay-summary" style="top: 112px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <h3 class="font-serif fs-5 fw-normal pb-3 d-flex align-items-center justify-content-between mb-0" style="color: #211D1E; border-bottom: 1px solid #E8E0DA;">
                            <span class="d-inline-flex align-items-center gap-2">
                                <i class="fas fa-bag-shopping" style="color: #541B29; font-size: 16px;"></i>
                                <span>Order Summary</span>
                            </span>
                            <span class="text-xs tracking-wider text-uppercase" style="color: #541B29; font-weight: 600;">({{ $cart->items->sum('quantity') }} Items)</span>
                        </h3>

                        <!-- Items List -->
                        <div class="d-flex flex-column gap-2 overflow-y-auto py-2 my-2 no-scrollbar pe-1" style="max-height: 320px;">
                            @foreach($cart->items as $item)
                                <div class="product-item-row d-flex align-items-center gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div class="product-item-thumb rounded-3 p-1 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 56px; height: 56px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                        <img src="{{ $item->bundle ? $item->bundle->image_url : $item->product->primary_image_url }}" 
                                             alt="{{ $item->bundle ? $item->bundle->name : $item->product->name }}" 
                                             class="img-fluid mh-100 object-contain">
                                    </div>

                                    <div class="flex-grow-1 min-w-0">
                                        <h4 class="font-serif fs-6 fw-semibold mb-0 lh-sm text-truncate" style="color: #211D1E;">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h4>
                                        <p class="mb-0 text-muted" style="font-size: 11px;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Artisan Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="font-mono text-muted" style="font-size: 11px;">Qty: {{ $item->quantity }} &times; <span class="fw-semibold" style="color: #541B29 !important;">Rs. {{ number_format($item->price, 0) }}</span></div>
                                    </div>
                                    <div class="text-end font-mono text-sm fw-bold flex-shrink-0" style="color: #541B29 !important;">
                                        Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Promo Code Section -->
                        <div class="pt-3" style="border-top: 1px solid #E8E0DA;">
                            @if($cart->coupon_code)
                                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between text-xs mb-3 transition" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                    <div>
                                        <span class="fw-bold font-mono" style="color: #541B29;">{{ $cart->coupon_code }}</span>
                                        <span class="ms-2" style="color: #541B29;">Discount Applied (-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-danger text-decoration-underline fw-bold" style="font-size: 11px;">Remove</a>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="d-block fw-semibold mb-1" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Discount Code / Voucher</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="ENTER CODE" 
                                               class="form-control text-xs text-uppercase font-mono checkout-input" 
                                               style="height: 38px; background-color: #FAF7F2; border: 1.5px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 12px; padding: 0 12px;">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="fw-semibold text-xs text-uppercase px-3 rounded-3 text-nowrap transition d-inline-flex align-items-center justify-content-center btn-gradient"
                                                style="height: 38px; border-radius: 8px;">
                                            <span x-show="!couponLoading">Apply</span>
                                            <span x-show="couponLoading" x-cloak class="luxury-spinner" style="width: 14px; height: 14px;"></span>
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="mt-1 mb-0" style="font-size: 11px;" :class="couponSuccess ? 'text-success' : 'text-danger'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        <!-- Financial Totals Breakdown -->
                        <div class="pt-3 d-flex flex-column gap-2 text-xs" style="border-top: 1px solid #E8E0DA;">
                            <div class="d-flex justify-content-between" style="color: #6B605B;">
                                <span>Subtotal:</span>
                                <span class="font-mono fw-semibold" style="color: #211D1E;">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>

                            @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between fw-semibold" style="color: #541B29;">
                                    <span>Voucher Discount ({{ $cart->coupon_code }}):</span>
                                    <span class="font-mono">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center" style="color: #6B605B;">
                                <span>Express Courier Delivery:</span>
                                @if($shippingCost == 0)
                                    <span class="badge px-2 py-0.5 rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 11px; font-weight: 700;">
                                        FREE
                                    </span>
                                @else
                                    <span class="font-mono fw-semibold" style="color: #541B29;">
                                        Rs. {{ number_format($shippingCost, 0) }}
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-baseline pt-3" style="border-top: 1px solid #E8E0DA;">
                                <span class="font-serif fs-5 fw-bold" style="color: #211D1E;">Total:</span>
                                <span class="font-serif fs-3 fw-bold font-mono" style="color: #541B29 !important;">
                                    Rs. {{ number_format($grandTotal, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Luxury Assurance Badges -->
                        <div class="mt-4 pt-4 row g-3" style="font-size: 11px; border-top: 1px solid #E8E0DA; color: #6B605B;">
                            <div class="col-6 d-flex align-items-center gap-2 assurance-badge-col">
                                <i class="fas fa-check-circle flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>100% Extrait Oil Formulation</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 assurance-badge-col">
                                <i class="fas fa-shield-halved flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>256-Bit SSL Secured</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 assurance-badge-col">
                                <i class="fas fa-rotate flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>7-Day Scent Guarantee</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 assurance-badge-col">
                                <i class="fas fa-truck flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>Fast Nationwide Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
