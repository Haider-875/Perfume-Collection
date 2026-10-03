@extends('admin.layouts.admin')

@section('title', 'Brand & Gateway Settings')
@section('page_title', 'Maison Parameters & Payment Gateways')
@section('page_subtitle', 'Configure brand identity, shipping rates, Pakistani payment gateways, and concierge channels')

@section('content')
<div x-data="{ activeTab: 'general' }">
    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-brand-border/60 pb-3 mb-6 overflow-x-auto text-xs">
        <button @click="activeTab = 'general'" 
                :class="activeTab === 'general' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-crown"></i>
            <span>Brand Identity</span>
        </button>

        <button @click="activeTab = 'shipping'" 
                :class="activeTab === 'shipping' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Shipping & Delivery</span>
        </button>

        <button @click="activeTab = 'payments'" 
                :class="activeTab === 'payments' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-credit-card"></i>
            <span>Payment Gateways (PK)</span>
        </button>

        <button @click="activeTab = 'social'" 
                :class="activeTab === 'social' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-share-nodes"></i>
            <span>Social & Concierge</span>
        </button>
    </div>

    <!-- Main Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- TAB 1: Brand Identity -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Brand & Store Parameters
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Maison Brand Name</label>
                        <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'Perfumes Collection' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Concierge Support Email</label>
                        <input type="email" name="store_email" value="{{ $settings['store_email'] ?? 'concierge@perfumecollectionpk.com' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Official Contact Phone (+92)</label>
                        <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '+92 300 1234567' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">WhatsApp Concierge Direct Number</label>
                        <input type="text" name="store_whatsapp" value="{{ $settings['store_whatsapp'] ?? '923001234567' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1">Boutique Physical Address</label>
                    <input type="text" name="store_address" value="{{ $settings['store_address'] ?? 'Gulberg III, Main Boulevard, Lahore, Pakistan' }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1">Store Announcement Bar Message</label>
                    <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? 'COMPLIMENTARY NATIONWIDE COURIER DELIVERY ON ORDERS OVER RS. 10,000' }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>
        </div>

        <!-- TAB 2: Shipping & Delivery -->
        <div x-show="activeTab === 'shipping'" class="space-y-6" style="display: none;">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Nationwide Shipping Parameters (Pakistan)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Standard Shipping Charge (PKR)</label>
                        <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] ?? '250' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-gold mb-1 font-semibold">Free Shipping Threshold (PKR)</label>
                        <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] ?? '10000' }}"
                               class="w-full bg-brand-black/60 border border-brand-gold/60 rounded-lg px-3.5 py-2 text-brand-text font-bold focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1">Estimated Delivery Window</label>
                    <input type="text" name="delivery_estimate" value="{{ $settings['delivery_estimate'] ?? '2-4 Working Days via TCS / Leopards / Trax' }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>
        </div>

        <!-- TAB 3: Pluggable Payment Gateways -->
        <div x-show="activeTab === 'payments'" class="space-y-6" style="display: none;">
            
            <!-- Cash on Delivery -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-hand-holding-dollar text-brand-gold"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Cash on Delivery (COD)</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_cod_enabled" value="1" {{ ($settings['payment_cod_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Enable COD</span>
                    </label>
                </div>
            </div>

            <!-- Direct Bank Transfer -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-building-columns text-brand-gold"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Direct Bank Transfer</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_bank_enabled" value="1" {{ ($settings['payment_bank_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Enable Bank Transfer</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'Meezan Bank Limited' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Account Title</label>
                        <input type="text" name="bank_account_title" value="{{ $settings['bank_account_title'] ?? 'PERFUMES COLLECTION PK' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '01010102938475' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">IBAN Number</label>
                        <input type="text" name="bank_iban" value="{{ $settings['bank_iban'] ?? 'PK45MEZN0001010102938475' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                </div>
            </div>

            <!-- EasyPaisa Wallet -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-emerald-400"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">EasyPaisa Mobile Wallet</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_easypaisa_enabled" value="1" {{ ($settings['payment_easypaisa_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Enable EasyPaisa</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">EasyPaisa Account Title</label>
                        <input type="text" name="easypaisa_title" value="{{ $settings['easypaisa_title'] ?? 'Perfumes Collection' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">EasyPaisa Mobile Number</label>
                        <input type="text" name="easypaisa_number" value="{{ $settings['easypaisa_number'] ?? '03001234567' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                </div>
            </div>

            <!-- JazzCash -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-400"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">JazzCash Merchant Gateway</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_jazzcash_enabled" value="1" {{ ($settings['payment_jazzcash_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Enable JazzCash</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Merchant ID</label>
                        <input type="text" name="jazzcash_merchant_id" value="{{ $settings['jazzcash_merchant_id'] ?? 'MC12345' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Password</label>
                        <input type="password" name="jazzcash_password" value="{{ $settings['jazzcash_password'] ?? 'pass123' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Integrity Salt</label>
                        <input type="password" name="jazzcash_salt" value="{{ $settings['jazzcash_salt'] ?? 'salt_secret_key' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                </div>
            </div>

            <!-- Safepay Debit/Credit Card -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-brand-gold"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Safepay Card Gateway</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_safepay_enabled" value="1" {{ ($settings['payment_safepay_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Enable Safepay</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">API Public Key</label>
                        <input type="text" name="safepay_api_key" value="{{ $settings['safepay_api_key'] ?? 'sec_test_12345' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Secret Shared Key</label>
                        <input type="password" name="safepay_secret" value="{{ $settings['safepay_secret'] ?? 'shared_secret_123' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Social & Concierge -->
        <div x-show="activeTab === 'social'" class="space-y-6" style="display: none;">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Social Channels & Digital Presence
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/perfumecollectionpk' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">Facebook URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com/perfumecollectionpk' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">TikTok Channel</label>
                        <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? 'https://tiktok.com/@perfumecollectionpk' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1">YouTube Channel</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com/@perfumecollectionpk' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl">
            <button type="submit" class="gold-btn px-6 py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save All Maison Parameters</span>
            </button>
        </div>
    </form>
</div>
@endsection
