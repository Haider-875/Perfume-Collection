@extends('admin.layouts.admin')

@section('title', 'Craft Luxury Bundle')
@section('page_title', 'Craft Luxury Fragrance Bundle')
@section('page_subtitle', 'Combine multiple vault fragrances with automated savings calculations')

@section('header_actions')
<a href="{{ route('admin.bundles.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Bundles</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.bundles.store') }}" enctype="multipart/form-data" class="space-y-6" x-data="bundleCalculator()">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Bundle Information
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Bundle Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Oud Trio Collection"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    @error('name') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Bundle SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="BUNDLE-TRIO-01"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text uppercase focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Badge Text</label>
                        <input type="text" name="badge_text" value="{{ old('badge_text', 'EXCLUSIVE BUNDLE - SAVE 30%') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Tagline / Highlight</label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. Three majestic extraits bundled for the discerning connoisseur"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Description *</label>
                    <textarea name="description" rows="4" required placeholder="Describe the pairing harmony and presentation coffret..."
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Products Selection Card -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3 flex items-center justify-between">
                    <span>Select Included Fragrances (Minimum 2)</span>
                    <span class="text-xs text-brand-gold font-sans font-normal" x-text="selectedCount + ' fragrances selected'"></span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-2">
                    @foreach($products as $prod)
                        <label class="flex items-center gap-3 p-2.5 bg-brand-card/40 border border-brand-border/40 rounded-lg cursor-pointer hover:border-brand-gold/40 transition">
                            <input type="checkbox" name="products[]" value="{{ $prod->id }}" @change="updateSelection()"
                                   class="bundle-product-cb rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                            <div class="min-w-0">
                                <div class="text-xs text-brand-text font-medium truncate">{{ $prod->name }}</div>
                                <div class="text-[10px] text-brand-gold font-serif">Rs. {{ number_format($prod->price, 0) }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('products') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Right Column: Pricing & Cover -->
        <div class="space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Bundle Pricing & Savings
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Combined Original Price (PKR) *</label>
                    <input type="number" name="original_price" x-model.number="originalPrice" required min="0" placeholder="28000"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-gold mb-1 font-semibold">Special Bundle Price (PKR) *</label>
                    <input type="number" name="bundle_price" x-model.number="bundlePrice" required min="0" placeholder="19999"
                           class="w-full bg-brand-black/60 border border-brand-gold/60 rounded-lg px-3 py-2 text-xs text-brand-text font-bold focus:outline-none focus:border-brand-gold">
                </div>

                <div class="p-3 bg-emerald-950/30 border border-emerald-500/30 rounded-lg text-xs flex items-center justify-between">
                    <span class="text-emerald-400">Calculated Patron Savings:</span>
                    <strong class="text-emerald-300 font-serif" x-text="'Rs. ' + Math.max(0, originalPrice - bundlePrice).toLocaleString()"></strong>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text font-medium">Publish Bundle on Storefront</span>
                    </label>
                </div>
            </div>

            <!-- Imagery Upload -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Presentation Image
                </h3>
                <div>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs text-brand-muted file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-brand-black hover:file:bg-brand-goldLight cursor-pointer">
                </div>
            </div>

            <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl">
                <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-gift"></i>
                    <span>Forge Bundle</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function bundleCalculator() {
        return {
            originalPrice: 28000,
            bundlePrice: 19999,
            selectedCount: 0,
            updateSelection() {
                this.selectedCount = document.querySelectorAll('.bundle-product-cb:checked').length;
            }
        }
    }
</script>
@endpush
