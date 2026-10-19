<style>
.collection-search-wrap {
    position: relative;
    width: 100%;
}
.collection-search-input {
    width: 100%;
    height: 32px;
    padding: 5px 28px 5px 30px;
    font-size: 10px !important;
    font-family: 'Poppins', sans-serif !important;
    background: #FAF7F2;
    border: 1px solid #E2D7CF;
    border-radius: 7px;
    color: #211D1E;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
    transition: all 0.2s ease;
}
.collection-search-input:focus {
    background: #FFFFFF;
    border-color: #780D24;
    outline: none;
    box-shadow: 0 0 0 3px rgba(120, 13, 36, 0.1);
}
.collection-search-input::placeholder {
    color: #A89F99;
    font-size: 9.5px !important;
}
.collection-search-icon {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    font-size: 10px;
    color: #780D24;
    pointer-events: none;
}
.collection-search-clear {
    position: absolute;
    top: 50%;
    right: 7px;
    transform: translateY(-50%);
    width: 17px;
    height: 17px;
    border-radius: 50%;
    background: #F0EAE3;
    color: #6B605B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    text-decoration: none;
    line-height: 1;
    transition: all 0.15s ease;
}
.collection-search-clear:hover {
    background: #780D24;
    color: #FFFFFF;
}

.btn-view-compositions {
    background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(120, 13, 36, 0.32) !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    text-decoration: none !important;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    font-family: 'Poppins', sans-serif !important;
    padding: 10px 20px !important;
    min-height: 41px;
    font-size: 11px !important;
    font-weight: 600 !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase;
    border-radius: 8px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    width: 100%;
}
.btn-view-compositions:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(120, 13, 36, 0.48) !important;
    color: #FFFFFF !important;
    filter: brightness(1.08);
}
.btn-view-compositions:active {
    transform: translateY(0);
}

/* Bullet point styling for list items */
.filter-bullet-point {
    width: 8px;
    height: 8px;
    min-width: 8px;
    min-height: 8px;
    border-radius: 50%;
    background-color: #9C8F89;
    display: block;
    flex-shrink: 0;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    outline: none !important;
    transform: none !important;
    box-shadow: none !important;
    transition: background-color 0.2s ease;
}
.filter-item-active .filter-bullet-point {
    background-color: #780D24 !important;
    transform: none !important;
    box-shadow: none !important;
}
.filter-item-link:hover .filter-bullet-point {
    background-color: #780D24;
}

/* Hide scrollbars across filters */
.overflow-y-auto::-webkit-scrollbar,
.collection-filter-form::-webkit-scrollbar,
.mobile-filter-drawer *::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}
.overflow-y-auto,
.collection-filter-form,
.mobile-filter-drawer * {
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}

@media (max-width: 575.98px) {
    .collection-search-input {
        height: 29px !important;
        font-size: 9px !important;
        padding: 4px 24px 4px 26px !important;
        border-radius: 6px !important;
    }
    .collection-search-input::placeholder {
        font-size: 9px !important;
    }
    .collection-search-icon {
        left: 8px !important;
        font-size: 9px !important;
    }
    .collection-search-clear {
        width: 15px !important;
        height: 15px !important;
        font-size: 9.5px !important;
        right: 5px !important;
    }
    .btn-view-compositions {
        padding: 9px 18px !important;
        min-height: 39px;
        font-size: 10.5px !important;
        letter-spacing: 0.08em !important;
    }
}
</style>

