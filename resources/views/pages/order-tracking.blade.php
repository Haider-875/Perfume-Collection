@extends('layouts.app')

@section('title', 'Consignment Tracking & Dossier Status — Perfumes Collection')

@section('content')
<div class="py-12 md:py-20 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="inline-block text-xs uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full mb-3">
                White-Glove Logistics
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-brand-gold font-light mb-4">Consignment Dossier Tracking</h1>
            <p class="text-brand-ivory/60 text-sm max-w-xl mx-auto leading-relaxed">
                Track the handcrafted journey of your luxury flacons from our private compounding vault to your doorstep across Pakistan.
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-2xl mb-12">
            <form action="{{ route('order.tracking') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <label class="block text-xs uppercase tracking-[0.2em] text-brand-gold mb-2 font-medium">Order Number</label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" placeholder="e.g. PC-100245" 
                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-sm text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none transition-all rounded-sm font-mono">
                </div>
                <div class="md:col-span-5">
                    <label class="block text-xs uppercase tracking-[0.2em] text-brand-gold mb-2 font-medium">Pakistani Phone Number</label>
                    <input type="text" name="phone" value="{{ $phone }}" placeholder="e.g. 03001234567" 
                           class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-sm text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none transition-all rounded-sm">
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-gold to-brand-gold-light text-black font-semibold text-xs uppercase tracking-[0.2em] hover:brightness-110 transition-all rounded-sm shadow-lg">
                        Track
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Tracking Results -->
                <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-10 rounded-sm shadow-2xl mb-12 space-y-8 animate-fadeIn">
                    <!-- Order Meta Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-white/10">
                        <div>
                            <span class="text-xs uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Dossier Reference</span>
                            <span class="font-serif text-2xl md:text-3xl text-brand-gold">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs uppercase tracking-[0.2em] text-brand-ivory/50 block mb-1">Placed On</span>
                            <span class="text-sm font-mono text-brand-ivory">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Visual Luxury Status Timeline -->
                    <div>
                        <h3 class="text-xs uppercase tracking-[0.25em] text-brand-gold mb-8 text-center md:text-left">Consignment Progress</h3>
                        
                        @php
                            $statuses = [
                                'pending' => ['label' => 'Dossier Received', 'desc' => 'Order created in system'],
                                'confirmed' => ['label' => 'Artisan Confirmed', 'desc' => 'Verified & queued for vault'],
                                'packed' => ['label' => 'Hand-Bottled & Sealed', 'desc' => 'Custom packaging & ribbons'],
                                'shipped' => ['label' => 'In Courier Transit', 'desc' => 'Dispatched with tracking'],
                                'delivered' => ['label' => 'Safely Delivered', 'desc' => 'Delivered to patron'],
                            ];
                            
                            $statusKeys = array_keys($statuses);
                            $currentStatus = $order->order_status;
                            if ($currentStatus === 'pending_verification') $currentStatus = 'pending';
                            $currentIndex = array_search($currentStatus, $statusKeys);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        <div class="relative">
                            <!-- Progress Bar Line -->
                            <div class="hidden md:block absolute top-5 left-8 right-8 h-0.5 bg-white/10 -z-0">
                                <div class="h-full bg-gradient-to-r from-brand-gold to-brand-gold-light transition-all duration-700" 
                                     style="width: {{ count($statusKeys) > 1 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0 }}%;"></div>
                            </div>

                            <!-- Steps Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 relative z-10">
                                @foreach($statuses as $key => $step)
                                    @php
                                        $index = array_search($key, $statusKeys);
                                        $isPassed = $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp
                                    <div class="flex md:flex-col items-center md:text-center gap-4 md:gap-2">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-300 {{ $isPassed ? 'bg-brand-gold text-black font-bold shadow-[0_0_15px_rgba(201,162,75,0.5)]' : 'bg-black/80 border border-white/20 text-brand-ivory/40' }}">
                                            @if($isPassed)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <span class="text-xs font-mono">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-xs uppercase tracking-[0.15em] font-semibold {{ $isPassed ? 'text-brand-gold' : 'text-brand-ivory/40' }} {{ $isCurrent ? 'underline decoration-brand-gold decoration-2 underline-offset-4' : '' }}">
                                                {{ $step['label'] }}
                                            </h4>
                                            <p class="text-[11px] text-brand-ivory/50 mt-0.5 hidden md:block">{{ $step['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Courier Details Card (if shipped) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="bg-gradient-to-r from-brand-maroon/30 via-black/40 to-brand-maroon/20 border border-brand-gold/30 p-6 rounded-sm">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <span class="text-[10px] uppercase tracking-[0.2em] text-brand-gold block mb-1">Pakistani Courier Partner</span>
                                    <div class="text-lg font-serif text-brand-ivory font-semibold">{{ $order->courier_name ?? 'TCS Express Courier' }}</div>
                                    <div class="text-xs font-mono text-brand-ivory/70 mt-1">
                                        Tracking CN: <span class="text-brand-gold">{{ $order->tracking_number ?? 'In Transit' }}</span>
                                    </div>
                                </div>
                                @if($order->tracking_link)
                                    <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="px-5 py-2.5 bg-brand-gold/20 hover:bg-brand-gold text-brand-gold hover:text-black border border-brand-gold text-xs uppercase tracking-[0.2em] transition-all rounded-sm font-semibold inline-flex items-center gap-2">
                                        <span>Live Courier Tracking</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-white/10">
                        <!-- Recipient & Delivery -->
                        <div class="bg-black/40 p-5 rounded border border-white/5 space-y-2 text-xs">
                            <h4 class="text-[11px] uppercase tracking-[0.2em] text-brand-gold mb-3 font-semibold">Delivery Destination</h4>
                            <p class="text-sm font-semibold text-brand-ivory">{{ $order->customer_name }}</p>
                            <p class="text-brand-ivory/70">{{ $order->shipping_address }}</p>
                            @if($order->area)<p class="text-brand-ivory/60">Area: {{ $order->area }}</p>@endif
                            <p class="text-brand-ivory/80">{{ $order->city }}, {{ $order->province }}</p>
                            <p class="text-brand-ivory/60">Phone: {{ $order->customer_phone }}</p>
                        </div>

                        <!-- Payment & Order Info -->
                        <div class="bg-black/40 p-5 rounded border border-white/5 space-y-2 text-xs">
                            <h4 class="text-[11px] uppercase tracking-[0.2em] text-brand-gold mb-3 font-semibold">Financial & Method</h4>
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-brand-ivory/50">Payment Method:</span>
                                <span class="font-semibold text-brand-ivory uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-brand-ivory/50">Payment Status:</span>
                                <span class="font-semibold uppercase {{ $order->payment_status === 'paid' ? 'text-green-400' : 'text-brand-gold' }}">
                                    {{ str_replace('_', ' ', $order->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-brand-ivory/50">Total Amount:</span>
                                <span class="font-semibold text-brand-gold font-serif text-sm">Rs. {{ number_format($order->total_amount, 0) }}</span>
                            </div>
                            @if($order->bank_transaction_id)
                                <div class="flex justify-between py-1">
                                    <span class="text-brand-ivory/50">Transaction ID:</span>
                                    <span class="font-mono text-brand-ivory/80">{{ $order->bank_transaction_id }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <h4 class="text-xs uppercase tracking-[0.2em] text-brand-gold mb-4 font-semibold">Consignment Contents</h4>
                        <div class="divide-y divide-white/5 bg-black/40 rounded border border-white/5 overflow-hidden">
                            @foreach($order->items as $item)
                                <div class="p-4 flex items-center justify-between gap-4 text-xs">
                                    <div>
                                        <div class="font-semibold text-sm text-brand-ivory">{{ $item->product_name }}</div>
                                        <div class="text-brand-ivory/50 text-[11px]">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-right font-mono text-brand-gold font-semibold">
                                        Rs. {{ number_format($item->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Found State -->
                <div class="bg-[#0d0608] border border-red-500/30 p-10 rounded-sm text-center shadow-2xl mb-12">
                    <div class="w-16 h-16 rounded-full bg-red-500/10 border border-red-500/30 mx-auto mb-4 flex items-center justify-center text-red-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-2xl text-brand-gold mb-2">No Matching Dossier Found</h3>
                    <p class="text-sm text-brand-ivory/60 max-w-md mx-auto mb-6">
                        We could not locate an order matching the provided criteria. Please verify your order number (e.g. PC-100245) or the phone number used during checkout.
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-brand-gold text-black font-semibold text-xs uppercase tracking-[0.2em] rounded-sm hover:brightness-110 transition-all">
                        <span>Connect with WhatsApp Concierge</span>
                    </a>
                </div>
            @endif
        @endif

        <!-- Help Card -->
        <div class="text-center p-8 bg-[#0d0608]/60 border border-white/5 rounded-sm">
            <h4 class="font-serif text-xl text-brand-gold mb-2">Require Bespoke Concierge Assistance?</h4>
            <p class="text-xs text-brand-ivory/60 max-w-md mx-auto mb-4">
                Our perfume concierges are active 7 days a week from 10:00 AM to 11:00 PM PKT for order status inquiries, address corrections, or dispatch inquiries.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="text-xs uppercase tracking-[0.2em] text-brand-gold hover:underline font-semibold">
                    WhatsApp Concierge &rarr;
                </a>
                <span class="text-white/20">&bull;</span>
                <a href="tel:+923001234567" class="text-xs uppercase tracking-[0.2em] text-brand-ivory/70 hover:text-brand-gold font-semibold">
                    +92 300 1234567
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
