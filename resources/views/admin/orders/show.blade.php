@extends('admin.layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('page_title', 'Order Management: #' . $order->order_number)
@section('page_subtitle', 'Placed on ' . $order->created_at->format('d F Y \a\t h:i A') . ' | ' . $order->city . ', ' . $order->province)

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-print"></i>
        <span>Print Invoice</span>
    </a>
    <a href="{{ route('admin.orders.packing-slip', $order->id) }}" target="_blank" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-box"></i>
        <span>Packing Slip</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Orders List</span>
    </a>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ receiptModal: false }">
    
    <!-- Left Column: Order Items & Customer Details -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Order Items Card -->
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6">
            <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3 mb-4 flex items-center justify-between">
                <span>Acquired Fragrances</span>
                <span class="text-xs text-brand-gold font-sans">{{ $order->items->count() }} items</span>
            </h3>

            <div class="divide-y divide-brand-border/30">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->product ? $item->product->main_image_url : asset('assets/images/perfumes/oud_royale.svg') }}" 
                                 alt="{{ $item->product_name }}" class="w-12 h-12 object-contain rounded-lg bg-brand-black p-1 border border-brand-border/40">
                            <div>
                                <div class="text-xs font-medium text-brand-text">{{ $item->product_name }}</div>
                                <div class="text-[10px] text-brand-muted">Volume: <span class="text-brand-gold">{{ $item->size }}</span> &bull; Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-serif font-bold text-xs text-brand-text">Rs. {{ number_format($item->total, 0) }}</div>
                            <div class="text-[10px] text-brand-muted">Rs. {{ number_format($item->price, 0) }} each</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Financial Summary Table -->
            <div class="mt-4 pt-4 border-t border-brand-border/40 space-y-2 text-xs">
                <div class="flex justify-between text-brand-muted">
                    <span>Subtotal:</span>
                    <span class="text-brand-text">{{ $order->formatted_subtotal }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-400">
                        <span>Discount (Coupon {{ $order->coupon_code }}):</span>
                        <span>- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-brand-muted">
                    <span>Shipping Charges:</span>
                    <span class="text-brand-text">{{ $order->formatted_shipping }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold border-t border-brand-border/40 pt-2 text-brand-gold">
                    <span>Total Amount (PKR):</span>
                    <span class="font-serif text-base">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping & Customer Address Card -->
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6">
            <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3 mb-4">
                Patron & Shipping Destination
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div class="space-y-1.5">
                    <span class="text-[10px] uppercase text-brand-muted tracking-wider block">Customer Contact</span>
                    <div class="text-brand-text font-medium text-sm">{{ $order->customer_name }}</div>
                    <div class="text-brand-muted"><i class="fa-solid fa-envelope mr-1.5 text-brand-gold"></i> {{ $order->customer_email }}</div>
                    <div class="text-brand-muted"><i class="fa-solid fa-phone mr-1.5 text-brand-gold"></i> {{ $order->customer_phone }}</div>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] uppercase text-brand-muted tracking-wider block">Delivery Address (Pakistan)</span>
                    <div class="text-brand-text leading-relaxed">
                        {{ $order->shipping_address }}<br>
                        @if($order->area) Area: {{ $order->area }}<br> @endif
                        @if($order->landmark) Landmark: {{ $order->landmark }}<br> @endif
                        <strong>{{ $order->city }}, {{ $order->province }}</strong> @if($order->postal_code) ({{ $order->postal_code }}) @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Receipt Verification Viewer -->
        @if($order->payment_receipt)
            <div class="bg-brand-surface border border-amber-500/40 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-amber-400"></i>
                        <h3 class="font-serif text-base font-semibold text-brand-text">Uploaded Payment Receipt</h3>
                    </div>
                    <span class="text-xs text-amber-400 bg-amber-950/30 px-2.5 py-0.5 rounded border border-amber-500/30">
                        {{ str_replace('_', ' ', $order->payment_status) }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-full sm:w-48 h-32 bg-brand-black rounded-lg border border-brand-border/60 overflow-hidden flex items-center justify-center cursor-pointer"
                         @click="receiptModal = true">
                        <img src="{{ asset($order->payment_receipt) }}" alt="Receipt" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1 space-y-2 text-xs">
                        <div class="text-brand-muted">Payment Method: <strong class="text-brand-text uppercase">{{ $order->payment_method }}</strong></div>
                        @if($order->bank_transaction_id)
                            <div class="text-brand-muted">Transaction ID / Ref: <strong class="text-brand-gold font-mono">{{ $order->bank_transaction_id }}</strong></div>
                        @endif
                        <p class="text-[11px] text-brand-muted">Verify transaction against boutique bank statement / EasyPaisa / JazzCash ledger before approval.</p>
                        
                        <div class="flex items-center gap-2 pt-2">
                            <form method="POST" action="{{ route('admin.orders.approve-receipt', $order->id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('Approve receipt and mark order as PAID?');" 
                                        class="px-4 py-1.5 rounded-lg bg-emerald-900/40 hover:bg-emerald-800/60 text-emerald-300 border border-emerald-500/40 text-xs font-medium flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-check"></i>
                                    <span>Approve & Confirm</span>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.orders.reject-receipt', $order->id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('Reject payment receipt?');" 
                                        class="px-4 py-1.5 rounded-lg bg-rose-900/40 hover:bg-rose-800/60 text-rose-300 border border-rose-500/40 text-xs font-medium flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-times"></i>
                                    <span>Reject Receipt</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column: Order Status & Courier Dispatch -->
    <div class="space-y-6">
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
            <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                Update Status & Courier
            </h3>

            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Fulfillment Status *</label>
                    <select name="order_status" required class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing / Blending</option>
                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped / Dispatched</option>
                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered to Patron</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Payment Status *</label>
                    <select name="payment_status" required class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid / Cash on Delivery</option>
                        <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>Pending Receipt Verification</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <div class="border-t border-brand-border/40 pt-3 space-y-3">
                    <span class="text-[10px] uppercase tracking-wider text-brand-gold font-semibold block">Pakistani Courier Partner</span>

                    <div>
                        <label class="block text-xs uppercase text-brand-muted mb-1">Courier Service</label>
                        <select name="courier_name" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                            <option value="">Select Courier...</option>
                            @foreach(array_keys($couriers) as $cName)
                                <option value="{{ $cName }}" {{ $order->courier_name === $cName ? 'selected' : '' }}>{{ $cName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs uppercase text-brand-muted mb-1">Consignment / Tracking #</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g. 78291039123"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text font-mono focus:outline-none focus:border-brand-gold">
                    </div>

                    @if($order->tracking_link)
                        <div class="text-xs">
                            <a href="{{ $order->tracking_link }}" target="_blank" class="text-brand-gold hover:underline flex items-center gap-1">
                                <span>Track on Courier Portal</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="border-t border-brand-border/40 pt-3">
                    <label class="block text-xs uppercase text-brand-muted mb-1">Internal Concierge Notes</label>
                    <textarea name="order_notes" rows="3" placeholder="Private internal notes for packaging and courier..."
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('order_notes', $order->order_notes) }}</textarea>
                </div>

                <button type="submit" class="w-full gold-btn py-2.5 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Save & Notify Patron</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Receipt Fullscreen Modal -->
    @if($order->payment_receipt)
        <div x-show="receiptModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" style="display: none;">
            <div class="relative max-w-3xl w-full bg-brand-surface border border-brand-border rounded-xl p-4 text-center" @click.outside="receiptModal = false">
                <button @click="receiptModal = false" class="absolute top-3 right-3 text-brand-muted hover:text-brand-text text-lg">
                    <i class="fa-solid fa-times"></i>
                </button>
                <h4 class="font-serif text-base text-brand-gold mb-3">Transaction Slip - Order #{{ $order->order_number }}</h4>
                <img src="{{ asset($order->payment_receipt) }}" alt="Receipt Full" class="max-h-[75vh] mx-auto rounded object-contain">
            </div>
        </div>
    @endif
</div>
@endsection
