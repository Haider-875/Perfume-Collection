@extends('admin.layouts.admin')

@section('title', 'Privilege Coupons')
@section('page_title', 'Privilege Coupons & Vouchers')
@section('page_subtitle', 'Manage promotional codes, VIP percentages, spend thresholds, and seasonal campaigns')

@section('header_actions')
<button @click="openCreateModal = true" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-plus"></i>
    <span>Create Privilege Code</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeCoupon: {} }">
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-brand-muted">
                <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                    <tr>
                        <th class="px-4 py-3">Coupon Code</th>
                        <th class="px-4 py-3">Benefit / Value</th>
                        <th class="px-4 py-3">Min Spend</th>
                        <th class="px-4 py-3">Redemptions</th>
                        <th class="px-4 py-3">Expiration</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/30">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-brand-card/30 transition">
                            <td class="px-4 py-3">
                                <span class="font-mono font-bold text-brand-gold bg-brand-gold/10 px-2 py-0.5 rounded border border-brand-gold/30">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-brand-text">
                                {{ $coupon->type === 'percentage' ? $coupon->value . '% OFF' : 'Rs. ' . number_format($coupon->value, 0) . ' OFF' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $coupon->min_spend > 0 ? 'Rs. ' . number_format($coupon->min_spend, 0) : 'None' }}
                            </td>
                            <td class="px-4 py-3 font-mono">
                                {{ $coupon->used_count }} / {{ $coupon->usage_limit ? $coupon->usage_limit : '&infin;' }}
                            </td>
                            <td class="px-4 py-3 text-[11px]">
                                {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Never' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                    {{ $coupon->is_active ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Expired' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="activeCoupon = {{ json_encode($coupon) }}; editModal = true" 
                                            class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('Revoke this coupon code?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded bg-brand-card hover:bg-rose-950/40 text-brand-muted hover:text-rose-400 flex items-center justify-center transition">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-brand-muted">No coupon codes configured.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-md space-y-4" @click.outside="openCreateModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Forge Privilege Coupon</h3>
            <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Coupon Code *</label>
                    <input type="text" name="code" required placeholder="e.g. MAISONVIP20" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text font-mono uppercase">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Discount Type *</label>
                        <select name="type" required class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed PKR (Rs.)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Discount Value *</label>
                        <input type="number" name="value" required min="1" placeholder="20" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Min Order Spend (PKR)</label>
                        <input type="number" name="min_spend" placeholder="5000" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Max Cap (PKR)</label>
                        <input type="number" name="max_discount" placeholder="4000" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Expiry Date</label>
                        <input type="date" name="expires_at" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Max Redemptions</label>
                        <input type="number" name="usage_limit" placeholder="100" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-brand-text">Active</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="px-3 py-1.5 rounded-lg bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg font-semibold">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-md space-y-4" @click.outside="editModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Edit Privilege Coupon</h3>
            <form method="POST" :action="'/admin/coupons/' + activeCoupon.id" class="space-y-3 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Coupon Code *</label>
                    <input type="text" name="code" :value="activeCoupon.code" required class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text font-mono uppercase">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Discount Type *</label>
                        <select name="type" :value="activeCoupon.type" required class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed PKR (Rs.)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Discount Value *</label>
                        <input type="number" name="value" :value="activeCoupon.value" required min="1" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Min Order Spend (PKR)</label>
                        <input type="number" name="min_spend" :value="activeCoupon.min_spend" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Max Redemptions</label>
                        <input type="number" name="usage_limit" :value="activeCoupon.usage_limit" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="activeCoupon.is_active" class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-brand-text">Active</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="editModal = false" class="px-3 py-1.5 rounded-lg bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg font-semibold">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
