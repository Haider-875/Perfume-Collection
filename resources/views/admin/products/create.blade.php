@extends('admin.layouts.admin')

@section('title', 'Craft New Fragrance')
@section('page_title', 'Craft New Fragrance Formulation')
@section('page_subtitle', 'Define composition, olfactory notes pyramid, pricing tiers, and presentation assets')

@section('header_actions')
<a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Vault</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Left Column: Primary Details & Formulation Notes -->
        <div class="col-lg-8">
            
            <!-- Basic Information Card -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-gem text-primary small"></i>
                        <span>Fragrance Identity & Story</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Fragrance Formulation Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Santal Desire">
                            @error('name') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Impression of (Designer / Niche Perfume) *</label>
                            <input type="text" name="impression_of" value="{{ old('impression_of') }}" placeholder="e.g. Santal 33 by Le Labo">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Used for prominent impression subtitle</small>
                            @error('impression_of') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Olfactory Tagline / Poetic Hook</label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. An opulent collision of smoked agarwood and amber">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Full Description & Composition Narrative *</label>
                        <textarea name="description" rows="5" required placeholder="Describe the soul of the fragrance, origin of ingredients, and dry-down character...">{{ old('description') }}</textarea>
                        @error('description') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Olfactory Notes Pyramid -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-layer-group text-primary small"></i>
                        <span>Olfactory Notes Pyramid</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Top Notes</label>
                            <textarea name="top_notes" rows="2" placeholder="e.g. Bergamot, Pink Pepper, Saffron">{{ old('top_notes') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Initial 15-minute impression</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Heart / Middle Notes</label>
                            <textarea name="heart_notes" rows="2" placeholder="e.g. Taif Rose, Cardamom, Birch">{{ old('heart_notes') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">The core olfactory bouquet</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Base Notes</label>
                            <textarea name="base_notes" rows="2" placeholder="e.g. Cambodian Oud, Amber, Leather">{{ old('base_notes') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Deep lingering foundation</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Longevity Rating</label>
                            <input type="text" name="longevity" value="{{ old('longevity', '10-12+ Hours') }}" placeholder="e.g. 10-12+ Hours">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Sillage / Projection</label>
                            <input type="text" name="sillage" value="{{ old('sillage', 'Enormous / Heavy') }}" placeholder="e.g. Enormous / Heavy">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Scent Family</label>
                            <input type="text" name="scent_family" value="{{ old('scent_family', 'Oriental Woody') }}" placeholder="e.g. Oriental Floral">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Size Variants & Pricing Tiers -->
            <div class="admin-card mb-4" x-data="variantManager()">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-wine-bottle text-primary small"></i>
                        <span>Bottle Sizes & Variant Inventory</span>
                    </h6>
                    <button type="button" @click="addVariant()" class="admin-btn-secondary" style="height: 32px; font-size: 0.75rem; padding: 0 0.75rem;">
                        <i class="fa-solid fa-plus small"></i>
                        <span>Add Size Variant</span>
                    </button>
                </div>
                <div class="p-4">
                    <template x-for="(v, index) in variants" :key="index">
                        <div class="p-3 bg-light border rounded mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-6 col-sm-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.7rem;">Size / Volume</label>
                                    <input type="text" name="variant_size[]" x-model="v.size" required placeholder="50ml / 100ml">
                                </div>
                                <div class="col-6 col-sm-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.7rem;">Variant SKU</label>
                                    <input type="text" name="variant_sku[]" x-model="v.sku" required placeholder="RO-50ML" style="text-transform: uppercase;">
                                </div>
                                <div class="col-6 col-sm-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.7rem;">Price (PKR)</label>
                                    <input type="number" name="variant_price[]" x-model="v.price" required min="0" placeholder="12500">
                                </div>
                                <div class="col-4 col-sm-2">
                                    <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.7rem;">Stock</label>
                                    <input type="number" name="variant_stock[]" x-model="v.stock" required min="0" placeholder="25">
                                </div>
                                <div class="col-2 col-sm-1 d-flex justify-content-end">
                                    <button type="button" @click="removeVariant(index)" x-show="variants.length > 1" class="btn btn-sm btn-outline-danger admin-action-btn border-0" title="Delete Variant">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- SEO Metadata -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-globe text-primary small"></i>
                        <span>SEO Meta Parameters</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Custom SEO title for search engines">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Meta Description</label>
                        <textarea name="meta_description" rows="2" placeholder="Luxury meta snippet for social sharing & search engines...">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Settings, Images & Categorization -->
        <div class="col-lg-4">

            <!-- Publishing & Status -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Status & Flags</h6>
                </div>
                <div class="p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="isActiveCheck">
                            Active in Store Vault
                        </label>
                    </div>

                    <div class="form-check mb-2.5">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedCheck" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isFeaturedCheck">
                            Featured in Spotlight
                        </label>
                    </div>

                    <div class="form-check mb-2.5">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="isBestsellerCheck" value="1" {{ old('is_bestseller', old('is_best_seller')) ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isBestsellerCheck">
                            Best Seller Badge
                        </label>
                    </div>

                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="is_new_arrival" id="isNewArrivalCheck" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isNewArrivalCheck">
                            New Arrival Badge
                        </label>
                    </div>
                </div>
            </div>

            <!-- Pricing & Core Inventory -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Core Pricing (PKR)</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Standard Base Price (PKR) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="12500">
                        @error('price') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Compare-at Price (PKR)</label>
                        <input type="number" name="compare_at_price" value="{{ old('compare_at_price') }}" min="0" placeholder="15000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Master SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="PC-ROYAL-OUD" style="text-transform: uppercase;">
                        @error('sku') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Bottle Volume (ml) *</label>
                        <input type="number" name="volume_ml" value="{{ old('volume_ml', 50) }}" required min="1">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Stock Units *</label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" required min="0" placeholder="50">
                    </div>
                </div>
            </div>

            <!-- Classification & Category -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Collection & Class</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Collection Category *</label>
                        <select name="category_id" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Gender Demeanor</label>
                        <select name="gender">
                            <option value="Unisex" {{ old('gender') === 'Unisex' ? 'selected' : '' }}>Unisex / Sovereign</option>
                            <option value="Men" {{ old('gender') === 'Men' ? 'selected' : '' }}>Masculine / Pour Homme</option>
                            <option value="Women" {{ old('gender') === 'Women' ? 'selected' : '' }}>Feminine / Pour Femme</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Concentration</label>
                        <select name="concentration">
                            <option value="Extrait de Parfum">Extrait de Parfum (35% Oil)</option>
                            <option value="Eau de Parfum">Eau de Parfum (20% Oil)</option>
                            <option value="Attar / Concentrated Perfume Oil">Pure Attar Oil</option>
                            <option value="Artisanal Scented Candle (Soy Wax)">Artisanal Scented Candle (Soy Wax)</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Tags (Comma Separated)</label>
                        <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Oud, Amber, Winter, Evening, Exclusive">
                    </div>
                </div>
            </div>

            <!-- Imagery Upload -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-camera text-primary small"></i>
                    <h6 class="fw-bold text-dark mb-0">Presentation Assets</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Main Flacon Image (Featured)</label>
                        <input type="file" name="primary_image" accept="image/*" class="form-control form-control-sm">
                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Supports PNG, JPG, WEBP, SVG</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Secondary / Box Image</label>
                        <input type="file" name="hover_image" accept="image/*" class="form-control form-control-sm">
                    </div>
                </div>
            </div>

            <!-- Submit Button Card -->
            <div class="admin-card mb-4 p-3 bg-white">
                <button type="submit" class="admin-btn-primary w-100 py-2.5 fs-6">
                    <i class="fa-solid fa-crown me-1"></i>
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
