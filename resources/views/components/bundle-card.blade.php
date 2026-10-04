@props(['bundle'])

<div class="bundle-card position-relative bg-gradient-wine-card border border-gold-30 luxury-hover-card rounded-4 overflow-hidden shadow-lg d-flex flex-column justify-content-between p-3 p-sm-4 h-100">
    
    <!-- Top Savings Badge -->
    <div class="position-absolute top-0 start-0 m-3 z-2">
        <span class="bg-gradient-discount-badge text-white fw-bold px-3 py-1 rounded-pill shadow-sm text-uppercase tracking-wider border border-gold-40" style="font-size: 11px;">
            {{ $bundle->badge_text ?? 'SAVE ' . $bundle->formatted_savings }}
        </span>
    </div>

    <!-- Image Preview -->
    <div class="position-relative w-100 aspect-1x1 rounded-3 overflow-hidden bg-theme-secondary border border-gold-20 d-flex align-items-center justify-center mb-3">
        <img src="{{ $bundle->image_url }}" 
             alt="{{ $bundle->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';"
             class="w-100 h-100 object-fit-cover transition-smooth"
             loading="lazy">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade pointer-events-none"></div>
    </div>

    <!-- Bundle Title & Tagline -->
    <div class="mb-3">
        <h3 class="font-serif fs-5 fw-medium text-ivory text-truncate mb-1">
            {{ $bundle->name }}
        </h3>
        @if($bundle->tagline)
            <p class="text-xs text-muted-luxury font-serif fst-italic mb-0">
                "{{ $bundle->tagline }}"
            </p>
        @endif
    </div>

    <!-- Included Flacons Breakdown -->
    @if($bundle->items && $bundle->items->count() > 0)
        <div class="bg-wine-dark border border-gold-20 rounded-3 p-3 mb-3 flex-grow-1">
            <div class="text-gold fw-bold mb-2 d-flex align-items-center gap-2 text-uppercase tracking-wider" style="font-size: 10px;">
                <i class="fas fa-layer-group text-gold"></i> Included in this Coffret:
            </div>
            <ul class="list-unstyled vstack gap-1 mb-0">
                @foreach($bundle->items as $bItem)
                    <li class="text-xs text-sub d-flex align-items-center gap-2">
                        <i class="fas fa-check text-gold" style="font-size: 10px;"></i>
                        <span><strong class="text-ivory">{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong> <span class="text-light-luxury">({{ $bItem->custom_size_label ?? '100ml Extrait' }})</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pricing and Savings Summary -->
    <div class="d-flex align-items-baseline justify-content-between pt-3 border-top border-gold-20 mb-3">
        <div>
            <div class="text-light-luxury text-uppercase tracking-wider fw-semibold" style="font-size: 10px;">Special Bundle Price</div>
            <div class="font-serif fs-4 fw-bold text-gold-soft">
                {{ $bundle->formatted_bundle_price }}
            </div>
        </div>
        <div class="text-end">
            <div class="text-xs text-light-luxury text-decoration-line-through">
                {{ $bundle->formatted_original_price }}
            </div>
            <div class="text-gold-soft fw-bold" style="font-size: 11px;">
                Save {{ $bundle->formatted_savings }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div>
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="w-100 btn-gold py-2_5 text-xs tracking-wider text-uppercase rounded-3 d-flex align-items-center justify-center gap-2">
            <i class="fas fa-cart-shopping" style="font-size: 11px;"></i>
            <span>ADD BUNDLE TO BAG</span>
        </button>
    </div>
</div>
