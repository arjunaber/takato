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
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #343a40;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #495057;
            --border-color: #dee2e6;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            /* Tambahan untuk sidebar */
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            /* Agar tidak 'penyet' saat di-hide */
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px;
            flex-shrink: 0;
            /* Tambahkan transisi */
            transition: margin-left 0.3s ease-in-out;
            z-index: 100;
        }

        /* === STATE SAAT SIDEBAR TERTUTUP === */
        body.sidebar-closed .sidebar {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            /* Hapus text-align, biarkan default */
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
            /* Jika menu banyak, bisa di-scroll */
        }

        .nav-link {
            display: block;
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            /* Agar teks tidak wrap saat sidebar mengecil */
        }

        .nav-link:hover {
            background-color: #f1f3f5;
            /* Warna hover lebih soft */
        }

        .nav-link.active {
            background-color: #e7f5ff;
            /* Primary light */
            color: var(--primary);
            font-weight: 600;
        }

        /* === Konten Utama (Navbar + Page) === */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            /* Tambahkan ini agar tidak 'loncat' saat sidebar hilang */
            min-width: 0;
        }

        /* === NAVBAR === */
        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            /* Ubah jadi space-between */
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        /* Wrapper untuk item navbar */
        .navbar-left,
        .navbar-right {
            display: flex;
            align-items: center;
        }

        /* Tombol Toggle Sidebar Baru */
        #sidebar-toggle {
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            color: var(--dark);
            cursor: pointer;
            margin-right: 16px;
            padding: 4px;
        }

        .navbar .username {
            font-weight: 600;
            margin-right: 16px;
        }

        .navbar .logout-btn {
            background: none;
            border: none;
            color: var(--danger);
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
        }

        /* === Konten Halaman === */
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 32px;
        }

        /* === Utility (Card, Button, Form, Table) === */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        th,
        td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        thead th {
            background-color: var(--light);
            font-weight: 600;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            Takato POS
        </div>
        <nav class="sidebar-nav">
            @auth
                {{-- 1. Dashboard (Hanya Owner yang bisa lihat) --}}
                @if (auth()->user()->role === 'owner')
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                @endif

                {{-- 2. Kasir (POS) (Owner & Admin bisa lihat) --}}
                @if (in_array(auth()->user()->role, ['owner', 'admin']))
                    <a href="{{ route('admin.pos.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pos.index') ? 'active' : '' }}">
                        Kasir (POS)
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        Histori Pesanan
                    </a>
                    <a href="{{ route('admin.shift.index') }}"
                        class="nav-link {{ request()->routeIs('admin.shift.index') ? 'active' : '' }}">
                        Kelola Shift
                    </a>
                @endif

                {{-- 3. Histori Pesanan (Hanya Owner yang bisa lihat) --}}
                @if (auth()->user()->role === 'owner')
                    {{-- 4. Produk (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        Produk
                    </a>

                    {{-- 5. Kategori (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        Kategori
                    </a>

                    {{-- 6. Add-Ons (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.addons.index') }}"
                        class="nav-link {{ request()->routeIs('admin.addons.*') ? 'active' : '' }}">
                        Add-Ons
                    </a>

                    {{-- 7. Bahan Baku (Stok) (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.ingredients.index') }}"
                        class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}">
                        Bahan Baku (Stok)
                    </a>

                    {{-- 8. Diskon (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.discounts.index') }}"
                        class="nav-link {{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                        Diskon
                    </a>

                    {{-- 9. Tipe Pesanan (Hanya Owner yang bisa lihat) --}}
                    <a href="{{ route('admin.order-types.index') }}"
                        class="nav-link {{ request()->routeIs('admin.order-types.*') ? 'active' : '' }}">
                        Tipe Pesanan
                    </a>

                    <a href="{{ route('admin.config.struk.edit') }}"
                        class="nav-link {{ request()->routeIs('admin.order-types.*') ? 'active' : '' }}">
                        Config Struk
                    </a>
                @endif
            @endauth
        </nav>
    </aside>

    <div class="main-wrapper">
        <nav class="navbar">
            {{-- TOMBOL TOGGLE BARU --}}
            <div class="navbar-left">
                <button id="sidebar-toggle" title="Toggle Sidebar">&#9776;</button>
            </div>

            {{-- ITEM NAVBAR SEBELAH KANAN --}}
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

    {{-- SCRIPT BARU UNTUK TOGGLE SIDEBAR --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('sidebar-toggle');
            const body = document.body;
            const storageKey = 'sidebarState';

            // 1. Cek status tersimpan di localStorage saat halaman dimuat
            const currentState = localStorage.getItem(storageKey);
            if (currentState === 'closed') {
                body.classList.add('sidebar-closed');
            }

            // 2. Tambahkan event listener ke tombol
            toggleButton.addEventListener('click', function() {
                body.classList.toggle('sidebar-closed');

                // 3. Simpan state baru ke localStorage
                if (body.classList.contains('sidebar-closed')) {
                    localStorage.setItem(storageKey, 'closed');
                } else {
                    localStorage.setItem(storageKey, 'open');
                }
            });
        });
    </script>

    {{-- Stack untuk JS tambahan per halaman (contoh: script dinamis form diskon) --}}
    @stack('scripts')
</body>

</html>
