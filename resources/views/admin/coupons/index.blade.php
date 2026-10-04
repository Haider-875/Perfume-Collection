@extends('admin.layouts.admin')

@section('title', 'Privilege Coupons')
@section('page_title', 'Privilege Coupons & Vouchers')
@section('page_subtitle', 'Manage promotional codes, VIP percentages, spend thresholds, and seasonal campaigns')

@section('header_actions')
<button type="button" @click="openCreateModal = true" class="admin-btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Create Privilege Code</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeCoupon: {} }">
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Coupon Code</th>
                        <th class="text-end">Benefit / Value</th>
                        <th class="text-end">Min Spend</th>
                        <th class="text-end">Redemptions</th>
                        <th>Expiration</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <span class="font-monospace fw-bold text-primary bg-light px-2.5 py-1 rounded border">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="text-end font-monospace">
                                <span class="fw-bold text-dark fs-6">
                                    {{ $coupon->type === 'percentage' ? $coupon->value . '% OFF' : 'Rs. ' . number_format($coupon->value, 0) . ' OFF' }}
                                </span>
                            </td>
                            <td class="text-end font-monospace">
                                <span class="text-muted">
                                    {{ $coupon->min_spend > 0 ? 'Rs. ' . number_format($coupon->min_spend, 0) : 'None' }}
                                </span>
                            </td>
                            <td class="text-end font-monospace">
                                <span class="fw-semibold text-dark">{{ $coupon->used_count }}</span>
                                <span class="text-muted">/ {{ $coupon->usage_limit ? $coupon->usage_limit : '&infin;' }}</span>
                            </td>
                            <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                                {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Never' }}
                            </td>
                            <td class="text-center">
                                @if($coupon->is_active)
                                    <span class="admin-badge admin-badge-success">Active</span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">Expired</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <button type="button" 
                                            @click="activeCoupon = {{ json_encode($coupon) }}; editModal = true" 
                                            class="admin-action-btn admin-action-edit" title="Edit Privilege Code">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('Revoke this coupon code?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-action-btn admin-action-delete" title="Revoke Code">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="fa-solid fa-ticket fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                    <h6 class="fw-semibold text-dark mb-1">No coupon codes configured</h6>
                                    <p class="small text-muted mb-3">Reward clientele with promotional percentages or vouchers.</p>
                                    <button type="button" @click="openCreateModal = true" class="admin-btn-primary">
                                        <i class="fa-solid fa-plus"></i> Create Privilege Code
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-md space-y-3" @click.outside="openCreateModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Forge Privilege Coupon</h6>
                <button type="button" @click="openCreateModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Coupon Code *</label>
                    <input type="text" name="code" required placeholder="e.g. MAISONVIP20" class="font-monospace text-uppercase">
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Discount Type *</label>
                        <select name="type" required>
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed PKR (Rs.)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Discount Value *</label>
                        <input type="number" name="value" required min="1" placeholder="20">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Min Spend (PKR)</label>
                        <input type="number" name="min_spend" placeholder="5000">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Max Cap (PKR)</label>
                        <input type="number" name="max_discount" placeholder="4000">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Expiry Date</label>
                        <input type="date" name="expires_at">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Max Redemptions</label>
                        <input type="number" name="usage_limit" placeholder="100">
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" checked class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Save Code</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-md space-y-3" @click.outside="editModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Edit Privilege Coupon</h6>
                <button type="button" @click="editModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" :action="'/admin/coupons/' + activeCoupon.id" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Coupon Code *</label>
                    <input type="text" name="code" :value="activeCoupon.code" required class="font-monospace text-uppercase">
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Discount Type *</label>
                        <select name="type" :value="activeCoupon.type" required>
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed PKR (Rs.)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Discount Value *</label>
                        <input type="number" name="value" :value="activeCoupon.value" required min="1">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Min Spend (PKR)</label>
                        <input type="number" name="min_spend" :value="activeCoupon.min_spend">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Max Redemptions</label>
                        <input type="number" name="usage_limit" :value="activeCoupon.usage_limit">
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" :checked="activeCoupon.is_active" class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="editModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Update Code</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
