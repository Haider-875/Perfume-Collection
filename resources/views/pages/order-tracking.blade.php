@extends('layouts.app')

@section('title', 'Track Order Consignment — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;">
    <div class="container px-3 px-lg-4" style="max-width: 900px;">
        <!-- Header -->
        <div class="text-center mb-5">
            <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Nationwide Tracking
            </span>
            <h1 class="font-serif display-5 fw-normal mb-2" style="color: #211D1E;">Order Status & Tracking</h1>
            <p class="mx-auto mb-0" style="font-size: 0.95rem; max-width: 560px; color: #6B605B;">
                Track your artisan fragrance parcel from our laboratory vault to your doorstep across Pakistan.
            </p>
        </div>

        <!-- Search Form -->
        <div class="p-4 p-md-5 rounded-4 shadow-sm mb-5" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <form action="{{ route('order.tracking') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Order Number</label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" placeholder="e.g. PC-100245" 
                           class="form-control text-sm py-2 px-3 font-mono" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
                <div class="col-12 col-md-5">
                    <label class="d-block mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Mobile Phone Number</label>
                    <input type="text" name="phone" value="{{ $phone }}" placeholder="e.g. 03001234567" 
                           class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="w-100 btn-gold py-2 text-xs text-uppercase tracking-wider fw-semibold rounded-3 shadow-sm" style="border-radius: 8px;">
                        Track
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Tracking Results -->
                <div class="p-4 p-md-5 rounded-4 shadow-sm mb-5 d-flex flex-column gap-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <!-- Order Meta Bar -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <div>
                            <span class="d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em; color: #6B605B;">Order Reference</span>
                            <span class="font-serif fs-3 fw-bold" style="color: #541B29;">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-end">
                            <span class="d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em; color: #6B605B;">Placed On</span>
                            <span class="text-sm font-mono fw-semibold" style="color: #211D1E;">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Visual Luxury Status Timeline -->
                    <div>
                        <h3 class="fw-semibold mb-4 text-center text-md-start" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Consignment Progress</h3>
                        
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
                            <div class="d-none d-md-block position-absolute start-0 end-0 mx-5" style="top: 20px; height: 4px; z-index: 1; background-color: #E8E0DA;">
                                <div class="h-100 transition" 
                                     style="background: #541B29; width: {{ count($statusKeys) > 1 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0 }}%;"></div>
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
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 transition" style="width: 40px; height: 40px; {{ $isPassed ? 'background-color: #541B29; color: #FFFFFF; font-weight: bold;' : 'background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                                                @if($isPassed)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <span class="text-xs font-mono">{{ $loop->iteration }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs text-uppercase tracking-wider fw-bold mb-0" style="color: {{ $isCurrent ? '#541B29' : ($isPassed ? '#211D1E' : '#6B605B') }};">
                                                    {{ $step['label'] }}
                                                </h4>
                                                <p class="mt-1 mb-0 d-none d-md-block" style="font-size: 11px; color: #6B605B;">{{ $step['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Courier Details Card (if shipped) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="p-4 rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <span class="fw-bold d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em; color: #541B29;">Courier Partner</span>
                                    <div class="fs-5 font-serif fw-bold" style="color: #211D1E;">{{ $order->courier_name ?? 'TCS Express Courier' }}</div>
                                    <div class="text-xs font-mono mt-1" style="color: #6B605B;">
                                        Tracking CN: <span class="fw-bold" style="color: #541B29;">{{ $order->tracking_number ?? 'In Transit' }}</span>
                                    </div>
                                </div>
                                @if($order->tracking_link)
                                    <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="btn-gold px-4 py-2 text-xs text-uppercase tracking-wider rounded-3 fw-semibold d-inline-flex align-items-center gap-2 text-decoration-none" style="border-radius: 8px;">
                                        <span>Live Tracking Portal</span>
                                        <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="row g-3 pt-3" style="border-top: 1px solid #E8E0DA;">
                        <!-- Recipient & Delivery -->
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-3 d-flex flex-column gap-1 text-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <h4 class="mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Delivery Address</h4>
                                <p class="text-sm fw-bold mb-0" style="color: #211D1E;">{{ $order->customer_name }}</p>
                                <p class="mb-0" style="color: #6B605B;">{{ $order->shipping_address }}</p>
                                @if($order->area)<p class="mb-0" style="color: #6B605B;">Area: {{ $order->area }}</p>@endif
                                <p class="mb-0" style="color: #6B605B;">{{ $order->city }}, {{ $order->province }}</p>
                                <p class="font-mono mb-0" style="color: #541B29;">Phone: {{ $order->customer_phone }}</p>
                            </div>
                        </div>

                        <!-- Payment & Order Info -->
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-3 d-flex flex-column gap-1 text-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <h4 class="mb-1 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Payment & Status</h4>
                                <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #E8E0DA;">
                                    <span style="color: #6B605B;">Method:</span>
                                    <span class="fw-semibold text-uppercase" style="color: #211D1E;">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1" style="border-bottom: 1px solid #E8E0DA;">
                                    <span style="color: #6B605B;">Payment Status:</span>
                                    <span class="fw-semibold text-uppercase" style="color: {{ $order->payment_status === 'paid' ? '#0E9F6E' : '#541B29' }};">
                                        {{ str_replace('_', ' ', $order->payment_status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span style="color: #6B605B;">Total:</span>
                                    <span class="fw-bold font-serif fs-6" style="color: #541B29 !important;">Rs. {{ number_format($order->total_amount, 0) }}</span>
                                </div>
                                @if($order->bank_transaction_id)
                                    <div class="d-flex justify-content-between py-1" style="border-top: 1px solid #E8E0DA;">
                                        <span style="color: #6B605B;">Transaction ID:</span>
                                        <span class="font-mono fw-semibold" style="color: #211D1E;">{{ $order->bank_transaction_id }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <h4 class="mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Items in this Parcel</h4>
                        <div class="rounded-3 overflow-hidden" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                            @foreach($order->items as $item)
                                <div class="p-3 d-flex align-items-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div>
                                        <div class="fw-bold fs-6" style="color: #211D1E;">{{ $item->product_name }}</div>
                                        <div style="font-size: 11px; color: #6B605B;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-end font-mono fw-bold" style="color: #541B29 !important;">
                                        Rs. {{ number_format($item->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Found State -->
                <div class="p-5 rounded-4 text-center shadow-sm mb-4 d-flex flex-column align-items-center gap-2" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px; background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #C81E1E;">
                        <i class="fas fa-exclamation-triangle fs-3"></i>
                    </div>
                    <h3 class="font-serif fs-4 mb-1 fw-bold" style="color: #211D1E;">No Matching Order Found</h3>
                    <p class="mx-auto mb-3" style="max-width: 440px; font-size: 0.9rem; color: #6B605B;">
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
        <div class="text-center p-4 rounded-4 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <h4 class="font-serif fs-5 fw-bold mb-1" style="color: #211D1E;">Need Assistance With Your Delivery?</h4>
            <p class="mx-auto mb-3" style="max-width: 440px; font-size: 0.85rem; color: #6B605B;">
                Our support team is available Mon–Sat from 10:00 AM to 10:00 PM PKT for order status inquiries, address corrections, or dispatch updates.
            </p>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="text-xs text-uppercase tracking-wider fw-bold text-decoration-none" style="color: #541B29;">
                    WhatsApp Support &rarr;
                </a>
                <span style="color: #9E7D3B; opacity: 0.5;">&bull;</span>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storePhone) }}" class="text-xs text-uppercase tracking-wider text-decoration-none fw-semibold" style="color: #211D1E;">
                    {{ $storePhone }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
