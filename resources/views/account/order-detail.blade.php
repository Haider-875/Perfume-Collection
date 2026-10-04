@extends('layouts.app')

@section('title', 'Dossier #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 1024px;">
        <!-- Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 pb-4 mb-4 border-bottom border-gold-20">
            <div>
                <a href="{{ route('account.orders') }}" class="text-xs text-uppercase tracking-wider text-gold text-gold-hover text-decoration-none d-inline-block mb-1">
                    &larr; Back to Order Dossiers
                </a>
                <h1 class="font-serif fs-2 text-gold-soft fw-normal mb-1">
                    Dossier Reference: {{ $order->order_number }}
                </h1>
                <p class="text-xs text-muted-parchment mb-0">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-light py-2 px-3 text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center gap-2">
                    <i class="fas fa-print text-gold"></i>
                    <span>Print Dossier</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-wine-dark border border-success-subtle text-success-emphasis rounded-3 p-3 mb-4 text-xs">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 text-xs">
                {{ session('error') }}
            </div>
        @endif

        <!-- Order Detail Card -->
        <div class="bg-wine-card border border-gold-30 p-4 p-md-5 rounded-4 shadow-2xl d-flex flex-column gap-4 mb-4">
            <!-- Timeline -->
            <div>
                <h3 class="text-xs text-uppercase tracking-widest text-gold mb-3 fw-semibold">Consignment Status Timeline</h3>
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

                <div class="row row-cols-2 row-cols-sm-5 g-2">
                    @foreach($statuses as $k => $label)
                        @php
                            $idx = array_search($k, $keys);
                            $passed = $idx <= $curIdx;
                            $active = $idx === $curIdx;
                        @endphp
                        <div class="col">
                            <div class="p-3 bg-wine-dark border rounded-3 text-center h-100 {{ $passed ? 'border-gold text-gold' : 'border-gold-20 text-muted-parchment' }} {{ $active ? 'bg-wine-accent border-gold shadow' : '' }}">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-xs fw-bold {{ $passed ? 'bg-gold text-dark' : 'bg-secondary bg-opacity-25 text-light-parchment' }}" style="width: 24px; height: 24px;">
                                    {{ $loop->iteration }}
                                </div>
                                <span class="d-block text-uppercase fw-semibold lh-sm" style="font-size: 10px; letter-spacing: 0.05em;">{{ $label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Courier Details if present -->
            @if($order->courier_name || $order->tracking_number)
                <div class="bg-wine-accent border border-gold-40 p-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3 text-xs">
                    <div>
                        <span class="d-block text-gold text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.1em;">Pakistani Courier Partner</span>
                        <div class="fs-6 font-serif text-light-parchment fw-semibold">{{ $order->courier_name ?? 'TCS Express Logistics' }}</div>
                        <div class="font-mono text-muted-parchment mt-1">Tracking CN: <span class="text-gold-soft">{{ $order->tracking_number ?? 'In Transit' }}</span></div>
                    </div>
                    @if($order->tracking_link)
                        <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                           class="btn-gold py-2 px-3 fw-semibold text-uppercase tracking-wider text-decoration-none rounded-3" style="font-size: 11px;">
                            Track Courier Live &rarr;
                        </a>
                    @endif
                </div>
            @endif

            <!-- Manual Payment Receipt Upload Section -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']))
                <div class="bg-wine-dark border border-gold-30 p-4 rounded-3 text-xs d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="font-serif fs-6 text-gold-soft fw-semibold mb-0">Payment Proof & Verification</h3>
                        <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->payment_status === 'paid' ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}" style="font-size: 10px;">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>

                    @if($order->payment_receipt)
                        <div class="p-3 bg-wine-card rounded-3 border border-gold-20 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold text-light-parchment">Payment Receipt Attached</div>
                                    <div class="text-muted-parchment" style="font-size: 11px;">Transaction Ref: {{ $order->bank_transaction_id ?? 'Submitted' }}</div>
                                </div>
                            </div>
                            <a href="{{ asset($order->payment_receipt) }}" target="_blank" class="text-gold text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px;">View Receipt</a>
                        </div>
                    @else
                        <p class="text-muted-parchment lh-base mb-0">
                            Please upload your bank transfer or wallet screenshot / transaction receipt to expedite verification by our finance concierge.
                        </p>
                        <form action="{{ route('account.order.receipt', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-end">
                            @csrf
                            <div class="col-12 col-md-5">
                                <label class="d-block text-gold mb-1 fw-medium text-uppercase" style="font-size: 11px;">Transaction ID (TID)</label>
                                <input type="text" name="transaction_id" value="{{ old('transaction_id', $order->bank_transaction_id) }}" placeholder="e.g. FT261003894"
                                       class="form-control form-control-luxury text-xs py-2 px-3 font-mono">
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="d-block text-gold mb-1 fw-medium text-uppercase" style="font-size: 11px;">Payment Screenshot</label>
                                <input type="file" name="receipt_file" required accept="image/*,.pdf"
                                       class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="w-100 btn-gold py-2 text-uppercase tracking-wider fw-semibold rounded-3 text-nowrap" style="font-size: 11px;">
                                    Upload
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Order Items Breakdown -->
            <div>
                <h3 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">Commissioned Fragrance Items</h3>
                <div class="bg-wine-dark rounded-3 border border-gold-20 overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-15' : '' }}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-wine-card rounded-2 border border-gold-20 p-1 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 48px; height: 48px;">
                                    @if($item->product)
                                        <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product_name }}" class="img-fluid mh-100 object-contain">
                                    @elseif($item->bundle)
                                        <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->product_name }}" class="img-fluid mh-100 object-contain">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-serif fs-6 fw-semibold text-light-parchment mb-0">{{ $item->product_name }}</h4>
                                    <p class="text-muted-parchment mb-0" style="font-size: 11px;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-end font-mono text-gold-soft fw-semibold">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financials Breakdown -->
            <div class="border-top border-gold-20 pt-3 d-flex flex-column gap-2 text-xs">
                <div class="d-flex justify-content-between text-muted-parchment">
                    <span>Subtotal:</span>
                    <span class="font-mono text-light-parchment">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between text-gold-soft">
                        <span>Privilege Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between text-muted-parchment">
                    <span>White-Glove Express Courier:</span>
                    <span class="font-mono text-light-parchment">{{ $order->shipping_cost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-2 border-top border-gold-20">
                    <span class="font-serif fs-5 text-gold-soft">Total Amount:</span>
                    <span class="font-serif fs-3 text-gold-soft font-mono fw-bold">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Destination & Logistics -->
            <div class="row g-3 pt-3 border-top border-gold-20 text-xs">
                <div class="col-12 col-md-6">
                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1">
                        <h4 class="text-gold mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.1em;">Delivery Destination</h4>
                        <p class="fw-semibold text-light-parchment mb-0">{{ $order->customer_name }}</p>
                        <p class="text-muted-parchment mb-0">{{ $order->shipping_address }}</p>
                        @if($order->area)<p class="text-muted-parchment mb-0">Area: {{ $order->area }}</p>@endif
                        <p class="text-muted-parchment mb-0">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="text-muted-parchment mb-0 font-mono">Contact: {{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1">
                        <h4 class="text-gold mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.1em;">Payment Dossier</h4>
                        <p class="text-muted-parchment mb-0"><strong class="text-gold">Method:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <p class="text-muted-parchment mb-0"><strong class="text-gold">Payment Status:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</p>
                        @if($order->bank_transaction_id)
                            <p class="text-muted-parchment font-mono mb-0"><strong class="text-gold font-sans">Transaction ID:</strong> {{ $order->bank_transaction_id }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
