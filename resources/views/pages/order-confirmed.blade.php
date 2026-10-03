@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-12 md:py-20 bg-[#050203] text-[#f5efe7] min-h-screen border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Success Celebration Banner -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 rounded-full bg-[#18050b] border-2 border-emerald-500/80 flex items-center justify-center text-emerald-400 mx-auto mb-4 shadow-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <span class="inline-block text-xs uppercase tracking-[0.28em] text-[#d6aa62] font-semibold px-4 py-1.5 bg-[#1f060d] border border-[#d6aa62]/30 rounded-full mb-3">
                Order Received
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-[#f5efe7] font-normal mb-2">Thank You, {{ $order->customer_name }}</h1>
            <p class="text-[#b8a9a2] text-sm max-w-lg mx-auto">
                Your bespoke fragrance order has been received. A detailed dispatch confirmation has been sent to <strong class="text-[#f5efe7]">{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-10 rounded-2xl shadow-xl space-y-8 mb-10">
            <!-- Order Reference Bar -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-[#d6aa62]/20">
                <div>
                    <span class="text-[11px] uppercase tracking-wider text-[#b8a9a2] block mb-0.5">Order Tracking Number</span>
                    <span class="font-serif text-2xl md:text-3xl text-[#f0d59d] font-bold">{{ $order->order_number }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[11px] uppercase tracking-wider text-[#b8a9a2] block mb-0.5">Payment Method</span>
                    <span class="text-xs uppercase tracking-wider px-3 py-1 bg-[#25050a] border border-[#d6aa62]/30 text-[#f5efe7] rounded-full font-semibold">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} &bull; {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>
            </div>

            <!-- Notice for Manual Bank / Wallet Transfers -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']) && $order->payment_status === 'pending_verification')
                <div class="bg-[#25050a] border border-[#d6aa62]/30 p-5 rounded-xl text-xs space-y-2 text-[#f5efe7]">
                    <div class="flex items-center gap-2 font-serif text-sm font-bold text-[#f0d59d]">
                        <svg class="w-5 h-5 flex-shrink-0 text-[#d6aa62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Payment Verification in Progress</span>
                    </div>
                    <p class="text-[#b8a9a2] leading-relaxed">
                        If you have already transferred the payment, our concierge team will verify your transaction reference / screenshot and confirm your order shortly.
                    </p>
                    @if(!$order->payment_receipt)
                        <div class="pt-1">
                            <a href="{{ route('account.order.show', $order->order_number) }}" class="inline-flex items-center gap-1.5 px-4 py-2 btn-gold text-xs font-semibold uppercase tracking-wider rounded-lg">
                                <span>Upload Payment Screenshot</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Items Ordered Breakdown -->
            <div>
                <h3 class="text-xs uppercase tracking-wider text-[#d6aa62] font-semibold mb-3">Items Ordered</h3>
                <div class="divide-y divide-[#d6aa62]/15 bg-[#080204] rounded-xl border border-[#d6aa62]/20 overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-4 flex items-center justify-between gap-4 text-xs">
                            <div>
                                <h4 class="font-serif text-base font-bold text-[#f5efe7]">{{ $item->product_name }}</h4>
                                <p class="text-[11px] text-[#b8a9a2]">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right font-mono text-[#f0d59d] font-bold">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="border-t border-[#d6aa62]/20 pt-4 space-y-2 text-xs">
                <div class="flex justify-between text-[#b8a9a2]">
                    <span>Subtotal:</span>
                    <span class="font-mono text-[#f5efe7]">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-[#f0d59d] font-semibold">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-[#b8a9a2]">
                    <span>Express Courier Delivery:</span>
                    <span class="font-mono text-[#d6aa62]">{{ $order->shipping_cost == 0 ? 'FREE' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="flex justify-between items-baseline pt-3 border-t border-[#d6aa62]/20 text-base font-semibold">
                    <span class="font-serif text-lg text-[#f5efe7]">Total Amount:</span>
                    <span class="font-serif text-2xl text-[#f0d59d] font-mono font-bold">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Recipient & Delivery Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-[#d6aa62]/20 text-xs">
                <div class="bg-[#080204] p-4 rounded-xl border border-[#d6aa62]/20 space-y-1.5">
                    <h4 class="text-[11px] uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Delivery Address</h4>
                    <p class="font-semibold text-[#f5efe7]">{{ $order->customer_name }}</p>
                    <p class="text-[#b8a9a2]">{{ $order->shipping_address }}</p>
                    @if($order->area)<p class="text-[#b8a9a2]">Area: {{ $order->area }}</p>@endif
                    <p class="text-[#b8a9a2]">{{ $order->city }}, {{ $order->province }}</p>
                    <p class="text-[#d6aa62] font-mono">Phone: {{ $order->customer_phone }}</p>
                </div>

                <div class="bg-[#080204] p-4 rounded-xl border border-[#d6aa62]/20 space-y-1.5">
                    <h4 class="text-[11px] uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Order Status & Instructions</h4>
                    <p class="text-[#b8a9a2]"><strong class="text-[#f5efe7]">Status:</strong> <span class="capitalize">{{ str_replace('_', ' ', $order->order_status) }}</span></p>
                    <p class="text-[#b8a9a2]"><strong class="text-[#f5efe7]">Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} (<span class="capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</span>)</p>
                    @if($order->order_notes)
                        <p class="text-[#b8a9a2] italic mt-2">"{{ $order->order_notes }}"</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Share & Track Order -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-[#d6aa62]/20">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="flex-1 py-3.5 btn-whatsapp font-semibold text-xs uppercase tracking-wider transition-all rounded-lg flex items-center justify-center gap-2 shadow-md">
                    <i class="fab fa-whatsapp text-lg"></i>
                    <span>Send Order Slip to WhatsApp</span>
                </a>

                <a href="{{ route('order.tracking', ['order_number' => $order->order_number, 'phone' => $order->customer_phone]) }}" 
                   class="flex-1 py-3.5 btn-gold font-semibold text-xs uppercase tracking-wider transition-all rounded-lg flex items-center justify-center gap-2 shadow-md">
                    <i class="fas fa-truck-fast text-sm"></i>
                    <span>Track Live Courier Consignment</span>
                </a>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('collections.show', 'all') }}" class="text-xs uppercase tracking-widest text-[#d6aa62] font-semibold hover:text-[#f0d59d] hover:underline">
                &larr; Continue Shopping at Perfumes Collection
            </a>
        </div>
    </div>
</div>
@endsection
