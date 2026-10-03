<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Dynamic Luxury SEO & Meta -->
    <title>@yield('title', 'Perfumes Collection | Haute Parfumerie & Imperial Extrait Pakistan')</title>
    <meta name="description" content="@yield('meta_description', 'Handcrafted Extrait de Parfum, rare Cambodian Dehn al Oud, and royal artisanal elixirs formulated for monumental 16+ hour longevity in Pakistan.')">
    <meta name="keywords" content="perfumes collection pakistan, perfume collection, luxury perfume pakistan, extrait de parfum lahore, buy oud online karachi, best long lasting attar islamabad, rawaha perfumes, luxury fragrance brand pakistan">
    
    <!-- OpenGraph & Social Cards -->
    <meta property="og:title" content="@yield('title', 'Perfumes Collection | Haute Parfumerie')">
    <meta property="og:description" content="@yield('meta_description', 'Handcrafted Extrait de Parfum and rare artisanal agarwood oils tailored for Pakistan’s connoisseurs.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/perfumes/oud_royale.svg') }}">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Google Fonts: Cormorant Garamond & Playfair Display (Serif), Inter & Jost (Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

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
                        deepblack: '#080304',
                        nightvelvet: '#0E0507',
                        gold: {
                            DEFAULT: '#C9A24B',
                            light: '#E6C77A',
                            dark: '#9E782F',
                            champagne: '#F3E5AB'
                        },
                        ivory: '#F5EFE6',
                        maroon: {
                            DEFAULT: '#4A0E17',
                            dark: '#2A060C'
                        }
                    },
                    fontFamily: {
                        serif: ['Cormorant Garamond', 'Playfair Display', 'serif'],
                        sans: ['Inter', 'Jost', 'sans-serif'],
                        display: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-[#080304] text-[#F5EFE6] font-sans antialiased selection:bg-[#C9A24B] selection:text-[#080304]" x-data="{ mobileMenuOpen: false, searchOpen: false }">

    <!-- 1. Top Rotating Announcement Bar -->
    <div class="top-ticker bg-[#110507] border-b border-[#C9A24B]/20 py-2 text-[11px] uppercase tracking-[0.18em] text-[#C9A24B] overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="swiper announcement-swiper">
                <div class="swiper-wrapper text-center">
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fas fa-truck-fast text-[#E6C77A]"></i>
                        <span>Complimentary Express Air Delivery across Pakistan on Orders Above Rs. 4,999</span>
                    </div>
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fas fa-hand-holding-dollar text-[#E6C77A]"></i>
                        <span>Cash on Delivery (COD) Available Nationwide &bull; 100% Guaranteed Extrait Concentration</span>
                    </div>
                    <div class="swiper-slide flex items-center justify-center space-x-2">
                        <i class="fab fa-whatsapp text-[#25D366]"></i>
                        <span>VIP Fragrance Concierge & WhatsApp Ordering: <strong>+92 300 1234567</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Sticky Translucent Glass Navbar -->
    <header class="sticky top-0 z-40 bg-[#080304]/90 backdrop-blur-md border-b border-[#C9A24B]/20 transition-all duration-300 site-header">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Left: Mobile Hamburger & Desktop Left Nav -->
                <div class="flex items-center space-x-6">
                    <!-- Mobile Hamburger -->
                    <button 
                        type="button" 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden text-[#F5EFE6] hover:text-[#C9A24B] text-xl focus:outline-none"
                        aria-label="Toggle Menu"
                    >
                        <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times" x-show="mobileMenuOpen"></i>
                    </button>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-xs uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/80 hover:text-[#C9A24B]' }} transition-colors">
                            Home
                        </a>

                        <!-- Collections Animated Dropdown -->
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <a 
                                href="{{ route('collections.show', 'all') }}" 
                                class="flex items-center space-x-1 text-xs uppercase tracking-[0.2em] {{ request()->routeIs('collections.*') ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/80 hover:text-[#C9A24B]' }} transition-colors py-6"
                            >
                                <span>Collections</span>
                                <i class="fas fa-chevron-down text-[9px] ml-1 transition-transform group-hover:rotate-180"></i>
                            </a>

                            <!-- Dropdown Menu -->
                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                class="absolute top-full left-0 w-72 bg-[#0C0507] border border-[#C9A24B]/35 shadow-2xl rounded-b-lg py-3 z-50 backdrop-blur-xl"
                                style="display: none;"
                            >
                                <a href="{{ route('collections.show', 'exclusive') }}" class="flex items-center justify-between px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Exclusive Reserve</span>
                                    <span class="text-[9px] bg-[#4A0E17] text-[#C9A24B] px-1.5 py-0.5 rounded border border-[#C9A24B]/30">EXTRAIT</span>
                                </a>
                                <a href="{{ route('collections.show', 'men') }}" class="flex items-center px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Men's Haute Parfumerie</span>
                                </a>
                                <a href="{{ route('collections.show', 'women') }}" class="flex items-center px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Women's Imperial Flora</span>
                                </a>
                                <a href="{{ route('collections.show', 'unisex') }}" class="flex items-center px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Unisex & Artisanal Oud</span>
                                </a>
                                <div class="border-t border-[#C9A24B]/15 my-1.5"></div>
                                <a href="{{ route('collections.show', 'bundles') }}" class="flex items-center justify-between px-5 py-2.5 text-xs text-[#C9A24B] hover:bg-[#C9A24B]/10 font-medium transition-colors">
                                    <span>Curated Bundles & Coffrets</span>
                                    <span class="text-[9px] bg-emerald-950 text-emerald-300 px-1.5 py-0.5 rounded">SAVE 25%</span>
                                </a>
                                <a href="{{ route('blogs.index') }}" class="flex items-center px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Fragrance Chronicles (Blogs)</span>
                                </a>
                                <a href="{{ route('pages.collaborations') }}" class="flex items-center px-5 py-2.5 text-xs text-[#F5EFE6]/85 hover:bg-[#C9A24B]/10 hover:text-[#C9A24B] transition-colors">
                                    <span>Artisanal Collaborations</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('collections.show', 'bundles') }}" class="text-xs uppercase tracking-[0.2em] {{ request()->is('collections/bundles') ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/80 hover:text-[#C9A24B]' }} transition-colors">
                            Bundles
                        </a>
                        <a href="{{ route('blogs.index') }}" class="text-xs uppercase tracking-[0.2em] {{ request()->routeIs('blogs.*') ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/80 hover:text-[#C9A24B]' }} transition-colors">
                            Chronicles
                        </a>
                        <a href="{{ route('pages.about') }}" class="text-xs uppercase tracking-[0.2em] {{ request()->routeIs('pages.about') ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/80 hover:text-[#C9A24B]' }} transition-colors">
                            Heritage
                        </a>
                    </nav>
                </div>

                <!-- Center: Brand Logo Monogram -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-block py-2">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" class="h-12 md:h-14 w-auto object-contain">
                    </a>
                </div>

                <!-- Right: Action Icons (Search, Scent Quiz, Wishlist, WhatsApp, Cart) -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <!-- Scent Finder Quiz Button (Desktop) -->
                    <button 
                        type="button" 
                        onclick="document.getElementById('scentQuizModal').classList.add('active')"
                        class="hidden md:flex items-center space-x-1.5 px-3 py-1.5 rounded border border-[#C9A24B]/40 text-[11px] uppercase tracking-widest text-[#C9A24B] hover:bg-[#C9A24B]/10 transition"
                    >
                        <i class="fas fa-wand-magic-sparkles text-[10px]"></i>
                        <span>Scent Quiz</span>
                    </button>

                    <!-- Search Modal Trigger -->
                    <button 
                        type="button" 
                        id="searchModalTrigger" 
                        class="text-[#F5EFE6]/80 hover:text-[#C9A24B] text-sm focus:outline-none transition-colors"
                        title="Search Fragrance Vault"
                    >
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Direct WhatsApp Fragrance Advisor -->
                    <a 
                        href="https://wa.me/923001234567?text={{ urlencode('Salam! I am exploring your luxury perfume collection and need advice.') }}" 
                        target="_blank" 
                        class="text-[#25D366] hover:text-[#25D366]/80 text-base transition-colors" 
                        title="Direct WhatsApp Concierge"
                    >
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <!-- Slide-in Cart Trigger -->
                    <button 
                        type="button" 
                        id="cartDrawerTrigger" 
                        class="relative text-[#F5EFE6]/80 hover:text-[#C9A24B] text-base focus:outline-none transition-colors"
                        title="Your Private Vault"
                    >
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count-badge absolute -top-2 -right-2 bg-[#4A0E17] text-[#C9A24B] border border-[#C9A24B]/40 text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                            0
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- 3. Full-Screen Animated Mobile Menu -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="fixed inset-0 z-50 bg-[#080304]/98 backdrop-blur-2xl flex flex-col justify-between p-6 overflow-y-auto lg:hidden"
        style="display: none;"
    >
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between border-b border-[#C9A24B]/20 pb-4">
            <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" class="h-10 w-auto object-contain">
            <button @click="mobileMenuOpen = false" class="text-2xl text-[#C9A24B] focus:outline-none">&times;</button>
        </div>

        <!-- Mobile Menu Navigation Links -->
        <div class="py-6 space-y-4">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block font-serif text-xl text-[#F5EFE6] hover:text-[#C9A24B] border-b border-[#C9A24B]/10 pb-2">
                Home
            </a>

            <!-- Mobile Collections Accordion -->
            <div x-data="{ colOpen: true }" class="border-b border-[#C9A24B]/10 pb-2">
                <button @click="colOpen = !colOpen" class="w-full flex items-center justify-between font-serif text-xl text-[#C9A24B]">
                    <span>Collections</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="colOpen ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="colOpen" class="pl-4 pt-3 space-y-2.5 text-sm text-[#F5EFE6]/80">
                    <a href="{{ route('collections.show', 'exclusive') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Exclusive Reserve (Extrait)</a>
                    <a href="{{ route('collections.show', 'men') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Men's Parfums</a>
                    <a href="{{ route('collections.show', 'women') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Women's Imperial Flora</a>
                    <a href="{{ route('collections.show', 'unisex') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Unisex & Pure Oud</a>
                    <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false" class="block py-1 text-[#C9A24B] font-semibold">Curated Bundles & Coffrets (Save 25%)</a>
                    <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Fragrance Chronicles (Blogs)</a>
                    <a href="{{ route('pages.collaborations') }}" @click="mobileMenuOpen = false" class="block py-1 hover:text-[#C9A24B]">Artisanal Collaborations</a>
                </div>
            </div>

            <a href="{{ route('collections.show', 'bundles') }}" @click="mobileMenuOpen = false" class="block font-serif text-xl text-[#F5EFE6] hover:text-[#C9A24B] border-b border-[#C9A24B]/10 pb-2">
                Bundles & Gifting
            </a>
            <a href="{{ route('blogs.index') }}" @click="mobileMenuOpen = false" class="block font-serif text-xl text-[#F5EFE6] hover:text-[#C9A24B] border-b border-[#C9A24B]/10 pb-2">
                Fragrance Journal
            </a>
            <a href="{{ route('pages.about') }}" @click="mobileMenuOpen = false" class="block font-serif text-xl text-[#F5EFE6] hover:text-[#C9A24B] border-b border-[#C9A24B]/10 pb-2">
                Our Heritage
            </a>
            <a href="{{ route('pages.contact') }}" @click="mobileMenuOpen = false" class="block font-serif text-xl text-[#F5EFE6] hover:text-[#C9A24B] border-b border-[#C9A24B]/10 pb-2">
                VIP Concierge & Consultations
            </a>
        </div>

        <!-- Mobile Menu Footer Actions -->
        <div class="border-t border-[#C9A24B]/20 pt-6 space-y-4">
            <button 
                type="button" 
                onclick="document.getElementById('scentQuizModal').classList.add('active'); mobileMenuOpen = false;"
                class="w-full btn-gold py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2"
            >
                <i class="fas fa-wand-magic-sparkles"></i>
                <span>LAUNCH SCENT FINDER QUIZ</span>
            </button>

            <a 
                href="https://wa.me/923001234567" 
                target="_blank" 
                class="w-full btn-whatsapp py-3 text-xs tracking-wider uppercase flex items-center justify-center space-x-2"
            >
                <i class="fab fa-whatsapp"></i>
                <span>CHAT WITH MASTER PERFUMER</span>
            </a>
        </div>
    </div>

    <!-- 4. Global Alerts / Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 px-4 py-3 rounded flex items-center justify-between">
                <div class="flex items-center space-x-3 text-xs md:text-sm">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 text-lg">&times;</button>
            </div>
        </div>
    @endif

    <!-- 5. Main Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- 6. Master Luxury Footer -->
    <footer class="bg-[#0A0405] border-t border-[#C9A24B]/30 pt-16 pb-12 site-footer">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                
                <!-- Col 1: Brand & Atelier Presence -->
                <div class="space-y-4">
                    <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" class="h-12 w-auto object-contain">
                    <p class="text-xs text-[#F5EFE6]/70 leading-relaxed font-light">
                        Perfumes Collection is Pakistan’s premier Haute Parfumerie crafting pure Extrait de Parfum and unadulterated Cambodian agarwood distillations. Formulated at 35%–40% oil concentration for royal sillage.
                    </p>
                    <div class="text-xs text-[#C9A24B] space-y-1">
                        <div><i class="fas fa-location-dot mr-1.5"></i> <strong>Boutiques:</strong> MM Alam Rd, Gulberg III, Lahore &bull; Clifton, Karachi</div>
                        <div><i class="fas fa-phone mr-1.5"></i> <strong>Helpline:</strong> +92 (42) 3578-9000 &bull; +92 300 1234567</div>
                    </div>
                </div>

                <!-- Col 2: The Olfactory Houses -->
                <div>
                    <h4 class="font-serif text-base text-[#C9A24B] uppercase tracking-widest mb-4">The Collections</h4>
                    <ul class="space-y-2.5 text-xs text-[#F5EFE6]/70">
                        <li><a href="{{ route('collections.show', 'exclusive') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Exclusive Reserve Extrait</span></a></li>
                        <li><a href="{{ route('collections.show', 'men') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Men's Royal Leather & Wood</span></a></li>
                        <li><a href="{{ route('collections.show', 'women') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Imperial Taif Rose & Motia</span></a></li>
                        <li><a href="{{ route('collections.show', 'unisex') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Pure Dehn al Oud Oils</span></a></li>
                        <li><a href="{{ route('collections.show', 'bundles') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Curated Discovery Coffrets</span></a></li>
                        <li><a href="{{ route('pages.collaborations') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Artisanal Collaborations</span></a></li>
                    </ul>
                </div>

                <!-- Col 3: Client Privilege & Care -->
                <div>
                    <h4 class="font-serif text-base text-[#C9A24B] uppercase tracking-widest mb-4">Privilege Care</h4>
                    <ul class="space-y-2.5 text-xs text-[#F5EFE6]/70">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>The Artisanal Heritage</span></a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Private Scent Consultation</span></a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Frequently Asked Questions</span></a></li>
                        <li><a href="{{ route('policies.shipping') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Pakistan Shipping & TCS Delivery</span></a></li>
                        <li><a href="{{ route('policies.refund') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Royal Exchange Guarantee</span></a></li>
                        <li><a href="{{ route('policies.privacy') }}" class="hover:text-[#C9A24B] transition-colors flex items-center space-x-2"><i class="fas fa-angle-right text-[10px] text-[#C9A24B]"></i><span>Privacy Policy & Security</span></a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Pakistan Gateways -->
                <div class="space-y-4">
                    <h4 class="font-serif text-base text-[#C9A24B] uppercase tracking-widest mb-2">The Private Circle</h4>
                    <p class="text-xs text-[#F5EFE6]/70 font-light">
                        Receive private vintage invitations and a complimentary Rs. 1,000 welcome voucher on your inaugural order.
                    </p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <div class="flex">
                            <input 
                                type="email" 
                                name="email" 
                                required 
                                placeholder="Enter email address..." 
                                class="bg-[#14080B] border border-[#C9A24B]/40 rounded-l px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none focus:border-[#C9A24B] flex-1"
                            >
                            <button type="submit" class="bg-[#C9A24B] text-[#080304] px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-r hover:bg-[#E6C77A] transition">
                                Join
                            </button>
                        </div>
                    </form>

                    <!-- Pakistan Payment & Logistics Badges -->
                    <div class="pt-2">
                        <span class="block text-[10px] uppercase tracking-widest text-[#C9A24B] mb-2 font-medium">Domestic Logistics & Payment:</span>
                        <div class="flex flex-wrap gap-1.5 text-[10px] text-[#F5EFE6]/80">
                            <span class="bg-[#160A0D] border border-[#C9A24B]/30 px-2 py-1 rounded flex items-center space-x-1"><i class="fas fa-money-bill-wave text-[#C9A24B]"></i><span>Cash on Delivery</span></span>
                            <span class="bg-[#160A0D] border border-[#C9A24B]/30 px-2 py-1 rounded flex items-center space-x-1"><i class="fas fa-mobile-screen text-[#C9A24B]"></i><span>JazzCash</span></span>
                            <span class="bg-[#160A0D] border border-[#C9A24B]/30 px-2 py-1 rounded flex items-center space-x-1"><i class="fas fa-wallet text-[#C9A24B]"></i><span>EasyPaisa</span></span>
                            <span class="bg-[#160A0D] border border-[#C9A24B]/30 px-2 py-1 rounded flex items-center space-x-1"><i class="fas fa-building-columns text-[#C9A24B]"></i><span>Raast / Bank</span></span>
                            <span class="bg-[#160A0D] border border-[#C9A24B]/30 px-2 py-1 rounded flex items-center space-x-1"><i class="fas fa-plane text-[#C9A24B]"></i><span>TCS Express Air</span></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Icons -->
            <div class="border-t border-[#C9A24B]/20 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-[#F5EFE6]/50 space-y-4 md:space-y-0">
                <div>
                    &copy; {{ date('Y') }} Perfumes Collection Ltd. All rights reserved. Registered Haute Parfumerie in Pakistan.
                </div>
                <div class="flex items-center space-x-4">
                    <a href="https://instagram.com" target="_blank" class="hover:text-[#C9A24B] transition"><i class="fab fa-instagram text-sm"></i></a>
                    <a href="https://facebook.com" target="_blank" class="hover:text-[#C9A24B] transition"><i class="fab fa-facebook-f text-sm"></i></a>
                    <a href="https://wa.me/923001234567" target="_blank" class="hover:text-[#C9A24B] transition"><i class="fab fa-whatsapp text-sm"></i></a>
                    <a href="https://youtube.com" target="_blank" class="hover:text-[#C9A24B] transition"><i class="fab fa-youtube text-sm"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 7. Slide-In Cart Drawer -->
    <div id="cartDrawerBackdrop" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300"></div>
    <aside id="cartDrawer" class="cart-drawer fixed inset-y-0 right-0 z-50 w-full max-w-md bg-[#0C0507] border-l border-[#C9A24B]/35 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Drawer Header -->
        <div class="p-5 border-b border-[#C9A24B]/25 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-shopping-bag text-[#C9A24B]"></i>
                <h3 class="font-serif text-lg tracking-wider text-[#F5EFE6]">Private Collection Vault</h3>
            </div>
            <button type="button" id="closeCartDrawer" class="text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition">&times;</button>
        </div>

        <!-- Dynamic Drawer Cart Items Body (Loaded via AJAX) -->
        <div id="cartDrawerBody" class="flex-1 overflow-y-auto p-5 space-y-4">
            <div class="text-center py-12 text-[#F5EFE6]/50">
                <i class="fas fa-gem text-3xl text-[#C9A24B]/40 mb-3 animate-pulse"></i>
                <p>Retrieving your private vault selections...</p>
            </div>
        </div>

        <!-- Drawer Footer with Subtotal & Checkout -->
        <div id="cartDrawerFooter" class="p-5 border-t border-[#C9A24B]/25 bg-[#080304] space-y-3" style="display: none;">
            <div class="flex items-center justify-between text-sm">
                <span class="text-[#F5EFE6]/70 uppercase tracking-wider text-xs">Privilege Subtotal:</span>
                <span id="cartDrawerSubtotal" class="font-serif text-xl text-[#C9A24B] font-bold">Rs. 0</span>
            </div>
            <p class="text-[11px] text-[#F5EFE6]/50 text-center">
                <i class="fas fa-shield-alt text-[#C9A24B] mr-1"></i> Free Express Air Shipping & COD included across Pakistan
            </p>
            <a href="https://wa.me/923001234567?text={{ urlencode('Salam! I want to proceed to checkout with my perfume selection.') }}" target="_blank" class="w-full btn-whatsapp py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2 block text-center">
                <i class="fab fa-whatsapp"></i>
                <span>PROCEED VIA WHATSAPP CONCIERGE</span>
            </a>
            <button type="button" onclick="alert('Proceeding to Checkout with Cash on Delivery (Part 2 Integration).')" class="w-full btn-gold py-3 text-xs tracking-widest uppercase block text-center">
                PROCEED TO CHECKOUT (COD)
            </button>
        </div>
    </aside>

    <!-- 8. Interactive Search Modal -->
    <div id="searchModal" class="luxury-modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <div class="luxury-modal-content relative w-full max-w-2xl bg-[#0D0507] border border-[#C9A24B]/40 rounded-lg p-6 sm:p-8 shadow-2xl transform scale-95 transition-all duration-300">
            <button id="closeSearchModal" class="modal-close-btn absolute top-4 right-4 text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition">&times;</button>
            <span class="block text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] mb-1 font-semibold">THE PRIVATE VAULT SEARCH</span>
            <h3 class="font-serif text-2xl text-[#F5EFE6] mb-4">Explore Our Olfactory Compositions</h3>
            
            <div class="relative mb-6">
                <input 
                    type="text" 
                    id="luxurySearchInput" 
                    placeholder="Search by note (Oud, Saffron, Rose), concentration, or title..." 
                    class="w-full bg-[#120709] border border-[#C9A24B]/40 rounded px-4 py-3.5 text-sm text-[#F5EFE6] focus:outline-none focus:border-[#C9A24B]"
                >
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
    <div id="scentQuizModal" class="luxury-modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
        <div class="luxury-modal-content relative w-full max-w-xl bg-[#0D0507] border border-[#C9A24B]/40 rounded-lg p-6 sm:p-8 shadow-2xl transform scale-95 transition-all duration-300">
            <button id="closeScentQuizBtn" class="modal-close-btn absolute top-4 right-4 text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition" onclick="document.getElementById('scentQuizModal').classList.remove('active')">&times;</button>
            <span class="block text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] mb-1 font-semibold">PERSONALIZED OLFACTORY ADVISOR</span>
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
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="royal" checked class="text-[#C9A24B]">
                            <span>Imperial Evening & Royal Presence</span>
                        </label>
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="wedding" class="text-[#C9A24B]">
                            <span>Grand Weddings & Celebrations</span>
                        </label>
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_occasion" value="summer" class="text-[#C9A24B]">
                            <span>Daytime Executive & Fresh</span>
                        </label>
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
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
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
                            <input type="radio" name="quiz_intensity" value="beast" checked class="text-[#C9A24B]">
                            <span>Beast Mode (16+ Hours Room-Filling)</span>
                        </label>
                        <label class="bg-[#14080B] border border-[#C9A24B]/20 p-3 rounded cursor-pointer flex items-center space-x-2 hover:border-[#C9A24B]">
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
        <button 
            type="button" 
            id="backToTopBtn" 
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="w-10 h-10 rounded-full bg-[#0C0507] border border-[#C9A24B]/50 text-[#C9A24B] shadow-2xl flex items-center justify-center hover:bg-[#C9A24B] hover:text-[#080304] transition-all opacity-0 pointer-events-none duration-300"
            title="Back to Top"
        >
            <i class="fas fa-arrow-up text-xs"></i>
        </button>

        <!-- Floating WhatsApp Concierge Button -->
        <a 
            href="https://wa.me/923001234567?text={{ urlencode('Salam! I am reaching out from your website for fragrance assistance.') }}" 
            target="_blank" 
            class="w-12 h-12 rounded-full bg-[#25D366] text-white shadow-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300 animate-bounce"
            title="WhatsApp Concierge"
        >
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
        document.addEventListener('DOMContentLoaded', function() {
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
