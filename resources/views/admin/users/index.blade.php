@extends('admin.layouts.admin')

@section('title', 'Staff Roles & Permissions')
@section('page_title', 'Administrative Staff & Access Delegation')
@section('page_subtitle', 'Manage team accounts, define roles, grant fine-grained permissions, and audit security access')

@section('header_actions')
<a href="{{ route('admin.users.create') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-user-plus"></i>
    <span>Provision Staff Member</span>
</a>
@endsection

@section('content')
<!-- Staff Overview & Search -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4">
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="sm:col-span-2 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-muted text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone..."
                   class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg pl-9 pr-4 py-2 text-xs text-brand-text placeholder-brand-muted/60 focus:outline-none focus:border-brand-gold">
        </div>
        <div class="flex items-center gap-2">
            <select name="role" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Administrative Roles</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Administrator</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="order_manager" {{ request('role') === 'order_manager' ? 'selected' : '' }}>Order Specialist</option>
                <option value="catalog_manager" {{ request('role') === 'catalog_manager' ? 'selected' : '' }}>Catalog Manager</option>
            </select>
            <button type="submit" class="bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg px-4 py-2 text-xs font-medium transition">
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Role Matrix Reference Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-brand-surface border border-amber-500/30 rounded-xl p-4">
        <div class="flex items-center gap-2 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-1">
            <i class="fa-solid fa-crown"></i>
            <span>Super Administrator</span>
        </div>
        <p class="text-[11px] text-brand-muted">Total authority over all systems, revenue, settings, staff roles, and audit trail.</p>
    </div>

    <div class="bg-brand-surface border border-blue-500/30 rounded-xl p-4">
        <div class="flex items-center gap-2 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-1">
            <i class="fa-solid fa-user-shield"></i>
            <span>Store Administrator</span>
        </div>
        <p class="text-[11px] text-brand-muted">Full catalog, orders, patrons, marketing, and operational management.</p>
    </div>

    <div class="bg-brand-surface border border-emerald-500/30 rounded-xl p-4">
        <div class="flex items-center gap-2 text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1">
            <i class="fa-solid fa-dolly"></i>
            <span>Order Specialist</span>
        </div>
        <p class="text-[11px] text-brand-muted">Order processing, bank slip verification, courier tracking (TCS, Trax, Leopards).</p>
    </div>

    <div class="bg-brand-surface border border-purple-500/30 rounded-xl p-4">
        <div class="flex items-center gap-2 text-purple-400 text-xs font-semibold uppercase tracking-wider mb-1">
            <i class="fa-solid fa-spray-can"></i>
            <span>Catalog Manager</span>
        </div>
        <p class="text-[11px] text-brand-muted">Formulations, olfactory notes, pricing tiers, discounts, and inventory control.</p>
    </div>
</div>

<!-- Staff Users Table -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-5 py-3">Team Member</th>
                    <th class="px-4 py-3">Assigned Role</th>
                    <th class="px-4 py-3">Permissions Scope</th>
                    <th class="px-4 py-3">Phone / Location</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($staffUsers as $staff)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-brand-maroon/60 border border-brand-gold/40 flex items-center justify-center font-bold text-xs text-brand-gold">
                                    {{ substr($staff->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-brand-text">{{ $staff->name }}</div>
                                    <div class="text-[11px] text-brand-muted font-mono">{{ $staff->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @if($staff->role === 'super_admin')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30 flex items-center gap-1.5 w-max">
                                    <i class="fa-solid fa-crown text-[9px]"></i> Super Admin
                                </span>
                            @elseif($staff->role === 'admin')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/30 flex items-center gap-1.5 w-max">
                                    <i class="fa-solid fa-user-shield text-[9px]"></i> Administrator
                                </span>
                            @elseif($staff->role === 'order_manager')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5 w-max">
                                    <i class="fa-solid fa-dolly text-[9px]"></i> Order Specialist
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/30 flex items-center gap-1.5 w-max">
                                    <i class="fa-solid fa-spray-can text-[9px]"></i> Catalog Manager
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if($staff->role === 'super_admin')
                                <span class="text-xs text-amber-300/90 font-medium">★ Unrestricted Access (All Modules)</span>
                            @else
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @php
                                        $perms = is_array($staff->permissions) ? $staff->permissions : (json_decode($staff->permissions ?? '[]', true) ?: []);
                                    @endphp
                                    @if(count($perms) > 0)
                                        @foreach(array_slice($perms, 0, 3) as $p)
                                            <span class="px-2 py-0.5 rounded text-[9px] bg-brand-card text-brand-gold border border-brand-border/60">
                                                {{ $availablePermissions[$p]['label'] ?? $p }}
                                            </span>
                                        @endforeach
                                        @if(count($perms) > 3)
                                            <span class="px-1.5 py-0.5 rounded text-[9px] bg-brand-card text-brand-muted">
                                                +{{ count($perms) - 3 }} more
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-[11px] text-brand-muted italic">Default role permissions</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-brand-text">{{ $staff->phone ?: '—' }}</div>
                            <div class="text-[10px] text-brand-muted">{{ $staff->city ?: 'Pakistan' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            @if($staff->is_active !== false)
                                <span class="inline-flex items-center gap-1 text-emerald-400 text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-rose-400 text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-[11px]">
                            {{ $staff->created_at ? $staff->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $staff->id) }}" class="p-2 rounded-lg bg-brand-card hover:bg-brand-border text-brand-gold transition" title="Edit Permissions">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if($staff->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $staff->id) }}" onsubmit="return confirm('Are you certain you wish to revoke and delete this staff account?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-brand-card hover:bg-rose-950/40 text-brand-muted hover:text-rose-400 transition" title="Revoke Staff Member">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-brand-muted">
                            <i class="fa-solid fa-users-slash text-2xl text-brand-border mb-2 block"></i>
                            No staff accounts match your current query.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($staffUsers->hasPages())
        <div class="p-4 border-t border-brand-border/40">
            {{ $staffUsers->links() }}
        </div>
    @endif
</div>
@endsection
