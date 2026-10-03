@extends('layouts.app')

@section('title', 'Patron Dossier & Vault — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Account Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-10 border-b border-white/10">
            <div>
                <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-2">
                    Private Patron Suite
                </span>
                <h1 class="font-serif text-3xl md:text-4xl text-brand-gold font-light">Welcome, {{ $user->name }}</h1>
                <p class="text-xs text-brand-ivory/60 mt-1">{{ $user->email }} &bull; Patron Since {{ $user->created_at->format('M Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('collections.index') }}" class="px-5 py-2.5 bg-brand-gold text-black font-semibold text-xs uppercase tracking-[0.2em] rounded-sm hover:brightness-110 transition-all">
                    Explore Vault
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 bg-black/60 border border-white/20 text-brand-ivory/80 hover:text-red-400 hover:border-red-500/40 text-xs uppercase tracking-wider rounded-sm transition-all">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3 space-y-2">
                <nav class="bg-[#0d0608] border border-brand-gold/20 p-3 rounded-sm space-y-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded bg-brand-maroon/30 text-brand-gold font-semibold border-l-2 border-brand-gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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

            <!-- Main Content Panel -->
            <div class="lg:col-span-9 space-y-8">
                <!-- Patron Metric Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-5 rounded-sm">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Total Orders</span>
                        <div class="font-serif text-3xl text-brand-gold">{{ $totalOrdersCount }}</div>
                        <span class="text-[11px] text-brand-ivory/40 mt-1 block">Lifetime Dossiers</span>
                    </div>
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-5 rounded-sm">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Total Valuation</span>
                        <div class="font-serif text-3xl text-brand-gold">Rs. {{ number_format($totalSpent, 0) }}</div>
                        <span class="text-[11px] text-brand-ivory/40 mt-1 block">Extrait Acquisitions</span>
                    </div>
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-5 rounded-sm">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Preserved Wishlist</span>
                        <div class="font-serif text-3xl text-brand-gold">{{ $wishlistCount }}</div>
                        <span class="text-[11px] text-brand-ivory/40 mt-1 block">Curated Flacons</span>
                    </div>
                </div>

                <!-- Recent Orders Section -->
                <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-white/10">
                        <h2 class="font-serif text-xl text-brand-gold font-light">Recent Order Dossiers</h2>
                        <a href="{{ route('account.orders') }}" class="text-xs uppercase tracking-wider text-brand-gold hover:underline">
                            View All Dossiers &rarr;
                        </a>
                    </div>

                    @if($recentOrders->isNotEmpty())
                        <div class="divide-y divide-white/5">
                            @foreach($recentOrders as $order)
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <span class="font-serif text-base text-brand-gold font-semibold">{{ $order->order_number }}</span>
                                            <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 rounded {{ $order->order_status === 'delivered' ? 'bg-green-950 text-green-300 border border-green-800' : 'bg-brand-maroon/30 text-brand-gold border border-brand-gold/30' }}">
                                                {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                                            </span>
                                        </div>
                                        <p class="text-brand-ivory/50 text-[11px] mt-1">
                                            Placed on {{ $order->created_at->format('d M Y') }} &bull; {{ $order->items->count() }} Creation(s) &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4 sm:text-right">
                                        <div>
                                            <div class="font-mono text-sm text-brand-gold font-semibold">Rs. {{ number_format($order->total_amount, 0) }}</div>
                                            <div class="text-[10px] text-brand-ivory/50 uppercase">{{ $order->payment_status }}</div>
                                        </div>
                                        <a href="{{ route('account.order.show', $order->order_number) }}" class="px-3 py-1.5 bg-brand-gold/10 hover:bg-brand-gold text-brand-gold hover:text-black border border-brand-gold/40 text-[11px] uppercase tracking-wider rounded transition-all">
                                            Inspect
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 text-xs text-brand-ivory/50">
                            <p class="mb-4">You have not commissioned any luxury fragrance dossiers yet.</p>
                            <a href="{{ route('collections.index') }}" class="px-5 py-2.5 bg-brand-gold text-black font-semibold uppercase tracking-wider rounded inline-block">
                                Explore Vault
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Primary Address & Concierge Assistance -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-6 rounded-sm text-xs space-y-2">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-serif text-base text-brand-gold">Primary Delivery Destination</h3>
                            <a href="{{ route('account.addresses') }}" class="text-[11px] text-brand-gold underline uppercase">Manage</a>
                        </div>
                        @if($defaultAddress)
                            <p class="font-semibold text-brand-ivory">{{ $defaultAddress->recipient_name }}</p>
                            <p class="text-brand-ivory/70">{{ $defaultAddress->street_address }}</p>
                            <p class="text-brand-ivory/70">{{ $defaultAddress->city }}, {{ $defaultAddress->province }}</p>
                            <p class="text-brand-ivory/50">Phone: {{ $defaultAddress->phone }}</p>
                        @else
                            <p class="text-brand-ivory/50">No default delivery address configured yet.</p>
                            <a href="{{ route('account.addresses') }}" class="text-brand-gold underline inline-block mt-2">Add Delivery Address</a>
                        @endif
                    </div>

                    <div class="bg-gradient-to-r from-brand-maroon/30 to-[#0d0608] border border-brand-gold/20 p-6 rounded-sm text-xs space-y-2">
                        <h3 class="font-serif text-base text-brand-gold">Private Concierge Support</h3>
                        <p class="text-brand-ivory/70 leading-relaxed">
                            Have questions regarding a custom extrait flacon, delivery rerouting, or scent curation?
                        </p>
                        <div class="pt-2">
                            <a href="https://wa.me/923001234567" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-[#25D366] hover:bg-[#20ba59] text-black font-semibold uppercase tracking-wider text-[11px] rounded transition-all">
                                <span>Connect via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
