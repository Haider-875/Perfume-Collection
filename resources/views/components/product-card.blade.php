@props(['product'])

<div class="product-card position-relative bg-white border border-subtle luxury-hover-card rounded-3 rounded-md-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-3 p-md-3.5 h-100" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
    
    <!-- Flacon Image Wrap (Clean, Spacious Presentation on Light Surface) -->
    <a href="{{ route('shop.show', $product->slug) }}" 
       class="product-card-media position-relative w-100 aspect-1x1 rounded-3 overflow-hidden d-flex align-items-center justify-content-center mb-2.5 mb-md-3 text-decoration-none"
       style="aspect-ratio: 1 / 1; background-color: #FAF7F2; border: 1px solid #EFEAE5;"
       aria-label="{{ $product->name }}">
       
        <!-- Badges Row (Anchored strictly inside the image frame) -->
        <div class="position-absolute top-0 start-0 product-card-badges z-2 d-flex flex-column gap-1 pointer-events-none" style="top: 8px; left: 8px; z-index: 3; max-width: calc(100% - 16px);">
            @if($product->is_bestseller)
                <span class="product-badge badge-bestseller bg-gradient-wine-badge text-white fw-bold text-uppercase rounded-pill shadow-sm shimmer-gold" style="font-size: 8.5px; letter-spacing: 0.08em; background-color: #541B29 !important; padding: 2.5px 7px; width: fit-content; max-width: 100%; white-space: nowrap;">
                    ★ BESTSELLER
                </span>
            @elseif($product->is_new_arrival)
                <span class="product-badge badge-new bg-success text-white fw-bold text-uppercase rounded-pill shadow-sm shimmer-gold" style="font-size: 8.5px; letter-spacing: 0.08em; background-color: #2D6A4F !important; padding: 2.5px 7px; width: fit-content; max-width: 100%; white-space: nowrap;">
                    NEW ARRIVAL
                </span>
            @elseif($product->is_featured)
                <span class="product-badge badge-featured bg-gradient-wine-badge text-white fw-bold text-uppercase rounded-pill shadow-sm shimmer-gold" style="font-size: 8.5px; letter-spacing: 0.08em; background-color: #541B29 !important; padding: 2.5px 7px; width: fit-content; max-width: 100%; white-space: nowrap;">
                    EXCLUSIVE
                </span>
            @endif

            @if($product->has_discount)
                <span class="product-badge badge-discount bg-danger text-white fw-bold rounded-pill shadow-sm" style="font-size: 8.5px; width: fit-content; background-color: #9E2A2B !important; padding: 2.5px 7px;">
                    -{{ $product->discount_percentage }}%
                </span>
            @endif
        </div>

        <picture class="w-100 h-100 d-flex align-items-center justify-content-center">
            @if($product->primary_webp_url)
                <source srcset="{{ $product->primary_webp_url }}" type="image/webp">
            @endif
            <img src="{{ $product->primary_image_url }}" 
                 alt="{{ $product->name }}" 
                 width="400" 
                 height="400"
                 decoding="async"
                 onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                 class="w-100 h-100 object-fit-contain transition-smooth" 
                 style="aspect-ratio: 1 / 1; object-fit: contain !important; object-position: center !important;"
                 loading="lazy">
        </picture>
        @if($product->hover_image && $product->hover_image !== $product->thumbnail_image)
            <picture class="position-absolute top-0 start-0 w-100 h-100 opacity-0 transition-smooth product-hover-pic pointer-events-none">
                @if($product->hover_webp_url)
                    <source srcset="{{ $product->hover_webp_url }}" type="image/webp">
                @endif
                <img src="{{ $product->hover_image_url }}" 
                     alt="{{ $product->name }} Presentation" 
                     width="400" 
                     height="400"
                     decoding="async"
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                     class="w-100 h-100 object-fit-contain" 
                     style="aspect-ratio: 1 / 1; object-fit: contain !important; object-position: center !important;"
                     loading="lazy">
            </picture>
        @endif
    </a>

    <!-- Product Metadata & Content -->
    <div class="product-card-body d-flex flex-column flex-grow-1 text-center px-1">
        <!-- Impression / Category Tag (Refined editorial typography) -->
        <div class="product-card-impression mb-1.5 mb-md-2 text-center">
            @if($product->impression_of)
                <span class="fw-medium d-block text-truncate" style="font-size: 11px; color: #6B605B; letter-spacing: 0.05em;" title="Impression of {{ $product->impression_of }}">
                    Impression of <span class="fw-semibold" style="color: #541B29;">{{ $product->impression_of }}</span>
                </span>
            @else
                <span class="fw-medium d-block text-uppercase tracking-wider text-truncate" style="font-size: 10.5px; color: #9E7D3B; letter-spacing: 0.12em;">
                    Signature Luxury Extrait
                </span>
            @endif
        </div>

        <!-- Product Title (Slightly larger, elegant Cormorant Garamond) -->
        <h3 class="product-card-title font-serif fw-semibold mb-2" title="{{ $product->name }}">
            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none" style="color: #211D1E !important;">{{ $product->name }}</a>
        </h3>

        <!-- Pricing: Compare at Price + Our Price Agy Peche with Luxury Gradient, Bottle Size Neche -->
        <div class="product-card-pricing-wrap my-2 my-md-2.5 text-center">
            <div class="product-card-pricing d-flex align-items-baseline justify-content-center gap-2 flex-wrap mb-1">
                @if($product->compare_at_price && $product->compare_at_price > $product->effective_price)
                    <span class="product-price-compare text-decoration-line-through text-nowrap">
                        Rs. {{ number_format($product->compare_at_price, 0) }}
                    </span>
                @endif
                <span class="product-price-main price-gradient-luxury fw-bold text-nowrap">
                    Rs. {{ number_format($product->effective_price, 0) }}
                </span>
            </div>

            <!-- Bottle Size Neche -->
            <div class="product-card-volume-row">
                <span class="product-price-volume text-nowrap">
                    {{ $product->volume_ml ?: 50 }}ml Bottle
                </span>
            </div>
        </div>

        <!-- Star Rating (Desktop Only) -->
        <div class="product-card-rating d-flex align-items-center justify-content-center gap-1 mb-2 d-none d-md-flex" style="font-size: 11px;">
            <i class="fas fa-star" style="font-size: 10px; color: #9E7D3B;"></i>
            <span class="fw-bold" style="color: #211D1E;">{{ number_format($product->rating_avg ?: 4.9, 1) }}</span>
            <span style="font-size: 10px; color: #786C67;">({{ $product->reviews_count ?: 48 }})</span>
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Add to Cart Button -->
    <div class="product-card-action mt-auto pt-2.5 pt-md-3" style="border-top: 1px solid #E8E0DA;">
        <button type="button" onclick="addToCartAjax({{ $product->id }}, 1, null, this)" 
                class="w-100 btn-gold btn-cart-gradient py-2.5 px-3 tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-2 text-white"
                style="min-height: 42px; background-color: #541B29 !important; border-radius: 8px; border: none; touch-action: manipulation; -webkit-tap-highlight-color: transparent; cursor: pointer;"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-white btn-cart-icon flex-shrink-0" style="font-size: 12px;" aria-hidden="true"></i>
            <span class="text-white text-nowrap" style="font-size: 12px; letter-spacing: 0.05em;">Add to Cart</span>
            <i class="fas fa-arrow-right-long btn-arrow text-white d-none d-md-inline-block" style="font-size: 11px;"></i>
        </button>
    </div>
</div>
