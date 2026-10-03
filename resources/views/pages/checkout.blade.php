@extends('layouts.app')

@section('title', 'Haute Parfumerie Checkout — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen" 
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
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Breadcrumb / Header -->
        <div class="text-center mb-10">
            <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-3">
                Secure 256-Bit SSL Encrypted Dossier
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-brand-gold font-light">Bespoke Checkout</h1>
        </div>

        @if(session('error'))
            <div class="mb-8 p-4 bg-red-950/60 border border-red-500/40 text-red-200 text-sm rounded-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-950/60 border border-red-500/40 text-red-200 text-sm rounded-sm">
                <div class="font-semibold mb-1 text-red-300">Please review the following requirements:</div>
                <ul class="list-disc list-inside space-y-1 text-xs text-red-200/90">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Left Column: Checkout Steps -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Step 1: Patron Contact & Delivery Address -->
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl relative">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                            <span class="w-7 h-7 rounded-full bg-brand-gold text-black font-bold text-xs flex items-center justify-center">1</span>
                            <h2 class="font-serif text-xl md:text-2xl text-brand-gold font-light">Patron Information & Delivery Address</h2>
                        </div>

                        <!-- Saved Address Quick Selector for logged in user -->
                        @if(auth()->check() && $savedAddresses->isNotEmpty())
                            <div class="mb-6 p-4 bg-black/40 border border-brand-gold/30 rounded-sm">
                                <label class="block text-xs uppercase tracking-[0.2em] text-brand-gold mb-2 font-medium">Select Saved Address</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($savedAddresses as $addr)
                                        <button type="button" 
                                                @click="
                                                    province = '{{ $addr->province }}';
                                                    city = '{{ $addr->city }}';
                                                    document.getElementById('input_name').value = '{{ $addr->recipient_name }}';
                                                    document.getElementById('input_phone').value = '{{ $addr->phone }}';
                                                    document.getElementById('input_address').value = '{{ $addr->street_address }}';
                                                    document.getElementById('input_postal').value = '{{ $addr->postal_code }}';
                                                "
                                                class="text-left p-3 border border-white/10 hover:border-brand-gold rounded bg-black/60 text-xs transition-all">
                                            <div class="font-semibold text-brand-gold">{{ $addr->recipient_name }}</div>
                                            <div class="text-brand-ivory/70 truncate">{{ $addr->street_address }}</div>
                                            <div class="text-brand-ivory/50">{{ $addr->city }}, {{ $addr->province }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4 text-xs">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Full Name *</label>
                                    <input type="text" id="input_name" name="customer_name" required 
                                           value="{{ old('customer_name', auth()->user()->name ?? ($defaultAddress->recipient_name ?? '')) }}" 
                                           placeholder="e.g. Syed Daniyal Ahmed"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Email Address (Dispatch Dossier) *</label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                           placeholder="patron@domain.com"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Pakistani Mobile Contact (+92 / 03XX) *</label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone', auth()->user()->phone ?? ($defaultAddress->phone ?? '')) }}" 
                                       placeholder="e.g. 0300 1234567"
                                       class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm font-mono">
                                <p class="text-[10px] text-brand-ivory/40 mt-1">Courier rider will contact you on this active phone prior to doorstep delivery.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Province / Region *</label>
                                    <select name="province" x-model="province" required 
                                            class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory focus:border-brand-gold focus:outline-none rounded-sm">
                                        @foreach($provinces as $prov => $cities)
                                            <option value="{{ $prov }}">{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">City in Pakistan *</label>
                                    <select name="city" x-model="city" required 
                                            class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory focus:border-brand-gold focus:outline-none rounded-sm">
                                        <template x-for="c in getCities()" :key="c">
                                            <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Street Address / House / Flat Number *</label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address', $defaultAddress->street_address ?? '') }}" 
                                       placeholder="e.g. House # 42-A, Street 14"
                                       class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Area / Sector / Block</label>
                                    <input type="text" name="area" value="{{ old('area') }}" 
                                           placeholder="e.g. DHA Phase 5 / Gulberg"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Prominent Landmark</label>
                                    <input type="text" name="landmark" value="{{ old('landmark') }}" 
                                           placeholder="e.g. Near Siddiq Trade Centre"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Postal Code</label>
                                    <input type="text" id="input_postal" name="postal_code" value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}" 
                                           placeholder="e.g. 54000"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm font-mono">
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Special Delivery Instructions</label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Please ring bell twice or leave with concierge."
                                          class="w-full bg-black/60 border border-brand-gold/30 px-4 py-2.5 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">{{ old('order_notes') }}</textarea>
                            </div>

                            @if(auth()->check())
                                <div class="pt-2 flex items-center gap-2">
                                    <input type="checkbox" id="save_address" name="save_address" value="1" class="accent-brand-gold w-4 h-4">
                                    <label for="save_address" class="text-brand-ivory/80 cursor-pointer">Save this address to my luxury account for future orders</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Courier Logistics Service -->
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                            <span class="w-7 h-7 rounded-full bg-brand-gold text-black font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="font-serif text-xl md:text-2xl text-brand-gold font-light">White-Glove Courier Logistics</h2>
                        </div>

                        <div class="p-4 bg-black/40 border border-brand-gold/40 rounded flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-brand-ivory">Insured Express Courier (TCS / Leopards / PostEx / Trax)</div>
                                    <div class="text-xs text-brand-ivory/50">Guaranteed nationwide 2-4 business days air/surface delivery</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-serif text-base text-brand-gold font-semibold">
                                    {{ $shippingCost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Pluggable Payment Methods -->
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                            <span class="w-7 h-7 rounded-full bg-brand-gold text-black font-bold text-xs flex items-center justify-center">3</span>
                            <h2 class="font-serif text-xl md:text-2xl text-brand-gold font-light">Select Payment Method</h2>
                        </div>

                        <div class="space-y-4">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'cod' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">Cash on Delivery (COD)</span>
                                            <p class="text-xs text-brand-ivory/50">Pay in cash to the delivery rider at your doorstep</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-wider text-brand-gold px-2.5 py-1 bg-brand-gold/10 rounded border border-brand-gold/30">Nationwide</span>
                                </div>
                            </div>

                            <!-- 2. Direct Bank Transfer / Raast -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'bank_transfer' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'">
                                <div class="p-4 flex items-center justify-between" @click="paymentMethod = 'bank_transfer'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">Direct Bank Transfer / Raast</span>
                                            <p class="text-xs text-brand-ivory/50">Transfer to Bank Alfalah account via Online Banking, ATM, or Raast</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-wider text-brand-gold px-2.5 py-1 bg-brand-gold/10 rounded border border-brand-gold/30">Manual</span>
                                </div>

                                <!-- Bank Transfer Details Drawer -->
                                <div x-show="paymentMethod === 'bank_transfer'" x-cloak class="p-5 bg-black/70 border-t border-brand-gold/20 space-y-4 text-xs">
                                    <div class="bg-[#12070a] p-4 rounded border border-brand-gold/30 space-y-2">
                                        <div class="font-serif text-sm text-brand-gold font-semibold mb-2">Corporate Bank Coordinates</div>
                                        <div class="flex justify-between items-center py-1 border-b border-white/5">
                                            <span class="text-brand-ivory/60">Bank Name:</span>
                                            <span class="font-semibold text-brand-ivory">{{ $bankDetails['bank_name'] }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1 border-b border-white/5">
                                            <span class="text-brand-ivory/60">Account Title:</span>
                                            <span class="font-semibold text-brand-ivory">{{ $bankDetails['account_title'] }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1 border-b border-white/5">
                                            <span class="text-brand-ivory/60">Account Number:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-brand-gold font-semibold">{{ $bankDetails['account_number'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['account_number'] }}')" class="text-[10px] text-brand-gold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center py-1 border-b border-white/5">
                                            <span class="text-brand-ivory/60">IBAN:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-brand-gold font-semibold">{{ $bankDetails['iban'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['iban'] }}')" class="text-[10px] text-brand-gold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span class="text-brand-ivory/60">Raast Instant ID:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-brand-gold font-semibold">{{ $bankDetails['raast_id'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['raast_id'] }}')" class="text-[10px] text-brand-gold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Bank Transaction Reference / TID</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. FT261003894"
                                                   class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2.5 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded font-mono">
                                        </div>
                                        <div>
                                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Attach Transfer Screenshot / Receipt</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory/70 text-xs focus:border-brand-gold rounded file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-brand-gold file:text-black file:font-semibold">
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-brand-ivory/50 italic">
                                        * You can also upload your payment receipt later from your customer account order history.
                                    </p>
                                </div>
                            </div>

                            <!-- 3. Mobile Wallets (JazzCash / EasyPaisa / SadaPay / NayaPay) -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'wallet_transfer' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'">
                                <div class="p-4 flex items-center justify-between" @click="paymentMethod = 'wallet_transfer'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="wallet_transfer" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay)</span>
                                            <p class="text-xs text-brand-ivory/50">Send payment directly from your mobile wallet application</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-wider text-brand-gold px-2.5 py-1 bg-brand-gold/10 rounded border border-brand-gold/30">Instant</span>
                                </div>

                                <div x-show="paymentMethod === 'wallet_transfer'" x-cloak class="p-5 bg-black/70 border-t border-brand-gold/20 space-y-4 text-xs">
                                    <!-- Wallet Selector Tabs -->
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" @click="walletType = 'easypaisa'" 
                                                :class="walletType === 'easypaisa' ? 'bg-brand-gold text-black font-bold' : 'bg-black/60 text-brand-ivory border border-white/10'"
                                                class="px-4 py-2 rounded text-xs uppercase tracking-wider transition-all">
                                            EasyPaisa
                                        </button>
                                        <button type="button" @click="walletType = 'jazzcash'" 
                                                :class="walletType === 'jazzcash' ? 'bg-brand-gold text-black font-bold' : 'bg-black/60 text-brand-ivory border border-white/10'"
                                                class="px-4 py-2 rounded text-xs uppercase tracking-wider transition-all">
                                            JazzCash
                                        </button>
                                        <button type="button" @click="walletType = 'sadapay'" 
                                                :class="walletType === 'sadapay' ? 'bg-brand-gold text-black font-bold' : 'bg-black/60 text-brand-ivory border border-white/10'"
                                                class="px-4 py-2 rounded text-xs uppercase tracking-wider transition-all">
                                            SadaPay
                                        </button>
                                        <button type="button" @click="walletType = 'nayapay'" 
                                                :class="walletType === 'nayapay' ? 'bg-brand-gold text-black font-bold' : 'bg-black/60 text-brand-ivory border border-white/10'"
                                                class="px-4 py-2 rounded text-xs uppercase tracking-wider transition-all">
                                            NayaPay
                                        </button>
                                    </div>
                                    <input type="hidden" name="wallet_type" :value="walletType">

                                    <!-- Wallet Account Card -->
                                    <div class="bg-[#12070a] p-4 rounded border border-brand-gold/30 space-y-2">
                                        <template x-if="walletType === 'easypaisa'">
                                            <div>
                                                <div class="font-serif text-sm text-green-400 font-semibold mb-1">EasyPaisa Account Coordinates</div>
                                                <div class="flex justify-between py-1 border-b border-white/5">
                                                    <span class="text-brand-ivory/60">Account Title:</span>
                                                    <span class="font-semibold text-brand-ivory">{{ $walletDetails['easypaisa']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-brand-ivory/60">Mobile Number:</span>
                                                    <span class="font-mono text-brand-gold font-semibold">{{ $walletDetails['easypaisa']['account_number'] }}</span>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'jazzcash'">
                                            <div>
                                                <div class="font-serif text-sm text-red-400 font-semibold mb-1">JazzCash Account Coordinates</div>
                                                <div class="flex justify-between py-1 border-b border-white/5">
                                                    <span class="text-brand-ivory/60">Account Title:</span>
                                                    <span class="font-semibold text-brand-ivory">{{ $walletDetails['jazzcash']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-brand-ivory/60">Mobile Number:</span>
                                                    <span class="font-mono text-brand-gold font-semibold">{{ $walletDetails['jazzcash']['account_number'] }}</span>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'sadapay'">
                                            <div>
                                                <div class="font-serif text-sm text-cyan-400 font-semibold mb-1">SadaPay Account Coordinates</div>
                                                <div class="flex justify-between py-1 border-b border-white/5">
                                                    <span class="text-brand-ivory/60">Account Title:</span>
                                                    <span class="font-semibold text-brand-ivory">{{ $walletDetails['sadapay']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-brand-ivory/60">Account Number:</span>
                                                    <span class="font-mono text-brand-gold font-semibold">{{ $walletDetails['sadapay']['account_number'] }}</span>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'nayapay'">
                                            <div>
                                                <div class="font-serif text-sm text-orange-400 font-semibold mb-1">NayaPay Account Coordinates</div>
                                                <div class="flex justify-between py-1 border-b border-white/5">
                                                    <span class="text-brand-ivory/60">Account Title:</span>
                                                    <span class="font-semibold text-brand-ivory">{{ $walletDetails['nayapay']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-brand-ivory/60">NayaPay ID:</span>
                                                    <span class="font-mono text-brand-gold font-semibold">{{ $walletDetails['nayapay']['nayapay_id'] }}</span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Transaction ID (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. 9876543210"
                                                   class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2.5 text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded font-mono">
                                        </div>
                                        <div>
                                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Payment Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory/70 text-xs focus:border-brand-gold rounded file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-brand-gold file:text-black file:font-semibold">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. JazzCash Online Gateway (Instant) -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'jazzcash' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'"
                                 @click="paymentMethod = 'jazzcash'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="jazzcash" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">JazzCash Online Gateway (Instant Mobile / Debit Card)</span>
                                            <p class="text-xs text-brand-ivory/50">Pay via JazzCash Mobile Account (MPIN) or Card with real-time verification</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-wider text-brand-gold px-2.5 py-1 bg-brand-gold/10 rounded border border-brand-gold/30">Automated</span>
                                </div>
                            </div>

                            <!-- 5. EasyPaisa Online Gateway (Instant) -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'easypaisa' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'"
                                 @click="paymentMethod = 'easypaisa'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="easypaisa" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">EasyPaisa Online Gateway (Instant Checkout)</span>
                                            <p class="text-xs text-brand-ivory/50">Hosted EasyPaisa payment gateway with instant confirmation</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-wider text-brand-gold px-2.5 py-1 bg-brand-gold/10 rounded border border-brand-gold/30">Automated</span>
                                </div>
                            </div>

                            <!-- 6. Debit / Credit Card (Safepay) -->
                            <div class="border rounded transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'safepay' ? 'border-brand-gold bg-brand-maroon/20 shadow-[0_0_15px_rgba(201,162,75,0.15)]' : 'border-white/10 bg-black/40 hover:border-white/30'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="accent-brand-gold w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-brand-ivory">Debit / Credit Card (Visa / MasterCard / PayPak)</span>
                                            <p class="text-xs text-brand-ivory/50">256-bit encrypted card checkout powered by Safepay</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-brand-gold font-mono">
                                        <span>VISA</span> &bull; <span>MC</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Desktop & Mobile -->
                    <div>
                        <button type="submit" 
                                class="w-full py-5 bg-gradient-to-r from-brand-gold via-brand-gold-light to-brand-gold text-black font-semibold text-sm uppercase tracking-[0.25em] hover:brightness-110 transition-all rounded-sm shadow-[0_4px_25px_rgba(201,162,75,0.4)] flex items-center justify-center gap-3">
                            <span>Place Confirmed Luxury Dossier</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="text-[11px] text-center text-brand-ivory/40 mt-3">
                            By placing this order, you confirm acceptance of our concierge terms, authenticity guarantee, and delivery policies.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Order Dossier Summary & Coupon -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-8 rounded-sm shadow-2xl sticky top-24">
                        <h3 class="font-serif text-xl text-brand-gold font-light pb-4 border-b border-white/10 flex items-center justify-between">
                            <span>Fragrance Dossier</span>
                            <span class="text-xs font-sans tracking-widest text-brand-ivory/60 uppercase">({{ $cart->items->sum('quantity') }} Flacons)</span>
                        </h3>

                        <!-- Items List -->
                        <div class="divide-y divide-white/5 max-h-80 overflow-y-auto py-2 my-2 custom-scrollbar pr-1">
                            @foreach($cart->items as $item)
                                <div class="py-3 flex items-center gap-4 text-xs">
                                    <div class="w-14 h-14 bg-black/80 rounded border border-white/10 p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset($item->bundle ? $item->bundle->image_url : $item->product->primary_image_url) }}" 
                                             alt="{{ $item->bundle ? $item->bundle->name : $item->product->name }}" 
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-serif text-sm text-brand-ivory font-semibold leading-tight">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h4>
                                        <p class="text-brand-ivory/50 text-[11px] mt-0.5">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Bespoke Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="text-brand-gold/80 font-mono mt-0.5">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 0) }}</div>
                                    </div>
                                    <div class="text-right font-mono text-sm text-brand-gold font-semibold">
                                        Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Promo Code Section -->
                        <div class="pt-4 border-t border-white/10">
                            @if($cart->coupon_code)
                                <div class="p-3 bg-brand-gold/10 border border-brand-gold/40 rounded flex items-center justify-between text-xs mb-4">
                                    <div>
                                        <span class="text-brand-gold font-semibold font-mono">{{ $cart->coupon_code }}</span>
                                        <span class="text-brand-ivory/70 ml-2">Privilege Applied (-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-red-400 hover:text-red-300 font-semibold underline text-[11px]">Remove</a>
                                </div>
                            @else
                                <div class="mb-4">
                                    <label class="block text-[10px] uppercase tracking-[0.2em] text-brand-gold mb-1.5 font-medium">Privilege Promo Code</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. ROYAL10 / FIRSTORDER" 
                                               class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-xs text-brand-ivory uppercase tracking-wider placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded font-mono">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="px-4 py-2 bg-brand-gold text-black font-semibold text-xs uppercase tracking-wider hover:brightness-110 transition-all rounded disabled:opacity-50">
                                            <span x-show="!couponLoading">Apply</span>
                                            <span x-show="couponLoading" x-cloak>...</span>
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="text-[11px] mt-1.5 font-medium" :class="couponSuccess ? 'text-green-400' : 'text-red-400'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        <!-- Financial Totals Breakdown -->
                        <div class="pt-4 border-t border-white/10 space-y-2.5 text-xs">
                            <div class="flex justify-between text-brand-ivory/70">
                                <span>Subtotal:</span>
                                <span class="font-mono text-brand-ivory font-semibold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>

                            @if($cart->discount_amount > 0)
                                <div class="flex justify-between text-brand-gold">
                                    <span>Privilege Discount ({{ $cart->coupon_code }}):</span>
                                    <span class="font-mono font-semibold">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-brand-ivory/70">
                                <span>White-Glove Courier Delivery:</span>
                                <span class="font-mono text-brand-ivory font-semibold">
                                    {{ $shippingCost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>

                            <div class="flex justify-between items-baseline pt-3 border-t border-brand-gold/30 text-base">
                                <span class="font-serif text-lg text-brand-gold">Grand Total:</span>
                                <span class="font-serif text-2xl font-bold text-brand-gold font-mono">
                                    Rs. {{ number_format($grandTotal, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Luxury Assurance Badges -->
                        <div class="mt-6 pt-6 border-t border-white/10 grid grid-cols-2 gap-3 text-[10px] text-brand-ivory/60">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>100% Pure Extrait Oil</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>256-Bit Encrypted</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>7-Day Scent Guarantee</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>Nationwide White-Glove</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
