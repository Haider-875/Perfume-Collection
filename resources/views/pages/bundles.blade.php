@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Sets | Perfumes Collection Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, impression pairings, and discovery coffrets with exclusive savings up to 30% across Pakistan.')

@section('content')

<style>
.gradient-gold-icon {
    background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}
.bundle-img-responsive {
    height: 270px;
}
.prop-icon-circle {
    width: 48px;
    height: 48px;
}
.prop-heading {
    font-size: 0.95rem;
}
.prop-text {
    font-size: 0.78rem;
}
.btn-view-inside {
    background: linear-gradient(135deg, #FFFFFF 0%, #FAF5EE 100%);
    border: 1px solid rgba(212, 175, 55, 0.45) !important;
    color: #541B29;
    padding: 7px 14px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.04em;
    box-shadow: 0 2px 6px rgba(84, 27, 41, 0.04);
    transition: all 0.25s ease;
    cursor: pointer;
}
.btn-view-inside:hover,
.btn-view-inside:active {
    background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%);
    border-color: #541B29 !important;
    box-shadow: 0 3px 10px rgba(84, 27, 41, 0.08);
}
.btn-view-inside.is-open {
    background: linear-gradient(135deg, #F5EBEF 0%, #FAF4EB 100%);
    border-color: #780D24 !important;
}

/* Included Items Preview: Always visible on Desktop (>=992px), Collapsible on Mobile (<992px) */
@media (min-width: 992px) {
    .btn-view-inside {
        display: none !important;
    }
    .bundle-included-wrap {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
    }
}
@media (max-width: 991.98px) {
    .btn-view-inside {
        display: flex !important;
    }
    .bundle-included-wrap {
        display: none;
    }
    .bundle-included-wrap.is-expanded {
        display: block !important;
        animation: bundleFadeSlide 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
}
@keyframes bundleFadeSlide {
    from {
        opacity: 0;
        transform: translateY(-6px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.badge-pill-chip {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%);
    border: 1px solid #EAD8B8;
}
/* Clickable Flacon Cards */
.flacon-clickable {
    cursor: pointer;
    transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    touch-action: manipulation;
    -webkit-tap-highlight-color: rgba(84, 27, 41, 0.08);
}
.flacon-clickable:hover {
    transform: translateY(-2px);
    border-color: #D4AF37 !important;
    background: linear-gradient(135deg, #FFFFFF 0%, #FAF5EE 100%) !important;
    box-shadow: 0 4px 14px rgba(84, 27, 41, 0.1) !important;
}
.flacon-clickable:active {
    transform: scale(0.985);
}
.badge-price-tap {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(84, 27, 41, 0.06);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
    border: 1px solid rgba(84, 27, 41, 0.08);
}
.flacon-clickable:hover .badge-price-tap {
    background: #541B29;
    border-color: #541B29;
}
.flacon-clickable:hover .badge-price-tap i {
    -webkit-text-fill-color: #FFFFFF !important;
    color: #FFFFFF !important;
}
.flacon-direct-link {
    cursor: pointer;
    z-index: 2;
}
.flacon-direct-link:hover {
    background: #D4AF37 !important;
    border-color: #D4AF37 !important;
}
.flacon-direct-link:hover i {
    color: #FFFFFF !important;
    -webkit-text-fill-color: #FFFFFF !important;
}

/* Flacon Price Popup Modal - Product Page Typography & Generous Spacing */
.flacon-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(17, 13, 14, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    overscroll-behavior: contain;
    touch-action: none;
    animation: fModalFadeIn 0.2s ease-out;
}
@keyframes fModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.flacon-modal-dialog {
    background: linear-gradient(145deg, #FFFFFF 0%, #FAF6F0 100%);
    border: 1px solid rgba(212, 175, 55, 0.45);
    border-radius: 18px;
    max-width: 440px;
    width: 100%;
    padding: 1.4rem;
    position: relative;
    box-shadow: 0 20px 50px rgba(84, 27, 41, 0.25), 0 4px 16px rgba(0,0,0,0.1);
    animation: fModalSlideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    max-height: 90vh;
    overflow-y: auto;
    overscroll-behavior: contain;
    touch-action: auto;
}
@keyframes fModalSlideUp {
    from { transform: translateY(16px) scale(0.97); opacity: 0; }
    to { transform: translateY(0) scale(1); opacity: 1; }
}
.flacon-modal-close-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #E8E0DA;
    background: #FAF7F2;
    color: #541B29;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s ease;
    flex-shrink: 0;
    padding: 0;
    line-height: 1;
}
.flacon-modal-close-btn:hover {
    background: #541B29;
    color: #FFFFFF;
    border-color: #541B29;
    transform: rotate(90deg);
}

.fmodal-header-badge {
    background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%);
    border: 1px solid #EAD8B8;
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: #541B29;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 50px;
    margin-left: 6px;
    margin-right: 14px;
    display: inline-flex;
    align-items: center;
    line-height: 1.25;
}

/* Modal Identity Card Typography (Matching Product Page) */
.fmodal-identity-card {
    background: #FFFFFF;
    border: 1px solid #E8E0DA;
    border-radius: 14px;
    padding: 0.95rem;
    margin-bottom: 0.9rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    overflow: hidden;
}
.fmodal-img-wrap {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: #FAF7F2;
    border: 1px solid #ECE4DC;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 4px;
}
.fmodal-img-wrap img {
    max-height: 52px;
    max-width: 52px;
    object-fit: contain;
    filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.08));
}
.fmodal-title {
    font-family: 'Wasted Vindey', 'Cormorant Garamond', Georgia, serif !important;
    font-size: 1.25rem !important;
    font-weight: 500 !important;
    line-height: 1.5 !important;
    color: #110D0E !important;
    margin: 0 0 6px 0 !important;
    word-break: normal;
    overflow-wrap: break-word;
    letter-spacing: 0.01em;
}
.fmodal-tagline {
    font-family: 'Poppins', sans-serif !important;
    font-style: italic !important;
    font-weight: 300 !important;
    font-size: 11px !important;
    line-height: 1.65 !important;
    color: #541B29 !important;
    margin: 0 0 10px 0 !important;
    word-break: normal;
    overflow-wrap: break-word;
}
.fmodal-concentration-badge {
    font-family: 'Poppins', sans-serif !important;
    font-size: 9px !important;
    font-weight: 600 !important;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    background: #541B29;
    color: #FFFFFF;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-block;
    line-height: 1.3;
    margin-top: 2px;
}

/* Callout Box */
.fmodal-callout-box {
    background: linear-gradient(135deg, rgba(84, 27, 41, 0.04) 0%, rgba(212, 154, 61, 0.1) 100%);
    border: 1px dashed rgba(212, 175, 55, 0.6);
    border-radius: 12px;
    padding: 0.95rem 1.05rem;
    margin-bottom: 1rem;
    font-family: 'Poppins', sans-serif !important;
    font-size: 11px;
    line-height: 1.7;
    color: #541B29;
}

@media (max-width: 575.98px) {
    .flacon-modal-dialog {
        padding: 1.15rem 1rem !important;
        border-radius: 16px !important;
        margin: 0.75rem !important;
        max-width: calc(100% - 1.5rem) !important;
    }
    .fmodal-identity-card {
        padding: 0.85rem 0.8rem !important;
        margin-bottom: 0.85rem !important;
    }
    .fmodal-title {
        font-size: 1.15rem !important;
        line-height: 1.45 !important;
        margin-bottom: 6px !important;
    }
    .fmodal-tagline {
        font-size: 10.5px !important;
        line-height: 1.6 !important;
        margin-bottom: 8px !important;
    }
    .fmodal-callout-box {
        padding: 0.8rem 0.9rem !important;
        font-size: 10.5px !important;
        line-height: 1.65 !important;
        margin-bottom: 0.85rem !important;
    }
}

/* Standalone Sizes Section */
.fmodal-sizes-header {
    font-family: 'Poppins', sans-serif !important;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.65rem;
}
.fmodal-sizes-heading {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #541B29;
    line-height: 1.3;
}
.fmodal-sizes-subheading {
    font-size: 9.5px;
    color: #7A6F68;
    line-height: 1.3;
}

.size-card {
    background: #FFFFFF;
    border: 1px solid #E8E0DA;
    border-radius: 12px;
    padding: 0.65rem 0.5rem;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    font-family: 'Poppins', sans-serif !important;
}
.size-card.is-coffret-highlight {
    background: linear-gradient(145deg, #FFFFFF 0%, #FAF4EB 100%);
    border: 1.5px solid #D4AF37;
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.18);
}
.coffret-chip {
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%);
    color: #FFFFFF;
    padding: 2.5px 6px;
    border-radius: 4px;
    display: inline-block;
    line-height: 1.2;
}
.size-tier-chip {
    font-size: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background: #F0EAE3;
    color: #6B605B;
    padding: 2.5px 6px;
    border-radius: 4px;
    display: inline-block;
    line-height: 1.2;
}
.size-volume {
    font-size: 13px;
    font-weight: 700;
    color: #110D0E;
    line-height: 1.35;
    margin-top: 5px;
}
.size-price {
    font-size: 13px;
    font-weight: 700;
    color: #780D24;
    line-height: 1.35;
    margin: 2px 0;
}
.size-label {
    font-size: 9px;
    color: #7A6F68;
    line-height: 1.25;
}

/* Full Width Button */
.fmodal-btn-view {
    font-family: 'Poppins', sans-serif !important;
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 10px 16px;
    border-radius: 10px;
    display: block;
    width: 100%;
    text-align: center;
    text-decoration: none;
    line-height: 1.3;
}
@media (max-width: 576px) {
    .flacon-modal-dialog {
        padding: 1.1rem;
        border-radius: 16px;
    }
    .fmodal-title {
        font-size: 1.15rem !important;
        line-height: 1.45 !important;
        margin-bottom: 5px !important;
    }
    .fmodal-tagline {
        font-size: 10.5px !important;
        line-height: 1.55 !important;
        margin-bottom: 7px !important;
    }
    .size-volume,
    .size-price {
        font-size: 11.5px;
    }
}
@media (max-width: 991.98px) {
    .bundle-img-responsive {
        height: 190px !important;
    }
    .bundle-card-master {
        padding: 1.1rem !important;
        border-radius: 14px !important;
    }
    .bundle-image-pedestal {
        padding: 1rem !important;
        border-radius: 12px !important;
    }
    .prop-icon-circle {
        width: 38px !important;
        height: 38px !important;
    }
    .prop-heading {
        font-size: 13px !important;
    }
    .prop-text {
        font-size: 10.5px !important;
        line-height: 1.35 !important;
    }
    .value-prop-bar {
        padding: 0.85rem !important;
    }
}
</style>

<!-- 1. Bundles Hero Banner -->
<section class="py-5 overflow-hidden" style="background: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')]
        ]" />

        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif mb-3 fw-normal display-5 tracking-wide" style="color: #211D1E !important;">
            Curated Fragrance Bundles
        </h1>
        <p class="mx-auto lh-base mb-0" style="max-width: 672px; font-size: 0.95rem; color: #6B605B;">
            Master impressions paired into bespoke presentation coffrets. Enjoy complimentary luxury gift boxes, guaranteed multi-bottle savings of up to 30%, and insured free air delivery across Pakistan.
        </p>
    </div>
