@extends('admin.layouts.admin')

@section('title', 'Orders & Receipts')
@section('page_title', 'Patron Orders & Receipts')
@section('page_subtitle', 'Process acquisitions, verify payment slips, update fulfillment status, and track couriers')

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.orders.export-csv', request()->query()) }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-file-export"></i>
        <span>Export Orders CSV</span>
    </a>
</div>
@endsection

@section('content')
<!-- Search & Filter Bar -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
        <!-- Search -->
        <div class="lg:col-span-2 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-muted text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, name, phone, email..."
                   class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg pl-9 pr-4 py-2 text-xs text-brand-text placeholder-brand-muted/60 focus:outline-none focus:border-brand-gold">
        </div>

        <!-- Order Status Filter -->
        <div>
            <select name="status" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
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
            <select name="payment_status" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Payment Status</option>
                <option value="pending_verification" {{ request('payment_status') === 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid / COD</option>
                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <!-- Province Filter -->
        <div>
            <select name="province" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Provinces</option>
                @foreach($provinces as $prov)
                    <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg py-2 text-xs font-medium transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'payment_status', 'province']))
                <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-lg bg-brand-black/60 text-brand-muted hover:text-brand-text border border-brand-border/60 text-xs">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Order Number</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Destination</th>
                    <th class="px-4 py-3">Total (PKR)</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Fulfillment</th>
                    <th class="px-4 py-3 text-right">Inspect</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($orders as $order)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-medium text-brand-gold hover:underline">
                                #{{ $order->order_number }}
                            </a>
                            @if($order->payment_receipt)
                                <span class="block text-[9px] text-amber-400 font-sans mt-0.5"><i class="fa-solid fa-paperclip"></i> Receipt Attached</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-[11px]">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-4 py-3">
                            <div class="text-brand-text font-medium">{{ $order->customer_name }}</div>
                            <div class="text-[10px] text-brand-muted">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-brand-text">{{ $order->city }}</div>
                            <div class="text-[10px] text-brand-muted">{{ $order->province }}</div>
                        </td>
                        <td class="px-4 py-3 font-serif font-bold text-brand-text">{{ $order->formatted_total }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $order->payment_status === 'paid' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : ($order->payment_status === 'pending_verification' ? 'bg-amber-950/40 text-amber-400 border border-amber-500/30' : 'bg-brand-card text-brand-muted border border-brand-border/40') }}">
                                {{ str_replace('_', ' ', $order->payment_status) }}
                            </span>
                            <span class="block text-[9px] text-brand-muted mt-0.5 uppercase">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $order->order_status === 'delivered' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : ($order->order_status === 'shipped' ? 'bg-purple-950/40 text-purple-400 border border-purple-500/30' : ($order->order_status === 'confirmed' ? 'bg-brand-gold/20 text-brand-gold border border-brand-gold/40' : 'bg-brand-card text-brand-text')) }}">
                                {{ $order->order_status }}
                            </span>
                            @if($order->courier_name)
                                <span class="block text-[9px] text-brand-muted mt-0.5">{{ $order->courier_name }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="px-2.5 py-1 rounded bg-brand-card hover:bg-brand-border text-brand-gold text-[11px] font-medium border border-brand-border/50 transition">
                                Manage &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-brand-muted">No orders found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-5 py-3 border-t border-brand-border/40 bg-brand-card/20">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
