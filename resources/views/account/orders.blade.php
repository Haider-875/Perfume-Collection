@extends('layouts.app')

@section('title', 'Order Dossiers & History — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-10 border-b border-white/10">
            <div>
                <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-2">
                    Acquisition Dossiers
                </span>
                <h1 class="font-serif text-3xl md:text-4xl text-brand-gold font-light">Your Fragrance Orders</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="text-xs uppercase tracking-wider text-brand-gold hover:underline">
                &larr; Back to Patron Suite
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3">
                <nav class="bg-[#0d0608] border border-brand-gold/20 p-3 rounded-sm space-y-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded bg-brand-maroon/30 text-brand-gold font-semibold border-l-2 border-brand-gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Orders Table Content -->
            <div class="lg:col-span-9 space-y-6">
                <!-- Status Filter Pills -->
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('account.orders') }}" class="px-4 py-2 rounded {{ !$status || $status === 'all' ? 'bg-brand-gold text-black font-semibold' : 'bg-[#0d0608] border border-white/10 text-brand-ivory/70 hover:border-brand-gold' }}">
                        All Dossiers
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'pending']) }}" class="px-4 py-2 rounded {{ $status === 'pending' ? 'bg-brand-gold text-black font-semibold' : 'bg-[#0d0608] border border-white/10 text-brand-ivory/70 hover:border-brand-gold' }}">
                        Pending Verification
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded {{ $status === 'confirmed' ? 'bg-brand-gold text-black font-semibold' : 'bg-[#0d0608] border border-white/10 text-brand-ivory/70 hover:border-brand-gold' }}">
                        Confirmed
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'shipped']) }}" class="px-4 py-2 rounded {{ $status === 'shipped' ? 'bg-brand-gold text-black font-semibold' : 'bg-[#0d0608] border border-white/10 text-brand-ivory/70 hover:border-brand-gold' }}">
                        In Transit
                    </a>
                    <a href="{{ route('account.orders', ['status' => 'delivered']) }}" class="px-4 py-2 rounded {{ $status === 'delivered' ? 'bg-brand-gold text-black font-semibold' : 'bg-[#0d0608] border border-white/10 text-brand-ivory/70 hover:border-brand-gold' }}">
                        Delivered
                    </a>
                </div>

                <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                    @if($orders->isNotEmpty())
                        <div class="divide-y divide-white/5">
                            @foreach($orders as $order)
                                <div class="py-5 flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3">
                                            <span class="font-serif text-lg text-brand-gold font-semibold">{{ $order->order_number }}</span>
                                            <span class="text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded {{ $order->order_status === 'delivered' ? 'bg-green-950 text-green-300 border border-green-800' : 'bg-brand-maroon/30 text-brand-gold border border-brand-gold/30' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                            @if($order->payment_status === 'pending_verification')
                                                <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 bg-yellow-950 text-yellow-300 border border-yellow-700/50 rounded">
                                                    Proof Required
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-brand-ivory/60 text-[11px]">
                                            Commissioned: {{ $order->created_at->format('d M Y, h:i A') }} &bull; {{ $order->city }}, {{ $order->province }}
                                        </p>
                                        <p class="text-brand-ivory/40 text-[11px]">
                                            Payment: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} ({{ strtoupper(str_replace('_', ' ', $order->payment_status)) }})
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4 md:text-right">
                                        <div>
                                            <div class="font-mono text-base text-brand-gold font-semibold">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div class="text-[11px] text-brand-ivory/50">{{ $order->items->sum('quantity') }} Flacon(s)</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" 
                                           class="px-4 py-2 bg-gradient-to-r from-brand-gold to-brand-gold-light text-black font-semibold text-[11px] uppercase tracking-wider rounded-sm hover:brightness-110 transition-all">
                                            Dossier Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-6 border-t border-white/10">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-xs text-brand-ivory/50">
                            <p class="mb-4">No order dossiers match the selected status filter.</p>
                            <a href="{{ route('collections.index') }}" class="px-5 py-2.5 bg-brand-gold text-black font-semibold uppercase tracking-wider rounded inline-block">
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
