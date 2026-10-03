@props(['product'])

<div class="product-card">
    <!-- Badges -->
    <div class="product-badge-wrap">
        @if($product->is_limited_edition)
            <span class="badge-luxury">ROYAL RESERVE</span>
        @elseif($product->is_bestseller)
            <span class="badge-luxury">BESTSELLER</span>
        @elseif($product->is_new_arrival)
            <span class="badge-luxury" style="background: linear-gradient(135deg, #16A085, #1ABC9C); color: #FFF;">NEW RELEASE</span>
        @endif

        @if($product->has_discount)
            <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
        @endif
    </div>

    <!-- Quick Floating Actions -->
    <div class="card-quick-actions">
        <!-- Quick View -->
        <button class="quick-action-btn quick-view-btn" 
                title="Quick Olfactory View"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-concentration="{{ $product->concentration }}"
                data-price="{{ $product->formatted_effective_price }}"
                data-img="{{ $product->primary_image_url }}"
                data-notes="{{ $product->top_notes_summary }} / {{ $product->heart_notes_summary }} / {{ $product->base_notes_summary }}"
                data-desc="{{ Str::limit($product->story ?? $product->description, 180) }}"
                data-url="{{ route('shop.show', $product->slug) }}">
            <i class="fas fa-eye"></i>
        </button>

        <!-- WhatsApp 1-Click Inquiry -->
        <a href="{{ $product->whats_app_order_url }}" target="_blank" class="quick-action-btn" style="color: #25D366;" title="Order in 1-Click on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Flacon Image Presentation -->
    <a href="{{ route('shop.show', $product->slug) }}" class="product-img-wrap">
        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="product-primary-img" loading="lazy">
        @if($product->hover_image)
            <img src="{{ $product->hover_image_url }}" alt="{{ $product->name }} Box" class="product-hover-img" loading="lazy">
        @endif
    </a>

    <!-- Meta Details -->
    <div class="product-meta">
        <span class="product-concentration">{{ $product->concentration }}</span>
        <div class="product-rating">
            <i class="fas fa-star"></i>
            <span>{{ number_format($product->rating_avg, 1) }}</span>
            <span style="color: var(--text-muted); font-size: 0.7rem;">({{ $product->reviews_count }})</span>
        </div>
    </div>

    <!-- Title -->
    <h3 class="product-title">
        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
    </h3>

    <!-- Notes Preview -->
    <p class="product-notes-preview">
        Notes: {{ $product->top_notes_summary ?? 'Kashmiri Saffron, Rose Absolute, Cambodian Agarwood' }}
    </p>

    <!-- Longevity & Sillage Tags -->
    <div class="product-performance-tags">
        <span class="perf-tag"><i class="fas fa-hourglass-half"></i> {{ $product->longevity }}</span>
        <span class="perf-tag"><i class="fas fa-wind"></i> {{ $product->volume_ml }}ml Flacon</span>
    </div>

    <!-- Footer with PKR Price and Add Action -->
    <div class="product-footer">
        <div class="price-box">
            <span class="current-price">{{ $product->formatted_effective_price }}</span>
            @if($product->has_discount)
                <span class="original-price">{{ $product->formatted_price }}</span>
            @endif
        </div>

        <button onclick="addToCartAjax({{ $product->id }}, 1)" class="btn-card-add" title="Acquire Flacon">
            <i class="fas fa-shopping-bag"></i>
        </button>
    </div>
</div>
