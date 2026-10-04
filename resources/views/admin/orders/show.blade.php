@extends('admin.layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('page_title', 'Order Management: #' . $order->order_number)
@section('page_subtitle', 'Placed on ' . $order->created_at->format('d F Y \a\t h:i A') . ' | ' . $order->city . ', ' . $order->province)

@section('header_actions')
<div class="d-flex align-items-center gap-2 flex-wrap">
    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="admin-btn-secondary" title="Print Invoice">
        <i class="fa-solid fa-print"></i>
        <span>Print Invoice</span>
    </a>
    <a href="{{ route('admin.orders.packing-slip', $order->id) }}" target="_blank" class="admin-btn-secondary" title="Print Packing Slip">
        <i class="fa-solid fa-box"></i>
        <span>Packing Slip</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="admin-btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Orders List</span>
    </a>
</div>
@endsection

@section('content')
<div class="row g-4">
    
    <!-- Left Column: Order Items & Customer Details -->
    <div class="col-lg-8">
        
        <!-- Order Items Card -->
        <div class="admin-card mb-4">
            <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-spray-can text-primary small"></i>
                    <span>Acquired Fragrances</span>
                </h6>
                <span class="admin-badge admin-badge-info">{{ $order->items->count() }} items</span>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="admin-thumb-box" onclick="window.previewImage('{{ $item->product ? $item->product->main_image_url : asset('assets/images/perfumes/oud_royale.svg') }}', '{{ $item->product_name }}')">
                                                <img src="{{ $item->product ? $item->product->main_image_url : asset('assets/images/perfumes/oud_royale.svg') }}" 
                                                     alt="{{ $item->product_name }}" class="admin-thumb-img">
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark small">{{ $item->product_name }}</div>
                                                @if($item->product && $item->product->sku)
                                                    <small class="text-muted font-monospace" style="font-size: 0.7rem;">SKU: {{ $item->product->sku }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center small"><span class="badge bg-light text-dark border">{{ $item->size }}</span></td>
                                    <td class="text-center small fw-semibold">{{ $item->quantity }}</td>
                                    <td class="text-end small font-monospace">Rs. {{ number_format($item->price, 0) }}</td>
                                    <td class="text-end small fw-bold font-monospace">Rs. {{ number_format($item->total, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Financial Summary Table -->
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex flex-column gap-2 ms-auto" style="max-width: 320px;">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Subtotal:</span>
                            <span class="text-dark font-monospace fw-semibold">{{ $order->formatted_subtotal }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between small text-success">
                                <span>Discount (Coupon {{ $order->coupon_code }}):</span>
                                <span class="font-monospace fw-semibold">- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Shipping Charges:</span>
                            <span class="text-dark font-monospace fw-semibold">{{ $order->formatted_shipping }}</span>
                        </div>
                        <div class="d-flex justify-content-between fs-6 fw-bold border-top pt-2 text-dark">
                            <span>Total Amount:</span>
                            <span class="font-monospace text-primary fs-5">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping & Customer Address Card -->
        <div class="admin-card mb-4">
            <div class="px-4 py-3 bg-white border-bottom">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-primary small"></i>
                    <span>Patron & Shipping Destination</span>
                </h6>
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Customer Contact</label>
                        <div class="fw-bold text-dark mb-1">{{ $order->customer_name }}</div>
                        <div class="small text-muted mb-1"><i class="fa-solid fa-envelope me-2 text-primary small"></i>{{ $order->customer_email }}</div>
                        <div class="small text-muted"><i class="fa-solid fa-phone me-2 text-primary small"></i>{{ $order->customer_phone }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Delivery Address (Pakistan)</label>
                        <div class="small text-dark leading-relaxed">
                            {{ $order->shipping_address }}<br>
                            @if($order->area) <span class="text-muted">Area:</span> {{ $order->area }}<br> @endif
                            @if($order->landmark) <span class="text-muted">Landmark:</span> {{ $order->landmark }}<br> @endif
                            <strong>{{ $order->city }}, {{ $order->province }}</strong> @if($order->postal_code) ({{ $order->postal_code }}) @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Receipt Verification Viewer -->
        @if($order->payment_receipt)
            <div class="admin-card mb-4 border-warning-subtle">
                <div class="px-4 py-3 bg-warning-subtle border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-receipt text-warning"></i>
                        <span>Uploaded Payment Receipt</span>
                    </h6>
                    <span class="admin-badge admin-badge-warning">
                        {{ str_replace('_', ' ', $order->payment_status) }}
                    </span>
                </div>
                <div class="p-4">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-4">
                        <div class="admin-thumb-box" style="width: 140px; height: 100px;" 
                             onclick="window.previewImage('{{ asset($order->payment_receipt) }}', 'Payment Receipt for Order #{{ $order->order_number }}')"
                             title="Click to view full receipt">
                            <img src="{{ asset($order->payment_receipt) }}" alt="Receipt" class="admin-thumb-img">
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-muted mb-1">Payment Method: <strong class="text-dark text-uppercase">{{ $order->payment_method }}</strong></div>
                            @if($order->bank_transaction_id)
                                <div class="small text-muted mb-1">Transaction Ref: <strong class="text-primary font-monospace">{{ $order->bank_transaction_id }}</strong></div>
                            @endif
                            <small class="text-muted d-block mb-3" style="font-size: 0.72rem;">Verify transaction in bank statement or mobile wallet before approving.</small>
                            
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <form method="POST" action="{{ route('admin.orders.approve-receipt', $order->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve receipt and mark order as PAID?');" 
                                            class="btn btn-sm btn-success px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5">
                                        <i class="fa-solid fa-check small"></i>
                                        <span>Approve & Confirm</span>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.orders.reject-receipt', $order->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Reject payment receipt?');" 
                                            class="btn btn-sm btn-outline-danger px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5">
                                        <i class="fa-solid fa-xmark small"></i>
                                        <span>Reject Receipt</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column: Order Status & Courier Dispatch (Edit Form) -->
    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <div class="px-4 py-3 bg-white border-bottom">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-sliders text-primary small"></i>
                    <span>Update Status & Courier</span>
                </h6>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Fulfillment Status *</label>
                        <select name="order_status" required>
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing / Blending</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped / Dispatched</option>
                            <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered to Patron</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Payment Status *</label>
                        <select name="payment_status" required>
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid / Cash on Delivery</option>
                            <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>Pending Receipt Verification</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div class="pt-3 border-top mb-3">
                        <label class="form-label small fw-semibold text-primary text-uppercase mb-2 d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Pakistani Courier Partner</label>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Courier Service</label>
                            <select name="courier_name">
                                <option value="">Select Courier...</option>
                                @foreach(array_keys($couriers) as $cName)
                                    <option value="{{ $cName }}" {{ $order->courier_name === $cName ? 'selected' : '' }}>{{ $cName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Consignment / Tracking #</label>
                            <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g. 78291039123" class="font-monospace">
                        </div>

                        @if($order->tracking_link)
                            <div class="small mt-1">
                                <a href="{{ $order->tracking_link }}" target="_blank" class="text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                                    <span>Track on Courier Portal</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem;"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-top mb-4">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Internal Concierge Notes</label>
                        <textarea name="order_notes" rows="3" placeholder="Private internal notes for packaging and courier...">{{ old('order_notes', $order->order_notes) }}</textarea>
                    </div>

                    <button type="submit" class="admin-btn-primary w-100 py-2.5 fs-6">
                        <i class="fa-solid fa-paper-plane me-1"></i>
                        <span>Save & Notify Patron</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
