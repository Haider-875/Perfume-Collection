@extends('layouts.app')

@section('title', 'Secure Checkout — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100 border-bottom border-gold-20" 
     style="background-color: #050203;"
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
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill d-inline-block mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">
                SSL Secured 256-Bit Checkout
            </span>
            <h1 class="font-serif display-5 text-light-parchment fw-normal mb-1">Complete Your Order</h1>
            <p class="text-muted-parchment mb-0" style="font-size: 0.95rem;">Authentic artisan impressions hand-poured in Pakistan</p>
        </div>

        @if(session('error'))
            <div class="alert bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 d-flex align-items-center gap-3">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4">
                <div class="fw-semibold mb-1 text-danger-subtle">Please review the following fields:</div>
                <ul class="mb-0 ps-3 text-xs text-danger-emphasis">
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
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-gold-20">
                            <span class="rounded-circle bg-wine-accent border border-gold-40 text-gold fw-bold text-xs d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">1</span>
                            <h2 class="font-serif fs-4 text-light-parchment fw-normal mb-0">Contact & Delivery Address</h2>
                        </div>

                        <!-- Saved Address Quick Selector for logged in user -->
                        @if(auth()->check() && $savedAddresses->isNotEmpty())
                            <div class="mb-4 p-3 bg-wine-accent border border-gold-30 rounded-3">
                                <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-2 fw-semibold">Select Saved Address</label>
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
                                                        document.getElementById('input_postal').value = '{{ $addr->postal_code }}';
                                                    "
                                                    class="text-start p-3 border border-gold-25 rounded-3 bg-wine-dark text-xs w-100 shadow-sm transition btn text-light-parchment">
                                                <div class="fw-semibold text-light-parchment">{{ $addr->recipient_name }}</div>
                                                <div class="text-muted-parchment text-truncate">{{ $addr->street_address }}</div>
                                                <div class="text-gold">{{ $addr->city }}, {{ $addr->province }}</div>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-3 text-xs">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Full Name *</label>
                                    <input type="text" id="input_name" name="customer_name" required 
                                           value="{{ old('customer_name', auth()->user()->name ?? ($defaultAddress->recipient_name ?? '')) }}" 
                                           placeholder="e.g. Syed Daniyal Ahmed"
                                           class="form-control form-control-luxury text-xs py-2 px-3">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Email Address (Order Confirmation) *</label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                           placeholder="patron@domain.com"
                                           class="form-control form-control-luxury text-xs py-2 px-3">
                                </div>
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Pakistani Mobile Contact (03XX-XXXXXXX) *</label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone', auth()->user()->phone ?? ($defaultAddress->phone ?? '')) }}" 
                                       placeholder="e.g. 03001234567"
                                       class="form-control form-control-luxury text-xs py-2 px-3 font-mono">
                                <p class="text-muted-parchment mt-1 mb-0" style="font-size: 11px;">Courier rider will call you on this active number prior to doorstep delivery.</p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Province / Region *</label>
                                    <select name="province" x-model="province" required 
                                            class="form-select form-control-luxury text-xs py-2 px-3">
                                        @foreach($provinces as $prov => $cities)
                                            <option value="{{ $prov }}" class="bg-wine-dark text-light-parchment">{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">City in Pakistan *</label>
                                    <select name="city" x-model="city" required 
                                            class="form-select form-control-luxury text-xs py-2 px-3">
                                        <template x-for="c in getCities()" :key="c">
                                            <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city" class="bg-wine-dark text-light-parchment"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Street Address / House / Flat Number *</label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address', $defaultAddress->street_address ?? '') }}" 
                                       placeholder="e.g. House # 42-A, Street 14"
                                       class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Area / Sector / Block</label>
                                    <input type="text" name="area" value="{{ old('area') }}" 
                                           placeholder="e.g. DHA Phase 5 / Gulberg"
                                           class="form-control form-control-luxury text-xs py-2 px-3">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Prominent Landmark</label>
                                    <input type="text" name="landmark" value="{{ old('landmark') }}" 
                                           placeholder="e.g. Near Siddiq Trade Centre"
                                           class="form-control form-control-luxury text-xs py-2 px-3">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Postal Code</label>
                                    <input type="text" id="input_postal" name="postal_code" value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}" 
                                           placeholder="e.g. 54000"
                                           class="form-control form-control-luxury text-xs py-2 px-3 font-mono">
                                </div>
                            </div>

                            <div>
                                <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Special Delivery Instructions (Optional)</label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Please call before arriving or leave with security gate."
                                          class="form-control form-control-luxury text-xs py-2 px-3">{{ old('order_notes') }}</textarea>
                            </div>

                            @if(auth()->check())
                                <div class="pt-2 d-flex align-items-center gap-2">
                                    <input type="checkbox" id="save_address" name="save_address" value="1" class="form-check-input bg-transparent border-gold-40 m-0">
                                    <label for="save_address" class="text-muted-parchment cursor-pointer text-xs mb-0">Save this address to my account for faster checkout next time</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Courier Logistics Service -->
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-gold-20">
                            <span class="rounded-circle bg-wine-accent border border-gold-40 text-gold fw-bold text-xs d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">2</span>
                            <h2 class="font-serif fs-4 text-light-parchment fw-normal mb-0">Nationwide Express Delivery</h2>
                        </div>

                        <div class="p-3 bg-wine-accent border border-gold-30 rounded-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-wine-dark border border-gold-30 d-flex align-items-center justify-content-center text-gold" style="width: 40px; height: 40px;">
                                    <i class="fas fa-truck-fast"></i>
                                </div>
                                <div>
                                    <div class="text-sm fw-semibold text-light-parchment">Tracked Courier (TCS / Leopards / PostEx / Trax)</div>
                                    <div class="text-xs text-muted-parchment">Guaranteed delivery within 2-4 business days across Pakistan</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="font-serif fs-6 text-gold-soft fw-bold">
                                    {{ $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Payment Methods -->
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-gold-20">
                            <span class="rounded-circle bg-wine-accent border border-gold-40 text-gold fw-bold text-xs d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">3</span>
                            <h2 class="font-serif fs-4 text-light-parchment fw-normal mb-0">Select Payment Method</h2>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'cod' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">Cash on Delivery (COD)</span>
                                            <p class="text-xs text-muted-parchment mb-0">Pay cash in hand to the courier rider upon delivery at your doorstep</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold text-gold-soft px-2 py-1 bg-wine-dark border border-gold-30 rounded" style="font-size: 10px; letter-spacing: 0.05em;">Nationwide</span>
                                </div>
                            </div>

                            <!-- 2. Direct Bank Transfer / Raast -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'bank_transfer' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'">
                                <div class="p-3 d-flex align-items-center justify-content-between" @click="paymentMethod = 'bank_transfer'">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">Direct Bank Transfer / Raast Instant</span>
                                            <p class="text-xs text-muted-parchment mb-0">Transfer via Bank App, ATM, or Raast with instant confirmation</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold text-muted-parchment px-2 py-1 bg-wine-dark border border-gold-20 rounded" style="font-size: 10px; letter-spacing: 0.05em;">Manual</span>
                                </div>

                                <!-- Bank Transfer Details Drawer -->
                                <div x-show="paymentMethod === 'bank_transfer'" x-cloak class="p-4 bg-wine-card border-top border-gold-20 d-flex flex-column gap-3 text-xs">
                                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-25 d-flex flex-column gap-2 shadow-sm">
                                        <div class="font-serif fs-6 text-gold-soft fw-bold mb-1">Perfumes Collection Official Bank Details</div>
                                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-gold-20">
                                            <span class="text-muted-parchment">Bank Name:</span>
                                            <span class="fw-semibold text-light-parchment">{{ $bankDetails['bank_name'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-gold-20">
                                            <span class="text-muted-parchment">Account Title:</span>
                                            <span class="fw-semibold text-light-parchment">{{ $bankDetails['account_title'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-gold-20">
                                            <span class="text-muted-parchment">Account Number:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="font-mono text-light-parchment fw-bold">{{ $bankDetails['account_number'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['account_number'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-gold-20">
                                            <span class="text-muted-parchment">IBAN:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="font-mono text-light-parchment fw-bold">{{ $bankDetails['iban'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['iban'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center py-1">
                                            <span class="text-muted-parchment">Raast Instant ID:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="font-mono text-gold-soft fw-bold">{{ $bankDetails['raast_id'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['raast_id'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Bank Transaction ID / Reference (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. FT261003894"
                                                   class="form-control form-control-luxury text-xs py-2 px-3 font-mono">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Attach Transfer Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="form-control form-control-luxury text-xs py-2 px-3">
                                        </div>
                                    </div>
                                    <p class="text-muted-parchment fst-italic mb-0" style="font-size: 11px;">
                                        * You can also upload your receipt later or send it to our WhatsApp concierge after placing your order.
                                    </p>
                                </div>
                            </div>

                            <!-- 3. Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay) -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'wallet_transfer' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'">
                                <div class="p-3 d-flex align-items-center justify-content-between" @click="paymentMethod = 'wallet_transfer'">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="wallet_transfer" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay)</span>
                                            <p class="text-xs text-muted-parchment mb-0">Send money directly to our registered merchant mobile account</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold text-gold-soft px-2 py-1 bg-wine-dark border border-gold-30 rounded" style="font-size: 10px; letter-spacing: 0.05em;">Instant</span>
                                </div>

                                <div x-show="paymentMethod === 'wallet_transfer'" x-cloak class="p-4 bg-wine-card border-top border-gold-20 d-flex flex-column gap-3 text-xs">
                                    <!-- Wallet Selector Tabs -->
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" @click="walletType = 'easypaisa'" 
                                                :class="walletType === 'easypaisa' ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark text-muted-parchment border-gold-25'"
                                                class="btn px-3 py-1-5 rounded-3 text-xs text-uppercase tracking-wider transition border">
                                            EasyPaisa
                                        </button>
                                        <button type="button" @click="walletType = 'jazzcash'" 
                                                :class="walletType === 'jazzcash' ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark text-muted-parchment border-gold-25'"
                                                class="btn px-3 py-1-5 rounded-3 text-xs text-uppercase tracking-wider transition border">
                                            JazzCash
                                        </button>
                                        <button type="button" @click="walletType = 'sadapay'" 
                                                :class="walletType === 'sadapay' ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark text-muted-parchment border-gold-25'"
                                                class="btn px-3 py-1-5 rounded-3 text-xs text-uppercase tracking-wider transition border">
                                            SadaPay
                                        </button>
                                        <button type="button" @click="walletType = 'nayapay'" 
                                                :class="walletType === 'nayapay' ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark text-muted-parchment border-gold-25'"
                                                class="btn px-3 py-1-5 rounded-3 text-xs text-uppercase tracking-wider transition border">
                                            NayaPay
                                        </button>
                                    </div>
                                    <input type="hidden" name="wallet_type" :value="walletType">

                                    <!-- Wallet Account Card -->
                                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-25 d-flex flex-column gap-2 shadow-sm">
                                        <template x-if="walletType === 'easypaisa'">
                                            <div>
                                                <div class="text-sm text-success fw-bold mb-1">EasyPaisa Account Details</div>
                                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                                    <span class="text-muted-parchment">Account Title:</span>
                                                    <span class="fw-semibold text-light-parchment">{{ $walletDetails['easypaisa']['account_title'] }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="text-muted-parchment">Mobile Number:</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="font-mono text-light-parchment fw-bold">{{ $walletDetails['easypaisa']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['easypaisa']['account_number'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'jazzcash'">
                                            <div>
                                                <div class="text-sm text-warning fw-bold mb-1">JazzCash Account Details</div>
                                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                                    <span class="text-muted-parchment">Account Title:</span>
                                                    <span class="fw-semibold text-light-parchment">{{ $walletDetails['jazzcash']['account_title'] }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="text-muted-parchment">Mobile Number:</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="font-mono text-light-parchment fw-bold">{{ $walletDetails['jazzcash']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['jazzcash']['account_number'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'sadapay'">
                                            <div>
                                                <div class="text-sm text-info fw-bold mb-1">SadaPay Account Details</div>
                                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                                    <span class="text-muted-parchment">Account Title:</span>
                                                    <span class="fw-semibold text-light-parchment">{{ $walletDetails['sadapay']['account_title'] }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="text-muted-parchment">Account / IBAN:</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="font-mono text-light-parchment fw-bold">{{ $walletDetails['sadapay']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['sadapay']['account_number'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'nayapay'">
                                            <div>
                                                <div class="text-sm text-warning-emphasis fw-bold mb-1">NayaPay Account Details</div>
                                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                                    <span class="text-muted-parchment">Account Title:</span>
                                                    <span class="fw-semibold text-light-parchment">{{ $walletDetails['nayapay']['account_title'] }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="text-muted-parchment">NayaPay ID:</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="font-mono text-light-parchment fw-bold">{{ $walletDetails['nayapay']['nayapay_id'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['nayapay']['nayapay_id'] }}')" class="btn btn-link p-0 text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Wallet Transaction ID (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. 9876543210"
                                                   class="form-control form-control-luxury text-xs py-2 px-3 font-mono">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="d-block text-uppercase tracking-wider text-gold mb-1 fw-semibold" style="font-size: 11px;">Payment Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="form-control form-control-luxury text-xs py-2 px-3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. JazzCash Online Gateway (Instant) -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'jazzcash' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'"
                                 @click="paymentMethod = 'jazzcash'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="jazzcash" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">JazzCash Online Gateway (Instant MPIN / Card)</span>
                                            <p class="text-xs text-muted-parchment mb-0">Pay directly from your JazzCash wallet via MPIN prompt or Debit Card</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold text-gold-soft px-2 py-1 bg-wine-dark border border-gold-30 rounded" style="font-size: 10px; letter-spacing: 0.05em;">Automated</span>
                                </div>
                            </div>

                            <!-- 5. EasyPaisa Online Gateway (Instant) -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'easypaisa' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'"
                                 @click="paymentMethod = 'easypaisa'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="easypaisa" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">EasyPaisa Online Gateway (Instant OTP)</span>
                                            <p class="text-xs text-muted-parchment mb-0">Hosted EasyPaisa payment gateway with real-time verification</p>
                                        </div>
                                    </div>
                                    <span class="text-uppercase fw-bold text-gold-soft px-2 py-1 bg-wine-dark border border-gold-30 rounded" style="font-size: 10px; letter-spacing: 0.05em;">Automated</span>
                                </div>
                            </div>

                            <!-- 6. Debit / Credit Card (Safepay) -->
                            <div class="border rounded-3 transition overflow-hidden cursor-pointer"
                                 :class="paymentMethod === 'safepay' ? 'border-gold bg-wine-accent' : 'border-gold-20 bg-wine-dark'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="form-check-input bg-transparent border-gold-40 m-0">
                                        <div>
                                            <span class="text-sm fw-semibold text-light-parchment">Debit / Credit Card (Visa / MasterCard / PayPak)</span>
                                            <p class="text-xs text-muted-parchment mb-0">256-bit encrypted card checkout powered by Safepay</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 text-xs text-gold font-mono fw-bold">
                                        <span>VISA</span> &bull; <span>MC</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full btn-gold py-3 text-xs fw-semibold text-uppercase tracking-widest shadow-xl d-flex align-items-center justify-content-center gap-2">
                            <span>Place Confirmed Order</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        <p class="text-muted-parchment text-center mt-3 mb-0" style="font-size: 11px;">
                            By placing this order, you confirm acceptance of our delivery policies and 7-day scent satisfaction guarantee.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Order Summary & Coupon (col-12 col-lg-5) -->
                <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl sticky-top" style="top: 112px;">
                        <h3 class="font-serif fs-5 text-light-parchment fw-normal pb-3 border-bottom border-gold-20 d-flex align-items-center justify-content-between mb-0">
                            <span>Order Summary</span>
                            <span class="text-xs tracking-wider text-gold text-uppercase">({{ $cart->items->sum('quantity') }} Items)</span>
                        </h3>

                        <!-- Items List -->
                        <div class="d-flex flex-column gap-2 overflow-y-auto py-2 my-2 no-scrollbar pe-1" style="max-height: 320px;">
                            @foreach($cart->items as $item)
                                <div class="py-2 d-flex align-items-center gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-20' : '' }}">
                                    <div class="bg-wine-dark rounded-3 border border-gold-25 p-1 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 56px; height: 56px;">
                                        <img src="{{ asset($item->bundle ? $item->bundle->image_url : $item->product->primary_image_url) }}" 
                                             alt="{{ $item->bundle ? $item->bundle->name : $item->product->name }}" 
                                             class="img-fluid mh-100 object-contain">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="font-serif fs-6 text-light-parchment fw-semibold mb-0 lh-sm">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h4>
                                        <p class="text-gold mb-0" style="font-size: 11px;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Artisan Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="text-muted-parchment font-mono" style="font-size: 11px;">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 0) }}</div>
                                    </div>
                                    <div class="text-end font-mono text-sm text-gold-soft fw-bold">
                                        Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Promo Code Section -->
                        <div class="pt-3 border-top border-gold-20">
                            @if($cart->coupon_code)
                                <div class="p-3 bg-wine-accent border border-gold-30 rounded-3 d-flex align-items-center justify-content-between text-xs mb-3">
                                    <div>
                                        <span class="text-gold-soft fw-bold font-mono">{{ $cart->coupon_code }}</span>
                                        <span class="text-gold ms-2">Discount Applied (-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-danger text-decoration-underline fw-bold" style="font-size: 11px;">Remove</a>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="d-block text-gold fw-semibold mb-1" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Discount Code / Voucher</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. ROYAL10 / FIRSTORDER" 
                                               class="form-control form-control-luxury text-xs py-2 px-3 text-uppercase font-mono">
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
                        <div class="pt-3 border-top border-gold-20 d-flex flex-column gap-2 text-xs">
                            <div class="d-flex justify-content-between text-muted-parchment">
                                <span>Subtotal:</span>
                                <span class="font-mono text-light-parchment fw-semibold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>

                            @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between text-gold-soft fw-semibold">
                                    <span>Voucher Discount ({{ $cart->coupon_code }}):</span>
                                    <span class="font-mono">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between text-muted-parchment">
                                <span>Express Courier Delivery:</span>
                                <span class="font-mono text-gold fw-semibold">
                                    {{ $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-baseline pt-3 border-top border-gold-20">
                                <span class="font-serif fs-5 text-light-parchment fw-bold">Total:</span>
                                <span class="font-serif fs-3 fw-bold text-gold-soft font-mono">
                                    Rs. {{ number_format($grandTotal, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Luxury Assurance Badges -->
                        <div class="mt-4 pt-4 border-top border-gold-20 row g-3 text-muted-parchment" style="font-size: 11px;">
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-gold flex-shrink-0"></i>
                                <span>100% Extrait Oil Formulation</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-shield-halved text-gold flex-shrink-0"></i>
                                <span>256-Bit SSL Secured</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-rotate text-gold flex-shrink-0"></i>
                                <span>7-Day Scent Guarantee</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-truck text-gold flex-shrink-0"></i>
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
