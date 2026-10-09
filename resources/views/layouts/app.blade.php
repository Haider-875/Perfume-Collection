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
        content="@yield('meta_description', 'Handcrafted Extrait de Parfum luxury impressions formulated with French oils for 14+ hour longevity in Pakistan. 100% authentic impressions.')">
    <meta name="keywords"
        content="perfumes collection, luxury impressions pakistan, buy rawaha lookalike, extrait de parfum lahore, buy perfume online karachi, best long lasting fragrance islamabad">

    <!-- OpenGraph & Social Cards -->
    <meta property="og:title" content="@yield('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions')">
    <meta property="og:description"
        content="@yield('meta_description', 'Handcrafted Extrait de Parfum luxury impressions formulated for Pakistan climate.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/brand/logo.png') }}">
    <meta name="twitter:card" content="summary_large_image">

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
    <link rel="stylesheet" href="{{ asset('assets/css/luxury.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Transition utilities for Alpine.js x-transition */
        .transition { transition-property: transform, opacity; }
        .ease-out { transition-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        .ease-in { transition-timing-function: cubic-bezier(0.4, 0, 1, 1); }
        .duration-300 { transition-duration: 300ms; }
        .duration-200 { transition-duration: 200ms; }
        .opacity-0 { opacity: 0; }
        .opacity-100 { opacity: 1; }
        .-translate-x-full { transform: translateX(-100%); }
        .translate-x-0 { transform: translateX(0); }

        /* Prevent Bootstrap .d-flex !important from keeping overlay open when x-show is false */
        [x-show="mobileMenuOpen"][style*="display: none"] {
            display: none !important;
        }

        /* Mobile Menu Drawer scroll containment */
        [x-show="mobileMenuOpen"] {
            height: 100vh;
            height: 100dvh;
            max-height: 100dvh;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
            touch-action: pan-y;
        }

        /* Mobile Centered Logo & Balanced Navigation */
        @media (max-width: 991.98px) {
            .site-navbar-inner {
                position: relative;
                height: 4.5rem !important;
            }
            .site-brand-wrapper {
                position: absolute !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin: 0 !important;
                z-index: 1;
            }
            .site-logo-img {
                height: 3.15rem !important;
                max-height: 52px !important;
                width: auto !important;
                object-fit: contain;
                filter: drop-shadow(0 2px 14px rgba(133,16,41,0.4)) !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-theme-main text-ivory font-sans antialiased"
    x-data="{ mobileMenuOpen: false, searchOpen: false }"
    x-init="$watch('mobileMenuOpen', val => document.body.classList.toggle('overflow-hidden', val))"
    :class="{ 'overflow-hidden': mobileMenuOpen }">

    @php
        $whatsappNum = \App\Models\Setting::get('whatsapp', '923363685732');
        $phoneNum = \App\Models\Setting::get('phone', '+92 336 3685732');
        $announcementText = \App\Models\Setting::get('announcement_text', '✨ SPECIAL LAUNCH: 15% OFF On All Luxury Impressions Over Rs. 4,000 + Free Nationwide Shipping | Code: PERFUME15');
        $freeShippingThreshold = \App\Models\Setting::get('free_shipping_threshold', '3000');
    @endphp
    <!-- 1. Top Rotating Announcement Bar (Royal Imperial Wine & Gold Haute Parfumerie) -->
    <div class="top-ticker overflow-hidden">
        <div class="container-fluid px-3 px-md-4 px-lg-5">
            <div class="swiper announcement-swiper">
                <div class="swiper-wrapper text-center">
                    <div class="swiper-slide">
                        <i class="fas fa-truck-fast text-gold"></i>
                        <span>Complimentary Nationwide Delivery on Orders Above Rs. 5,000</span>
                    </div>
                    <div class="swiper-slide">
                        <i class="fas fa-crown text-gold"></i>
                        <span>35% - 40% Pure Extrait Strength &bull; 14+ Hours Beast Mode Longevity</span>
                    </div>
                    <div class="swiper-slide">
                        <i class="fas fa-hand-holding-dollar text-gold"></i>
                        <span>Cash on Delivery (COD) Available Across All Cities in Pakistan</span>
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
    <header class="sticky-top site-header" x-data="{ accountOpen: false }">
        <div class="container-fluid px-3 px-md-4 px-lg-5">
            <div class="d-flex align-items-center justify-content-between w-100 site-navbar-inner" style="height: 5rem;">

                <!-- Mobile Left: Hamburger Button (d-lg-none) -->
                <div class="d-flex align-items-center d-lg-none flex-shrink-0" style="z-index: 2;">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-ivory border-0 bg-transparent p-2 me-1 fs-4 mobile-hamburger-btn"
                        aria-label="Toggle Menu"
                        style="touch-action: manipulation; -webkit-tap-highlight-color: transparent;">
                        <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times" x-show="mobileMenuOpen"></i>
                    </button>
                </div>

                <!-- Left: Brand Logo & Company Name (Left on Desktop, Centered on Mobile) -->
                <div class="d-flex align-items-center gap-3 flex-shrink-0 site-brand-wrapper">
                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 gap-sm-3 text-decoration-none site-brand-link">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                            class="img-fluid site-logo-img" style="height: 2.75rem; width: auto; object-fit: contain; filter: drop-shadow(0 2px 12px rgba(133,16,41,0.35));">
                        <div class="d-none d-lg-flex flex-column site-brand-text">
                            <span class="font-hero text-uppercase lh-1 gold-gradient-text" style="font-size: 1.15rem; letter-spacing: 0.14em; font-weight: 400;">PERFUMES
                                <br> COLLECTION</span>
                            <span class="text-gold" style="font-size: 8px; letter-spacing: 0.32em; text-transform: uppercase; font-weight: 300;">LUXURY
                                EXTRAIT DE PARFUM</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Primary Navigation Links (Desktop Only) -->
                <nav class="d-none d-lg-flex align-items-center header-nav">
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
                            class="nav-link-luxury border-0 bg-transparent p-0 d-inline-flex align-items-center {{ request()->is('collections*') && !request()->is('collections/bundles*') ? 'active' : '' }}"
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
                                <span>Private Reserve (Extrait)</span>
                                <span class="badge-extrait">40% OIL</span>
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

                    <!-- Bundles Link -->
                    <a href="{{ route('bundles.index') }}"
                        class="nav-link-luxury {{ request()->is('collections/bundles*') ? 'active' : '' }}">
                        <span>Bundles</span>
                        <span class="nav-badge-sale">SALE</span>
                    </a>

                    <a href="{{ route('collections.show', 'all') }}?sort=bestseller"
                        class="nav-link-luxury">
                        Bestsellers
                    </a>

                    <a href="{{ route('collections.show', 'exclusive') }}"
                        class="nav-link-luxury {{ request()->is('collections/exclusive*') ? 'active' : '' }}">
                        Private Reserve
                    </a>
                </nav>

                <!-- Right: Action Icons (Search, User Account / Sign In, Cart) -->
                <div class="d-flex align-items-center gap-3 gap-md-4 flex-shrink-0" style="z-index: 2;">
                    <!-- Slide-in Cart Trigger -->
                    <button type="button" id="cartDrawerTrigger"
                        class="position-relative border-0 bg-transparent text-ivory opacity-75 p-1 fs-5"
                        title="Your Cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count-badge position-absolute bg-gradient-gold-pill text-theme-main rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="top: -6px; right: -6px; width: 18px; height: 18px; font-size: 10px; font-weight: 400;">
                            0
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Off-Canvas Animated Mobile Menu & Backdrop -->
    <div x-show="mobileMenuOpen"
        x-cloak
        @click="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mobile-offcanvas-backdrop d-lg-none"
        style="z-index: 1055;"></div>

    <div x-show="mobileMenuOpen"
        x-cloak
        @keydown.escape.window="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full" 
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200" 
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="mobile-offcanvas-drawer p-3 p-sm-4 d-lg-none"
        style="z-index: 1060;">
        <!-- Mobile Menu Header -->
        <div class="d-flex align-items-center justify-content-between border-bottom border-gold-20 pb-3 flex-shrink-0">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                    style="height: 2.25rem; width: auto; object-fit: contain;">
                <span class="font-hero text-uppercase tracking-wider gold-gradient-text" style="font-size: 1rem;">Perfumes Collection</span>
            </div>
            <button type="button" @click="mobileMenuOpen = false"
                class="border-0 bg-transparent text-ivory fs-2 p-1 d-flex align-items-center justify-content-center"
                style="width: 44px; height: 44px; touch-action: manipulation;"
                aria-label="Close navigation">&times;</button>
        </div>

        <!-- Mobile Menu Navigation Links -->
        <div class="py-3 vstack gap-2 flex-grow-1 overflow-y-auto">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Home
            </a>

            <!-- Mobile Collections Accordion -->
            <div x-data="{ colOpen: true }" class="border-bottom border-gold-15 py-2">
                <button type="button" @click="colOpen = !colOpen"
                    class="w-100 border-0 bg-transparent text-start d-flex align-items-center justify-content-between font-serif fs-5 text-ivory p-0">
                    <span>Shop & Collections</span>
                    <i class="fas fa-chevron-down text-gold" style="font-size: 11px;"
                        :class="colOpen ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="colOpen" class="ps-3 pt-2 vstack gap-2 text-sm text-muted-luxury">
                    <a href="{{ route('collections.show', 'all') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">All Impressions Catalog</a>
                    <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">Exclusive Reserve (35% Extrait)</a>
                    <a href="{{ route('collections.show', 'men') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">Men's Impressions</a>
                    <a href="{{ route('collections.show', 'women') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">Women's Impressions</a>
                    <a href="{{ route('collections.show', 'unisex') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">Unisex & Pure Oud</a>
                    <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-gold-soft fw-semibold text-decoration-none">Bundles & Discovery Sets (Save 25%)</a>
                    <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury text-decoration-none">Fragrance Chronicles</a>
                </div>
            </div>

            <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Private Reserve
            </a>

            <a href="{{ route('bundles.index') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Bundles & Discovery Sets
            </a>
            <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Olfactory Journal
            </a>
            <a href="{{ route('pages.about') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Our Artisanal Craft
            </a>
            <a href="{{ route('pages.contact') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 py-2 text-decoration-none">
                Contact & VIP Concierge
            </a>
        </div>

        <!-- Mobile Menu Footer Actions -->
        <div class="border-top border-gold-20 pt-3 vstack gap-2 flex-shrink-0">
            <button type="button"
                onclick="document.getElementById('scentQuizModal').classList.add('active'); mobileMenuOpen = false;"
                class="w-100 btn-gold py-2.5 text-xs tracking-widest text-uppercase d-flex align-items-center justify-center gap-2"
                style="min-height: 44px;">
                <i class="fas fa-wand-magic-sparkles"></i>
                <span>LAUNCH SCENT FINDER QUIZ</span>
            </button>

            <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out for perfume recommendations.') }}"
                target="_blank"
                class="w-100 btn-whatsapp py-2.5 text-xs tracking-wider text-uppercase d-flex align-items-center justify-center gap-2 text-decoration-none"
                style="min-height: 44px;">
                <i class="fab fa-whatsapp"></i>
                <span>WHATSAPP CONCIERGE ORDER</span>
            </a>
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
    <footer class="site-footer bg-theme-dark text-muted-luxury border-top border-gold-20 py-5">
        <div class="container px-3 px-lg-4">
            <div class="row g-4 g-lg-5 mb-5">

                <!-- Col 1: Brand & Atelier Presence -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="vstack gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                                style="height: 3rem; width: auto; object-fit: contain;">
                            <span class="font-serif fw-bold fs-5 gold-gradient-text text-uppercase tracking-wider">Perfumes Collection</span>
                        </div>
                        <p class="text-muted-luxury lh-base fw-light mb-0" style="font-size: 0.76rem;">
                            {{ $settings['site_name'] ?? 'Perfumes Collection' }} crafts high-fidelity Extrait de Parfum
                            impressions inspired by iconic global niche perfumeries. Formulated at 35%–40% pure oil
                            concentration for monumental 14+ hours longevity.
                        </p>
                    </div>
                </div>

                <!-- Col 2: The Olfactory Houses -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-3 fw-semibold border-bottom border-gold-20 pb-2">
                        Top Collections</h4>
                    <ul class="list-unstyled vstack gap-2 text-muted-luxury mb-0" style="font-size: 0.76rem;">
                        <li><a href="{{ route('collections.show', 'exclusive') }}"
                                class="text-muted-luxury hover-gold transition-all">Exclusive Reserve Extrait</a></li>
                        <li><a href="{{ route('collections.show', 'men') }}"
                                class="text-muted-luxury hover-gold transition-all">Men's Designer Impressions</a></li>
                        <li><a href="{{ route('collections.show', 'women') }}"
                                class="text-muted-luxury hover-gold transition-all">Women's Impressions</a></li>
                        <li><a href="{{ route('collections.show', 'unisex') }}"
                                class="text-muted-luxury hover-gold transition-all">Unisex & Niche Extraits</a></li>
                    </ul>
                </div>

                <!-- Col 3: Client Privilege & Care -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-3 fw-semibold border-bottom border-gold-20 pb-2">
                        Customer Care</h4>
                    <ul class="list-unstyled vstack gap-2 text-muted-luxury mb-0" style="font-size: 0.76rem;">
                        <li><a href="{{ route('pages.about') }}"
                                class="text-muted-luxury hover-gold transition-all">Our Artisanal Craft</a></li>
                        <li><a href="{{ route('pages.contact') }}"
                                class="text-muted-luxury hover-gold transition-all">Contact Scent Concierge</a></li>
                        <li><a href="{{ route('pages.faq') }}"
                                class="text-muted-luxury hover-gold transition-all">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('policies.shipping') }}"
                                class="text-muted-luxury hover-gold transition-all">Shipping & Courier Delivery</a></li>
                        <li><a href="{{ route('policies.refund') }}"
                                class="text-muted-luxury hover-gold transition-all">Hassle-Free Return Guarantee</a></li>
                        <li><a href="{{ route('policies.privacy') }}"
                                class="text-muted-luxury hover-gold transition-all">Privacy Policy & Security</a></li>
                    </ul>
                </div>

                <!-- Col 4: The Privileged Circle -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="vstack gap-3">
                        <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-1 fw-semibold border-bottom border-gold-20 pb-2">
                            The Privileged Circle</h4>
                        <p class="text-muted-luxury fw-light mb-0" style="font-size: 0.76rem;">
                            An exclusive patronage for discerning fragrance connoisseurs across Pakistan. Enjoy handcrafted private reserve formulations, bespoke scent consultations, and complimentary nationwide express courier delivery.
                        </p>
                        <div class="d-flex align-items-center gap-2 pt-1 text-gold-soft" style="font-size: 0.75rem;">
                            <i class="fas fa-gem text-gold"></i>
                            <span class="text-uppercase tracking-wider">Handcrafted in Pakistan</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Icons -->
            <div class="border-top border-gold-15 pt-4 d-flex flex-column flex-md-row align-items-center justify-content-between text-muted-luxury gap-3" style="font-size: 0.76rem;">
                <div>
                    &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Perfumes Collection' }}. All rights reserved. Registered Haute Parfumerie in Pakistan.
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ $settings['social_instagram'] ?? 'https://instagram.com' }}" target="_blank" class="text-muted-luxury fs-6"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings['social_facebook'] ?? 'https://facebook.com' }}" target="_blank" class="text-muted-luxury fs-6"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/{{ $whatsappNum }}" target="_blank" class="text-muted-luxury fs-6"><i class="fab fa-whatsapp text-success"></i></a>
                    <a href="{{ $settings['social_youtube'] ?? 'https://youtube.com' }}" target="_blank" class="text-muted-luxury fs-6"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 7. Slide-In Cart Drawer -->
    <div id="cartDrawerOverlay" class="cart-drawer-overlay"></div>
    <aside id="luxuryCartDrawer" class="cart-drawer">
        <!-- Drawer Header -->
        <div class="p-4 border-bottom border-gold-25 bg-theme-secondary d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-shopping-bag text-gold fs-5"></i>
                <div>
                    <h3 class="font-serif fs-5 tracking-wider text-ivory fw-semibold mb-0">Your Fragrance Bag</h3>
                    <span id="cartDrawerHeaderCount" class="text-muted-luxury" style="font-size: 11px;">0 items</span>
                </div>
            </div>
            <button type="button" id="closeCartDrawer"
                class="border-0 bg-transparent text-muted-luxury fs-3 p-0">&times;</button>
        </div>

        <!-- Dynamic Drawer Cart Items Body (Loaded via AJAX) -->
        <div id="cartDrawerItems" class="flex-grow-1 overflow-y-auto p-4 vstack gap-3 bg-theme-dark text-ivory">
            <div class="text-center py-5 text-muted-luxury">
                <i class="fas fa-gem fs-2 text-gold opacity-50 mb-3 animate-pulse"></i>
                <p class="mb-0">Retrieving your selected impressions...</p>
            </div>
        </div>

        <!-- Drawer Footer with Subtotal, Trust Assurance & Checkout -->
        <div id="cartDrawerFooter" class="p-3.5 p-sm-4 border-top border-gold-25 bg-wine-dark d-flex flex-column gap-3">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted-luxury text-uppercase tracking-wider text-xs fw-medium">Subtotal:</span>
                <span id="cartDrawerSubtotal" class="font-serif fs-4 text-white fw-bold" style="color: #ffffff !important;">Rs. 0</span>
            </div>

            <!-- Customer Trust & Authenticity Assurance Strip -->
            <div class="cart-trust-badges d-flex flex-column gap-1.5 p-2.5 rounded-3 bg-wine-card border border-gold-20 text-center font-sans">
                <div class="d-flex align-items-center justify-content-center gap-2 text-gold-soft" style="font-size: 11px; font-weight: 500;">
                    <i class="fas fa-shield-halved text-gold"></i>
                    <span>100% French Fragrance Oils &bull; 38% Extrait</span>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-2 text-muted-luxury" style="font-size: 10px;">
                    <i class="fas fa-rotate text-gold-soft"></i>
                    <span>7-Day Hassle-Free Scent Exchange Guaranteed</span>
                </div>
            </div>

            <!-- Action Buttons: Side-by-side in Same Line with 5px Gap -->
            <div class="d-flex align-items-center pt-1" style="gap: 5px;">
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
        style="z-index: 1050; pointer-events: none; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);">
        <div class="luxury-modal-content position-relative w-100 bg-theme-dark border border-gold-40 rounded p-4 p-sm-5 shadow-lg"
            style="max-width: 42rem;">
            <button id="closeSearchModal"
                class="modal-close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent text-ivory opacity-75 fs-3">&times;</button>
            <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 10px;">THE PRIVATE VAULT SEARCH</span>
            <h3 class="font-serif fs-4 text-ivory mb-3">Explore Our Olfactory Compositions</h3>

            <div class="position-relative mb-4">
                <input type="text" id="luxurySearchInput"
                    placeholder="Search by note (Oud, Saffron, Rose), concentration, or title..."
                    class="form-control form-control-luxury py-3 pe-5 text-sm">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-gold"></i>
            </div>

            <div id="liveSearchResults" class="overflow-y-auto vstack gap-2 pe-1" style="max-height: 18rem;">
                <div class="text-center text-muted-luxury py-4 text-xs">
                    Type at least 2 characters to search live compositions...
                </div>
            </div>
        </div>
    </div>

    <!-- 9. Scent Finder Quiz Modal -->
    <div id="scentQuizModal"
        class="luxury-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3 opacity-0"
        style="z-index: 1050; pointer-events: none; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);">
        <div class="luxury-modal-content position-relative w-100 bg-theme-dark border border-gold-40 rounded p-4 p-sm-5 shadow-lg"
            style="max-width: 36rem;">
            <button id="closeScentQuizBtn"
                class="modal-close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent text-ivory opacity-75 fs-3"
                onclick="document.getElementById('scentQuizModal').classList.remove('active')">&times;</button>
            <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 10px;">PERSONALIZED OLFACTORY ADVISOR</span>
            <h3 class="font-serif fs-4 text-ivory mb-2">Find Your Signature Formulation</h3>
            <p class="text-xs text-muted-luxury mb-4">
                Answer 2 brief questions to match your presence with our master perfumer's private reserve.
            </p>

            <form id="scentQuizForm" class="vstack gap-3">
                <div>
                    <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-2 fw-medium">
                        1. Primary occasion of wear:
                    </label>
                    <div class="row g-2 text-xs">
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_occasion" value="royal" checked class="form-check-input mt-0">
                                <span>Imperial Evening & Royal</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_occasion" value="wedding" class="form-check-input mt-0">
                                <span>Grand Weddings & Gala</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_occasion" value="summer" class="form-check-input mt-0">
                                <span>Daytime Executive & Fresh</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_occasion" value="spiritual" class="form-check-input mt-0">
                                <span>Spiritual Dehn al Oud / Jumuah</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-2 fw-medium">
                        2. Sillage & Longevity Benchmark:
                    </label>
                    <div class="row g-2 text-xs">
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_intensity" value="beast" checked class="form-check-input mt-0">
                                <span>Beast Mode (16+ Hours)</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="w-100 bg-theme-card border border-gold-20 p-3 rounded cursor-pointer d-flex align-items-center gap-2 text-ivory">
                                <input type="radio" name="quiz_intensity" value="intimate" class="form-check-input mt-0">
                                <span>Sophisticated Aura</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase mt-2">
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
            class="luxury-dock-btn dock-btn-whatsapp text-white text-decoration-none shadow-lg position-relative"
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
    <script src="{{ asset('assets/js/luxury.js') }}"></script>

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