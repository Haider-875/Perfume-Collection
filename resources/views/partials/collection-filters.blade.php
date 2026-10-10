<form action="{{ url()->current() }}" method="GET" id="{{ $formId ?? 'collectionFilterForm' }}" class="collection-filter-form d-flex flex-column gap-3.5">
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

    {{-- Sort By (Only for Mobile Drawer where desktop top bar sort is hidden) --}}
    @if(isset($isMobileDrawer) && $isMobileDrawer)
    <div class="mb-1">
        <label for="mobileSortSelect" class="d-block text-xs text-uppercase tracking-wider fw-semibold mb-1.5 font-sans" style="color: #211D1E;">
            Sort By
        </label>
        <select 
            name="sort" 
            id="mobileSortSelect"
            onchange="this.form.submit()" 
            class="form-select w-100 text-xs py-2 pe-4 ps-2.5 rounded-3 shadow-sm"
            style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;"
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

    {{-- 1. Top Section: Search & Clear All --}}
    <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #541B29;">
                <i class="fas fa-sliders-h" style="font-size: 11px; color: #541B29;"></i>
                <span>Filter Fragrances</span>
            </span>
            @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                <a href="{{ url()->current() }}" class="text-decoration-none font-sans" style="font-size: 11px; letter-spacing: 0.04em; color: #541B29;" title="Reset all filters">
                    <i class="fas fa-rotate-left me-1" style="font-size: 9px;"></i> Reset All
                </a>
            @endif
        </div>

        {{-- Search Input with Clear Button --}}
        <div class="position-relative">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search note or impression..." 
                class="form-control text-xs py-2 ps-3 pe-4 rounded-3 shadow-xs"
                style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;"
            >
            @if(request('q'))
                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="position-absolute end-0 top-50 translate-middle-y me-2 fs-5 text-decoration-none lh-1" style="color: #6B605B;" title="Clear search">&times;</a>
            @endif
        </div>
    </div>

    {{-- Active Filter Chips --}}
    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
        <div class="pb-2.5" style="border-bottom: 1px solid #E8E0DA;">
            <div class="d-flex flex-wrap gap-1">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-white shadow-xs" style="font-size: 10px; background-color: #541B29;">
                        <span>"{{ Str::limit(request('q'), 15) }}"</span>
                        <i class="fas fa-times ms-1" style="font-size: 8px;"></i>
                    </a>
                @endif

                @if(request('family'))
                    @php $activeFam = $fragranceFamilies->firstWhere('slug', request('family')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['family' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-white shadow-xs" style="font-size: 10px; background-color: #541B29;">
                        <span>{{ $activeFam ? $activeFam->name : ucfirst(request('family')) }}</span>
                        <i class="fas fa-times ms-1" style="font-size: 8px;"></i>
                    </a>
                @endif

                @if(request('note'))
                    <a href="{{ request()->fullUrlWithQuery(['note' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-white shadow-xs" style="font-size: 10px; background-color: #541B29;">
                        <span>Note: {{ ucfirst(request('note')) }}</span>
                        <i class="fas fa-times ms-1" style="font-size: 8px;"></i>
                    </a>
                @endif

                @if(request('volume_ml'))
                    <a href="{{ request()->fullUrlWithQuery(['volume_ml' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-white shadow-xs" style="font-size: 10px; background-color: #541B29;">
                        <span>{{ request('volume_ml') }} ml</span>
                        <i class="fas fa-times ms-1" style="font-size: 8px;"></i>
                    </a>
                @endif

                @if(request('min_price') || request('max_price'))
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1 px-2.5 py-1 text-white shadow-xs" style="font-size: 10px; background-color: #541B29;">
                        <span>Rs. {{ request('min_price') ? number_format(request('min_price')) : '0' }} - {{ request('max_price') ? number_format(request('max_price')) : 'Max' }}</span>
                        <i class="fas fa-times ms-1" style="font-size: 8px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Group 1: Fragrance Family (Primary Filter - Open by default) --}}
    <div class="pt-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openFamily: true }">
        <button 
            type="button" 
            @click="openFamily = !openFamily"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Fragrance Family"
        >
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #211D1E;">
                <span>Fragrance Family</span>
                @if(request('family'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openFamily ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openFamily" x-cloak class="d-flex flex-column gap-1 pt-1">
            <a 
                href="{{ request()->fullUrlWithQuery(['family' => null]) }}" 
                class="d-flex align-items-center justify-content-between text-xs py-1.5 px-2.5 rounded-2 text-decoration-none transition"
                style="{{ !request('family') ? 'background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}"
            >
                <span>All Families</span>
            </a>
            @foreach($fragranceFamilies as $family)
                <a 
                    href="{{ request()->fullUrlWithQuery(['family' => request('family') == $family->slug ? null : $family->slug]) }}" 
                    class="d-flex align-items-center justify-content-between text-xs py-1.5 px-2.5 rounded-2 text-decoration-none transition"
                    style="{{ request('family') == $family->slug ? 'background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}"
                >
                    <span class="d-flex align-items-center gap-2">
                        <i class="fas fa-check" style="font-size: 8px; color: #541B29; {{ request('family') == $family->slug ? '' : 'visibility: hidden;' }}"></i>
                        <span>{{ $family->name }}</span>
                    </span>
                    <span style="font-size: 10px; color: #786C67;">({{ $family->products_count }})</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Group 2: Price (Clean presets + compact custom range) --}}
    <div class="pt-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openPrice: true }">
        <button 
            type="button" 
            @click="openPrice = !openPrice"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Price"
        >
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #211D1E;">
                <span>Price</span>
                @if(request('min_price') || request('max_price'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openPrice ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openPrice" x-cloak class="d-flex flex-column gap-2 pt-1">
            @php
                $isUnder15k = request('max_price') == '15000' && !request('min_price');
                $is15kTo18k = request('min_price') == '15000' && request('max_price') == '18000';
                $isAbove18k = request('min_price') == '18000' && !request('max_price');
            @endphp
            <div class="d-flex flex-column gap-1 text-xs font-sans">
                <a 
                    href="{{ $isUnder15k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => null, 'max_price' => 15000]) }}"
                    class="py-1.5 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $isUnder15k ? 'background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}"
                >
                    <span>Under Rs. 15,000</span>
                    <i class="fas fa-check" style="font-size: 8px; color: #541B29; {{ $isUnder15k ? '' : 'visibility: hidden;' }}"></i>
                </a>
                <a 
                    href="{{ $is15kTo18k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 15000, 'max_price' => 18000]) }}"
                    class="py-1.5 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $is15kTo18k ? 'background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}"
                >
                    <span>Rs. 15,000 – Rs. 18,000</span>
                    <i class="fas fa-check" style="font-size: 8px; color: #541B29; {{ $is15kTo18k ? '' : 'visibility: hidden;' }}"></i>
                </a>
                <a 
                    href="{{ $isAbove18k ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 18000, 'max_price' => null]) }}"
                    class="py-1.5 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $isAbove18k ? 'background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}"
                >
                    <span>Above Rs. 18,000</span>
                    <i class="fas fa-check" style="font-size: 8px; color: #541B29; {{ $isAbove18k ? '' : 'visibility: hidden;' }}"></i>
                </a>
            </div>

            {{-- Compact Custom Price Range Inputs --}}
            <div class="pt-2" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex align-items-center gap-1.5">
                    <input 
                        type="number" 
                        name="min_price" 
                        value="{{ request('min_price') }}" 
                        placeholder="Min" 
                        class="form-control text-xs py-1.5 px-2 text-center rounded-2"
                        style="width: calc(50% - 18px); background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;"
                    >
                    <span style="font-size: 10px; color: #A89F99;">–</span>
                    <input 
                        type="number" 
                        name="max_price" 
                        value="{{ request('max_price') }}" 
                        placeholder="Max" 
                        class="form-control text-xs py-1.5 px-2 text-center rounded-2"
                        style="width: calc(50% - 18px); background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;"
                    >
                    <button type="submit" class="btn text-white py-1.5 px-2 rounded-2 text-uppercase fw-semibold shadow-xs" style="font-size: 9px; letter-spacing: 0.05em; background-color: #541B29; border: 1px solid #541B29;" title="Apply price range">
                        Go
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Group 3: Bottle Size (Simple customer-friendly label) --}}
    <div class="pt-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openVolume: true }">
        <button 
            type="button" 
            @click="openVolume = !openVolume"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Bottle Size"
        >
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #211D1E;">
                <span>Bottle Size</span>
                @if(request('volume_ml'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openVolume ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openVolume" x-cloak class="pt-1">
            <div class="row g-2 text-xs font-sans">
                @foreach([10, 50, 100] as $vol)
                    <div class="col-4">
                        <a 
                            href="{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}"
                            class="d-block w-100 py-1.5 text-center rounded-3 transition text-decoration-none shadow-xs"
                            style="{{ request('volume_ml') == $vol ? 'background-color: #541B29; color: #FFFFFF; border: 1px solid #541B29; font-weight: 600;' : 'background-color: #FAF7F2; color: #211D1E; border: 1px solid #E8E0DA;' }}"
                        >
                            {{ $vol }} ml
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Group 4: Scent Notes (Collapsed by default so sidebar remains compact & tidy) --}}
    <div class="pt-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openNotes: {{ request('note') ? 'true' : 'false' }} }">
        <button 
            type="button" 
            @click="openNotes = !openNotes"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Scent Notes"
        >
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #211D1E;">
                <span>Scent Notes</span>
                @if(request('note'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0" style="font-size: 9px; background-color: #541B29;">1</span>
                @else
                    <span style="font-size: 10px; color: #786C67;">({{ count($scentNotes) }})</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openNotes ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #786C67;"></i>
        </button>

        <div x-show="openNotes" x-cloak class="pt-1">
            <div class="d-flex flex-wrap gap-1">
                @foreach($scentNotes as $note)
                    <a 
                        href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                        class="px-2 py-1 rounded-2 transition text-decoration-none font-sans"
                        style="font-size: 11px; {{ request('note') == $note->slug ? 'background-color: #541B29; color: #FFFFFF; border: 1px solid #541B29; font-weight: 600;' : 'background-color: #FAF7F2; color: #4A403A; border: 1px solid #E8E0DA;' }}"
                    >
                        {{ $note->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Group 5: Collections (Collapsed by default on 'all' page) --}}
    <div class="pt-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openCollections: {{ $slug !== 'all' ? 'true' : 'false' }} }">
        <button 
            type="button" 
            @click="openCollections = !openCollections"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Collections"
        >
            <span class="text-xs text-uppercase tracking-wider fw-semibold d-flex align-items-center gap-1.5 font-sans" style="color: #211D1E;">
                <span>Collections</span>
                @if($slug !== 'all')
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0" style="font-size: 9px; background-color: #541B29;">Active</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openCollections ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openCollections" x-cloak class="pt-1">
            <ul class="list-unstyled mb-0 d-flex flex-column gap-1 text-xs font-sans">
                <li>
                    <a href="{{ route('collections.show', 'all') }}" class="d-block py-1.5 px-2.5 rounded-2 text-decoration-none" style="{{ $slug === 'all' ? 'color: #541B29; font-weight: 600; background-color: #FAF7F2;' : 'color: #6B605B;' }}">
                        All Impressions
                    </a>
                </li>
                @foreach($allCollections as $col)
                    <li>
                        <a href="{{ route('collections.show', $col->slug) }}" class="d-block py-1.5 px-2.5 rounded-2 text-decoration-none" style="{{ $slug === $col->slug ? 'color: #541B29; font-weight: 600; background-color: #FAF7F2;' : 'color: #6B605B;' }}">
                            {{ $col->name }}
                        </a>
                    </li>
                @endforeach
                <li class="pt-1">
                    <a href="{{ route('collections.show', 'bundles') }}" class="d-flex align-items-center justify-content-between py-1.5 px-2.5 rounded-2 text-decoration-none" style="color: #541B29; font-weight: 600;">
                        <span>Curated Bundles</span>
                        <span class="text-white px-1.5 py-0.5 rounded fw-bold" style="font-size: 9px; background-color: #541B29;">SAVE 25%</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</form>
