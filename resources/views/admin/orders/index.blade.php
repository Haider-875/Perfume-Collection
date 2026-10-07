@extends('admin.layouts.admin')

@section('title', 'Orders & Receipts')
@section('page_title', 'Patron Orders & Receipts')
@section('page_subtitle', 'Process acquisitions, verify payment slips, update fulfillment status, and track couriers')

@section('header_actions')
<div class="d-flex align-items-center gap-2">
    <a href="{{ route('admin.orders.export-csv', request()->query()) }}" class="admin-btn-secondary">
        <i class="fa-solid fa-file-export text-muted"></i>
        <span class="d-none d-sm-inline">Export Orders CSV</span>
        <span class="d-sm-none">Export</span>
    </a>
</div>
@endsection

@section('content')
<!-- Search & Filter Bar -->
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
        <!-- Search -->
        <div class="lg:col-span-2 position-relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, name, phone, email..."
                   class="ps-3">
        </div>

        <!-- Order Status Filter -->
        <div>
            <select name="status">
                <option value="">All Fulfillment Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <!-- Payment Status Filter -->
        <div>
            <select name="payment_status">
                <option value="">All Payment Status</option>
                <option value="pending_verification" {{ request('payment_status') === 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid / COD</option>
                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <!-- Province Filter -->
        <div>
            <select name="province">
                <option value="">All Provinces</option>
                @foreach($provinces as $prov)
                    <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="admin-btn-primary flex-fill">
                <i class="fa-solid fa-filter small"></i>
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search', 'status', 'payment_status', 'province']))
                <a href="{{ route('admin.orders.index') }}" class="admin-btn-reset" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Orders Table Card -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Destination</th>
                    <th class="text-end">Total (PKR)</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Fulfillment</th>
                    <th class="text-end" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-monospace fw-bold text-primary text-decoration-none d-block">
                                #{{ $order->order_number }}
                            </a>
                            @if($order->payment_receipt)
                                <button type="button" 
                                        onclick="window.previewImage('{{ asset($order->payment_receipt) }}', 'Payment Receipt for Order #{{ $order->order_number }}')"
                                        class="badge bg-warning-subtle text-warning border border-warning-subtle text-decoration-none mt-1 d-inline-flex align-items-center gap-1 border-0"
                                        style="font-size: 0.68rem; cursor: pointer;"
                                        title="Click to inspect receipt screenshot">
                                    <i class="fa-solid fa-receipt"></i> Receipt
                                </button>
                            @endif
                        </td>
                        <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                            <small class="text-muted font-monospace" style="font-size: 0.72rem;">{{ $order->customer_phone }}</small>
                        </td>
                        <td>
                            <div class="text-dark">{{ $order->city }}</div>
                            <small class="text-muted" style="font-size: 0.72rem;">{{ $order->province }}</small>
                        </td>
                        <td class="text-end font-monospace">
                            <span class="fw-bold text-dark fs-6">{{ $order->formatted_total }}</span>
                        </td>
                        <td class="text-center">
                            @if($order->payment_status === 'paid')
                                <span class="admin-badge admin-badge-success">Paid</span>
                            @elseif($order->payment_status === 'pending_verification')
                                <span class="admin-badge admin-badge-warning">Verification</span>
                            @elseif($order->payment_status === 'failed')
                                <span class="admin-badge admin-badge-danger">Failed</span>
                            @else
                                <span class="admin-badge admin-badge-secondary">Unpaid / COD</span>
                            @endif
                            <small class="text-muted d-block text-uppercase mt-0.5" style="font-size: 0.65rem;">
                                {{ $order->payment_method }}
                            </small>
                        </td>
                        <td class="text-center">
                            @if($order->order_status === 'delivered')
                                <span class="admin-badge admin-badge-success">Delivered</span>
                            @elseif($order->order_status === 'shipped')
                                <span class="admin-badge admin-badge-info">Shipped</span>
                            @elseif($order->order_status === 'processing')
                                <span class="admin-badge admin-badge-purple">Processing</span>
                            @elseif($order->order_status === 'confirmed')
                                <span class="admin-badge admin-badge-info">Confirmed</span>
                            @elseif($order->order_status === 'cancelled')
                                <span class="admin-badge admin-badge-danger">Cancelled</span>
                            @else
                                <span class="admin-badge admin-badge-warning">Pending</span>
                            @endif
                            @if($order->courier_name)
                                <small class="text-muted d-block mt-0.5" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-truck-fast me-1"></i>{{ $order->courier_name }}
                                </small>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="admin-action-btn admin-action-view" title="Manage order details">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <div class="py-3">
                                <i class="fa-solid fa-receipt fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No orders found</h6>
                                <p class="small text-muted mb-0">No customer acquisitions match your filter criteria.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="admin-pagination-bar">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
