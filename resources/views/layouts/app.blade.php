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

    <!-- Google Fonts: DM Sans & Jost (Exact Reference: BuyRawaha) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- FontAwesome 6 Pro/Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Master Luxury Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/luxury.css') }}">

    <!-- Tailwind via CDN for utility enhancements -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deepblack: '#000000',
                        nightvelvet: '#111111',
                        gold: {
                            DEFAULT: '#C19E66',
                            light: '#DFB966',
                            dark: '#8C651E',
                            champagne: '#C5A880'
                        },
                        ivory: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['"DM Sans"', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                        serif: ['"Jost"', 'sans-serif'],
                        heading: ['"Jost"', '"DM Sans"', 'sans-serif'],
                        display: ['"Jost"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="bg-white text-gray-900 font-sans antialiased selection:bg-amber-100 selection:text-amber-900"
    x-data="{ mobileMenuOpen: false, searchOpen: false }">

    @php
        $whatsappNum = \App\Models\Setting::get('whatsapp', '923008765432');
        $phoneNum = \App\Models\Setting::get('phone', '+92 300 8765432');
        $announcementText = \App\Models\Setting::get('announcement_text', '✨ EID SPECIAL: 15% OFF On All Luxury Impressions Over Rs. 4,000 + Free Nationwide Shipping | Code: RAVAHA15');
        $freeShippingThreshold = \App\Models\Setting::get('free_shipping_threshold', '3000');
    @endphp

    <!-- 1. Top Rotating Announcement Bar -->
    <div
        class="top-ticker bg-[#111827] text-white py-2 text-[11px] uppercase tracking-[0.16em] overflow-hidden border-b border-amber-500/20">
        <div class="container mx-auto px-4">
            <div class="swiper announcement-swiper">
                <div class="swiper-wrapper text-center">
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fas fa-truck-fast text-amber-400"></i>
                        <span>Complimentary Express Air Shipping Across Pakistan on Orders Over Rs.
                            {{ number_format($freeShippingThreshold) }}</span>
                    </div>
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fas fa-crown text-amber-400"></i>
                        <span>35% - 40% Extrait Concentration &bull; 14+ Hours Beast Mode Longevity</span>
                    </div>
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fas fa-hand-holding-dollar text-emerald-400"></i>
                        <span>Cash on Delivery (COD) Available Nationwide Across Pakistan</span>
                    </div>
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fab fa-whatsapp text-emerald-400"></i>
                        <span>VIP Scent Advisor & WhatsApp Ordering: <strong>{{ $phoneNum }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Sticky Pure White Navbar (Exact BuyRawaha Layout) -->
    <header
        class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-xs transition-all duration-300 site-header">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Left: Brand Logo & Company Name (User requirement: Logo on LEFT, name: "Perfumes Collection") -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <!-- Mobile Hamburger -->
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden text-black hover:text-gray-700 text-xl focus:outline-none mr-1"
                        aria-label="Toggle Menu">
                        <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times" x-show="mobileMenuOpen"></i>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                            class="h-12 md:h-14 w-auto object-contain">
                        <div class="hidden sm:flex flex-col">
                            <span
                                class="font-['Jost'] font-bold text-base md:text-lg tracking-[0.14em] text-black uppercase leading-tight group-hover:text-amber-800 transition-colors">PERFUMES
                                <br> COLLECTION</span>
                            <span class="text-[9px] uppercase tracking-[0.28em] text-gray-500 font-medium">LUXURY
                                EXTRAIT DE PARFUM</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Primary Navigation Links (Matching BuyRawaha) -->
                <nav class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->routeIs('home') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors">
                        Home
                    </a>

                    <!-- Impressions Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                        @mouseleave="open = false">
                        <a href="{{ route('collections.show', 'all') }}"
                            class="flex items-center space-x-1 text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->is('collections*') && !request()->is('collections/bundles*') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors py-6">
                            <span>Shop Impressions</span>
                            <i
                                class="fas fa-chevron-down text-[9px] ml-1 transition-transform group-hover:rotate-180"></i>
                        </a>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute top-full left-0 w-64 bg-white border border-gray-200 shadow-xl rounded-b-lg py-3 z-50"
                            style="display: none;">
                            <a href="{{ route('collections.show', 'all') }}"
                                class="flex items-center justify-between px-5 py-2.5 text-xs text-gray-800 hover:bg-gray-100 hover:text-black font-medium transition-colors">
                                <span>All Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'exclusive') }}"
                                class="flex items-center justify-between px-5 py-2.5 text-xs text-gray-800 hover:bg-gray-100 hover:text-black transition-colors">
                                <span>Private Reserve (Extrait)</span>
                                <span class="text-[9px] bg-black text-white px-1.5 py-0.5 rounded font-bold">40%
                                    OIL</span>
                            </a>
                            <a href="{{ route('collections.show', 'men') }}"
                                class="flex items-center px-5 py-2.5 text-xs text-gray-800 hover:bg-gray-100 hover:text-black transition-colors">
                                <span>Men's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'women') }}"
                                class="flex items-center px-5 py-2.5 text-xs text-gray-800 hover:bg-gray-100 hover:text-black transition-colors">
                                <span>Women's Impressions</span>
                            </a>
                            <a href="{{ route('collections.show', 'unisex') }}"
                                class="flex items-center px-5 py-2.5 text-xs text-gray-800 hover:bg-gray-100 hover:text-black transition-colors">
                                <span>Unisex & Niche Extraits</span>
                            </a>
                            <div class="border-t border-gray-100 my-1.5"></div>
                            <a href="{{ route('bundles.index') }}"
                                class="flex items-center justify-between px-5 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold transition-colors">
                                <span>Discovery Bundles & Sets</span>
                                <span class="text-[9px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-bold">SAVE
                                    30%</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('collections.show', 'all') }}?sort=bestseller"
                        class="text-[13px] uppercase tracking-[0.1em] font-medium text-gray-800 hover:text-black transition-colors">
                        Bestsellers
                    </a>

                    <a href="{{ route('collections.show', 'men') }}"
                        class="text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->is('collections/men') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors">
                        Men
                    </a>

                    <a href="{{ route('collections.show', 'women') }}"
                        class="text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->is('collections/women') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors">
                        Women
                    </a>

                    <!-- Bundles & Sets Link -->
                    <a href="{{ route('bundles.index') }}"
                        class="text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->is('collections/bundles*') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors relative">
                        <span>Bundles & Sets</span>
                        <span
                            class="absolute -top-2.5 -right-3 text-[9px] bg-red-600 text-white font-bold px-1.5 py-0.2 rounded-full leading-tight">SALE</span>
                    </a>

                        {{-- <a href="{{ route('order.tracking') }}"
                            class="text-[13px] uppercase tracking-[0.1em] font-medium {{ request()->routeIs('order.tracking') ? 'text-black font-bold border-b-2 border-black pb-1' : 'text-gray-800 hover:text-black' }} transition-colors">
                            Track Order
                        </a> --}}
                </nav>

                <!-- Right: Action Icons (Search, Scent Advisor, Account, WhatsApp, Cart) -->
                <div class="flex items-center space-x-3.5 md:space-x-5">
                    <!-- Scent Finder Quiz Button (Desktop) -->
                    {{-- <button type="button" onclick="document.getElementById('scentQuizModal').classList.add('active')"
                        class="hidden xl:flex items-center space-x-1.5 px-3 py-1.5 rounded-full border border-gray-300 text-[11px] uppercase tracking-wider text-black bg-gray-50 hover:bg-black hover:text-white transition font-medium">
                        <i class="fas fa-wand-magic-sparkles text-[10px] text-amber-700"></i>
                        <span>Scent Advisor</span>
                    </button> --}}

                    <!-- Search Modal Trigger -->
                    <button type="button" id="searchModalTrigger"
                        class="text-gray-800 hover:text-black text-base focus:outline-none transition-colors p-1"
                        title="Search Perfumes">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- User Account / Staff Link -->
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('account.index') }}"
                            class="text-gray-800 hover:text-black text-base focus:outline-none transition-colors p-1"
                            title="{{ auth()->user()->isAdmin() ? 'Admin Portal' : 'My Account' }}">
                            <i
                                class="fas {{ auth()->user()->isAdmin() ? 'fa-shield-halved text-amber-700' : 'fa-user' }}"></i>
                        </a>
                
                    @endauth

                    <!-- Direct WhatsApp Fragrance Advisor -->
                    {{-- <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am exploring perfumes from Perfumes Collection and would like recommendations.') }}"
                        target="_blank" class="text-[#25D366] hover:text-[#20BA5A] text-xl transition-colors p-1"
                        title="Order on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a> --}}

                    <!-- Slide-in Cart Trigger -->
                    <button type="button" id="cartDrawerTrigger"
                        class="relative text-gray-800 hover:text-black text-lg focus:outline-none transition-colors p-1"
                        title="Your Cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span
                            class="cart-count-badge absolute -top-1.5 -right-1.5 bg-black text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
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
        class="fixed inset-0 z-50 bg-white/98 backdrop-blur-2xl flex flex-col justify-between p-6 overflow-y-auto lg:hidden shadow-2xl"
        style="display: none;">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
            <div class="flex items-center space-x-2.5">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                    class="h-10 w-auto object-contain">
                <span class="font-['Jost'] font-bold text-base text-black uppercase tracking-wider">Perfumes
                    Collection</span>
            </div>
            <button @click="mobileMenuOpen = false"
                class="text-2xl text-gray-700 hover:text-black focus:outline-none">&times;</button>
        </div>

        <!-- Mobile Menu Navigation Links -->
        <div class="py-6 space-y-4">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="block font-serif text-lg text-gray-900 hover:text-amber-800 border-b border-gray-100 pb-2">
                Home
            </a>

            <!-- Mobile Collections Accordion -->
            <div x-data="{ colOpen: true }" class="border-b border-gray-100 pb-2">
                <button @click="colOpen = !colOpen"
                    class="w-full flex items-center justify-between font-serif text-lg text-gray-900">
                    <span>Collections & Impressions</span>
                    <i class="fas fa-chevron-down text-xs text-amber-800 transition-transform"
                        :class="colOpen ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="colOpen" class="pl-4 pt-3 space-y-2.5 text-sm text-gray-600">
                    <a href="{{ route('collections.show', 'all') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">All Impressions Catalog</a>
                    <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">Exclusive Reserve (35% Extrait)</a>
                    <a href="{{ route('collections.show', 'men') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">Men's Impressions</a>
                    <a href="{{ route('collections.show', 'women') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">Women's Impressions</a>
                    <a href="{{ route('collections.show', 'unisex') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">Unisex & Pure Oud</a>
                    <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false"
                        class="block py-1 text-amber-800 font-semibold">Bundles & Discovery Sets (Save 25%)</a>
                    <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                        class="block py-1 hover:text-amber-800">Fragrance Chronicles</a>
                </div>
            </div>

            <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false"
                class="block font-serif text-lg text-gray-900 hover:text-amber-800 border-b border-gray-100 pb-2">
                Bundles & Discovery Sets
            </a>
            <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false"
                class="block font-serif text-lg text-gray-900 hover:text-amber-800 border-b border-gray-100 pb-2">
                Olfactory Journal
            </a>
            <a href="{{ route('pages.about') }}" @click="mobileMenuOpen = false"
                class="block font-serif text-lg text-gray-900 hover:text-amber-800 border-b border-gray-100 pb-2">
                Our Artisanal Craft
            </a>
            <a href="{{ route('pages.contact') }}" @click="mobileMenuOpen = false"
                class="block font-serif text-lg text-gray-900 hover:text-amber-800 border-b border-gray-100 pb-2">
                Contact & VIP Concierge
            </a>
        </div>

        <!-- Mobile Menu Footer Actions -->
        <div class="border-t border-gray-200 pt-6 space-y-3">
            <button type="button"
                onclick="document.getElementById('scentQuizModal').classList.add('active'); mobileMenuOpen = false;"
                class="w-full btn-gold py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2">
                <i class="fas fa-wand-magic-sparkles"></i>
                <span>LAUNCH SCENT FINDER QUIZ</span>
            </button>

            <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out for perfume recommendations.') }}"
                target="_blank"
                class="w-full btn-whatsapp py-3 text-xs tracking-wider uppercase flex items-center justify-center space-x-2">
                <i class="fab fa-whatsapp"></i>
                <span>WHATSAPP CONCIERGE ORDER</span>
            </a>
        </div>
    </div>

    <!-- 4. Global Alerts / Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div
                class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3 text-xs md:text-sm">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-emerald-700 text-lg">&times;</button>
            </div>
        </div>
    @endif

    <!-- 5. Main Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- 6. Master Luxury Footer (Clean Rawaha-Style Theme) -->
    <footer class="bg-gray-900 text-gray-300 border-t border-amber-600/30 pt-16 pb-12 site-footer">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <!-- Col 1: Brand & Atelier Presence -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection"
                            class="h-12 w-auto object-contain">
                        <span class="font-['Jost'] font-bold text-lg text-white uppercase tracking-wider">Perfumes
                            Collection</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed font-light">
                        {{ $settings['site_name'] ?? 'Perfumes Collection' }} crafts high-fidelity Extrait de Parfum
                        impressions inspired by iconic global niche perfumeries. Formulated at 35%–40% pure oil
                        concentration for monumental 14+ hours longevity.
                    </p>
                    <div class="text-xs text-amber-400 space-y-1.5 pt-2">
                        <div><i class="fas fa-location-dot mr-2 text-amber-500"></i> <strong>Atelier:</strong>
                            {{ $settings['store_address'] ?? 'MM Alam Road, Gulberg III, Lahore, Pakistan' }}</div>
                        <div><i class="fas fa-phone mr-2 text-amber-500"></i> <strong>Helpline:</strong>
                            {{ $settings['site_phone'] ?? '+92 300 8765432' }}</div>
                        <div><i class="fab fa-whatsapp mr-2 text-emerald-400"></i> <strong>WhatsApp:</strong>
                            +{{ $whatsappNum }}</div>
                    </div>
                </div>

                <!-- Col 2: The Olfactory Houses -->
                <div>
                    <h4
                        class="font-serif text-sm text-white uppercase tracking-widest mb-4 font-semibold border-b border-gray-800 pb-2">
                        Top Collections</h4>
                    <ul class="space-y-2.5 text-xs text-gray-400">
                        <li><a href="{{ route('collections.show', 'exclusive') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Exclusive Reserve
                                    Extrait</span></a></li>
                        <li><a href="{{ route('collections.show', 'men') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Men's Designer
                                    Impressions</span></a></li>
                        <li><a href="{{ route('collections.show', 'women') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Women's Floral &
                                    Amber Impressions</span></a></li>
                        <li><a href="{{ route('collections.show', 'unisex') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Unisex & Pure Oud
                                    Oils</span></a></li>
                        <li><a href="{{ route('collections.show', 'bundles') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Curated Discovery
                                    Bundles (Save 25%)</span></a></li>
                        <li><a href="{{ route('blogs.index') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Fragrance Notes &
                                    Guides</span></a></li>
                    </ul>
                </div>

                <!-- Col 3: Client Privilege & Care -->
                <div>
                    <h4
                        class="font-serif text-sm text-white uppercase tracking-widest mb-4 font-semibold border-b border-gray-800 pb-2">
                        Customer Care</h4>
                    <ul class="space-y-2.5 text-xs text-gray-400">
                        <li><a href="{{ route('pages.about') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Our Artisanal
                                    Craft</span></a></li>
                        <li><a href="{{ route('pages.contact') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Contact Scent
                                    Concierge</span></a></li>
                        <li><a href="{{ route('pages.faq') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Frequently Asked
                                    Questions</span></a></li>
                        <li><a href="{{ route('policies.shipping') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Shipping & Courier
                                    Delivery</span></a></li>
                        <li><a href="{{ route('policies.refund') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Hassle-Free Return
                                    Guarantee</span></a></li>
                        <li><a href="{{ route('policies.privacy') }}"
                                class="hover:text-amber-400 transition-colors flex items-center space-x-2"><i
                                    class="fas fa-angle-right text-[10px] text-amber-500"></i><span>Privacy Policy &
                                    Security</span></a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Pakistan Gateways -->
                <div class="space-y-4">
                    <h4
                        class="font-serif text-sm text-white uppercase tracking-widest mb-2 font-semibold border-b border-gray-800 pb-2">
                        The Privileged Circle</h4>
                    <p class="text-xs text-gray-400 font-light">
                        Receive exclusive release drops and a complimentary Rs. 500 welcome voucher on your inaugural
                        order.
                    </p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <div class="flex">
                            <input type="email" name="email" required placeholder="Enter your email..."
                                class="bg-gray-800 border border-gray-700 rounded-l px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500 flex-1">
                            <button type="submit"
                                class="bg-amber-600 text-white px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-r hover:bg-amber-500 transition">
                                Join
                            </button>
                        </div>
                    </form>

                    <!-- Pakistan Payment & Logistics Badges -->
                    <div class="pt-2">
                        <span
                            class="block text-[10px] uppercase tracking-widest text-amber-400 mb-2 font-medium">Domestic
                            Logistics & Payments:</span>
                        <div class="flex flex-wrap gap-1.5 text-[10px] text-gray-300">
                            <span
                                class="bg-gray-800 border border-gray-700 px-2 py-1 rounded flex items-center space-x-1"><i
                                    class="fas fa-money-bill-wave text-amber-400"></i><span>Cash on
                                    Delivery</span></span>
                            <span
                                class="bg-gray-800 border border-gray-700 px-2 py-1 rounded flex items-center space-x-1"><i
                                    class="fas fa-mobile-screen text-amber-400"></i><span>JazzCash</span></span>
                            <span
                                class="bg-gray-800 border border-gray-700 px-2 py-1 rounded flex items-center space-x-1"><i
                                    class="fas fa-wallet text-amber-400"></i><span>EasyPaisa</span></span>
                            <span
                                class="bg-gray-800 border border-gray-700 px-2 py-1 rounded flex items-center space-x-1"><i
                                    class="fas fa-building-columns text-amber-400"></i><span>Raast / Bank</span></span>
                            <span
                                class="bg-gray-800 border border-gray-700 px-2 py-1 rounded flex items-center space-x-1"><i
                                    class="fas fa-plane text-amber-400"></i><span>TCS / Leopards / PostEx</span></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Icons -->
            <div
                class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500 space-y-4 md:space-y-0">
                <div>
                    &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'RAVAHA Fragrances' }}. All rights reserved.
                    Registered Haute Parfumerie in Pakistan.
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ $settings['social_instagram'] ?? 'https://instagram.com' }}" target="_blank"
                        class="hover:text-amber-400 transition"><i class="fab fa-instagram text-sm"></i></a>
                    <a href="{{ $settings['social_facebook'] ?? 'https://facebook.com' }}" target="_blank"
                        class="hover:text-amber-400 transition"><i class="fab fa-facebook-f text-sm"></i></a>
                    <a href="https://wa.me/{{ $whatsappNum }}" target="_blank"
                        class="hover:text-emerald-400 transition"><i class="fab fa-whatsapp text-sm"></i></a>
                    <a href="{{ $settings['social_youtube'] ?? 'https://youtube.com' }}" target="_blank"
                        class="hover:text-amber-400 transition"><i class="fab fa-youtube text-sm"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 7. Slide-In Cart Drawer -->
    <div id="cartDrawerOverlay" class="cart-drawer-overlay"></div>
    <aside id="luxuryCartDrawer" class="cart-drawer">
        <!-- Drawer Header -->
        <div class="p-5 border-b border-gray-200 bg-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-shopping-bag text-amber-700 text-lg"></i>
                <div>
                    <h3 class="font-serif text-lg tracking-wider text-gray-900 font-semibold">Your Fragrance Bag</h3>
                    <span id="cartDrawerHeaderCount" class="text-[11px] text-gray-500">0 items</span>
                </div>
            </div>
            <button type="button" id="closeCartDrawer"
                class="text-gray-400 hover:text-gray-800 text-2xl transition focus:outline-none">&times;</button>
        </div>

        <!-- Dynamic Drawer Cart Items Body (Loaded via AJAX) -->
        <div id="cartDrawerItems" class="flex-1 overflow-y-auto p-5 space-y-4 bg-white">
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-gem text-3xl text-amber-500/50 mb-3 animate-pulse"></i>
                <p>Retrieving your selected impressions...</p>
            </div>
        </div>

        <!-- Drawer Footer with Subtotal & Checkout -->
        <div id="cartDrawerFooter" class="p-5 border-t border-gray-200 bg-gray-50 space-y-3">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 uppercase tracking-wider text-xs font-medium">Subtotal:</span>
                <span id="cartDrawerSubtotal" class="font-serif text-xl text-gray-900 font-bold">Rs. 0</span>
            </div>
            <p class="text-[11px] text-gray-500 text-center">
                <i class="fas fa-shield-alt text-amber-600 mr-1"></i> Free Express Shipping & COD across Pakistan
            </p>
            <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I want to complete my perfume order with Cash on Delivery.') }}"
                target="_blank"
                class="w-full btn-whatsapp py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2 block text-center">
                <i class="fab fa-whatsapp"></i>
                <span>ORDER VIA WHATSAPP (1-CLICK)</span>
            </a>
            <a href="{{ route('checkout.index') }}"
                class="w-full btn-gold py-3 text-xs tracking-widest uppercase block text-center">
                PROCEED TO SECURE CHECKOUT
            </a>
        </div>
    </aside>

    <!-- 8. Interactive Search Modal -->
    <div id="searchModal"
        class="luxury-modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="luxury-modal-content relative w-full max-w-2xl bg-[#0D0507] border border-[#C9A24B]/40 rounded-lg p-6 sm:p-8 shadow-2xl transform scale-95 transition-all duration-300">
            <button id="closeSearchModal"
                class="modal-close-btn absolute top-4 right-4 text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition">&times;</button>
            <span class="block text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] mb-1 font-semibold">THE PRIVATE
                VAULT SEARCH</span>
            <h3 class="font-serif text-2xl text-[#F5EFE6] mb-4">Explore Our Olfactory Compositions</h3>

            <div class="relative mb-6">
                <input type="text" id="luxurySearchInput"
                    placeholder="Search by note (Oud, Saffron, Rose), concentration, or title..."
                    class="w-full bg-[#120709] border border-[#C9A24B]/40 rounded px-4 py-3.5 text-sm text-[#F5EFE6] focus:outline-none focus:border-[#C9A24B]">
                <i class="fas fa-search absolute right-4 top-4 text-[#C9A24B]"></i>
            </div>

            <div id="liveSearchResults" class="max-h-72 overflow-y-auto space-y-3 pr-2">
                <div class="text-center text-[#F5EFE6]/40 py-8 text-xs">
                    Type at least 2 characters to search live compositions...
                </div>
            </div>
        </div>
    </div>

    <!-- 9. Scent Finder Quiz Modal -->
    <div id="scentQuizModal"
        class="luxury-modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="luxury-modal-content relative w-full max-w-xl bg-[#0D0507] border border-[#C9A24B]/40 rounded-lg p-6 sm:p-8 shadow-2xl transform scale-95 transition-all duration-300">
            <button id="closeScentQuizBtn"
                class="modal-close-btn absolute top-4 right-4 text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition"
                onclick="document.getElementById('scentQuizModal').classList.remove('active')">&times;</button>
            <span class="block text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] mb-1 font-semibold">PERSONALIZED
                OLFACTORY ADVISOR</span>
            <h3 class="font-serif text-2xl text-[#F5EFE6] mb-2">Find Your Signature Formulation</h3>
            <p class="text-xs text-[#F5EFE6]/70 mb-6">
                Answer 2 brief questions to match your presence with our master perfumer's private reserve.
            </p>

            <form id="scentQuizForm" class="space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider text-[#C9A24B] mb-2 font-medium">
                        1. Primary occasion of wear:
                    </label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="royal" checked class="text-[#C9A24B]">
                            <span>Imperial Evening & Royal Presence</span>
                        </label>
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="wedding" class="text-[#C9A24B]">
                            <span>Grand Weddings & Celebrations</span>
                        </label>
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="summer" class="text-[#C9A24B]">
                            <span>Daytime Executive & Fresh</span>
                        </label>
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="spiritual" class="text-[#C9A24B]">
                            <span>Spiritual Dehn al Oud / Jumuah</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-[#C9A24B] mb-2 font-medium">
                        2. Sillage & Longevity Benchmark:
                    </label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_intensity" value="beast" checked class="text-[#C9A24B]">
                            <span>Beast Mode (16+ Hours Room-Filling)</span>
                        </label>
                        <label
                            class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_intensity" value="intimate" class="text-[#C9A24B]">
                            <span>Sophisticated Intimate Aura</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full btn-gold py-3 text-xs tracking-widest uppercase mt-4">
                    REVEAL MY SIGNATURE MASTERPIECE
                </button>
            </form>

            <div id="quizResults" class="mt-4"></div>
        </div>
    </div>

    <!-- 10. Floating WhatsApp & Back to Top Buttons -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-center space-y-3">
        <!-- Back to top button -->
        <button type="button" id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="w-10 h-10 rounded-full bg-[#0C0507] border border-[#C9A24B]/50 text-[#C9A24B] shadow-2xl flex items-center justify-center hover:bg-[#C9A24B] hover:text-[#080304] transition-all opacity-0 pointer-events-none duration-300"
            title="Back to Top">
            <i class="fas fa-arrow-up text-xs"></i>
        </button>

        <!-- Floating WhatsApp Concierge Button -->
        <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am reaching out from your website for fragrance assistance.') }}"
            target="_blank"
            class="w-12 h-12 rounded-full bg-[#25D366] text-white shadow-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300 animate-bounce"
            title="WhatsApp Concierge">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>

    <!-- Toast Notifications Root -->
    <div class="toast-container fixed bottom-6 left-6 z-50 space-y-2"></div>

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
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                    backToTopBtn.classList.add('opacity-100', 'pointer-events-auto');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                    backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>