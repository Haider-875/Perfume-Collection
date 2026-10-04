@extends('layouts.app')

@section('title', 'Order Dossiers & History — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-5 border-bottom border-gold-20">
            <div>
                <span class="d-inline-block text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em;">
                    Acquisition Dossiers
                </span>
                <h1 class="font-serif fs-2 text-gold-soft fw-normal mb-0">Your Fragrance Orders</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="text-xs text-uppercase tracking-wider text-gold text-gold-hover text-decoration-none">
                &larr; Back to Patron Suite
            </a>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="bg-wine-card border border-gold-20 p-2 rounded-3 d-flex flex-column gap-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-muted-parchment text-gold-hover text-decoration-none transition">
                        <i class="fas fa-user-circle"></i>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 bg-wine-accent text-gold fw-semibold border-start border-3 border-gold text-decoration-none">
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

            <!-- Orders Table Content -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Status Filter Pills -->
                <div class="d-flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('account.orders') }}" class="px-3 py-2 rounded-3 text-decoration-none {{ !$status || $status === 'all' ? 'bg-gold text-dark fw-bold' : 'bg-wine-card border border-gold-20 text-muted-parchment text-gold-hover' }}">
                        All Dossiers
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'pending']) }}" class="px-3 py-2 rounded-3 text-decoration-none {{ $status === 'pending' ? 'bg-gold text-dark fw-bold' : 'bg-wine-card border border-gold-20 text-muted-parchment text-gold-hover' }}">
                        Pending Verification
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'confirmed']) }}" class="px-3 py-2 rounded-3 text-decoration-none {{ $status === 'confirmed' ? 'bg-gold text-dark fw-bold' : 'bg-wine-card border border-gold-20 text-muted-parchment text-gold-hover' }}">
                        Confirmed
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'shipped']) }}" class="px-3 py-2 rounded-3 text-decoration-none {{ $status === 'shipped' ? 'bg-gold text-dark fw-bold' : 'bg-wine-card border border-gold-20 text-muted-parchment text-gold-hover' }}">
                        In Transit
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'delivered']) }}" class="px-3 py-2 rounded-3 text-decoration-none {{ $status === 'delivered' ? 'bg-gold text-dark fw-bold' : 'bg-wine-card border border-gold-20 text-muted-parchment text-gold-hover' }}">
                        Delivered
                    </a>
                </div>

                <div class="bg-wine-card border border-gold-20 p-4 p-md-5 rounded-3 shadow-xl">
                    @if($orders->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($orders as $order)
                                <div class="py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-15' : '' }}">
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="font-serif fs-5 text-gold-soft fw-bold">{{ $order->order_number }}</span>
                                            <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->order_status === 'delivered' ? 'bg-success-subtle text-success border border-success' : 'bg-wine-dark text-gold border border-gold-30' }}" style="font-size: 10px;">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                            @if($order->payment_status === 'pending_verification')
                                                <span class="text-uppercase tracking-wider px-2 py-0-5 bg-warning-subtle text-warning border border-warning-subtle rounded" style="font-size: 10px;">
                                                    Proof Required
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-muted-parchment mb-0" style="font-size: 11px;">
                                            Commissioned: {{ $order->created_at->format('d M Y, h:i A') }} &bull; {{ $order->city }}, {{ $order->province }}
                                        </p>
                                        <p class="text-muted-parchment mb-0 opacity-75" style="font-size: 11px;">
                                            Payment: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} ({{ strtoupper(str_replace('_', ' ', $order->payment_status)) }})
                                        </p>
                                    </div>

                                    <div class="d-flex align-items-center gap-4 text-md-end">
                                        <div>
                                            <div class="font-mono fs-6 text-gold-soft fw-bold">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div class="text-muted-parchment" style="font-size: 11px;">{{ $order->items->sum('quantity') }} Flacon(s)</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" 
                                           class="btn-gold py-2 px-3 text-xs text-uppercase tracking-wider fw-semibold text-decoration-none rounded-3">
                                            Dossier Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 mt-4 border-top border-gold-20">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5 text-xs text-muted-parchment">
                            <p class="mb-3">No order dossiers match the selected status filter.</p>
                            <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-2 px-4 text-uppercase tracking-wider rounded-3 d-inline-block text-decoration-none">
                                Explore Fragrance Vault
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
