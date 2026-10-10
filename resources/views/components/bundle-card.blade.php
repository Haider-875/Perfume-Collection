@props(['bundle'])

<div class="bundle-card position-relative bg-white border border-subtle luxury-hover-card rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-3 p-sm-4 h-100" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
    
    <!-- Top Savings Badge -->
    <div class="position-absolute top-0 start-0 m-3 z-2">
        <span class="badge-savings-luxury shadow-sm" style="background-color: #541B29; color: #FFFFFF; border: none;">
            {{ $bundle->badge_text ?? 'SAVE ' . $bundle->formatted_savings }}
        </span>
    </div>

    <!-- Image Preview Pedestal (Clean light surface) -->
    <div class="bundle-image-pedestal position-relative w-100 aspect-1x1 rounded-3 overflow-hidden mb-3 d-flex align-items-center justify-content-center" style="background-color: #FAF7F2; border: 1px solid #EFEAE5; aspect-ratio: 1 / 1;">
        <img src="{{ $bundle->image_url }}" 
             alt="{{ $bundle->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';"
             class="w-100 h-100 object-fit-contain transition-smooth"
             loading="lazy">
    </div>

    <!-- Bundle Title & Tagline -->
    <div class="mb-3">
        <span class="d-block fw-medium mb-1" style="font-size: 9.5px; letter-spacing: 0.16em; text-transform: uppercase; color: #9E7D3B;">
            <i class="fas fa-crown me-1"></i> CURATED COFFRET
        </span>
        <h3 class="font-hero fs-5 fw-normal text-truncate mb-1" style="color: #211D1E !important;">
            {{ $bundle->name }}
        </h3>
        @if($bundle->tagline)
            <p class="text-xs font-sans mb-0 lh-sm" style="color: #6B605B;">
                {{ $bundle->tagline }}
            </p>
        @endif
    </div>

    <!-- Included Flacons Breakdown -->
    @if($bundle->items && $bundle->items->count() > 0)
        <div class="rounded-3 p-2.5 mb-3 flex-grow-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
            <div class="fw-semibold mb-2 d-flex align-items-center gap-1 text-uppercase tracking-wider" style="font-size: 9.5px; color: #541B29;">
                <i class="fas fa-layer-group" style="color: #9E7D3B;"></i> Included in this Set:
            </div>
            <ul class="list-unstyled vstack gap-1.5 mb-0">
                @foreach($bundle->items as $bItem)
                    <li class="text-xs d-flex align-items-center gap-2" style="color: #6B605B;">
                        <i class="fas fa-check" style="font-size: 9px; color: #541B29;"></i>
                        <span class="text-truncate"><strong style="color: #211D1E;">{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong> <span style="font-size: 9.5px; color: #786C67;">({{ $bItem->custom_size_label ?? '100ml Extrait' }})</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pricing and Savings Summary -->
    <div class="d-flex align-items-baseline justify-content-between pt-3 mb-3" style="border-top: 1px solid #E8E0DA;">
        <div>
            <div class="text-uppercase tracking-wider fw-medium" style="font-size: 9.5px; color: #786C67;">Coffret Price</div>
            <div class="font-hero fs-4 fw-bold" style="color: #541B29 !important;">
                {{ $bundle->formatted_bundle_price }}
            </div>
        </div>
        <div class="text-end">
            <div class="text-xs text-decoration-line-through" style="color: #786C67;">
                {{ $bundle->formatted_original_price }}
            </div>
            <div class="fw-semibold" style="font-size: 10px; color: #9E2A2B;">
                Save {{ $bundle->formatted_savings }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div>
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="btn-bundle-bag w-100 d-flex align-items-center justify-content-center gap-2 text-white" 
                style="height: 42px; font-size: 0.78rem; background-color: #541B29 !important; border: none; border-radius: 8px;">
            <i class="fas fa-shopping-bag"></i>
            <span>ADD BUNDLE TO BAG</span>
        </button>
    </div>
</div>
