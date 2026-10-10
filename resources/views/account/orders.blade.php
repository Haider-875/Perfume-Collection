@extends('layouts.app')

@section('title', 'Order Dossiers & History — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-5" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Acquisition Dossiers
                </span>
                <h1 class="font-serif fs-2 fw-normal mb-0" style="color: #211D1E;">Your Fragrance Orders</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="text-xs text-uppercase tracking-wider fw-semibold text-decoration-none" style="color: #541B29;">
                &larr; Back to Patron Suite
            </a>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 text-xs shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-user-circle"></i>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
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

            <!-- Orders Table Content -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Status Filter Pills -->
                <div class="d-flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('account.orders') }}" class="px-3 py-2 rounded-3 text-decoration-none shadow-sm {{ !$status || $status === 'all' ? 'text-white fw-bold' : '' }}" style="{{ !$status || $status === 'all' ? 'background-color: #541B29;' : 'background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                        All Dossiers
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'pending']) }}" class="px-3 py-2 rounded-3 text-decoration-none shadow-sm {{ $status === 'pending' ? 'text-white fw-bold' : '' }}" style="{{ $status === 'pending' ? 'background-color: #541B29;' : 'background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                        Pending Verification
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'confirmed']) }}" class="px-3 py-2 rounded-3 text-decoration-none shadow-sm {{ $status === 'confirmed' ? 'text-white fw-bold' : '' }}" style="{{ $status === 'confirmed' ? 'background-color: #541B29;' : 'background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                        Confirmed
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'shipped']) }}" class="px-3 py-2 rounded-3 text-decoration-none shadow-sm {{ $status === 'shipped' ? 'text-white fw-bold' : '' }}" style="{{ $status === 'shipped' ? 'background-color: #541B29;' : 'background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                        In Transit
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'delivered']) }}" class="px-3 py-2 rounded-3 text-decoration-none shadow-sm {{ $status === 'delivered' ? 'text-white fw-bold' : '' }}" style="{{ $status === 'delivered' ? 'background-color: #541B29;' : 'background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                        Delivered
                    </a>
                </div>

                <div class="p-4 p-md-5 rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    @if($orders->isNotEmpty())
                        <div class="d-flex flex-column gap-3">
                            @foreach($orders as $order)
                                <div class="py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="font-serif fs-5 fw-bold" style="color: #541B29;">{{ $order->order_number }}</span>
                                            <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->order_status === 'delivered' ? 'bg-success-subtle text-success-emphasis border border-success' : '' }}" style="font-size: 10px; {{ $order->order_status !== 'delivered' ? 'background-color: #FAF7F2; color: #541B29; border: 1px solid #E8E0DA;' : '' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                            @if($order->payment_status === 'pending_verification')
                                                <span class="text-uppercase tracking-wider px-2 py-0-5 bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded" style="font-size: 10px;">
                                                    Proof Required
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-0" style="font-size: 11px; color: #6B605B;">
                                            Commissioned: {{ $order->created_at->format('d M Y, h:i A') }} &bull; {{ $order->city }}, {{ $order->province }}
                                        </p>
                                        <p class="mb-0 opacity-75" style="font-size: 11px; color: #786C67;">
                                            Payment: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} ({{ strtoupper(str_replace('_', ' ', $order->payment_status)) }})
                                        </p>
                                    </div>

                                    <div class="d-flex align-items-center gap-4 text-md-end">
                                        <div>
                                            <div class="font-mono fs-6 fw-bold" style="color: #541B29 !important;">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div style="font-size: 11px; color: #786C67;">{{ $order->items->sum('quantity') }} Flacon(s)</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" 
                                           class="btn py-2 px-3 text-xs text-uppercase tracking-wider fw-semibold text-decoration-none rounded-3 text-white shadow-sm" style="background-color: #541B29;">
                                            Dossier Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 mt-4" style="border-top: 1px solid #E8E0DA;">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5 text-xs" style="color: #786C67;">
                            <p class="mb-3">No order dossiers match the selected status filter.</p>
                            <a href="{{ route('collections.show', 'all') }}" class="btn py-2 px-4 text-uppercase tracking-wider rounded-3 d-inline-block text-decoration-none text-white shadow-sm" style="background-color: #541B29;">
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
