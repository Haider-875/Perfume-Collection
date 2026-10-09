<form action="{{ url()->current() }}" method="GET" id="{{ $formId ?? 'collectionFilterForm' }}" class="collection-filter-form">
    {{-- Preserve active filters as hidden inputs for text/price submissions --}}
    @if(request('family'))
        <input type="hidden" name="family" value="{{ request('family') }}">
    @endif
    @if(request('note'))
        <input type="hidden" name="note" value="{{ request('note') }}">
    @endif
    @if(request('volume_ml'))
        <input type="hidden" name="volume_ml" value="{{ request('volume_ml') }}">
    @endif
    @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    {{-- 1. Top Bar: Quick Search & Filter Status --}}
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-2">
                <i class="fas fa-sliders-h text-gold" style="font-size: 11px;"></i>
                <span>Filter Scents</span>
            </span>
            @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                <a href="{{ url()->current() }}" class="text-muted-parchment text-gold-hover text-decoration-none" style="font-size: 11px; letter-spacing: 0.05em;" title="Reset all filters">
                    <i class="fas fa-undo me-1" style="font-size: 9px;"></i> Reset All
                </a>
            @endif
        </div>

        {{-- Search Input with 1-click Clear --}}
        <div class="position-relative">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search note or impression..." 
                class="form-control form-control-luxury text-xs py-2 ps-3 pe-4"
            >
            @if(request('q'))
                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="position-absolute end-0 top-50 translate-middle-y me-2 text-muted-parchment text-light-parchment-hover fs-5 text-decoration-none lh-1" title="Clear search">&times;</a>
            @endif
        </div>
    </div>

    {{-- Active Filters Badges (Instant visual feedback + 1-click remove) --}}
    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
        <div class="mb-3 pb-3 border-bottom border-gold-20">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted-parchment text-uppercase" style="font-size: 10px; letter-spacing: 0.08em;">Active Filters</span>
            </div>
            <div class="d-flex flex-wrap gap-1">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="badge rounded-pill bg-wine-accent border border-gold-30 text-gold-soft text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-light-parchment-hover" style="font-size: 10px;">
                        <span>"{{ Str::limit(request('q'), 15) }}"</span>
                        <i class="fas fa-times text-gold ms-1" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('family'))
                    @php $activeFam = $fragranceFamilies->firstWhere('slug', request('family')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['family' => null]) }}" class="badge rounded-pill bg-wine-accent border border-gold-30 text-gold-soft text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-light-parchment-hover" style="font-size: 10px;">
                        <span>{{ $activeFam ? $activeFam->name : ucfirst(request('family')) }}</span>
                        <i class="fas fa-times text-gold ms-1" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('note'))
                    <a href="{{ request()->fullUrlWithQuery(['note' => null]) }}" class="badge rounded-pill bg-wine-accent border border-gold-30 text-gold-soft text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-light-parchment-hover" style="font-size: 10px;">
                        <span>Note: {{ ucfirst(request('note')) }}</span>
                        <i class="fas fa-times text-gold ms-1" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('volume_ml'))
                    <a href="{{ request()->fullUrlWithQuery(['volume_ml' => null]) }}" class="badge rounded-pill bg-wine-accent border border-gold-30 text-gold-soft text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-light-parchment-hover" style="font-size: 10px;">
                        <span>{{ request('volume_ml') }} ml</span>
                        <i class="fas fa-times text-gold ms-1" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('min_price') || request('max_price'))
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="badge rounded-pill bg-wine-accent border border-gold-30 text-gold-soft text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-light-parchment-hover" style="font-size: 10px;">
                        <span>Rs. {{ request('min_price') ? number_format(request('min_price')) : '0' }} - {{ request('max_price') ? number_format(request('max_price')) : 'Max' }}</span>
                        <i class="fas fa-times text-gold ms-1" style="font-size: 9px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Filter 1: Fragrance Family (Primary Filter - Open by Default) --}}
    <div class="border-top border-gold-20 pt-3 mb-3" x-data="{ openFamily: true }">
        <button 
            type="button" 
            @click="openFamily = !openFamily"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2.5 text-decoration-none"
            aria-label="Toggle Fragrance Family"
        >
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-1.5">
                <span>Fragrance Family</span>
                @if(request('family'))
                    <span class="badge rounded-pill bg-gold text-wine-dark fw-bold px-1.5 py-0" style="font-size: 9px;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down text-muted-parchment" :style="openFamily ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px;"></i>
        </button>

        <div x-show="openFamily" x-cloak class="d-flex flex-column gap-1">
            <a 
                href="{{ request()->fullUrlWithQuery(['family' => null]) }}" 
                class="d-flex align-items-center justify-content-between text-xs py-1.5 px-2 rounded-2 text-decoration-none transition {{ !request('family') ? 'bg-wine-accent text-gold-soft fw-semibold border border-gold-30' : 'text-muted-parchment text-light-parchment-hover' }}"
            >
                <span>All Fragrance Families</span>
            </a>
            @foreach($fragranceFamilies as $family)
                <a 
                    href="{{ request()->fullUrlWithQuery(['family' => request('family') == $family->slug ? null : $family->slug]) }}" 
                    class="d-flex align-items-center justify-content-between text-xs py-1.5 px-2 rounded-2 text-decoration-none transition {{ request('family') == $family->slug ? 'bg-wine-accent text-gold-soft fw-semibold border border-gold-30' : 'text-muted-parchment text-light-parchment-hover' }}"
                >
                    <span class="d-flex align-items-center gap-2">
                        <i class="fas fa-check text-gold" style="font-size: 8px; {{ request('family') == $family->slug ? '' : 'visibility: hidden;' }}"></i>
                        <span>{{ $family->name }}</span>
                    </span>
                    <span class="{{ request('family') == $family->slug ? 'text-gold-soft' : 'text-muted-parchment' }}" style="font-size: 10px;">({{ $family->products_count }})</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Filter 2: Flacon Volume / Bottle Size (Quick 3-button row) --}}
    <div class="border-top border-gold-20 pt-3 mb-3" x-data="{ openVolume: true }">
        <button 
            type="button" 
            @click="openVolume = !openVolume"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2.5 text-decoration-none"
            aria-label="Toggle Bottle Size"
        >
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-1.5">
                <span>Flacon Volume</span>
                @if(request('volume_ml'))
                    <span class="badge rounded-pill bg-gold text-wine-dark fw-bold px-1.5 py-0" style="font-size: 9px;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down text-muted-parchment" :style="openVolume ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px;"></i>
        </button>

        <div x-show="openVolume" x-cloak>
            <div class="row g-2 text-xs">
                @foreach([10, 50, 100] as $vol)
                    <div class="col-4">
                        <a 
                            href="{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}"
                            class="d-block w-100 py-1.5 text-center rounded-3 border transition text-decoration-none {{ request('volume_ml') == $vol ? 'bg-wine-accent text-gold-soft border-gold fw-semibold' : 'border-gold-25 bg-wine-dark text-muted-parchment text-light-parchment-hover' }}"
                        >
                            {{ $vol }} ml
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Filter 3: Price (PKR) --}}
    <div class="border-top border-gold-20 pt-3 mb-3" x-data="{ openPrice: {{ request()->hasAny(['min_price', 'max_price']) ? 'true' : 'true' }} }">
        <button 
            type="button" 
            @click="openPrice = !openPrice"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2.5 text-decoration-none"
            aria-label="Toggle Price Range"
        >
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-1.5">
                <span>Price (PKR)</span>
                @if(request('min_price') || request('max_price'))
                    <span class="badge rounded-pill bg-gold text-wine-dark fw-bold px-1.5 py-0" style="font-size: 9px;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down text-muted-parchment" :style="openPrice ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px;"></i>
        </button>

        <div x-show="openPrice" x-cloak class="d-flex flex-column gap-2">
            {{-- Quick Budget Brackets --}}
            <div class="d-flex flex-column gap-1 text-xs">
                @php
                    $isUnder15k = request('max_price') == '15000' && !request('min_price');
                    $is15kTo18k = request('min_price') == '15000' && request('max_price') == '18000';
                    $isAbove18k = request('min_price') == '18000' && !request('max_price');
                @endphp
                <a 
                    href="{{ $isUnder15k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => null, 'max_price' => 15000]) }}"
                    class="py-1 px-2 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between {{ $isUnder15k ? 'bg-wine-accent text-gold-soft border border-gold-30 fw-semibold' : 'text-muted-parchment text-light-parchment-hover' }}"
                >
                    <span>Under Rs. 15,000</span>
                    <i class="fas fa-check text-gold" style="font-size: 8px; {{ $isUnder15k ? '' : 'visibility: hidden;' }}"></i>
                </a>
                <a 
                    href="{{ $is15kTo18k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 15000, 'max_price' => 18000]) }}"
                    class="py-1 px-2 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between {{ $is15kTo18k ? 'bg-wine-accent text-gold-soft border border-gold-30 fw-semibold' : 'text-muted-parchment text-light-parchment-hover' }}"
                >
                    <span>Rs. 15,000 – Rs. 18,000</span>
                    <i class="fas fa-check text-gold" style="font-size: 8px; {{ $is15kTo18k ? '' : 'visibility: hidden;' }}"></i>
                </a>
                <a 
                    href="{{ $isAbove18k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 18000, 'max_price' => null]) }}"
                    class="py-1 px-2 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between {{ $isAbove18k ? 'bg-wine-accent text-gold-soft border border-gold-30 fw-semibold' : 'text-muted-parchment text-light-parchment-hover' }}"
                >
                    <span>Above Rs. 18,000</span>
                    <i class="fas fa-check text-gold" style="font-size: 8px; {{ $isAbove18k ? '' : 'visibility: hidden;' }}"></i>
                </a>
            </div>

            {{-- Custom Price Range Inputs --}}
            <div class="pt-2 border-top border-gold-10">
                <div class="d-flex align-items-center gap-1.5 mb-1">
                    <input 
                        type="number" 
                        name="min_price" 
                        value="{{ request('min_price') }}" 
                        placeholder="Min" 
                        class="form-control form-control-luxury text-xs py-1.5 px-2 text-center"
                        style="width: calc(50% - 14px);"
                    >
                    <span class="text-muted-parchment" style="font-size: 10px;">to</span>
                    <input 
                        type="number" 
                        name="max_price" 
                        value="{{ request('max_price') }}" 
                        placeholder="Max" 
                        class="form-control form-control-luxury text-xs py-1.5 px-2 text-center"
                        style="width: calc(50% - 14px);"
                    >
                    <button type="submit" class="btn-gold py-1.5 px-2 rounded-2 text-uppercase fw-semibold" style="font-size: 9px; letter-spacing: 0.05em;" title="Apply custom price">
                        Go
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter 4: Signature Notes (Collapsed by default so it doesn't clutter!) --}}
    <div class="border-top border-gold-20 pt-3 mb-3" x-data="{ openNotes: {{ request('note') ? 'true' : 'false' }} }">
        <button 
            type="button" 
            @click="openNotes = !openNotes"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2.5 text-decoration-none"
            aria-label="Toggle Signature Notes"
        >
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-1.5">
                <span>Signature Notes</span>
                @if(request('note'))
                    <span class="badge rounded-pill bg-gold text-wine-dark fw-bold px-1.5 py-0" style="font-size: 9px;">1</span>
                @else
                    <span class="text-muted-parchment" style="font-size: 10px;">({{ count($scentNotes) }})</span>
                @endif
            </span>
            <i class="fas fa-chevron-down text-muted-parchment" :style="openNotes ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px;"></i>
        </button>

        <div x-show="openNotes" x-cloak class="pt-1">
            <div class="d-flex flex-wrap gap-1">
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
    </div>

    {{-- Filter 5: Houses & Categories (Collapsed by default on 'all' so it doesn't clutter!) --}}
    <div class="border-top border-gold-20 pt-3 mb-2" x-data="{ openHouses: {{ $slug !== 'all' ? 'true' : 'false' }} }">
        <button 
            type="button" 
            @click="openHouses = !openHouses"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2.5 text-decoration-none"
            aria-label="Toggle Houses & Categories"
        >
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-1.5">
                <span>Houses & Categories</span>
                @if($slug !== 'all')
                    <span class="badge rounded-pill bg-gold text-wine-dark fw-bold px-1.5 py-0" style="font-size: 9px;">Active</span>
                @endif
            </span>
            <i class="fas fa-chevron-down text-muted-parchment" :style="openHouses ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px;"></i>
        </button>

        <div x-show="openHouses" x-cloak class="pt-1">
            <ul class="list-unstyled mb-0 d-flex flex-column gap-1 text-xs">
                <li>
                    <a href="{{ route('collections.show', 'all') }}" class="d-block py-1 px-2 rounded text-decoration-none {{ $slug === 'all' ? 'text-gold fw-bold bg-wine-accent' : 'text-muted-parchment text-light-parchment-hover' }}">
                        All Impressions
                    </a>
                </li>
                @foreach($allCollections as $col)
                    <li>
                        <a href="{{ route('collections.show', $col->slug) }}" class="d-block py-1 px-2 rounded text-decoration-none {{ $slug === $col->slug ? 'text-gold fw-bold bg-wine-accent' : 'text-muted-parchment text-light-parchment-hover' }}">
                            {{ $col->name }}
                        </a>
                    </li>
                @endforeach
                <li class="pt-1">
                    <a href="{{ route('collections.show', 'bundles') }}" class="d-flex align-items-center justify-content-between py-1 px-2 rounded text-gold-soft fw-semibold text-decoration-none">
                        <span>Curated Bundles</span>
                        <span class="bg-wine-accent text-gold-soft border border-gold-30 px-1.5 py-0-5 rounded fw-bold" style="font-size: 9px;">SAVE 25%</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Sort By (Only for Mobile Drawer where desktop top bar sort is hidden) --}}
    @if(isset($isMobileDrawer) && $isMobileDrawer)
    <div class="border-top border-gold-20 pt-3 mb-3">
        <label class="d-block text-xs text-uppercase tracking-widest text-gold fw-semibold mb-2">
            Sort Masterpieces
        </label>
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
</form>
