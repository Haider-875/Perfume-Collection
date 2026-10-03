@props(['product'])

<div class="product-card group relative bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 hover:border-[#d6aa62]/80 rounded-2xl overflow-hidden shadow-xl hover:shadow-[0_12px_35px_rgba(214,170,98,0.18)] transition-all duration-300 flex flex-col justify-between p-3.5 sm:p-4 h-full">
    
    <!-- Badges Row -->
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5 pointer-events-none">
        @if($product->is_bestseller)
            <span class="bg-gradient-to-r from-[#4a0915] to-[#25050a] text-[#f0d59d] text-[10px] font-bold tracking-widest uppercase px-2.5 py-0.5 rounded-full shadow-md border border-[#d6aa62]/50 backdrop-blur-xs">
                ★ BESTSELLER
            </span>
        @elseif($product->is_new_arrival)
            <span class="bg-gradient-to-r from-[#1b3d22] to-[#0d2212] text-emerald-200 text-[10px] font-bold tracking-widest uppercase px-2.5 py-0.5 rounded-full shadow-md border border-emerald-500/40 backdrop-blur-xs">
                NEW ARRIVAL
            </span>
        @elseif($product->is_featured)
            <span class="bg-gradient-to-r from-[#4a0915] to-[#25050a] text-[#ffd987] text-[10px] font-bold tracking-widest uppercase px-2.5 py-0.5 rounded-full shadow-md border border-[#d6aa62]/40 backdrop-blur-xs">
                EXCLUSIVE
            </span>
        @endif

        @if($product->has_discount)
            <span class="bg-gradient-to-r from-[#851a31] to-[#4a0915] text-[#fff7ed] text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm w-fit border border-[#d6aa62]/30">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    <!-- Quick Actions Floating Toolbars -->
    <div class="absolute top-3 right-3 z-10 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
        <!-- WhatsApp Direct Inquiry -->
        <a href="{{ $product->whats_app_order_url }}" 
           target="_blank" 
           class="w-9 h-9 bg-[#050203]/90 text-emerald-400 hover:bg-emerald-500 hover:text-white rounded-full shadow-lg flex items-center justify-center text-sm border border-[#d6aa62]/40 transition-colors" 
           title="Order 1-Click via WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Live Quick View Button -->
        <button type="button"
                class="quick-action-btn quick-view-btn w-9 h-9 bg-[#050203]/90 text-[#f5efe7] hover:bg-[#d6aa62] hover:text-[#050203] rounded-full shadow-lg flex items-center justify-center text-xs border border-[#d6aa62]/40 transition-colors"
                title="Quick Preview"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-impression="{{ $product->impression_of ?? 'Signature Composition' }}"
                data-concentration="{{ $product->concentration }}"
                data-price="{{ $product->formatted_effective_price }}"
                data-img="{{ $product->primary_image_url }}"
                data-notes="{{ $product->top_notes_summary }} / {{ $product->heart_notes_summary }} / {{ $product->base_notes_summary }}"
                data-desc="{{ Str::limit($product->story ?? $product->description, 180) }}"
                data-url="{{ route('shop.show', $product->slug) }}">
            <i class="fas fa-eye"></i>
        </button>
    </div>

    <!-- Flacon Image Wrap (Full Coverage with Hover Zoom) -->
    <a href="{{ route('shop.show', $product->slug) }}" class="relative w-full aspect-square rounded-xl overflow-hidden bg-[#0c0305] border border-[#d6aa62]/20 flex items-center justify-center mb-3 group/img">
        <img src="{{ $product->primary_image_url }}" 
             alt="{{ $product->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-108" 
             loading="lazy">
        @if($product->hover_image && $product->hover_image !== $product->thumbnail_image)
            <img src="{{ $product->hover_image_url }}" 
                 alt="{{ $product->name }} Presentation" 
                 onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                 class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700 group-hover:opacity-100" 
                 loading="lazy">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-[#050203]/60 via-transparent to-transparent pointer-events-none"></div>
    </a>

    <!-- Product Metadata & Content -->
    <div class="flex flex-col flex-grow text-center px-1">
        <!-- Impression Tag -->
        <div class="mb-1 text-center">
            @if($product->impression_of)
                <span class="text-[11px] text-[#b8a9a2] font-medium block truncate" title="Impression of {{ $product->impression_of }}">
                    Impression of <span class="text-[#f0d59d] font-semibold">{{ $product->impression_of }}</span>
                </span>
            @else
                <span class="text-[11px] text-[#d6aa62] font-medium block uppercase tracking-wider">
                    Signature Luxury Extrait
                </span>
            @endif
        </div>

        <!-- Product Title (Cormorant Garamond Elegance) -->
        <h3 class="font-serif text-lg sm:text-xl font-medium text-[#f5efe7] group-hover:text-[#f0d59d] transition-colors leading-snug line-clamp-1 mb-1.5">
            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <!-- Dual Pricing / Range in Shimmering Gold -->
        <div class="my-1.5 flex items-baseline justify-center gap-1.5">
            <span class="text-xs sm:text-sm font-medium text-[#b8a9a2]">
                Rs. {{ number_format(max(450, round($product->effective_price * 0.22, -1))) }}
            </span>
            <span class="text-[10px] text-[#8e7c75] font-medium uppercase">/10ml</span>
            <span class="text-xs text-[#d6aa62]/50 font-light">&ndash;</span>
            <span class="text-sm sm:text-base font-bold text-[#f0d59d]">
                {{ $product->formatted_effective_price }}
            </span>
            <span class="text-[10px] text-[#8e7c75] font-medium uppercase">/{{ $product->volume_ml }}ml</span>
        </div>

        <!-- Star Rating -->
        <div class="flex items-center justify-center gap-1 text-[11px] text-[#d6aa62] mb-1">
            <i class="fas fa-star text-[10px]"></i>
            <span class="font-bold text-[#f5efe7]">{{ number_format($product->rating_avg ?: 4.9, 1) }}</span>
            <span class="text-[#8e7c75] text-[10px]">({{ $product->reviews_count ?: 48 }})</span>
        </div>
    </div>

    <!-- Prominent Full-Width Luxury Gold Button -->
    <div class="mt-3 pt-2 border-t border-[#d6aa62]/20">
        <button onclick="addToCartAjax({{ $product->id }}, 1)" 
                class="w-full py-2.5 px-4 btn-gold active:scale-[0.98] text-[#050203] font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-2 group-hover:shadow-[0_4px_20px_rgba(214,170,98,0.45)]"
                title="Add to Cart">
            <i class="fas fa-cart-shopping text-xs"></i>
            <span>Add to Cart</span>
        </button>
    </div>
</div>