<form action="{{ url()->current() }}" method="GET" id="{{ $formId ?? 'collectionFilterForm' }}" class="collection-filter-form d-flex flex-column gap-3" style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;">
    {{-- Preserve active filters as hidden inputs for text/filter submissions --}}
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
        <label for="mobileSortSelect" class="d-block text-xs text-uppercase tracking-wider fw-bold mb-1.5" style="color: #211D1E; font-size: 10.5px; letter-spacing: 0.08em;">
            Sort By
        </label>
        <div class="position-relative">
            <i class="fas fa-arrow-down-short-wide position-absolute top-50 translate-middle-y" style="left: 14px; font-size: 11px; color: #541B29; pointer-events: none; z-index: 2;"></i>
            <select 
                name="sort" 
                id="mobileSortSelect" 
                onchange="this.form.submit()" 
                class="form-select w-100 rounded-3 shadow-xs"
                style="background: linear-gradient(180deg, #FFFFFF 0%, #FAF6F0 100%) !important; border: 1px solid #E2D7CF !important; color: #211D1E !important; font-size: 11.5px !important; font-weight: 600 !important; height: 40px !important; padding: 7px 34px 7px 34px !important; cursor: pointer; box-shadow: 0 2px 8px rgba(84, 27, 41, 0.06) !important; appearance: none; -webkit-appearance: none; -moz-appearance: none;"
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

    {{-- 1. Top Section: Header & Refined Search Input --}}
    <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="d-flex align-items-center gap-1.5" style="color: #541B29; font-size: 10.5px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase;">
                <i class="fas fa-sliders-h" style="font-size: 11px; color: #541B29;"></i>
                <span>Filter Fragrances</span>
            </span>
            @if(request()->hasAny(['family', 'note', 'volume_ml', 'q']))
                <a href="{{ url()->current() }}" class="text-decoration-none d-inline-flex align-items-center gap-1 transition" style="font-size: 10.5px; font-weight: 600; color: #541B29;" title="Reset all filters">
                    <i class="fas fa-rotate-left" style="font-size: 9.5px;"></i>
                    <span>Reset All</span>
                </a>
            @endif
        </div>

        {{-- Luxury Refined Search Input with Mobile Responsive Sizing --}}
        <div class="collection-search-wrap">
            <i class="fas fa-search collection-search-icon"></i>
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search note or impression..." 
                class="collection-search-input"
            >
            @if(request('q'))
                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="collection-search-clear" title="Clear search">&times;</a>
            @endif
        </div>
    </div>

    {{-- Active Filter Chips --}}
    @if(request()->hasAny(['family', 'note', 'volume_ml', 'q']))
        <div class="pb-2" style="border-bottom: 1px solid #E8E0DA;">
            <div class="d-flex flex-wrap gap-1.5">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 10.5px; font-weight: 500; background-color: #541B29;">
                        <span>"{{ Str::limit(request('q'), 14) }}"</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('family'))
                    @php $activeFam = $fragranceFamilies->firstWhere('slug', request('family')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['family' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 10.5px; font-weight: 500; background-color: #541B29;">
                        <span>{{ $activeFam ? $activeFam->name : ucfirst(request('family')) }}</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('note'))
                    @php $activeNote = $scentNotes->firstWhere('slug', request('note')); @endphp
                    <a href="{{ request()->fullUrlWithQuery(['note' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 10.5px; font-weight: 500; background-color: #541B29;">
                        <span>Note: {{ $activeNote ? $activeNote->name : ucfirst(str_replace('-', ' ', request('note'))) }}</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif

                @if(request('volume_ml'))
                    <a href="{{ request()->fullUrlWithQuery(['volume_ml' => null]) }}" class="badge rounded-pill text-decoration-none d-inline-flex align-items-center gap-1.5 px-2.5 py-1 text-white shadow-xs" style="font-size: 10.5px; font-weight: 500; background-color: #541B29;">
                        <span>{{ request('volume_ml') }} ml</span>
                        <i class="fas fa-times" style="font-size: 9px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Group 1: Fragrance Family (Primary Filter - 4 Core Families in the Shop) --}}
    <div class="pt-2" style="border-top: 1px solid #E8E0DA;" x-data="{ openFamily: true }">
        <button 
            type="button" 
            @click="openFamily = !openFamily"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Fragrance Family"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Fragrance Family</span>
                @if(request('family'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openFamily ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openFamily" x-cloak class="d-flex flex-column pt-1.5" style="gap: 8px !important;">
            <a 
                href="{{ request()->fullUrlWithQuery(['family' => null]) }}" 
                class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition filter-item-link {{ !request('family') ? 'filter-item-active' : '' }}"
                style="{{ !request('family') ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
            >
                <span class="d-flex align-items-center" style="font-size: 11.5px; gap: 8px;">
                    <span class="filter-bullet-point"></span>
                    <span>All Families</span>
                </span>
            </a>
            @foreach($fragranceFamilies as $family)
                <a 
                    href="{{ request()->fullUrlWithQuery(['family' => request('family') == $family->slug ? null : $family->slug]) }}" 
                    class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition filter-item-link {{ request('family') == $family->slug ? 'filter-item-active' : '' }}"
                    style="{{ request('family') == $family->slug ? 'background-color: #F5EBEF; color: #541B29; font-weight: 600;' : 'color: #554D49; background-color: transparent;' }}"
                >
                    <span class="d-flex align-items-center" style="font-size: 11.5px; gap: 8px;">
                        <span class="filter-bullet-point"></span>
                        <span>{{ $family->name }}</span>
                    </span>
                    <span class="badge rounded-pill fw-medium" style="background-color: #FAF7F2; color: #786C67; font-size: 10px; border: 1px solid #E8E0DA;">{{ $family->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Group 2: Bottle Size (Compact, Small Luxury Buttons: 30ml, 50ml, 100ml) --}}
    <div class="pt-2 pb-1" style="border-top: 1px solid #E8E0DA;" x-data="{ openVolume: true }">
        <button 
            type="button" 
            @click="openVolume = !openVolume"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Bottle Size"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>Bottle Size</span>
                @if(request('volume_ml'))
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">1</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openVolume ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openVolume" x-cloak class="pt-1 pb-1">
            <div class="d-flex align-items-center mb-1" style="gap: 5px !important;">
                @foreach([30, 50, 100] as $vol)
                    <a 
                        href="{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}"
                        class="d-flex align-items-center justify-content-center flex-fill transition text-decoration-none shadow-xs"
                        style="height: 29px; font-size: 10.5px; border-radius: 6px; {{ request('volume_ml') == $vol ? 'background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; color: #FFFFFF !important; border: 1px solid #541B29 !important; font-weight: 600; box-shadow: 0 2px 8px rgba(120, 13, 36, 0.3) !important;' : 'background: linear-gradient(180deg, #FFFFFF 0%, #FAF6F0 100%) !important; color: #211D1E !important; border: 1px solid #E2D7CF !important; font-weight: 500;' }}"
                    >
                        {{ $vol }} ml
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Group 3: Collections Navigation --}}
    <div class="pt-2" style="border-top: 1px solid #E8E0DA;" x-data="{ openCollections: true }">
        <button 
            type="button" 
            @click="openCollections = !openCollections"
            class="w-100 bg-transparent border-0 p-0 d-flex align-items-center justify-content-between text-start cursor-pointer mb-2 text-decoration-none"
            aria-label="Toggle Collections"
        >
            <span class="d-flex align-items-center gap-1.5" style="color: #211D1E; font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                <span>All Impressions</span>
                @if($slug !== 'all')
                    <span class="badge rounded-pill text-white fw-bold px-1.5 py-0.5" style="font-size: 9px; background-color: #541B29;">Active</span>
                @endif
            </span>
            <i class="fas fa-chevron-down" :style="openCollections ? 'transform: rotate(180deg); transition: transform 0.2s ease;' : 'transition: transform 0.2s ease;'" style="font-size: 10px; color: #A89F99;"></i>
        </button>

        <div x-show="openCollections" x-cloak class="pt-1.5">
            <ul class="list-unstyled mb-0 d-flex flex-column" style="gap: 8px !important;">
                <li>
                    <a href="{{ route('collections.show', 'all') }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition filter-item-link {{ $slug === 'all' ? 'filter-item-active' : '' }}" style="{{ $slug === 'all' ? 'color: #541B29; font-weight: 600; background-color: #F5EBEF;' : 'color: #554D49;' }}">
                        <span class="d-flex align-items-center" style="font-size: 11.5px; gap: 8px;">
                            <span class="filter-bullet-point"></span>
                            <span>All Impressions</span>
                        </span>
                        @if($slug === 'all')
                            <i class="fas fa-check" style="font-size: 8.5px; color: #541B29;"></i>
                        @endif
                    </a>
                </li>
                @foreach($allCollections as $col)
                    <li>
                        <a href="{{ route('collections.show', $col->slug) }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none transition filter-item-link {{ $slug === $col->slug ? 'filter-item-active' : '' }}" style="{{ $slug === $col->slug ? 'color: #541B29; font-weight: 600; background-color: #F5EBEF;' : 'color: #554D49;' }}">
                            <span class="d-flex align-items-center" style="font-size: 11.5px; gap: 8px;">
                                <span class="filter-bullet-point"></span>
                                <span>{{ $col->name }}</span>
                            </span>
                            @if($slug === $col->slug)
                                <i class="fas fa-check" style="font-size: 8.5px; color: #541B29;"></i>
                            @endif
                        </a>
                    </li>
                @endforeach
                <li class="pt-0.5">
                    <a href="{{ route('collections.show', 'bundles') }}" class="d-flex align-items-center justify-content-between py-2 px-2.5 rounded-2 text-decoration-none filter-item-link" style="color: #541B29; font-weight: 600; background-color: #FAF7F2; border: 1px dashed #541B29;">
                        <span class="d-flex align-items-center" style="font-size: 11.5px; gap: 8px;">
                            <span class="filter-bullet-point" style="background-color: #D4AF37;"></span>
                            <span>Curated Bundles</span>
                        </span>
                        <span class="text-white px-2 py-0.5 rounded-pill fw-bold badge-save-gradient" style="font-size: 8.5px; background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; letter-spacing: 0.05em; border: 1px solid rgba(255, 255, 255, 0.35);">SAVE 25%</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Action CTA: View Compositions Button (Desktop Sidebar) --}}
    @if(!isset($isMobileDrawer) || !$isMobileDrawer)
    <div class="pt-2.5">
        <button 
            type="submit" 
            class="btn-view-compositions"
        >
            <span>View Compositions</span>
        </button>
    </div>
    @endif
</form>
