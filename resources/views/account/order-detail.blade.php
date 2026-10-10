@extends('layouts.app')

@section('title', 'Dossier #' . $order->order_number . ' — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 1024px;">
        <!-- Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <a href="{{ route('account.orders') }}" class="text-xs text-uppercase tracking-wider fw-semibold text-decoration-none d-inline-block mb-1" style="color: #541B29;">
                    &larr; Back to Order Dossiers
                </a>
                <h1 class="font-serif fs-2 fw-normal mb-1" style="color: #211D1E;">
                    Dossier Reference: {{ $order->order_number }}
                </h1>
                <p class="text-xs mb-0" style="color: #6B605B;">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn py-2 px-3 text-xs text-uppercase tracking-wider rounded-3 d-flex align-items-center gap-2 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                    <i class="fas fa-print" style="color: #541B29;"></i>
                    <span>Print Dossier</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border border-success-subtle text-success-emphasis rounded-3 p-3 mb-4 text-xs shadow-sm" style="background-color: #FAF7F2;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 text-xs shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Order Detail Card -->
        <div class="p-4 p-md-5 rounded-4 shadow-sm d-flex flex-column gap-4 mb-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <!-- Timeline -->
            <div>
                <h3 class="text-xs text-uppercase tracking-widest mb-3 fw-semibold" style="color: #541B29;">Consignment Status Timeline</h3>
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
                            <div class="p-3 border rounded-3 text-center h-100" style="{{ $active ? 'background-color: #541B29; border-color: #541B29; color: #FFFFFF;' : ($passed ? 'background-color: #FAF7F2; border-color: #541B29; color: #541B29;' : 'background-color: #FAF7F2; border-color: #E8E0DA; color: #786C67;') }}">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-xs fw-bold" style="width: 24px; height: 24px; {{ $active ? 'background-color: #FFFFFF; color: #541B29;' : ($passed ? 'background-color: #541B29; color: #FFFFFF;' : 'background-color: #E8E0DA; color: #786C67;') }}">
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
                <div class="p-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3 text-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                    <div>
                        <span class="d-block text-uppercase mb-1 fw-semibold" style="font-size: 10px; letter-spacing: 0.1em; color: #541B29;">Pakistani Courier Partner</span>
                        <div class="fs-6 font-serif fw-semibold" style="color: #211D1E;">{{ $order->courier_name ?? 'TCS Express Logistics' }}</div>
                        <div class="font-mono mt-1" style="color: #6B605B;">Tracking CN: <span class="fw-bold" style="color: #541B29;">{{ $order->tracking_number ?? 'In Transit' }}</span></div>
                    </div>
                    @if($order->tracking_link)
                        <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                           class="btn py-2 px-3 fw-semibold text-uppercase tracking-wider text-decoration-none rounded-3 text-white shadow-sm" style="font-size: 11px; background-color: #541B29;">
                            Track Courier Live &rarr;
                        </a>
                    @endif
                </div>
            @endif

            <!-- Manual Payment Receipt Upload Section -->
            @if(in_array($order->payment_method, ['bank_transfer', 'wallet_transfer']))
                <div class="p-4 rounded-3 text-xs d-flex flex-column gap-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="font-serif fs-6 fw-semibold mb-0" style="color: #211D1E;">Payment Proof & Verification</h3>
                        <span class="text-uppercase tracking-wider px-2 py-0-5 rounded {{ $order->payment_status === 'paid' ? 'bg-success-subtle text-success-emphasis border border-success' : 'bg-warning-subtle text-warning-emphasis border border-warning' }}" style="font-size: 10px;">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>

                    @if($order->payment_receipt)
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold" style="color: #211D1E;">Payment Receipt Attached</div>
                                    <div style="font-size: 11px; color: #6B605B;">Transaction Ref: {{ $order->bank_transaction_id ?? 'Submitted' }}</div>
                                </div>
                            </div>
                            <a href="{{ asset($order->payment_receipt) }}" target="_blank" class="text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px; color: #541B29;">View Receipt</a>
                        </div>
                    @else
                        <p class="lh-base mb-0" style="color: #6B605B;">
                            Please upload your bank transfer or wallet screenshot / transaction receipt to expedite verification by our finance concierge.
                        </p>
                        <form action="{{ route('account.order.receipt', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-end">
                            @csrf
                            <div class="col-12 col-md-5">
                                <label class="d-block mb-1 fw-medium text-uppercase" style="font-size: 11px; color: #541B29;">Transaction ID (TID)</label>
                                <input type="text" name="transaction_id" value="{{ old('transaction_id', $order->bank_transaction_id) }}" placeholder="e.g. FT261003894"
                                       class="form-control text-xs py-2 px-3 font-mono" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="d-block mb-1 fw-medium text-uppercase" style="font-size: 11px; color: #541B29;">Payment Screenshot</label>
                                <input type="file" name="receipt_file" required accept="image/*,.pdf"
                                       class="form-control text-xs py-2 px-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="w-100 btn py-2 text-uppercase tracking-wider fw-semibold rounded-3 text-nowrap text-white shadow-sm" style="font-size: 11px; background-color: #541B29;">
                                    Upload
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Order Items Breakdown -->
            <div>
                <h3 class="text-xs text-uppercase tracking-widest fw-semibold mb-3" style="color: #541B29;">Commissioned Fragrance Items</h3>
                <div class="rounded-3 overflow-hidden" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                    @foreach($order->items as $item)
                        <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-2 p-1 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 48px; height: 48px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                                    @if($item->product)
                                        <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product_name }}" class="img-fluid mh-100 object-contain">
                                    @elseif($item->bundle)
                                        <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->product_name }}" class="img-fluid mh-100 object-contain">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-serif fs-6 fw-semibold mb-0" style="color: #211D1E;">{{ $item->product_name }}</h4>
                                    <p class="mb-0" style="font-size: 11px; color: #6B605B;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-end font-mono fw-bold" style="color: #541B29 !important;">
                                Rs. {{ number_format($item->total, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Financials Breakdown -->
            <div class="pt-3 d-flex flex-column gap-2 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex justify-content-between" style="color: #6B605B;">
                    <span>Subtotal:</span>
                    <span class="font-mono fw-semibold" style="color: #211D1E !important;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between" style="color: #9E2A2B;">
                        <span>Privilege Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-mono fw-semibold">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between" style="color: #6B605B;">
                    <span>White-Glove Express Courier:</span>
                    <span class="font-mono" style="color: #211D1E;">{{ $order->shipping_cost == 0 ? 'COMPLIMENTARY' : 'Rs. ' . number_format($order->shipping_cost, 0) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline pt-2" style="border-top: 1px solid #E8E0DA;">
                    <span class="font-serif fs-5 fw-medium" style="color: #211D1E;">Total Amount:</span>
                    <span class="font-serif fs-3 font-mono fw-bold" style="color: #541B29 !important;">Rs. {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <!-- Destination & Logistics -->
            <div class="row g-3 pt-3 text-xs" style="border-top: 1px solid #E8E0DA;">
                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.1em; color: #541B29;">Delivery Destination</h4>
                        <p class="fw-semibold mb-0" style="color: #211D1E;">{{ $order->customer_name }}</p>
                        <p class="mb-0" style="color: #6B605B;">{{ $order->shipping_address }}</p>
                        @if($order->area)<p class="mb-0" style="color: #6B605B;">Area: {{ $order->area }}</p>@endif
                        <p class="mb-0" style="color: #6B605B;">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="font-mono mb-0" style="color: #6B605B;">Contact: {{ $order->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 d-flex flex-column gap-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                        <h4 class="mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.1em; color: #541B29;">Payment Dossier</h4>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #541B29;">Method:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <p class="mb-0" style="color: #6B605B;"><strong style="color: #541B29;">Payment Status:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</p>
                        @if($order->bank_transaction_id)
                            <p class="font-mono mb-0" style="color: #6B605B;"><strong class="font-sans" style="color: #541B29;">Transaction ID:</strong> {{ $order->bank_transaction_id }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
