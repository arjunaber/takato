@php
    use Carbon\Carbon;
@endphp
@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <style>
        /* ... (CSS KPI Card & Grid Anda yang lama) ... */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .kpi-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
        }

        .kpi-card h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0 0 10px 0;
        }

        .kpi-card .value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .kpi-card-pos {
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .kpi-card-pos:hover {
            background: #0069d9;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .kpi-card-pos h3 {
            color: white;
            margin: 0;
        }

        /* == CSS BARU UNTUK FILTER TANGGAL == */
        .dashboard-filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .filter-group .form-control {
            width: 100%;
            padding: 10px 14px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            padding-bottom: 10px;
            /* Agar sejajar dengan form-control */
        }

        .quick-links {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            flex-basis: 100%;
        }

        .quick-links a {
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
        }

        /* ... (CSS Grid & List Card Anda yang lama) ... */
        .dashboard-grid-large {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-top: 24px;
        }

        .list-card ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .list-card li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .list-card li:last-child {
            border-bottom: none;
        }

        .list-card .item-name {
            font-weight: 600;
        }

        .list-card .item-value {
            font-weight: 600;
            color: var(--text-color);
        }

        .list-card .item-unit {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-left: 5px;
        }

        .list-card .item-low-stock {
            color: var(--danger);
            font-weight: 700;
        }

        /* Responsif */
        @media (max-width: 1024px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-grid-large {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .filter-buttons {
                padding-bottom: 0;
            }
        }
    </style>
@endpush


@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
    </div>

    {{-- =================================== --}}
    {{-- =     BARU: FILTER TANGGAL        = --}}
    {{-- =================================== --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="dashboard-filter-form">

            {{-- Input Start Date --}}
            <div class="filter-group">
                <label for="start_date">Mulai Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>

            {{-- Input End Date --}}
            <div class="filter-group">
                <label for="end_date">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>

            {{-- Tombol Filter --}}
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>

            {{-- Tombol Cepat --}}
            <div class="quick-links">
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::today()->toDateString() }}&end_date={{ Carbon::today()->toDateString() }}">
                    Hari Ini
                </a>
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::yesterday()->toDateString() }}&end_date={{ Carbon::yesterday()->toDateString() }}">
                    Kemarin
                </a>
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::today()->subDays(6)->toDateString() }}&end_date={{ Carbon::today()->toDateString() }}">
                    7 Hari Terakhir
                </a>
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::today()->subDays(29)->toDateString() }}&end_date={{ Carbon::today()->toDateString() }}">
                    30 Hari Terakhir
                </a>
            </div>
        </form>
    </div>


    {{-- =================================== --}}
    {{-- =     BARIS 1: KARTU KPI          = --}}
    {{-- =================================== --}}
    <div class="kpi-grid">
        {{-- Ganti variabelnya agar dinamis --}}
        <div class="kpi-card">
            <h3>Omzet Penjualan</h3>
            <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="kpi-card">
            <h3>Total Transaksi</h3>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="kpi-card">
            <h3>Rata-rata / Transaksi</h3>
            <div class="value">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
        </div>
        <a href="{{ route('admin.pos.index') }}" class="kpi-card kpi-card-pos">
            <h3>BUKA HALAMAN KASIR &rarr;</h3>
        </a>
    </div>

    {{-- =================================== --}}
    {{-- =     BARIS 2: GRAFIK & LIST      = --}}
    {{-- =================================== --}}
    <div class="dashboard-grid-large">

        {{-- Kolom Kiri: Grafik --}}
        <div class="card">
            <h3>Grafik Penjualan</h3>
            <div style="height: 350px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Kolom Kanan: List --}}
        <div>
            {{-- Kartu Top Selling --}}
            <div class="card list-card" style="margin-bottom: 24px;">
                <h3>Produk Terlaris (Sesuai Filter)</h3>
                <ul>
                    @forelse($topProducts as $product)
                        <li>
                            <span class="item-name">{{ $product->item_name }}</span>
                            <span class="item-value">
                                {{ $product->total_sold }}
                                <span class="item-unit">terjual</span>
                            </span>
                        </li>
                    @empty
                        <li>
                            <span class="item-unit">Belum ada penjualan.</span>
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Kartu Stok Menipis (Tidak terpengaruh filter) --}}
            <div class="card list-card">
                <h3>Stok Akan Habis</h3>
                <ul>
                    @forelse($lowStockItems as $item)
                        <li>
                            <span class="item-name">{{ $item->name }}</span>
                            <span class="item-value item-low-stock">
                                {{ $item->stock }}
                                <span class="item-unit">{{ $item->unit }}</span>
                            </span>
                        </li>
                    @empty
                        <li>
                            <span class="item-unit">Semua stok aman.</span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Library Chart.js untuk membuat grafik --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data dari Controller yang di-passing ke Blade
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            const ctx = document.getElementById('salesChart').getContext('2d');

            var gradient = ctx.createLinearGradient(0, 0, 0, 350);
            gradient.addColorStop(0, 'rgba(0, 123, 255, 0.4)');
            gradient.addColorStop(1, 'rgba(0, 123, 255, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Omzet Penjualan',
                        data: chartData,
                        backgroundColor: gradient,
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
