<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Concierge') | Perfumes Collection Haute Parfumerie</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js CDN for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            black: '#080304',
                            surface: '#11070A',
                            card: '#160B0E',
                            border: '#2A151B',
                            gold: '#C9A24B',
                            goldLight: '#E6C77A',
                            goldDark: '#8F6E26',
                            text: '#F5EFE6',
                            muted: '#9E8E81',
                            maroon: '#4A0E17',
                            maroonDark: '#2C080E'
                        }
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        display: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #080304;
            color: #F5EFE6;
            font-family: 'Inter', sans-serif;
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #C9A24B 0%, #E6C77A 50%, #8F6E26 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border-glow {
            border: 1px solid rgba(201, 162, 75, 0.25);
            box-shadow: 0 0 15px rgba(201, 162, 75, 0.05);
        }
        .gold-btn {
            background: linear-gradient(135deg, #C9A24B 0%, #E6C77A 100%);
            color: #080304;
            font-weight: 600;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
        }
        .gold-btn:hover {
            box-shadow: 0 0 20px rgba(201, 162, 75, 0.4);
            transform: translateY(-1px);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #080304;
        }
        ::-webkit-scrollbar-thumb {
            background: #2A151B;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #C9A24B;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/80 z-40 lg:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-brand-surface border-r border-brand-border/60 flex flex-col transition-transform duration-300 ease-in-out">
        
        <!-- Brand Header -->
        <div class="h-20 px-6 border-b border-brand-border/40 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border border-brand-gold/40 flex items-center justify-center bg-brand-maroon/30 text-brand-gold">
                    <i class="fa-solid fa-crown text-sm"></i>
                </div>
                <div>
                    <span class="font-serif tracking-widest text-base font-bold gold-gradient-text block leading-none">PERFUMES COLLECTION</span>
                    <span class="text-[9px] uppercase tracking-[0.25em] text-brand-gold/70 block mt-1">Admin Concierge</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-brand-muted hover:text-brand-text">
                <i class="fa-solid fa-times text-lg"></i>
            </button>
        </div>

        <!-- Live Pulse Bar -->
        <div class="px-6 py-2.5 bg-brand-black/40 border-b border-brand-border/30 flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-brand-muted text-[11px] tracking-wider uppercase">Live Telemetry</span>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-brand-gold hover:text-brand-goldLight text-[11px] flex items-center gap-1 transition">
                <span>View Store</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-xs"></i>
                <span>Overview & Analytics</span>
            </a>

            <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase tracking-[0.2em] text-brand-gold/60 font-semibold">Catalogue Suite</div>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.products.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-spray-can-sparkles w-5 text-center text-xs"></i>
                <span>Fragrances Vault</span>
            </a>

            <a href="{{ route('admin.bundles.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.bundles.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-gift w-5 text-center text-xs"></i>
                <span>Luxury Bundles</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-layer-group w-5 text-center text-xs"></i>
                <span>Collections & Categories</span>
            </a>

            <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase tracking-[0.2em] text-brand-gold/60 font-semibold">Sales & Patrons</div>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-receipt w-5 text-center text-xs"></i>
                <span>Orders & Receipts</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.customers.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-users-viewfinder w-5 text-center text-xs"></i>
                <span>Patrons Intelligence</span>
            </a>

            <a href="{{ route('admin.coupons.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.coupons.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-ticket-simple w-5 text-center text-xs"></i>
                <span>Privilege Coupons</span>
            </a>

            <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase tracking-[0.2em] text-brand-gold/60 font-semibold">Content & Brand</div>

            <a href="{{ route('admin.blogs.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.blogs.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-feather-pointed w-5 text-center text-xs"></i>
                <span>Fragrance Journal</span>
            </a>

            <a href="{{ route('admin.hero-slides.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.hero-slides.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-images w-5 text-center text-xs"></i>
                <span>Showcase Slides</span>
            </a>

            <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase tracking-[0.2em] text-brand-gold/60 font-semibold">Control & Security</div>

            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-sliders w-5 text-center text-xs"></i>
                <span>Gateways & Settings</span>
            </a>

            <a href="{{ route('admin.activity-logs.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-brand-gold/15 text-brand-gold font-medium border border-brand-gold/30' : 'text-brand-muted hover:text-brand-text hover:bg-brand-card' }}">
                <i class="fa-solid fa-shield-halved w-5 text-center text-xs"></i>
                <span>Audit & Security Logs</span>
            </a>
        </nav>

        <!-- Admin Profile Footer -->
        <div class="p-4 border-t border-brand-border/60 bg-brand-black/50 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-brand-maroon/60 border border-brand-gold/40 flex items-center justify-center font-bold text-xs text-brand-gold">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0">
                    <div class="text-xs font-medium text-brand-text truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-brand-gold tracking-wider uppercase truncate">Maison Admin</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="w-8 h-8 rounded-lg flex items-center justify-center text-brand-muted hover:text-rose-400 hover:bg-rose-950/30 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-72">

        <!-- Top Bar -->
        <header class="h-20 bg-brand-surface/90 backdrop-blur border-b border-brand-border/60 px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-brand-muted hover:text-brand-text p-2">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="font-serif text-xl lg:text-2xl font-semibold text-brand-text tracking-wide">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-brand-muted hidden sm:block">@yield('page_subtitle', 'Haute Parfumerie Operations Center')</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @yield('header_actions')
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="mx-6 mt-4 p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/30 text-emerald-300 flex items-center justify-between text-sm shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-200"><i class="fa-solid fa-times"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" 
                 class="mx-6 mt-4 p-4 rounded-xl bg-rose-950/40 border border-rose-500/30 text-rose-300 flex items-center justify-between text-sm shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-rose-200"><i class="fa-solid fa-times"></i></button>
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }" x-show="show" 
                 class="mx-6 mt-4 p-4 rounded-xl bg-amber-950/40 border border-amber-500/30 text-amber-300 flex items-center justify-between text-sm shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-amber-400 text-lg"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button @click="show = false" class="text-amber-400 hover:text-amber-200"><i class="fa-solid fa-times"></i></button>
            </div>
        @endif

        <!-- Scrollable Page Body -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
