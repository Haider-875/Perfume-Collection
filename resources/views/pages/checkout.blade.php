@extends('layouts.app')

@section('title', 'Secure Checkout — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#050203] text-[#f5efe7] min-h-screen border-b border-[#d6aa62]/20" 
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
        <!-- Header -->
        <div class="text-center mb-10">
            <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold px-4 py-1.5 bg-[#1f060d] border border-[#d6aa62]/30 rounded-full inline-block mb-2">
                SSL Secured 256-Bit Checkout
            </span>
            <h1 class="font-serif text-3xl md:text-4xl text-[#f5efe7] font-normal">Complete Your Order</h1>
            <p class="text-[#b8a9a2] text-sm mt-1">Authentic artisan impressions hand-poured in Pakistan</p>
        </div>

        @if(session('error'))
            <div class="mb-8 p-4 bg-[#2a080e] border border-rose-500/40 text-rose-300 text-sm rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-4 bg-[#2a080e] border border-rose-500/40 text-rose-300 text-sm rounded-xl">
                <div class="font-semibold mb-1 text-rose-200">Please review the following fields:</div>
                <ul class="list-disc list-inside space-y-1 text-xs text-rose-300">
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
                <div class="lg:col-span-7 space-y-6">
                    <!-- Step 1: Customer Contact & Delivery Address -->
                    <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-8 rounded-2xl shadow-xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#d6aa62]/20">
                            <span class="w-7 h-7 rounded-full bg-[#25050a] border border-[#d6aa62]/40 text-[#d6aa62] font-bold text-xs flex items-center justify-center">1</span>
                            <h2 class="font-serif text-xl md:text-2xl text-[#f5efe7] font-medium">Contact & Delivery Address</h2>
                        </div>

                        <!-- Saved Address Quick Selector for logged in user -->
                        @if(auth()->check() && $savedAddresses->isNotEmpty())
                            <div class="mb-6 p-4 bg-[#25050a] border border-[#d6aa62]/30 rounded-xl">
                                <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Select Saved Address</label>
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
                                                class="text-left p-3 border border-[#d6aa62]/25 hover:border-[#d6aa62] rounded-lg bg-[#080204] text-xs transition-all shadow-sm">
                                            <div class="font-semibold text-[#f5efe7]">{{ $addr->recipient_name }}</div>
                                            <div class="text-[#b8a9a2] truncate">{{ $addr->street_address }}</div>
                                            <div class="text-[#d6aa62]">{{ $addr->city }}, {{ $addr->province }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4 text-xs">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Full Name *</label>
                                    <input type="text" id="input_name" name="customer_name" required 
                                           value="{{ old('customer_name', auth()->user()->name ?? ($defaultAddress->recipient_name ?? '')) }}" 
                                           placeholder="e.g. Syed Daniyal Ahmed"
                                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Email Address (Order Confirmation) *</label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                           placeholder="patron@domain.com"
                                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Pakistani Mobile Contact (03XX-XXXXXXX) *</label>
                                <input type="tel" id="input_phone" name="customer_phone" required 
                                       value="{{ old('customer_phone', auth()->user()->phone ?? ($defaultAddress->phone ?? '')) }}" 
                                       placeholder="e.g. 03001234567"
                                       class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg font-mono">
                                <p class="text-[11px] text-[#b8a9a2] mt-1">Courier rider will call you on this active number prior to doorstep delivery.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Province / Region *</label>
                                    <select name="province" x-model="province" required 
                                            class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                        @foreach($provinces as $prov => $cities)
                                            <option value="{{ $prov }}" class="bg-[#140408]">{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">City in Pakistan *</label>
                                    <select name="city" x-model="city" required 
                                            class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                        <template x-for="c in getCities()" :key="c">
                                            <option :value="c.split(' (')[0]" x-text="c" :selected="c.split(' (')[0] === city" class="bg-[#140408]"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Street Address / House / Flat Number *</label>
                                <input type="text" id="input_address" name="shipping_address" required 
                                       value="{{ old('shipping_address', $defaultAddress->street_address ?? '') }}" 
                                       placeholder="e.g. House # 42-A, Street 14"
                                       class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Area / Sector / Block</label>
                                    <input type="text" name="area" value="{{ old('area') }}" 
                                           placeholder="e.g. DHA Phase 5 / Gulberg"
                                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Prominent Landmark</label>
                                    <input type="text" name="landmark" value="{{ old('landmark') }}" 
                                           placeholder="e.g. Near Siddiq Trade Centre"
                                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Postal Code</label>
                                    <input type="text" id="input_postal" name="postal_code" value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}" 
                                           placeholder="e.g. 54000"
                                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg font-mono">
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1.5 font-semibold">Special Delivery Instructions (Optional)</label>
                                <textarea name="order_notes" rows="2" placeholder="e.g. Please call before arriving or leave with security gate."
                                          class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-2.5 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62] focus:outline-none rounded-lg">{{ old('order_notes') }}</textarea>
                            </div>

                            @if(auth()->check())
                                <div class="pt-2 flex items-center gap-2">
                                    <input type="checkbox" id="save_address" name="save_address" value="1" class="accent-[#d6aa62] w-4 h-4 rounded">
                                    <label for="save_address" class="text-[#b8a9a2] cursor-pointer text-xs">Save this address to my account for faster checkout next time</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Courier Logistics Service -->
                    <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-8 rounded-2xl shadow-xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#d6aa62]/20">
                            <span class="w-7 h-7 rounded-full bg-[#25050a] border border-[#d6aa62]/40 text-[#d6aa62] font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="font-serif text-xl md:text-2xl text-[#f5efe7] font-medium">Nationwide Express Delivery</h2>
                        </div>

                        <div class="p-4 bg-[#25050a] border border-[#d6aa62]/30 rounded-xl flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#18050b] border border-[#d6aa62]/30 flex items-center justify-center text-[#d6aa62]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-[#f5efe7]">Tracked Courier (TCS / Leopards / PostEx / Trax)</div>
                                    <div class="text-xs text-[#b8a9a2]">Guaranteed delivery within 2-4 business days across Pakistan</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-serif text-base text-[#f0d59d] font-bold">
                                    {{ $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Payment Methods -->
                    <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-8 rounded-2xl shadow-xl">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#d6aa62]/20">
                            <span class="w-7 h-7 rounded-full bg-[#25050a] border border-[#d6aa62]/40 text-[#d6aa62] font-bold text-xs flex items-center justify-center">3</span>
                            <h2 class="font-serif text-xl md:text-2xl text-[#f5efe7] font-medium">Select Payment Method</h2>
                        </div>

                        <div class="space-y-3.5">
                            <!-- 1. Cash on Delivery (COD) -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'cod' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'"
                                 @click="paymentMethod = 'cod'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">Cash on Delivery (COD)</span>
                                            <p class="text-xs text-[#b8a9a2]">Pay cash in hand to the courier rider upon delivery at your doorstep</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#f0d59d] px-2.5 py-1 bg-[#4a0915] border border-[#d6aa62]/30 rounded">Nationwide</span>
                                </div>
                            </div>

                            <!-- 2. Direct Bank Transfer / Raast -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'bank_transfer' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'">
                                <div class="p-4 flex items-center justify-between" @click="paymentMethod = 'bank_transfer'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">Direct Bank Transfer / Raast Instant</span>
                                            <p class="text-xs text-[#b8a9a2]">Transfer via Bank App, ATM, or Raast with instant confirmation</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#b8a9a2] px-2.5 py-1 bg-[#18050b] border border-[#d6aa62]/20 rounded">Manual</span>
                                </div>

                                <!-- Bank Transfer Details Drawer -->
                                <div x-show="paymentMethod === 'bank_transfer'" x-cloak class="p-5 bg-[#18050b] border-t border-[#d6aa62]/20 space-y-4 text-xs">
                                    <div class="bg-[#080204] p-4 rounded-xl border border-[#d6aa62]/25 space-y-2 shadow-sm">
                                        <div class="font-serif text-sm text-[#f0d59d] font-bold mb-2">Perfumes Collection Official Bank Details</div>
                                        <div class="flex justify-between items-center py-1.5 border-b border-[#d6aa62]/15">
                                            <span class="text-[#b8a9a2]">Bank Name:</span>
                                            <span class="font-semibold text-[#f5efe7]">{{ $bankDetails['bank_name'] }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1.5 border-b border-[#d6aa62]/15">
                                            <span class="text-[#b8a9a2]">Account Title:</span>
                                            <span class="font-semibold text-[#f5efe7]">{{ $bankDetails['account_title'] }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1.5 border-b border-[#d6aa62]/15">
                                            <span class="text-[#b8a9a2]">Account Number:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-[#f5efe7] font-bold">{{ $bankDetails['account_number'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['account_number'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center py-1.5 border-b border-[#d6aa62]/15">
                                            <span class="text-[#b8a9a2]">IBAN:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-[#f5efe7] font-bold">{{ $bankDetails['iban'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['iban'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center py-1.5">
                                            <span class="text-[#b8a9a2]">Raast Instant ID:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-[#f0d59d] font-bold">{{ $bankDetails['raast_id'] }}</span>
                                                <button type="button" @click="copyText('{{ $bankDetails['raast_id'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1 font-semibold">Bank Transaction ID / Reference (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. FT261003894"
                                                   class="w-full bg-[#080204] border border-[#d6aa62]/30 px-3 py-2.5 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none rounded-lg font-mono text-xs">
                                        </div>
                                        <div>
                                            <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1 font-semibold">Attach Transfer Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="w-full bg-[#080204] border border-[#d6aa62]/30 px-3 py-2 text-[#b8a9a2] text-xs focus:border-[#d6aa62] rounded-lg file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-[#25050a] file:text-[#d6aa62] file:font-semibold">
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-[#b8a9a2] italic">
                                        * You can also upload your receipt later or send it to our WhatsApp concierge after placing your order.
                                    </p>
                                </div>
                            </div>

                            <!-- 3. Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay) -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'wallet_transfer' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'">
                                <div class="p-4 flex items-center justify-between" @click="paymentMethod = 'wallet_transfer'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="wallet_transfer" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay)</span>
                                            <p class="text-xs text-[#b8a9a2]">Send money directly to our registered merchant mobile account</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#f0d59d] px-2.5 py-1 bg-[#4a0915] border border-[#d6aa62]/30 rounded">Instant</span>
                                </div>

                                <div x-show="paymentMethod === 'wallet_transfer'" x-cloak class="p-5 bg-[#18050b] border-t border-[#d6aa62]/20 space-y-4 text-xs">
                                    <!-- Wallet Selector Tabs -->
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" @click="walletType = 'easypaisa'" 
                                                :class="walletType === 'easypaisa' ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#080204] text-[#b8a9a2] border border-[#d6aa62]/25'"
                                                class="px-3.5 py-1.5 rounded-lg text-xs uppercase tracking-wider transition-all border">
                                            EasyPaisa
                                        </button>
                                        <button type="button" @click="walletType = 'jazzcash'" 
                                                :class="walletType === 'jazzcash' ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#080204] text-[#b8a9a2] border border-[#d6aa62]/25'"
                                                class="px-3.5 py-1.5 rounded-lg text-xs uppercase tracking-wider transition-all border">
                                            JazzCash
                                        </button>
                                        <button type="button" @click="walletType = 'sadapay'" 
                                                :class="walletType === 'sadapay' ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#080204] text-[#b8a9a2] border border-[#d6aa62]/25'"
                                                class="px-3.5 py-1.5 rounded-lg text-xs uppercase tracking-wider transition-all border">
                                            SadaPay
                                        </button>
                                        <button type="button" @click="walletType = 'nayapay'" 
                                                :class="walletType === 'nayapay' ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#080204] text-[#b8a9a2] border border-[#d6aa62]/25'"
                                                class="px-3.5 py-1.5 rounded-lg text-xs uppercase tracking-wider transition-all border">
                                            NayaPay
                                        </button>
                                    </div>
                                    <input type="hidden" name="wallet_type" :value="walletType">

                                    <!-- Wallet Account Card -->
                                    <div class="bg-[#080204] p-4 rounded-xl border border-[#d6aa62]/25 space-y-2 shadow-sm">
                                        <template x-if="walletType === 'easypaisa'">
                                            <div>
                                                <div class="text-sm text-emerald-400 font-bold mb-1">EasyPaisa Account Details</div>
                                                <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                                    <span class="text-[#b8a9a2]">Account Title:</span>
                                                    <span class="font-semibold text-[#f5efe7]">{{ $walletDetails['easypaisa']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#b8a9a2]">Mobile Number:</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[#f5efe7] font-bold">{{ $walletDetails['easypaisa']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['easypaisa']['account_number'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'jazzcash'">
                                            <div>
                                                <div class="text-sm text-amber-400 font-bold mb-1">JazzCash Account Details</div>
                                                <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                                    <span class="text-[#b8a9a2]">Account Title:</span>
                                                    <span class="font-semibold text-[#f5efe7]">{{ $walletDetails['jazzcash']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#b8a9a2]">Mobile Number:</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[#f5efe7] font-bold">{{ $walletDetails['jazzcash']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['jazzcash']['account_number'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'sadapay'">
                                            <div>
                                                <div class="text-sm text-cyan-400 font-bold mb-1">SadaPay Account Details</div>
                                                <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                                    <span class="text-[#b8a9a2]">Account Title:</span>
                                                    <span class="font-semibold text-[#f5efe7]">{{ $walletDetails['sadapay']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#b8a9a2]">Account / IBAN:</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[#f5efe7] font-bold">{{ $walletDetails['sadapay']['account_number'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['sadapay']['account_number'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="walletType === 'nayapay'">
                                            <div>
                                                <div class="text-sm text-orange-400 font-bold mb-1">NayaPay Account Details</div>
                                                <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                                    <span class="text-[#b8a9a2]">Account Title:</span>
                                                    <span class="font-semibold text-[#f5efe7]">{{ $walletDetails['nayapay']['account_title'] }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#b8a9a2]">NayaPay ID:</span>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[#f5efe7] font-bold">{{ $walletDetails['nayapay']['nayapay_id'] }}</span>
                                                        <button type="button" @click="copyText('{{ $walletDetails['nayapay']['nayapay_id'] }}')" class="text-[11px] text-[#d6aa62] font-semibold underline uppercase">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1 font-semibold">Wallet Transaction ID (TID)</label>
                                            <input type="text" name="transaction_id" placeholder="e.g. 9876543210"
                                                   class="w-full bg-[#080204] border border-[#d6aa62]/30 px-3 py-2.5 text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none rounded-lg font-mono text-xs">
                                        </div>
                                        <div>
                                            <label class="block uppercase tracking-wider text-[#d6aa62] text-[11px] mb-1 font-semibold">Payment Screenshot</label>
                                            <input type="file" name="receipt_file" accept="image/*,.pdf"
                                                   class="w-full bg-[#080204] border border-[#d6aa62]/30 px-3 py-2 text-[#b8a9a2] text-xs focus:border-[#d6aa62] rounded-lg file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-[#25050a] file:text-[#d6aa62] file:font-semibold">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. JazzCash Online Gateway (Instant) -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'jazzcash' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'"
                                 @click="paymentMethod = 'jazzcash'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="jazzcash" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">JazzCash Online Gateway (Instant MPIN / Card)</span>
                                            <p class="text-xs text-[#b8a9a2]">Pay directly from your JazzCash wallet via MPIN prompt or Debit Card</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#f0d59d] px-2.5 py-1 bg-[#4a0915] border border-[#d6aa62]/30 rounded">Automated</span>
                                </div>
                            </div>

                            <!-- 5. EasyPaisa Online Gateway (Instant) -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'easypaisa' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'"
                                 @click="paymentMethod = 'easypaisa'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="easypaisa" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">EasyPaisa Online Gateway (Instant OTP)</span>
                                            <p class="text-xs text-[#b8a9a2]">Hosted EasyPaisa payment gateway with real-time verification</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#f0d59d] px-2.5 py-1 bg-[#4a0915] border border-[#d6aa62]/30 rounded">Automated</span>
                                </div>
                            </div>

                            <!-- 6. Debit / Credit Card (Safepay) -->
                            <div class="border rounded-xl transition-all cursor-pointer overflow-hidden"
                                 :class="paymentMethod === 'safepay' ? 'border-[#d6aa62] bg-[#25050a]/70 ring-1 ring-[#d6aa62]' : 'border-[#d6aa62]/20 bg-[#080204] hover:border-[#d6aa62]/40'"
                                 @click="paymentMethod = 'safepay'">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="safepay" x-model="paymentMethod" class="accent-[#d6aa62] w-4 h-4">
                                        <div>
                                            <span class="text-sm font-semibold text-[#f5efe7]">Debit / Credit Card (Visa / MasterCard / PayPak)</span>
                                            <p class="text-xs text-[#b8a9a2]">256-bit encrypted card checkout powered by Safepay</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-[#d6aa62] font-mono font-bold">
                                        <span>VISA</span> &bull; <span>MC</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full btn-gold py-4 text-xs font-semibold uppercase tracking-[0.2em] shadow-xl flex items-center justify-center gap-3">
                            <span>Place Confirmed Order</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="text-[11px] text-center text-[#b8a9a2] mt-3">
                            By placing this order, you confirm acceptance of our delivery policies and 7-day scent satisfaction guarantee.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Order Summary & Coupon -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-8 rounded-2xl shadow-xl sticky top-28">
                        <h3 class="font-serif text-xl text-[#f5efe7] font-medium pb-4 border-b border-[#d6aa62]/20 flex items-center justify-between">
                            <span>Order Summary</span>
                            <span class="text-xs font-sans tracking-wider text-[#d6aa62] uppercase">({{ $cart->items->sum('quantity') }} Items)</span>
                        </h3>

                        <!-- Items List -->
                        <div class="divide-y divide-[#d6aa62]/15 max-h-80 overflow-y-auto py-2 my-2 no-scrollbar pr-1">
                            @foreach($cart->items as $item)
                                <div class="py-3 flex items-center gap-4 text-xs">
                                    <div class="w-14 h-14 bg-[#080204] rounded-lg border border-[#d6aa62]/25 p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset($item->bundle ? $item->bundle->image_url : $item->product->primary_image_url) }}" 
                                             alt="{{ $item->bundle ? $item->bundle->name : $item->product->name }}" 
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-serif text-sm text-[#f5efe7] font-semibold leading-tight">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h4>
                                        <p class="text-[#d6aa62] text-[11px] mt-0.5">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Artisan Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="text-[#b8a9a2] font-mono mt-0.5">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 0) }}</div>
                                    </div>
                                    <div class="text-right font-mono text-sm text-[#f0d59d] font-bold">
                                        Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Promo Code Section -->
                        <div class="pt-4 border-t border-[#d6aa62]/20">
                            @if($cart->coupon_code)
                                <div class="p-3 bg-[#25050a] border border-[#d6aa62]/30 rounded-xl flex items-center justify-between text-xs mb-4">
                                    <div>
                                        <span class="text-[#f0d59d] font-bold font-mono">{{ $cart->coupon_code }}</span>
                                        <span class="text-[#d6aa62] ml-2">Discount Applied (-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-rose-400 hover:text-rose-300 font-semibold underline text-[11px]">Remove</a>
                                </div>
                            @else
                                <div class="mb-4">
                                    <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] mb-1.5 font-semibold">Discount Code / Voucher</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. ROYAL10 / FIRSTORDER" 
                                               class="w-full bg-[#080204] border border-[#d6aa62]/30 px-3 py-2 text-xs text-[#f5efe7] uppercase tracking-wider placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none rounded-lg font-mono">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="px-4 py-2 btn-gold font-semibold text-xs uppercase tracking-wider rounded-lg disabled:opacity-50">
                                            <span x-show="!couponLoading">Apply</span>
                                            <span x-show="couponLoading" x-cloak>...</span>
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="text-[11px] mt-1.5 font-medium" :class="couponSuccess ? 'text-emerald-400' : 'text-rose-400'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        <!-- Financial Totals Breakdown -->
                        <div class="pt-4 border-t border-[#d6aa62]/20 space-y-2.5 text-xs">
                            <div class="flex justify-between text-[#b8a9a2]">
                                <span>Subtotal:</span>
                                <span class="font-mono text-[#f5efe7] font-semibold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>

                            @if($cart->discount_amount > 0)
                                <div class="flex justify-between text-[#f0d59d] font-semibold">
                                    <span>Voucher Discount ({{ $cart->coupon_code }}):</span>
                                    <span class="font-mono">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-[#b8a9a2]">
                                <span>Express Courier Delivery:</span>
                                <span class="font-mono text-[#d6aa62] font-semibold">
                                    {{ $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0) }}
                                </span>
                            </div>

                            <div class="flex justify-between items-baseline pt-3 border-t border-[#d6aa62]/20 text-base">
                                <span class="font-serif text-lg text-[#f5efe7] font-bold">Total:</span>
                                <span class="font-serif text-2xl font-bold text-[#f0d59d] font-mono">
                                    Rs. {{ number_format($grandTotal, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Luxury Assurance Badges -->
                        <div class="mt-6 pt-6 border-t border-[#d6aa62]/20 grid grid-cols-2 gap-3 text-[11px] text-[#b8a9a2]">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#d6aa62] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>100% Extrait Oil Formulation</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#d6aa62] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>256-Bit SSL Secured</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#d6aa62] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>7-Day Scent Guarantee</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#d6aa62] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
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
