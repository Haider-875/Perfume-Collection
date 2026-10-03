@extends('admin.layouts.admin')

@section('title', 'Craft New Fragrance')
@section('page_title', 'Craft New Fragrance Formulation')
@section('page_subtitle', 'Define composition, olfactory notes pyramid, pricing tiers, and presentation assets')

@section('header_actions')
<a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Vault</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Primary Details & Notes -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Information Card -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-gem text-brand-gold text-xs"></i>
                    <span>Fragrance Identity & Story</span>
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Fragrance Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Oud Extrait"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text placeholder-brand-muted/50 focus:outline-none focus:border-brand-gold">
                    @error('name') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Olfactory Tagline / Poetic Hook</label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. An opulent collision of smoked Cambodian agarwood and amber"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text placeholder-brand-muted/50 focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Full Description & Composition Narrative *</label>
                    <textarea name="description" rows="5" required placeholder="Describe the soul of the fragrance, origin of ingredients, and dry-down character..."
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text placeholder-brand-muted/50 focus:outline-none focus:border-brand-gold">{{ old('description') }}</textarea>
                    @error('description') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Olfactory Notes Pyramid -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-layer-group text-brand-gold text-xs"></i>
                    <span>Olfactory Notes Pyramid</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-gold mb-1 font-medium">Top Notes</label>
                        <textarea name="top_notes" rows="2" placeholder="e.g. Bergamot, Pink Pepper, Saffron"
                                  class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('top_notes') }}</textarea>
                        <span class="text-[10px] text-brand-muted">Initial 15-minute impression</span>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-goldLight mb-1 font-medium">Heart / Middle Notes</label>
                        <textarea name="heart_notes" rows="2" placeholder="e.g. Taif Rose, Cardamom, Birch"
                                  class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('heart_notes') }}</textarea>
                        <span class="text-[10px] text-brand-muted">The core olfactory bouquet</span>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-goldDark mb-1 font-medium">Base Notes</label>
                        <textarea name="base_notes" rows="2" placeholder="e.g. Cambodian Oud, Amber, Leather"
                                  class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('base_notes') }}</textarea>
                        <span class="text-[10px] text-brand-muted">Deep lingering foundation</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Longevity Rating</label>
                        <input type="text" name="longevity" value="{{ old('longevity', '10-12+ Hours') }}" placeholder="e.g. 10-12+ Hours"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Sillage / Projection</label>
                        <input type="text" name="sillage" value="{{ old('sillage', 'Enormous / Heavy') }}" placeholder="e.g. Enormous / Heavy"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Scent Family</label>
                        <input type="text" name="scent_family" value="{{ old('scent_family', 'Oriental Woody') }}" placeholder="e.g. Oriental Floral"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>
            </div>

            <!-- Size Variants & Pricing Tiers -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4" x-data="variantManager()">
                <div class="flex items-center justify-between border-b border-brand-border/40 pb-3">
                    <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2">
                        <i class="fa-solid fa-wine-bottle text-brand-gold text-xs"></i>
                        <span>Bottle Sizes & Variant Inventory</span>
                    </h3>
                    <button type="button" @click="addVariant()" class="px-3 py-1 rounded bg-brand-card hover:bg-brand-border text-brand-gold text-xs border border-brand-border/60">
                        + Add Size Variant
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(v, index) in variants" :key="index">
                        <div class="p-3 bg-brand-card/40 border border-brand-border/40 rounded-lg grid grid-cols-2 sm:grid-cols-5 gap-3 items-end">
                            <div>
                                <label class="block text-[10px] uppercase text-brand-muted mb-1">Size / Volume</label>
                                <input type="text" name="variant_size[]" x-model="v.size" required placeholder="50ml / 100ml"
                                       class="w-full bg-brand-black/80 border border-brand-border/60 rounded px-2.5 py-1.5 text-xs text-brand-text">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase text-brand-muted mb-1">Variant SKU</label>
                                <input type="text" name="variant_sku[]" x-model="v.sku" required placeholder="RO-50ML"
                                       class="w-full bg-brand-black/80 border border-brand-border/60 rounded px-2.5 py-1.5 text-xs text-brand-text uppercase">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase text-brand-muted mb-1">Price (PKR)</label>
                                <input type="number" name="variant_price[]" x-model="v.price" required min="0" placeholder="12500"
                                       class="w-full bg-brand-black/80 border border-brand-border/60 rounded px-2.5 py-1.5 text-xs text-brand-text">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase text-brand-muted mb-1">Stock Units</label>
                                <input type="number" name="variant_stock[]" x-model="v.stock" required min="0" placeholder="25"
                                       class="w-full bg-brand-black/80 border border-brand-border/60 rounded px-2.5 py-1.5 text-xs text-brand-text">
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="removeVariant(index)" x-show="variants.length > 1" class="w-8 h-8 rounded bg-rose-950/40 text-rose-400 hover:bg-rose-900/60 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- SEO Metadata -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-globe text-brand-gold text-xs"></i>
                    <span>SEO Meta Parameters</span>
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Custom SEO title for Google ranking"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" placeholder="Luxury meta snippet for social sharing & search engines..."
                                  class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings, Images & Categorization -->
        <div class="space-y-6">

            <!-- Publishing & Status -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Status & Flags
                </h3>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text font-medium">Active in Store Vault</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">Featured in Maison Spotlight</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">Best Seller Badge</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">New Arrival Badge</span>
                    </label>
                </div>
            </div>

            <!-- Pricing & Core Inventory -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Core Pricing (PKR)
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Standard Base Price (PKR) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="12500"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    @error('price') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Compare-at Price (PKR)</label>
                    <input type="number" name="compare_at_price" value="{{ old('compare_at_price') }}" min="0" placeholder="15000"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Master SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="PC-ROYAL-OUD"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text uppercase focus:outline-none focus:border-brand-gold">
                    @error('sku') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Total Vault Stock Units *</label>
                    <input type="number" name="stock" value="{{ old('stock', 50) }}" required min="0" placeholder="50"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>

            <!-- Classification & Category -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Collection & Class
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Collection Category *</label>
                    <select name="category_id" required class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Gender / Demeanor</label>
                    <select name="gender" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="Unisex" {{ old('gender') === 'Unisex' ? 'selected' : '' }}>Unisex / Sovereign</option>
                        <option value="Men" {{ old('gender') === 'Men' ? 'selected' : '' }}>Masculine / Pour Homme</option>
                        <option value="Women" {{ old('gender') === 'Women' ? 'selected' : '' }}>Feminine / Pour Femme</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Concentration</label>
                    <select name="concentration" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="Extrait de Parfum">Extrait de Parfum (35% Oil)</option>
                        <option value="Eau de Parfum">Eau de Parfum (20% Oil)</option>
                        <option value="Attar / Concentrated Perfume Oil">Pure Attar Oil</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Tags (Comma Separated)</label>
                    <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Oud, Amber, Winter, Evening, Exclusive"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>

            <!-- Imagery Upload -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Presentation Assets
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-2">Bottle & Box Photography (Multiple Images)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                           class="w-full text-xs text-brand-muted file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-brand-black hover:file:bg-brand-goldLight cursor-pointer">
                    <span class="text-[10px] text-brand-muted mt-1 block">Supports PNG, JPG, WEBP, SVG (Max 2MB per asset)</span>
                </div>
            </div>

            <!-- Submit Button Card -->
            <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl space-y-3">
                <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-crown"></i>
                    <span>Forge Fragrance into Vault</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function variantManager() {
        return {
            variants: [
                { size: '50ml', sku: '{{ old('sku', 'PC-FRAG-50') }}', price: '{{ old('price', '9500') }}', stock: '25' },
                { size: '100ml', sku: '{{ old('sku', 'PC-FRAG-100') }}', price: '{{ old('price', '15500') }}', stock: '25' },
            ],
            addVariant() {
                this.variants.push({ size: '', sku: '', price: '', stock: '20' });
            },
            removeVariant(index) {
                this.variants.splice(index, 1);
            }
        }
    }
</script>
@endpush
