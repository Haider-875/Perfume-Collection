@extends('layouts.app')

@section('title', 'Track Order Consignment — Perfumes Collection')

@section('content')
<div class="py-12 md:py-20 bg-[#050203] text-[#f5efe7] min-h-screen border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-10">
            <span class="inline-block text-xs uppercase tracking-[0.28em] text-[#d6aa62] font-semibold px-4 py-1.5 bg-[#1f060d] border border-[#d6aa62]/30 rounded-full mb-3">
                Nationwide Tracking
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-[#f5efe7] font-normal mb-3">Order Status & Tracking</h1>
            <p class="text-[#b8a9a2] text-sm max-w-xl mx-auto leading-relaxed">
                Track your artisan fragrance parcel from our laboratory vault to your doorstep across Pakistan.
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-8 rounded-2xl shadow-xl mb-10">
            <form action="{{ route('order.tracking') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Order Number</label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" placeholder="e.g. PC-100245" 
                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-sm text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none rounded-lg font-mono">
                </div>
                <div class="md:col-span-5">
                    <label class="block text-xs uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Mobile Phone Number</label>
                    <input type="text" name="phone" value="{{ $phone }}" placeholder="e.g. 03001234567" 
                           class="w-full bg-[#080204] border border-[#d6aa62]/30 px-4 py-3 text-sm text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:border-[#d6aa62] focus:outline-none rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="w-full btn-gold py-3.5 text-xs uppercase tracking-wider font-semibold rounded-lg shadow-md">
                        Track
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Tracking Results -->
                <div class="bg-[#140408] border border-[#d6aa62]/25 p-6 md:p-10 rounded-2xl shadow-xl mb-10 space-y-8 animate-fadeIn">
                    <!-- Order Meta Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-[#d6aa62]/20">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-[#b8a9a2] block mb-0.5">Order Reference</span>
                            <span class="font-serif text-2xl md:text-3xl text-[#f0d59d] font-bold">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs uppercase tracking-wider text-[#b8a9a2] block mb-0.5">Placed On</span>
                            <span class="text-sm font-mono text-[#f5efe7] font-semibold">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Visual Luxury Status Timeline -->
                    <div>
                        <h3 class="text-xs uppercase tracking-wider text-[#d6aa62] font-semibold mb-6 text-center md:text-left">Consignment Progress</h3>
                        
                        @php
                            $statuses = [
                                'pending' => ['label' => 'Order Received', 'desc' => 'Order created in system'],
                                'confirmed' => ['label' => 'Confirmed', 'desc' => 'Payment verified & queued'],
                                'packed' => ['label' => 'Hand Bottled', 'desc' => 'Bottled & packed with care'],
                                'shipped' => ['label' => 'In Courier Transit', 'desc' => 'Dispatched with tracking'],
                                'delivered' => ['label' => 'Delivered', 'desc' => 'Safely received by customer'],
                            ];
                            
                            $statusKeys = array_keys($statuses);
                            $currentStatus = $order->order_status;
                            if ($currentStatus === 'pending_verification') $currentStatus = 'pending';
                            $currentIndex = array_search($currentStatus, $statusKeys);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        <div class="relative">
                            <!-- Progress Bar Line -->
                            <div class="hidden md:block absolute top-5 left-8 right-8 h-1 bg-[#25050a] -z-0">
                                <div class="h-full bg-gradient-to-r from-[#d6aa62] to-[#f0d59d] transition-all duration-700" 
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
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-300 {{ $isPassed ? 'bg-gradient-to-r from-[#d6aa62] to-[#c08b3f] text-[#050203] font-bold shadow-md' : 'bg-[#080204] border border-[#d6aa62]/30 text-[#b8a9a2]' }}">
                                            @if($isPassed)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <span class="text-xs font-mono">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-xs uppercase tracking-wider font-bold {{ $isPassed ? 'text-[#f5efe7]' : 'text-[#b8a9a2]' }} {{ $isCurrent ? 'text-[#f0d59d]' : '' }}">
                                                {{ $step['label'] }}
                                            </h4>
                                            <p class="text-[11px] text-[#b8a9a2]/80 mt-0.5 hidden md:block">{{ $step['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Courier Details Card (if shipped) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="bg-[#25050a] border border-[#d6aa62]/30 p-6 rounded-xl">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <span class="text-[11px] uppercase tracking-wider text-[#d6aa62] font-bold block mb-1">Courier Partner</span>
                                    <div class="text-lg font-serif text-[#f5efe7] font-bold">{{ $order->courier_name ?? 'TCS Express Courier' }}</div>
                                    <div class="text-xs font-mono text-[#b8a9a2] mt-1">
                                        Tracking CN: <span class="font-bold text-[#f0d59d]">{{ $order->tracking_number ?? 'In Transit' }}</span>
                                    </div>
                                </div>
                                @if($order->tracking_link)
                                    <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="btn-gold px-5 py-2.5 text-xs uppercase tracking-wider rounded-lg font-semibold inline-flex items-center gap-2">
                                        <span>Live Tracking Portal</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#d6aa62]/20">
                        <!-- Recipient & Delivery -->
                        <div class="bg-[#080204] p-5 rounded-xl border border-[#d6aa62]/20 space-y-1.5 text-xs">
                            <h4 class="text-[11px] uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Delivery Address</h4>
                            <p class="text-sm font-bold text-[#f5efe7]">{{ $order->customer_name }}</p>
                            <p class="text-[#b8a9a2]">{{ $order->shipping_address }}</p>
                            @if($order->area)<p class="text-[#b8a9a2]">Area: {{ $order->area }}</p>@endif
                            <p class="text-[#b8a9a2]">{{ $order->city }}, {{ $order->province }}</p>
                            <p class="text-[#d6aa62] font-mono">Phone: {{ $order->customer_phone }}</p>
                        </div>

                        <!-- Payment & Order Info -->
                        <div class="bg-[#080204] p-5 rounded-xl border border-[#d6aa62]/20 space-y-1.5 text-xs">
                            <h4 class="text-[11px] uppercase tracking-wider text-[#d6aa62] mb-2 font-semibold">Payment & Status</h4>
                            <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                <span class="text-[#b8a9a2]">Method:</span>
                                <span class="font-semibold text-[#f5efe7] uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-[#d6aa62]/15">
                                <span class="text-[#b8a9a2]">Payment Status:</span>
                                <span class="font-semibold uppercase {{ $order->payment_status === 'paid' ? 'text-emerald-400' : 'text-[#f0d59d]' }}">
                                    {{ str_replace('_', ' ', $order->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-[#b8a9a2]">Total:</span>
                                <span class="font-bold text-[#f0d59d] font-serif text-sm">Rs. {{ number_format($order->total_amount, 0) }}</span>
                            </div>
                            @if($order->bank_transaction_id)
                                <div class="flex justify-between py-1 border-t border-[#d6aa62]/15">
                                    <span class="text-[#b8a9a2]">Transaction ID:</span>
                                    <span class="font-mono text-[#f5efe7] font-semibold">{{ $order->bank_transaction_id }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <h4 class="text-xs uppercase tracking-wider text-[#d6aa62] mb-3 font-semibold">Items in this Parcel</h4>
                        <div class="divide-y divide-[#d6aa62]/15 bg-[#080204] rounded-xl border border-[#d6aa62]/20 overflow-hidden">
                            @foreach($order->items as $item)
                                <div class="p-4 flex items-center justify-between gap-4 text-xs">
                                    <div>
                                        <div class="font-bold text-sm text-[#f5efe7]">{{ $item->product_name }}</div>
                                        <div class="text-[#b8a9a2] text-[11px]">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-right font-mono text-[#f0d59d] font-bold">
                                        Rs. {{ number_format($item->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Found State -->
                <div class="bg-[#140408] border border-[#d6aa62]/25 p-10 rounded-2xl text-center shadow-xl mb-10 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-[#25050a] border border-rose-500/40 mx-auto mb-2 flex items-center justify-center text-rose-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-2xl text-[#f5efe7] mb-2 font-bold">No Matching Order Found</h3>
                    <p class="text-sm text-[#b8a9a2] max-w-md mx-auto">
                        We could not find an order matching the details provided. Please verify the order number (e.g. PC-100245) or the phone number used during checkout.
                    </p>
                    <div class="pt-2">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 px-6 py-3 btn-whatsapp font-semibold text-xs uppercase tracking-wider rounded-lg transition-all shadow-md">
                            <i class="fab fa-whatsapp"></i>
                            <span>Contact WhatsApp Support</span>
                        </a>
                    </div>
                </div>
            @endif
        @endif

        <!-- Help Card -->
        @php
            $storePhone = settings('site_phone', '+92 300 8765432');
        @endphp
        <div class="text-center p-8 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl shadow-xl">
            <h4 class="font-serif text-lg text-[#f5efe7] font-bold mb-1">Need Assistance With Your Delivery?</h4>
            <p class="text-xs text-[#b8a9a2] max-w-md mx-auto mb-4">
                Our support team is available Mon–Sat from 10:00 AM to 10:00 PM PKT for order status inquiries, address corrections, or dispatch updates.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="text-xs uppercase tracking-wider text-[#d6aa62] font-bold hover:text-[#f0d59d] hover:underline">
                    WhatsApp Support &rarr;
                </a>
                <span class="text-[#d6aa62]/40">&bull;</span>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storePhone) }}" class="text-xs uppercase tracking-wider text-[#f5efe7] hover:text-[#f0d59d] font-semibold">
                    {{ $storePhone }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
