@extends('layouts.app')

@section('title', 'The Fragrance Vault | RAVAHA Parfums Pakistan')

@section('content')

<!-- Header Breadcrumb & Title -->
<section style="padding: 50px 0 40px; background: #F9FAFB; border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 20px;">
            <div>
                <span class="section-pretitle">ARTISANAL CREATIONS</span>
                <h1 style="font-size: 2.6rem; margin-bottom: 8px; font-family: var(--font-serif); color: #111827;">
                    @if($currentCategory)
                        {{ $currentCategory->name }}
                    @elseif($currentFamily)
                        {{ $currentFamily->name }}
                    @elseif(request('gender'))
                        {{ ucfirst(request('gender')) }} Fragrances
                    @else
                        All Fragrance Impressions
                    @endif
                </h1>
                <p style="font-family: var(--font-serif); font-size: 1.1rem; color: #4B5563; max-width: 600px;">
                    @if($currentCategory)
                        {{ $currentCategory->description }}
                    @else
                        Explore our handcrafted 100% Extrait de Parfums and designer impressions formulated for extraordinary longevity and projection.
                    @endif
                </p>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <span style="font-size: 0.85rem; color: #6B7280;">
                    Showing <strong>{{ $products->total() }}</strong> Artisan Flacons
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Body -->
<section style="padding: 50px 0 90px; background: #FFFFFF;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start;">
            
            <!-- Left: Luxury Olfactory Filter Sidebar -->
            <aside style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 12px; padding: 26px; position: sticky; top: 100px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #E5E7EB; padding-bottom: 14px;">
                    <h3 style="font-size: 0.95rem; color: #111827; display: flex; align-items: center; gap: 8px; font-weight: 700;">
                        <i class="fas fa-sliders-h text-gold"></i> FILTER SCENTS
                    </h3>
                    <a href="{{ route('shop.index') }}" style="font-size: 0.75rem; color: #6B7280; text-decoration: none;">Reset All</a>
                </div>

                <form action="{{ route('shop.index') }}" method="GET" id="catalogFilterForm">
                    <!-- Search Input -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 8px; font-weight: 600;">Keywords / Impressions</label>
                        <div style="position: relative;">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, designer names..." style="width: 100%; background: #F9FAFB; border: 1px solid #D1D5DB; padding: 10px 14px; border-radius: 8px; color: #111827; font-size: 0.85rem;">
                        </div>
                    </div>

                    <!-- Collections / Categories -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 10px; font-weight: 600;">Categories</label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; cursor: pointer; color: {{ !request('category') ? '#B8860B; font-weight: 600;' : '#4B5563;' }}">
                                <span><input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()"> All Categories</span>
                            </label>
                            @foreach($categories as $cat)
                                <label style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; cursor: pointer; color: {{ request('category') == $cat->slug ? '#B8860B; font-weight: 600;' : '#4B5563;' }}">
                                    <span><input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()"> {{ $cat->name }}</span>
                                    <span style="font-size: 0.75rem; color: #9CA3AF;">({{ $cat->active_products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Olfactory Families -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 10px; font-weight: 600;">Fragrance Family</label>
                        <select name="family" onchange="this.form.submit()" style="width: 100%; background: #F9FAFB; border: 1px solid #D1D5DB; padding: 10px 12px; border-radius: 8px; color: #111827; font-size: 0.85rem;">
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
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 10px; font-weight: 600;">Gender Persona</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 6px;">
                            <label style="background: {{ request('gender') == 'Unisex' ? '#FEF3C7' : '#F9FAFB' }}; border: 1px solid {{ request('gender') == 'Unisex' ? '#B8860B' : '#E5E7EB' }}; padding: 8px 4px; border-radius: 8px; text-align: center; font-size: 0.78rem; cursor: pointer; color: #111827; font-weight: {{ request('gender') == 'Unisex' ? '600' : 'normal' }};">
                                <input type="radio" name="gender" value="Unisex" {{ request('gender') == 'Unisex' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Unisex
                            </label>
                            <label style="background: {{ request('gender') == 'Men' ? '#FEF3C7' : '#F9FAFB' }}; border: 1px solid {{ request('gender') == 'Men' ? '#B8860B' : '#E5E7EB' }}; padding: 8px 4px; border-radius: 8px; text-align: center; font-size: 0.78rem; cursor: pointer; color: #111827; font-weight: {{ request('gender') == 'Men' ? '600' : 'normal' }};">
                                <input type="radio" name="gender" value="Men" {{ request('gender') == 'Men' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Men
                            </label>
                            <label style="background: {{ request('gender') == 'Women' ? '#FEF3C7' : '#F9FAFB' }}; border: 1px solid {{ request('gender') == 'Women' ? '#B8860B' : '#E5E7EB' }}; padding: 8px 4px; border-radius: 8px; text-align: center; font-size: 0.78rem; cursor: pointer; color: #111827; font-weight: {{ request('gender') == 'Women' ? '600' : 'normal' }};">
                                <input type="radio" name="gender" value="Women" {{ request('gender') == 'Women' ? 'checked' : '' }} style="display: none;" onchange="this.form.submit()"> Women
                            </label>
                        </div>
                    </div>

                    <!-- Price Range (PKR) -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 10px; font-weight: 600;">Price Range (PKR)</label>
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 10px;">
                            <input type="number" name="min_price" value="{{ request('min_price', 1500) }}" placeholder="Min" style="width: 50%; background: #F9FAFB; border: 1px solid #D1D5DB; padding: 8px; border-radius: 8px; color: #111827; font-size: 0.8rem;">
                            <span style="color: #9CA3AF;">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price', 15000) }}" placeholder="Max" style="width: 50%; background: #F9FAFB; border: 1px solid #D1D5DB; padding: 8px; border-radius: 8px; color: #111827; font-size: 0.8rem;">
                        </div>
                        <button type="submit" class="btn-outline-gold" style="width: 100%; padding: 8px; font-size: 0.75rem; border-radius: 8px;">Apply Price Filter</button>
                    </div>

                    <!-- Key Scent Notes -->
                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #4B5563; margin-bottom: 10px; font-weight: 600;">Signature Note Accord</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px; max-height: 160px; overflow-y: auto;">
                            @foreach($scentNotes as $note)
                                <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                                   class="note-chip" 
                                   style="font-size: 0.72rem; padding: 4px 8px; text-decoration: none; border-radius: 6px; border: 1px solid {{ request('note') == $note->slug ? '#B8860B' : '#E5E7EB' }}; background: {{ request('note') == $note->slug ? '#FEF3C7' : '#F9FAFB' }}; color: #111827;">
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
                <div style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 10px; padding: 14px 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 30px; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
                    <div style="font-size: 0.85rem; color: #4B5563;">
                        Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of {{ $products->total() }} Flacons
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label style="font-size: 0.8rem; color: #6B7280; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600;">Sort By:</label>
                        <select onchange="location = this.value;" style="background: #F9FAFB; border: 1px solid #D1D5DB; padding: 8px 12px; border-radius: 6px; color: #111827; font-size: 0.82rem; font-weight: 600;">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }}>Curated / Featured</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bestsellers</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
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
                    <div style="background: #FFFFFF; border: 1px solid #E5E7EB; padding: 60px 30px; text-align: center; border-radius: 12px;">
                        <i class="fas fa-search text-gold" style="font-size: 3rem; margin-bottom: 20px; display: block; color: #B8860B;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 10px; color: #111827;">No Fragrances Matching Your Criteria</h3>
                        <p style="font-family: var(--font-serif); font-size: 1.1rem; color: #6B7280; margin-bottom: 24px;">
                            We could not find perfumes fitting your specific filter combinations. Try resetting filters or search by impression name.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn-gold" style="padding: 12px 24px; border-radius: 8px;">RESET ALL FILTERS</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
