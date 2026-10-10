<div class="d-flex justify-content-between align-items-center pb-3" style="border-bottom: 1px solid #E8E0DA;">
    <h3 class="fw-bold d-flex align-items-center gap-2 mb-0" style="font-size: 12px; letter-spacing: 0.2em; text-transform: uppercase; color: #211D1E;">
        <i class="fas fa-sliders-h" style="color: #541B29;"></i> FILTER SCENTS
    </h3>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('shop.index') }}" class="transition text-decoration-none" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #541B29;">Reset All</a>
        @if(!empty($isMobileDrawer))
            <button type="button" @click="mobileFiltersOpen = false" class="border-0 bg-transparent fs-3 p-0" style="color: #211D1E;" aria-label="Close filters">&times;</button>
        @endif
    </div>
</div>

<form action="{{ route('shop.index') }}" method="GET" id="{{ $formId ?? 'catalogFilterForm' }}" class="d-flex flex-column gap-4">
    <!-- Search Input -->
    <div>
        <label class="d-block fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Keywords / Impressions</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, designer names..." class="form-control py-2 px-3 text-xs rounded-3 shadow-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
    </div>

    <!-- Collections / Categories -->
    <div>
        <label class="d-block fw-semibold mb-3" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Categories</label>
        <div class="d-flex flex-column gap-2">
            <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0" style="font-size: 12px; {{ !request('category') ? 'color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}">
                <span class="d-flex align-items-center gap-2">
                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input m-0"> 
                    All Categories
                </span>
            </label>
            @foreach($categories as $cat)
                <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0" style="font-size: 12px; {{ request('category') == $cat->slug ? 'color: #541B29; font-weight: 600;' : 'color: #6B605B;' }}">
                    <span class="d-flex align-items-center gap-2">
                        <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input m-0"> 
                        {{ $cat->name }}
                    </span>
                    <span style="font-size: 10px; color: #786C67;">({{ $cat->active_products_count }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Olfactory Families -->
    <div>
        <label class="d-block fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Fragrance Family</label>
        <select name="family" onchange="this.form.submit()" class="form-select text-xs py-2 px-3 rounded-3 shadow-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
            <option value="">All Fragrance Families</option>
            @foreach($fragranceFamilies as $fam)
                <option value="{{ $fam->slug }}" {{ request('family') == $fam->slug ? 'selected' : '' }}>
                    {{ $fam->name }} ({{ $fam->products_count }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Gender / Aura -->
    <div>
        <label class="d-block fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Gender Persona</label>
        <div class="row g-1">
            @foreach(['Unisex', 'Men', 'Women'] as $g)
                <div class="col-4">
                    <label class="p-2 rounded-3 text-center cursor-pointer transition d-block w-100 mb-0 shadow-xs" style="font-size: 12px; {{ request('gender') == $g ? 'background-color: #541B29; border: 1px solid #541B29; color: #FFFFFF; font-weight: 600;' : 'background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;' }}">
                        <input type="radio" name="gender" value="{{ $g }}" {{ request('gender') == $g ? 'checked' : '' }} class="d-none" onchange="this.form.submit()">
                        {{ $g }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Price Range (PKR) -->
    <div>
        <label class="d-block fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Price Range (PKR)</label>
        <div class="d-flex gap-2 align-items-center mb-3">
            <input type="number" name="min_price" value="{{ request('min_price', 1500) }}" placeholder="Min" class="form-control text-xs py-2 px-2 text-center rounded-2" style="width: calc(50% - 10px); background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
            <span style="color: #A89F99;">-</span>
            <input type="number" name="max_price" value="{{ request('max_price', 15000) }}" placeholder="Max" class="form-control text-xs py-2 px-2 text-center rounded-2" style="width: calc(50% - 10px); background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
        </div>
        <button type="submit" class="w-100 py-2 text-uppercase fw-semibold text-white shadow-xs" style="font-size: 11px; letter-spacing: 0.05em; background-color: #541B29; border: 1px solid #541B29; border-radius: 8px;">Apply Price Filter</button>
    </div>

    <!-- Key Scent Notes -->
    <div>
        <label class="d-block fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #211D1E;">Signature Note Accord</label>
        <div class="d-flex flex-wrap gap-1 overflow-y-auto no-scrollbar" style="max-height: 160px;">
            @foreach($scentNotes as $note)
                <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                   class="px-2 py-1 rounded transition text-decoration-none shadow-xs"
                   style="font-size: 11px; {{ request('note') == $note->slug ? 'background-color: #541B29; border: 1px solid #541B29; color: #FFFFFF; font-weight: 600;' : 'background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #4A403A;' }}">
                    {{ $note->name }}
                </a>
            @endforeach
        </div>
    </div>
</form>
