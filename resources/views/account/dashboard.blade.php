@extends('layouts.app')

@section('title', 'Patron Dossier & Vault — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <!-- Account Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-5" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Private Patron Suite
                </span>
                <h1 class="font-serif fs-2 fw-normal mb-1" style="color: #211D1E;">Welcome, {{ $user->name }}</h1>
                <p class="text-xs mb-0" style="color: #6B605B;">{{ $user->email }} &bull; Patron Since {{ $user->created_at->format('M Y') }}</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('collections.show', 'all') }}" class="btn py-2 px-3 text-xs text-uppercase tracking-widest text-decoration-none rounded-3 text-white shadow-sm" style="background-color: #541B29;">
                    Explore Vault
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn py-2 px-3 text-xs text-uppercase tracking-wider rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 text-xs shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
                        <i class="fas fa-user-circle"></i>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-box-archive"></i>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-location-dot"></i>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-heart"></i>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-star"></i>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content Panel -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Patron Metric Cards -->
                <div class="row g-3">
                    <div class="col-12 col-sm-4">
                        <div class="p-4 rounded-3 h-100 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <span class="d-block text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em; color: #786C67;">Total Orders</span>
                            <div class="font-serif fs-2 fw-bold" style="color: #541B29;">{{ $totalOrdersCount }}</div>
                            <span class="d-block mt-1" style="font-size: 11px; color: #786C67;">Lifetime Dossiers</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-4 rounded-3 h-100 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <span class="d-block text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em; color: #786C67;">Total Valuation</span>
                            <div class="font-serif fs-2 font-mono fw-bold" style="color: #541B29 !important;">Rs. {{ number_format($totalSpent, 0) }}</div>
                            <span class="d-block mt-1" style="font-size: 11px; color: #786C67;">Extrait Acquisitions</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-4 rounded-3 h-100 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <span class="d-block text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em; color: #786C67;">Preserved Wishlist</span>
                            <div class="font-serif fs-2 fw-bold" style="color: #541B29;">{{ $wishlistCount }}</div>
                            <span class="d-block mt-1" style="font-size: 11px; color: #786C67;">Curated Flacons</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Section -->
                <div class="p-4 p-md-5 rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <h2 class="font-serif fs-4 fw-normal mb-0" style="color: #211D1E;">Recent Order Dossiers</h2>
                        <a href="{{ route('account.orders') }}" class="text-xs text-uppercase tracking-wider fw-semibold text-decoration-none" style="color: #541B29;">
                            View All Dossiers &rarr;
                        </a>
                    </div>

                    @if($recentOrders->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentOrders as $order)
                                <div class="py-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="font-serif fs-6 fw-bold" style="color: #541B29;">{{ $order->order_number }}</span>
                                            <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->order_status === 'delivered' ? 'bg-success-subtle text-success-emphasis border border-success' : '' }}" style="font-size: 10px; {{ $order->order_status !== 'delivered' ? 'background-color: #FAF7F2; color: #541B29; border: 1px solid #E8E0DA;' : '' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                        </div>
                                        <p class="mt-1 mb-0" style="font-size: 11px; color: #6B605B;">
                                            Placed on {{ $order->created_at->format('d M Y') }} &bull; {{ $order->items->count() }} Creation(s) &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center gap-4 text-sm-end">
                                        <div>
                                            <div class="font-mono fs-6 fw-bold" style="color: #541B29 !important;">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div class="text-uppercase" style="font-size: 10px; color: #786C67;">{{ $order->payment_status }}</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" class="btn btn-sm py-1 px-3 text-decoration-none text-uppercase shadow-sm" style="font-size: 11px; letter-spacing: 0.05em; background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                                            Inspect
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-xs" style="color: #786C67;">
                            <p class="mb-3">You have not commissioned any luxury fragrance dossiers yet.</p>
                            <a href="{{ route('collections.show', 'all') }}" class="btn py-2 px-4 text-uppercase tracking-wider rounded-3 d-inline-block text-decoration-none text-white shadow-sm" style="background-color: #541B29;">
                                Explore Vault
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Primary Address & Concierge Assistance -->
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-3 text-xs d-flex flex-column gap-2 h-100 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h3 class="font-serif fs-6 mb-0" style="color: #211D1E;">Primary Delivery Destination</h3>
                                <a href="{{ route('account.addresses') }}" class="text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px; color: #541B29;">Manage</a>
                            </div>
                            @if($defaultAddress)
                                <p class="fw-semibold mb-0" style="color: #211D1E;">{{ $defaultAddress->recipient_name }}</p>
                                <p class="mb-0" style="color: #6B605B;">{{ $defaultAddress->street_address }}</p>
                                <p class="mb-0" style="color: #6B605B;">{{ $defaultAddress->city }}, {{ $defaultAddress->province }}</p>
                                <p class="mb-0 font-mono" style="color: #6B605B;">Phone: {{ $defaultAddress->phone }}</p>
                            @else
                                <p class="mb-0" style="color: #786C67;">No default delivery address configured yet.</p>
                                <a href="{{ route('account.addresses') }}" class="text-decoration-underline d-inline-block mt-1 fw-semibold" style="color: #541B29;">Add Delivery Address</a>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-3 text-xs d-flex flex-column gap-2 h-100 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <h3 class="font-serif fs-6 mb-0" style="color: #211D1E;">Private Concierge Support</h3>
                            <p class="lh-base mb-0" style="color: #6B605B;">
                                Have questions regarding a custom extrait flacon, delivery rerouting, or scent curation?
                            </p>
                            <div class="pt-2">
                                <a href="https://wa.me/{{ $whatsappNum ?? '923363685732' }}" target="_blank" rel="noopener noreferrer" 
                                   class="py-2 px-3 text-uppercase tracking-wider fw-semibold d-inline-flex align-items-center gap-2 text-decoration-none rounded-3 text-white shadow-sm" style="font-size: 11px; background-color: #25D366;">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Connect via WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
