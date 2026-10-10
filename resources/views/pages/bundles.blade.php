@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Sets | Perfumes Collection Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, impression pairings, and discovery coffrets with exclusive savings up to 30% across Pakistan.')

@section('content')

<!-- 1. Bundles Hero Banner -->
<section class="py-5 text-center position-relative overflow-hidden" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 position-relative z-2">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => 'Curated Bundles & Discovery Sets']
        ]" />

        <div class="mt-2">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29; font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">
                <i class="fas fa-crown" style="color: #9E7D3B;"></i>
                <span>HAUTE PARFUMERIE DISCOVERY COFFRETS</span>
            </span>
            <h1 class="font-hero hero-title text-uppercase mb-2 fw-normal display-5 tracking-tight" style="color: #211D1E;">
                Curated Fragrance Bundles
            </h1>
            <p class="mx-auto lh-base fw-light mb-0 font-sans" style="max-width: 680px; font-size: 0.95rem; color: #6B605B;">
                Master impressions paired into bespoke presentation coffrets. Enjoy complimentary luxury gift boxes, guaranteed multi-bottle savings of up to 30%, and insured free air delivery across Pakistan.
            </p>
        </div>
    </div>
</section>

<!-- 2. Bundles Showcase Section -->
<section class="py-5" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4">
        
        <!-- Value Proposition Highlights Bar -->
        <div class="row g-4 mb-5 p-3 p-md-4 rounded-4 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 fw-medium mb-1" style="color: #211D1E;">Handcrafted Velvet Box</h4>
                    <p class="text-xs mb-0" style="color: #6B605B;">Complimentary royal coffret unboxing experience</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 fw-medium mb-1" style="color: #211D1E;">Guaranteed Savings</h4>
                    <p class="text-xs mb-0" style="color: #6B605B;">Save up to 30% versus purchasing individual flacons</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 fw-medium mb-1" style="color: #211D1E;">Express Air Delivery</h4>
                    <p class="text-xs mb-0" style="color: #6B605B;">24-48h insured TCS express courier with nationwide COD</p>
                </div>
            </div>
        </div>

        <!-- Master Bundles List -->
        <div class="d-flex flex-column gap-5">
            @forelse($bundles as $bundle)
                <div class="bundle-card-master p-4 p-lg-5">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="col-12 col-lg-4 position-relative">
                            <div class="bundle-image-pedestal">
                                <img 
                                    src="{{ $bundle->image_url }}" 
                                    alt="{{ $bundle->name }}" 
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';" 
                                    class="img-fluid object-fit-contain mx-auto"
                                    style="height: 270px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge-savings-luxury shadow-sm">
                                            SAVE RS. {{ number_format($bundle->savings_amount) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0 m-3">
                                    <span class="badge-savings-luxury shadow-sm" style="background-color: #FAF7F2; color: #541B29; border: 1px solid #E8E0DA;">
                                        EXTRAIT SET
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="col-12 col-lg-5 d-flex flex-column gap-3">
                            <div>
                                <span class="d-inline-flex align-items-center gap-1 fw-medium" style="font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: #541B29;">
                                    <i class="fas fa-gem" style="font-size: 9px; color: #9E7D3B;"></i>
                                    <span>EXCLUSIVE SIGNATURE COFFRET</span>
                                </span>
                                <h3 class="font-hero hero-title fs-2 mt-1 fw-normal mb-0" style="color: #211D1E;">{{ $bundle->name }}</h3>
                                <p class="font-sans mt-2 lh-base fw-light mb-0" style="font-size: 0.88rem; color: #4A403A;">
                                    {{ $bundle->tagline ?? $bundle->description }}
                                </p>
                            </div>

                            <!-- Included Items Preview -->
                            <div class="py-3 my-1" style="border-top: 1px solid #E8E0DA; border-bottom: 1px solid #E8E0DA;">
                                <h5 class="fw-semibold mb-2.5 d-flex align-items-center gap-2" style="font-size: 10.5px; letter-spacing: 0.12em; text-transform: uppercase; color: #541B29;">
                                    <i class="fas fa-layer-group" style="color: #9E7D3B;"></i>
                                    <span>Fragrances Included in this Coffret:</span>
                                </h5>
                                <div class="row g-2">
                                    @if(isset($bundle->items) && $bundle->items->count() > 0)
                                        @foreach($bundle->items as $bItem)
                                            @php $bProd = $bItem->product; @endphp
                                            @if($bProd)
                                                <div class="col-12 col-sm-6">
                                                    <div class="bundle-flacon-card d-flex align-items-center gap-2">
                                                        <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-fit-contain flex-shrink-0" style="width: 38px; height: 38px;">
                                                        <div class="text-truncate">
                                                            <div class="text-xs fw-medium text-truncate" style="color: #211D1E;">{{ $bProd->name }}</div>
                                                            <div style="font-size: 10px; font-weight: 400; color: #6B605B;">{{ $bProd->volume_ml ?? 50 }}ml &bull; Extrait de Parfum</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif(isset($bundle->products) && $bundle->products->count() > 0)
                                        @foreach($bundle->products as $bProd)
                                            <div class="col-12 col-sm-6">
                                                <div class="bundle-flacon-card d-flex align-items-center gap-2">
                                                    <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-fit-contain flex-shrink-0" style="width: 38px; height: 38px;">
                                                    <div class="text-truncate">
                                                        <div class="text-xs fw-medium text-truncate" style="color: #211D1E;">{{ $bProd->name }}</div>
                                                        <div style="font-size: 10px; font-weight: 400; color: #6B605B;">{{ $bProd->volume_ml ?? 50 }}ml &bull; Extrait de Parfum</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Pricing & Call to Action -->
                        <div class="col-12 col-lg-3">
                            <div class="bundle-pricing-card text-center d-flex flex-column gap-3 shadow-sm">
                                <div>
                                    <span class="d-block mb-1 text-uppercase fw-medium" style="font-size: 10px; letter-spacing: 0.14em; color: #6B605B;">Special Set Price</span>
                                    <div class="font-hero hero-title fs-2 fw-bold" style="color: #541B29 !important;">
                                        Rs. {{ number_format($bundle->price) }}
                                    </div>
                                    @if($bundle->original_price > $bundle->price)
                                        <div class="text-xs text-decoration-line-through mt-0.5" style="color: #7A6F68;">
                                            Rs. {{ number_format($bundle->original_price) }}
                                        </div>
                                        <div class="mt-1.5">
                                            <span class="badge-savings-luxury" style="font-size: 9px; padding: 2px 8px;">
                                                YOU SAVE RS. {{ number_format($bundle->savings_amount) }} ({{ round((($bundle->original_price - $bundle->price)/$bundle->original_price)*100) }}% OFF)
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="vstack gap-2 pt-1">
                                    <button 
                                        type="button"
                                        onclick="addBundleToCart({{ $bundle->id }})"
                                        class="btn-bundle-bag"
                                    >
                                        <i class="fas fa-shopping-bag"></i>
                                        <span>ADD BUNDLE TO BAG</span>
                                    </button>

                                    <button 
                                        type="button"
                                        onclick="buyBundleNow({{ $bundle->id }})"
                                        class="btn-bundle-buynow"
                                    >
                                        <span>BUY NOW</span>
                                        <i class="fas fa-arrow-right-long btn-arrow"></i>
                                    </button>
                                </div>

                                <div class="pt-1" style="font-size: 9.5px; line-height: 1.4; color: #6B605B; border-top: 1px solid #E8E0DA;">
                                    <i class="fas fa-shield-halved me-1" style="color: #9E7D3B;"></i> 100% Genuine French Oil &bull; Free Shipping
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 rounded-4 p-5 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <i class="fas fa-gem fs-1 mb-3" style="color: #9E7D3B;"></i>
                    <h4 class="font-serif fs-4 mb-2" style="color: #211D1E;">No Active Bundles at this Moment</h4>
                    <p class="mb-4 text-xs font-sans" style="color: #6B605B;">Our private master discovery coffrets are curated seasonally. Browse our full fragrance library in the meantime.</p>
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold px-4 py-2 text-xs text-uppercase rounded-3 text-decoration-none" style="border-radius: 8px;">
                        EXPLORE ALL PERFUMES
                    </a>
                </div>
            @endforelse
        </div>

        @if(method_exists($bundles, 'links') && $bundles->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $bundles->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
