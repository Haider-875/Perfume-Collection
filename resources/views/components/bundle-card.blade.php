@props(['bundle'])

<div class="bundle-card position-relative bg-gradient-wine-card border border-gold-30 luxury-hover-card rounded-4 overflow-hidden shadow-lg d-flex flex-column justify-content-between p-3 p-sm-4 h-100">
    
    <!-- Top Savings Badge -->
    <div class="position-absolute top-0 start-0 m-3 z-2">
        <span class="badge-savings-luxury shadow-md">
            {{ $bundle->badge_text ?? 'SAVE ' . $bundle->formatted_savings }}
        </span>
    </div>

    <!-- Image Preview -->
    <div class="bundle-image-pedestal position-relative w-100 aspect-1x1 rounded-3 overflow-hidden mb-3">
        <img src="{{ $bundle->image_url }}" 
             alt="{{ $bundle->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';"
             class="w-100 h-100 object-fit-contain transition-smooth"
             loading="lazy">
    </div>

    <!-- Bundle Title & Tagline -->
    <div class="mb-3">
        <span class="d-block text-gold fw-medium mb-1" style="font-size: 9.5px; letter-spacing: 0.16em; text-transform: uppercase;">
            <i class="fas fa-crown me-1"></i> CURATED COFFRET
        </span>
        <h3 class="font-hero fs-5 fw-normal text-ivory text-truncate mb-1">
            {{ $bundle->name }}
        </h3>
        @if($bundle->tagline)
            <p class="text-xs text-muted-luxury font-sans mb-0 lh-sm">
                {{ $bundle->tagline }}
            </p>
        @endif
    </div>

    <!-- Included Flacons Breakdown -->
    @if($bundle->items && $bundle->items->count() > 0)
        <div class="bg-wine-dark border border-gold-20 rounded-3 p-2.5 mb-3 flex-grow-1">
            <div class="text-gold fw-semibold mb-2 d-flex align-items-center gap-1 text-uppercase tracking-wider" style="font-size: 9.5px;">
                <i class="fas fa-layer-group text-gold"></i> Included in this Set:
            </div>
            <ul class="list-unstyled vstack gap-1.5 mb-0">
                @foreach($bundle->items as $bItem)
                    <li class="text-xs text-sub d-flex align-items-center gap-2">
                        <i class="fas fa-check text-gold" style="font-size: 9px;"></i>
                        <span class="text-truncate"><strong class="text-ivory">{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong> <span class="text-gold" style="font-size: 9.5px;">({{ $bItem->custom_size_label ?? '100ml Extrait' }})</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pricing and Savings Summary -->
    <div class="d-flex align-items-baseline justify-content-between pt-3 border-top border-gold-20 mb-3">
        <div>
            <div class="text-muted-luxury text-uppercase tracking-wider fw-medium" style="font-size: 9.5px;">Coffret Price</div>
            <div class="font-hero fs-4 fw-normal text-gold-bright gold-gradient-text">
                {{ $bundle->formatted_bundle_price }}
            </div>
        </div>
        <div class="text-end">
            <div class="text-xs text-muted-luxury text-decoration-line-through">
                {{ $bundle->formatted_original_price }}
            </div>
            <div class="text-gold-soft fw-semibold" style="font-size: 10px;">
                Save {{ $bundle->formatted_savings }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div>
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="btn-bundle-bag" style="height: 42px; font-size: 0.78rem;">
            <i class="fas fa-shopping-bag"></i>
            <span>ADD BUNDLE TO BAG</span>
        </button>
    </div>
</div>
