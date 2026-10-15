<form action="{{ url()->current() }}" method="GET" id="{{ $formId ?? 'collectionFilterForm' }}" class="collection-filter-form d-flex flex-column gap-3.5" style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;">
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
    <div class="mb-2">
        <label for="mobileSortSelect" class="d-block text-xs text-uppercase tracking-wider fw-bold mb-1.5" style="color: #211D1E; font-size: 11px; letter-spacing: 0.08em;">
            Sort By
        </label>
        <div class="position-relative">
            <i class="fas fa-arrow-down-short-wide position-absolute top-50 translate-middle-y" style="left: 14px; font-size: 11px; color: #541B29; pointer-events: none; z-index: 2;"></i>
            <select 
                name="sort" 
                id="mobileSortSelect" 
                onchange="this.form.submit()" 
                class="form-select w-100 rounded-3 shadow-xs"
                style="background: linear-gradient(180deg, #FFFFFF 0%, #FAF6F0 100%) !important; border: 1px solid #E2D7CF !important; color: #211D1E !important; font-size: 12px !important; font-weight: 600 !important; height: 44px !important; padding: 8px 36px 8px 36px !important; cursor: pointer; box-shadow: 0 2px 8px rgba(84, 27, 41, 0.06) !important; appearance: none; -webkit-appearance: none; -moz-appearance: none;"
            >
                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured Creations</option>
                <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Most Coveted (Bestsellers)</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
            </select>
            <i class="fas fa-chevron-down position-absolute top-50 translate-middle-y" style="right: 14px; font-size: 10px; color: #541B29; pointer-events: none; z-index: 2;"></i>
        </div>
    </div>
    @endif

    {{-- 1. Top Section: Header & Quick Search --}}
    <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="d-flex align-items-center gap-2" style="color: #541B29; font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase;">
                <i class="fas fa-sliders-h" style="font-size: 12px; color: #541B29;"></i>
                <span>Filter Fragrances</span>
            </span>
            @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                <a href="{{ url()->current() }}" class="text-decoration-none d-inline-flex align-items-center gap-1 transition" style="font-size: 11px; font-weight: 600; color: #541B29;" title="Reset all filters">
                    <i class="fas fa-rotate-left" style="font-size: 10px;"></i>
                    <span>Reset All</span>
                </a>
            @endif
        </div>

        {{-- Search Input with Clean Clear Button --}}
        <div class="position-relative">
            <i class="fas fa-search position-absolute top-50 translate-middle-y" style="left: 12px; font-size: 12px; color: #A89F99; pointer-events: none;"></i>
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search note or impression..." 
                class="form-control rounded-3 shadow-xs"
                style="padding: 9px 34px 9px 34px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; font-size: 12px; height: 40px;"
            >
            @if(request('q'))
                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="position-absolute end-0 top-50 translate-middle-y me-2.5 fs-5 text-decoration-none lh-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; color: #786C67;" title="Clear search">&times;</a>
            @endif
        </div>
    </div>

    {{-- Active Filter Chips --}}
    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
        <div class="pb-2.5" style="border-bottom: 1px solid #E8E0DA;">
            <div class="d-flex flex-wrap gap-1.5">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 11px; font-weight: 500; background-color: #541B29;">
                        <span>"{{ Str::limit(request('q'), 14) }}"</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('family'))
                    @php $activeFam = $fragranceFamilies->firstWhere('slug', request('family')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['family' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 11px; font-weight: 500; background-color: #541B29;">
                        <span>{{ $activeFam ? $activeFam->name : ucfirst(request('family')) }}</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('note'))
                    @php $activeNote = $scentNotes->firstWhere('slug', request('note')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['note' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 11px; font-weight: 500; background-color: #541B29;">
                        <span>Note: {{ $activeNote ? $activeNote->name : ucfirst(str_replace('-', ' ', request('note'))) }}</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('volume_ml'))
                    <a href="{{ request()->fullUrlWithQuery(['volume_ml' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 11px; font-weight: 500; background-color: #541B29;">
                        <span>{{ request('volume_ml') }} ml</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('min_price') || request('max_price'))
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 11px; font-weight: 500; background-color: #541B29;">
                        <span>Rs. {{ request('min_price') ? number_format(request('min_price')) : '0' }} - {{ request('max_price') ? number_format(request('max_price')) : 'Max' }}</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Group 1: Fragrance Family (Primary Filter - Open by default) --}}
    <div class="pt-2.5" style="border-top: 1px solid #E8E0DA;" x-data="{ openFamily: true }">
        <button 
            type="button" 
            @click="openFamily = !openFamily"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Fragrance Family"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Fragrance Family</span>
                @if(request('family'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openFamily ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openFamily" x-cloak class="d-flex flex-column gap-1 pt-1">
            <a 
                href="{{ request()->fullUrlWithQuery(['family' => null]) }}" 
                class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition"
                style="{{ !request('family') ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
            >
                <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                    <i class="fas fa-circle" style="font-size: 6px; color: #541B29; {{ !request('family') ? '' : 'visibility: hidden;' }}"></i>
                    <span>All Families</span>
                </span>
            </a>
            @foreach($fragranceFamilies as $family)
                <a 
                    href="{{ request()->fullUrlWithQuery(['family' => request('family') == $family->slug ? null : $family->slug]) }}" 
                    class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition"
                    style="{{ request('family') == $family->slug ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                        <i class="fas fa-check" style="font-size: 9px; color: #541B29; {{ request('family') == $family->slug ? '' : 'visibility: hidden;' }}"></i>
                        <span>{{ $family->name }}</span>
                    </span>
                    <span class="badge rounded-pill fw-medium" style="background-color: #FAF7F2; color: #786C67; font-size: 11px; border: 1px solid #E8E0DA;">{{ $family->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Group 2: Price (Realistic Extrait brackets + clean custom inputs) --}}
    <div class="pt-2.5" style="border-top: 1px solid #E8E0DA;" x-data="{ openPrice: true }">
        <button 
            type="button" 
            @click="openPrice = !openPrice"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Price"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Price</span>
                @if(request('min_price') || request('max_price'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openPrice ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openPrice" x-cloak class="d-flex flex-column gap-2 pt-1">
            @php
                $isUnder2500 = request('max_price') == '2500' && !request('min_price');
                $is2500To3500 = request('min_price') == '2500' && request('max_price') == '3500';
                $isAbove3500 = request('min_price') == '3500' && !request('max_price');
                $isAllPrices = !request('min_price') && !request('max_price');
            @endphp
            <div class="d-flex flex-column gap-1">
                <a 
                    href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}"
                    class="py-2 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $isAllPrices ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                        <i class="fas fa-circle" style="font-size: 6px; color: #541B29; {{ $isAllPrices ? '' : 'visibility: hidden;' }}"></i>
                        <span>All Prices</span>
                    </span>
                </a>
                <a 
                    href="{{ $isUnder2500 ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => null, 'max_price' => 2500]) }}"
                    class="py-2 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $isUnder2500 ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                        <i class="fas fa-check" style="font-size: 9px; color: #541B29; {{ $isUnder2500 ? '' : 'visibility: hidden;' }}"></i>
                        <span>Under Rs. 2,500</span>
                    </span>
                </a>
                <a 
                    href="{{ $is2500To3500 ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 2500, 'max_price' => 3500]) }}"
                    class="py-2 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $is2500To3500 ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                        <i class="fas fa-check" style="font-size: 9px; color: #541B29; {{ $is2500To3500 ? '' : 'visibility: hidden;' }}"></i>
                        <span>Rs. 2,500 – Rs. 3,500</span>
                    </span>
                </a>
                <a 
                    href="{{ $isAbove3500 ? request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) : request()->fullUrlWithQuery(['min_price' => 3500, 'max_price' => null]) }}"
                    class="py-2 px-2.5 rounded-2 text-decoration-none transition d-flex align-items-center justify-content-between"
                    style="{{ $isAbove3500 ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center gap-2" style="font-size: 12px;">
                        <i class="fas fa-check" style="font-size: 9px; color: #541B29; {{ $isAbove3500 ? '' : 'visibility: hidden;' }}"></i>
                        <span>Above Rs. 3,500</span>
                    </span>
                </a>
            </div>

            {{-- Custom Price Range Inputs --}}
            <div class="pt-2" style="border-top: 1px solid #E8E0DA;">
                <div class="d-flex align-items-center">
                    <input 
                        type="number" 
                        name="min_price" 
                        value="{{ request('min_price') }}" 
                        placeholder="Min (Rs)" 
                        class="form-control text-center rounded-2"
                        style="flex: 1; min-width: 0; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; font-size: 12px; height: 38px;"
                    >
                    <span class="px-1 text-muted" style="font-size: 12px; flex-shrink: 0;">–</span>
                    <input 
                        type="number" 
                        name="max_price" 
                        value="{{ request('max_price') }}" 
                        placeholder="Max (Rs)" 
                        class="form-control text-center rounded-2"
                        style="flex: 1; min-width: 0; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; font-size: 12px; height: 38px;"
                    >
                    <button 
                        type="submit" 
                        class="btn text-white py-1.5 px-3 rounded-2 text-uppercase fw-bold shadow-sm d-flex align-items-center justify-content-center" 
                        style="flex-shrink: 0; margin-left: 10px !important; height: 38px; font-size: 11px; letter-spacing: 0.06em; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; background-color: #7A1C33 !important; border: none !important; color: #FFFFFF !important; box-shadow: 0 4px 12px rgba(122, 28, 51, 0.35) !important;" 
                        title="Apply price range"
                    >
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Group 3: Bottle Size (Segmented Gradient Touch Buttons: 30ml, 50ml, 100ml) --}}
    <div class="pt-2.5 pb-3" style="border-top: 1px solid #E8E0DA;" x-data="{ openVolume: true }">
        <button 
            type="button" 
            @click="openVolume = !openVolume"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Bottle Size"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Bottle Size</span>
                @if(request('volume_ml'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openVolume ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openVolume" x-cloak class="pt-1 pb-2">
            <div class="row g-2 mb-2">
                @foreach([30, 50, 100] as $vol)
                    <div class="col-4">
                        <a 
                            href="{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}"
                            class="d-flex align-items-center justify-content-center w-100 rounded-3 transition text-decoration-none shadow-xs"
                            style="height: 42px; font-size: 12px; {{ request('volume_ml') == $vol ? 'background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: 1px solid #541B29 !important; font-weight: 600; box-shadow: 0 4px 12px rgba(122, 28, 51, 0.35) !important;' : 'background: linear-gradient(180deg, #FFFFFF 0%, #FAF5EF 100%) !important; color: #211D1E !important; border: 1px solid #E8E0DA !important; font-weight: 500; box-shadow: 0 1px 3px rgba(0,0,0,0.03);' }}"
                        >
                            {{ $vol }} ml
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Group 4: Collections Navigation --}}
    <div class="pt-2.5" style="border-top: 1px solid #E8E0DA;" x-data="{ openCollections: {{ $slug !== 'all' ? 'true' : 'false' }} }">
        <button 
            type="button" 
            @click="openCollections = !openCollections"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Collections"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Collections</span>
                @if($slug !== 'all')
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">Active</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openCollections ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openCollections" x-cloak class="pt-1">
            <ul class="list-unstyled mb-0 d-flex flex-column gap-1">
                <li>
                    <a href="{{ route('collections.show', 'all') }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition" style="{{ $slug === 'all' ? 'color: #541B29; font-weight: 600; background-color: #F5EBEF;' : 'color: #554D49;' }}">
                        <span style="font-size: 12px;">All Impressions</span>
                        @if($slug === 'all')
                            <i class="fas fa-check" style="font-size: 9px; color: #541B29;"></i>
                        @endif
                    </a>
                </li>
                @foreach($allCollections as $col)
                    <li>
                        <a href="{{ route('collections.show', $col->slug) }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition" style="{{ $slug === $col->slug ? 'color: #541B29; font-weight: 600; background-color: #F5EBEF;' : 'color: #554D49;' }}">
                            <span style="font-size: 12px;">{{ $col->name }}</span>
                            @if($slug === $col->slug)
                                <i class="fas fa-check" style="font-size: 9px; color: #541B29;"></i>
                            @endif
                        </a>
                    </li>
                @endforeach
                <li class="pt-1">
                    <a href="{{ route('collections.show', 'bundles') }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none" style="color: #541B29; font-weight: 600; background-color: #FAF7F2; border: 1px dashed #541B29;">
                        <span style="font-size: 12px;">Curated Bundles</span>
                        <span class="text-white px-2 py-0.5 rounded-pill fw-bold" style="font-size: 9px; background-color: #541B29; letter-spacing: 0.05em;">SAVE 25%</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</form>