</section>

<!-- 2. Bundles Showcase Section -->
<section class="py-4 py-lg-5" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 d-flex flex-column">

        <!-- Master Bundles List (On mobile appears first, on desktop appears after value proposition) -->
        <div class="order-1 order-lg-2 d-flex flex-column gap-4 gap-lg-5 mb-4 mb-lg-5">
            @forelse($bundles as $bundle)
                @php
                    $itemsCount = ($bundle->items && $bundle->items->count()) 
                        ? $bundle->items->count() 
                        : (($bundle->products && $bundle->products->count()) ? $bundle->products->count() : 2);
                @endphp
                <div class="bundle-card-master p-3 p-md-4 p-lg-5">
                    <div class="row g-3 g-lg-4 align-items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="col-12 col-lg-4 position-relative">
                            <div class="bundle-image-pedestal" onclick="toggleBundleIncluded(this)" style="cursor: pointer;" title="Click to view coffret details">
                                <img 
                                    src="{{ $bundle->image_url }}" 
                                    alt="{{ $bundle->name }}" 
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';" 
                                    class="img-fluid object-fit-contain mx-auto bundle-img-responsive"
                                    style="filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="position-absolute top-0 start-0 m-2.5 m-md-3">
                                        <span class="product-badge badge-discount badge-save-gradient text-white fw-bold rounded-pill shadow-sm" style="font-size: 9.5px; width: fit-content; background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; border: 1px solid rgba(255, 255, 255, 0.4) !important; padding: 3px 9px; box-shadow: 0 2px 8px rgba(120, 13, 36, 0.32), 0 1px 3px rgba(212, 154, 61, 0.22) !important;">
                                            SAVE RS. {{ number_format($bundle->savings_amount) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0 m-2.5 m-md-3">
                                    <span class="product-badge badge-featured text-white fw-bold text-uppercase rounded-pill shadow-sm" style="font-size: 9.5px; background: linear-gradient(135deg, #780D24 0%, #541B29 45%, #B45309 100%) !important; border: 1px solid rgba(255, 255, 255, 0.4) !important; padding: 3px 9px; box-shadow: 0 2px 8px rgba(84, 27, 41, 0.35) !important; letter-spacing: 0.05em;">
                                        ★ {{ $bundle->badge_text ?? 'EXTRAIT SET' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="col-12 col-lg-5 d-flex flex-column gap-2 gap-lg-3">
                            <div onclick="toggleBundleIncluded(this)" style="cursor: pointer;">
                                <span class="d-inline-flex align-items-center gap-1.5 fw-medium" style="font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: #541B29;">
                                    <i class="fas fa-gem gradient-gold-icon" style="font-size: 10px;"></i>
                                    <span>EXCLUSIVE SIGNATURE COFFRET</span>
                                </span>
                                <h3 class="font-hero hero-title fs-3 fs-lg-2 mt-1 fw-normal mb-1" style="color: #211D1E;">{{ $bundle->name }}</h3>
                                <p class="font-sans lh-base fw-light mb-0" style="font-size: 0.88rem; color: #4A403A;">
                                    {{ $bundle->tagline ?? $bundle->description }}
                                </p>
                            </div>

                            <!-- Mobile Collapsible Trigger Button / Badge -->
                            <button 
                                type="button" 
                                onclick="toggleBundleIncluded(this)"
                                class="btn-view-inside w-100 align-items-center justify-content-between"
                                data-items-count="{{ $itemsCount }}"
                                aria-label="Toggle fragrances included"
                                aria-expanded="false"
                            >
                                <span class="d-flex align-items-center gap-2">
                                    <span class="badge-pill-chip flex-shrink-0">
                                        <i class="fas fa-sparkles gradient-gold-icon" style="font-size: 10px;"></i>
                                    </span>
                                    <span class="text-uppercase btn-view-inside-label" style="font-size: 10.5px; font-weight: 600; letter-spacing: 0.05em;">
                                        View What's Inside ({{ $itemsCount }} Fragrances)
                                    </span>
                                </span>
                                <span class="badge-pill-chip flex-shrink-0 transition btn-view-inside-chevron">
                                    <i class="fas fa-chevron-down" style="font-size: 8.5px; color: #541B29;"></i>
                                </span>
                            </button>

                            <!-- Included Items Preview (Always visible on Desktop, Collapsible on Mobile) -->
                            <div 
                                class="bundle-included-wrap py-2.5 py-lg-3 my-1"
                                style="border-top: 1px solid #E8E0DA; border-bottom: 1px solid #E8E0DA;"
                            >
                                <h5 class="fw-semibold mb-2.5 d-flex align-items-center gap-2" style="font-size: 10.5px; letter-spacing: 0.12em; text-transform: uppercase; color: #541B29; margin-top: 5px; padding-top: 3px;">
                                    <i class="fas fa-layer-group gradient-gold-icon" style="font-size: 11px;"></i>
                                    <span>Fragrances Included in this Coffret:</span>
                                </h5>
                                <div class="row g-2">
                                    @if(isset($bundle->items) && $bundle->items->count() > 0)
                                        @foreach($bundle->items as $bItem)
                                            @php 
                                                $bProd = $bItem->product; 
                                                if($bProd) {
                                                    $sizesList = [];
                                                    if ($bProd->variants && $bProd->variants->count() > 0) {
                                                        foreach ($bProd->variants as $v) {
                                                            $sizesList[] = [
                                                                'size' => $v->volume_ml ? $v->volume_ml . 'ml' : ($v->name ?: '50ml'),
                                                                'price' => (float)$v->price,
                                                                'formatted' => 'Rs. ' . number_format($v->price),
                                                                'is_coffret_size' => ((int)$v->volume_ml === (int)($bProd->volume_ml ?? 50))
                                                            ];
                                                        }
                                                    } elseif ($bProd->prices && $bProd->prices->count() > 0) {
                                                        foreach ($bProd->prices as $pr) {
                                                            $sizesList[] = [
                                                                'size' => $pr->size,
                                                                'price' => (float)$pr->price,
                                                                'formatted' => 'Rs. ' . number_format($pr->price),
                                                                'is_coffret_size' => (str_contains($pr->size, (string)($bProd->volume_ml ?? 50)))
                                                            ];
                                                        }
                                                    }
                                                    if (empty($sizesList)) {
                                                        $baseP = (float)($bProd->price ?: 2500);
                                                        $sizesList = [
                                                            ['size' => '30ml', 'price' => 1350, 'formatted' => 'Rs. 1,350', 'is_coffret_size' => false],
                                                            ['size' => '50ml', 'price' => $baseP, 'formatted' => 'Rs. ' . number_format($baseP), 'is_coffret_size' => true],
                                                            ['size' => '100ml', 'price' => round($baseP * 1.7 / 100) * 100, 'formatted' => 'Rs. ' . number_format(round($baseP * 1.7 / 100) * 100), 'is_coffret_size' => false],
                                                        ];
                                                    }
                                                    $prodPayload = [
                                                        'name' => $bProd->name,
                                                        'tagline' => $bProd->tagline ?? ($bProd->impression_of ? 'Impression of ' . $bProd->impression_of : 'Haute Parfumerie Extrait'),
                                                        'image' => $bProd->primary_image_url,
                                                        'url' => route('shop.show', $bProd->slug),
                                                        'concentration' => $bProd->concentration ?? 'Extrait de Parfum',
                                                        'bundle_name' => $bundle->name,
                                                        'bundle_price' => 'Rs. ' . number_format($bundle->price),
                                                        'sizes' => $sizesList
                                                    ];
                                                }
                                            @endphp
                                            @if($bProd)
                                                <div class="col-12 col-sm-6">
                                                    <div 
                                                        class="bundle-flacon-card d-flex align-items-center gap-2 p-1.5 flacon-clickable" 
                                                        style="border-radius: 8px; cursor: pointer; touch-action: manipulation;"
                                                        role="button"
                                                        tabindex="0"
                                                        data-flacon="{{ json_encode($prodPayload) }}"
                                                        data-url="{{ route('shop.show', $bProd->slug) }}"
                                                        onclick="handleFlaconCardClick(this, event)"
                                                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { handleFlaconCardClick(this, event); }"
                                                        title="View {{ $bProd->name }} details & prices"
                                                    >
                                                        <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-fit-contain flex-shrink-0 rounded-1" style="width: 32px; height: 32px; background: #FAF7F2; pointer-events: none;">
                                                        <div class="text-truncate flex-grow-1" style="pointer-events: none;">
                                                            <div class="fw-medium text-truncate" style="color: #211D1E; font-size: 10.5px; line-height: 1.25;">{{ $bProd->name }}</div>
                                                            <div style="font-size: 9px; font-weight: 400; color: #786C67; line-height: 1.2;">{{ $bProd->volume_ml ?? 50 }}ml &bull; Extrait de Parfum</div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                            <span class="badge-price-tap" title="View standalone bottle prices" style="pointer-events: none;">
                                                                <i class="fas fa-tag gradient-gold-icon" style="font-size: 9.5px;"></i>
                                                            </span>
                                                            <a href="{{ route('shop.show', $bProd->slug) }}" 
                                                               class="badge-price-tap flacon-direct-link" 
                                                               onclick="event.stopPropagation();" 
                                                               title="Open {{ $bProd->name }} page"
                                                               aria-label="Open perfume product page">
                                                                <i class="fas fa-arrow-up-right-from-square" style="font-size: 8.5px; color: #541B29;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif(isset($bundle->products) && $bundle->products->count() > 0)
                                        @foreach($bundle->products as $bProd)
                                            @php
                                                $sizesList = [];
                                                if ($bProd->variants && $bProd->variants->count() > 0) {
                                                    foreach ($bProd->variants as $v) {
                                                        $sizesList[] = [
                                                            'size' => $v->volume_ml ? $v->volume_ml . 'ml' : ($v->name ?: '50ml'),
                                                            'price' => (float)$v->price,
                                                            'formatted' => 'Rs. ' . number_format($v->price),
                                                            'is_coffret_size' => ((int)$v->volume_ml === (int)($bProd->volume_ml ?? 50))
                                                        ];
                                                    }
                                                } elseif ($bProd->prices && $bProd->prices->count() > 0) {
                                                    foreach ($bProd->prices as $pr) {
                                                        $sizesList[] = [
                                                            'size' => $pr->size,
                                                            'price' => (float)$pr->price,
                                                            'formatted' => 'Rs. ' . number_format($pr->price),
                                                            'is_coffret_size' => (str_contains($pr->size, (string)($bProd->volume_ml ?? 50)))
                                                        ];
                                                    }
                                                }
                                                if (empty($sizesList)) {
                                                    $baseP = (float)($bProd->price ?: 2500);
                                                    $sizesList = [
                                                        ['size' => '30ml', 'price' => 1350, 'formatted' => 'Rs. 1,350', 'is_coffret_size' => false],
                                                        ['size' => '50ml', 'price' => $baseP, 'formatted' => 'Rs. ' . number_format($baseP), 'is_coffret_size' => true],
                                                        ['size' => '100ml', 'price' => round($baseP * 1.7 / 100) * 100, 'formatted' => 'Rs. ' . number_format(round($baseP * 1.7 / 100) * 100), 'is_coffret_size' => false],
                                                    ];
                                                }
                                                $prodPayload = [
                                                    'name' => $bProd->name,
                                                    'tagline' => $bProd->tagline ?? ($bProd->impression_of ? 'Impression of ' . $bProd->impression_of : 'Haute Parfumerie Extrait'),
                                                    'image' => $bProd->primary_image_url,
                                                    'url' => route('shop.show', $bProd->slug),
                                                    'concentration' => $bProd->concentration ?? 'Extrait de Parfum',
                                                    'bundle_name' => $bundle->name,
                                                    'bundle_price' => 'Rs. ' . number_format($bundle->price),
                                                    'sizes' => $sizesList
                                                ];
                                            @endphp
                                            <div class="col-12 col-sm-6">
                                                <div 
                                                    class="bundle-flacon-card d-flex align-items-center gap-2 p-1.5 flacon-clickable" 
                                                    style="border-radius: 8px; cursor: pointer; touch-action: manipulation;"
                                                    role="button"
                                                    tabindex="0"
                                                    data-flacon="{{ json_encode($prodPayload) }}"
                                                    data-url="{{ route('shop.show', $bProd->slug) }}"
                                                    onclick="handleFlaconCardClick(this, event)"
                                                    onkeydown="if(event.key === 'Enter' || event.key === ' ') { handleFlaconCardClick(this, event); }"
                                                    title="View {{ $bProd->name }} details & prices"
                                                >
                                                    <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid object-fit-contain flex-shrink-0 rounded-1" style="width: 32px; height: 32px; background: #FAF7F2; pointer-events: none;">
                                                    <div class="text-truncate flex-grow-1" style="pointer-events: none;">
                                                        <div class="fw-medium text-truncate" style="color: #211D1E; font-size: 10.5px; line-height: 1.25;">{{ $bProd->name }}</div>
                                                        <div style="font-size: 9px; font-weight: 400; color: #786C67; line-height: 1.2;">{{ $bProd->volume_ml ?? 50 }}ml &bull; Extrait de Parfum</div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                        <span class="badge-price-tap" title="View standalone bottle prices" style="pointer-events: none;">
                                                            <i class="fas fa-tag gradient-gold-icon" style="font-size: 9.5px;"></i>
                                                        </span>
                                                        <a href="{{ route('shop.show', $bProd->slug) }}" 
                                                           class="badge-price-tap flacon-direct-link" 
                                                           onclick="event.stopPropagation();" 
                                                           title="Open {{ $bProd->name }} page"
                                                           aria-label="Open perfume product page">
                                                            <i class="fas fa-arrow-up-right-from-square" style="font-size: 8.5px; color: #541B29;"></i>
                                                        </a>
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
                            <div class="bundle-pricing-card text-center d-flex flex-column gap-3 shadow-sm p-3 p-lg-4">
                                <div>
                                    <span class="d-block mb-1 text-uppercase fw-medium" style="font-size: 10px; letter-spacing: 0.14em; color: #6B605B;">Special Set Price</span>
                                    <div class="d-flex align-items-baseline justify-content-center gap-2 flex-wrap mb-1">
                                        <span class="font-hero hero-title fs-2 fw-bold lh-1" style="color: #541B29 !important;">
                                            Rs. {{ number_format($bundle->price) }}
                                        </span>
                                        @if($bundle->original_price > $bundle->price)
                                            <del class="text-decoration-line-through" style="color: #7A6F68; font-size: 13px; font-weight: 400;">
                                                Rs. {{ number_format($bundle->original_price) }}
                                            </del>
                                        @endif
                                    </div>
                                    @if($bundle->original_price > $bundle->price)
                                        <div class="mt-1">
                                            <span class="badge-savings-luxury badge-save-gradient" style="font-size: 9px; padding: 2.5px 10px; background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; border: 1px solid rgba(255, 255, 255, 0.35) !important;">
                                                YOU SAVE RS. {{ number_format($bundle->savings_amount) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="vstack gap-2 pt-1">
                                    <button 
                                        type="button"
                                        onclick="addBundleToCart({{ $bundle->id }}, this)"
                                        class="btn-bundle-bag d-flex align-items-center justify-content-center gap-2"
                                    >
                                        <i class="fas fa-cart-shopping text-white btn-cart-icon flex-shrink-0" style="font-size: 13px;" aria-hidden="true"></i>
                                        <span>ADD BUNDLE</span>
                                    </button>

                                    <button 
                                        type="button"
                                        onclick="buyBundleNow({{ $bundle->id }}, this)"
                                        class="btn-bundle-buynow d-flex align-items-center justify-content-center"
                                    >
                                        <span>BUY NOW</span>
                                    </button>
                                </div>

                                <div class="pt-1 text-center" style="font-size: 9.5px; line-height: 1.4; color: #6B605B; border-top: 1px solid #E8E0DA;">
                                    <span>100% Genuine French Oil &bull; Free Shipping</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 rounded-4 p-5 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <i class="fas fa-gem gradient-gold-icon fs-1 mb-3"></i>
                    <h4 class="font-serif fs-4 mb-2" style="color: #211D1E;">No Active Bundles at this Moment</h4>
                    <p class="mb-4 text-xs font-sans" style="color: #6B605B;">Our private master discovery coffrets are curated seasonally. Browse our full fragrance library in the meantime.</p>
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold px-4 py-2 text-xs text-uppercase rounded-3 text-decoration-none" style="border-radius: 8px;">
                        EXPLORE ALL PERFUMES
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Value Proposition Highlights Bar (On mobile appears at the very bottom, on desktop appears at the top) -->
        <div class="order-2 order-lg-1 row g-3 g-md-4 mb-4 mb-lg-5 p-2.5 p-sm-3 p-md-4 rounded-3 rounded-md-4 shadow-sm value-prop-bar" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <div class="col-12 col-md-4 d-flex align-items-center gap-2.5 gap-md-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 prop-icon-circle shadow-xs" style="background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                    <i class="fas fa-gift gradient-gold-icon fs-6"></i>
                </div>
                <div>
                    <h4 class="font-serif fw-medium mb-0 mb-md-1 prop-heading" style="color: #211D1E;">Handcrafted Velvet Box</h4>
                    <p class="prop-text mb-0" style="color: #6B605B;">Complimentary royal coffret unboxing experience</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-2.5 gap-md-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 prop-icon-circle shadow-xs" style="background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                    <i class="fas fa-percent gradient-gold-icon fs-6"></i>
                </div>
                <div>
                    <h4 class="font-serif fw-medium mb-0 mb-md-1 prop-heading" style="color: #211D1E;">Guaranteed Savings</h4>
                    <p class="prop-text mb-0" style="color: #6B605B;">Save up to 30% versus purchasing individual flacons</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-center gap-2.5 gap-md-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 prop-icon-circle shadow-xs" style="background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                    <i class="fas fa-truck-fast gradient-gold-icon fs-6"></i>
                </div>
                <div>
                    <h4 class="font-serif fw-medium mb-0 mb-md-1 prop-heading" style="color: #211D1E;">Express Air Delivery</h4>
                    <p class="prop-text mb-0" style="color: #6B605B;">24-48h insured TCS express courier with nationwide COD</p>
                </div>
            </div>
        </div>

        @if(method_exists($bundles, 'links') && $bundles->hasPages())
            <div class="order-3 mt-4 mt-lg-5 d-flex justify-content-center">
                {{ $bundles->links() }}
            </div>
        @endif

    </div>
</section>

<!-- 3. Flacon Price Details Modal Popup -->
<div id="flaconPriceModal" class="flacon-modal-backdrop d-none" onclick="if(event.target === this) closeFlaconPriceModal()">
    <div class="flacon-modal-dialog">
        <!-- Modal Header Row -->
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 px-1" style="border-bottom: 1px solid #ECE4DC;">
            <span class="fmodal-header-badge">
                INDIVIDUAL FLACON PRICING
            </span>
            <button type="button" class="flacon-modal-close-btn me-1" onclick="closeFlaconPriceModal()" aria-label="Close modal">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        <!-- Perfume Identity Card (Product Page Typography & Generous Line Spacing) -->
        <div class="fmodal-identity-card">
            <div class="d-flex align-items-start gap-3">
                <div class="fmodal-img-wrap">
                    <img id="fModalImage" src="" alt="Perfume Flacon">
                </div>
                <div class="flex-grow-1" style="min-width: 0; overflow: hidden;">
                    <h4 id="fModalName" class="fmodal-title"></h4>
                    <p id="fModalTagline" class="fmodal-tagline"></p>
                    <div>
                        <span class="fmodal-concentration-badge" id="fModalConcentration">Extrait de Parfum</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bundle Advantage Callout Box -->
        <div class="fmodal-callout-box">
            <span class="fw-bold" style="color: #780D24;">Exclusive Coffret Price:</span>
            Included in <strong id="fModalBundleName">this set</strong> (Complete set at <span id="fModalBundlePrice" class="fw-bold" style="color: #780D24;"></span>) with massive savings vs purchasing standalone!
        </div>

        <!-- Standalone Bottle Prices Section -->
        <div class="fmodal-sizes-header">
            <span class="fmodal-sizes-heading">Standalone Bottle Prices:</span>
            <span class="fmodal-sizes-subheading">All 3 Bottle Sizes</span>
        </div>

        <!-- 3 Bottle Sizes Cards Grid -->
        <div id="fModalSizesGrid" class="row g-2 mb-3">
            <!-- Dynamically populated cards for 30ml, 50ml, 100ml -->
        </div>

        <div class="mt-2.5">
            <a id="fModalLink" href="#" class="btn-bundle-bag w-100 text-center text-decoration-none py-2.5 text-uppercase fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 11px; letter-spacing: 0.08em; border-radius: 8px;">
                <span>VIEW FULL PERFUME DETAILS & BOTTLE SIZES</span>
                <i class="fas fa-arrow-right-long" style="font-size: 10px;"></i>
            </a>
        </div>
    </div>
</div>

<script>
function handleFlaconCardClick(element, event) {
    if (event) {
        if (event.target && event.target.closest && event.target.closest('.flacon-direct-link')) {
            return;
        }
        event.preventDefault();
        event.stopPropagation();
    }
    
    try {
        const raw = element.getAttribute('data-flacon');
        let data = null;
        if (raw) {
            data = typeof raw === 'string' ? JSON.parse(raw) : raw;
        } else if (element.dataset && element.dataset.flacon) {
            data = JSON.parse(element.dataset.flacon);
        }
        
        if (data) {
            openFlaconPriceModal(data);
            return;
        }
    } catch (e) {
        console.warn('Flacon data parse error:', e);
    }
    
    const url = element.getAttribute('data-url') || (element.dataset ? element.dataset.url : null);
    if (url && url !== '#') {
        window.location.href = url;
    }
}

function openFlaconPriceModal(data) {
    if (!data) return;
    const modal = document.getElementById('flaconPriceModal');
    if (!modal) {
        if (data.url && data.url !== '#') {
            window.location.href = data.url;
        }
        return;
    }
    
    const setSafeText = (id, text) => {
        const el = document.getElementById(id);
        if (el) el.textContent = text || '';
    };

    setSafeText('fModalName', data.name);
    setSafeText('fModalTagline', data.tagline || 'Haute Parfumerie Impression');
    
    const imgEl = document.getElementById('fModalImage');
    if (imgEl) {
        imgEl.src = data.image || '';
        imgEl.alt = data.name || 'Perfume Flacon';
    }
    
    setSafeText('fModalConcentration', data.concentration || 'Extrait de Parfum');
    setSafeText('fModalBundleName', data.bundle_name || 'this coffret');
    setSafeText('fModalBundlePrice', data.bundle_price || '');
    
    const linkEl = document.getElementById('fModalLink');
    if (linkEl) {
        linkEl.href = data.url || '#';
    }
    
    const sizesGrid = document.getElementById('fModalSizesGrid');
    if (sizesGrid) {
        sizesGrid.innerHTML = '';
        if (Array.isArray(data.sizes) && data.sizes.length > 0) {
            data.sizes.forEach(function(s) {
                const isCoffret = !!s.is_coffret_size;
                let tierName = 'Flacon';
                if (s.size.includes('30')) tierName = 'Travel Size';
                else if (s.size.includes('50')) tierName = 'Signature';
                else if (s.size.includes('100')) tierName = 'Grand Flacon';
                
                const col = document.createElement('div');
                col.className = data.sizes.length === 2 ? 'col-6' : 'col-4';
                col.innerHTML = `
                    <div class="size-card text-center p-2 rounded-3 h-100 ${isCoffret ? 'is-coffret-highlight' : ''}"
                         style="cursor: pointer; touch-action: manipulation;"
                         onclick="window.location.href='${data.url || '#'}'"
                         title="View ${s.size} single bottle on product page">
                        ${isCoffret 
                            ? '<span class="coffret-chip">Coffret Size</span>' 
                            : `<span class="size-tier-chip">${tierName}</span>`}
                        <div class="size-volume mt-1.5">${s.size}</div>
                        <div class="size-price my-0.5">${s.formatted}</div>
                        <div class="size-label">${isCoffret ? 'In this Bundle' : 'Single Bottle'}</div>
                    </div>
                `;
                sizesGrid.appendChild(col);
            });
        }
    }
    
    modal.classList.remove('d-none');
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
    document.body.style.touchAction = 'none';
}

function closeFlaconPriceModal() {
    const modal = document.getElementById('flaconPriceModal');
    if (modal) {
        modal.classList.add('d-none');
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
        document.body.style.touchAction = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modalBackdrop = document.getElementById('flaconPriceModal');
    if (modalBackdrop) {
        modalBackdrop.addEventListener('touchmove', function(e) {
            if (e.target === modalBackdrop) {
                e.preventDefault();
            }
        }, { passive: false });
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFlaconPriceModal();
    }
});

function toggleBundleIncluded(trigger) {
    const card = trigger.closest('.bundle-card-master');
    if (!card) return;
    const wrap = card.querySelector('.bundle-included-wrap');
    const btn = card.querySelector('.btn-view-inside');
    if (!wrap) return;

    const isOpen = wrap.classList.toggle('is-expanded');
    if (btn) {
        btn.classList.toggle('is-open', isOpen);
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        const label = btn.querySelector('.btn-view-inside-label');
        const chevron = btn.querySelector('.btn-view-inside-chevron');
        const count = btn.dataset.itemsCount || '2';
        if (label) {
            label.textContent = isOpen ? 'Hide Included Fragrances' : `View What's Inside (${count} Fragrances)`;
        }
        if (chevron) {
            chevron.style.transform = isOpen ? 'rotate(180deg)' : '';
        }
    }
}

function buyBundleNow(bundleId, btnElement) {
    if (btnElement) {
        btnElement.disabled = true;
        btnElement.innerHTML = '<i class="fas fa-spinner fa-spin text-white"></i> <span>CHECKOUT...</span>';
    }

    // Direct Form Submission: guarantees 100% reliable session persistence and direct checkout navigation
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("cart.add") }}';
    form.style.display = 'none';

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    
    const fields = [
        { name: '_token', value: csrf },
        { name: 'bundle_id', value: bundleId },
        { name: 'quantity', value: 1 },
        { name: 'redirect', value: 'checkout' }
    ];

    fields.forEach(function(f) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = f.name;
        input.value = f.value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

function addBundleToCart(bundleId, btnElement) {
    // Both Add Bundle and Buy Now proceed directly to checkout as requested
    buyBundleNow(bundleId, btnElement);
}
</script>

@endsection
