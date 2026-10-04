@extends('admin.layouts.admin')

@section('title', 'Craft Luxury Bundle')
@section('page_title', 'Craft Luxury Fragrance Bundle')
@section('page_subtitle', 'Combine multiple vault fragrances with automated savings calculations')

@section('header_actions')
<a href="{{ route('admin.bundles.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Bundles</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.bundles.store') }}" enctype="multipart/form-data" x-data="bundleCalculator()">
    @csrf

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-gift text-primary small"></i>
                        <span>Bundle Information</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Bundle Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Oud Trio Collection">
                        @error('name') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Bundle SKU *</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="BUNDLE-TRIO-01" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Badge Text</label>
                            <input type="text" name="badge_text" value="{{ old('badge_text', 'EXCLUSIVE BUNDLE - SAVE 30%') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Tagline / Highlight</label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. Three majestic extraits bundled for the discerning connoisseur">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Description *</label>
                        <textarea name="description" rows="4" required placeholder="Describe the pairing harmony and presentation coffret...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Products Selection Card -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-spray-can-sparkles text-primary small"></i>
                        <span>Select Included Fragrances (Minimum 2)</span>
                    </h6>
                    <span class="admin-badge admin-badge-info" x-text="selectedCount + ' fragrances selected'"></span>
                </div>
                <div class="p-4">
                    <div class="row g-2" style="max-height: 320px; overflow-y: auto;">
                        @foreach($products as $prod)
                            <div class="col-sm-6">
                                <label class="p-2.5 bg-light border rounded d-flex align-items-center gap-2.5 cursor-pointer h-100 mb-0 hover-shadow transition">
                                    <input type="checkbox" name="products[]" value="{{ $prod->id }}" @change="updateSelection()"
                                           class="bundle-product-cb form-check-input mt-0 flex-shrink-0">
                                    <div class="min-w-0">
                                        <div class="small fw-semibold text-dark text-truncate">{{ $prod->name }}</div>
                                        <div class="small text-muted font-monospace" style="font-size: 0.72rem;">Rs. {{ number_format($prod->price, 0) }}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('products') <div class="text-danger small mt-2" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Pricing & Cover -->
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Bundle Pricing & Savings</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Combined Original Price (PKR) *</label>
                        <input type="number" name="original_price" x-model.number="originalPrice" required min="0" placeholder="28000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-primary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Special Bundle Price (PKR) *</label>
                        <input type="number" name="bundle_price" x-model.number="bundlePrice" required min="0" placeholder="19999" class="fw-bold">
                    </div>

                    <div class="p-3 bg-success-subtle border border-success-subtle rounded d-flex align-items-center justify-content-between mb-3">
                        <span class="small fw-semibold text-success">Calculated Patron Savings:</span>
                        <strong class="text-success font-monospace" x-text="'Rs. ' + Math.max(0, originalPrice - bundlePrice).toLocaleString()"></strong>
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" checked>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="isActiveCheck">
                            Publish Bundle on Storefront
                        </label>
                    </div>
                </div>
            </div>

            <!-- Imagery Upload -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-camera text-primary small"></i>
                    <h6 class="fw-bold text-dark mb-0">Presentation Image</h6>
                </div>
                <div class="p-4">
                    <input type="file" name="image" accept="image/*" class="form-control form-control-sm">
                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Upload bundle presentation coffret image.</small>
                </div>
            </div>

            <!-- Action Button -->
            <div class="admin-card mb-4 p-3 bg-white">
                <button type="submit" class="admin-btn-primary w-100 py-2.5 fs-6">
                    <i class="fa-solid fa-crown me-1"></i>
                    <span>Craft Luxury Bundle</span>
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
            originalPrice: {{ old('original_price', 0) }},
            bundlePrice: {{ old('bundle_price', 0) }},
            selectedCount: 0,
            updateSelection() {
                this.selectedCount = document.querySelectorAll('.bundle-product-cb:checked').length;
            }
        }
    }
</script>
@endpush
