@extends('admin.layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('page_title', 'Modify Fragrance: ' . $product->name)
@section('page_subtitle', 'SKU: ' . $product->sku . ' | Collection: ' . ($product->category->name ?? 'Unassigned'))

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-eye"></i>
        <span>Live Preview</span>
    </a>
    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Vault List</span>
    </a>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Primary Details & Notes -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Information Card -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-gem text-brand-gold text-xs"></i>
                    <span>Fragrance Identity & Story</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Fragrance Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        @error('name') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-gold mb-1 font-medium">Impression Of (Designer / Niche Reference)</label>
                        <input type="text" name="impression_of" value="{{ old('impression_of', $product->impression_of) }}" placeholder="e.g. Tom Ford Tuscan Leather / Creed Aventus"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        @error('impression_of') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Olfactory Tagline / Poetic Hook</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $product->tagline) }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Full Description & Composition Narrative *</label>
                    <textarea name="description" rows="5" required
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('description', $product->description) }}</textarea>
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
                        <textarea name="top_notes" rows="2" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('top_notes', $product->top_notes_summary ?? '') }}</textarea>
                        <span class="text-[10px] text-brand-muted">Initial impression</span>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-goldLight mb-1 font-medium">Heart / Middle Notes</label>
                        <textarea name="heart_notes" rows="2" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('heart_notes', $product->heart_notes_summary ?? '') }}</textarea>
                        <span class="text-[10px] text-brand-muted">Core bouquet</span>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-goldDark mb-1 font-medium">Base Notes</label>
                        <textarea name="base_notes" rows="2" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('base_notes', $product->base_notes_summary ?? '') }}</textarea>
                        <span class="text-[10px] text-brand-muted">Deep dry-down</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Longevity</label>
                        <input type="text" name="longevity" value="{{ old('longevity', $product->longevity) }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Sillage</label>
                        <input type="text" name="sillage" value="{{ old('sillage', $product->sillage) }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Scent Family</label>
                        <input type="text" name="scent_family" value="{{ old('scent_family', $product->scent_family) }}"
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
                                <input type="text" name="variant_size[]" x-model="v.size" required placeholder="50ml"
                                       class="w-full bg-brand-black/80 border border-brand-border/60 rounded px-2.5 py-1.5 text-xs text-brand-text">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase text-brand-muted mb-1">Variant SKU</label>
                                <input type="text" name="variant_sku[]" x-model="v.sku" required placeholder="SKU-50ML"
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
                                <button type="button" @click="removeVariant(index)" class="w-8 h-8 rounded bg-rose-950/40 text-rose-400 hover:bg-rose-900/60 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Visual Assets & Imagery -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-images text-brand-gold text-xs"></i>
                    <span>Visual Assets & Flacon Imagery</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-brand-black/50 p-3 rounded-lg border border-brand-border/40">
                        <label class="block text-xs uppercase tracking-wider text-brand-gold mb-2 font-medium">Primary Flacon Image</label>
                        @if($product->thumbnail_image)
                            <div class="mb-2 w-24 h-24 bg-brand-black rounded flex items-center justify-center p-2 border border-brand-border/60">
                                <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="primary_image" accept="image/*"
                               class="w-full text-xs text-brand-muted file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-brand-black hover:file:bg-brand-goldLight cursor-pointer">
                        <span class="text-[10px] text-brand-muted mt-1 block">Leave empty to keep existing flacon shot.</span>
                    </div>

                    <div class="bg-brand-black/50 p-3 rounded-lg border border-brand-border/40">
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-2 font-medium">Hover / Box Image</label>
                        @if($product->hover_image)
                            <div class="mb-2 w-24 h-24 bg-brand-black rounded flex items-center justify-center p-2 border border-brand-border/60">
                                <img src="{{ asset($product->hover_image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="hover_image" accept="image/*"
                               class="w-full text-xs text-brand-muted file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-brand-card file:text-brand-text hover:file:bg-brand-border cursor-pointer">
                        <span class="text-[10px] text-brand-muted mt-1 block">Secondary image on hover.</span>
                    </div>
                </div>

                @if($product->images->count() > 0)
                <div class="pt-3 border-t border-brand-border/40">
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-2">Extra Gallery Shots</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($product->images as $img)
                            <div class="relative bg-brand-black rounded-lg p-2 border border-brand-border/50 group">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}" class="w-full h-24 object-contain rounded">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- SEO Parameters -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
                    <i class="fa-solid fa-globe text-brand-gold text-xs"></i>
                    <span>SEO Meta Parameters</span>
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                                  class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings & Pricing -->
        <div class="space-y-6">

            <!-- Publishing & Status -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Status & Badges
                </h3>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text font-medium">Active in Store Vault</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">Featured in Maison Spotlight</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller ?? false) ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">Best Seller Badge</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}
                               class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text">New Arrival Badge</span>
                    </label>
                </div>
            </div>

            <!-- Pricing & SKU -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Core Pricing (PKR)
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Base Price (PKR) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Compare-at Price (PKR)</label>
                    <input type="number" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" min="0"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Master SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text uppercase focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Standard Bottle Volume (ml) *</label>
                    <input type="number" name="volume_ml" value="{{ old('volume_ml', $product->volume_ml ?? 50) }}" required min="1"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Total Vault Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>

            <!-- Classification -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Collection & Demeanor
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Collection Category *</label>
                    <select name="category_id" required class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Gender Demeanor</label>
                    <select name="gender" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="Unisex" {{ old('gender', $product->gender) === 'Unisex' ? 'selected' : '' }}>Unisex / Sovereign</option>
                        <option value="Men" {{ old('gender', $product->gender) === 'Men' ? 'selected' : '' }}>Masculine / Pour Homme</option>
                        <option value="Women" {{ old('gender', $product->gender) === 'Women' ? 'selected' : '' }}>Feminine / Pour Femme</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Concentration</label>
                    <select name="concentration" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                        <option value="Extrait de Parfum" {{ old('concentration', $product->concentration) === 'Extrait de Parfum' ? 'selected' : '' }}>Extrait de Parfum</option>
                        <option value="Eau de Parfum" {{ old('concentration', $product->concentration) === 'Eau de Parfum' ? 'selected' : '' }}>Eau de Parfum</option>
                        <option value="Attar / Concentrated Perfume Oil" {{ old('concentration', $product->concentration) === 'Attar / Concentrated Perfume Oil' ? 'selected' : '' }}>Pure Attar Oil</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl space-y-3">
                <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Formulation Changes</span>
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Danger Zone Delete Form -->
<div class="mt-8 p-6 bg-rose-950/20 border border-rose-900/40 rounded-xl flex items-center justify-between">
    <div>
        <h4 class="text-sm font-serif font-semibold text-rose-300">Retire Fragrance from Vault</h4>
        <p class="text-xs text-brand-muted">This will remove the product and its variants from customer view.</p>
    </div>
    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Permanently retire this fragrance from the vault?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-rose-900/40 hover:bg-rose-900/70 text-rose-300 border border-rose-700/50 rounded-lg text-xs font-medium transition">
            Delete Fragrance
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function variantManager() {
        const initialVariants = @json($product->variants->map(fn($v) => [
            'size' => $v->size_label ?? $v->size ?? '',
            'sku' => $v->sku,
            'price' => $v->price,
            'stock' => $v->stock
        ]));

        return {
            variants: initialVariants.length > 0 ? initialVariants : [
                { size: '50ml', sku: '{{ $product->sku }}-50', price: '{{ $product->price }}', stock: '25' }
            ],
            addVariant() {
                this.variants.push({ size: '', sku: '', price: '', stock: '20' });
            },
            removeVariant(index) {
                if (this.variants.length > 1) {
                    this.variants.splice(index, 1);
                } else {
                    alert('At least one volume variant must exist.');
                }
            }
        }
    }
</script>
@endpush
