@extends('layouts.app')

@section('title', 'Secure Checkout — Perfumes Collection')

@push('styles')
<style>
    .tid-input::placeholder,
    .checkout-input::placeholder {
        font-size: 11px !important;
        opacity: 0.65;
        letter-spacing: normal;
    }
    .checkout-input, 
    textarea.checkout-input {
        font-size: 12px !important;
    }
    select.checkout-select,
    .checkout-select {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        font-size: 11.5px !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        padding-left: 12px !important;
        padding-right: 32px !important;
        background-color: #FAF7F2 !important;
        border: 1px solid #E8E0DA !important;
        border-radius: 8px !important;
        color: #211D1E !important;
    }
    .checkout-input:focus, .checkout-select:focus, textarea.checkout-input:focus {
        background-color: #FFFFFF !important;
        border-color: #541B29 !important;
        box-shadow: 0 0 0 3px rgba(84, 27, 41, 0.08) !important;
    }
    .btn-gold,
    .btn-gradient {
        background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important;
        color: #FFFFFF !important;
        border: none !important;
        box-shadow: 0 4px 14px rgba(122, 28, 51, 0.3) !important;
    }
    .btn-gold:hover,
    .btn-gradient:hover {
        background: linear-gradient(135deg, #C94363 0%, #8D213C 50%, #541B29 100%) !important;
        color: #FFFFFF !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(122, 28, 51, 0.4) !important;
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
        walletType: '{{ old('wallet_type', 'easypaisa') }}',
        shippingCost: {{ $shippingCost }},
        subtotal: {{ $cart->subtotal }},
        discount: {{ $cart->discount_amount }},
        couponCode: '',
        couponLoading: false,
        couponMessage: '',
        couponSuccess: null,
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
        <div class="text-center mb-5">
            <span class="fw-semibold px-3 py-1 rounded-pill d-inline-block mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                SSL Secured 256-Bit Checkout
            </span>
            <h1 class="font-serif display-5 fw-normal mb-1" style="color: #211D1E;">Complete Your Order</h1>
            <p class="mb-0" style="font-size: 0.95rem; color: #6B605B;">Authentic artisan impressions hand-poured in Pakistan</p>
        </div>

        @if(session('error'))
            <div class="alert rounded-3 p-3 mb-4 d-flex align-items-center gap-3" style="background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #9B1C1C;">
                <i class="fas fa-exclamation-circle fs-5" style="color: #C81E1E;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert rounded-3 p-3 mb-4" style="background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #9B1C1C;">
                <div class="fw-semibold mb-1">Please review the following fields:</div>
                <ul class="mb-0 ps-3 text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4 g-lg-5">
                <!-- Left Column: Checkout Steps (col-12 col-lg-7) -->
                <div class="col-12 col-lg-7 d-flex flex-column gap-4">
                    <!-- Step 1: Customer Contact & Delivery Address -->
                    <div class="p-3 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">1</span>
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

                        <div class="d-flex flex-column gap-3">
                            <!-- Full Name & Email -->
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" id="input_name" name="customer_name" required 
                                           value="{{ old('customer_name') }}" 
                                           placeholder="e.g. Muhammad Ali"
                                           class="form-control checkout-input" 
                                           style="height: 40px; font-size: 12px; padding: 0 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Email Address (Order Confirmation) <span class="text-danger">*</span></label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email') }}" 
                                           placeholder="e.g. name@example.com"
                                           class="form-control checkout-input" 
                                           style="height: 40px; font-size: 12px; padding: 0 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                </div>
                            </div>

                            <!-- Mobile Contact -->
                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Pakistani Mobile Contact (03XX-XXXXXXX) <span class="text-danger">*</span></label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone') }}" 
                                       placeholder="e.g. 03001234567"
                                       class="form-control font-mono checkout-input" 
                                       style="height: 40px; font-size: 12px; padding: 0 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                <small class="d-block mt-1 text-muted" style="font-size: 11px;">
                                    <i class="fas fa-info-circle me-1" style="color: #541B29;"></i>Courier rider will call you on this active number prior to doorstep delivery.
                                </small>
                            </div>

                            <!-- Province & City -->
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Province / Region <span class="text-danger">*</span></label>
                                    <select name="province" x-model="province" required 
                                            class="form-select checkout-select" 
                                            style="height: 38px; min-height: 38px; font-size: 11.5px; padding: 0 30px 0 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; cursor: pointer;">
                                        <option value="" disabled :selected="!province">Select Province</option>
                                        @foreach($provinces as $prov => $cities)
                                            <option value="{{ $prov }}">{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">City in Pakistan <span class="text-danger">*</span></label>
                                    <select name="city" x-model="city" required 
                                            class="form-select checkout-select" 
                                            style="height: 38px; min-height: 38px; font-size: 11.5px; padding: 0 30px 0 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; cursor: pointer;">
                                        <option value="" disabled :selected="!city">Select City</option>
                                        <template x-for="c in getCities()" :key="c">
                                            <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Street Address / House / Flat Number <span class="text-danger">*</span></label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address') }}" 
                                       placeholder="e.g. House #, Street #, Apartment"
                                       class="form-control checkout-input" 
                                       style="height: 40px; font-size: 12px; padding: 0 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>

                            <!-- Area / Sector / Landmark -->
                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Area / Sector / Landmark <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span></label>
                                <input type="text" name="area" value="{{ old('area') }}" 
                                       placeholder="e.g. Area, Sector, Block or Nearest Landmark"
                                       class="form-control checkout-input" 
                                       style="height: 40px; font-size: 12px; padding: 0 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>

                            <!-- Special Delivery Instructions -->
                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Special Delivery Instructions <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span></label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Call before arrival or leave with security gate"
                                          class="form-control checkout-input" 
                                          style="font-size: 12px; padding: 10px 14px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">{{ old('order_notes') }}</textarea>
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
                    <div class="p-3.5 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3.5 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center gap-3">
                                <span class="rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">2</span>
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
                            <div class="rounded-3 p-3.5 p-sm-4 d-flex align-items-start gap-3 position-relative" 
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
                            <div class="d-flex flex-column gap-3.5">
                                <div class="rounded-3 p-3.5 p-sm-4 d-flex align-items-start gap-3" 
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
                                <div class="rounded-3 p-3.5 p-sm-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" 
                                     style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border: 1px solid #FDE68A; border-radius: 10px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #F59E0B; color: #FFFFFF;">
                                            <i class="fas fa-gift" style="font-size: 14px;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: 13px; color: #92400E;">Want FREE Delivery?</div>
                                            <div style="font-size: 12px; color: #78350F; line-height: 1.45;">
                                                Add only <strong class="fw-bold" style="color: #92400E;">Rs. {{ number_format(5000 - $cart->subtotal, 0) }}</strong> more to unlock <strong>FREE Nationwide Delivery</strong>!
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('collections.show', 'all') }}" class="btn btn-sm text-uppercase fw-semibold flex-shrink-0 text-decoration-none d-inline-flex align-items-center justify-content-center" 
                                       style="height: 36px; padding: 0 18px; font-size: 11.5px; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%); color: #FFFFFF; border-radius: 6px; box-shadow: 0 2px 8px rgba(122,28,51,0.25);">
                                        Add Flacon &rarr;
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Step 3: Payment Methods -->
                    <div class="p-3 p-sm-4 p-md-4 rounded-4 shadow-sm checkout-step-card" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">3</span>
                            <div>
                                <h2 class="font-serif fw-normal mb-0" style="font-size: 1.25rem; color: #211D1E;">Select Payment Method</h2>
                                <span class="d-block text-muted" style="font-size: 11px; margin-top: 2px;">Encrypted, safe and verified payment channels</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'cod' ? 'border: 2px solid #541B29; background-color: #FAF7F2; box-shadow: 0 4px 14px rgba(84,27,41,0.06);' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="form-check-input mt-1 flex-shrink-0" style="accent-color: #541B29; width: 17px; height: 17px; cursor: pointer;">
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Cash on Delivery (COD)</span>
                                            <span class="text-uppercase fw-bold px-2 py-0.5 rounded flex-shrink-0" style="font-size: 9.5px; letter-spacing: 0.05em; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">Nationwide</span>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">Pay cash in hand to the courier rider upon delivery at your doorstep</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Easypaisa Direct Transfer -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'wallet_transfer' ? 'border: 2px solid #541B29; background-color: #FAF7F2; box-shadow: 0 4px 14px rgba(84,27,41,0.06);' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3" @click="paymentMethod = 'wallet_transfer'">
                                    <input type="radio" name="payment_method" value="wallet_transfer" x-model="paymentMethod" class="form-check-input mt-1 flex-shrink-0" style="accent-color: #541B29; width: 17px; height: 17px; cursor: pointer;">
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Easypaisa</span>
                                            <span class="text-uppercase fw-bold px-2 py-0.5 rounded flex-shrink-0" style="font-size: 9.5px; letter-spacing: 0.05em; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">Instant</span>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">Transfer payment directly to our registered EasyPaisa account</p>
                                    </div>
                                </div>

                                <!-- Easypaisa Drawer -->
                                <div x-show="paymentMethod === 'wallet_transfer'" x-cloak class="p-3 p-sm-4 d-flex flex-column gap-3" style="background-color: #FFFFFF; border-top: 1px solid #E8E0DA; padding: 20px !important;">
                                    <input type="hidden" name="wallet_type" value="easypaisa">

                                    <!-- EasyPaisa Account Details Card -->
                                    <div class="rounded-3 shadow-xs d-flex flex-column gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; padding: 16px 18px;">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-wallet" style="color: #198754; font-size: 13px;"></i>
                                                <span class="fw-bold text-uppercase" style="font-size: 11.5px; letter-spacing: 0.04em; color: #198754;">EasyPaisa Account Details</span>
                                            </div>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5" style="font-size: 10px;">Official</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-1.5" style="border-bottom: 1px solid #E8E0DA; font-size: 12px;">
                                            <span style="color: #6B605B;">Account Title:</span>
                                            <span class="fw-semibold" style="color: #211D1E;">{{ $walletDetails['easypaisa']['account_title'] }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-1" style="font-size: 12px;">
                                            <span style="color: #6B605B;">Mobile Number:</span>
                                            <div class="d-flex align-items-center gap-2" x-data="{ copied: false }">
                                                <span class="font-mono fw-bold px-2 py-0.5 rounded" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E; font-size: 12.5px;">{{ $walletDetails['easypaisa']['account_number'] }}</span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $walletDetails['easypaisa']['account_number'] }}'); copied = true; setTimeout(() => { copied = false }, 2000)" 
                                                        class="btn btn-sm text-uppercase fw-semibold transition d-inline-flex align-items-center justify-content-center" 
                                                        style="height: 28px; min-width: 68px; padding: 0 14px; font-size: 11px; letter-spacing: 0.05em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: none !important; border-radius: 6px; box-shadow: 0 2px 8px rgba(122, 28, 51, 0.3) !important;">
                                                    <span x-text="copied ? 'Copied' : 'Copy'">Copy</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TID & Custom File Upload Inputs Row -->
                                    <div class="row g-3 pt-2">
                                        <!-- TID Input -->
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; color: #541B29;">
                                                EasyPaisa TID (Transaction ID)
                                            </label>
                                            <div class="position-relative d-flex align-items-center">
                                                <span class="position-absolute start-0 ps-3 d-flex align-items-center pointer-events-none" style="color: #7A1C33; z-index: 2;">
                                                    <i class="fas fa-receipt" style="font-size: 13px;"></i>
                                                </span>
                                                <input type="text" name="transaction_id" placeholder="e.g. 10-digit TID (from SMS)"
                                                       class="form-control font-mono tid-input" 
                                                       style="height: 44px; padding-left: 38px; padding-right: 14px; font-size: 12px; background-color: #FAF7F2; border: 1.5px solid #D4C7BD; color: #211D1E; border-radius: 8px;">
                                            </div>
                                            <small class="d-block mt-1 text-muted" style="font-size: 10.5px;">Enter 10-digit transaction ID received in SMS.</small>
                                        </div>

                                        <!-- Custom File Upload UI -->
                                        <div class="col-12 col-md-6" x-data="{ fileName: '' }">
                                            <label class="d-block text-uppercase tracking-wider mb-1.5 fw-semibold" style="font-size: 11px; color: #541B29;">
                                                Payment Screenshot <span class="fw-normal text-muted" style="text-transform: none;">(Optional)</span>
                                            </label>
                                            <div class="position-relative">
                                                <label class="d-flex align-items-center justify-content-between rounded-3 cursor-pointer transition w-100 m-0"
                                                       style="height: 44px; padding: 0 8px 0 14px; background-color: #FAF7F2; border: 1.5px dashed #D4C7BD; border-radius: 8px;">
                                                    <input type="file" name="receipt_file" accept="image/*,.pdf" 
                                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" 
                                                           style="z-index: 2;"
                                                           @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                                    <div class="d-flex align-items-center gap-2 overflow-hidden pe-2" style="z-index: 1;">
                                                        <i :class="fileName ? 'fas fa-check-circle text-success' : 'fas fa-cloud-arrow-up'" 
                                                           :style="fileName ? 'font-size: 13px;' : 'color: #541B29; font-size: 13px;'"></i>
                                                        <span class="text-truncate" style="font-size: 12px; color: #211D1E;" 
                                                              x-text="fileName ? fileName : 'Upload receipt (Image / PDF)'">
                                                            Upload receipt (Image / PDF)
                                                        </span>
                                                    </div>
                                                    <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 fw-semibold text-uppercase transition" 
                                                          style="height: 30px; padding: 0 14px; font-size: 11px; letter-spacing: 0.05em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border-radius: 6px; box-shadow: 0 2px 8px rgba(122, 28, 51, 0.3) !important; z-index: 1;"
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

                            <!-- 3. Debit / Credit Card (Visa / MasterCard / PayPak) -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'safepay' ? 'border: 2px solid #541B29; background-color: #FAF7F2; box-shadow: 0 4px 14px rgba(84,27,41,0.06);' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-3 p-sm-4 d-flex align-items-start gap-3">
                                    <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="form-check-input mt-1 flex-shrink-0" style="accent-color: #541B29; width: 17px; height: 17px; cursor: pointer;">
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1.5">
                                            <span class="fw-semibold" style="font-size: 14px; color: #211D1E;">Debit / Credit Card</span>
                                            <div class="d-flex align-items-center gap-1 font-mono fw-bold flex-shrink-0" style="font-size: 9.5px; color: #541B29;">
                                                <span class="px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">VISA</span>
                                                <span class="px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">MC</span>
                                                <span class="px-1.5 py-0.5 rounded shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA;">PAYPAK</span>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45; color: #6B605B;">256-bit encrypted card checkout powered by Safepay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-100 py-3 text-xs fw-semibold text-uppercase tracking-widest shadow-xl d-flex align-items-center justify-content-center gap-2 transition" 
                                style="height: 48px; border-radius: 8px; border: none !important; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; box-shadow: 0 4px 18px rgba(122, 28, 51, 0.35) !important;">
                            <span>Place Confirmed Order</span>
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                        <p class="text-center mt-3 mb-0" style="font-size: 11px; color: #6B605B;">
                            By placing this order, you confirm acceptance of our delivery policies and 7-day scent satisfaction guarantee.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Order Summary & Coupon (col-12 col-lg-5) -->
                <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                    <div class="p-3 p-sm-4 p-md-5 rounded-4 shadow-sm sticky-top checkout-order-summary-card" style="top: 112px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <h3 class="font-serif fs-5 fw-normal pb-3 d-flex align-items-center justify-content-between mb-0" style="color: #211D1E; border-bottom: 1px solid #E8E0DA;">
                            <span>Order Summary</span>
                            <span class="text-xs tracking-wider text-uppercase" style="color: #541B29; font-weight: 600;">({{ $cart->items->sum('quantity') }} Items)</span>
                        </h3>

                        <!-- Items List -->
                        <div class="d-flex flex-column gap-2 overflow-y-auto py-2 my-2 no-scrollbar pe-1" style="max-height: 320px;">
                            @foreach($cart->items as $item)
                                <div class="py-2 d-flex align-items-center gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div class="rounded-3 p-1 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 56px; height: 56px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                        <img src="{{ $item->bundle ? $item->bundle->image_url : $item->product->primary_image_url }}" 
                                             alt="{{ $item->bundle ? $item->bundle->name : $item->product->name }}" 
                                             class="img-fluid mh-100 object-contain">
                                    </div>

                                    <div class="flex-grow-1">
                                        <h4 class="font-serif fs-6 fw-semibold mb-0 lh-sm" style="color: #211D1E;">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h4>
                                        <p class="mb-0" style="font-size: 11px; color: #6B605B;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Artisan Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="font-mono" style="font-size: 11px; color: #6B605B;">Qty: {{ $item->quantity }} &times; <span class="fw-semibold" style="color: #541B29 !important;">Rs. {{ number_format($item->price, 0) }}</span></div>
                                    </div>
                                    <div class="text-end font-mono text-sm fw-bold" style="color: #541B29 !important;">
                                        Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Promo Code Section -->
                        <div class="pt-3" style="border-top: 1px solid #E8E0DA;">
                            @if($cart->coupon_code)
                                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between text-xs mb-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
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
                                        <input type="text" x-model="couponCode" placeholder="" 
                                               class="form-control text-xs text-uppercase font-mono checkout-input" 
                                               style="height: 38px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 12px; padding: 0 12px;">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="fw-semibold text-xs text-uppercase px-3 rounded-3 text-nowrap transition d-inline-flex align-items-center justify-content-center"
                                                style="height: 38px; border: none !important; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; box-shadow: 0 2px 8px rgba(122, 28, 51, 0.25) !important;">
                                            <span x-show="!couponLoading">Apply</span>
                                            <span x-show="couponLoading" x-cloak>...</span>
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
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>100% Extrait Oil Formulation</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-shield-halved flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>256-Bit SSL Secured</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-rotate flex-shrink-0" style="color: #9E7D3B;"></i>
                                <span>7-Day Scent Guarantee</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
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
