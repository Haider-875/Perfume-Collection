@extends('admin.layouts.admin')

@section('title', 'Audit & Security Logs')
@section('page_title', 'Maison Audit & Security Logs')
@section('page_subtitle', 'Immutable security audit trail of administrative modifications, orders, and configuration updates')

@section('content')
<!-- Filter Bar -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4">
    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <!-- Search -->
        <div class="sm:col-span-2 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-muted text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by description, admin user, or IP..."
                   class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg pl-9 pr-4 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
        </div>

        <!-- Action Filter -->
        <div class="flex items-center gap-2">
            <select name="action" class="flex-1 bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Actions</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $act)) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg px-4 py-2 text-xs font-medium transition">
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Timestamp</th>
                    <th class="px-4 py-3">Concierge / Admin</th>
                    <th class="px-4 py-3">Action Type</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Target Subject</th>
                    <th class="px-4 py-3 text-right">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($logs as $log)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3 font-mono text-[11px] text-brand-muted whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                        <td class="px-4 py-3 font-medium text-brand-text">{{ $log->user_name ?? 'System' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-mono font-semibold bg-brand-card text-brand-gold border border-brand-border/50">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-brand-text font-medium">{{ $log->description }}</td>
                        <td class="px-4 py-3 text-brand-muted font-mono text-[11px]">
                            {{ $log->subject_type ? $log->subject_type . ' #' . $log->subject_id : 'General' }}
                        </td>
                        <td class="px-4 py-3 text-right font-mono text-[11px] text-brand-muted">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-brand-muted">No activity logs recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="px-5 py-3 border-t border-brand-border/40 bg-brand-card/20">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
