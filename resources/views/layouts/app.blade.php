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

    @stack('styles')
</head>

<body class="bg-theme-main text-ivory font-sans antialiased"
    x-data="{ mobileMenuOpen: false, searchOpen: false }">

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
    <header class="sticky-top site-header">
        <div class="container-fluid px-3 px-md-4 px-lg-5">
            <div class="d-flex align-items-center justify-content-between w-100" style="height: 5rem;">

                <!-- Left: Brand Logo & Company Name (Logo on LEFT, name: "Perfumes Collection") -->
                <div class="d-flex align-items-center gap-3 flex-shrink-0">
                    <!-- Mobile Hamburger -->
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="d-lg-none text-ivory border-0 bg-transparent p-0 me-2 fs-4"
                        aria-label="Toggle Menu">
                        <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times" x-show="mobileMenuOpen"></i>
                    </button>

                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                            class="img-fluid" style="height: 3rem; width: auto; object-fit: contain; filter: drop-shadow(0 2px 12px rgba(214,170,98,0.25));">
                        <div class="d-none d-sm-flex flex-column">
                            <span class="font-hero text-uppercase lh-1 gold-gradient-text" style="font-size: 1.15rem; letter-spacing: 0.14em; font-weight: 400;">PERFUMES
                                <br> COLLECTION</span>
                            <span class="text-gold" style="font-size: 8px; letter-spacing: 0.32em; text-transform: uppercase; font-weight: 300;">LUXURY
                                EXTRAIT DE PARFUM</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Primary Navigation Links (Spacious Luxury Gap & Hover Dropdown) -->
                <nav class="d-none d-lg-flex align-items-center header-nav">
                    <a href="{{ route('home') }}"
                        class="nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>

                    <!-- Shop Dropdown (Pure Hover, Zero Layout Shift) -->
                    <div class="nav-dropdown-wrapper">
                        <a href="{{ route('collections.show', 'all') }}"
                            class="nav-link-luxury {{ request()->is('collections*') && !request()->is('collections/bundles*') ? 'active' : '' }}">
                            <span>Shop</span>
                            <i class="fas fa-chevron-down nav-chevron ms-1" style="font-size: 8px;"></i>
                        </a>

                        <!-- Dropdown Menu (Opens on Hover smoothly) -->
                        <div class="nav-dropdown-menu">
                            <a href="{{ route('collections.show', 'all') }}"
                                class="dropdown-item-luxury d-flex align-items-center justify-content-between">
                                <span>All Fragrances</span>
                                <i class="fas fa-arrow-right opacity-50" style="font-size: 9px;"></i>
                            </a>
                            <a href="{{ route('collections.show', 'exclusive') }}"
                                class="dropdown-item-luxury d-flex align-items-center justify-content-between">
                                <span>Private Reserve (Extrait)</span>
                                <span class="badge-extrait">40% OIL</span>
                            </a>
                            <a href="{{ route('collections.show', 'men') }}"
                                class="dropdown-item-luxury">
                                <span>Men's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'women') }}"
                                class="dropdown-item-luxury">
                                <span>Women's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'unisex') }}"
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

                    <a href="{{ route('collections.show', 'all') }}"
                        class="nav-link-luxury">
                        Candles
                    </a>

                    <a href="{{ route('collections.show', 'all') }}"
                        class="nav-link-luxury">
                        Attar Collection
                    </a>
                </nav>

                <!-- Right: Action Icons (Search, User Account / Sign In, Cart) -->
                <div class="d-flex align-items-center gap-3 gap-md-4">
                    <!-- Search Modal Trigger -->
                    <button type="button" id="searchModalTrigger"
                        class="border-0 bg-transparent text-ivory opacity-75 p-1 fs-6"
                        title="Search Fragrances">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- User Account / Staff / Guest Sign In -->
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('account.dashboard') }}"
                            class="text-ivory opacity-75 p-1 fs-6"
                            title="{{ auth()->user()->isAdmin() ? 'Admin Portal' : 'My Account' }}">
                            <i class="fas {{ auth()->user()->isAdmin() ? 'fa-shield-halved text-gold' : 'fa-user' }}"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-ivory opacity-75 p-1 fs-6"
                            title="Sign In to Your Account">
                            <i class="far fa-user"></i>
                        </a>
                    @endauth

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

    <!-- 3. Full-Screen Animated Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="position-fixed top-0 start-0 w-100 h-100 bg-theme-dark backdrop-blur-xl d-flex flex-column justify-content-between p-4 overflow-y-auto d-lg-none shadow-lg border-end border-gold-30"
        style="z-index: 1060; display: none;">
        <!-- Mobile Menu Header -->
        <div class="d-flex align-items-center justify-content-between border-bottom border-gold-20 pb-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                    style="height: 2.5rem; width: auto; object-fit: contain;">
                <span class="font-serif fw-bold text-uppercase tracking-wider gold-gradient-text">Perfumes Collection</span>
            </div>
            <button @click="mobileMenuOpen = false"
                class="border-0 bg-transparent text-ivory fs-2">&times;</button>
        </div>

        <!-- Mobile Menu Navigation Links -->
        <div class="py-4 vstack gap-3">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 pb-2">
                Home
            </a>

            <!-- Mobile Collections Accordion -->
            <div x-data="{ colOpen: true }" class="border-bottom border-gold-15 pb-2">
                <button @click="colOpen = !colOpen"
                    class="w-100 border-0 bg-transparent text-start d-flex align-items-center justify-content-between font-serif fs-5 text-ivory p-0">
                    <span>Collections & Impressions</span>
                    <i class="fas fa-chevron-down text-gold" style="font-size: 11px;"
                        :class="colOpen ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="colOpen" class="ps-3 pt-2 vstack gap-2 text-sm text-muted-luxury">
                    <a href="{{ route('collections.show', 'all') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">All Impressions Catalog</a>
                    <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">Exclusive Reserve (35% Extrait)</a>
                    <a href="{{ route('collections.show', 'men') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">Men's Impressions</a>
                    <a href="{{ route('collections.show', 'women') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">Women's Impressions</a>
                    <a href="{{ route('collections.show', 'unisex') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">Unisex & Pure Oud</a>
                    <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-gold-soft fw-semibold">Bundles & Discovery Sets (Save 25%)</a>
                    <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                        class="d-block py-1 text-muted-luxury">Fragrance Chronicles</a>
                </div>
            </div>

            <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 pb-2">
                Bundles & Discovery Sets
            </a>
            <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 pb-2">
                Olfactory Journal
            </a>
            <a href="{{ route('pages.about') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 pb-2">
                Our Artisanal Craft
            </a>
            <a href="{{ route('pages.contact') }}" @click="mobileMenuOpen = false"
                class="font-serif fs-5 text-ivory border-bottom border-gold-15 pb-2">
                Contact & VIP Concierge
            </a>
        </div>

        <!-- Mobile Menu Footer Actions -->
        <div class="border-top border-gold-20 pt-4 vstack gap-2">
            <button type="button"
                onclick="document.getElementById('scentQuizModal').classList.add('active'); mobileMenuOpen = false;"
                class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase d-flex align-items-center justify-center gap-2">
                <i class="fas fa-wand-magic-sparkles"></i>
                <span>LAUNCH SCENT FINDER QUIZ</span>
            </button>

            <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out for perfume recommendations.') }}"
                target="_blank"
                class="w-100 btn-whatsapp py-3 text-xs tracking-wider text-uppercase d-flex align-items-center justify-center gap-2">
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
                        <p class="text-xs text-muted-luxury lh-base fw-light">
                            {{ $settings['site_name'] ?? 'Perfumes Collection' }} crafts high-fidelity Extrait de Parfum
                            impressions inspired by iconic global niche perfumeries. Formulated at 35%–40% pure oil
                            concentration for monumental 14+ hours longevity.
                        </p>
                        <div class="text-xs text-gold vstack gap-2 pt-2">
                            <div><i class="fas fa-location-dot me-2 text-gold"></i> <strong class="text-ivory">Atelier:</strong>
                                {{ $settings['store_address'] ?? 'MM Alam Road, Gulberg III, Lahore, Pakistan' }}</div>
                            <div><i class="fab fa-whatsapp me-2 text-success"></i> <strong class="text-ivory">WhatsApp Concierge:</strong>
                                <a href="https://wa.me/{{ $whatsappNum }}" target="_blank" class="text-gold text-decoration-none">+92 336 3685732</a></div>
                        </div>
                    </div>
                </div>

                <!-- Col 2: The Olfactory Houses -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-3 fw-semibold border-bottom border-gold-20 pb-2">
                        Top Collections</h4>
                    <ul class="list-unstyled vstack gap-2 text-xs text-muted-luxury">
                        <li><a href="{{ route('collections.show', 'exclusive') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Exclusive Reserve Extrait</span></a></li>
                        <li><a href="{{ route('collections.show', 'men') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Men's Designer Impressions</span></a></li>
                        <li><a href="{{ route('collections.show', 'women') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Women's Floral & Amber Impressions</span></a></li>
                        <li><a href="{{ route('collections.show', 'unisex') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Unisex & Pure Oud Oils</span></a></li>
                        <li><a href="{{ route('collections.show', 'bundles') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Curated Discovery Bundles (Save 25%)</span></a></li>
                        <li><a href="{{ route('blogs.index') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Fragrance Notes & Guides</span></a></li>
                    </ul>
                </div>

                <!-- Col 3: Client Privilege & Care -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-3 fw-semibold border-bottom border-gold-20 pb-2">
                        Customer Care</h4>
                    <ul class="list-unstyled vstack gap-2 text-xs text-muted-luxury">
                        <li><a href="{{ route('pages.about') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Our Artisanal Craft</span></a></li>
                        <li><a href="{{ route('pages.contact') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Contact Scent Concierge</span></a></li>
                        <li><a href="{{ route('pages.faq') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Frequently Asked Questions</span></a></li>
                        <li><a href="{{ route('policies.shipping') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Shipping & Courier Delivery</span></a></li>
                        <li><a href="{{ route('policies.refund') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Hassle-Free Return Guarantee</span></a></li>
                        <li><a href="{{ route('policies.privacy') }}"
                                class="text-muted-luxury d-flex align-items-center gap-2"><i
                                    class="fas fa-angle-right text-gold" style="font-size: 10px;"></i><span>Privacy Policy & Security</span></a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Pakistan Gateways -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="vstack gap-3">
                        <h4 class="font-serif text-xs text-ivory text-uppercase tracking-widest mb-1 fw-semibold border-bottom border-gold-20 pb-2">
                            The Privileged Circle</h4>
                        <p class="text-xs text-muted-luxury fw-light mb-0">
                            Receive exclusive release drops and a complimentary Rs. 500 welcome voucher on your inaugural order.
                        </p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" required placeholder="Enter your email..."
                                    class="form-control form-control-luxury text-xs">
                                <button type="submit" class="btn-gold px-3 py-2 text-xs fw-semibold text-uppercase tracking-wider">
                                    Join
                                </button>
                            </div>
                        </form>

                        <!-- Pakistan Payment & Logistics Badges -->
                        <div class="pt-2">
                            <span class="d-block text-gold mb-2 fw-medium text-uppercase tracking-wider" style="font-size: 10px;">Domestic Logistics & Payments:</span>
                            <div class="d-flex flex-wrap gap-1" style="font-size: 10px;">
                                <span class="bg-theme-card border border-gold-20 px-2 py-1 rounded d-flex align-items-center gap-1 text-ivory"><i class="fas fa-money-bill-wave text-gold"></i><span>COD</span></span>
                                <span class="bg-theme-card border border-gold-20 px-2 py-1 rounded d-flex align-items-center gap-1 text-ivory"><i class="fas fa-mobile-screen text-gold"></i><span>JazzCash</span></span>
                                <span class="bg-theme-card border border-gold-20 px-2 py-1 rounded d-flex align-items-center gap-1 text-ivory"><i class="fas fa-wallet text-gold"></i><span>EasyPaisa</span></span>
                                <span class="bg-theme-card border border-gold-20 px-2 py-1 rounded d-flex align-items-center gap-1 text-ivory"><i class="fas fa-building-columns text-gold"></i><span>Bank</span></span>
                                <span class="bg-theme-card border border-gold-20 px-2 py-1 rounded d-flex align-items-center gap-1 text-ivory"><i class="fas fa-plane text-gold"></i><span>Courier</span></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Icons -->
            <div class="border-top border-gold-15 pt-4 d-flex flex-column flex-md-row align-items-center justify-content-between text-xs text-muted-luxury gap-3">
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

        <!-- Drawer Footer with Subtotal & Checkout -->
        <div id="cartDrawerFooter" class="p-4 border-top border-gold-25 bg-wine-dark vstack gap-3">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted-luxury text-uppercase tracking-wider text-xs fw-medium">Subtotal:</span>
                <span id="cartDrawerSubtotal" class="font-serif fs-4 text-gold-soft fw-bold">Rs. 0</span>
            </div>
            <p class="text-muted-luxury text-center mb-0" style="font-size: 11px;">
                <i class="fas fa-shield-alt text-gold me-1"></i> Free Express Shipping & COD across Pakistan
            </p>
            <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I want to complete my perfume order with Cash on Delivery.') }}"
                target="_blank"
                class="w-100 btn-whatsapp py-3 text-xs tracking-widest text-uppercase d-flex align-items-center justify-center gap-2 text-center text-decoration-none">
                <i class="fab fa-whatsapp"></i>
                <span>ORDER VIA WHATSAPP (1-CLICK)</span>
            </a>
            <a href="{{ route('checkout.index') }}"
                class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase d-block text-center text-decoration-none">
                PROCEED TO SECURE CHECKOUT
            </a>
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

    <!-- 10. Floating WhatsApp & Back to Top Buttons -->
    <div class="position-fixed bottom-0 end-0 m-4 d-flex flex-column align-items-center gap-3" style="z-index: 1040;">
        <!-- Back to top button -->
        <button type="button" id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="rounded-circle bg-theme-dark border border-gold-50 text-gold shadow-lg d-flex align-items-center justify-content-center opacity-0 pe-none transition-smooth"
            style="width: 2.75rem; height: 2.75rem;"
            title="Back to Top">
            <i class="fas fa-arrow-up text-xs"></i>
        </button>

        <!-- Floating WhatsApp Concierge Button -->
        <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out from your website for fragrance assistance.') }}"
            target="_blank"
            class="rounded-circle btn-whatsapp shadow-lg d-flex align-items-center justify-content-center text-white text-decoration-none"
            style="width: 3.25rem; height: 3.25rem;"
            title="WhatsApp Concierge">
            <i class="fab fa-whatsapp fs-3"></i>
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

            // Back to top scroll listener
            const backToTopBtn = document.getElementById('backToTopBtn');
            if (backToTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 400) {
                        backToTopBtn.classList.remove('opacity-0', 'pe-none');
                        backToTopBtn.classList.add('opacity-100', 'pe-auto');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'pe-none');
                        backToTopBtn.classList.remove('opacity-100', 'pe-auto');
                    }
                });
            }
        });
    </script>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>