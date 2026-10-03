@extends('layouts.app')

@section('title', 'Dossier Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-12 md:py-20 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-12">
            <div class="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-2 border-brand-gold/20 animate-ping"></div>
                <div class="w-16 h-16 rounded-full bg-brand-gold/10 border-2 border-brand-gold flex items-center justify-center text-brand-gold shadow-[0_0_25px_rgba(201,162,75,0.4)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <span class="inline-block text-xs uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full mb-3">
                Order Confirmed
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-brand-gold font-light mb-2">Thank You, {{ $order->customer_name }}</h1>
            <p class="text-brand-ivory/70 text-sm max-w-lg mx-auto">
                Your bespoke fragrance dossier has been formally commissioned. A confirmation has been dispatched to <strong class="text-brand-ivory">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Dossier Card -->
        <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-10 rounded-sm shadow-2xl space-y-8 mb-10">
            <!-- Order Reference Bar -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-white/10">
                <div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Dossier Tracking Number</span>
                    <span class="font-serif text-2xl md:text-3xl text-brand-gold font-semibold">{{ $order->order_number }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Payment Dossier</span>
                    <span class="text-xs uppercase tracking-wider px-3 py-1 bg-brand-gold/10 border border-brand-gold/30 text-brand-gold rounded-full font-semibold">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="bg-gradient-to-r from-brand-maroon/40 via-[#1a0a0e] to-brand-maroon/30 border border-brand-gold/40 p-6 rounded-sm text-xs space-y-3">
                    <div class="flex items-center gap-2 text-brand-gold font-serif text-sm font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Manual Payment Verification in Progress</span>
                    </div>
                    <p class="text-brand-ivory/80 leading-relaxed">
                        If you have already submitted your transaction reference / receipt, our finance concierge will verify and update your dossier within 30–60 minutes.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-2">
                            <a href="{{ route('account.order.show', $order->order_number) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-gold text-black font-semibold uppercase tracking-wider text-[11px] rounded hover:brightness-110">
                                <span>Upload Payment Screenshot Now</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown -->
            <div>
                <h3 class="text-xs uppercase tracking-[0.2em] text-brand-gold font-semibold mb-4">Commissioned Flacons</h3>
                <div class="divide-y divide-white/5 bg-black/40 rounded border border-white/5 overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-4 flex items-center justify-between gap-4 text-xs">
                            <div>
                                <h4 class="font-serif text-sm font-semibold text-brand-ivory">{{ $item->product_name }}</h4>
                                <p class="text-[11px] text-brand-ivory/50">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right font-mono text-brand-gold font-semibold">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="border-t border-white/10 pt-4 space-y-2 text-xs">
                <div class="flex justify-between text-brand-ivory/70">
                    <span>Subtotal:</span>
                    <span class="font-mono text-brand-ivory">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-brand-gold">
                        <span>Privilege Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-brand-ivory/70">
                    <span>White-Glove Express Courier:</span>
                    <span class="font-mono text-brand-ivory">{{ $order->shipping_cost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="flex justify-between items-baseline pt-3 border-t border-brand-gold/30 text-base font-semibold">
                    <span class="font-serif text-lg text-brand-gold">Total Amount Due:</span>
                    <span class="font-serif text-2xl text-brand-gold font-mono">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-white/10 text-xs">
                <div class="bg-black/40 p-4 rounded border border-white/5 space-y-1.5">
                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-brand-gold mb-2 font-semibold">Delivery Destination</h4>
                    <p class="font-semibold text-brand-ivory">{{ $order->customer_name }}</p>
                    <p class="text-brand-ivory/70">{{ $order->shipping_address }}</p>
                    @if($order->area)<p class="text-brand-ivory/60">Area: {{ $order->area }}</p>@endif
                    <p class="text-brand-ivory/80">{{ $order->city }}, {{ $order->province }}</p>
                    <p class="text-brand-ivory/60">Phone: {{ $order->customer_phone }}</p>
                </div>

                <div class="bg-black/40 p-4 rounded border border-white/5 space-y-1.5">
                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-brand-gold mb-2 font-semibold">Concierge Notes & Status</h4>
                    <p class="text-brand-ivory/70"><strong class="text-brand-gold">Order Status:</strong> {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}</p>
                    <p class="text-brand-ivory/70"><strong class="text-brand-gold">Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} ({{ strtoupper(str_replace('_', ' ', $order->payment_status)) }})</p>
                    @if($order->order_notes)
                        <p class="text-brand-ivory/60 italic mt-2">"{{ $order->order_notes }}"</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Share & Track Order -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-white/10">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="flex-1 py-3.5 bg-[#25D366] hover:bg-[#20ba59] text-black font-semibold text-xs uppercase tracking-[0.2em] transition-all rounded-sm flex items-center justify-center gap-2 shadow-lg">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Notify Concierge on WhatsApp</span>
                </a>

                <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                   class="flex-1 py-3.5 bg-gradient-to-r from-brand-gold to-brand-gold-light text-black font-semibold text-xs uppercase tracking-[0.2em] transition-all rounded-sm flex items-center justify-center gap-2 shadow-lg hover:brightness-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Track Live Consignment</span>
                </a>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('collections.index') }}" class="text-xs uppercase tracking-[0.25em] text-brand-gold hover:underline">
                &larr; Continue Exploring The Perfume Vault
            </a>
        </div>
    </div>
</div>
@endsection
