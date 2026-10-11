@extends('layouts.app')

@section('title', 'Secure Checkout — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" 
     style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;"
     x-data="{
        province: '{{ old('province', $defaultAddress->province ?? 'Punjab') }}',
        city: '{{ old('city', $defaultAddress->city ?? 'Lahore') }}',
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
            alert('Copied to clipboard: ' + text);
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
                    <div class="p-3 p-sm-4 p-md-5 rounded-4 shadow-sm checkout-step-card" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">1</span>
                            <h2 class="font-serif fs-4 fw-normal mb-0" style="color: #211D1E;">Contact & Delivery Address</h2>
                        </div>

                        <!-- Saved Address Quick Selector for logged in user -->
                        @if(auth()->check() && $savedAddresses->isNotEmpty())
                            <div class="mb-4 p-3 rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <label class="d-block text-xs text-uppercase tracking-wider mb-2 fw-semibold" style="color: #541B29;">Select Saved Address</label>
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
                                                    class="text-start p-3 rounded-3 text-xs w-100 shadow-sm transition btn" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                                                <div class="fw-semibold" style="color: #211D1E;">{{ $addr->recipient_name }}</div>
                                                <div class="text-truncate" style="color: #6B605B;">{{ $addr->street_address }}</div>
                                                <div style="color: #541B29; font-weight: 500;">{{ $addr->city }}, {{ $addr->province }}</div>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-3 text-xs">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Full Name *</label>
                                    <input type="text" id="input_name" name="customer_name" required 
                                           value="{{ old('customer_name', auth()->user()->name ?? ($defaultAddress->recipient_name ?? '')) }}" 
                                           placeholder="e.g. Syed Daniyal Ahmed"
                                           class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Email Address (Order Confirmation) *</label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                           placeholder="patron@domain.com"
                                           class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                </div>
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Pakistani Mobile Contact (03XX-XXXXXXX) *</label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone', auth()->user()->phone ?? ($defaultAddress->phone ?? '')) }}" 
                                       placeholder="e.g. 03001234567"
                                       class="form-control text-xs py-2 px-3 font-mono" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                <p class="mt-1 mb-0" style="font-size: 11px; color: #6B605B;">Courier rider will call you on this active number prior to doorstep delivery.</p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Province / Region *</label>
                                    <select name="province" x-model="province" required 
                                            class="form-select text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        @foreach($provinces as $prov => $cities)
                                            <option value="{{ $prov }}">{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">City in Pakistan *</label>
                                    <select name="city" x-model="city" required 
                                            class="form-select text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        <template x-for="c in getCities()" :key="c">
                                            <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Street Address / House / Flat Number *</label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address', $defaultAddress->street_address ?? '') }}" 
                                       placeholder="e.g. House # 42-A, Street 14"
                                       class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Area / Sector / Block (Optional)</label>
                                <input type="text" name="area" value="{{ old('area') }}" 
                                       placeholder="e.g. DHA Phase 5 / Gulberg / Bahria Town"
                                       class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Special Delivery Instructions (Optional)</label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Please call before arriving or leave with security gate."
                                          class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">{{ old('order_notes') }}</textarea>
                            </div>

                            @if(auth()->check())
                                <div class="pt-2 d-flex align-items-center gap-2">
                                    <input type="checkbox" id="save_address" name="save_address" value="1" class="form-check-input m-0" style="border-color: #E8E0DA;">
                                    <label for="save_address" class="cursor-pointer text-xs mb-0" style="color: #6B605B;">Save this address to my account for faster checkout next time</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Payment Methods -->
                    <div class="p-3 p-sm-4 p-md-5 rounded-4 shadow-sm checkout-step-card" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            <span class="rounded-circle fw-bold text-xs d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">2</span>
                            <h2 class="font-serif fs-4 fw-normal mb-0" style="color: #211D1E;">Select Payment Method</h2>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'cod' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="form-check-input m-0 flex-shrink-0" style="accent-color: #541B29;">
                                        <div>
                                            <span class="text-sm fw-semibold" style="color: #211D1E;">Cash on Delivery (COD)</span>
                                            <p class="text-xs mb-0" style="color: #6B605B;">Pay cash in hand to the courier rider upon delivery at your doorstep</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold px-2 py-1 rounded flex-shrink-0 ms-2" style="font-size: 10px; letter-spacing: 0.05em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">Nationwide</span>
                                </div>
                            </div>

                            <!-- 2. Easypaisa Direct Transfer -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'wallet_transfer' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'">
                                <div class="p-3 d-flex align-items-center justify-content-between" @click="paymentMethod = 'wallet_transfer'">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="wallet_transfer" x-model="paymentMethod" class="form-check-input m-0 flex-shrink-0" style="accent-color: #541B29;">
                                        <div>
                                            <span class="text-sm fw-semibold" style="color: #211D1E;">Easypaisa</span>
                                            <p class="text-xs mb-0" style="color: #6B605B;">Transfer payment directly to our registered EasyPaisa account</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold px-2 py-1 rounded flex-shrink-0 ms-2" style="font-size: 10px; letter-spacing: 0.05em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">Instant</span>
                                </div>

                                <div x-show="paymentMethod === 'wallet_transfer'" x-cloak class="p-4 d-flex flex-column gap-3 text-xs" style="background-color: #FFFFFF; border-top: 1px solid #E8E0DA;">
                                    <input type="hidden" name="wallet_type" value="easypaisa">

                                    <!-- EasyPaisa Account Card -->
                                    <div class="p-3 rounded-3 d-flex flex-column gap-2 shadow-sm" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                        <div class="text-sm fw-bold mb-1" style="color: #198754;">EasyPaisa Account Details</div>
                                        <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #E8E0DA;">
                                            <span style="color: #6B605B;">Account Title:</span>
                                            <span class="fw-semibold" style="color: #211D1E;">{{ $walletDetails['easypaisa']['account_title'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-1">
                                            <span style="color: #6B605B;">Mobile Number:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="font-mono fw-bold" style="color: #211D1E;">{{ $walletDetails['easypaisa']['account_number'] }}</span>
                                                <button type="button" @click="copyText('{{ $walletDetails['easypaisa']['account_number'] }}')" class="btn btn-link p-0 text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px; color: #541B29;">Copy</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">EasyPaisa Transaction ID (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. 9876543210"
                                                   class="form-control text-xs py-2 px-3 font-mono" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider mb-1 fw-semibold" style="font-size: 11px; color: #541B29;">Payment Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="form-control text-xs py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Debit / Credit Card (Visa / MasterCard / PayPak) -->
                            <div class="rounded-3 transition overflow-hidden cursor-pointer"
                                 :style="paymentMethod === 'safepay' ? 'border: 2px solid #541B29; background-color: #FAF7F2;' : 'border: 1px solid #E8E0DA; background-color: #FFFFFF;'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="form-check-input m-0 flex-shrink-0" style="accent-color: #541B29;">
                                        <div>
                                            <span class="text-sm fw-semibold" style="color: #211D1E;">Debit / Credit Card (Visa / MasterCard / PayPak)</span>
                                            <p class="text-xs mb-0" style="color: #6B605B;">256-bit encrypted card checkout powered by Safepay</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 text-xs font-mono fw-bold flex-shrink-0 ms-2" style="color: #541B29;">
                                        <span>VISA</span> &bull; <span>MC</span> &bull; <span>PAYPAK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-100 btn-gold py-3 text-xs fw-semibold text-uppercase tracking-widest shadow-xl d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                            <span>Place Confirmed Order</span>
                            <i class="fas fa-arrow-right"></i>
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
                                        <img src="{{ asset($item->bundle ? $item->bundle->image_url : $item->product->primary_image_url) }}" 
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
                                        <input type="text" x-model="couponCode" placeholder="e.g. ROYAL10 / FIRSTORDER" 
                                               class="form-control text-xs py-2 px-3 text-uppercase font-mono" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="btn-gold fw-semibold text-xs text-uppercase px-3 py-2 rounded-3 text-nowrap">
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

                            <div class="d-flex justify-content-between" style="color: #6B605B;">
                                <span>Express Courier Delivery:</span>
                                <span class="font-mono fw-semibold" style="color: #541B29;">
                                    {{ $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
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
