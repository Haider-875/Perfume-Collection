@props(['bundle'])

<div class="bundle-card position-relative bg-white border border-subtle luxury-hover-card rounded-3 rounded-md-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-2 p-sm-3 h-100" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
    
    <!-- Bundle Image Pedestal (Clean, Spacious 1:1 Presentation on Light Surface) -->
    <a href="{{ route('bundles.index') }}" 
       class="product-card-media position-relative w-100 aspect-1x1 rounded-3 overflow-hidden d-flex align-items-center justify-content-center mb-2 mb-md-3 text-decoration-none"
       style="aspect-ratio: 1 / 1; background-color: #FAF7F2; border: 1px solid #EFEAE5;"
       aria-label="{{ $bundle->name }}">
        
        <!-- Badges Row (Anchored strictly INSIDE Image Pedestal so badges never go outside the card) -->
        @php
            $bundleDiscountPct = ($bundle->original_price > $bundle->bundle_price && $bundle->original_price > 0)
                ? round((($bundle->original_price - $bundle->bundle_price) / $bundle->original_price) * 100)
                : 0;
            $primaryBadge = ($bundle->badge_text && !str_starts_with(strtoupper(trim($bundle->badge_text)), 'SAVE')) 
                ? $bundle->badge_text 
                : 'EXCLUSIVE SET';
        @endphp
        <div class="position-absolute top-0 start-0 product-card-badges z-2 d-flex flex-column gap-1 pointer-events-none" style="top: 8px; left: 8px; z-index: 3; max-width: calc(100% - 16px);">
            <span class="product-badge badge-featured bg-gradient-wine-badge text-white fw-bold text-uppercase rounded-pill shadow-sm" style="font-size: 9px; letter-spacing: 0.08em; background-color: #541B29 !important; padding: 2.5px 7px; width: fit-content; max-width: 100%; white-space: nowrap;">
                <i class="fas fa-crown me-1" style="font-size: 8px; color: #E8C170;"></i> {{ $primaryBadge }}
            </span>

            @if($bundleDiscountPct > 0)
                <span class="product-badge badge-discount bg-danger text-white fw-bold rounded-pill shadow-sm" style="font-size: 9px; width: fit-content; background-color: #9E2A2B !important; padding: 2.5px 7px;">
                    -{{ $bundleDiscountPct }}%
                </span>
            @elseif($bundle->savings_amount > 0)
                <span class="product-badge badge-discount bg-danger text-white fw-bold rounded-pill shadow-sm" style="font-size: 9px; width: fit-content; background-color: #9E2A2B !important; padding: 2.5px 7px;">
                    SAVE {{ $bundle->formatted_savings }}
                </span>
            @endif
        </div>

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
        <h3 class="product-card-title font-serif fw-medium mb-1" title="{{ $bundle->name }}">
            <a href="{{ route('bundles.index') }}" class="text-decoration-none" style="color: #211D1E !important;">{{ $bundle->name }}</a>
        </h3>

        <!-- Tagline / Subtitle -->
        @if($bundle->tagline)
            <p class="font-sans mb-1.5 lh-sm text-truncate-2" style="color: #6B605B; font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $bundle->tagline }}
            </p>
        @endif

        <!-- Dual Pricing / Range (Clean Luxury Presentation: Compare at + Bundle Price) -->
        <div class="product-card-pricing mt-auto pt-2 mb-1 d-flex align-items-baseline justify-content-center gap-1.5 flex-nowrap">
            @if($bundle->original_price > $bundle->bundle_price)
                <span class="product-price-compare text-decoration-line-through text-nowrap">
                    {{ $bundle->formatted_original_price }}
                </span>
            @endif
            <span class="product-price-main fw-bold text-nowrap">
                {{ $bundle->formatted_bundle_price }}
            </span>
            @if($bundle->savings_amount > 0)
                <span class="product-price-volume text-nowrap" style="color: #2D6A4F !important; font-weight: 600;">
                    (Save {{ $bundle->formatted_savings }})
                </span>
            @endif
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Add to Cart Button (Matching Product Card) -->
    <div class="product-card-action mt-2 mt-md-3 pt-0 pt-md-2" style="border-top: 1px solid #E8E0DA;">
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="w-100 btn-gold btn-cart-gradient py-2 py-sm-2.5 px-2 px-sm-3 tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-1.5 gap-sm-2 text-white"
                style="min-height: 40px; background-color: #541B29 !important; border-radius: 8px; border: none; touch-action: manipulation;"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-white btn-cart-icon flex-shrink-0" style="font-size: 11px;" aria-hidden="true"></i>
            <span class="text-white text-nowrap" style="font-size: 11.5px; font-family: 'Wasted Vindey', 'Cormorant Garamond', Georgia, serif !important;">Add to Cart</span>
            <i class="fas fa-arrow-right-long btn-arrow text-white d-none d-md-inline-block" style="font-size: 11px;"></i>
        </button>
    </div>
</div>
