@extends('admin.layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('page_title', 'Modify Fragrance: ' . $product->name)
@section('page_subtitle', 'SKU: ' . $product->sku . ' | Collection: ' . ($product->category->name ?? 'Unassigned'))

@section('header_actions')
<a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="admin-btn-secondary" title="View live on storefront">
    <i class="fa-solid fa-arrow-up-right-from-square"></i>
    <span>Live Preview</span>
</a>
<a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Vault List</span>
</a>
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
                    <span class="badge bg-light text-muted border font-monospace" style="font-size: 0.7rem;">Safe Disk Cleanup Active</span>
                </div>
                <div class="p-4">
                    <div class="row g-4 mb-3">
                        <div class="col-md-6" id="primary-image-container">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Primary Flacon Image</label>
                            @if($product->thumbnail_image)
                                <div class="d-flex align-items-center justify-content-between mb-2 p-2 bg-light border rounded" id="primary-image-preview">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="admin-thumb-box flex-shrink-0" style="width: 56px; height: 56px; cursor: pointer;" onclick="window.previewImage('{{ asset($product->thumbnail_image) }}', '{{ addslashes($product->name) }} Primary')">
                                            <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}" class="admin-thumb-img">
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="small fw-semibold text-dark text-truncate" style="font-size: 0.78rem;">Current Primary Shot</div>
                                            <div class="text-muted text-truncate" style="font-size: 0.7rem;">{{ basename($product->thumbnail_image) }}</div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2.5 py-1 d-inline-flex align-items-center gap-1.5 flex-shrink-0" style="font-size: 0.75rem;" onclick="removeSpecialImage('primary')">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>
                            @else
                                <div class="mb-2 p-2 bg-light border rounded text-muted small d-flex align-items-center gap-2" style="font-size: 0.75rem;" id="primary-image-empty">
                                    <i class="fa-solid fa-image text-muted"></i>
                                    <span>No primary image set (default placeholder used).</span>
                                </div>
                            @endif
                            <input type="file" name="primary_image" accept="image/*" class="form-control form-control-sm">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Select a new file to set or replace primary flacon shot.</small>
                        </div>

                        <div class="col-md-6" id="hover-image-container">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">Hover / Box Image</label>
                            @if($product->hover_image)
                                <div class="d-flex align-items-center justify-content-between mb-2 p-2 bg-light border rounded" id="hover-image-preview">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="admin-thumb-box flex-shrink-0" style="width: 56px; height: 56px; cursor: pointer;" onclick="window.previewImage('{{ asset($product->hover_image) }}', '{{ addslashes($product->name) }} Box')">
                                            <img src="{{ asset($product->hover_image) }}" alt="{{ $product->name }}" class="admin-thumb-img">
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="small fw-semibold text-dark text-truncate" style="font-size: 0.78rem;">Current Box / Hover Shot</div>
                                            <div class="text-muted text-truncate" style="font-size: 0.7rem;">{{ basename($product->hover_image) }}</div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2.5 py-1 d-inline-flex align-items-center gap-1.5 flex-shrink-0" style="font-size: 0.75rem;" onclick="removeSpecialImage('hover')">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>
                            @else
                                <div class="mb-2 p-2 bg-light border rounded text-muted small d-flex align-items-center gap-2" style="font-size: 0.75rem;" id="hover-image-empty">
                                    <i class="fa-solid fa-image text-muted"></i>
                                    <span>No secondary hover image set.</span>
                                </div>
                            @endif
                            <input type="file" name="hover_image" accept="image/*" class="form-control form-control-sm">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Secondary packaging or box shot displayed on hover.</small>
                        </div>
                    </div>

                    <div class="pt-3 border-top mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-0" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                Extra Gallery Shots (<span id="gallery-count">{{ $product->images ? $product->images->count() : 0 }}</span>)
                            </label>
                            <span class="text-muted" style="font-size: 0.72rem;">Click the red trash button to remove any gallery image</span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-3" id="gallery-container">
                            @if($product->images && $product->images->count() > 0)
                                @foreach($product->images as $img)
                                    <div class="position-relative gallery-item-card border rounded p-1 bg-white shadow-sm" id="gallery-item-{{ $img->id }}" style="width: 80px;">
                                        <div class="admin-thumb-box w-100" style="height: 70px; cursor: pointer;" onclick="window.previewImage('{{ asset($img->image_path) }}', 'Gallery Shot')">
                                            <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}" class="admin-thumb-img rounded">
                                        </div>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center shadow"
                                                style="width: 22px; height: 22px; font-size: 10px;"
                                                title="Remove this image"
                                                onclick="removeGalleryImage({{ $img->id }})">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="p-3 bg-light rounded border">
                            <label class="form-label small fw-semibold text-dark text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                <i class="fa-solid fa-cloud-arrow-up text-primary me-1"></i> Add More Gallery Images
                            </label>
                            <input type="file" name="gallery_images[]" multiple accept="image/*" class="form-control form-control-sm">
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Select one or multiple images to add to the fragrance gallery upon saving.</small>
                        </div>
                    </div>
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
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-0" style="font-size: 0.72rem; letter-spacing: 0.05em;">Collection Category *</label>
                            <a href="{{ route('admin.categories.index') }}" target="_blank" class="small text-primary text-decoration-none fw-semibold" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-plus-circle me-1"></i>Add New Category
                            </a>
                        </div>
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
                            <option value="Artisanal Scented Candle (Soy Wax)" {{ old('concentration', $product->concentration) === 'Artisanal Scented Candle (Soy Wax)' ? 'selected' : '' }}>Artisanal Scented Candle (Soy Wax)</option>
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

