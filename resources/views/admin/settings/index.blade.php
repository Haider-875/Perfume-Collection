@extends('admin.layouts.admin')

@section('title', 'Brand & Gateway Settings')
@section('page_title', 'Brand Parameters & Payment Gateways')
@section('page_subtitle', 'Configure brand identity, shipping rates, Pakistani payment gateways, bank accounts, and concierge channels')

@section('content')
<div x-data="{ activeTab: 'general' }">
    <!-- Navigation Tabs -->
    <ul class="nav nav-pills gap-2 mb-4 bg-white p-2 border rounded-3 admin-card d-flex flex-wrap">
        <li class="nav-item">
            <button type="button" @click="activeTab = 'general'" 
                    :class="activeTab === 'general' ? 'nav-link active bg-primary text-white shadow-xs' : 'nav-link text-secondary'" 
                    class="fw-semibold px-3 py-2 small d-flex align-items-center gap-2 border-0">
                <i class="fa-solid fa-crown"></i>
                <span>Brand Identity</span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" @click="activeTab = 'shipping'" 
                    :class="activeTab === 'shipping' ? 'nav-link active bg-primary text-white shadow-xs' : 'nav-link text-secondary'" 
                    class="fw-semibold px-3 py-2 small d-flex align-items-center gap-2 border-0">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Shipping & Logistics</span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" @click="activeTab = 'payments'" 
                    :class="activeTab === 'payments' ? 'nav-link active bg-primary text-white shadow-xs' : 'nav-link text-secondary'" 
                    class="fw-semibold px-3 py-2 small d-flex align-items-center gap-2 border-0">
                <i class="fa-solid fa-credit-card"></i>
                <span>Payment Gateways & Banks</span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" @click="activeTab = 'social'" 
                    :class="activeTab === 'social' ? 'nav-link active bg-primary text-white shadow-xs' : 'nav-link text-secondary'" 
                    class="fw-semibold px-3 py-2 small d-flex align-items-center gap-2 border-0">
                <i class="fa-solid fa-share-nodes"></i>
                <span>Social & WhatsApp</span>
            </button>
        </li>
    </ul>

    <!-- Main Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- TAB 1: Brand Identity -->
        <div x-show="activeTab === 'general'" x-cloak>
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-crown text-primary small"></i>
                        <span>Brand & Boutique Parameters</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Brand / Store Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? ($settings['store_name'] ?? 'Perfumes Collection') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Concierge Support Email</label>
                            <input type="email" name="site_email" value="{{ $settings['site_email'] ?? ($settings['store_email'] ?? 'concierge@perfumes.pk') }}" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Official Contact Phone (+92)</label>
                            <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? ($settings['store_phone'] ?? '+92 336 3685732') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">WhatsApp Direct Number (e.g. 923363685732)</label>
                            <input type="text" name="site_whatsapp" value="{{ $settings['site_whatsapp'] ?? ($settings['store_whatsapp'] ?? '923363685732') }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Boutique Physical Address</label>
                        <input type="text" name="site_address" value="{{ $settings['site_address'] ?? ($settings['store_address'] ?? 'Gulberg III, Main Boulevard, Lahore, Pakistan') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Store Announcement Bar Text</label>
                        <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? 'FREE EXPRESS DELIVERY ON ORDERS OVER RS. 5,000 | 100% PURE EXTRAIT DE PARFUM' }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Meta Description (SEO)</label>
                            <textarea name="site_description" rows="3">{{ $settings['site_description'] ?? 'Artisanal luxury impressions hand-poured in Pakistan. Monumental longevity and projection.' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Brand Logo</label>
                            <input type="file" name="store_logo" accept="image/*,.svg" class="form-control form-control-sm">
                            @if(isset($settings['store_logo']))
                                <div class="mt-2 p-2 bg-light border rounded d-flex align-items-center gap-2">
                                    <img src="{{ asset($settings['store_logo']) }}" alt="Logo" class="object-fit-contain" style="height: 32px; max-width: 100px;">
                                    <small class="text-muted text-truncate" style="font-size: 0.72rem;">Current: {{ $settings['store_logo'] }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Shipping & Delivery -->
        <div x-show="activeTab === 'shipping'" x-cloak style="display: none;">
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-primary small"></i>
                        <span>Nationwide Shipping Parameters (Pakistan)</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Standard Shipping Rate (PKR)</label>
                            <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] ?? '250' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Free Shipping Threshold (PKR)</label>
                            <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] ?? '5000' }}" class="fw-bold">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Estimated Delivery Window</label>
                        <input type="text" name="delivery_estimate" value="{{ $settings['delivery_estimate'] ?? '2-4 Working Days via TCS / Leopards / PostEx / Trax' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Payment Gateways & Accounts -->
        <div x-show="activeTab === 'payments'" x-cloak style="display: none;">
            
            <!-- Cash on Delivery -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-hand-holding-dollar text-primary small"></i>
                        <span>Cash on Delivery (COD)</span>
                    </h6>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="payment_cod_enabled" id="codEnabledCheck" value="1" {{ ($settings['payment_cod_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="codEnabledCheck">
                            Enable COD Nationwide
                        </label>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-muted small mb-0">Allow patrons across Pakistan to pay upon delivery of their fragrance package via courier.</p>
                </div>
            </div>

            <!-- Direct Bank Transfer & Raast -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-building-columns text-primary small"></i>
                        <span>Corporate Bank Account & Raast ID</span>
                    </h6>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="payment_bank_enabled" id="bankEnabledCheck" value="1" {{ ($settings['payment_bank_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="bankEnabledCheck">
                            Enable Bank Transfer / Raast
                        </label>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'Bank Alfalah Limited' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Title</label>
                            <input type="text" name="bank_account_title" value="{{ $settings['bank_account_title'] ?? 'PERFUMES COLLECTION PVT LTD' }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Number</label>
                            <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '0142-1007894561' }}" class="font-monospace">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">IBAN Number</label>
                            <input type="text" name="bank_iban" value="{{ $settings['bank_iban'] ?? 'PK36ALFH01421007894561' }}" class="font-monospace">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-primary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Raast Instant ID</label>
                            <input type="text" name="bank_raast_id" value="{{ $settings['bank_raast_id'] ?? '923008765432' }}" class="font-monospace fw-bold">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Branch Name / City</label>
                            <input type="text" name="bank_branch" value="{{ $settings['bank_branch'] ?? 'Main Boulevard Gulberg, Lahore' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Wallets -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-wallet text-success small"></i>
                        <span>Mobile Wallets (EasyPaisa / JazzCash / SadaPay / NayaPay)</span>
                    </h6>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="payment_wallet_enabled" id="walletEnabledCheck" value="1" {{ ($settings['payment_wallet_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="walletEnabledCheck">
                            Enable Mobile Wallets
                        </label>
                    </div>
                </div>
                <div class="p-4">
                    <!-- EasyPaisa -->
                    <div class="mb-4">
                        <h6 class="small fw-bold text-success text-uppercase mb-2">EasyPaisa Account</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Title</label>
                                <input type="text" name="easypaisa_account_title" value="{{ $settings['easypaisa_account_title'] ?? ($settings['easypaisa_title'] ?? 'PERFUMES COLLECTION') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Mobile Number</label>
                                <input type="text" name="easypaisa_number" value="{{ $settings['easypaisa_number'] ?? '03008765432' }}" class="font-monospace">
                            </div>
                        </div>
                    </div>

                    <!-- JazzCash Manual -->
                    <div class="mb-4 pt-3 border-top">
                        <h6 class="small fw-bold text-danger text-uppercase mb-2">JazzCash Account</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Title</label>
                                <input type="text" name="jazzcash_account_title" value="{{ $settings['jazzcash_account_title'] ?? 'PERFUMES COLLECTION' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Mobile Number</label>
                                <input type="text" name="jazzcash_number" value="{{ $settings['jazzcash_number'] ?? '03008765432' }}" class="font-monospace">
                            </div>
                        </div>
                    </div>

                    <!-- SadaPay -->
                    <div class="mb-4 pt-3 border-top">
                        <h6 class="small fw-bold text-info text-uppercase mb-2">SadaPay Account</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Title</label>
                                <input type="text" name="sadapay_account_title" value="{{ $settings['sadapay_account_title'] ?? 'PERFUMES COLLECTION' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Mobile / Account Number</label>
                                <input type="text" name="sadapay_number" value="{{ $settings['sadapay_number'] ?? '03008765432' }}" class="font-monospace">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">SadaPay IBAN</label>
                                <input type="text" name="sadapay_iban" value="{{ $settings['sadapay_iban'] ?? 'PK89SADA00000003008765432' }}" class="font-monospace">
                            </div>
                        </div>
                    </div>

                    <!-- NayaPay -->
                    <div class="pt-3 border-top">
                        <h6 class="small fw-bold text-warning text-uppercase mb-2">NayaPay Account</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Account Title</label>
                                <input type="text" name="nayapay_account_title" value="{{ $settings['nayapay_account_title'] ?? 'PERFUMES COLLECTION' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">NayaPay ID (e.g. @perfumes)</label>
                                <input type="text" name="nayapay_id" value="{{ $settings['nayapay_id'] ?? '@perfumes' }}" class="font-monospace">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JazzCash Merchant Gateway (Instant Automated) -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-bolt text-warning small"></i>
                        <span>JazzCash Merchant Online Gateway (Automated)</span>
                    </h6>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="payment_jazzcash_enabled" id="jazzcashGatewayCheck" value="1" {{ ($settings['payment_jazzcash_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="jazzcashGatewayCheck">
                            Enable JazzCash Gateway
                        </label>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Merchant ID</label>
                            <input type="text" name="jazzcash_merchant_id" value="{{ $settings['jazzcash_merchant_id'] ?? 'MC-PERFUMES-884' }}" class="font-monospace">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Password</label>
                            <input type="password" name="jazzcash_password" value="{{ $settings['jazzcash_password'] ?? 'pass123' }}" class="font-monospace">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Integrity Salt</label>
                            <input type="password" name="jazzcash_salt" value="{{ $settings['jazzcash_salt'] ?? 'salt_secret_key' }}" class="font-monospace">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Safepay Debit/Credit Card -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-primary small"></i>
                        <span>Safepay Card Gateway (Visa / Mastercard)</span>
                    </h6>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="payment_safepay_enabled" id="safepayCheck" value="1" {{ ($settings['payment_safepay_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="safepayCheck">
                            Enable Safepay
                        </label>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">API Public Key</label>
                            <input type="text" name="safepay_api_key" value="{{ $settings['safepay_api_key'] ?? 'sec_test_12345' }}" class="font-monospace">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Secret Shared Key</label>
                            <input type="password" name="safepay_secret" value="{{ $settings['safepay_secret'] ?? 'shared_secret_123' }}" class="font-monospace">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Social & Concierge -->
        <div x-show="activeTab === 'social'" x-cloak style="display: none;">
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-primary small"></i>
                        <span>Social Channels & Digital Presence</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Instagram Profile URL</label>
                            <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/perfumescollection' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Facebook Page URL</label>
                            <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com/perfumescollection' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">TikTok Profile URL</label>
                            <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? 'https://tiktok.com/@perfumescollection' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">YouTube Channel URL</label>
                            <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com/@perfumescollection' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky or Bottom Submit Bar -->
        <div class="admin-card p-3 d-flex align-items-center justify-content-end bg-white">
            <button type="submit" class="admin-btn-primary px-4 py-2 fs-6">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                <span>Save All Store Settings</span>
            </button>
        </div>
    </form>
</div>
@endsection
