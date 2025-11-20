<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Takato POS</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* === PALET WARNA EARTH TONE (Sesuai Gambar) === */
            --primary: #A05C35;
            /* Rust/Tembaga */
            --primary-dark: #824828;
            /* Hover Tembaga */
            --primary-light: #FDF3EE;
            /* Tint Sangat Muda (untuk background aktif) */

            --secondary: #946E67;
            /* Mauve/Coklat Pudar */

            --warning: #C39653;
            /* Gold/Emas */

            /* Functional Colors */
            --success: #556B2F;
            /* Dark Olive Green */
            --danger: #A52A2A;
            /* Brown/Red */

            --light: #f8f9fa;
            --dark: #646C66;
            /* Slate/Abu Gelap */

            --body-bg: #DADDD8;
            /* Mist/Abu Terang (Background Utama) */
            --card-bg: #ffffff;

            --text-color: #2C3330;
            /* Hampir Hitam (untuk teks utama) */
            --text-muted: #646C66;

            --border-color: #c1c4c0;
            --shadow-sm: 0 2px 4px rgba(60, 60, 60, 0.08);

            --sidebar-width: 260px;
        }

        /* === RESET & GLOBAL STYLES === */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }

        a:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px;
            flex-shrink: 0;
            transition: margin-left 0.3s ease-in-out;
            z-index: 100;
        }

        body.sidebar-closed .sidebar {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
        }

        .nav-link {
            display: block;
            padding: 12px 16px;
            border-radius: 8px;
            color: var(--text-color);
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            background-color: #F0F2F1;
            color: var(--primary);
        }

        .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
            border-left: 4px solid var(--primary);
        }

        /* === LAYOUT UTAMA === */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            min-width: 0;
        }

        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .navbar-left,
        .navbar-right {
            display: flex;
            align-items: center;
        }

        #sidebar-toggle {
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            color: var(--primary);
            cursor: pointer;
            margin-right: 16px;
            padding: 4px;
            transition: color 0.2s;
        }

        #sidebar-toggle:hover {
            color: var(--primary-dark);
        }

        .navbar .username {
            font-weight: 600;
            margin-right: 16px;
            color: var(--text-color);
        }

        .navbar .logout-btn {
            background: none;
            border: none;
            color: var(--danger);
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .navbar .logout-btn:hover {
            background-color: #fff5f5;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 32px;
        }

        /* === KOMPONEN UI SERAGAM (POS & HISTORY) === */

        /* 1. Buttons */
        .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid transparent;
            /* Ensure border exists for outlines */
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Override Bootstrap Btn Primary */
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: white !important;
        }

        .btn-success {
            background-color: var(--success) !important;
            border-color: var(--success) !important;
            color: white !important;
        }

        .btn-danger {
            background-color: var(--danger) !important;
            border-color: var(--danger) !important;
            color: white !important;
        }

        .btn-secondary {
            background-color: var(--secondary) !important;
            border-color: var(--secondary) !important;
            color: white !important;
        }

        /* 2. Cards */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        /* 3. Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 0;
            /* Reset margin jika di dalam card */
        }

        th,
        td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        thead th {
            background-color: #F0F2F1;
            font-weight: 600;
            color: var(--dark);
        }

        tbody tr:hover {
            background-color: #fafbfc;
        }

        /* 4. Forms & Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        /* Hapus biru pada fokus input */
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(160, 92, 53, 0.15);
            /* Glow Rust */
        }

        /* 5. Override Bootstrap Utilities (Hapus Biru) */
        .bg-primary {
            background-color: var(--primary) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .border-primary {
            border-color: var(--primary) !important;
        }

        .bg-info {
            background-color: var(--secondary) !important;
        }

        /* Ganti cyan info jadi secondary */
        .text-info {
            color: var(--secondary) !important;
        }

        /* 6. Override Select2 (Sering jadi sumber warna biru) */
        .select2-container--default .select2-selection--single {
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            height: 45px !important;
            /* Samakan dengan form-control */
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
        }

        /* Warna sorotan saat dropdown dipilih */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary) !important;
            color: white !important;
        }

        /* Fokus Select2 */
        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(160, 92, 53, 0.15);
        }

        /* 7. Pagination (Jika ada) */
        .page-item.active .page-link {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }

        .page-link {
            color: var(--primary) !important;
        }

        /* Utility Classes */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            color: var(--dark);
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #eef5e9;
            color: #3d4d21;
            border: 1px solid #dce8d3;
        }

        .alert-danger {
            background-color: #faeaea;
            color: #7a1f1f;
            border: 1px solid #f0d5d5;
        }

        .text-right {
            text-align: right;
        }

        .d-flex {
            display: flex;
        }

        .gap-2 {
            gap: 8px;
        }
    </style>

    @stack('styles')
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            Takato POS
        </div>
        <nav class="sidebar-nav">
            @auth
                @if (auth()->user()->role === 'owner')
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                @endif

                @if (in_array(auth()->user()->role, ['owner', 'admin']))
                    <a href="{{ route('admin.pos.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pos.index') ? 'active' : '' }}">
                        Kasir (POS)
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.orders.online') ? 'active' : '' }}">
                        Histori Pesanan
                    </a>
                    <a href="{{ route('admin.orders.online') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.online') ? 'active' : '' }}">
                        Pesanan Online
                    </a>
                    <a href="{{ route('admin.tables.index') }}"
                        class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                        Monitoring Meja
                    </a>
                    <a href="{{ route('admin.shift.index') }}"
                        class="nav-link {{ request()->routeIs('admin.shift.index') ? 'active' : '' }}">
                        Kelola Shift
                    </a>
                @endif

                @if (auth()->user()->role === 'owner')
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        Kategori
                    </a>
                    <a href="{{ route('admin.addons.index') }}"
                        class="nav-link {{ request()->routeIs('admin.addons.*') ? 'active' : '' }}">
                        Add-Ons
                    </a>
                    <a href="{{ route('admin.ingredients.index') }}"
                        class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}">
                        Bahan Baku (Stok)
                    </a>
                    <a href="{{ route('admin.discounts.index') }}"
                        class="nav-link {{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                        Diskon
                    </a>
                    <a href="{{ route('admin.order-types.index') }}"
                        class="nav-link {{ request()->routeIs('admin.order-types.*') ? 'active' : '' }}">
                        Tipe Pesanan
                    </a>
                    <a href="{{ route('admin.config.struk.edit') }}"
                        class="nav-link {{ request()->routeIs('admin.config.*') ? 'active' : '' }}">
                        Config Struk
                    </a>
                    <a href="{{ route('admin.reports.gross_profit.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        Report
                    </a>
                @endif
            @endauth
        </nav>
    </aside>

    <div class="main-wrapper">
        <nav class="navbar">
            <div class="navbar-left">
                <button id="sidebar-toggle" title="Toggle Sidebar">&#9776;</button>
            </div>
            <div class="navbar-right">
                @auth
                    <span class="username">Halo, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @endauth
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('sidebar-toggle');
            const body = document.body;
            const storageKey = 'sidebarState';

            const currentState = localStorage.getItem(storageKey);
            if (currentState === 'closed') {
                body.classList.add('sidebar-closed');
            }

            toggleButton.addEventListener('click', function() {
                body.classList.toggle('sidebar-closed');
                if (body.classList.contains('sidebar-closed')) {
                    localStorage.setItem(storageKey, 'closed');
                } else {
                    localStorage.setItem(storageKey, 'open');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
