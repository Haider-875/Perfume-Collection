@extends('admin.layouts.admin')

@section('title', 'Overview & Analytics')
@section('page_title', 'Maison Overview & Intelligence')
@section('page_subtitle', 'Real-time telemetry, revenue analytics, and boutique operations')

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.products.create') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
        <i class="fa-solid fa-plus"></i>
        <span>New Fragrance</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
        <i class="fa-solid fa-receipt"></i>
        <span>View Orders</span>
    </a>
</div>
@endsection

@section('content')
<!-- Metric Stat Cards Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <!-- Today's Sales -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4 relative overflow-hidden group hover:border-brand-gold/40 transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] uppercase tracking-wider text-brand-muted">Today's Revenue</span>
            <div class="w-8 h-8 rounded-lg bg-brand-gold/10 border border-brand-gold/20 flex items-center justify-center text-brand-gold text-xs">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-xl font-bold font-serif text-brand-text">Rs. {{ number_format($todaySales, 0) }}</div>
            <div class="text-[11px] text-brand-gold mt-1 flex items-center gap-1">
                <span>{{ $todayOrdersCount }} orders placed today</span>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4 relative overflow-hidden group hover:border-brand-gold/40 transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] uppercase tracking-wider text-brand-muted">Total Lifetime Sales</span>
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-xs">
                <i class="fa-solid fa-vault"></i>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-xl font-bold font-serif text-brand-text">Rs. {{ number_format($totalRevenue, 0) }}</div>
            <div class="text-[11px] text-emerald-400 mt-1 flex items-center gap-1">
                <span>{{ $totalOrdersCount }} total patron orders</span>
            </div>
        </div>
    </div>

    <!-- Average Order Value (AOV) -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4 relative overflow-hidden group hover:border-brand-gold/40 transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] uppercase tracking-wider text-brand-muted">Average Order (AOV)</span>
            <div class="w-8 h-8 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 text-xs">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-xl font-bold font-serif text-brand-text">Rs. {{ number_format($averageOrderValue, 0) }}</div>
            <div class="text-[11px] text-brand-muted mt-1">Per transaction average</div>
        </div>
    </div>

    <!-- Pending Verifications Alert -->
    <div class="bg-brand-surface border {{ $pendingVerificationsCount > 0 ? 'border-amber-500/50 bg-amber-950/10' : 'border-brand-border/60' }} rounded-xl p-4 relative overflow-hidden group transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] uppercase tracking-wider text-brand-muted">Pending Verifications</span>
            <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-xs">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
        </div>
        <div class="mt-3 flex items-baseline justify-between">
            <div class="text-xl font-bold font-serif {{ $pendingVerificationsCount > 0 ? 'text-amber-400' : 'text-brand-text' }}">
                {{ $pendingVerificationsCount }}
            </div>
            @if($pendingVerificationsCount > 0)
                <a href="{{ route('admin.orders.index', ['payment_status' => 'pending_verification']) }}" class="text-[11px] text-amber-400 hover:underline">
                    Verify Receipts &rarr;
                </a>
            @endif
        </div>
        <div class="text-[11px] text-brand-muted mt-1">Bank / Wallet slips awaiting review</div>
    </div>
</div>

