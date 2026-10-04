@extends('admin.layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('page_title', 'Modify Fragrance: ' . $product->name)
@section('page_subtitle', 'SKU: ' . $product->sku . ' | Collection: ' . ($product->category->name ?? 'Unassigned'))

@section('header_actions')
<div class="d-flex align-items-center gap-2 flex-wrap">
    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="admin-btn-secondary" title="View live on storefront">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        <span>Live Preview</span>
    </a>
    <a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Vault List</span>
    </a>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Fragrance Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Impression Of (Designer / Niche Reference)</label>
                            <input type="text" name="impression_of" value="{{ old('impression_of', $product->impression_of) }}" placeholder="e.g. Tom Ford Tuscan Leather / Creed Aventus">
                            @error('impression_of') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Olfactory Tagline / Poetic Hook</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $product->tagline) }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Full Description & Composition Narrative *</label>
                        <textarea name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
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
                            <textarea name="top_notes" rows="2">{{ old('top_notes', $product->top_notes_summary ?? '') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Initial impression</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Heart / Middle Notes</label>
                            <textarea name="heart_notes" rows="2">{{ old('heart_notes', $product->heart_notes_summary ?? '') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Core bouquet</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Base Notes</label>
                            <textarea name="base_notes" rows="2">{{ old('base_notes', $product->base_notes_summary ?? '') }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Deep dry-down</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Longevity</label>
                            <input type="text" name="longevity" value="{{ old('longevity', $product->longevity) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Sillage</label>
                            <input type="text" name="sillage" value="{{ old('sillage', $product->sillage) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Scent Family</label>
                            <input type="text" name="scent_family" value="{{ old('scent_family', $product->scent_family) }}">
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
                                    <input type="text" name="variant_size[]" x-model="v.size" required placeholder="50ml">
                                </div>
                                <div class="col-6 col-sm-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.7rem;">Variant SKU</label>
                                    <input type="text" name="variant_sku[]" x-model="v.sku" required placeholder="SKU-50ML" style="text-transform: uppercase;">
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
                                    <button type="button" @click="removeVariant(index)" class="btn btn-sm btn-outline-danger admin-action-btn border-0" title="Delete Variant">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Visual Assets & Imagery -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-images text-primary small"></i>
                        <span>Visual Assets & Flacon Imagery</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-4 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Primary Flacon Image</label>
                            @if($product->thumbnail_image)
                                <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light border rounded">
                                    <div class="admin-thumb-box" style="width: 56px; height: 56px;" onclick="window.previewImage('{{ asset($product->thumbnail_image) }}', '{{ $product->name }} Primary')">
                                        <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}" class="admin-thumb-img">
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">Current primary image</div>
                                </div>
                            @endif
                            <input type="file" name="primary_image" accept="image/*" class="form-control form-control-sm">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Leave empty to keep existing flacon shot.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Hover / Box Image</label>
                            @if($product->hover_image)
                                <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light border rounded">
                                    <div class="admin-thumb-box" style="width: 56px; height: 56px;" onclick="window.previewImage('{{ asset($product->hover_image) }}', '{{ $product->name }} Box')">
                                        <img src="{{ asset($product->hover_image) }}" alt="{{ $product->name }}" class="admin-thumb-img">
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">Current hover/packaging image</div>
                                </div>
                            @endif
                            <input type="file" name="hover_image" accept="image/*" class="form-control form-control-sm">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Secondary image displayed on hover.</small>
                        </div>
                    </div>

                    @if($product->images && $product->images->count() > 0)
                        <div class="pt-3 border-top">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Extra Gallery Shots</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->images as $img)
                                    <div class="admin-thumb-box" style="width: 64px; height: 64px;" onclick="window.previewImage('{{ asset($img->image_path) }}', 'Gallery Shot')">
                                        <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}" class="admin-thumb-img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Parameters -->
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
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Meta Description</label>
                        <textarea name="meta_description" rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Settings & Pricing -->
        <div class="col-lg-4">

            <!-- Publishing & Status -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Status & Badges</h6>
                </div>
                <div class="p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="isActiveCheck">
                            Active in Store Vault
                        </label>
                    </div>

                    <div class="form-check mb-2.5">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedCheck" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isFeaturedCheck">
                            Featured in Spotlight
                        </label>
                    </div>

                    <div class="form-check mb-2.5">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="isBestsellerCheck" value="1" {{ old('is_bestseller', $product->is_bestseller ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isBestsellerCheck">
                            Best Seller Badge
                        </label>
                    </div>

                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="is_new_arrival" id="isNewArrivalCheck" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                        <label class="form-check-label small text-dark cursor-pointer" for="isNewArrivalCheck">
                            New Arrival Badge
                        </label>
                    </div>
                </div>
            </div>

            <!-- Pricing & Core SKU -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Core Pricing (PKR)</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Base Price (PKR) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0">
                        @error('price') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Compare-at Price (PKR)</label>
                        <input type="number" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Master SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required style="text-transform: uppercase;">
                        @error('sku') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Bottle Volume (ml) *</label>
                        <input type="number" name="volume_ml" value="{{ old('volume_ml', $product->volume_ml ?? 50) }}" required min="1">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                    </div>
                </div>
            </div>

            <!-- Classification -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Collection & Demeanor</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Collection Category *</label>
                        <select name="category_id" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Gender Demeanor</label>
                        <select name="gender">
                            <option value="Unisex" {{ old('gender', $product->gender) === 'Unisex' ? 'selected' : '' }}>Unisex / Sovereign</option>
                            <option value="Men" {{ old('gender', $product->gender) === 'Men' ? 'selected' : '' }}>Masculine / Pour Homme</option>
                            <option value="Women" {{ old('gender', $product->gender) === 'Women' ? 'selected' : '' }}>Feminine / Pour Femme</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Concentration</label>
                        <select name="concentration">
                            <option value="Extrait de Parfum" {{ old('concentration', $product->concentration) === 'Extrait de Parfum' ? 'selected' : '' }}>Extrait de Parfum</option>
                            <option value="Eau de Parfum" {{ old('concentration', $product->concentration) === 'Eau de Parfum' ? 'selected' : '' }}>Eau de Parfum</option>
                            <option value="Attar / Concentrated Perfume Oil" {{ old('concentration', $product->concentration) === 'Attar / Concentrated Perfume Oil' ? 'selected' : '' }}>Pure Attar Oil</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Tags (Comma Separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="admin-card mb-4 p-3 bg-white">
                <button type="submit" class="admin-btn-primary w-100 py-2.5 fs-6">
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    <span>Save Formulation Changes</span>
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Danger Zone Delete Card -->
<div class="admin-card border-danger-subtle bg-danger-subtle p-3 p-sm-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-4">
    <div>
        <h6 class="fw-bold text-danger mb-1">Retire Fragrance from Vault</h6>
        <small class="text-muted">This will remove the product and its variants from customer view.</small>
    </div>
    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Permanently retire this fragrance from the vault?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-2 fw-semibold">
            <i class="fa-solid fa-trash me-1"></i> Delete Fragrance
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
