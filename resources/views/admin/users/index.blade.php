@extends('admin.layouts.admin')

@section('title', 'Staff Roles & Permissions')
@section('page_title', 'Administrative Staff & Access Delegation')
@section('page_subtitle', 'Manage team accounts, define roles, grant fine-grained permissions, and audit security access')

@section('header_actions')
<a href="{{ route('admin.users.create') }}" class="admin-btn-primary">
    <i class="fa-solid fa-user-plus"></i>
    <span>Provision Staff Member</span>
</a>
@endsection

@section('content')
<!-- Staff Overview & Search Bar -->
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="sm:col-span-2 position-relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone..."
                   class="ps-3">
        </div>
        <div class="d-flex align-items-center gap-2">
            <select name="role" class="flex-fill">
                <option value="">All Administrative Roles</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Administrator</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="order_manager" {{ request('role') === 'order_manager' ? 'selected' : '' }}>Order Specialist</option>
                <option value="catalog_manager" {{ request('role') === 'catalog_manager' ? 'selected' : '' }}>Catalog Manager</option>
            </select>
            <button type="submit" class="admin-btn-primary">
                <i class="fa-solid fa-filter small"></i>
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="admin-btn-reset" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Role Matrix Reference Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <div class="bg-white border rounded-3 p-3 shadow-xs" style="border-left: 4px solid #f59e0b !important;">
        <div class="d-flex align-items-center gap-2 text-warning small fw-bold text-uppercase tracking-wider mb-1">
            <i class="fa-solid fa-crown"></i>
            <span>Super Administrator</span>
        </div>
        <p class="small text-muted mb-0" style="font-size: 0.72rem;">Total authority over all systems, revenue, settings, staff roles, and audit trail.</p>
    </div>

    <div class="bg-white border rounded-3 p-3 shadow-xs" style="border-left: 4px solid #0d6efd !important;">
        <div class="d-flex align-items-center gap-2 text-primary small fw-bold text-uppercase tracking-wider mb-1">
            <i class="fa-solid fa-user-shield"></i>
            <span>Store Administrator</span>
        </div>
        <p class="small text-muted mb-0" style="font-size: 0.72rem;">Full catalog, orders, patrons, marketing, and operational management.</p>
    </div>

    <div class="bg-white border rounded-3 p-3 shadow-xs" style="border-left: 4px solid #10b981 !important;">
        <div class="d-flex align-items-center gap-2 text-success small fw-bold text-uppercase tracking-wider mb-1">
            <i class="fa-solid fa-dolly"></i>
            <span>Order Specialist</span>
        </div>
        <p class="small text-muted mb-0" style="font-size: 0.72rem;">Order processing, bank slip verification, courier tracking (TCS, Trax, Leopards).</p>
    </div>

    <div class="bg-white border rounded-3 p-3 shadow-xs" style="border-left: 4px solid #8b5cf6 !important;">
        <div class="d-flex align-items-center gap-2 text-purple small fw-bold text-uppercase tracking-wider mb-1">
            <i class="fa-solid fa-spray-can"></i>
            <span>Catalog Manager</span>
        </div>
        <p class="small text-muted mb-0" style="font-size: 0.72rem;">Formulations, olfactory notes, pricing tiers, discounts, and inventory control.</p>
    </div>
</div>

<!-- Staff Users Table Card -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Team Member</th>
                    <th>Assigned Role</th>
                    <th>Permissions Scope</th>
                    <th>Phone / Location</th>
                    <th class="text-center">Status</th>
                    <th>Created</th>
                    <th class="text-end" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffUsers as $staff)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light border text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; min-width: 38px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;">{{ $staff->name }}</div>
                                    <small class="text-muted font-monospace d-block text-truncate" style="font-size: 0.72rem;">{{ $staff->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($staff->role === 'super_admin')
                                <span class="admin-badge admin-badge-warning">
                                    <i class="fa-solid fa-crown small"></i> Super Admin
                                </span>
                            @elseif($staff->role === 'admin')
                                <span class="admin-badge admin-badge-info">
                                    <i class="fa-solid fa-user-shield small"></i> Administrator
                                </span>
                            @elseif($staff->role === 'order_manager')
                                <span class="admin-badge admin-badge-success">
                                    <i class="fa-solid fa-dolly small"></i> Order Specialist
                                </span>
                            @else
                                <span class="admin-badge admin-badge-purple">
                                    <i class="fa-solid fa-spray-can small"></i> Catalog Manager
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($staff->role === 'super_admin')
                                <span class="small text-warning fw-semibold">★ Unrestricted Access (All Modules)</span>
                            @else
                                <div class="d-flex flex-wrap gap-1" style="max-width: 280px;">
                                    @php
                                        $perms = is_array($staff->permissions) ? $staff->permissions : (json_decode($staff->permissions ?? '[]', true) ?: []);
                                    @endphp
                                    @if(count($perms) > 0)
                                        @foreach(array_slice($perms, 0, 3) as $p)
                                            <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.68rem;">
                                                {{ $availablePermissions[$p]['label'] ?? $p }}
                                            </span>
                                        @endforeach
                                        @if(count($perms) > 3)
                                            <span class="badge bg-light text-muted border fw-normal" style="font-size: 0.68rem;">
                                                +{{ count($perms) - 3 }} more
                                            </span>
                                        @endif
                                    @else
                                        <span class="small text-muted fst-italic" style="font-size: 0.75rem;">Default role permissions</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="text-dark small">{{ $staff->phone ?: '—' }}</div>
                            <small class="text-muted" style="font-size: 0.72rem;">{{ $staff->city ?: 'Pakistan' }}</small>
                        </td>
                        <td class="text-center">
                            @if($staff->is_active !== false)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Suspended</span>
                            @endif
                        </td>
                        <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                            {{ $staff->created_at ? $staff->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-1.5">
                                <a href="{{ route('admin.users.edit', $staff->id) }}" class="admin-action-btn admin-action-edit" title="Edit Permissions">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if($staff->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $staff->id) }}" onsubmit="return confirm('Are you certain you wish to revoke and delete this staff account?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-action-btn admin-action-delete" title="Revoke Staff Account">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="py-3">
                                <i class="fa-solid fa-users-slash fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No staff accounts found</h6>
                                <p class="small text-muted mb-3">Provision accounts for administrators and dispatch managers.</p>
                                <a href="{{ route('admin.users.create') }}" class="admin-btn-primary">
                                    <i class="fa-solid fa-user-plus"></i> Provision Staff Member
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($staffUsers->hasPages())
        <div class="admin-pagination-bar">
            {{ $staffUsers->links() }}
        </div>
    @endif
</div>
@endsection