<!-- Secondary Metrics Bar: Live Visitors & Device Split -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Live Traffic & Visitors -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5 md:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <h3 class="font-serif text-base font-semibold text-brand-text">Live Boutique Traffic Telemetry</h3>
            </div>
            <span class="text-xs text-brand-gold bg-brand-gold/10 px-2.5 py-1 rounded-full border border-brand-gold/20">
                {{ $liveVisitorsCount }} Patrons Active Now
            </span>
        </div>

        <div class="grid grid-cols-3 gap-3 border-t border-brand-border/40 pt-4">
            <div>
                <div class="text-xs text-brand-muted uppercase tracking-wider">Today's Visits</div>
                <div class="text-lg font-serif font-bold text-brand-text mt-1">{{ number_format($todayVisitsCount) }}</div>
            </div>
            <div>
                <div class="text-xs text-brand-muted uppercase tracking-wider">Unique Patrons</div>
                <div class="text-lg font-serif font-bold text-brand-text mt-1">{{ number_format($todayUniqueVisitors) }}</div>
            </div>
            <div>
                <div class="text-xs text-brand-muted uppercase tracking-wider">Conversion Rate</div>
                <div class="text-lg font-serif font-bold text-brand-gold mt-1">{{ $conversionRate }}%</div>
            </div>
        </div>
    </div>

    <!-- Device Split -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5">
        <h3 class="font-serif text-base font-semibold text-brand-text mb-3">Device Split</h3>
        <div class="space-y-3">
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-brand-muted"><i class="fa-solid fa-mobile-screen mr-1 text-brand-gold"></i> Mobile Visitors</span>
                    <span class="text-brand-text font-medium">{{ $mobilePercentage }}%</span>
                </div>
                <div class="w-full bg-brand-card h-2 rounded-full overflow-hidden">
                    <div class="bg-brand-gold h-full rounded-full" style="width: {{ $mobilePercentage }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-brand-muted"><i class="fa-solid fa-laptop mr-1 text-brand-muted"></i> Desktop Patrons</span>
                    <span class="text-brand-text font-medium">{{ $desktopPercentage }}%</span>
                </div>
                <div class="w-full bg-brand-card h-2 rounded-full overflow-hidden">
                    <div class="bg-brand-muted h-full rounded-full" style="width: {{ $desktopPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Trend Chart & Top Selling -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- 7-Day Revenue Trend Chart -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-serif text-lg font-semibold text-brand-text">7-Day Sales & Volume Trend</h3>
                <p class="text-xs text-brand-muted">Daily gross revenue in PKR across Pakistani territories</p>
            </div>
            <span class="text-xs text-brand-muted bg-brand-card px-3 py-1 rounded-lg border border-brand-border/50">Past 7 Days</span>
        </div>
        <div class="h-64">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Fragrances -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5">
        <h3 class="font-serif text-lg font-semibold text-brand-text mb-4">Best Sellers</h3>
        <div class="space-y-3">
            @forelse($topSelling as $index => $item)
                <div class="flex items-center justify-between pb-3 border-b border-brand-border/30 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <span class="w-5 text-center font-serif text-xs font-bold {{ $index === 0 ? 'text-brand-gold' : 'text-brand-muted' }}">0{{ $index + 1 }}</span>
                        <div>
                            <div class="text-xs font-medium text-brand-text">{{ $item->product_name }}</div>
                            <div class="text-[11px] text-brand-muted">{{ $item->total_qty }} units acquired</div>
                        </div>
                    </div>
                    <div class="text-xs font-serif font-bold text-brand-gold">
                        Rs. {{ number_format($item->total_sales, 0) }}
                    </div>
                </div>
            @empty
                <div class="text-xs text-brand-muted py-6 text-center">No sales recorded yet.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Regional Intelligence & Low Stock Alerts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Orders by Pakistani City & Province -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5 lg:col-span-2">
        <h3 class="font-serif text-lg font-semibold text-brand-text mb-1">Pakistani Geographic Distribution</h3>
        <p class="text-xs text-brand-muted mb-4">Order frequency across metropolitan hubs and provinces</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- By City -->
            <div class="bg-brand-card/50 border border-brand-border/40 rounded-lg p-3">
                <h4 class="text-xs uppercase tracking-wider text-brand-gold mb-3 font-semibold">Top Metros</h4>
                <div class="space-y-2">
                    @forelse($ordersByCity as $cityStat)
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-brand-text">{{ $cityStat->city ?? 'Unknown' }}</span>
                            <span class="text-brand-muted font-serif font-medium">{{ $cityStat->total_orders }} orders (Rs. {{ number_format($cityStat->total_amount, 0) }})</span>
                        </div>
                    @empty
                        <div class="text-xs text-brand-muted">No regional orders yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- By Province -->
            <div class="bg-brand-card/50 border border-brand-border/40 rounded-lg p-3">
                <h4 class="text-xs uppercase tracking-wider text-brand-gold mb-3 font-semibold">Provinces</h4>
                <div class="space-y-2">
                    @forelse($ordersByProvince as $provStat)
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-brand-text">{{ $provStat->province ?? 'Unspecified' }}</span>
                            <span class="text-brand-muted font-serif font-medium">{{ $provStat->total_orders }} orders</span>
                        </div>
                    @empty
                        <div class="text-xs text-brand-muted">No regional orders yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-lg font-semibold text-brand-text">Stock Alerts</h3>
            <span class="text-[11px] text-amber-400 bg-amber-950/30 px-2 py-0.5 rounded border border-amber-500/30">&le; 10 bottles</span>
        </div>
        <div class="space-y-3">
            @forelse($lowStockProducts as $lowProd)
                <div class="flex items-center justify-between pb-2 border-b border-brand-border/30 last:border-0">
                    <div>
                        <a href="{{ route('admin.products.edit', $lowProd->id) }}" class="text-xs text-brand-text hover:text-brand-gold font-medium block truncate max-w-[170px]">
                            {{ $lowProd->name }}
                        </a>
                        <span class="text-[10px] text-brand-muted">{{ $lowProd->category->name ?? 'Fragrance' }}</span>
                    </div>
                    <span class="text-xs font-bold {{ $lowProd->stock <= 3 ? 'text-rose-400' : 'text-amber-400' }}">
                        {{ $lowProd->stock }} left
                    </span>
                </div>
            @empty
                <div class="text-xs text-emerald-400 py-4 text-center">
                    <i class="fa-solid fa-check-circle mr-1"></i> Vault reserves are well stocked.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-serif text-lg font-semibold text-brand-text">Recent Orders</h3>
            <p class="text-xs text-brand-muted">Latest acquisitions from patrons nationwide</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-brand-gold hover:text-brand-goldLight flex items-center gap-1">
            <span>View All Orders</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Order Number</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($recentOrders as $ord)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3 font-mono font-medium text-brand-text">#{{ $ord->order_number }}</td>
                        <td class="px-4 py-3">
                            <div class="text-brand-text font-medium">{{ $ord->customer_name }}</div>
                            <div class="text-[10px] text-brand-muted">{{ $ord->customer_phone }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $ord->city }}, {{ $ord->province }}</td>
                        <td class="px-4 py-3 font-serif font-bold text-brand-gold">{{ $ord->formatted_total }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $ord->payment_status === 'paid' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : ($ord->payment_status === 'pending_verification' ? 'bg-amber-950/40 text-amber-400 border border-amber-500/30' : 'bg-brand-card text-brand-muted') }}">
                                {{ str_replace('_', ' ', $ord->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $ord->order_status === 'delivered' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : ($ord->order_status === 'shipped' ? 'bg-purple-950/40 text-purple-400 border border-purple-500/30' : 'bg-brand-card text-brand-text') }}">
                                {{ $ord->order_status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-brand-gold hover:underline">
                                Inspect
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-brand-muted">No orders in archive.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const chartLabels = @json($chartLabels);
        const salesTrend = @json($salesTrend);
        const ordersTrend = @json($ordersTrend);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Gross Revenue (PKR)',
                        data: salesTrend,
                        borderColor: '#C9A24B',
                        backgroundColor: 'rgba(201, 162, 75, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders Count',
                        data: ordersTrend,
                        borderColor: '#E6C77A',
                        borderDash: [5, 5],
                        borderWidth: 1.5,
                        tension: 0.2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#9E8E81', font: { size: 11 } }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(42, 21, 27, 0.4)' },
                        ticks: { color: '#9E8E81', font: { size: 10 } }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: 'rgba(42, 21, 27, 0.4)' },
                        ticks: { 
                            color: '#C9A24B',
                            callback: value => 'Rs. ' + (value >= 1000 ? (value/1000) + 'k' : value)
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { color: '#E6C77A', stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
@endpush