@php
    $initialVariants = $product->variants->map(function($v) {
        return [
            'size' => $v->size_label ?? $v->size ?? '',
            'sku' => $v->sku,
            'price' => $v->price,
            'stock' => $v->stock,
        ];
    })->values()->toArray();
@endphp

@push('scripts')
<script>
    function variantManager() {
        const initialVariants = @json($initialVariants);

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

    function removeSpecialImage(type) {
        const label = type === 'primary' ? 'Primary Flacon Image' : 'Hover / Box Image';
        if (!confirm(`Are you sure you want to remove the ${label}? If this file is not used by any other fragrance, it will also be safely removed from disk.`)) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        const url = '{{ route('admin.products.remove-image', $product->id) }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ type: type })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const previewEl = document.getElementById(`${type}-image-preview`);
                if (previewEl) {
                    previewEl.style.transition = 'all 0.3s ease';
                    previewEl.style.opacity = '0';
                    previewEl.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        previewEl.remove();
                        const container = document.getElementById(`${type}-image-container`);
                        const emptyState = document.createElement('div');
                        emptyState.id = `${type}-image-empty`;
                        emptyState.className = 'mb-2 p-2 bg-light border rounded text-muted small d-flex align-items-center gap-2';
                        emptyState.style.fontSize = '0.75rem';
                        emptyState.innerHTML = `<i class="fa-solid fa-circle-check text-success"></i> <span class="text-success">${data.message}</span>`;
                        container.insertBefore(emptyState, container.querySelector('input[type="file"]'));
                    }, 300);
                }
            } else {
                alert(data.message || 'Error removing image.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Network error while removing image. Please try again.');
        });
    }

    function removeGalleryImage(imageId) {
        if (!confirm('Are you sure you want to remove this gallery image? If the image is not used elsewhere, it will be safely deleted from disk.')) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        const baseUrl = '{{ url('admin/products/' . $product->id . '/gallery-images') }}';
        const url = `${baseUrl}/${imageId}`;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`gallery-item-${imageId}`);
                if (item) {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.remove();
                        const countEl = document.getElementById('gallery-count');
                        if (countEl) {
                            const current = parseInt(countEl.innerText) || 0;
                            countEl.innerText = Math.max(0, current - 1);
                        }
                    }, 300);
                }
            } else {
                alert(data.message || 'Error removing gallery image.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Network error while removing gallery image. Please try again.');
        });
    }
</script>
@endpush
