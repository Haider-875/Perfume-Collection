<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic Luxury SEO & Meta -->
    <title>@yield('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')</title>
    <meta name="description"
        content="@yield('meta_description', 'Handcrafted Extrait de Parfum luxury impressions formulated with French oils for 8-10 hours longevity in Pakistan. 100% authentic impressions.')">
    <meta name="keywords"
        content="perfumes collection, luxury impressions pakistan, extrait de parfum lahore, buy perfume online karachi, best long lasting fragrance islamabad">

    <!-- OpenGraph & Social Cards -->
    <meta property="og:title" content="@yield('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions')">
    <meta property="og:description"
        content="@yield('meta_description', 'Handcrafted Extrait de Parfum luxury impressions formulated for Pakistan climate.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/brand/logo.png') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Luxury Brand Favicon & Icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/brand/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/brand/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/brand/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#541B29">

    <!-- Google Fonts: Poppins (Subheadings & Body Regular), Cormorant Garamond & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- FontAwesome 6 Pro/Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5.3 CSS ONLY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Luxury Font: Wasted Vindey Preload -->
    <link rel="preload" href="{{ asset('assets/fonts/Wasted-Vindey.ttf') }}" as="font" type="font/ttf" crossorigin>

    <!-- Master Luxury Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/luxury.css') }}?v={{ filemtime(public_path('assets/css/luxury.css')) ?: '2.0.9' }}-v3">

    <!-- Alpine.js & Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.13.5/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>


    <style>
        [x-cloak] { display: none !important; }
        body.page-entrance-active {
            animation: pageEntrance 0.35s ease-out;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-theme-main text-ivory font-sans"
    x-data="{ mobileMenuOpen: false }"
    x-init="$watch('mobileMenuOpen', val => {
        if (window.ScrollLock) {
            val ? window.ScrollLock.lock('mobile-nav') : window.ScrollLock.unlock('mobile-nav');
        }
    })">

    @php
        $whatsappNum = \App\Models\Setting::get('whatsapp', '923363685732');
        $phoneNum = \App\Models\Setting::get('phone', '+92 336 3685732');
        $announcementText = \App\Models\Setting::get('announcement_text', '✨ SPECIAL LAUNCH: 15% OFF On All Luxury Impressions Over Rs. 4,000 + Free Nationwide Shipping | Code: PERFUME15');
        $freeShippingThreshold = \App\Models\Setting::get('free_shipping_threshold', '5000');
    @endphp
    <!-- 1. Top Rotating Announcement Bar (Royal Imperial Wine & Gold Haute Parfumerie) -->
    <div class="top-ticker overflow-hidden">
        <div class="container-fluid px-2 px-md-4 px-lg-5">
            <div class="swiper announcement-swiper">
                <div class="swiper-wrapper text-center">
                    <div class="swiper-slide">
                        <i class="fas fa-truck-fast text-gold"></i>
                        <span>Complimentary Nationwide Delivery on Orders Above Rs. 5,000</span>
                    </div>
                    <div class="swiper-slide">
                        <i class="fas fa-crown text-gold"></i>
                        <span>35% - 40% Pure Extrait Strength &bull; 8-10 Hours Long Lasting Longevity</span>
                    </div>
                    <div class="swiper-slide">
                        <i class="fas fa-hand-holding-dollar text-gold"></i>
                        <span>Cash on Delivery Available Across All Cities in Pakistan</span>
                    </div>
                    <div class="swiper-slide">
                        <i class="fab fa-whatsapp text-success"></i>
                        <span>VIP Scent Concierge & WhatsApp Ordering: <a href="https://wa.me/{{ $whatsappNum }}" target="_blank" class="text-gold text-decoration-none fw-medium ms-1">+92 336 3685732</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Sticky Translucent Luxury Navbar (Wine Black Glass & Gold Accents) -->
    <header class="sticky-top site-header">
        <div class="container-fluid px-3 px-md-4 px-lg-5">
            <div class="d-flex d-lg-grid align-items-center justify-content-between w-100 site-navbar-inner position-relative">
                <!-- Mobile Left: Hamburger Button (d-lg-none) -->
                <div class="d-flex align-items-center d-lg-none flex-shrink-0" style="z-index: 2;">
                    <button type="button"
                        id="mobileMenuToggle"
                        onclick="if(window.toggleMobileNav) window.toggleMobileNav()"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="border-0 bg-transparent p-2 me-1 fs-4 mobile-hamburger-btn d-inline-flex align-items-center justify-content-center"
                        aria-label="Toggle Navigation Menu"
                        :aria-expanded="mobileMenuOpen.toString()"
                        style="color: #211D1E !important; touch-action: manipulation; -webkit-tap-highlight-color: transparent; width: 44px; height: 44px; min-width: 44px; min-height: 44px;">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Left: Brand Logo & Company Name (Left on Desktop, Centered on Mobile) -->
                <div class="d-flex align-items-center gap-3 flex-shrink-0 site-brand-wrapper">
                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 gap-sm-3 text-decoration-none site-brand-link">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                            class="img-fluid site-logo-img" style="height: 3.25rem; width: auto; object-fit: contain; filter: drop-shadow(0 2px 12px rgba(133,16,41,0.35));">
                        <div class="d-none d-lg-flex flex-column site-brand-text">
                            <span class="font-hero text-uppercase lh-1 gold-gradient-text" style="font-size: 1.15rem; letter-spacing: 0.14em; font-weight: 400; color: #211D1E !important;">PERFUMES
                                <br> COLLECTION</span>
                            <span class="text-gold" style="font-size: 10px; letter-spacing: 0.32em; text-transform: uppercase; font-weight: 500 !important;">LUXURY
                                EXTRAIT DE PARFUM</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Primary Navigation Links (Desktop Only) -->
                <nav class="d-none d-lg-flex align-items-center justify-content-center header-nav">
                    <a href="{{ route('home') }}"
                        class="nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>

                    <!-- Shop Dropdown (Hover + Click Toggle Support) -->
                    <div class="nav-dropdown-wrapper"
                         x-data="{ shopDropdownOpen: false }"
                         @click.outside="shopDropdownOpen = false"
                         @keydown.escape.window="shopDropdownOpen = false">
                        <button type="button"
                            @click="shopDropdownOpen = !shopDropdownOpen"
                            class="nav-link-luxury border-0 bg-transparent p-0 d-inline-flex align-items-center {{ request()->is('collections*') && !request()->is('collections/bundles*') && !request()->is('collections/exclusive*') ? 'active' : '' }}"
                            :class="{ 'active': shopDropdownOpen }"
                            aria-haspopup="true"
                            :aria-expanded="shopDropdownOpen.toString()"
                            style="cursor: pointer; height: 100%;">
                            <span>Shop</span>
                            <i class="fas fa-chevron-down nav-chevron ms-1"
                                :class="{ 'chevron-rotated': shopDropdownOpen }"
                                style="font-size: 8px;"></i>
                        </button>

                        <!-- Dropdown Menu (Opens on Hover or Click smoothly) -->
                        <div class="nav-dropdown-menu" :class="{ 'dropdown-active': shopDropdownOpen }">
                            <a href="{{ route('collections.show', 'all') }}"
                                @click="shopDropdownOpen = false"
                                class="dropdown-item-luxury d-flex align-items-center justify-content-between">
                                <span>All Fragrances</span>
                                <i class="fas fa-arrow-right opacity-50" style="font-size: 9px;"></i>
                            </a>
                            <a href="{{ route('collections.show', 'exclusive') }}"
                                @click="shopDropdownOpen = false"
                                class="dropdown-item-luxury d-flex align-items-center justify-content-between">
                                <span>Exclusive Reserve</span>
                                <span class="nav-badge-exclusive">NEW</span>
                            </a>
                            <a href="{{ route('collections.show', 'men') }}"
                                @click="shopDropdownOpen = false"
                                class="dropdown-item-luxury">
                                <span>Men's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'women') }}"
                                @click="shopDropdownOpen = false"
                                class="dropdown-item-luxury">
                                <span>Women's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'unisex') }}"
                                @click="shopDropdownOpen = false"
                                class="dropdown-item-luxury">
                                <span>Unisex & Niche Extraits</span>
                            </a>
                        </div>
                    </div>

                    <!-- Exclusive Link -->
                    <a href="{{ route('collections.show', 'exclusive') }}"
                        class="nav-link-luxury {{ request()->is('collections/exclusive*') ? 'active' : '' }}">
                        <span>Exclusive</span>
                        <span class="nav-badge-exclusive">NEW</span>
                    </a>

                    <!-- Bundles Link -->
                    <a href="{{ route('bundles.index') }}"
                        class="nav-link-luxury {{ request()->is('collections/bundles*') ? 'active' : '' }}">
                        <span>Bundles</span>
                        <span class="nav-badge-sale">SALE</span>
                    </a>

                    <a href="{{ route('collections.show', 'all') }}?sort=bestseller"
                        class="nav-link-luxury">
                        <span>Bestsellers</span>
                        <span class="nav-badge-sale">SALE</span>
                    </a>
                </nav>

                <!-- Right: Action Icons (Search, Cart) -->
                <div class="d-flex align-items-center justify-content-end gap-2 gap-sm-3 gap-md-4 flex-shrink-0 site-header-actions" style="z-index: 2;">
                    <!-- Search Modal Trigger -->
                    <button type="button" id="searchModalTrigger"
                        class="border-0 bg-transparent p-1 fs-5 site-nav-icon-btn"
                        title="Search Fragrances"
                        aria-label="Search Fragrances"
                        style="color: #211D1E !important; touch-action: manipulation; cursor: pointer; transition: opacity 0.2s ease;">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Slide-in Cart Trigger -->
                    <button type="button" id="cartDrawerTrigger"
                        onclick="if(window.openCartDrawer) window.openCartDrawer();"
                        class="position-relative border-0 bg-transparent p-1 fs-5 site-nav-icon-btn d-inline-flex align-items-center justify-content-center"
                        title="Your Cart"
                        aria-label="View Shopping Cart"
                        style="color: #211D1E !important; touch-action: manipulation; cursor: pointer; transition: opacity 0.2s ease; width: 44px; height: 44px; min-width: 44px; min-height: 44px;">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count-badge position-absolute rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="top: 2px; right: 2px; width: 18px; height: 18px; font-size: 10px; font-weight: 600; background-color: #541B29 !important; color: #FFFFFF !important;">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Off-Canvas Animated Mobile Menu & Backdrop -->
    <div x-show="mobileMenuOpen"
        x-cloak
        id="mobileNavBackdrop"
        @click="mobileMenuOpen = false"
        onclick="if(window.closeMobileNav) window.closeMobileNav();"
        class="mobile-offcanvas-backdrop d-lg-none"
        :class="{ 'active': mobileMenuOpen }"
        style="z-index: 1055;"></div>

    <div x-show="mobileMenuOpen"
        x-cloak
        id="mobileNavDrawer"
        @keydown.escape.window="mobileMenuOpen = false"
        class="mobile-offcanvas-drawer p-3 p-sm-4 d-lg-none"
        :class="{ 'active': mobileMenuOpen }"
        style="z-index: 1060; background-color: #FFFFFF !important; color: #211D1E !important; border-right: 1px solid #E8E0DA;">
        <!-- Mobile Menu Header -->
        <div class="d-flex align-items-center justify-content-between pb-3 flex-shrink-0" style="border-bottom: 1px solid #E8E0DA;">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                    style="height: 2.25rem; width: auto; object-fit: contain;">
                <span class="font-hero text-uppercase tracking-wider" style="font-size: 1rem; color: #211D1E !important;">Perfumes Collection</span>
            </div>
            <button type="button"
                id="closeMobileNav"
                @click="mobileMenuOpen = false"
                onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="border-0 bg-transparent fs-2 p-1 d-flex align-items-center justify-content-center"
                style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; touch-action: manipulation; -webkit-tap-highlight-color: transparent; color: #211D1E !important; cursor: pointer;"
                aria-label="Close navigation">&times;</button>
        </div>

        <!-- Mobile Menu Navigation Links -->
        <div id="mobileNavItems" class="py-3 vstack gap-2 flex-grow-1 overflow-y-auto" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="font-hero fs-5 py-2 text-decoration-none"
                style="color: #211D1E !important; border-bottom: 1px solid #E8E0DA; letter-spacing: 0.04em;">
                Home
            </a>

            <!-- Mobile Exclusive Link -->
            <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="font-hero fs-5 py-2 text-decoration-none d-flex align-items-center justify-content-between pe-2"
                style="color: #211D1E !important; border-bottom: 1px solid #E8E0DA; letter-spacing: 0.04em;">
                <span>Exclusive</span>
                <span class="nav-badge-exclusive">NEW</span>
            </a>

            <!-- Mobile Collections Accordion -->
            <div x-data="{ colOpen: true }" class="py-2" style="border-bottom: 1px solid #E8E0DA;">
                <button type="button" @click="colOpen = !colOpen"
                    class="w-100 border-0 bg-transparent text-start d-flex align-items-center justify-content-between font-hero fs-5 p-0"
                    style="color: #211D1E !important; letter-spacing: 0.04em;">
                    <span>Shop & Collections</span>
                    <i class="fas fa-chevron-down" style="font-size: 11px; color: #541B29;"
                        :class="colOpen ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="colOpen" class="ps-3 pt-2 vstack gap-2 text-sm font-hero" style="color: #6B605B; letter-spacing: 0.03em;">
                    <a href="{{ route('collections.show', 'all') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                        class="d-block py-1 text-decoration-none" style="color: #6B605B;">All Impressions Catalog</a>
                    <a href="{{ route('collections.show', 'men') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                        class="d-block py-1 text-decoration-none" style="color: #6B605B;">Men's Impressions</a>
                    <a href="{{ route('collections.show', 'women') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                        class="d-block py-1 text-decoration-none" style="color: #6B605B;">Women's Impressions</a>
                    <a href="{{ route('collections.show', 'unisex') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                        class="d-block py-1 text-decoration-none" style="color: #6B605B;">Unisex & Pure Oud</a>
                </div>
            </div>

            <a href="{{ route('bundles.index') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="font-hero fs-5 py-2 text-decoration-none"
                style="color: #211D1E !important; border-bottom: 1px solid #E8E0DA; letter-spacing: 0.04em;">
                Bundles & Discovery Sets
            </a>

            <!-- Mobile Bestsellers Link -->
            <a href="{{ route('collections.show', 'all') }}?sort=bestseller" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="font-hero fs-5 py-2 text-decoration-none d-flex align-items-center justify-content-between pe-2"
                style="color: #211D1E !important; border-bottom: 1px solid #E8E0DA; letter-spacing: 0.04em;">
                <span>Bestsellers</span>
                <span class="nav-badge-sale">SALE</span>
            </a>
            <a href="{{ route('pages.about') }}" @click="mobileMenuOpen = false" onclick="if(window.closeMobileNav) window.closeMobileNav();"
                class="font-hero fs-5 py-2 text-decoration-none"
                style="color: #211D1E !important; border-bottom: 1px solid #E8E0DA; letter-spacing: 0.04em;">
                Our Artisanal Craft
            </a>
        </div>

        <!-- Mobile Menu Footer Actions (Side-by-side matching "Your Fragrance Bag") -->
        <div class="border-top pt-3 flex-shrink-0" style="border-color: #E8E0DA !important;">
            <div class="d-flex align-items-center" style="gap: 5px;">
                <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out for perfume recommendations.') }}"
                    target="_blank"
                    class="cart-btn-whatsapp-buynow text-decoration-none">
                    <i class="fab fa-whatsapp fs-6"></i>
                    <span>WHATSAPP</span>
                </a>
                <button type="button"
                    onclick="if(window.closeMobileNav) window.closeMobileNav(); const m = document.getElementById('scentQuizModal'); if(m){ m.classList.add('active'); if(window.ScrollLock) window.ScrollLock.lock('scent-quiz'); }"
                    class="cart-btn-checkout border-0 text-decoration-none">
                    <i class="fas fa-wand-magic-sparkles" style="font-size: 11px;"></i>
                    <span>SCENT QUIZ</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Global Alerts / Flash Messages -->
    @if(session('success'))
        <div class="container px-3 px-md-4 mt-3">
            <div class="alert alert-success d-flex align-items-center justify-content-between shadow-sm">
                <div class="d-flex align-items-center gap-2 text-xs text-md-sm">
                    <i class="fas fa-check-circle text-success"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- 5. Main Content Area -->
    <main class="min-vh-100">
        @yield('content')
    </main>

    <!-- 6. Master Luxury Footer (Perfumes Collection Theme) -->
    <footer class="site-footer border-top py-5" style="background-color: #FAF7F2 !important; border-top: 1px solid #E8E0DA !important; color: #6B605B;">
        <div class="container px-3 px-lg-4">
            <div class="row g-4 g-lg-5 mb-5">

                <!-- Col 1: Brand & Atelier Presence -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="vstack gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                                style="height: 3rem; width: auto; object-fit: contain;">
                            <span class="font-serif fw-bold fs-5 text-uppercase tracking-wider" style="color: #211D1E !important;">Perfumes Collection</span>
                        </div>
                        <p class="lh-base fw-light mb-0" style="font-size: 0.76rem; color: #6B605B;">
                            {{ $settings['site_name'] ?? 'Perfumes Collection' }} crafts high-fidelity Extrait de Parfum
                            impressions inspired by iconic global niche perfumeries. Formulated at 35%–40% pure oil
                            concentration for monumental 8-10 hours longevity.
                        </p>
                    </div>
                </div>

                <!-- Col 2: The Olfactory Houses -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-uppercase tracking-widest mb-3 fw-semibold pb-2" style="color: #541B29 !important; border-bottom: 1px solid #E8E0DA !important;">
                        Top Collections</h4>
                    <ul class="list-unstyled vstack gap-2 mb-0" style="font-size: 0.76rem;">
                        <li><a href="{{ route('collections.show', 'exclusive') }}"
                                class="text-decoration-none transition-all fw-medium" style="color: #541B29;">Exclusive Reserve</a></li>
                        <li><a href="{{ route('collections.show', 'men') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Men's Designer Impressions</a></li>
                        <li><a href="{{ route('collections.show', 'women') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Women's Impressions</a></li>
                        <li><a href="{{ route('collections.show', 'unisex') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Unisex & Niche Extraits</a></li>
                    </ul>
                </div>

                <!-- Col 3: Client Privilege & Care -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-uppercase tracking-widest mb-3 fw-semibold pb-2" style="color: #541B29 !important; border-bottom: 1px solid #E8E0DA !important;">
                        Customer Care</h4>
                    <ul class="list-unstyled vstack gap-2 mb-0" style="font-size: 0.76rem;">
                        <li><a href="{{ route('pages.about') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Our Artisanal Craft</a></li>
                        <li><a href="{{ route('pages.faq') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('policies.shipping') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Shipping & Courier Delivery</a></li>
                        <li><a href="{{ route('policies.refund') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Hassle-Free Return Guarantee</a></li>
                        <li><a href="{{ route('policies.privacy') }}"
                                class="text-decoration-none transition-all" style="color: #6B605B;">Privacy Policy & Security</a></li>
                    </ul>
                </div>

                <!-- Col 4: The Privileged Circle -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="vstack gap-3">
                        <h4 class="font-serif text-xs text-uppercase tracking-widest mb-1 fw-semibold pb-2" style="color: #541B29 !important; border-bottom: 1px solid #E8E0DA !important;">
                            The Privileged Circle</h4>
                        <p class="fw-light mb-0" style="font-size: 0.76rem; color: #6B605B;">
                            An exclusive patronage for discerning fragrance connoisseurs across Pakistan. Enjoy handcrafted private reserve formulations, bespoke scent consultations, and complimentary nationwide express courier delivery.
                        </p>
                        <div class="d-flex align-items-center justify-content-center gap-2 pt-1 text-center w-100" style="font-size: 0.75rem; color: #541B29;">
                            <i class="fas fa-gem" style="color: #9E7D3B;"></i>
                            <span class="text-uppercase tracking-wider fw-medium">Handcrafted in Pakistan</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Icons -->
            <div class="pt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" style="font-size: 0.76rem; border-top: 1px solid #E8E0DA !important; color: #786C67;">
                <div class="text-center text-md-start">
                    &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Perfumes Collection' }}. All rights reserved. Registered Haute Parfumerie in Pakistan.
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ $settings['social_instagram'] ?? 'https://www.instagram.com/perfumescollectionoffical?vrfl=MTU3aGN1aW83NHBqMQ==' }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings['social_facebook'] ?? 'https://www.facebook.com/share/19hj89MXpm/' }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/{{ $whatsappNum }}" target="_blank" rel="noopener noreferrer" class="footer-social-link text-success" aria-label="WhatsApp Concierge"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 7. Slide-In Cart Drawer -->
    <div id="cartDrawerOverlay" class="cart-drawer-overlay" onclick="if(window.closeCartDrawer) window.closeCartDrawer();"></div>
    <aside id="luxuryCartDrawer" class="cart-drawer" style="background-color: #FFFFFF !important; border-left: 1px solid #E8E0DA;">
        <!-- Drawer Header -->
        <div class="p-4 d-flex align-items-center justify-content-between" style="background-color: #FFFFFF !important; border-bottom: 1px solid #E8E0DA !important;">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-shopping-bag fs-5" style="color: #541B29;"></i>
                <div>
                    <h3 class="font-serif fs-5 tracking-wider fw-semibold mb-0" style="color: #211D1E !important;">Your Fragrance Bag</h3>
                    <span id="cartDrawerHeaderCount" style="color: #786C67; font-size: 11px;">0 items</span>
                </div>
            </div>
            <button type="button" id="closeCartDrawer"
                onclick="if(window.closeCartDrawer) window.closeCartDrawer();"
                class="border-0 bg-transparent fs-2 p-1 d-flex align-items-center justify-content-center"
                style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; touch-action: manipulation; -webkit-tap-highlight-color: transparent; color: #211D1E !important; cursor: pointer;"
                aria-label="Close Shopping Bag">&times;</button>
        </div>

        <!-- Dynamic Drawer Cart Items Body (Loaded via AJAX) -->
        <div id="cartDrawerItems" class="flex-grow-1 overflow-y-auto overflow-x-hidden p-3 p-sm-4 vstack gap-3" style="background-color: #FAF7F2 !important; color: #211D1E !important; box-sizing: border-box; width: 100%;">
            <div class="text-center py-5" style="color: #6B605B;">
                <i class="fas fa-gem fs-2 opacity-50 mb-3 animate-pulse" style="color: #9E7D3B;"></i>
                <p class="mb-0">Retrieving your selected impressions...</p>
            </div>
        </div>

        <!-- Drawer Footer with Subtotal, Trust Assurance & Checkout -->
        <div id="cartDrawerFooter" class="p-3.5 p-sm-4 d-flex flex-column gap-3" style="background-color: #FFFFFF !important; border-top: 1px solid #E8E0DA !important;">
            <!-- Free Shipping Progress Tracker -->
            <div id="cartDrawerShippingBox" class="p-2.5 rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-1" style="font-size: 11px;">
                    <span id="cartDrawerShippingText" style="color: #514744;">
                        <i class="fas fa-truck-fast text-gold me-1"></i> Free delivery on orders over Rs. 5,000
                    </span>
                    <span id="cartDrawerShippingPercent" class="fw-bold font-mono" style="font-size: 10px; color: #541B29;">0%</span>
                </div>
                <div class="progress" style="height: 5px; background-color: #E8E0DA; border-radius: 999px;">
                    <div id="cartDrawerShippingProgressBar" class="progress-bar" role="progressbar" 
                         style="width: 0%; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%); border-radius: 999px;" 
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="d-flex flex-column gap-1.5 px-1">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-uppercase tracking-wider text-xs fw-medium" style="color: #786C67;">Subtotal:</span>
                    <span id="cartDrawerSubtotal" class="font-serif fs-5 fw-bold" style="color: #211D1E !important;">Rs. 0</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-uppercase tracking-wider text-xs fw-medium" style="color: #786C67;">Delivery:</span>
                    <span id="cartDrawerShippingFee" class="text-xs fw-bold font-mono" style="color: #541B29 !important;">Rs. 399</span>
                </div>
            </div>

            <!-- Customer Trust & Authenticity Assurance Strip -->
            <div class="cart-trust-badges d-flex flex-column gap-1.5 p-2.5 rounded-3 text-center font-sans" style="background-color: #FAF7F2 !important; border: 1px solid #E8E0DA !important;">
                <div class="d-flex align-items-center justify-content-center gap-2" style="font-size: 11px; font-weight: 500; color: #541B29;">
                    <i class="fas fa-shield-halved" style="color: #9E7D3B;"></i>
                    <span>100% French Fragrance Oils &bull; 38% Extrait</span>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-2" style="font-size: 10px; color: #6B605B;">
                    <i class="fas fa-rotate" style="color: #541B29;"></i>
                    <span>7-Day Hassle-Free Scent Exchange Guaranteed</span>
                </div>
            </div>

            <!-- Action Buttons: Side-by-side in Same Line with 5px Gap -->
            <div class="d-flex align-items-center pt-1 p-2" style="gap: 5px;">
                <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I want to complete my perfume order with Cash on Delivery.') }}"
                    target="_blank"
                    class="cart-btn-whatsapp-buynow text-decoration-none">
                    <i class="fab fa-whatsapp fs-6"></i>
                    <span>WHATSAPP</span>
                </a>
                <a href="{{ route('checkout.index') }}"
                    class="cart-btn-checkout text-decoration-none">
                    <span>CHECKOUT</span>
                    <i class="fas fa-arrow-right-long" style="font-size: 10px;"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- 8. Interactive Search Modal -->
    <div id="searchModal"
        class="luxury-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3 opacity-0"
        style="z-index: 1050; pointer-events: none; background: rgba(0,0,0,0.6); backdrop-filter: blur(6px);">
        <div class="luxury-modal-content position-relative w-100 rounded-4 p-4 p-sm-5 shadow-lg"
            style="max-width: 42rem; background-color: #FFFFFF !important; border: 1px solid #E8E0DA; color: #211D1E !important;">
            <button id="closeSearchModal"
                class="modal-close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent fs-3"
                style="color: #211D1E !important; opacity: 0.8;">&times;</button>
            <span class="d-block mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 10px; color: #9E7D3B;">THE PRIVATE VAULT SEARCH</span>
            <h3 class="font-serif fs-4 mb-3" style="color: #211D1E !important;">Explore Our Olfactory Compositions</h3>

            <div class="position-relative mb-4">
                <input type="text" id="luxurySearchInput"
                    placeholder="Search by note (Oud, Saffron, Rose), concentration, or title..."
                    class="form-control form-control-luxury py-3 pe-5 text-sm">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3" style="color: #541B29;"></i>
            </div>

            <div id="liveSearchResults" class="overflow-y-auto vstack gap-2 pe-1" style="max-height: 18rem;">
                <div class="text-center py-4 text-xs" style="color: #6B605B;">
                    Type at least 2 characters to search live compositions...
                </div>
            </div>
        </div>
    </div>

    <!-- 9. Scent Finder Quiz Modal -->
    <div id="scentQuizModal"
        class="luxury-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3 opacity-0"
        style="z-index: 1050; pointer-events: none; background: rgba(0,0,0,0.6); backdrop-filter: blur(6px);">
        <div class="luxury-modal-content position-relative w-100 rounded-4 p-4 p-sm-5 shadow-lg"
            style="max-width: 36rem; background-color: #FFFFFF !important; border: 1px solid #E8E0DA; color: #211D1E !important;">
            <button id="closeScentQuizBtn"
                class="modal-close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent fs-3"
                style="color: #211D1E !important; opacity: 0.8;"
                onclick="document.getElementById('scentQuizModal').classList.remove('active')">&times;</button>
            <span class="d-block mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 10px; color: #9E7D3B;">PERSONALIZED OLFACTORY ADVISOR</span>
            <h3 class="font-serif fs-4 mb-2" style="color: #211D1E !important;">Find Your Signature Formulation</h3>
            <p class="text-xs mb-4" style="color: #6B605B;">
                Answer 2 brief questions to match your presence with our master perfumer's private reserve.
            </p>

            <form id="scentQuizForm" class="vstack gap-3">
                <div>
                    <label class="d-block text-xs text-uppercase tracking-wider mb-2 fw-medium" style="color: #541B29;">
                        1. Primary occasion of wear:
                    </label>
                    <div class="row g-2 text-xs">
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_occasion" value="royal" checked class="form-check-input mt-0">
                                <span>Imperial Evening & Royal</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_occasion" value="wedding" class="form-check-input mt-0">
                                <span>Grand Weddings & Gala</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_occasion" value="summer" class="form-check-input mt-0">
                                <span>Daytime Executive & Fresh</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_occasion" value="spiritual" class="form-check-input mt-0">
                                <span>Spiritual Dehn al Oud / Jumuah</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="d-block text-xs text-uppercase tracking-wider mb-2 fw-medium" style="color: #541B29;">
                        2. Sillage & Longevity Benchmark:
                    </label>
                    <div class="row g-2 text-xs">
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_intensity" value="beast" checked class="form-check-input mt-0">
                                <span>Long Lasting (8-10 Hours)</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 p-3 rounded cursor-pointer d-flex align-items-center gap-2" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                <input type="radio" name="quiz_intensity" value="intimate" class="form-check-input mt-0">
                                <span>Sophisticated Aura</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase mt-2" style="background-color: #541B29 !important; color: #FFFFFF !important; border: none; border-radius: 8px;">
                    REVEAL MY SIGNATURE MASTERPIECE
                </button>
            </form>

            <div id="quizResults" class="mt-3"></div>
        </div>
    </div>

    <!-- 10. Floating Luxury Actions Dock (WhatsApp & Back to Top) -->
    <div id="floatingActionsDock" class="luxury-floating-dock d-flex flex-column align-items-center gap-2" style="z-index: 1040;">
        <!-- Back to top button (Micro gold arrow, revealed only on deep scroll) -->
        <button type="button" id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="luxury-dock-btn dock-btn-top opacity-0 pe-none transition-smooth"
            title="Back to Top"
            aria-label="Back to Top">
            <i class="fas fa-arrow-up text-xs"></i>
        </button>

        <!-- Floating WhatsApp Concierge Button -->
        <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out from your website for fragrance assistance.') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="luxury-dock-btn dock-btn-whatsapp text-white text-decoration-none shadow-lg position-relative pulse-luxury-ring"
            title="WhatsApp Concierge"
            aria-label="Contact Concierge on WhatsApp">
            <i class="fab fa-whatsapp fs-5"></i>
            <span class="dock-pulse-dot" title="Online Concierge"></span>
        </a>
    </div>

    <!-- Toast Notifications Root -->
    <div class="toast-container position-fixed bottom-0 start-0 m-4 p-0 vstack gap-2" style="z-index: 1070;"></div>

    <!-- Swiper & Luxury JS Engine -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/luxury.js') }}?v={{ file_exists(public_path('assets/js/luxury.js')) ? filemtime(public_path('assets/js/luxury.js')) : time() }}"></script>

    <script>
        // Announcement Bar Swiper
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.announcement-swiper', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                speed: 800,
                effect: 'fade',
                fadeEffect: { crossFade: true }
            });

            // Smart Floating Dock & Back to Top scroll listener
            const floatingDock = document.getElementById('floatingActionsDock');
            const backToTopBtn = document.getElementById('backToTopBtn');
            let scrollTimeout;

            if (floatingDock && backToTopBtn) {
                window.addEventListener('scroll', () => {
                    // Show / hide back to top button
                    if (window.scrollY > 400) {
                        backToTopBtn.classList.remove('opacity-0', 'pe-none');
                        backToTopBtn.classList.add('opacity-100', 'pe-auto');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'pe-none');
                        backToTopBtn.classList.remove('opacity-100', 'pe-auto');
                    }

                    // Mobile non-intrusive scroll fade: dim while scrolling, restore when stopped
                    if (window.innerWidth <= 768) {
                        floatingDock.classList.add('scrolling');
                        clearTimeout(scrollTimeout);
                        scrollTimeout = setTimeout(() => {
                            floatingDock.classList.remove('scrolling');
                        }, 800);
                    }
                }, { passive: true });
            }
        });
    </script>


    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>