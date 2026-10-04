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
<div class="space-y-6">
    <!-- Header Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="admin-card p-4">
            <span class="text-[10px] uppercase text-brand-muted tracking-wider block font-semibold">Total Acquisitions</span>
            <div class="text-xl font-bold font-serif text-brand-text mt-1">{{ $customer->orders->count() }} Orders</div>
        </div>
        <div class="admin-card p-4">
            <span class="text-[10px] uppercase text-brand-muted tracking-wider block font-semibold">Lifetime Spend</span>
            <div class="text-xl font-bold font-serif text-brand-gold mt-1">Rs. {{ number_format($totalSpend, 0) }}</div>
        </div>
        <div class="admin-card p-4">
            <span class="text-[10px] uppercase text-brand-muted tracking-wider block font-semibold">Email Address</span>
            <div class="text-xs text-brand-text font-medium mt-1.5 truncate">{{ $customer->email }}</div>
        </div>
        <div class="admin-card p-4">
            <span class="text-[10px] uppercase text-brand-muted tracking-wider block font-semibold">Contact Phone</span>
            <div class="text-xs text-brand-text font-medium mt-1.5">{{ $customer->phone ?? 'Not provided' }}</div>
        </div>
    </div>

    <!-- Order History Table -->
    <div class="admin-card overflow-hidden">
        <div class="p-4 border-b border-brand-border/40">
            <h3 class="font-serif text-base font-semibold text-brand-text">
                Acquisitions History
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-brand-muted">
                <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                    <tr>
                        <th class="px-4 py-3">Order #</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-end">Items</th>
                        <th class="px-4 py-3 text-end">Total</th>
                        <th class="px-4 py-3 text-center">Payment</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Inspect</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/30">
                    @forelse($customer->orders as $ord)
                        <tr class="hover:bg-brand-card/30">
                            <td class="px-4 py-3 font-mono font-medium text-brand-gold">#{{ $ord->order_number }}</td>
                            <td class="px-4 py-3">{{ $ord->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-end">{{ $ord->items->count() }} bottles</td>
                            <td class="px-4 py-3 text-end font-serif font-bold text-brand-text">{{ $ord->formatted_total }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="admin-badge admin-badge-{{ $ord->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ $ord->payment_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="admin-badge admin-badge-{{ in_array($ord->order_status, ['delivered', 'completed']) ? 'success' : 'info' }}">
                                    {{ $ord->order_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="admin-btn-secondary inline-flex text-xs py-1 px-2.5">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-brand-muted">No orders recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
