@props(['bundle'])

<div class="bundle-card position-relative bg-white border border-subtle luxury-hover-card rounded-3 rounded-md-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-2 p-sm-3 h-100" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
    
    <!-- Badges Row (Top Left Pill Badges matching Product Card) -->
    @php
        $bundleDiscountPct = ($bundle->original_price > $bundle->bundle_price && $bundle->original_price > 0)
            ? round((($bundle->original_price - $bundle->bundle_price) / $bundle->original_price) * 100)
            : 0;
        $primaryBadge = ($bundle->badge_text && !str_starts_with(strtoupper(trim($bundle->badge_text)), 'SAVE')) 
            ? $bundle->badge_text 
            : 'EXCLUSIVE SET';
    @endphp
    <div class="position-absolute top-0 start-0 product-card-badges z-2 d-flex flex-column gap-1 pointer-events-none" style="top: 8px; left: 8px; z-index: 3;">
        <span class="product-badge badge-featured bg-gradient-wine-badge text-white fw-bold text-uppercase rounded-pill shadow-sm" style="font-size: 9px; letter-spacing: 0.1em; background-color: #541B29 !important; padding: 2.5px 7px; width: fit-content;">
            <i class="fas fa-crown me-1" style="font-size: 8px; color: #E8C170;"></i> {{ $primaryBadge }}
        </span>

        @if($bundle->savings_amount > 0 || $bundleDiscountPct > 0)
            <span class="product-badge badge-discount bg-danger text-white fw-bold rounded-pill shadow-sm" style="font-size: 9px; width: fit-content; background-color: #9E2A2B !important; padding: 2.5px 7px;">
                SAVE {{ $bundle->formatted_savings }} @if($bundleDiscountPct > 0)({{ $bundleDiscountPct }}% OFF)@endif
            </span>
        @endif
    </div>

    <!-- Bundle Image Pedestal (Clean, Spacious 1:1 Presentation on Light Surface) -->
    <a href="{{ route('bundles.index') }}" 
       class="product-card-media position-relative w-100 aspect-1x1 rounded-3 overflow-hidden d-flex align-items-center justify-content-center mb-2 mb-md-3 text-decoration-none"
       style="aspect-ratio: 1 / 1; background-color: #FAF7F2; border: 1px solid #EFEAE5;"
       aria-label="{{ $bundle->name }}">
        <img src="{{ $bundle->image_url }}" 
             alt="{{ $bundle->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';"
             class="w-100 h-100 object-fit-contain transition-smooth"
             style="aspect-ratio: 1 / 1; object-fit: contain !important; object-position: center !important;"
             loading="lazy">
    </a>

    <!-- Bundle Metadata & Content (Structured matching Product Card) -->
    <div class="product-card-body d-flex flex-column flex-grow-1 text-center px-1">
        <!-- Impression / Curated Set Tag -->
        <div class="product-card-impression mb-1 text-center">
            <span class="fw-semibold d-block text-uppercase tracking-wider" style="font-size: 10px; letter-spacing: 0.16em; color: #780D24;">
                CURATED COFFRET
            </span>
        </div>

        <!-- Bundle Title (Wasted Vindey Serif Typography) -->
        <h3 class="product-card-title font-serif fs-5 fw-medium mb-1">
            <a href="{{ route('bundles.index') }}" class="text-decoration-none" style="color: #211D1E !important;">{{ $bundle->name }}</a>
        </h3>

        <!-- Tagline / Subtitle -->
        @if($bundle->tagline)
            <p class="font-sans mb-1.5 lh-sm text-truncate-2" style="color: #6B605B; font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $bundle->tagline }}
            </p>
        @endif

        <!-- Included Flacons Breakdown (Responsive, Compact & Elegant) -->
        @if($bundle->items && $bundle->items->count() > 0)
            <div class="bundle-items-box rounded-3 p-2 p-sm-2.5 my-1.5 flex-grow-1 text-start" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                <div class="fw-semibold mb-1.5 d-flex align-items-center justify-content-between text-uppercase tracking-wider" style="font-size: 9.5px; color: #541B29;">
                    <span class="d-flex align-items-center gap-1">
                        <i class="fas fa-layer-group" style="color: #9E7D3B; font-size: 9.5px;"></i> Included in Set:
                    </span>
                    <span class="badge rounded-pill fw-medium" style="font-size: 8.5px; background-color: #EFE8E1; color: #541B29; padding: 2px 6px;">
                        {{ $bundle->items->count() }} Flacons
                    </span>
                </div>
                <ul class="list-unstyled vstack gap-1 mb-0">
                    @foreach($bundle->items as $bItem)
                        <li class="d-flex align-items-center gap-1.5 text-truncate" style="color: #6B605B; font-size: 10.5px;">
                            <i class="fas fa-check flex-shrink-0" style="font-size: 8.5px; color: #780D24;"></i>
                            <span class="text-truncate">
                                <strong style="color: #211D1E;">{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong>
                                <span style="font-size: 9px; color: #786C67;">({{ $bItem->custom_size_label ?? ($bItem->product && $bItem->product->volume_ml ? $bItem->product->volume_ml . 'ml Extrait' : 'Extrait de Parfum') }})</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Dual Pricing / Range matching Product Card -->
        <div class="product-card-pricing my-1 d-flex align-items-baseline justify-content-center gap-1.5 flex-wrap">
            @if($bundle->original_price > $bundle->bundle_price)
                <span class="product-price-min text-decoration-line-through fw-normal text-nowrap" style="color: #786C67; font-size: 11.5px;">
                    {{ $bundle->formatted_original_price }}
                </span>
                <span class="product-price-sep opacity-50 fw-light d-none d-sm-inline" style="color: #786C67 !important;">&bull;</span>
            @endif
            <span class="product-price-main fw-bold font-serif fs-5 text-nowrap" style="color: #541B29 !important;">
                {{ $bundle->formatted_bundle_price }}
            </span>
            @if($bundle->savings_amount > 0)
                <span class="product-price-savings fw-semibold text-nowrap" style="font-size: 10px; color: #9E2A2B;">
                    Save {{ $bundle->formatted_savings }}
                </span>
            @endif
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Add to Cart Button (Matching Product Card) -->
    <div class="product-card-action mt-2 mt-md-3 pt-0 pt-md-2" style="border-top: 1px solid #E8E0DA;">
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="w-100 btn-gold btn-cart-gradient py-2 py-sm-2.5 px-2 px-sm-3 tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-1.5 gap-sm-2 text-white"
                style="min-height: 40px; background-color: #541B29 !important; border-radius: 8px; border: none; font-family: 'Wasted Vindey', 'Cormorant Garamond', Georgia, serif !important;"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-white" style="font-size: 11px;"></i>
            <span class="text-white text-nowrap" style="font-size: 11.5px; font-family: 'Wasted Vindey', 'Cormorant Garamond', Georgia, serif !important;">Add to Cart</span>
            <i class="fas fa-arrow-right-long btn-arrow text-white d-none d-md-inline-block" style="font-size: 11px;"></i>
        </button>
    </div>
</div>
