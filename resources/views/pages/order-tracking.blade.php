@extends('layouts.app')

@section('title', 'Track Order Consignment — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100 border-bottom border-gold-20" style="background-color: #050203;">
    <div class="container px-3 px-lg-4" style="max-width: 900px;">
        <!-- Header -->
        <div class="text-center mb-5">
            <span class="d-inline-block text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">
                Nationwide Tracking
            </span>
            <h1 class="font-serif display-5 text-light-parchment fw-normal mb-2">Order Status & Tracking</h1>
            <p class="text-muted-parchment mx-auto mb-0" style="font-size: 0.95rem; max-width: 560px;">
                Track your artisan fragrance parcel from our laboratory vault to your doorstep across Pakistan.
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl mb-5">
            <form action="{{ route('order.tracking') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Order Number</label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" placeholder="e.g. PC-100245" 
                           class="form-control form-control-luxury text-sm py-2 px-3 font-mono">
                </div>
                <div class="col-12 col-md-5">
                    <label class="d-block text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Mobile Phone Number</label>
                    <input type="text" name="phone" value="{{ $phone }}" placeholder="e.g. 03001234567" 
                           class="form-control form-control-luxury text-sm py-2 px-3">
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="w-100 btn-gold py-2 text-xs text-uppercase tracking-wider fw-semibold rounded-3 shadow-sm">
                        Track
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Tracking Results -->
                <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl mb-5 d-flex flex-column gap-4">
                    <!-- Order Meta Bar -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4 border-bottom border-gold-20">
                        <div>
                            <span class="text-muted-parchment d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">Order Reference</span>
                            <span class="font-serif fs-3 text-gold-soft fw-bold">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-end">
                            <span class="text-muted-parchment d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">Placed On</span>
                            <span class="text-sm font-mono text-light-parchment fw-semibold">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Visual Luxury Status Timeline -->
                    <div>
                        <h3 class="text-gold fw-semibold mb-4 text-center text-md-start" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase;">Consignment Progress</h3>
                        
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

                        <div class="position-relative">
                            <!-- Progress Bar Line -->
                            <div class="d-none d-md-block position-absolute start-0 end-0 mx-5 bg-wine-accent" style="top: 20px; height: 4px; z-index: 1;">
                                <div class="h-100 transition" 
                                     style="background: linear-gradient(to right, #d6aa62, #f0d59d); width: {{ count($statusKeys) > 1 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0 }}%;"></div>
                            </div>

                            <!-- Steps Grid -->
                            <div class="row row-cols-1 row-cols-md-5 g-3 position-relative" style="z-index: 2;">
                                @foreach($statuses as $key => $step)
                                    @php
                                        $index = array_search($key, $statusKeys);
                                        $isPassed = $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp
                                    <div class="col">
                                        <div class="d-flex d-md-flex flex-row flex-md-column align-items-center text-md-center gap-3 gap-md-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 transition {{ $isPassed ? 'text-dark fw-bold shadow' : 'bg-wine-dark border border-gold-30 text-muted-parchment' }}" style="width: 40px; height: 40px; {{ $isPassed ? 'background: linear-gradient(to right, #d6aa62, #c08b3f);' : '' }}">
                                                @if($isPassed)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <span class="text-xs font-mono">{{ $loop->iteration }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs text-uppercase tracking-wider fw-bold mb-0 {{ $isPassed ? 'text-light-parchment' : 'text-muted-parchment' }} {{ $isCurrent ? 'text-gold-soft' : '' }}">
                                                    {{ $step['label'] }}
                                                </h4>
                                                <p class="text-muted-parchment mt-1 mb-0 d-none d-md-block" style="font-size: 11px;">{{ $step['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Courier Details Card (if shipped) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="bg-wine-accent border border-gold-30 p-4 rounded-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <span class="text-gold fw-bold d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;">Courier Partner</span>
                                    <div class="fs-5 font-serif text-light-parchment fw-bold">{{ $order->courier_name ?? 'TCS Express Courier' }}</div>
                                    <div class="text-xs font-mono text-muted-parchment mt-1">
                                        Tracking CN: <span class="fw-bold text-gold-soft">{{ $order->tracking_number ?? 'In Transit' }}</span>
                                    </div>
                                </div>
                                @if($order->tracking_link)
                                    <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="btn-gold px-4 py-2 text-xs text-uppercase tracking-wider rounded-3 fw-semibold d-inline-flex align-items-center gap-2 text-decoration-none">
                                        <span>Live Tracking Portal</span>
                                        <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="row g-3 pt-3 border-top border-gold-20">
                        <!-- Recipient & Delivery -->
                        <div class="col-12 col-md-6">
                            <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1 text-xs">
                                <h4 class="text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Delivery Address</h4>
                                <p class="text-sm fw-bold text-light-parchment mb-0">{{ $order->customer_name }}</p>
                                <p class="text-muted-parchment mb-0">{{ $order->shipping_address }}</p>
                                @if($order->area)<p class="text-muted-parchment mb-0">Area: {{ $order->area }}</p>@endif
                                <p class="text-muted-parchment mb-0">{{ $order->city }}, {{ $order->province }}</p>
                                <p class="text-gold font-mono mb-0">Phone: {{ $order->customer_phone }}</p>
                            </div>
                        </div>

                        <!-- Payment & Order Info -->
                        <div class="col-12 col-md-6">
                            <div class="bg-wine-dark p-3 rounded-3 border border-gold-20 d-flex flex-column gap-1 text-xs">
                                <h4 class="text-gold mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Payment & Status</h4>
                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                    <span class="text-muted-parchment">Method:</span>
                                    <span class="fw-semibold text-light-parchment text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom border-gold-20">
                                    <span class="text-muted-parchment">Payment Status:</span>
                                    <span class="fw-semibold text-uppercase {{ $order->payment_status === 'paid' ? 'text-success' : 'text-gold-soft' }}">
                                        {{ str_replace('_', ' ', $order->payment_status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span class="text-muted-parchment">Total:</span>
                                    <span class="fw-bold text-white font-serif fs-6" style="color: #ffffff !important;">Rs. {{ number_format($order->total_amount, 0) }}</span>
                                </div>
                                @if($order->bank_transaction_id)
                                    <div class="d-flex justify-content-between py-1 border-top border-gold-20">
                                        <span class="text-muted-parchment">Transaction ID:</span>
                                        <span class="font-mono text-light-parchment fw-semibold">{{ $order->bank_transaction_id }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <h4 class="text-gold mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Items in this Parcel</h4>
                        <div class="bg-wine-dark rounded-3 border border-gold-20 overflow-hidden">
                            @foreach($order->items as $item)
                                <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom border-gold-20' : '' }}">
                                    <div>
                                        <div class="fw-bold fs-6 text-light-parchment">{{ $item->product_name }}</div>
                                        <div class="text-muted-parchment" style="font-size: 11px;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-end font-mono text-white fw-bold" style="color: #ffffff !important;">
                                        Rs. {{ number_format($item->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Found State -->
                <div class="bg-wine-card border border-gold-25 p-5 rounded-4 text-center shadow-xl mb-4 d-flex flex-column align-items-center gap-2">
                    <div class="rounded-circle bg-wine-accent border border-danger-subtle d-flex align-items-center justify-content-center text-danger mb-2" style="width: 64px; height: 64px;">
                        <i class="fas fa-exclamation-triangle fs-3"></i>
                    </div>
                    <h3 class="font-serif fs-4 text-light-parchment mb-1 fw-bold">No Matching Order Found</h3>
                    <p class="text-muted-parchment mx-auto mb-3" style="max-width: 440px; font-size: 0.9rem;">
                        We could not find an order matching the details provided. Please verify the order number (e.g. PC-100245) or the phone number used during checkout.
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="btn-whatsapp px-4 py-2 fw-semibold text-xs text-uppercase tracking-wider rounded-3 d-inline-flex align-items-center gap-2 shadow-sm text-decoration-none">
                        <i class="fab fa-whatsapp"></i>
                        <span>Contact WhatsApp Support</span>
                    </a>
                </div>
            @endif
        @endif

        <!-- Help Card -->
        @php
            $storePhone = settings('site_phone', '+92 336 3685732');
        @endphp
        <div class="text-center p-4 bg-wine-card border border-gold-25 rounded-4 shadow-xl">
            <h4 class="font-serif fs-5 text-light-parchment fw-bold mb-1">Need Assistance With Your Delivery?</h4>
            <p class="text-muted-parchment mx-auto mb-3" style="max-width: 440px; font-size: 0.85rem;">
                Our support team is available Mon–Sat from 10:00 AM to 10:00 PM PKT for order status inquiries, address corrections, or dispatch updates.
            </p>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="text-xs text-uppercase tracking-wider text-gold fw-bold text-decoration-none text-gold-hover">
                    WhatsApp Support &rarr;
                </a>
                <span class="text-gold opacity-50">&bull;</span>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storePhone) }}" class="text-xs text-uppercase tracking-wider text-light-parchment text-decoration-none text-gold-hover fw-semibold">
                    {{ $storePhone }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
