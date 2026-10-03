@extends('admin.layouts.admin')

@section('title', 'Brand & Gateway Settings')
@section('page_title', 'RAVAHA Parameters & Payment Gateways')
@section('page_subtitle', 'Configure brand identity, shipping rates, Pakistani payment gateways, bank accounts, and concierge channels')

@section('content')
<div x-data="{ activeTab: 'general' }">
    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-brand-border/60 pb-3 mb-6 overflow-x-auto text-xs">
        <button type="button" @click="activeTab = 'general'" 
                :class="activeTab === 'general' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-crown"></i>
            <span>Brand Identity</span>
        </button>

        <button type="button" @click="activeTab = 'shipping'" 
                :class="activeTab === 'shipping' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Shipping & Logistics</span>
        </button>

        <button type="button" @click="activeTab = 'payments'" 
                :class="activeTab === 'payments' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-credit-card"></i>
            <span>Payment Gateways & Banks</span>
        </button>

        <button type="button" @click="activeTab = 'social'" 
                :class="activeTab === 'social' ? 'bg-brand-gold/20 text-brand-gold border-brand-gold/50' : 'bg-brand-card text-brand-muted hover:text-brand-text border-brand-border/60'"
                class="px-4 py-2 rounded-lg border font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-share-nodes"></i>
            <span>Social & WhatsApp</span>
        </button>
    </div>

    <!-- Main Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- TAB 1: Brand Identity -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Brand & Boutique Parameters
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Brand / Store Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? ($settings['store_name'] ?? 'RAVAHA Parfums') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Concierge Support Email</label>
                        <input type="email" name="site_email" value="{{ $settings['site_email'] ?? ($settings['store_email'] ?? 'support@ravaha.pk') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Official Contact Phone (+92)</label>
                        <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? ($settings['store_phone'] ?? '+92 300 8765432') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">WhatsApp Concierge Direct Number (e.g. 923008765432)</label>
                        <input type="text" name="site_whatsapp" value="{{ $settings['site_whatsapp'] ?? ($settings['store_whatsapp'] ?? '923008765432') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Boutique Physical Address</label>
                    <input type="text" name="site_address" value="{{ $settings['site_address'] ?? ($settings['store_address'] ?? 'Gulberg III, Main Boulevard, Lahore, Pakistan') }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Store Announcement Bar Text</label>
                    <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? 'FREE EXPRESS DELIVERY ON ORDERS OVER RS. 5,000 | 100% PURE EXTRAIT DE PARFUM' }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Meta Description (SEO)</label>
                        <textarea name="site_description" rows="2" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">{{ $settings['site_description'] ?? 'Artisanal luxury impressions hand-poured in Pakistan. Monumental longevity and projection.' }}</textarea>
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Brand Logo</label>
                        <input type="file" name="store_logo" accept="image/*,.svg" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-1.5 text-xs text-brand-muted file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-brand-gold file:text-black">
                        @if(isset($settings['store_logo']))
                            <div class="mt-2 text-[11px] text-brand-gold flex items-center gap-2">
                                <span>Current: {{ $settings['store_logo'] }}</span>
                            </div>
                        @endif
                    </div>
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
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Standard Shipping Rate (PKR)</label>
                        <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] ?? '250' }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-gold mb-1 font-semibold">Free Shipping Threshold (PKR)</label>
                        <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] ?? '5000' }}"
                               class="w-full bg-brand-black/60 border border-brand-gold/60 rounded-lg px-3.5 py-2 text-brand-text font-bold focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Estimated Delivery Window</label>
                    <input type="text" name="delivery_estimate" value="{{ $settings['delivery_estimate'] ?? '2-4 Working Days via TCS / Leopards / PostEx / Trax' }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2 text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>
        </div>

        <!-- TAB 3: Pluggable Payment Gateways & Accounts -->
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
                        <span class="text-xs text-brand-text font-semibold">Enable COD Nationwide</span>
                    </label>
                </div>
            </div>

            <!-- Direct Bank Transfer & Raast -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-building-columns text-brand-gold"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Corporate Bank Account & Raast ID</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_bank_enabled" value="1" {{ ($settings['payment_bank_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text font-semibold">Enable Bank Transfer / Raast</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'Bank Alfalah Limited' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Account Title</label>
                        <input type="text" name="bank_account_title" value="{{ $settings['bank_account_title'] ?? 'RAVAHA PARFUMS PVT LTD' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '0142-1007894561' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">IBAN Number</label>
                        <input type="text" name="bank_iban" value="{{ $settings['bank_iban'] ?? 'PK36ALFH01421007894561' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-gold mb-1 font-semibold">Raast Instant ID</label>
                        <input type="text" name="bank_raast_id" value="{{ $settings['bank_raast_id'] ?? '923008765432' }}" class="w-full bg-brand-black/60 border border-brand-gold/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Branch Name / City</label>
                        <input type="text" name="bank_branch" value="{{ $settings['bank_branch'] ?? 'Main Boulevard Gulberg, Lahore' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
            </div>

            <!-- Mobile Wallets -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-emerald-400"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay)</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_wallet_enabled" value="1" {{ ($settings['payment_wallet_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text font-semibold">Enable Mobile Wallets</span>
                    </label>
                </div>

                <!-- EasyPaisa -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-xs font-bold uppercase text-emerald-400">EasyPaisa Account</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">EasyPaisa Account Title</label>
                            <input type="text" name="easypaisa_account_title" value="{{ $settings['easypaisa_account_title'] ?? ($settings['easypaisa_title'] ?? 'RAVAHA PARFUMS') }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                        </div>
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">EasyPaisa Mobile Number</label>
                            <input type="text" name="easypaisa_number" value="{{ $settings['easypaisa_number'] ?? '03008765432' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                        </div>
                    </div>
                </div>

                <!-- JazzCash Manual -->
                <div class="space-y-3 pt-3 border-t border-brand-border/40">
                    <h4 class="text-xs font-bold uppercase text-red-400">JazzCash Account</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">JazzCash Account Title</label>
                            <input type="text" name="jazzcash_account_title" value="{{ $settings['jazzcash_account_title'] ?? 'RAVAHA PARFUMS' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                        </div>
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">JazzCash Mobile Number</label>
                            <input type="text" name="jazzcash_number" value="{{ $settings['jazzcash_number'] ?? '03008765432' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                        </div>
                    </div>
                </div>

                <!-- SadaPay -->
                <div class="space-y-3 pt-3 border-t border-brand-border/40">
                    <h4 class="text-xs font-bold uppercase text-teal-400">SadaPay Account</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">SadaPay Account Title</label>
                            <input type="text" name="sadapay_account_title" value="{{ $settings['sadapay_account_title'] ?? 'RAVAHA PARFUMS' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                        </div>
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">SadaPay Mobile / Account</label>
                            <input type="text" name="sadapay_number" value="{{ $settings['sadapay_number'] ?? '03008765432' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                        </div>
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">SadaPay IBAN</label>
                            <input type="text" name="sadapay_iban" value="{{ $settings['sadapay_iban'] ?? 'PK89SADA00000003008765432' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                        </div>
                    </div>
                </div>

                <!-- NayaPay -->
                <div class="space-y-3 pt-3 border-t border-brand-border/40">
                    <h4 class="text-xs font-bold uppercase text-orange-400">NayaPay Account</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">NayaPay Account Title</label>
                            <input type="text" name="nayapay_account_title" value="{{ $settings['nayapay_account_title'] ?? 'RAVAHA PARFUMS' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                        </div>
                        <div>
                            <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">NayaPay ID (e.g. @ravaha)</label>
                            <input type="text" name="nayapay_id" value="{{ $settings['nayapay_id'] ?? '@ravaha' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <!-- JazzCash Merchant Gateway (Instant Automated) -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-400"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">JazzCash Merchant Online Gateway (Automated)</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_jazzcash_enabled" value="1" {{ ($settings['payment_jazzcash_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text font-semibold">Enable JazzCash Gateway</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Merchant ID</label>
                        <input type="text" name="jazzcash_merchant_id" value="{{ $settings['jazzcash_merchant_id'] ?? 'MC-RAVAHA-884' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Password</label>
                        <input type="password" name="jazzcash_password" value="{{ $settings['jazzcash_password'] ?? 'pass123' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Integrity Salt</label>
                        <input type="password" name="jazzcash_salt" value="{{ $settings['jazzcash_salt'] ?? 'salt_secret_key' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                </div>
            </div>

            <!-- Safepay Debit/Credit Card -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-brand-gold"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Safepay Card Gateway (Visa / Mastercard)</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="payment_safepay_enabled" value="1" {{ ($settings['payment_safepay_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text font-semibold">Enable Safepay</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">API Public Key</label>
                        <input type="text" name="safepay_api_key" value="{{ $settings['safepay_api_key'] ?? 'sec_test_12345' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text font-mono">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Secret Shared Key</label>
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
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Instagram Profile URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/ravahaparfums' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">Facebook Page URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com/ravahaparfums' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">TikTok Profile URL</label>
                        <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? 'https://tiktok.com/@ravahaparfums' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-brand-muted mb-1 font-semibold">YouTube Channel URL</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com/@ravahaparfums' }}" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl">
            <button type="submit" class="gold-btn px-6 py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save All Store Settings</span>
            </button>
        </div>
    </form>
</div>
@endsection
