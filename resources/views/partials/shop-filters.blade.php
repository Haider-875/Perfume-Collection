<div class="d-flex justify-content-between align-items-center pb-3 border-bottom border-gold-20">
    <h3 class="text-light-parchment fw-bold d-flex align-items-center gap-2 mb-0" style="font-size: 12px; letter-spacing: 0.2em; text-transform: uppercase;">
        <i class="fas fa-sliders-h text-gold"></i> FILTER SCENTS
    </h3>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('shop.index') }}" class="text-muted-parchment text-gold-hover transition text-decoration-none" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Reset All</a>
        @if(!empty($isMobileDrawer))
            <button type="button" @click="mobileFiltersOpen = false" class="border-0 bg-transparent text-ivory fs-3 p-0" aria-label="Close filters">&times;</button>
        @endif
    </div>
</div>

<form action="{{ route('shop.index') }}" method="GET" id="{{ $formId ?? 'catalogFilterForm' }}" class="d-flex flex-column gap-4">
    <!-- Search Input -->
    <div>
        <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Keywords / Impressions</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, designer names..." class="form-control form-control-luxury py-2 px-3 text-xs">
    </div>

    <!-- Collections / Categories -->
    <div>
        <label class="d-block text-gold fw-semibold mb-3" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Categories</label>
        <div class="d-flex flex-column gap-2">
            <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0 {{ !request('category') ? 'text-gold fw-bold' : 'text-light-parchment text-gold-hover' }}" style="font-size: 12px;">
                <span class="d-flex align-items-center gap-2">
                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input bg-transparent border-gold-40 m-0"> 
                    All Categories
                </span>
            </label>
            @foreach($categories as $cat)
                <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0 {{ request('category') == $cat->slug ? 'text-gold fw-bold' : 'text-light-parchment text-gold-hover' }}" style="font-size: 12px;">
                    <span class="d-flex align-items-center gap-2">
                        <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input bg-transparent border-gold-40 m-0"> 
                        {{ $cat->name }}
                    </span>
                    <span class="text-muted-parchment" style="font-size: 10px;">({{ $cat->active_products_count }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Olfactory Families -->
    <div>
        <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Fragrance Family</label>
        <select name="family" onchange="this.form.submit()" class="form-select form-control-luxury text-xs py-2 px-3">
            <option value="" class="bg-wine-dark text-light-parchment">All Fragrance Families</option>
            @foreach($fragranceFamilies as $fam)
                <option value="{{ $fam->slug }}" {{ request('family') == $fam->slug ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">
                    {{ $fam->name }} ({{ $fam->products_count }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Gender / Aura -->
    <div>
        <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Gender Persona</label>
        <div class="row g-1">
            @foreach(['Unisex', 'Men', 'Women'] as $g)
                <div class="col-4">
                    <label class="p-2 border rounded-3 text-center cursor-pointer transition d-block w-100 mb-0 {{ request('gender') == $g ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark border-gold-25 text-light-parchment' }}" style="font-size: 12px;">
                        <input type="radio" name="gender" value="{{ $g }}" {{ request('gender') == $g ? 'checked' : '' }} class="d-none" onchange="this.form.submit()">
                        {{ $g }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Price Range (PKR) -->
    <div>
        <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Price Range (PKR)</label>
        <div class="d-flex gap-2 align-items-center mb-3">
            <input type="number" name="min_price" value="{{ request('min_price', 1500) }}" placeholder="Min" class="form-control form-control-luxury text-xs py-2 px-2 text-center" style="width: calc(50% - 10px);">
            <span class="text-muted-parchment">-</span>
            <input type="number" name="max_price" value="{{ request('max_price', 15000) }}" placeholder="Max" class="form-control form-control-luxury text-xs py-2 px-2 text-center" style="width: calc(50% - 10px);">
        </div>
        <button type="submit" class="w-100 btn-gold py-2 text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.05em;">Apply Price Filter</button>
    </div>

    <!-- Key Scent Notes -->
    <div>
        <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Signature Note Accord</label>
        <div class="d-flex flex-wrap gap-1 overflow-y-auto no-scrollbar" style="max-height: 160px;">
            @foreach($scentNotes as $note)
                <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                   class="px-2 py-1 rounded border transition text-decoration-none {{ request('note') == $note->slug ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark border-gold-20 text-muted-parchment text-gold-hover' }}"
                   style="font-size: 11px;">
                    {{ $note->name }}
                </a>
            @endforeach
        </div>
    </div>
</form>
