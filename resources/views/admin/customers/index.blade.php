@extends('admin.layouts.admin')

@section('title', 'Patrons Intelligence')
@section('page_title', 'Patrons & Customer Intelligence')
@section('page_subtitle', 'VIP patron profiles, order frequencies, and lifetime value across Pakistan')

@section('content')
<!-- Search & Filter Bar -->
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex align-items-center gap-3">
        <div class="flex-grow-1 position-relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search patrons by name, email, phone, city..." class="ps-3">
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="admin-btn-primary">
                <i class="fa-solid fa-magnifying-glass small"></i>
                <span>Search</span>
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.customers.index') }}" class="admin-btn-reset" title="Clear Search">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Customers Table Card -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Patron Profile</th>
                    <th>Contact Details</th>
                    <th>City / Province</th>
                    <th class="text-end">Orders Placed</th>
                    <th class="text-end">Lifetime Value</th>
                    <th>Member Since</th>
                    <th class="text-end" style="width: 90px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light border text-primary d-flex align-items-center justify-content-center fw-bold text-xs" style="width: 38px; height: 38px; min-width: 38px;">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-dark fw-semibold text-decoration-none d-block text-truncate" style="max-width: 200px;">
                                        {{ $customer->name }}
                                    </a>
                                    @if(($customer->orders_sum_total_amount ?? 0) >= 50000)
                                        <span class="admin-badge admin-badge-warning" style="font-size: 0.6rem;">VIP CONNOISSEUR</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark small">{{ $customer->email }}</div>
                            <small class="text-muted font-monospace" style="font-size: 0.72rem;">{{ $customer->phone ?? 'No phone' }}</small>
                        </td>
                        <td>
                            <span class="text-dark">{{ $customer->city ?? 'Pakistan' }}</span>
                        </td>
                        <td class="text-end font-monospace">
                            <span class="fw-bold text-dark fs-6">{{ $customer->orders_count }}</span>
                            <small class="text-muted" style="font-size: 0.7rem;">orders</small>
                        </td>
                        <td class="text-end font-monospace">
                            <span class="fw-bold text-dark fs-6">
                                Rs. {{ number_format($customer->orders_sum_total_amount ?? 0, 0) }}
                            </span>
                        </td>
                        <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="admin-action-btn admin-action-view" title="Inspect Patron Profile">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="py-3">
                                <i class="fa-solid fa-users fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No patron records found</h6>
                                <p class="small text-muted mb-0">Customer accounts will populate as orders are placed.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div class="admin-pagination-bar">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
