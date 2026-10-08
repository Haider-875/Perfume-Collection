<form action="{{ url()->current() }}" method="GET" id="{{ $formId ?? 'collectionFilterForm' }}">
    @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    <!-- Quick Search in Collection -->
    <div class="mb-4">
        <label class="d-block text-xs text-uppercase tracking-widest text-gold fw-semibold mb-2">Search Catalog</label>
        <div class="position-relative">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search note or impression..." 
                class="form-control form-control-luxury text-xs py-2 px-3"
            >
            @if(request('q'))
                <a href="{{ url()->current() }}" class="position-absolute end-0 top-50 translate-middle-y me-3 text-muted-parchment text-light-parchment-hover text-xs text-decoration-none">&times;</a>
            @endif
        </div>
    </div>

    <!-- Filter 1: Collections Navigation -->
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3 d-flex align-items-center justify-content-between">
            <span>Houses & Categories</span>
            <i class="fas fa-chevron-down text-muted-parchment" style="font-size: 10px;"></i>
        </h4>
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-xs">
            <li>
                <a href="{{ route('collections.show', 'all') }}" class="d-block py-1 text-decoration-none {{ $slug === 'all' ? 'text-gold fw-bold' : 'text-muted-parchment text-light-parchment-hover' }}">
                    All Impressions
                </a>
            </li>
            @foreach($allCollections as $col)
                <li>
                    <a href="{{ route('collections.show', $col->slug) }}" class="d-block py-1 text-decoration-none {{ $slug === $col->slug ? 'text-gold fw-bold' : 'text-muted-parchment text-light-parchment-hover' }}">
                        {{ $col->name }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('collections.show', 'bundles') }}" class="d-block py-1 text-gold-soft fw-semibold text-decoration-none d-flex align-items-center justify-content-between">
                    <span>Curated Bundles</span>
                    <span class="bg-wine-accent text-gold-soft border border-gold-30 px-2 py-0-5 rounded fw-bold" style="font-size: 9px;">SAVE 25%</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Filter 2: Fragrance Family -->
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
            Fragrance Family
        </h4>
        <div class="d-flex flex-column gap-2 overflow-y-auto pe-2 no-scrollbar" style="max-height: 192px;">
            @foreach($fragranceFamilies as $family)
                <label class="d-flex align-items-center justify-content-between text-xs text-muted-parchment cursor-pointer text-light-parchment-hover mb-0">
                    <span class="d-flex align-items-center gap-2">
                        <input 
                            type="radio" 
                            name="family" 
                            value="{{ $family->slug }}" 
                            {{ request('family') == $family->slug ? 'checked' : '' }} 
                            onchange="this.form.submit()"
                            class="form-check-input bg-transparent border-gold-40 m-0"
                        >
                        <span class="{{ request('family') == $family->slug ? 'text-gold fw-bold' : '' }}">{{ $family->name }}</span>
                    </span>
                    <span class="text-muted-parchment" style="font-size: 10px;">({{ $family->products_count }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Filter 3: Scent Notes -->
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
            Signature Notes
        </h4>
        <div class="d-flex flex-wrap gap-1 overflow-y-auto pe-1 no-scrollbar" style="max-height: 160px;">
            @foreach($scentNotes as $note)
                <a 
                    href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                    class="px-2 py-1 rounded border transition text-decoration-none {{ request('note') == $note->slug ? 'bg-wine-accent text-gold-soft border-gold fw-semibold' : 'border-gold-20 bg-wine-dark text-muted-parchment text-gold-hover' }}"
                    style="font-size: 11px;"
                >
                    {{ $note->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Filter 4: Volume / Size (ml) -->
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
            Flacon Volume
        </h4>
        <div class="row g-2 text-xs">
            @foreach([10, 50, 100] as $vol)
                <div class="col-4">
                    <button 
                        type="button" 
                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}'"
                        class="w-100 py-2 text-center rounded-3 border transition {{ request('volume_ml') == $vol ? 'bg-wine-accent text-gold-soft border-gold fw-semibold' : 'border-gold-25 bg-wine-dark text-muted-parchment text-light-parchment-hover' }}"
                    >
                        {{ $vol }} ml
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filter 5: Price Range (PKR) -->
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
            Price Range (PKR)
        </h4>
        <div class="d-flex align-items-center gap-2 mb-3">
            <input 
                type="number" 
                name="min_price" 
                value="{{ request('min_price') }}" 
                placeholder="Min Rs." 
                class="form-control form-control-luxury text-xs py-2 px-2 text-center"
                style="width: calc(50% - 10px);"
            >
            <span class="text-muted-parchment">-</span>
            <input 
                type="number" 
                name="max_price" 
                value="{{ request('max_price') }}" 
                placeholder="Max Rs." 
                class="form-control form-control-luxury text-xs py-2 px-2 text-center"
                style="width: calc(50% - 10px);"
            >
        </div>
        <button type="submit" class="w-100 btn-gold py-2 text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.1em;">
            Apply Price
        </button>
    </div>

    <!-- Sort by in mobile drawer -->
    @if(isset($isMobileDrawer) && $isMobileDrawer)
    <div class="border-top border-gold-20 pt-4 mb-4">
        <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
            Sort Masterpieces
        </h4>
        <select 
            name="sort" 
            onchange="this.form.submit()" 
            class="form-select select-luxury-sort w-100"
        >
            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured Creations</option>
            <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Most Coveted (Bestsellers)</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
        </select>
    </div>
    @endif

    <!-- Reset Filters -->
    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
        <a href="{{ url()->current() }}" class="d-block text-center text-xs text-danger py-2 border border-danger-subtle rounded text-uppercase tracking-wider fw-semibold text-decoration-none">
            <i class="fas fa-undo me-1"></i> Clear All Filters
        </a>
    @endif
</form>
