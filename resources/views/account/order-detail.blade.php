@extends('layouts.app')

@section('title', 'Dossier #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-white/10">
            <div>
                <a href="{{ route('account.orders') }}" class="text-xs uppercase tracking-wider text-brand-gold hover:underline inline-block mb-2">
                    &larr; Back to Order Dossiers
                </a>
                <h1 class="font-serif text-2xl md:text-4xl text-brand-gold font-light">
                    Dossier Reference: {{ $order->order_number }}
                </h1>
                <p class="text-xs text-brand-ivory/60 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="px-4 py-2 bg-black/60 border border-white/20 text-brand-ivory hover:border-brand-gold text-xs uppercase tracking-wider rounded transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Dossier</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-950/60 border border-green-500/40 text-green-300 text-xs rounded-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-950/60 border border-red-500/40 text-red-300 text-xs rounded-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Order Detail Card -->
        <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-10 rounded-sm shadow-2xl space-y-8 mb-8">
            <!-- Timeline -->
            <div>
                <h3 class="text-xs uppercase tracking-[0.25em] text-brand-gold mb-6 font-semibold">Consignment Status Timeline</h3>
                @php
                    $statuses = [
                        'pending' => 'Dossier Received',
                        'confirmed' => 'Order Confirmed',
                        'packed' => 'Hand-Bottled & Sealed',
                        'shipped' => 'In Courier Transit',
                        'delivered' => 'Delivered'
                    ];
                    $keys = array_keys($statuses);
                    $cur = $order->order_status;
                    if ($cur === 'pending_verification') $cur = 'pending';
                    $curIdx = array_search($cur, $keys);
                    if ($curIdx === false) $curIdx = 0;
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    @foreach($statuses as $k => $label)
                        @php
                            $idx = array_search($k, $keys);
                            $passed = $idx <= $curIdx;
                            $active = $idx === $curIdx;
                        @endphp
                        <div class="p-3 bg-black/40 border rounded text-center {{ $passed ? 'border-brand-gold/60 text-brand-gold' : 'border-white/5 text-brand-ivory/40' }} {{ $active ? 'bg-brand-maroon/20 ring-1 ring-brand-gold' : '' }}">
                            <div class="w-6 h-6 rounded-full mx-auto mb-2 flex items-center justify-center text-[10px] font-bold {{ $passed ? 'bg-brand-gold text-black' : 'bg-white/10 text-white/40' }}">
                                {{ $loop->iteration }}
                            </div>
                            <span class="text-[10px] uppercase tracking-wider font-semibold block leading-tight">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Courier Details if present -->
            @if($order->courier_name || $order->tracking_number)
                <div class="bg-gradient-to-r from-brand-maroon/30 to-[#12070a] border border-brand-gold/40 p-5 rounded-sm flex flex-wrap items-center justify-between gap-4 text-xs">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-brand-gold block mb-1">Pakistani Courier Partner</span>
                        <div class="text-base font-serif text-brand-ivory font-semibold">{{ $order->courier_name ?? 'TCS Express Logistics' }}</div>
                        <div class="font-mono text-brand-ivory/70 mt-0.5">Tracking CN: <span class="text-brand-gold">{{ $order->tracking_number ?? 'In Transit' }}</span></div>
                    </div>
                    @if($order->tracking_link)
                        <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                           class="px-4 py-2 bg-brand-gold text-black font-semibold text-[11px] uppercase tracking-wider rounded transition-all hover:brightness-110">
                            Track Courier Live &rarr;
                        </a>
                    @endif
                </div>
            @endif

            <!-- Manual Payment Receipt Upload Section (if pending verification / unpaid) -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']))
                <div class="bg-[#12070a] border border-brand-gold/30 p-6 rounded-sm text-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif text-base text-brand-gold font-semibold">Payment Proof & Verification</h3>
                        <span class="text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded {{ $order->payment_status === 'paid' ? 'bg-green-950 text-green-300 border border-green-800' : 'bg-yellow-950 text-yellow-300 border border-yellow-700/50' }}">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>

                    @if($order->payment_receipt)
                        <div class="p-3 bg-black/60 rounded border border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <div class="font-semibold text-brand-ivory">Payment Receipt Attached</div>
                                    <div class="text-[11px] text-brand-ivory/50">Transaction Ref: {{ $order->bank_transaction_id ?? 'Submitted' }}</div>
                                </div>
                            </div>
                            <a href="{{ asset($order->payment_receipt) }}" target="_blank" class="text-brand-gold underline uppercase text-[11px]">View Receipt</a>
                        </div>
                    @else
                        <p class="text-brand-ivory/70 leading-relaxed">
                            Please upload your bank transfer or wallet screenshot / transaction receipt to expedite verification by our finance concierge.
                        </p>
                        <form action="{{ route('account.order.receipt', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                            @csrf
                            <div class="md:col-span-5">
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Transaction ID (TID)</label>
                                <input type="text" name="transaction_id" value="{{ old('transaction_id', $order->bank_transaction_id) }}" placeholder="e.g. FT261003894"
                                       class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded text-xs font-mono focus:border-brand-gold focus:outline-none">
                            </div>
                            <div class="md:col-span-5">
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Payment Screenshot</label>
                                <input type="file" name="receipt_file" required accept="image/*,.pdf"
                                       class="w-full bg-black/60 border border-brand-gold/30 px-3 py-1.5 text-brand-ivory/70 text-xs focus:border-brand-gold rounded file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-brand-gold file:text-black file:font-semibold">
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full py-2 bg-brand-gold text-black font-semibold text-[11px] uppercase tracking-wider rounded hover:brightness-110 transition-all">
                                    Upload
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Order Items Breakdown -->
            <div>
                <h3 class="text-xs uppercase tracking-[0.2em] text-brand-gold font-semibold mb-4">Commissioned Fragrance Items</h3>
                <div class="divide-y divide-white/5 bg-black/40 rounded border border-white/5 overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-4 flex items-center justify-between gap-4 text-xs">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-black/80 rounded border border-white/10 p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    @if($item->product)
                                        <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                    @elseif($item->bundle)
                                        <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-serif text-sm font-semibold text-brand-ivory">{{ $item->product_name }}</h4>
                                    <p class="text-[11px] text-brand-ivory/50">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-right font-mono text-brand-gold font-semibold">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financials Breakdown -->
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
                    <span class="font-serif text-lg text-brand-gold">Total Amount:</span>
                    <span class="font-serif text-2xl text-brand-gold font-mono">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Destination & Logistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-white/10 text-xs">
                <div class="bg-black/40 p-4 rounded border border-white/5 space-y-1.5">
                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-brand-gold mb-2 font-semibold">Delivery Destination</h4>
                    <p class="font-semibold text-brand-ivory">{{ $order->customer_name }}</p>
                    <p class="text-brand-ivory/70">{{ $order->shipping_address }}</p>
                    @if($order->area)<p class="text-brand-ivory/60">Area: {{ $order->area }}</p>@endif
                    <p class="text-brand-ivory/80">{{ $order->city }}, {{ $order->province }}</p>
                    <p class="text-brand-ivory/60">Contact: {{ $order->customer_phone }}</p>
                </div>

                <div class="bg-black/40 p-4 rounded border border-white/5 space-y-1.5">
                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-brand-gold mb-2 font-semibold">Payment Dossier</h4>
                    <p class="text-brand-ivory/70"><strong class="text-brand-gold">Method:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p class="text-brand-ivory/70"><strong class="text-brand-gold">Payment Status:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</p>
                    @if($order->bank_transaction_id)
                        <p class="text-brand-ivory/70 font-mono"><strong class="text-brand-gold font-sans">Transaction ID:</strong> {{ $order->bank_transaction_id }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
