@props(['product'])

<div class="product-card position-relative bg-gradient-wine-card border border-gold-25 luxury-hover-card rounded-4 overflow-hidden shadow-lg d-flex flex-column justify-content-between p-3 p-sm-3 h-100">
    
    <!-- Badges Row -->
    <div class="position-absolute top-0 start-0 m-3 z-2 d-flex flex-column gap-1 pointer-events-none">
        @if($product->is_bestseller)
            <span class="bg-gradient-wine-badge text-gold-soft fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm border border-gold-50 backdrop-blur-xs" style="font-size: 10px; letter-spacing: 0.15em;">
                ★ BESTSELLER
            </span>
        @elseif($product->is_new_arrival)
            <span class="bg-success text-white fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm border border-success backdrop-blur-xs" style="font-size: 10px; letter-spacing: 0.15em;">
                NEW ARRIVAL
            </span>
        @elseif($product->is_featured)
            <span class="bg-gradient-wine-badge text-gold-bright fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm border border-gold-40 backdrop-blur-xs" style="font-size: 10px; letter-spacing: 0.15em;">
                EXCLUSIVE
            </span>
        @endif

        @if($product->has_discount)
            <span class="bg-gradient-discount-badge text-white fw-bold px-2 py-0-5 rounded-pill shadow-sm border border-gold-30" style="font-size: 10px; width: fit-content;">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    <!-- Flacon Image Wrap (Full Coverage with Hover Zoom) -->
    <a href="{{ route('shop.show', $product->slug) }}" class="position-relative w-100 aspect-1x1 rounded-3 overflow-hidden bg-theme-secondary border border-gold-20 d-flex align-items-center justify-center mb-3 text-decoration-none">
        <img src="{{ $product->primary_image_url }}" 
             alt="{{ $product->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
             class="w-100 h-100 object-fit-cover transition-smooth" 
             loading="lazy">
        @if($product->hover_image && $product->hover_image !== $product->thumbnail_image)
            <img src="{{ $product->hover_image_url }}" 
                 alt="{{ $product->name }} Presentation" 
                 onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                 class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover opacity-0 transition-smooth" 
                 loading="lazy">
        @endif
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade pointer-events-none"></div>
    </a>

    <!-- Product Metadata & Content -->
    <div class="product-card-body d-flex flex-column flex-grow-1 text-center px-1">
        <!-- Impression Tag -->
        <div class="product-card-impression mb-1 text-center">
            @if($product->impression_of)
                <span class="text-muted-luxury fw-medium d-block text-truncate" style="font-size: 11px;" title="Impression of {{ $product->impression_of }}">
                    Impression of <span class="text-gold-soft fw-semibold">{{ $product->impression_of }}</span>
                </span>
            @else
                <span class="text-gold fw-medium d-block text-uppercase tracking-wider" style="font-size: 11px;">
                    Signature Luxury Extrait
                </span>
            @endif
        </div>

        <!-- Product Title (Cormorant Garamond Elegance) -->
        <h3 class="product-card-title font-serif fs-5 fw-medium text-ivory mb-1">
            <a href="{{ route('shop.show', $product->slug) }}" class="text-ivory text-decoration-none">{{ $product->name }}</a>
        </h3>

        <!-- Dual Pricing / Range in Pure White -->
        <div class="product-card-pricing my-1 d-flex align-items-baseline justify-content-center gap-1">
            <span class="text-xs text-white fw-medium" style="color: #ffffff !important;">
                Rs. {{ number_format(max(450, round($product->effective_price * 0.22, -1))) }}
            </span>
            <span class="text-light-luxury fw-medium text-uppercase" style="font-size: 10px;">/10ml</span>
            <span class="text-white opacity-50 fw-light" style="font-size: 11px; color: #ffffff !important;">&ndash;</span>
            <span class="text-sm fw-bold text-white" style="color: #ffffff !important;">
                {{ $product->formatted_effective_price }}
            </span>
            <span class="text-light-luxury fw-medium text-uppercase" style="font-size: 10px;">/{{ $product->volume_ml }}ml</span>
        </div>

        <!-- Star Rating -->
        <div class="product-card-rating d-flex align-items-center justify-content-center gap-1 text-gold mb-1" style="font-size: 11px;">
            <i class="fas fa-star" style="font-size: 10px;"></i>
            <span class="fw-bold text-ivory">{{ number_format($product->rating_avg ?: 4.9, 1) }}</span>
            <span class="text-light-luxury" style="font-size: 10px;">({{ $product->reviews_count ?: 48 }})</span>
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Add to Cart Gradient Button -->
    <div class="mt-3 pt-2 border-top border-gold-20">
        <button onclick="addToCartAjax({{ $product->id }}, 1)" 
                class="w-100 btn-gold btn-cart-gradient py-2.5 px-3 text-xs tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-2 text-white"
                style="min-height: 42px;"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-white" style="font-size: 11px;"></i>
            <span class="text-white">Add to Cart</span>
            <i class="fas fa-arrow-right-long btn-arrow text-white" style="font-size: 11px;"></i>
        </button>
    </div>
</div>
