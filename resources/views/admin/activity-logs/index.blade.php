@extends('admin.layouts.admin')

@section('title', 'Audit & Security Logs')
@section('page_title', 'Maison Audit & Security Logs')
@section('page_subtitle', 'Immutable security audit trail of administrative modifications, orders, and configuration updates')

@section('content')
<!-- Filter Bar -->
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <!-- Search -->
        <div class="sm:col-span-2 position-relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by description, admin user, or IP address..." class="ps-3">
        </div>

        <!-- Action Filter & Buttons -->
        <div class="d-flex align-items-center gap-2">
            <select name="action" class="flex-fill">
                <option value="">All Audit Actions</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $act)) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn-primary">
                <i class="fa-solid fa-filter small"></i>
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search', 'action']))
                <a href="{{ route('admin.activity-logs.index') }}" class="admin-btn-reset" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Logs Table Card -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 170px;">Timestamp</th>
                    <th>Concierge / Admin</th>
                    <th class="text-center" style="width: 140px;">Action Type</th>
                    <th>Description</th>
                    <th>Target Subject</th>
                    <th class="text-end" style="width: 130px;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                            {{ $log->created_at->format('d M Y, H:i:s') }}
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $log->user_name ?? 'System' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="admin-badge admin-badge-info font-monospace" style="font-size: 0.65rem;">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>
                            <span class="text-dark">{{ $log->description }}</span>
                        </td>
                        <td>
                            <span class="font-monospace small text-muted">
                                {{ $log->subject_type ? $log->subject_type . ' #' . $log->subject_id : 'General' }}
                            </span>
                        </td>
                        <td class="text-end font-monospace small text-muted">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="py-3">
                                <i class="fa-solid fa-shield-halved fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No activity logs recorded</h6>
                                <p class="small text-muted mb-0">System updates and administrative actions will log automatically here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="admin-pagination-bar">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
