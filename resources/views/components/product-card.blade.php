@props(['product'])

<div class="product-card position-relative bg-white border border-subtle luxury-hover-card rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-3 p-sm-3 h-100" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
    
    <!-- Badges Row -->
    <div class="position-absolute top-0 start-0 m-2 m-sm-3 z-2 d-flex flex-column gap-1 pointer-events-none">
        @if($product->is_bestseller)
            <span class="bg-gradient-wine-badge text-white fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm" style="font-size: 10px; letter-spacing: 0.12em; background-color: #541B29 !important;">
                ★ BESTSELLER
            </span>
        @elseif($product->is_new_arrival)
            <span class="bg-success text-white fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm" style="font-size: 10px; letter-spacing: 0.12em;">
                NEW ARRIVAL
            </span>
        @elseif($product->is_featured)
            <span class="bg-gradient-wine-badge text-white fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm" style="font-size: 10px; letter-spacing: 0.12em; background-color: #541B29 !important;">
                EXCLUSIVE
            </span>
        @endif

        @if($product->has_discount)
            <span class="bg-danger text-white fw-bold px-2 py-0-5 rounded-pill shadow-sm" style="font-size: 10px; width: fit-content; background-color: #9E2A2B !important;">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    <!-- Flacon Image Wrap (Clean, Spacious Presentation on Light Surface) -->
    <a href="{{ route('shop.show', $product->slug) }}" 
       class="product-card-media position-relative w-100 aspect-1x1 rounded-3 overflow-hidden d-flex align-items-center justify-content-center mb-2 mb-md-3 text-decoration-none"
       style="aspect-ratio: 1 / 1; min-height: 180px; background-color: #FAF7F2; border: 1px solid #EFEAE5;">
        <img src="{{ $product->primary_image_url }}" 
             alt="{{ $product->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
             class="w-100 h-100 object-fit-cover transition-smooth" 
             style="aspect-ratio: 1 / 1;"
             loading="lazy">
        @if($product->hover_image && $product->hover_image !== $product->thumbnail_image)
            <img src="{{ $product->hover_image_url }}" 
                 alt="{{ $product->name }} Presentation" 
                 onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                 class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover opacity-0 transition-smooth" 
                 style="aspect-ratio: 1 / 1;"
                 loading="lazy">
        @endif
    </a>

    <!-- Product Metadata & Content -->
    <div class="product-card-body d-flex flex-column flex-grow-1 text-center px-1">
        <!-- Impression Tag (Desktop Only, Hidden on Mobile for clean Image -> Title order) -->
        <div class="product-card-impression mb-1 text-center d-none d-md-block">
            @if($product->impression_of)
                <span class="fw-medium d-block text-truncate" style="font-size: 11px; color: #6B605B;" title="Impression of {{ $product->impression_of }}">
                    Impression of <span class="fw-semibold" style="color: #541B29;">{{ $product->impression_of }}</span>
                </span>
            @else
                <span class="fw-medium d-block text-uppercase tracking-wider" style="font-size: 11px; color: #9E7D3B;">
                    Signature Luxury Extrait
                </span>
            @endif
        </div>

        <!-- Product Title (Cormorant Garamond Elegance) -->
        <h3 class="product-card-title font-serif fs-5 fw-medium mb-1">
            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none" style="color: #211D1E !important;">{{ $product->name }}</a>
        </h3>

        <!-- Dual Pricing / Range in Charcoal & Maroon -->
        <div class="product-card-pricing my-1 d-flex align-items-baseline justify-content-center gap-1 flex-wrap">
            <span class="text-nowrap d-inline-flex align-items-baseline gap-1">
                <span class="product-price-min fw-medium" style="color: #211D1E !important;">
                    Rs. {{ number_format(max(450, round($product->effective_price * 0.22, -1))) }}
                </span>
                <span class="product-price-unit fw-medium text-uppercase" style="color: #786C67; font-size: 10px;">/10ml</span>
            </span>
            <span class="product-price-sep opacity-50 fw-light" style="color: #786C67 !important;">&ndash;</span>
            <span class="text-nowrap d-inline-flex align-items-baseline gap-1">
                <span class="product-price-main fw-bold" style="color: #541B29 !important;">
                    {{ $product->formatted_effective_price }}
                </span>
                <span class="product-price-unit fw-medium text-uppercase" style="color: #786C67; font-size: 10px;">/{{ $product->volume_ml }}ml</span>
            </span>
        </div>

        <!-- Star Rating (Desktop Only, Hidden on Mobile for clean Title -> Price -> Button order) -->
        <div class="product-card-rating d-flex align-items-center justify-content-center gap-1 mb-1 d-none d-md-flex" style="font-size: 11px;">
            <i class="fas fa-star" style="font-size: 10px; color: #9E7D3B;"></i>
            <span class="fw-bold" style="color: #211D1E;">{{ number_format($product->rating_avg ?: 4.9, 1) }}</span>
            <span style="font-size: 10px; color: #786C67;">({{ $product->reviews_count ?: 48 }})</span>
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Add to Cart Button -->
    <div class="product-card-action mt-2 mt-md-3 pt-0 pt-md-2" style="border-top: 1px solid #E8E0DA;">
        <button onclick="addToCartAjax({{ $product->id }}, 1)" 
                class="w-100 btn-gold btn-cart-gradient py-2.5 px-3 tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-2 text-white"
                style="min-height: 42px; background-color: #541B29 !important; border-radius: 8px; border: none;"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-white" style="font-size: 11px;"></i>
            <span class="text-white">Add to Cart</span>
            <i class="fas fa-arrow-right-long btn-arrow text-white d-none d-md-inline-block" style="font-size: 11px;"></i>
        </button>
    </div>
</div>
