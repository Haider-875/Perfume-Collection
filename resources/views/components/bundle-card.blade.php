@props(['bundle'])

<div class="bundle-card group relative bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/30 hover:border-[#d6aa62]/80 rounded-2xl overflow-hidden shadow-xl hover:shadow-[0_12px_35px_rgba(214,170,98,0.2)] transition-all duration-300 flex flex-col justify-between p-5 sm:p-6">
    
    <!-- Top Savings Badge -->
    <div class="absolute top-4 left-4 z-10">
        <span class="bg-gradient-to-r from-[#851a31] to-[#4a0915] text-[#fff7ed] text-[11px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider border border-[#d6aa62]/40">
            {{ $bundle->badge_text ?? 'SAVE ' . $bundle->formatted_savings }}
        </span>
    </div>

    <!-- Image Preview -->
    <div class="relative w-full aspect-square sm:h-64 rounded-xl overflow-hidden bg-[#0c0305] border border-[#d6aa62]/20 flex items-center justify-center mb-4">
        <img src="{{ $bundle->image_url }}" 
             alt="{{ $bundle->name }}" 
             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-t from-[#050203]/70 via-transparent to-transparent pointer-events-none"></div>
    </div>

    <!-- Bundle Title & Tagline -->
    <div class="mb-3">
        <h3 class="font-serif text-xl sm:text-2xl font-medium text-[#f5efe7] group-hover:text-[#f0d59d] transition-colors leading-snug mb-1">
            {{ $bundle->name }}
        </h3>
        @if($bundle->tagline)
            <p class="text-xs text-[#b8a9a2] font-serif italic">
                "{{ $bundle->tagline }}"
            </p>
        @endif
    </div>

    <!-- Included Flacons Breakdown -->
    @if($bundle->items && $bundle->items->count() > 0)
        <div class="bg-[#160409]/70 border border-[#d6aa62]/20 rounded-xl p-3 mb-4 flex-grow">
            <div class="text-[10px] uppercase tracking-wider text-[#d6aa62] font-bold mb-2 flex items-center gap-1.5">
                <i class="fas fa-layer-group text-[#d6aa62]"></i> Included in this Coffret:
            </div>
            <ul class="space-y-1.5">
                @foreach($bundle->items as $bItem)
                    <li class="text-xs text-[#dfd5cb] flex items-center gap-2">
                        <i class="fas fa-check text-[#d6aa62] text-[10px]"></i>
                        <span><strong class="text-[#f5efe7]">{{ $bItem->product->name ?? 'Luxury Flacon' }}</strong> <span class="text-[#8e7c75]">({{ $bItem->custom_size_label ?? '100ml Extrait' }})</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pricing and Savings Summary -->
    <div class="flex items-baseline justify-between pt-3 border-t border-[#d6aa62]/20 mb-4">
        <div>
            <div class="text-[10px] text-[#8e7c75] uppercase tracking-wider font-semibold">Special Bundle Price</div>
            <div class="font-serif text-2xl font-bold text-[#f0d59d]">
                {{ $bundle->formatted_bundle_price }}
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-[#8e7c75] line-through">
                {{ $bundle->formatted_original_price }}
            </div>
            <div class="text-[11px] text-[#f0d59d] font-bold">
                Save {{ $bundle->formatted_savings }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-2">
        <button onclick="addBundleToCart({{ $bundle->id }})" 
                class="w-full btn-gold py-3 text-xs tracking-wider uppercase rounded-xl flex items-center justify-center gap-2">
            <i class="fas fa-cart-shopping text-xs"></i>
            <span>ADD BUNDLE TO BAG</span>
        </button>
    </div>
</div>
