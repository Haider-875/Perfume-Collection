@extends('layouts.app')

@section('title', 'Track Order Consignment — Perfumes Collection')

@section('content')
<div class="py-4 py-md-5 min-vh-100" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;">
    <div class="container px-3 px-sm-4" style="max-width: 860px;">
        <!-- Header Section -->
        <div class="text-center mb-4 mb-md-5">
            <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2.5" style="font-size: 10.5px; letter-spacing: 0.25em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Nationwide Tracking
            </span>
            <h1 class="font-serif fw-normal mb-2.5" style="font-size: clamp(1.4rem, 2.8vw, 1.85rem); color: #211D1E; letter-spacing: 0.01em; line-height: 1.3;">
                Order Status &amp; Tracking
            </h1>
            <p class="mx-auto mb-0" style="font-size: 0.9rem; max-width: 520px; color: #6B605B; line-height: 1.75; letter-spacing: 0.01em;">
                Track your artisan fragrance parcel from our laboratory vault to your doorstep across Pakistan.
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="p-4 p-sm-4.5 p-md-5 rounded-4 shadow-sm mb-4 mb-md-5" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <form action="{{ route('order.tracking') }}" method="GET" class="row g-3 g-md-4 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="d-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: #541B29;">
                        Order Number
                    </label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" placeholder="e.g. PC-100245" 
                           class="form-control font-mono" 
                           style="height: 48px; font-size: 13.5px; padding: 0 16px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
                <div class="col-12 col-md-5">
                    <label class="d-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: #541B29;">
                        Mobile Phone Number
                    </label>
                    <input type="text" name="phone" value="{{ $phone }}" placeholder="e.g. 03001234567" 
                           class="form-control font-mono" 
                           style="height: 48px; font-size: 13.5px; padding: 0 16px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" 
                            class="w-100 fw-bold text-uppercase tracking-wider d-flex align-items-center justify-content-center gap-2 transition shadow-sm" 
                            style="height: 48px; padding: 0 16px; font-size: 12px; letter-spacing: 0.08em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: none !important; border-radius: 8px; box-shadow: 0 4px 14px rgba(122, 28, 51, 0.28) !important;">
                        <i class="fas fa-magnifying-glass" style="font-size: 12px;"></i>
                        <span>Track</span>
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Tracking Results Card -->
                <div class="p-4 p-sm-4.5 p-md-5 rounded-4 shadow-sm mb-4 mb-md-5" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <!-- Order Reference Bar -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <div>
                            <span class="d-block mb-1.5 text-uppercase fw-medium" style="font-size: 11px; letter-spacing: 0.08em; color: #6B605B;">Order Reference</span>
                            <span class="font-serif fs-4 fw-bold font-mono" style="color: #541B29; letter-spacing: 0.02em;">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-sm-end">
                            <span class="d-block mb-1.5 text-uppercase fw-medium" style="font-size: 11px; letter-spacing: 0.08em; color: #6B605B;">Placed On</span>
                            <span class="font-mono fw-semibold px-3 py-1 rounded-pill d-inline-block" style="font-size: 11.5px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </span>
                        </div>
                    </div>

                    <!-- Visual Luxury Status Timeline -->
                    <div class="mb-4 pb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <h3 class="fw-semibold mb-3.5" style="font-size: 11.5px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">Consignment Progress</h3>
                        
                        @php
                            $statuses = [
                                'pending' => ['label' => 'Order Received', 'desc' => 'Order created in system'],
                                'confirmed' => ['label' => 'Confirmed', 'desc' => 'Verified & queued for lab'],
                                'packed' => ['label' => 'Hand Bottled', 'desc' => 'Filled & sealed with care'],
                                'shipped' => ['label' => 'In Transit', 'desc' => 'Dispatched with tracking'],
                                'delivered' => ['label' => 'Delivered', 'desc' => 'Received at doorstep'],
                            ];
                            
                            $statusKeys = array_keys($statuses);
                            $currentStatus = $order->order_status;
                            if ($currentStatus === 'pending_verification') $currentStatus = 'pending';
                            $currentIndex = array_search($currentStatus, $statusKeys);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        <!-- Desktop & Tablet Horizontal Stepper (>= 768px) -->
                        <div class="d-none d-md-block position-relative pt-3 pb-3">
                            <!-- Progress Bar Line -->
                            <div class="position-absolute start-0 end-0" style="top: 31px; height: 3px; z-index: 1; background-color: #E8E0DA; left: 40px !important; right: 40px !important;">
                                <div class="h-100 transition" 
                                     style="background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%); width: {{ count($statusKeys) > 1 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0 }}%;"></div>
                            </div>

                            <!-- Steps Grid -->
                            <div class="row row-cols-5 g-2 position-relative" style="z-index: 2;">
                                @foreach($statuses as $key => $step)
                                    @php
                                        $index = array_search($key, $statusKeys);
                                        $isPassed = $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp
                                    <div class="col text-center">
                                        <div class="d-flex flex-column align-items-center gap-2.5">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 transition shadow-xs" 
                                                 style="width: 40px; height: 40px; {{ $isPassed ? 'background: linear-gradient(135deg, #B83A58 0%, #7A1C33 100%); color: #FFFFFF;' : 'background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #6B605B;' }}">
                                                @if($isPassed)
                                                    <i class="fas fa-check" style="font-size: 12px;"></i>
                                                @else
                                                    <span class="font-mono" style="font-size: 12px;">{{ $loop->iteration }}</span>
                                                @endif
                                            </div>
                                            <div class="pt-1">
                                                <h4 class="text-uppercase tracking-wider fw-bold mb-1" style="font-size: 11px; color: {{ $isCurrent ? '#541B29' : ($isPassed ? '#211D1E' : '#786C67') }};">
                                                    {{ $step['label'] }}
                                                </h4>
                                                <p class="mb-0" style="font-size: 10.5px; color: #6B605B; line-height: 1.5;">{{ $step['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Mobile Vertical Stepper (< 768px) -->
                        <div class="d-md-none position-relative ps-4 my-3.5" style="border-left: 2px solid #E8E0DA; margin-left: 14px;">
                            <div class="d-flex flex-column gap-4">
                                @foreach($statuses as $key => $step)
                                    @php
                                        $index = array_search($key, $statusKeys);
                                        $isPassed = $index <= $currentIndex;
                                        $isCurrent = $index === $currentIndex;
                                    @endphp
                                    <div class="d-flex align-items-start gap-3 position-relative">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                             style="width: 30px; height: 30px; margin-left: -30px; {{ $isPassed ? 'background: linear-gradient(135deg, #B83A58 0%, #7A1C33 100%); color: #FFFFFF;' : 'background-color: #FFFFFF; border: 2px solid #D4C7BD; color: #786C67;' }}">
                                            @if($isPassed)
                                                <i class="fas fa-check" style="font-size: 10px;"></i>
                                            @else
                                                <span class="font-mono" style="font-size: 10px;">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 min-w-0 pt-0.5">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                                <span class="fw-bold text-uppercase" style="font-size: 12px; letter-spacing: 0.04em; color: {{ $isCurrent ? '#541B29' : ($isPassed ? '#211D1E' : '#786C67') }};">
                                                    {{ $step['label'] }}
                                                </span>
                                                @if($isCurrent)
                                                    <span class="badge px-2.5 py-1 rounded-pill" style="font-size: 9.5px; background-color: #FDF2F2; color: #541B29; border: 1px solid #E8E0DA;">Active Stage</span>
                                                @endif
                                            </div>
                                            <p class="mb-0" style="font-size: 11.5px; color: #6B605B; line-height: 1.6;">{{ $step['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Courier Details Card (if shipped) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="p-4 p-md-4.5 rounded-3 mb-4" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <span class="fw-semibold d-block mb-1.5 text-uppercase" style="font-size: 10.5px; letter-spacing: 0.08em; color: #541B29;">Courier Partner</span>
                                    <div class="font-serif fw-bold mb-1" style="font-size: 15px; color: #211D1E;">{{ $order->courier_name ?? 'TCS Express Courier' }}</div>
                                    <div class="font-mono" style="color: #6B605B; font-size: 12px;">
                                        Tracking CN: <span class="fw-bold" style="color: #541B29;">{{ $order->tracking_number ?? 'In Transit' }}</span>
                                    </div>
                                </div>
                                @if($order->tracking_link)
                                    <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="px-4 py-2.5 text-uppercase tracking-wider rounded-3 fw-bold d-inline-flex align-items-center gap-2 text-decoration-none shadow-sm" 
                                       style="height: 44px; font-size: 11.5px; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border-radius: 8px;">
                                        <span>Live Tracking Portal</span>
                                        <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Details Grid: Spacious Delivery Address & Payment Status -->
                    <div class="row g-3 g-md-4 mb-4">
                        <!-- Recipient & Delivery -->
                        <div class="col-12 col-md-6">
                            <div class="p-4 p-md-4.5 rounded-3 d-flex flex-column gap-3 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <h4 class="mb-1 fw-bold" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">
                                    Delivery Address
                                </h4>
                                
                                <div class="fw-bold mb-0.5" style="font-size: 13.5px; color: #211D1E;">
                                    {{ $order->customer_name }}
                                </div>
                                
                                <div class="d-flex align-items-start gap-2.5" style="font-size: 12px; color: #6B605B; line-height: 1.7;">
                                    <i class="fas fa-location-dot mt-1 flex-shrink-0" style="color: #541B29; font-size: 12px;"></i>
                                    <span>{{ $order->shipping_address }}{{ $order->area ? ', ' . $order->area : '' }}, {{ $order->city }}, {{ $order->province }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2.5 pt-2 mt-auto" style="border-top: 1px solid #E8E0DA; font-size: 12px;">
                                    <i class="fas fa-phone flex-shrink-0" style="color: #541B29; font-size: 11px;"></i>
                                    <span class="font-mono fw-bold" style="color: #541B29;">{{ $order->customer_phone }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment & Order Info -->
                        <div class="col-12 col-md-6">
                            <div class="p-4 p-md-4.5 rounded-3 d-flex flex-column gap-2.5 h-100" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; font-size: 12px;">
                                <h4 class="mb-1 fw-bold" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">
                                    Payment &amp; Status
                                </h4>
                                
                                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #E8E0DA;">
                                    <span style="color: #6B605B;">Payment Method:</span>
                                    <span class="fw-semibold text-uppercase" style="color: #211D1E;">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #E8E0DA;">
                                    <span style="color: #6B605B;">Payment Status:</span>
                                    <span class="fw-bold text-capitalize" style="color: {{ $order->payment_status === 'paid' ? '#047857' : '#541B29' }};">
                                        {{ str_replace('_', ' ', $order->payment_status) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span style="color: #6B605B;">Total Amount:</span>
                                    <span class="fw-bold font-serif font-mono" style="font-size: 15px; color: #541B29 !important;">
                                        Rs. {{ number_format($order->total_amount, 0) }}
                                    </span>
                                </div>

                                @if($order->bank_transaction_id)
                                    <div class="d-flex justify-content-between align-items-center py-2 mt-auto" style="border-top: 1px solid #E8E0DA;">
                                        <span style="color: #6B605B;">Transaction ID:</span>
                                        <span class="font-mono fw-semibold" style="color: #211D1E;">{{ $order->bank_transaction_id }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Ordered in this Parcel -->
                    <div>
                        <h4 class="mb-3 fw-semibold" style="font-size: 11.5px; letter-spacing: 0.1em; text-transform: uppercase; color: #541B29;">Items in this Parcel</h4>
                        <div class="rounded-3 overflow-hidden" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                            @foreach($order->items as $item)
                                <div class="p-3.5 p-md-4 d-flex align-items-center justify-content-between gap-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="{{ !$loop->last ? 'border-color: #E8E0DA !important;' : '' }}">
                                    <div class="min-w-0">
                                        <h5 class="font-serif fw-semibold mb-1 text-truncate" style="font-size: 14px; color: #211D1E; line-height: 1.45;">{{ $item->product_name }}</h5>
                                        <p class="mb-0" style="font-size: 12px; color: #6B605B; line-height: 1.55;">{{ $item->variant_label ?? 'Standard Flacon' }} &bull; Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-end font-mono fw-bold flex-shrink-0" style="font-size: 13.5px; color: #541B29 !important;">
                                        Rs. {{ number_format($item->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Not Found State -->
                <div class="p-4 p-md-5 rounded-4 text-center shadow-sm mb-4 mb-md-5 d-flex flex-column align-items-center gap-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-1" style="width: 60px; height: 60px; background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #C81E1E;">
                        <i class="fas fa-exclamation-triangle fs-4"></i>
                    </div>
                    <h3 class="font-serif fs-5 mb-1 fw-bold" style="color: #211D1E;">No Matching Order Found</h3>
                    <p class="mx-auto mb-3" style="max-width: 460px; font-size: 0.9rem; color: #6B605B; line-height: 1.75;">
                        We could not find an order matching the details provided. Please verify the order number (e.g. PC-100245) or the phone number used during checkout.
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="fw-bold text-uppercase d-inline-flex align-items-center gap-2.5 text-decoration-none shadow-sm"
                       style="height: 48px; padding: 0 24px; font-size: 12px; letter-spacing: 0.08em; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%) !important; color: #FFFFFF !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; border-radius: 8px; box-shadow: 0 4px 14px rgba(18, 140, 126, 0.35) !important;">
                        <i class="fab fa-whatsapp" style="font-size: 18px;"></i>
                        <span>Contact WhatsApp Support</span>
                    </a>
                </div>
            @endif
        @endif

        <!-- Help & Concierge Assistance Card -->
        @php
            $storePhone = settings('site_phone', '+92 336 3685732');
        @endphp
        <div class="text-center p-4 p-sm-4.5 p-md-5 rounded-4 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <h4 class="font-serif fw-bold mb-2" style="font-size: 16px; color: #211D1E; letter-spacing: 0.01em;">Need Assistance With Your Delivery?</h4>
            <p class="mx-auto mb-3.5" style="max-width: 500px; font-size: 0.88rem; color: #6B605B; line-height: 1.75;">
                Our concierge team is available Mon–Sat from 10:00 AM to 10:00 PM PKT for order status inquiries, address corrections, or dispatch updates.
            </p>
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 pt-1">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                   class="fw-bold text-uppercase text-decoration-none d-inline-flex align-items-center gap-2 px-3.5 py-2 rounded-pill shadow-xs" 
                   style="font-size: 12px; background-color: #DEF7EC; color: #0E9F6E; border: 1px solid #31C48D;">
                    <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                    <span>WhatsApp Concierge &rarr;</span>
                </a>
                <span class="d-none d-sm-inline" style="color: #9E7D3B; opacity: 0.5;">&bull;</span>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storePhone) }}" class="text-uppercase tracking-wider text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 px-3.5 py-2 rounded-pill" style="font-size: 12px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                    <i class="fas fa-phone-alt" style="font-size: 11px; color: #541B29;"></i>
                    <span>{{ $storePhone }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
