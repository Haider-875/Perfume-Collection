@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Sets | Perfumes Collection Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, impression pairings, and discovery coffrets with exclusive savings up to 30% across Pakistan.')

@section('content')

<!-- Bundles Hero Banner -->
<section class="py-5 bg-wine-ticker border-bottom border-gold-30 text-center">
    <div class="container px-3 px-lg-4">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => 'Curated Bundles & Sets']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase;">CURATED PAIRINGS & SIGNATURE SETS</span>
        <h1 class="font-serif text-light-parchment mb-2 fw-normal display-5 tracking-tight">
            Curated Fragrance Bundles
        </h1>
        <p class="mx-auto text-muted-parchment lh-base fw-light mb-0" style="max-width: 672px; font-size: 0.95rem;">
            Curated pairings presented in luxury packaging. Enjoy complimentary presentation boxes and savings of up to 30% across Pakistan.
        </p>
    </div>
</section>

<!-- Bundles Showcase Grid -->
<section class="py-5 border-bottom border-gold-20" style="background-color: #080204;">
    <div class="container px-3 px-lg-4">
        
        <!-- Value Proposition Bar -->
        <div class="row g-4 mb-5 p-4 bg-gradient-wine-ticker border border-gold-25 rounded-4 shadow-xl">
            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle bg-wine-dark border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-5 flex-shrink-0 shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 text-light-parchment fw-medium mb-1">Velvet Presentation Box</h4>
                    <p class="text-xs text-muted-parchment mb-0">Complimentary luxury unboxing experience</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle bg-wine-dark border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-5 flex-shrink-0 shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 text-light-parchment fw-medium mb-1">Guaranteed Savings</h4>
                    <p class="text-xs text-muted-parchment mb-0">Save up to 30% compared to individual bottles</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle bg-wine-dark border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-5 flex-shrink-0 shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-serif fs-6 text-light-parchment fw-medium mb-1">Complimentary Express Air</h4>
                    <p class="text-xs text-muted-parchment mb-0">24-48 Hour insured TCS delivery to all cities</p>
                </div>
            </div>
        </div>

        <!-- Master Bundles List -->
        <div class="d-flex flex-column gap-5">
            @forelse($bundles as $bundle)
                <div class="bg-gradient-wine-ticker border border-gold-30 rounded-4 p-4 p-lg-5 shadow-2xl transition">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="col-12 col-lg-4 position-relative">
                            <div class="position-relative overflow-hidden rounded-3 border border-gold-20 bg-wine-dark p-3 text-center">
                                <img 
                                    src="{{ $bundle->image_url }}" 
                                    alt="{{ $bundle->name }}" 
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';" 
                                    class="img-fluid object-contain mx-auto transition"
                                    style="height: 256px;"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="position-absolute top-0 start-0 m-3 bg-wine-accent text-light-parchment px-3 py-1 text-uppercase fw-bold rounded shadow-sm border border-gold-30" style="font-size: 11px; letter-spacing: 0.05em;">
                                        SAVE RS. {{ number_format($bundle->savings_amount) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="col-12 col-lg-5 d-flex flex-column gap-3">
                            <div>
                                <span class="d-block text-gold fw-semibold" style="font-size: 10px; letter-spacing: 0.3em; text-transform: uppercase;">EXCLUSIVE COFFRET SET</span>
                                <h3 class="font-serif fs-2 text-light-parchment mt-1 fw-normal mb-0">{{ $bundle->name }}</h3>
                                <p class="text-muted-parchment mt-2 lh-base fw-light mb-0" style="font-size: 0.9rem;">
                                    {{ $bundle->description }}
                                </p>
                            </div>

                            <!-- Included Items Preview -->
                            <div class="border-top border-bottom border-gold-20 py-3 my-2">
                                <h5 class="text-gold fw-semibold mb-3" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">
                                    Fragrances Included in Set:
                                </h5>
                                <div class="row g-2">
                                    @if(isset($bundle->items) && $bundle->items->count() > 0)
                                        @foreach($bundle->items as $bItem)
                                            @php $bProd = $bItem->product; @endphp
                                            @if($bProd)
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center gap-2 p-2 bg-wine-dark border border-gold-20 rounded-3">
                                                        <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-contain flex-shrink-0" style="width: 40px; height: 40px;">
                                                        <div class="text-truncate">
                                                            <div class="text-xs fw-semibold text-light-parchment text-truncate">{{ $bProd->name }}</div>
                                                            <div class="text-muted-parchment" style="font-size: 10px;">{{ $bProd->volume_ml ?? 50 }}ml Extrait</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif(isset($bundle->products) && $bundle->products->count() > 0)
                                        @foreach($bundle->products as $bProd)
                                            <div class="col-6">
                                                <div class="d-flex align-items-center gap-2 p-2 bg-wine-dark border border-gold-20 rounded-3">
                                                    <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-contain flex-shrink-0" style="width: 40px; height: 40px;">
                                                    <div class="text-truncate">
                                                        <div class="text-xs fw-semibold text-light-parchment text-truncate">{{ $bProd->name }}</div>
                                                        <div class="text-muted-parchment" style="font-size: 10px;">{{ $bProd->volume_ml }}ml Extrait</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Pricing & Call to Action -->
                        <div class="col-12 col-lg-3 bg-wine-dark border border-gold-30 rounded-3 p-4 text-center d-flex flex-column gap-3 shadow-xl">
                            <div>
                                <span class="d-block text-muted-parchment mb-1 text-uppercase" style="font-size: 10px; letter-spacing: 0.1em;">Bundle Set Price</span>
                                <div class="font-serif fs-3 text-gold-soft fw-bold">
                                    Rs. {{ number_format($bundle->price) }}
                                </div>
                                @if($bundle->original_price > $bundle->price)
                                    <div class="text-xs text-muted-parchment text-decoration-line-through mt-1">
                                        Rs. {{ number_format($bundle->original_price) }}
                                    </div>
                                    <div class="text-gold-soft fw-semibold mt-1" style="font-size: 11px;">
                                        You Save: Rs. {{ number_format($bundle->savings_amount) }} ({{ round((($bundle->original_price - $bundle->price)/$bundle->original_price)*100) }}%)
                                    </div>
                                @endif
                            </div>

                            <button 
                                type="button"
                                onclick="addBundleToCart({{ $bundle->id }})"
                                class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase d-flex align-items-center justify-content-center gap-2 rounded-3"
                            >
                                <i class="fas fa-shopping-bag"></i>
                                <span>ADD BUNDLE TO BAG</span>
                            </button>

                            <a 
                                href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I would like to order the ' . $bundle->name . ' for Rs. ' . number_format($bundle->price) . ' with Cash on Delivery.') }}" 
                                target="_blank" 
                                class="w-100 btn-whatsapp py-2 text-xs tracking-wider d-flex align-items-center justify-content-center gap-2 text-decoration-none rounded-3"
                            >
                                <i class="fab fa-whatsapp"></i>
                                <span>ORDER ON WHATSAPP</span>
                            </a>

                            <div class="text-muted-parchment" style="font-size: 10px;">
                                <i class="fas fa-shield-alt text-gold me-1"></i> 100% Guaranteed Authentic Extrait
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-wine-dark border border-gold-20 rounded-3 p-4">
                    <p class="text-muted-parchment mb-0">No bundles currently active. Check back shortly for seasonal discovery coffrets.</p>
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
