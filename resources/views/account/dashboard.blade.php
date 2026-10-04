@extends('layouts.app')

@section('title', 'Patron Dossier & Vault — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <!-- Account Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-5 border-bottom border-gold-20">
            <div>
                <span class="d-inline-block text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em;">
                    Private Patron Suite
                </span>
                <h1 class="font-serif fs-2 text-gold-soft fw-normal mb-1">Welcome, {{ $user->name }}</h1>
                <p class="text-xs text-muted-parchment mb-0">{{ $user->email }} &bull; Patron Since {{ $user->created_at->format('M Y') }}</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-2 px-3 text-xs text-uppercase tracking-widest text-decoration-none rounded-3">
                    Explore Vault
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light py-2 px-3 text-xs text-uppercase tracking-wider rounded-3">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="bg-wine-card border border-gold-20 p-2 rounded-3 d-flex flex-column gap-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 bg-wine-accent text-gold fw-semibold border-start border-3 border-gold text-decoration-none">
                        <i class="fas fa-user-circle"></i>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-muted-parchment text-gold-hover text-decoration-none transition">
                        <i class="fas fa-box-archive"></i>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-muted-parchment text-gold-hover text-decoration-none transition">
                        <i class="fas fa-location-dot"></i>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-muted-parchment text-gold-hover text-decoration-none transition">
                        <i class="fas fa-heart"></i>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-muted-parchment text-gold-hover text-decoration-none transition">
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
                        <div class="bg-wine-card border border-gold-20 p-4 rounded-3 h-100">
                            <span class="d-block text-muted-parchment text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em;">Total Orders</span>
                            <div class="font-serif fs-2 text-gold-soft">{{ $totalOrdersCount }}</div>
                            <span class="d-block text-muted-parchment mt-1" style="font-size: 11px;">Lifetime Dossiers</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="bg-wine-card border border-gold-20 p-4 rounded-3 h-100">
                            <span class="d-block text-muted-parchment text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em;">Total Valuation</span>
                            <div class="font-serif fs-2 text-gold-soft font-mono">Rs. {{ number_format($totalSpent, 0) }}</div>
                            <span class="d-block text-muted-parchment mt-1" style="font-size: 11px;">Extrait Acquisitions</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="bg-wine-card border border-gold-20 p-4 rounded-3 h-100">
                            <span class="d-block text-muted-parchment text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.2em;">Preserved Wishlist</span>
                            <div class="font-serif fs-2 text-gold-soft">{{ $wishlistCount }}</div>
                            <span class="d-block text-muted-parchment mt-1" style="font-size: 11px;">Curated Flacons</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Section -->
                <div class="bg-wine-card border border-gold-20 p-4 p-md-5 rounded-3 shadow-xl">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom border-gold-20">
                        <h2 class="font-serif fs-4 text-gold-soft fw-normal mb-0">Recent Order Dossiers</h2>
                        <a href="{{ route('account.orders') }}" class="text-xs text-uppercase tracking-wider text-gold text-gold-hover text-decoration-none">
                            View All Dossiers &rarr;
                        </a>
                    </div>

                    @if($recentOrders->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentOrders as $order)
                                <div class="py-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-15' : '' }}">
                                    <div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="font-serif fs-6 text-gold-soft fw-bold">{{ $order->order_number }}</span>
                                            <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->order_status === 'delivered' ? 'bg-success-subtle text-success-emphasis border border-success' : 'bg-wine-dark text-gold border border-gold-30' }}" style="font-size: 10px;">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                        </div>
                                        <p class="text-muted-parchment mt-1 mb-0" style="font-size: 11px;">
                                            Placed on {{ $order->created_at->format('d M Y') }} &bull; {{ $order->items->count() }} Creation(s) &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center gap-4 text-sm-end">
                                        <div>
                                            <div class="font-mono fs-6 text-gold fw-bold">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div class="text-muted-parchment text-uppercase" style="font-size: 10px;">{{ $order->payment_status }}</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" class="btn btn-outline-light py-1 px-3 text-gold border-gold-30 text-gold-hover text-decoration-none text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">
                                            Inspect
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-xs text-muted-parchment">
                            <p class="mb-3">You have not commissioned any luxury fragrance dossiers yet.</p>
                            <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-2 px-4 text-uppercase tracking-wider rounded-3 d-inline-block text-decoration-none">
                                Explore Vault
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Primary Address & Concierge Assistance -->
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="bg-wine-card border border-gold-20 p-4 rounded-3 text-xs d-flex flex-column gap-2 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h3 class="font-serif fs-6 text-gold-soft mb-0">Primary Delivery Destination</h3>
                                <a href="{{ route('account.addresses') }}" class="text-gold text-decoration-underline text-uppercase" style="font-size: 11px;">Manage</a>
                            </div>
                            @if($defaultAddress)
                                <p class="fw-semibold text-light-parchment mb-0">{{ $defaultAddress->recipient_name }}</p>
                                <p class="text-muted-parchment mb-0">{{ $defaultAddress->street_address }}</p>
                                <p class="text-muted-parchment mb-0">{{ $defaultAddress->city }}, {{ $defaultAddress->province }}</p>
                                <p class="text-muted-parchment mb-0">Phone: {{ $defaultAddress->phone }}</p>
                            @else
                                <p class="text-muted-parchment mb-0">No default delivery address configured yet.</p>
                                <a href="{{ route('account.addresses') }}" class="text-gold text-decoration-underline d-inline-block mt-1">Add Delivery Address</a>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="bg-wine-card border border-gold-20 p-4 rounded-3 text-xs d-flex flex-column gap-2 h-100">
                            <h3 class="font-serif fs-6 text-gold-soft mb-0">Private Concierge Support</h3>
                            <p class="text-muted-parchment lh-base mb-0">
                                Have questions regarding a custom extrait flacon, delivery rerouting, or scent curation?
                            </p>
                            <div class="pt-2">
                                <a href="https://wa.me/923001234567" target="_blank" rel="noopener noreferrer" 
                                   class="btn-whatsapp py-2 px-3 text-uppercase tracking-wider fw-semibold d-inline-flex align-items-center gap-2 text-decoration-none rounded-3" style="font-size: 11px;">
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
