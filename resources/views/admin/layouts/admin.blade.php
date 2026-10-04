<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Perfumes Collection</title>

    <!-- Google Fonts: DM Sans & Jost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS ONLY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #0d6efd;
            --body-bg: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --card-border: #e2e8f0;
        }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #adminSidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 2px 0 8px rgba(0,0,0,0.06);
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
        }

        .sidebar-brand img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .sidebar-brand-text {
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            color: #ffffff;
            font-size: 1.05rem;
            letter-spacing: 0.06em;
            line-height: 1.2;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.75rem;
        }

        .sidebar-heading {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #94a3b8;
            padding: 0.75rem 0.75rem 0.35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 0.15rem;
        }

        .sidebar-link i {
            width: 1.25rem;
            text-align: center;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .sidebar-link:hover i {
            color: #ffffff;
        }

        .sidebar-link.active {
            color: #ffffff;
            background-color: var(--sidebar-active);
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: #ffffff;
        }

        .sidebar-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background-color: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Main Content Wrapper */
        #adminMain {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .admin-topbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--card-border);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .admin-content {
            padding: 1.75rem 1.5rem;
            flex: 1;
        }

        /* Mobile Sidebar adjustments */
        @media (max-width: 991.98px) {
            #adminSidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #adminSidebar.show {
                margin-left: 0;
            }
            #adminMain {
                margin-left: 0;
            }
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1030;
                display: none;
            }
            .sidebar-backdrop.show {
                display: block;
            }
        }

        /* Clean Bootstrap Bridge for Existing Admin Views */
        .bg-brand-surface, .bg-brand-card {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
            color: #1e293b !important;
        }

        .text-brand-text { color: #1e293b !important; }
        .text-brand-muted { color: #64748b !important; }
        .text-brand-gold { color: #0d6efd !important; }
        .border-brand-border, [class*="border-brand-border"] { border-color: #e2e8f0 !important; }
        
        .gold-btn, .admin-btn-primary {
            background-color: #0d6efd !important;
            border: 1px solid #0d6efd !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 0.375rem !important;
            height: 38px !important;
            padding: 0 1rem !important;
            font-size: 0.85rem !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(13, 110, 253, 0.15) !important;
            white-space: nowrap !important;
        }
        .gold-btn:hover, .admin-btn-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a58ca !important;
            color: #ffffff !important;
        }

        .admin-btn-secondary {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #475569 !important;
            font-weight: 500 !important;
            border-radius: 0.375rem !important;
            height: 38px !important;
            padding: 0 0.875rem !important;
            font-size: 0.85rem !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.4rem !important;
            transition: all 0.15s ease;
            white-space: nowrap !important;
        }
        .admin-btn-secondary:hover {
            background-color: #f8fafc !important;
            color: #1e293b !important;
            border-color: #94a3b8 !important;
        }

        .admin-btn-reset {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #64748b !important;
            border-radius: 0.375rem !important;
            width: 38px !important;
            height: 38px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 0.85rem !important;
            text-decoration: none !important;
            transition: all 0.15s ease;
            flex-shrink: 0 !important;
        }
        .admin-btn-reset:hover {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #94a3b8 !important;
        }

        /* Standard Admin Containers */
        .admin-card {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
            overflow: hidden !important;
            margin-bottom: 1.5rem !important;
        }

        .admin-filter-bar {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
            padding: 1rem 1.25rem !important;
            margin-bottom: 1.25rem !important;
        }

        /* Clean Forms & Inputs */
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="url"], input[type="date"], select, textarea {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.375rem !important;
            height: 38px;
            padding: 0.45rem 0.75rem !important;
            font-size: 0.85rem !important;
            width: 100%;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        textarea {
            height: auto !important;
            min-height: 80px;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15) !important;
            outline: none !important;
        }

        /* Standard Action Buttons */
        .admin-action-btn {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
            border-radius: 0.375rem !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 0.75rem !important;
            transition: all 0.15s ease !important;
            text-decoration: none !important;
            padding: 0 !important;
        }
        .admin-action-view {
            color: #64748b !important;
        }
        .admin-action-view:hover {
            color: #0d6efd !important;
            background-color: #eff6ff !important;
            border-color: #bfdbfe !important;
        }
        .admin-action-edit {
            color: #0d6efd !important;
        }
        .admin-action-edit:hover {
            color: #0a58ca !important;
            background-color: #eff6ff !important;
            border-color: #93c5fd !important;
        }
        .admin-action-delete {
            color: #ef4444 !important;
        }
        .admin-action-delete:hover {
            color: #dc2626 !important;
            background-color: #fef2f2 !important;
            border-color: #fecaca !important;
        }

        /* Clean Standardized Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            color: #1e293b !important;
            background-color: #ffffff !important;
        }

        th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 0.75rem 1rem !important;
            white-space: nowrap !important;
        }

        td {
            padding: 0.75rem 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.85rem !important;
            vertical-align: middle !important;
        }

        tr:hover td {
            background-color: #f8fafc !important;
        }

        /* Alignment Utilities for Tables */
        th.text-end, td.text-end {
            text-align: right !important;
        }
        th.text-center, td.text-center {
            text-align: center !important;
        }

        /* Standard Status Badges */
        .admin-badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            padding: 0.25rem 0.65rem !important;
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            border-radius: 0.375rem !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
        }
        .admin-badge-success {
            background-color: #ecfdf5 !important;
            color: #059669 !important;
            border: 1px solid #a7f3d0 !important;
        }
        .admin-badge-warning {
            background-color: #fffbeb !important;
            color: #d97706 !important;
            border: 1px solid #fde68a !important;
        }
        .admin-badge-danger {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fecaca !important;
        }
        .admin-badge-info {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid #bfdbfe !important;
        }
        .admin-badge-secondary {
            background-color: #f8fafc !important;
            color: #64748b !important;
            border: 1px solid #e2e8f0 !important;
        }
        .admin-badge-purple {
            background-color: #faf5ff !important;
            color: #7c3aed !important;
            border: 1px solid #ddd6fe !important;
        }

        /* Standard Image Thumbnails with Click-to-Preview UX */
        .admin-thumb-box {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
            border-radius: 0.5rem !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            padding: 2px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            position: relative !important;
            flex-shrink: 0 !important;
        }
        .admin-thumb-box:hover {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2) !important;
            transform: scale(1.06) !important;
        }
        .admin-thumb-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
            border-radius: 0.375rem !important;
        }
        .admin-thumb-img-cover {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 0.375rem !important;
        }

        /* Standard Pagination Bar */
        .admin-pagination-bar {
            padding: 0.85rem 1.25rem !important;
            border-top: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Grid Utilities Bridge */
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .md\:col-span-2 { grid-column: span 2 / span 2; }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .lg\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
            .lg\:grid-cols-6 { grid-template-columns: repeat(6, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:col-span-3 { grid-column: span 3 / span 3; }
        }

        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body x-data="{ mobileNav: false, previewModal: false, previewImgUrl: '', previewImgTitle: '' }" 
      @open-preview.window="previewModal = true; previewImgUrl = $event.detail.url; previewImgTitle = $event.detail.title || 'Image Preview'" 
      @keydown.escape.window="previewModal = false">

    <!-- Mobile Backdrop -->
    <div class="sidebar-backdrop" :class="{ 'show': mobileNav }" @click="mobileNav = false"></div>

    <!-- Simple Modern Bootstrap Sidebar -->
    <aside id="adminSidebar" :class="{ 'show': mobileNav }">
        <!-- Brand Header (Left Logo + Perfumes Collection) -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" class="me-2">
            <div>
                <div class="sidebar-brand-text">PERFUMES COLLECTION</div>
                <small class="text-secondary text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.15em;">Admin Center</small>
            </div>
        </a>

        <!-- Navigation Links -->
        <nav class="sidebar-nav">
            <div class="sidebar-heading">MAIN</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-heading">CATALOGUE</div>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-spray-can-sparkles"></i>
                <span>Products & Impressions</span>
            </a>

            <a href="{{ route('admin.bundles.index') }}" class="sidebar-link {{ request()->routeIs('admin.bundles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gift"></i>
                <span>Bundles & Sets</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i>
                <span>Categories</span>
            </a>

            <div class="sidebar-heading">SALES & CUSTOMERS</div>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Orders & Receipts</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Customers</span>
            </a>

            <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="fa-solid fa-ticket"></i>
                <span>Coupons & Discounts</span>
            </a>

            <div class="sidebar-heading">CONTENT</div>
            <a href="{{ route('admin.hero-slides.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                <i class="fa-solid fa-images"></i>
                <span>Hero Banners</span>
            </a>

            <a href="{{ route('admin.blogs.index') }}" class="sidebar-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog Articles</span>
            </a>

            <div class="sidebar-heading">ADMINISTRATION</div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield"></i>
                <span>Staff & Roles</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                <span>Store Settings</span>
            </a>

            <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Activity Logs</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="d-flex align-items-center text-white text-decoration-none">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.85rem;">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden" style="max-width: 130px;">
                    <div class="small fw-semibold text-truncate text-white">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="text-secondary d-block text-truncate" style="font-size: 0.7rem;">{{ Auth::user()->role ?? 'Administrator' }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Layout -->
    <div id="adminMain">
        <!-- Top Navbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-light border d-lg-none" @click="mobileNav = true">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold text-dark font-['Jost']">@yield('page_title', 'Dashboard')</h5>
                    <small class="text-muted d-none d-sm-inline">@yield('page_subtitle', 'Perfumes Collection Management Suite')</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @yield('header_actions')

                <!-- View Store Button -->
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square small"></i>
                    <span class="d-none d-sm-inline">View Store</span>
                </a>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-circle"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear me-2 text-muted"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between mb-3 shadow-xs" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check text-success"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between mb-3 shadow-xs" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-danger"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-between mb-3 shadow-xs" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <!-- Global Responsive Image Preview Modal -->
    <div x-show="previewModal" 
         class="fixed inset-0 z-[1060] flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" 
         style="display: none;" 
         @click.self="previewModal = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden max-w-[92vw] max-h-[88vh] flex flex-col border border-slate-200" 
             @click.outside="previewModal = false">
            <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-3 flex-shrink-0">
                <div class="flex items-center gap-2 truncate">
                    <i class="fa-solid fa-image text-primary small"></i>
                    <span class="text-xs font-semibold text-slate-800 truncate" x-text="previewImgTitle"></span>
                </div>
                <button type="button" @click="previewModal = false" 
                        class="w-7 h-7 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 hover:text-slate-900 flex items-center justify-center text-xs transition border-0" 
                        title="Close (ESC)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-3 bg-slate-900/95 flex items-center justify-center overflow-auto max-h-[calc(88vh-55px)] select-none">
                <img :src="previewImgUrl" :alt="previewImgTitle" 
                     class="max-w-[88vw] max-h-[78vh] object-contain rounded shadow-lg transition-transform duration-200"
                     style="user-select: none;">
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global Image Preview Dispatcher
        window.previewImage = function(url, title) {
            if (!url) return;
            window.dispatchEvent(new CustomEvent('open-preview', {
                detail: { url: url, title: title || 'Image Preview' }
            }));
        };
    </script>

    @stack('scripts')
</body>
</html>
