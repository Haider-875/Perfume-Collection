<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Perfumes Collection</title>

    <!-- Luxury Brand Favicon & Icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/brand/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/brand/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/brand/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#541B29">

    <!-- Google Fonts: Plus Jakarta Sans & Jost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS ONLY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme Initialization Script (Prevents FOUT) -->
    <script>
        (function() {
            var savedTheme = localStorage.getItem('pc_admin_theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --sidebar-width: 255px;
            --sidebar-bg: #0f172a;
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --sidebar-link-text: #94a3b8;
            --sidebar-link-hover: rgba(255, 255, 255, 0.06);
            --sidebar-link-active-bg: #2563eb;
            --sidebar-link-active-text: #ffffff;
            --body-bg: #f4f6fa;
            --card-bg: #ffffff;
            --card-border: #f1f3f7;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 6px 18px rgba(0, 0, 0, 0.02);
            --text-dark: #111827;
            --text-muted: #8c9ba8;
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --accent-amber: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Modern Dark Left Menu Bar */
        #adminSidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
        }

        .sidebar-brand {
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--sidebar-border);
            text-decoration: none;
            background-color: var(--sidebar-bg);
        }

        .sidebar-brand-logo-wrap {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
        }

        .sidebar-brand-badge {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            color: #f8fafc;
            font-size: 1.12rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar-collapse-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .sidebar-collapse-btn:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.85rem;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }

        .sidebar-heading {
            font-size: 11px !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 0.85rem 0.75rem 0.35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.85rem;
            color: var(--sidebar-link-text);
            text-decoration: none;
            border-radius: 0.65rem;
            font-size: 14px !important;
            font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 0.2rem;
        }

        .sidebar-link-inner {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-link i {
            width: 1.25rem;
            text-align: center;
            font-size: 15px !important;
            color: #64748b;
            transition: color 0.15s ease;
        }

        .sidebar-link:hover {
            color: #f8fafc;
            background-color: var(--sidebar-link-hover);
        }

        .sidebar-link:hover i {
            color: #f8fafc;
        }

        /* Active Sidebar Link (Distinct vibrant blue with white text) */
        .sidebar-link.active {
            color: var(--sidebar-link-active-text) !important;
            background-color: var(--sidebar-link-active-bg) !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.35);
        }

        .sidebar-link.active i {
            color: var(--sidebar-link-active-text) !important;
        }

        .sidebar-active-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #ffffff;
            display: inline-block;
        }

        /* Sidebar Promo Card ("Upgrade to Premium!" in Reference Image) */
        .sidebar-promo-card {
            background: linear-gradient(145deg, #1e293b 0%, #0b1120 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }
        .sidebar-promo-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.45) 0%, transparent 70%);
            pointer-events: none;
        }
        .promo-icon-badge {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: rgba(37, 99, 235, 0.3);
            border: 1px solid rgba(59, 130, 246, 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 13px;
        }
        .promo-title {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 3px;
        }
        .promo-desc {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.4;
            margin-bottom: 11px;
        }
        .promo-btn {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 9999px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 0.42rem 1rem !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.35) !important;
            display: block;
            text-align: center;
            text-decoration: none;
        }
        .promo-btn:hover {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .sidebar-footer {
            padding: 0.85rem 1rem;
            border-top: 1px solid var(--sidebar-border);
            background-color: var(--sidebar-bg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13.5px !important;
        }

        /* Main Content Wrapper */
        #adminMain {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Topbar (Matching Reference Image) */
        .admin-topbar {
            height: 72px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--sidebar-border);
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.015);
        }

        .topbar-search-box {
            background-color: #ffffff;
            border: 1px solid #eef1f6;
            border-radius: 9999px;
            padding: 0.45rem 1rem;
            width: 320px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }
        .topbar-search-box:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .topbar-search-input {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            font-size: 13px !important;
            height: auto !important;
            outline: none !important;
            color: #111827 !important;
            width: 100%;
        }
        .search-kbd-badge {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            background-color: #f8fafc;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .topbar-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #ffffff;
            border: 1px solid #eef1f6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            position: relative;
            transition: all 0.15s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .topbar-icon-btn:hover {
            background-color: #f8fafc;
            color: #111827;
            border-color: #cbd5e1;
        }
        .topbar-icon-btn .unread-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #2563eb;
            border: 1.5px solid #ffffff;
        }

        .topbar-avatar-wrap {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            cursor: pointer;
        }
        .topbar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1.5px solid #e2e8f0;
            color: #2563eb;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .topbar-avatar .avatar-online-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #10b981;
            border: 2px solid #ffffff;
        }

        .admin-content {
            padding: 1.75rem 1.75rem;
            flex: 1;
        }

        .sidebar-backdrop {
            display: none;
        }

        /* Mobile Sidebar adjustments */
        @media (max-width: 991.98px) {
            #adminSidebar {
                transform: translateX(-100%);
                margin-left: 0 !important;
                transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
            }
            #adminSidebar.show {
                transform: translateX(0);
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
            }
            #adminMain {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                min-width: 0 !important;
            }
            .sidebar-backdrop {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);
                z-index: 1030;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.25s ease, visibility 0.25s ease;
            }
            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
        }

        @media (max-width: 767.98px) {
            .admin-topbar {
                height: 60px !important;
                min-height: 60px;
                padding: 0 1rem !important;
                flex-wrap: nowrap;
                gap: 0.75rem;
            }
            .admin-content {
                padding: 0.85rem 0.75rem !important;
            }
            .admin-filter-bar {
                padding: 0.75rem !important;
            }
            .admin-card {
                margin-bottom: 0.85rem;
            }
            .table-responsive {
                max-width: 100%;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                overscroll-behavior-x: contain;
                margin-bottom: 0;
            }
            input[type="text"], input[type="email"], input[type="password"], input[type="number"], 
            input[type="url"], input[type="date"], select, textarea, .form-control, .form-select {
                font-size: 15px !important;
            }
        }

        html, body {
            max-width: 100vw;
            overflow-x: hidden !important;
        }

        body.overflow-hidden {
            overflow: hidden !important;
            touch-action: none;
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
            height: 40px !important;
            padding: 0 1.15rem !important;
            font-size: 14px !important;
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
            height: 40px !important;
            padding: 0 1rem !important;
            font-size: 14px !important;
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
            width: 40px !important;
            height: 40px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
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
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], 
        input[type="url"], input[type="date"], select, textarea, .form-control, .form-select {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.375rem !important;
            height: 40px;
            padding: 0.5rem 0.85rem !important;
            font-size: 14px !important;
            width: 100%;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        textarea, textarea.form-control {
            height: auto !important;
            min-height: 85px;
        }

        input:focus, select:focus, textarea:focus, .form-control:focus, .form-select:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15) !important;
            outline: none !important;
        }

        /* Standard Action Buttons */
        .admin-action-btn {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            border-radius: 0.375rem !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 13.5px !important;
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
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 0.85rem 1rem !important;
            white-space: nowrap !important;
        }

        td {
            padding: 0.85rem 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
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

        /* Standard Status Badges (Minimum 13px) */
        .admin-badge, .badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            padding: 0.32rem 0.65rem !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            border-radius: 0.375rem !important;
            line-height: 1.25 !important;
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

        /* Action buttons spacing */
        .table td .d-inline-flex,
        .admin-actions-cell .d-inline-flex {
            gap: 8px !important;
        }
        .gap-1\.5 {
            gap: 8px !important;
        }

        /* Standard SaaS Admin Pagination Bar */
        .admin-pagination-bar {
            padding: 0.95rem 1.5rem !important;
            border-top: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
        }

        .admin-pagination-wrapper {
            width: 100% !important;
        }

        .admin-pagination-info {
            font-size: 13.5px !important;
            color: #64748b !important;
        }

        .admin-pagination-list {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .admin-page-item {
            display: inline-flex !important;
            list-style: none !important;
        }

        .admin-page-link {
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            color: #334155 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: all 0.15s ease !important;
            user-select: none;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
        }

        .admin-page-link:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        .admin-page-link.active,
        .admin-page-item.active .admin-page-link {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 3px rgba(13, 110, 253, 0.3) !important;
        }

        .admin-page-link.disabled,
        .admin-page-item.disabled .admin-page-link {
            opacity: 0.55 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
            background-color: #f8fafc !important;
            color: #94a3b8 !important;
            border-color: #e2e8f0 !important;
            box-shadow: none !important;
        }

        .admin-page-dots {
            border: none !important;
            background: transparent !important;
            color: #94a3b8 !important;
            box-shadow: none !important;
            min-width: 24px !important;
        }

        /* Fallback for standard bootstrap pagination if rendered */
        .admin-pagination-bar .pagination {
            margin: 0 !important;
            gap: 6px !important;
        }
        .admin-pagination-bar .page-link {
            font-size: 13px !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
            color: #334155 !important;
            background-color: #ffffff !important;
        }
        .admin-pagination-bar .page-item.active .page-link {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
        }

        /* Grid Utilities Bridge */
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        
        @media (max-width: 479.98px) {
            .grid-cols-2 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        }
        
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

        [x-cloak] { display: none !important; }
        .form-label, label {
            margin-bottom: 0.4rem;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #475569;
        }
        .form-check-input {
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* ==========================================================================
           GLOBAL MINIMUM FONT SIZE ENFORCEMENT (STRICT MINIMUM 13px ACROSS PORTAL)
           ========================================================================== */
        small, .small, .form-text, .admin-help-text, 
        .text-danger.small, .invalid-feedback,
        .font-monospace.small, code.small,
        .form-label, label, .form-check-label,
        .sidebar-heading, th,
        .admin-badge, .badge,
        .text-xs,
        [style*="font-size: 0.5"], [style*="font-size:0.5"],
        [style*="font-size: 0.6"], [style*="font-size:0.6"],
        [style*="font-size: 0.7"], [style*="font-size:0.7"],
        [style*="font-size: 0.72"], [style*="font-size:0.72"],
        [style*="font-size: 0.75"], [style*="font-size:0.75"],
        [style*="font-size: 0.78"], [style*="font-size:0.78"],
        [style*="font-size: 0.8rem"], [style*="font-size:0.8rem"],
        [style*="font-size: 8px"], [style*="font-size:8px"],
        [style*="font-size: 9px"], [style*="font-size:9px"],
        [style*="font-size: 10px"], [style*="font-size:10px"],
        [style*="font-size: 11px"], [style*="font-size:11px"],
        [style*="font-size: 12px"], [style*="font-size:12px"] {
            font-size: 13px !important;
        }

        /* Maintain comfortable reading & input sizes */
        td {
            font-size: 14px !important;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], 
        input[type="url"], input[type="date"], select, textarea, .form-control, .form-select {
            font-size: 14px !important;
        }
        .admin-action-btn {
            font-size: 13.5px !important;
        }
        /* ==========================================================================
           DARK & LIGHT MODE THEMING ENGINE
           ========================================================================== */
        /* Dark Theme Variables & Component Inversion */
        [data-theme="dark"] {
            --body-bg: #0b0f19;
            --card-bg: #111827;
            --card-border: #1f293d;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
            --text-dark: #f8fafc;
            --text-muted: #94a3b8;
        }

        [data-theme="dark"] body,
        [data-theme="dark"] #adminMain,
        [data-theme="dark"] main {
            background-color: #0b0f19 !important;
            color: #f1f5f9 !important;
        }

        /* Topbar in Dark Mode */
        [data-theme="dark"] .admin-topbar {
            background-color: #111827 !important;
            border-bottom-color: #1f293d !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35) !important;
        }
        [data-theme="dark"] .topbar-search-box {
            background-color: #182235 !important;
            border-color: #24324c !important;
        }
        [data-theme="dark"] .topbar-search-input {
            color: #f8fafc !important;
        }
        [data-theme="dark"] .topbar-search-input::placeholder {
            color: #64748b !important;
        }
        [data-theme="dark"] .search-kbd-badge {
            background-color: #0f172a !important;
            border-color: #24324c !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .topbar-icon-btn {
            background-color: #182235 !important;
            border-color: #24324c !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .topbar-icon-btn:hover {
            background-color: #24324c !important;
            color: #f8fafc !important;
            border-color: #3b82f6 !important;
        }
        [data-theme="dark"] .topbar-icon-btn .unread-dot {
            border-color: #182235 !important;
        }
        [data-theme="dark"] .topbar-avatar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            border-color: #334155 !important;
            color: #60a5fa !important;
        }
        [data-theme="dark"] .topbar-avatar .avatar-online-dot {
            border-color: #111827 !important;
        }

        /* Dropdowns in Dark Mode */
        [data-theme="dark"] .dropdown-menu {
            background-color: #111827 !important;
            border: 1px solid #1f293d !important;
            color: #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }
        [data-theme="dark"] .dropdown-menu .dropdown-item {
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .dropdown-menu .dropdown-item:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        [data-theme="dark"] .dropdown-menu .dropdown-divider {
            border-color: #1f293d !important;
        }
        [data-theme="dark"] .dropdown-menu .text-dark {
            color: #f8fafc !important;
        }

        /* Cards, Surfaces & Containers in Dark Mode */
        [data-theme="dark"] .admin-card,
        [data-theme="dark"] .dash-card,
        [data-theme="dark"] .bg-brand-surface,
        [data-theme="dark"] .bg-brand-card,
        [data-theme="dark"] .card {
            background-color: #111827 !important;
            border-color: #1f293d !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .card-header,
        [data-theme="dark"] .admin-card-header {
            background-color: #151e30 !important;
            border-bottom-color: #1f293d !important;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .card-footer,
        [data-theme="dark"] .admin-card-footer {
            background-color: #151e30 !important;
            border-top-color: #1f293d !important;
            color: #cbd5e1 !important;
        }

        /* Filter Bar in Dark Mode */
        [data-theme="dark"] .admin-filter-bar {
            background-color: #111827 !important;
            border-color: #1f293d !important;
            color: #f1f5f9 !important;
        }

        /* Tables & Lists in Dark Mode */
        [data-theme="dark"] table,
        [data-theme="dark"] .table {
            background-color: #111827 !important;
            color: #f1f5f9 !important;
            border-color: #1f293d !important;
        }
        [data-theme="dark"] th,
        [data-theme="dark"] .table thead th {
            background-color: #162032 !important;
            color: #cbd5e1 !important;
            border-bottom-color: #1f293d !important;
        }
        [data-theme="dark"] td,
        [data-theme="dark"] .table tbody td {
            background-color: #111827 !important;
            color: #e2e8f0 !important;
            border-bottom-color: #1a2436 !important;
        }
        [data-theme="dark"] tr:hover td,
        [data-theme="dark"] .table tbody tr:hover td {
            background-color: #182235 !important;
            color: #ffffff !important;
        }

        /* Form Inputs & Controls in Dark Mode */
        [data-theme="dark"] input[type="text"],
        [data-theme="dark"] input[type="email"],
        [data-theme="dark"] input[type="password"],
        [data-theme="dark"] input[type="number"],
        [data-theme="dark"] input[type="url"],
        [data-theme="dark"] input[type="date"],
        [data-theme="dark"] select,
        [data-theme="dark"] textarea,
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #162032 !important;
            color: #f8fafc !important;
            border-color: #24324c !important;
        }
        [data-theme="dark"] input::placeholder,
        [data-theme="dark"] textarea::placeholder {
            color: #64748b !important;
        }
        [data-theme="dark"] input:focus,
        [data-theme="dark"] select:focus,
        [data-theme="dark"] textarea:focus,
        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #182235 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
        }
        [data-theme="dark"] .form-label,
        [data-theme="dark"] label {
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .input-group-text {
            background-color: #1f293d !important;
            border-color: #24324c !important;
            color: #cbd5e1 !important;
        }

        /* Buttons & Actions in Dark Mode */
        [data-theme="dark"] .admin-btn-secondary {
            background-color: #182235 !important;
            border-color: #24324c !important;
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .admin-btn-secondary:hover {
            background-color: #24324c !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }
        [data-theme="dark"] .admin-btn-reset {
            background-color: #182235 !important;
            border-color: #24324c !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .admin-btn-reset:hover {
            background-color: #24324c !important;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .admin-action-btn {
            background-color: #182235 !important;
            border-color: #24324c !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .admin-action-btn:hover {
            background-color: #24324c !important;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .admin-action-view:hover {
            color: #60a5fa !important;
            background-color: rgba(37, 99, 235, 0.2) !important;
            border-color: #3b82f6 !important;
        }
        [data-theme="dark"] .admin-action-edit:hover {
            color: #60a5fa !important;
            background-color: rgba(37, 99, 235, 0.2) !important;
            border-color: #3b82f6 !important;
        }
        [data-theme="dark"] .admin-action-delete:hover {
            color: #f87171 !important;
            background-color: rgba(239, 68, 68, 0.2) !important;
            border-color: #ef4444 !important;
        }

        /* SaaS Pagination in Dark Mode */
        [data-theme="dark"] .admin-pagination-bar {
            background-color: #141c2b !important;
            border-top-color: #1f293d !important;
        }
        [data-theme="dark"] .admin-pagination-info {
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .admin-page-link,
        [data-theme="dark"] .admin-pagination-bar .page-link {
            background-color: #182235 !important;
            border-color: #24324c !important;
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .admin-page-link:hover,
        [data-theme="dark"] .admin-pagination-bar .page-link:hover {
            background-color: #24324c !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }
        [data-theme="dark"] .admin-page-link.disabled,
        [data-theme="dark"] .admin-page-item.disabled .admin-page-link,
        [data-theme="dark"] .admin-pagination-bar .page-item.disabled .page-link {
            background-color: #131a27 !important;
            border-color: #1f293d !important;
            color: #64748b !important;
        }
        [data-theme="dark"] .admin-thumb-box {
            background-color: #162032 !important;
            border-color: #24324c !important;
        }

        /* Text Contrast Inversions in Dark Mode */
        [data-theme="dark"] .text-dark { color: #f8fafc !important; }
        [data-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-theme="dark"] .text-secondary { color: #94a3b8 !important; }
        [data-theme="dark"] .text-brand-text { color: #f8fafc !important; }
        [data-theme="dark"] .text-brand-muted { color: #94a3b8 !important; }
        [data-theme="dark"] .border-brand-border { border-color: #1f293d !important; }
        [data-theme="dark"] .border { border-color: #1f293d !important; }
        [data-theme="dark"] .border-bottom { border-bottom-color: #1f293d !important; }
        [data-theme="dark"] .border-top { border-top-color: #1f293d !important; }
        [data-theme="dark"] .border-light,
        [data-theme="dark"] .border-light-subtle { border-color: #1f293d !important; }
        [data-theme="dark"] .border-secondary-subtle { border-color: #24324c !important; }

        /* Bootstrap Light Surfaces & Badges in Dark Mode */
        [data-theme="dark"] .bg-white { background-color: #111827 !important; color: #f1f5f9 !important; }
        [data-theme="dark"] .bg-light { background-color: #182235 !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .bg-light-subtle { background-color: #182235 !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .bg-secondary-subtle { background-color: #1e293b !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .bg-primary-subtle { background-color: rgba(37, 99, 235, 0.15) !important; color: #60a5fa !important; border-color: rgba(37, 99, 235, 0.3) !important; }
        [data-theme="dark"] .bg-success-subtle { background-color: rgba(16, 185, 129, 0.15) !important; color: #34d399 !important; border-color: rgba(16, 185, 129, 0.3) !important; }
        [data-theme="dark"] .bg-warning-subtle { background-color: rgba(245, 158, 11, 0.15) !important; color: #fbbf24 !important; border-color: rgba(245, 158, 11, 0.3) !important; }
        [data-theme="dark"] .bg-danger-subtle { background-color: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; border-color: rgba(239, 68, 68, 0.3) !important; }
        [data-theme="dark"] .bg-info-subtle { background-color: rgba(6, 182, 212, 0.15) !important; color: #22d3ee !important; border-color: rgba(6, 182, 212, 0.3) !important; }
        [data-theme="dark"] .btn-light { background-color: #182235 !important; border-color: #24324c !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .btn-light:hover { background-color: #24324c !important; border-color: #3b82f6 !important; color: #ffffff !important; }
        [data-theme="dark"] .btn-outline-secondary { border-color: #24324c !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .btn-outline-secondary:hover { background-color: #182235 !important; color: #ffffff !important; }
        [data-theme="dark"] .badge.bg-light { background-color: #182235 !important; color: #cbd5e1 !important; border-color: #24324c !important; }

        /* Badges In Dark Mode */
        [data-theme="dark"] .admin-badge-secondary {
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
            border-color: #334155 !important;
        }
        [data-theme="dark"] .admin-badge-success {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
        [data-theme="dark"] .admin-badge-warning {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
            border-color: rgba(245, 158, 11, 0.3) !important;
        }
        [data-theme="dark"] .admin-badge-danger {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }
        [data-theme="dark"] .admin-badge-info {
            background-color: rgba(37, 99, 235, 0.15) !important;
            color: #60a5fa !important;
            border-color: rgba(37, 99, 235, 0.3) !important;
        }

        /* Modals in Dark Mode */
        [data-theme="dark"] .modal-content {
            background-color: #111827 !important;
            border: 1px solid #1f293d !important;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .modal-header {
            border-bottom-color: #1f293d !important;
        }
        [data-theme="dark"] .modal-footer {
            border-top-color: #1f293d !important;
        }
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Theme Toggle Icon Switching */
        .theme-toggle-btn .theme-icon-sun {
            display: none;
        }
        .theme-toggle-btn .theme-icon-moon {
            display: inline-block;
        }
        [data-theme="dark"] .theme-toggle-btn .theme-icon-sun {
            display: inline-block;
            color: #fbbf24 !important;
        }
        [data-theme="dark"] .theme-toggle-btn .theme-icon-moon {
            display: none;
        }
    </style>
    @stack('styles')
</head>
<body x-data="{ mobileNav: false, previewModal: false, previewImgUrl: '', previewImgTitle: '' }" 
      x-init="$watch('mobileNav', val => document.body.classList.toggle('overflow-hidden', val))"
      :class="{ 'overflow-hidden': mobileNav }"
      @open-preview.window="previewModal = true; previewImgUrl = $event.detail.url; previewImgTitle = $event.detail.title || 'Image Preview'" 
      @keydown.escape.window="previewModal = false; mobileNav = false"
      @toggle-mobile-sidebar.window="mobileNav = !mobileNav"
      @close-mobile-sidebar.window="mobileNav = false"
      @open-mobile-sidebar.window="mobileNav = true">

    <!-- Mobile Backdrop -->
    <div class="sidebar-backdrop" :class="{ 'show': mobileNav }" @click="mobileNav = false"></div>

    @php
        $sidebarPendingCount = $pendingVerificationsCount ?? \App\Models\Order::where('payment_status', 'pending_verification')->count();
    @endphp

    <!-- Modern Bootstrap Sidebar with Full Perfumes Collection Navigation -->
    <aside id="adminSidebar" :class="{ 'show': mobileNav }">
        <!-- Brand Header (Left Brand + Collapse Icon) -->
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-logo-wrap">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" style="height: 38px; width: auto; object-fit: contain;">
                <div>
                    <div class="sidebar-brand-text">PERFUMES COLLECTION</div>
                    <small class="text-secondary text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.1em; display: block; line-height: 1.1;">Admin Center</small>
                </div>
            </a>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="sidebar-collapse-btn d-none d-lg-inline-flex" title="Sidebar View">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <button type="button" @click="mobileNav = false" class="btn text-secondary border-0 d-lg-none" aria-label="Close Sidebar" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fa-solid fa-xmark" style="font-size: 16px;"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Links with All Original Boutique Sections -->
        <nav class="sidebar-nav">
            <!-- MAIN -->
            <div class="sidebar-heading">MAIN</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    @if(request()->routeIs('admin.dashboard'))
                        <i class="fa-solid fa-check small text-primary" style="width: 14px; font-size: 11px !important;"></i>
                    @else
                        <i class="fa-solid fa-chart-pie"></i>
                    @endif
                    <span>Dashboard</span>
                </div>
            </a>

            <!-- CATALOGUE -->
            <div class="sidebar-heading">CATALOGUE</div>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-spray-can-sparkles"></i>
                    <span>Products & Impressions</span>
                </div>
            </a>

            <a href="{{ route('admin.products.import') }}" class="sidebar-link {{ request()->routeIs('admin.products.import*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-file-import"></i>
                    <span>Bulk Price Import</span>
                </div>
            </a>

            <a href="{{ route('admin.bundles.index') }}" class="sidebar-link {{ request()->routeIs('admin.bundles.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-gift"></i>
                    <span>Bundles & Sets</span>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Categories</span>
                </div>
            </a>

            <!-- SALES & CUSTOMERS -->
            <div class="sidebar-heading">SALES & CUSTOMERS</div>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Orders & Receipts</span>
                </div>
                @if($sidebarPendingCount > 0)
                    <span class="badge" style="background-color: #ecfdf5; color: #10b981; border: 1px solid #d1fae5; font-size: 11px; padding: 0.2rem 0.55rem; border-radius: 9999px; font-weight: 700;">
                        {{ $sidebarPendingCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-users"></i>
                    <span>Customers</span>
                </div>
            </a>

            <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-ticket"></i>
                    <span>Coupons & Discounts</span>
                </div>
            </a>

            <!-- CONTENT -->
            <div class="sidebar-heading">CONTENT</div>
            <a href="{{ route('admin.hero-slides.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-images"></i>
                    <span>Hero Banners</span>
                </div>
            </a>

            <!-- ADMINISTRATION -->
            <div class="sidebar-heading">ADMINISTRATION</div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Staff & Roles</span>
                </div>
            </a>

            <a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-key"></i>
                    <span>Profile & Password</span>
                </div>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-gear"></i>
                    <span>Store Settings</span>
                </div>
            </a>

            <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Activity Logs</span>
                </div>
            </a>

            <!-- Storefront Direct Link -->
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link mt-2">
                <div class="sidebar-link-inner">
                    <i class="fa-solid fa-store"></i>
                    <span>View Boutique</span>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 10px !important; color: #94a3b8; width: auto;"></i>
            </a>

        </nav>

        <!-- Sidebar Footer (Monogram Avatar & Sign Out) -->
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="d-flex align-items-center text-decoration-none" title="My Profile & Security">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px; font-size: 13px; background-color: #1e293b; color: #60a5fa; border: 1.5px solid rgba(255, 255, 255, 0.12);">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden" style="max-width: 120px;">
                    <div class="fw-semibold text-truncate text-white" style="font-size: 13px;">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="text-secondary d-block text-truncate" style="font-size: 11px;">{{ Auth::user()->role ?? 'Store Admin' }}</small>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm border-0 p-1 text-secondary" style="background: transparent; color: #94a3b8;" title="Logout" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Layout -->
    <div id="adminMain">
        <!-- Top Navbar (Matching Reference Image) -->
        <header class="admin-topbar">
            <!-- Left: Mobile Menu + Search Pill -->
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-light border d-lg-none" @click="mobileNav = true" aria-label="Open Sidebar" data-sidebar-toggle style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Search Input Pill (Matching Reference: "Search anything... ⌘K") -->
                <div class="topbar-search-box d-none d-md-flex align-items-center">
                    <i class="fa-solid fa-magnifying-glass text-muted me-2" style="font-size: 13px;"></i>
                    <input type="text" class="topbar-search-input" placeholder="Search anything..." aria-label="Search anything">
                    <span class="search-kbd-badge">⌘K</span>
                </div>
            </div>

            <!-- Right: Theme, Notifications, Avatar -->
            <div class="d-flex align-items-center gap-2">
                <!-- 1-Click Instant Cache Purge Button -->
                <form method="POST" action="{{ route('admin.cache.purge') }}" class="d-inline" onsubmit="return confirm('Purge application cache? This will clear all compiled views and refresh product listings immediately.');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1.5 px-2.5 py-1.5 rounded-pill shadow-xs" title="Clear Application Cache & Refresh Site" style="font-size: 12px; font-weight: 600; border-color: rgba(245, 158, 11, 0.4); color: #d97706;">
                        <i class="fa-solid fa-bolt" style="font-size: 11px;"></i>
                        <span class="d-none d-sm-inline">Purge Cache</span>
                    </button>
                </form>

                <!-- Dark & Light Mode Toggle Button -->
                <button type="button" class="topbar-icon-btn theme-toggle-btn" id="themeToggleBtn" onclick="window.toggleAdminTheme()" title="Toggle Dark / Light Mode" aria-label="Toggle Dark or Light Mode">
                    <i class="fa-solid fa-moon theme-icon-moon"></i>
                    <i class="fa-solid fa-sun theme-icon-sun"></i>
                </button>

                <!-- Notifications Bell with Dot -->
                <a href="{{ route('admin.orders.index', ['payment_status' => 'pending_verification']) }}" class="topbar-icon-btn position-relative" title="Notifications">
                    <i class="fa-regular fa-bell"></i>
                    @if(!empty($sidebarPendingCount) && $sidebarPendingCount > 0)
                        <span class="unread-dot"></span>
                    @endif
                </a>

                <!-- User Dropdown with Avatar & Online Dot -->
                <div class="dropdown ms-1">
                    <div class="topbar-avatar-wrap dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                        <div class="topbar-avatar">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            <span class="avatar-online-dot"></span>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius: 12px; min-width: 180px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark small">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-muted small" style="font-size: 11px;">{{ Auth::user()->email ?? 'admin@store.com' }}</div>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="fa-solid fa-key me-2 text-primary"></i>Profile & Password</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-store me-2 text-muted"></i>View Boutique</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear me-2 text-muted"></i>Store Settings</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Sign Out</button>
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
            @if(!request()->routeIs('admin.dashboard') && (View::hasSection('page_title') || View::hasSection('header_actions')))
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                    <div>
                        @hasSection('page_title')
                            <h1 class="h4 fw-bold text-dark mb-1">@yield('page_title')</h1>
                        @endif
                        @hasSection('page_subtitle')
                            <p class="text-muted small mb-0">@yield('page_subtitle')</p>
                        @endif
                    </div>
                    @hasSection('header_actions')
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @yield('header_actions')
                        </div>
                    @endif
                </div>
            @endif

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
        // Dark & Light Mode Theme Controller
        window.toggleAdminTheme = function() {
            var currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            try {
                localStorage.setItem('pc_admin_theme', newTheme);
            } catch (e) {
                console.warn('LocalStorage unavailable for theme storage:', e);
            }
            window.dispatchEvent(new CustomEvent('admin-theme-changed', {
                detail: { theme: newTheme }
            }));
        };

        // Global Image Preview Dispatcher
        window.previewImage = function(url, title) {
            if (!url) return;
            window.dispatchEvent(new CustomEvent('open-preview', {
                detail: { url: url, title: title || 'Image Preview' }
            }));
        };

        // Standalone Mobile Sidebar Toggle (Dispatches Alpine Event or Applies Direct Fallback)
        window.toggleMobileSidebar = function(forceState) {
            const hasAlpine = typeof Alpine !== 'undefined' && window.Alpine;
            if (hasAlpine) {
                if (forceState === true) {
                    window.dispatchEvent(new CustomEvent('open-mobile-sidebar'));
                } else if (forceState === false) {
                    window.dispatchEvent(new CustomEvent('close-mobile-sidebar'));
                } else {
                    window.dispatchEvent(new CustomEvent('toggle-mobile-sidebar'));
                }
                return;
            }

            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.querySelector('.sidebar-backdrop');
            if (!sidebar) return;
            const shouldOpen = forceState !== undefined ? forceState : !sidebar.classList.contains('show');
            sidebar.classList.toggle('show', shouldOpen);
            if (backdrop) backdrop.classList.toggle('show', shouldOpen);
            document.body.classList.toggle('overflow-hidden', shouldOpen);
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Wire fallback listeners only if Alpine isn't loaded after delay
            setTimeout(function() {
                if (typeof Alpine === 'undefined') {
                    document.querySelectorAll('[data-sidebar-toggle]').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            window.toggleMobileSidebar();
                        });
                    });
                    const backdrop = document.querySelector('.sidebar-backdrop');
                    if (backdrop) {
                        backdrop.addEventListener('click', function() {
                            window.toggleMobileSidebar(false);
                        });
                    }
                    document.querySelectorAll('#adminSidebar [aria-label="Close Sidebar"]').forEach(btn => {
                        btn.addEventListener('click', function() {
                            window.toggleMobileSidebar(false);
                        });
                    });
                }
            }, 300);
        });
    </script>

    @stack('scripts')
</body>
</html>
