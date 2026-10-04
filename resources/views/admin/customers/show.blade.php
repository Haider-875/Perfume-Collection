@extends('admin.layouts.admin')

@section('title', 'Patron Profile: ' . $customer->name)
@section('page_title', 'Patron Dossier: ' . $customer->name)
@section('page_subtitle', 'Member since ' . $customer->created_at->format('F Y') . ' | Lifetime Spend: Rs. ' . number_format($totalSpend, 0))

@section('header_actions')
<a href="{{ route('admin.customers.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Patrons List</span>
</a>
@endsection

@section('content')
<!-- Header Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-3 h-100">
            <span class="small fw-semibold text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Acquisitions</span>
            <div class="fs-4 fw-bold text-dark mt-1">{{ $customer->orders->count() }} Orders</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-3 h-100">
            <span class="small fw-semibold text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Lifetime Spend</span>
            <div class="fs-4 fw-bold text-primary font-monospace mt-1">Rs. {{ number_format($totalSpend, 0) }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-3 h-100">
            <span class="small fw-semibold text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Email Address</span>
            <div class="small fw-medium text-dark mt-1.5 text-truncate">{{ $customer->email }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="admin-card p-3 h-100">
            <span class="small fw-semibold text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Contact Phone</span>
            <div class="small fw-medium text-dark mt-1.5">{{ $customer->phone ?? 'Not provided' }}</div>
        </div>
    </div>
</div>

<!-- Order History Table -->
<div class="admin-card">
    <div class="px-4 py-3 bg-white border-bottom">
        <h6 class="fw-bold text-dark mb-0">Acquisitions History</h6>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th class="text-end">Items</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Inspect</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer->orders as $ord)
                    <tr>
                        <td class="font-monospace fw-semibold text-primary">#{{ $ord->order_number }}</td>
                        <td class="small">{{ $ord->created_at->format('d M Y') }}</td>
                        <td class="text-end small">{{ $ord->items->count() }} bottles</td>
                        <td class="text-end small font-monospace fw-bold">{{ $ord->formatted_total }}</td>
                        <td class="text-center">
                            <span class="admin-badge admin-badge-{{ $ord->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $ord->payment_status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="admin-badge admin-badge-{{ in_array($ord->order_status, ['delivered', 'completed']) ? 'success' : 'info' }}">
                                {{ $ord->order_status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $ord->id) }}" class="admin-btn-secondary" style="height: 30px; font-size: 0.75rem; padding: 0 0.65rem;">
                                Manage &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-5 text-center text-muted">No orders recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
