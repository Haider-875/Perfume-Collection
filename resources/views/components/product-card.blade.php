@props(['product'])

<div class="product-card group relative bg-white border border-gray-200/80 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:border-amber-300/80 transition-all duration-300 flex flex-col justify-between p-4">
    
    <!-- Badges Row -->
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5 pointer-events-none">
        @if($product->is_bestseller)
            <span class="bg-black text-amber-300 text-[10px] font-bold tracking-widest uppercase px-2 py-0.5 rounded shadow-sm border border-amber-500/30">
                ★ BESTSELLER
            </span>
        @elseif($product->is_new_arrival)
            <span class="bg-emerald-700 text-white text-[10px] font-bold tracking-widest uppercase px-2 py-0.5 rounded shadow-sm">
                NEW ARRIVAL
            </span>
        @elseif($product->is_featured)
            <span class="bg-amber-900 text-amber-200 text-[10px] font-bold tracking-widest uppercase px-2 py-0.5 rounded shadow-sm">
                EXCLUSIVE
            </span>
        @endif

        @if($product->has_discount)
            <span class="bg-rose-700 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm w-fit">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    <!-- Quick Actions Floating Toolbars -->
    <div class="absolute top-3 right-3 z-10 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
        <!-- WhatsApp Direct Inquiry -->
        <a href="{{ $product->whats_app_order_url }}" 
           target="_blank" 
           class="w-9 h-9 bg-white/95 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-full shadow-md flex items-center justify-center text-sm border border-gray-100 transition-colors" 
           title="Order 1-Click via WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Live Quick View Button -->
        <button type="button"
                class="quick-action-btn quick-view-btn w-9 h-9 bg-white/95 text-gray-700 hover:bg-black hover:text-amber-400 rounded-full shadow-md flex items-center justify-center text-xs border border-gray-100 transition-colors"
                title="Quick Olfactory Preview"
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

    <!-- Flacon Image Wrap -->
    <a href="{{ route('shop.show', $product->slug) }}" class="relative w-full h-56 bg-gradient-to-b from-gray-50/70 to-amber-50/20 rounded-lg flex items-center justify-center overflow-hidden mb-3.5">
        <img src="{{ $product->primary_image_url }}" 
             alt="{{ $product->name }}" 
             class="max-h-48 w-auto object-contain transition-transform duration-500 group-hover:scale-105" 
             loading="lazy">
        @if($product->hover_image)
            <img src="{{ $product->hover_image_url }}" 
                 alt="{{ $product->name }} Presentation Box" 
                 class="absolute max-h-48 w-auto object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100" 
                 loading="lazy">
        @endif
    </a>

    <!-- Impression Tag (Key BuyRawaha Signature Element) -->
    <div class="mb-1.5">
        @if($product->impression_of)
            <div class="inline-flex items-center gap-1 bg-amber-50/90 border border-amber-200/70 text-amber-900 text-[10px] px-2 py-0.5 rounded font-medium">
                <span class="text-amber-700/80 font-normal">Our Impression of:</span>
                <strong class="font-semibold">{{ $product->impression_of }}</strong>
            </div>
        @else
            <div class="inline-flex items-center gap-1 bg-gray-50 border border-gray-200/60 text-gray-700 text-[10px] px-2 py-0.5 rounded font-medium">
                <span>Signature Pure Extrait</span>
            </div>
        @endif
    </div>

    <!-- Product Title -->
    <h3 class="font-serif text-base font-bold text-gray-900 leading-snug group-hover:text-amber-800 transition-colors line-clamp-1 mb-1">
        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
    </h3>

    <!-- Reviews Rating & Concentration -->
    <div class="flex items-center justify-between text-xs mb-2">
        <div class="flex items-center gap-1 text-amber-500 text-[11px]">
            <i class="fas fa-star"></i>
            <span class="font-semibold text-gray-800">{{ number_format($product->rating_avg ?: 4.9, 1) }}</span>
            <span class="text-gray-400 text-[10px]">({{ $product->reviews_count ?: 48 }})</span>
        </div>
        <span class="text-[10px] text-gray-500 uppercase tracking-wider font-medium">
            {{ $product->volume_ml }}ml Flacon
        </span>
    </div>

    <!-- Olfactory Notes Preview -->
    <p class="text-[11px] text-gray-500 italic line-clamp-1 mb-3">
        Notes: {{ $product->top_notes_summary ?? 'Crimson Saffron, Taif Rose, Royal Agarwood' }}
    </p>

    <!-- Size Variants Quick Tag -->
    <div class="flex items-center gap-1 mb-3 text-[10px]">
        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">50ml</span>
        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">100ml</span>
        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-500">10ml Tester</span>
    </div>

    <!-- Price and Add to Bag Footer -->
    <div class="pt-3 border-t border-gray-100 flex items-center justify-between mt-auto">
        <div class="flex flex-col">
            <div class="flex items-baseline gap-1.5">
                <span class="text-base font-bold text-gray-900 font-serif">
                    {{ $product->formatted_effective_price }}
                </span>
                @if($product->has_discount)
                    <span class="text-xs text-gray-400 line-through">
                        {{ $product->formatted_price }}
                    </span>
                @endif
            </div>
            <span class="text-[9px] text-emerald-700 font-semibold uppercase tracking-wider">Free Shipping Included</span>
        </div>

        <button onclick="addToCartAjax({{ $product->id }}, 1)" 
                class="px-3.5 py-2 rounded-lg bg-black hover:bg-amber-600 text-white text-xs font-semibold uppercase tracking-wider shadow-sm transition flex items-center gap-1.5"
                title="Add to Vault Cart">
            <i class="fas fa-bag-shopping text-xs"></i>
            <span>Add</span>
        </button>
    </div>
</div>
