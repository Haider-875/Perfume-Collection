@extends('admin.layouts.admin')

@section('title', 'Patrons Intelligence')
@section('page_title', 'Patrons & Customer Intelligence')
@section('page_subtitle', 'VIP patron profiles, order frequencies, and lifetime value across Pakistan')

@section('content')
<!-- Search Bar -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="flex items-center gap-3">
        <div class="flex-1 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-muted text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patrons by name, email, phone, city..."
                   class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg pl-9 pr-4 py-2 text-xs text-brand-text placeholder-brand-muted/60 focus:outline-none focus:border-brand-gold">
        </div>
        <button type="submit" class="bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg px-4 py-2 text-xs font-medium transition">
            Search
        </button>
    </form>
</div>

<!-- Customers Table -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Patron Profile</th>
                    <th class="px-4 py-3">Contact Details</th>
                    <th class="px-4 py-3">City / Province</th>
                    <th class="px-4 py-3 text-center">Orders Placed</th>
                    <th class="px-4 py-3">Lifetime Value</th>
                    <th class="px-4 py-3">Member Since</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($customers as $customer)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-brand-maroon/50 border border-brand-gold/40 flex items-center justify-center font-bold text-xs text-brand-gold">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-brand-text hover:text-brand-gold font-medium block">
                                        {{ $customer->name }}
                                    </a>
                                    @if(($customer->orders_sum_total_amount ?? 0) >= 50000)
                                        <span class="text-[9px] text-brand-gold uppercase tracking-wider font-semibold">VIP CONNOISSEUR</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div>{{ $customer->email }}</div>
                            <div class="text-[10px] text-brand-muted">{{ $customer->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $customer->city ?? 'Pakistan' }}</td>
                        <td class="px-4 py-3 text-center font-bold text-brand-text">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 font-serif font-bold text-brand-gold">
                            Rs. {{ number_format($customer->orders_sum_total_amount ?? 0, 0) }}
                        </td>
                        <td class="px-4 py-3 text-[11px]">{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="px-2.5 py-1 rounded bg-brand-card hover:bg-brand-border text-brand-gold text-[11px] font-medium border border-brand-border/50 transition">
                                Profile &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-brand-muted">No patron records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div class="px-5 py-3 border-t border-brand-border/40 bg-brand-card/20">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
