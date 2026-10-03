@extends('layouts.app')

@section('title', 'The Fragrance Vault | Maison d\'Orient Luxury Catalog Pakistan')

@section('content')

<!-- Header Breadcrumb & Title -->
<section style="padding: 50px 0 40px; background: linear-gradient(180deg, #141218 0%, #0A0A0C 100%); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 20px;">
            <div>
                <span class="section-pretitle">THE PRIVATE VAULT</span>
                <h1 style="font-size: 2.8rem; margin-bottom: 8px;">
                    @if($currentCategory)
                        {{ $currentCategory->name }}
                    @elseif($currentFamily)
                        {{ $currentFamily->name }}
                    @elseif(request('gender'))
                        {{ ucfirst(request('gender')) }} Fragrances
                    @else
                        All Olfactory Masterpieces
                    @endif
                </h1>
                <p style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--text-sub); max-width: 600px;">
                    @if($currentCategory)
                        {{ $currentCategory->description }}
                    @else
                        Explore our handcrafted Extrait de Parfums and pure Cambodian agarwood oils formulated for monumental longevity.
                    @endif
                </p>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <span style="font-size: 0.85rem; color: var(--text-muted);">
                    Showing <strong>{{ $products->total() }}</strong> Extrait Flacons
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Body -->
<section style="padding: 50px 0 90px;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start;">
            
            <!-- Left: Luxury Olfactory Filter Sidebar -->
            <aside style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 26px; position: sticky; top: 100px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 14px;">
                    <h3 style="font-size: 1rem; color: var(--gold-champagne); display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-sliders-h text-gold"></i> REVISE AURA
                    </h3>
                    <a href="{{ route('shop.index') }}" style="font-size: 0.75rem; color: var(--text-muted); text-decoration: none;">Reset All</a>
                </div>

                <form action="{{ route('shop.index') }}" method="GET" id="catalogFilterForm">
                    <!-- Search Input -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 8px;">Keywords</label>
                        <div style="position: relative;">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, names..." style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 10px 14px; border-radius: 4px; color: #FFF; font-size: 0.85rem;">
                        </div>
                    </div>

                    <!-- Collections / Categories -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 10px;">Collections</label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; cursor: pointer; color: {{ !request('category') ? 'var(--gold-primary)' : 'var(--text-sub)' }};">
                                <span><input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()"> All Vault Collections</span>
                            </label>
                            @foreach($categories as $cat)
                                <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; cursor: pointer; color: {{ request('category') == $cat->slug ? 'var(--gold-primary)' : 'var(--text-sub)' }};">
                                    <span><input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()"> {{ $cat->name }}</span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted);">({{ $cat->active_products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Olfactory Families -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 10px;">Fragrance Family</label>
                        <select name="family" onchange="this.form.submit()" style="width: 100%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 10px 12px; border-radius: 4px; color: #FFF; font-size: 0.85rem;">
                            <option value="">All Fragrance Families</option>
                            @foreach($fragranceFamilies as $fam)
                                <option value="{{ $fam->slug }}" {{ request('family') == $fam->slug ? 'selected' : '' }}>
                                    {{ $fam->name }} ({{ $fam->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gender / Aura -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 10px;">Gender / Persona</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 6px;">
                            <label style="background: rgba(255,255,255,0.03); border: 1px solid {{ request('gender') == 'Unisex' ? 'var(--gold-primary)' : 'var(--border-subtle)' }}; padding: 8px 4px; border-radius: 4px; text-align: center; font-size: 0.78rem; cursor: pointer; color: var(--text-ivory);">
                                <input type="radio" name="gender" value="Unisex" {{ request('gender') == 'Unisex' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Unisex
                            </label>
                            <label style="background: rgba(255,255,255,0.03); border: 1px solid {{ request('gender') == 'Men' ? 'var(--gold-primary)' : 'var(--border-subtle)' }}; padding: 8px 4px; border-radius: 4px; text-align: center; font-size: 0.78rem; cursor: pointer; color: var(--text-ivory);">
                                <input type="radio" name="gender" value="Men" {{ request('gender') == 'Men' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Men
                            </label>
                            <label style="background: rgba(255,255,255,0.03); border: 1px solid {{ request('gender') == 'Women' ? 'var(--gold-primary)' : 'var(--border-subtle)' }}; padding: 8px 4px; border-radius: 4px; text-align: center; font-size: 0.78rem; cursor: pointer; color: var(--text-ivory);">
                                <input type="radio" name="gender" value="Women" {{ request('gender') == 'Women' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Women
                            </label>
                        </div>
                    </div>

                    <!-- Price Range (PKR) -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 10px;">Price Range (PKR)</label>
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 10px;">
                            <input type="number" name="min_price" value="{{ request('min_price', 5000) }}" placeholder="Min" style="width: 50%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 8px; border-radius: 4px; color: #FFF; font-size: 0.8rem;">
                            <span style="color: var(--text-muted);">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price', 35000) }}" placeholder="Max" style="width: 50%; background: #0E0E12; border: 1px solid var(--border-subtle); padding: 8px; border-radius: 4px; color: #FFF; font-size: 0.8rem;">
                        </div>
                        <button type="submit" class="btn-outline-gold" style="width: 100%; padding: 8px; font-size: 0.75rem;">Apply Price</button>
                    </div>

                    <!-- Key Scent Notes -->
                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 10px;">Signature Note Accord</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px; max-height: 160px; overflow-y: auto;">
                            @foreach($scentNotes as $note)
                                <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                                   class="note-chip" 
                                   style="font-size: 0.72rem; padding: 4px 8px; text-decoration: none; {{ request('note') == $note->slug ? 'border-color: var(--gold-primary); background: rgba(212,175,55,0.2);' : '' }}">
                                    {{ $note->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Right: Products Grid & Top Sort Bar -->
            <div>
                <!-- Top Sorting Bar -->
                <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 30px;">
                    <div style="font-size: 0.85rem; color: var(--text-sub);">
                        Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of {{ $products->total() }} Flacons
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em;">Sort By:</label>
                        <select onchange="location = this.value;" style="background: #0E0E12; border: 1px solid var(--border-subtle); padding: 8px 12px; border-radius: 4px; color: var(--gold-champagne); font-size: 0.82rem; font-weight: 600;">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }}>Curated / Featured</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Hall of Bestsellers</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Patron Rating</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 26px;">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div style="margin-top: 50px; display: flex; justify-content: center;">
                        {{ $products->links() }}
                    </div>
                @else
                    <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); padding: 60px 30px; text-align: center; border-radius: var(--radius-md);">
                        <i class="fas fa-search text-gold" style="font-size: 3rem; margin-bottom: 20px; display: block;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 10px;">No Flacons Matching Your Criteria</h3>
                        <p style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--text-sub); margin-bottom: 24px;">
                            We could not find perfumes fitting your specific filter combinations. Try resetting the filters or speak directly with our Master Parfumeur.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn-gold">RESET ALL FILTERS</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
