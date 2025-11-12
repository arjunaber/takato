@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth; // Tambahkan ini jika Anda menggunakan Auth::user()->role di view
@endphp

@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dashboard-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
            flex-grow: 1;
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
            flex-shrink: 0;
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

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            padding-bottom: 10px;
        }

        .action-buttons .btn {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-buttons .btn svg {
            width: 18px;
            height: 18px;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .kpi-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .kpi-icon {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .kpi-icon-sales {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .kpi-icon-orders {
            background-color: #eafbf0;
            color: #28a745;
        }

        .kpi-icon-avg {
            background-color: #fff8e6;
            color: #ffc107;
        }

        .kpi-icon-discount {
            background-color: #fdeeee;
            color: #dc3545;
        }

        .kpi-card-content h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0 0 5px 0;
        }

        .kpi-card-content .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .dashboard-main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-top: 24px;
        }

        .chart-container {
            height: 350px;
            position: relative;
        }

        .list-card ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .list-card li {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        #stock-request-form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            margin-bottom: 20px;
        }

        #stock-request-form-ingredient {
            flex-grow: 3;
        }

        #stock-request-form-amount {
            flex-grow: 1;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid var(--border-color);
            height: 44px;
            padding: 8px 10px;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }

        .stock-request-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .stock-request-table th,
        .stock-request-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .stock-request-table th {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .stock-request-table td.stock-info {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .stock-request-table .remove-item-btn {
            background: #dc3545;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            line-height: 1;
            font-weight: bold;
        }

        .stock-request-table .remove-item-btn:hover {
            background: #c82333;
        }

        .print-area {
            display: none;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-area {
                display: block !important;
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                margin: 0;
            }

            .print-area * {
                visibility: visible;
            }

            .print-area h1 {
                font-size: 18pt;
                margin-bottom: 10px;
            }

            .print-area h2 {
                font-size: 14pt;
                margin-bottom: 20px;
            }

            .print-area table {
                width: 100%;
                border-collapse: collapse;
            }

            .print-area th,
            .print-area td {
                font-size: 10pt;
                padding: 10px;
                border: 1px solid #ccc;
                text-align: left;
            }

            .print-area th {
                background-color: #f4f4f4;
            }

            .print-area .print-header {
                margin-bottom: 30px;
            }

            .print-area .print-header p {
                font-size: 10pt;
                margin: 5px 0;
            }
        }

        @media (max-width: 1200px) {
            .dashboard-main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .kpi-grid {
                grid-template-columns: 1fr 1fr;
            }

            .dashboard-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons {
                justify-content: flex-start;
                padding-bottom: 0;
            }
        }

        @media (max-width: 768px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
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

    {{-- KONTROL FILTER & BUTTONS (Dilihat oleh Owner dan Admin/Kasir) --}}
    <div class="dashboard-controls">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="start_date">Mulai Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="filter-group">
                <label for="end_date">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
            <div class="quick-links">
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::today()->toDateString() }}&end_date={{ Carbon::today()->toDateString() }}">Hari
                    Ini</a>
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::yesterday()->toDateString() }}&end_date={{ Carbon::yesterday()->toDateString() }}">Kemarin</a>
                <a
                    href="{{ route('admin.dashboard') }}?start_date={{ Carbon::today()->subDays(6)->toDateString() }}&end_date={{ Carbon::today()->toDateString() }}">7
                    Hari Terakhir</a>
            </div>
        </form>

        <div class="action-buttons">
            {{-- Tombol Permintaan Stok hanya untuk Admin/Owner (yang mengelola stok) --}}
            <button type="button" id="open-stock-request-btn" class="btn btn-secondary"
                style="background-color: var(--secondary-light); color: var(--text-color);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Buat Permintaan Stok
            </button>
            <a href="{{ route('admin.pos.index') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                </svg>
                Buka Kasir
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA DASHBOARD (Hanya untuk Owner) --}}
    @if ($isOwner)
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon-sales">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="kpi-card-content">
                    <h3>Omzet Penjualan</h3>
                    <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon-orders">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <div class="kpi-card-content">
                    <h3>Total Transaksi</h3>
                    <div class="value">{{ $totalOrders }}</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon-avg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="kpi-card-content">
                    <h3>Rata-rata/Transaksi</h3>
                    <div class="value">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon-discount">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <div class="kpi-card-content">
                    <h3>Total Diskon</h3>
                    <div class="value">Rp {{ number_format($totalDiscountsGiven, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="dashboard-main-grid">
            <div class="card">
                <h3>Grafik Penjualan</h3>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="dashboard-sidebar">
                <div class="card list-card">
                    <h3>Produk Terlaris</h3>
                    <ul>
                        @forelse($topProducts as $product)
                            <li>
                                <span class="item-name">{{ Str::limit($product->item_name, 25) }}</span>
                                <span class="item-value">{{ $product->total_sold }} <span
                                        class="item-unit">terjual</span></span>
                            </li>
                        @empty
                            <li><span class="item-unit">Belum ada penjualan.</span></li>
                        @endforelse
                    </ul>
                </div>

                <div class="card">
                    <h3>Penjualan per Kategori</h3>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Pesan yang muncul untuk Admin (role='admin') dan peran lain yang diizinkan masuk --}}
        <div class="alert alert-info p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="font-bold text-lg mb-2">Akses Terbatas</h4>
            <p>Anda login sebagai
                {{ Auth::user()->role === 'admin' ? 'Admin (Kasir)' : ucfirst(Auth::user()->role) }}. Tampilan
                data penjualan dan metrik sensitif dibatasi hanya untuk peran Owner.</p>
            <p class="mt-2 text-sm text-gray-600">Anda masih dapat menggunakan fitur  Buka Kasir
                dan Buat Permintaan Stok.</p>
        </div>
    @endif

    <div class="modal-overlay" id="stock-request-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Buat Permintaan Stok</h2>
            </div>
            <div class="modal-body">
                <div id="stock-request-form">
                    <div class="form-group" id="stock-request-form-ingredient">
                        <label>Pilih Bahan Baku</label>
                        <select id="ingredient-select" class="form-control" style="width: 100%;">
                            <option value="">Mencari...</option>
                        </select>
                    </div>
                    <div class="form-group" id="stock-request-form-amount">
                        <label>Jumlah</label>
                        <input type="number" id="stock-request-amount" class="form-control" placeholder="0"
                            step="0.01">
                    </div>
                    <div class="variant-action">
                        <button type="button" id="stock-request-add-btn" class="btn btn-primary">Add</button>
                    </div>
                </div>

                <table class="stock-request-table">
                    <thead>
                        <tr>
                            <th>Nama Bahan Baku</th>
                            <th style="width: 100px;">Stok Saat Ini</th>
                            <th style="width: 120px;">Permintaan</th>
                            <th style="width: 50px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="stock-request-tbody">
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada item
                                ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div id="print-info-footer" style="font-size: 0.9rem; color: var(--text-muted);">
                    Diajukan oleh: <strong>{{ auth()->user()->name }}</strong>
                </div>
                <div>
                    <button type="button" id="stock-request-close-btn" class="btn btn-secondary"
                        style="background-color: var(--secondary-light); color: var(--text-color);">Batal</button>
                    <button type="button" id="stock-request-print-btn" class="btn btn-primary">Cetak Surat
                        Jalan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="print-area" id="print-surat-jalan"></div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const ALL_INGREDIENTS = @json($allIngredients);
        let stockRequestItems = [];

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        $(document).ready(function() {
            console.log('Dashboard loaded, jQuery version:', $.fn.jquery);

            // Periksa apakah user adalah Owner sebelum menginisialisasi chart
            const isOwner = @json($isOwner);

            if (isOwner) {
                // GRAFIK LINE
                const salesCtx = document.getElementById('salesChart');
                if (salesCtx) {
                    const chartLabels = @json($chartLabels);
                    const chartData = @json($chartData);
                    const gradient = salesCtx.getContext('2d').createLinearGradient(0, 0, 0, 350);
                    gradient.addColorStop(0, 'rgba(0, 123, 255, 0.4)');
                    gradient.addColorStop(1, 'rgba(0, 123, 255, 0)');
                    new Chart(salesCtx, {
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
                                        callback: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(
                                            value)
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
                                        label: (context) => `Omzet: ${formatRupiah(context.parsed.y)}`
                                    }
                                }
                            }
                        }
                    });
                }

                // GRAFIK PIE
                const categoryCtx = document.getElementById('categoryChart');
                if (categoryCtx) {
                    const categoryLabels = @json($categoryChartLabels);
                    const categoryData = @json($categoryChartData);
                    new Chart(categoryCtx, {
                        type: 'doughnut',
                        data: {
                            labels: categoryLabels,
                            datasets: [{
                                label: 'Penjualan',
                                data: categoryData,
                                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545',
                                    '#6c757d'
                                ],
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        padding: 15
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (context) => `${context.label}: ${formatRupiah(context.raw)}`
                                    }
                                }
                            }
                        }
                    });
                }
            } // END if (isOwner)

            // MODAL STOCK LOGIC (DILIHAT OLEH SEMUA)
            const $modal = $('#stock-request-modal');
            const $tbody = $('#stock-request-tbody');
            const $amountInput = $('#stock-request-amount');
            const $ingredientSelect = $('#ingredient-select');

            // Init Select2
            $ingredientSelect.select2({
                placeholder: "Cari bahan baku...",
                dropdownParent: $('#stock-request-form-ingredient'),
                data: ALL_INGREDIENTS.map(item => ({
                    id: item.id,
                    text: `${item.name} (${item.unit})`,
                    stock: item.stock,
                    unit: item.unit,
                    name: item.name
                }))
            });
            $ingredientSelect.val(null).trigger('change');

            // Open Modal
            $('#open-stock-request-btn').on('click', function() {
                console.log('Opening modal...');
                $modal.css('display', 'flex');
            });

            // Close Modal
            $('#stock-request-close-btn').on('click', function() {
                console.log('Closing modal...');
                $modal.css('display', 'none');
            });

            $modal.on('click', function(e) {
                if (e.target === this) {
                    $(this).css('display', 'none');
                }
            });

            // Render Table Function
            function renderTable() {
                console.log('Rendering table, items:', stockRequestItems);
                $tbody.empty();

                if (stockRequestItems.length === 0) {
                    $tbody.html(
                        '<tr><td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada item ditambahkan.</td></tr>'
                    );
                    return;
                }

                stockRequestItems.forEach(function(item) {
                    const $row = $('<tr>').attr('data-id', item.id);
                    $row.append($('<td>').html('<strong>' + item.name + '</strong>'));
                    $row.append($('<td>').addClass('stock-info').text(item.stock + ' ' + item.unit));
                    $row.append($('<td>').text(item.amount + ' ' + item.unit));

                    const $removeBtn = $('<button>')
                        .attr('type', 'button')
                        .addClass('remove-item-btn')
                        .attr('data-item-id', item.id)
                        .text('×');

                    $row.append($('<td>').append($removeBtn));
                    $tbody.append($row);
                });

                console.log('Table rendered, rows:', $tbody.find('tr').length);
            }

            // Add Item
            $('#stock-request-add-btn').on('click', function() {
                console.log('Add button clicked');
                const selectedData = $ingredientSelect.select2('data')[0];
                const amount = parseFloat($amountInput.val()) || 0;

                console.log('Selected:', selectedData, 'Amount:', amount);

                if (!selectedData || !selectedData.id || amount <= 0) {
                    alert('Silakan pilih bahan baku dan isi jumlah permintaan.');
                    return;
                }

                if (stockRequestItems.some(item => item.id == selectedData.id)) {
                    alert('Bahan baku sudah ada di daftar.');
                    return;
                }

                stockRequestItems.push({
                    id: selectedData.id,
                    name: selectedData.name,
                    stock: selectedData.stock,
                    unit: selectedData.unit,
                    amount: amount
                });

                console.log('Item added, total items:', stockRequestItems.length);
                renderTable();

                $ingredientSelect.val(null).trigger('change');
                $amountInput.val('');
            });

            // Remove Item - Event Delegation
            $tbody.on('click', '.remove-item-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const itemId = $(this).attr('data-item-id');
                console.log('Remove clicked for ID:', itemId, 'type:', typeof itemId);

                // Convert both to string for comparison
                stockRequestItems = stockRequestItems.filter(item => String(item.id) !== String(itemId));

                console.log('After remove:', stockRequestItems);
                renderTable();
            });

            // Print
            $('#stock-request-print-btn').on('click', function() {
                console.log('Print clicked, items:', stockRequestItems);

                if (stockRequestItems.length === 0) {
                    alert('Daftar permintaan masih kosong.');
                    return;
                }

                // 1. Encode data array ke JSON, lalu ke Base64 (untuk transfer aman via URL)
                const encodedItems = btoa(JSON.stringify(stockRequestItems));

                // 2. Buat URL baru dan buka di tab baru
                const printUrl = '{{ route('admin.stock.request.print') }}?items=' + encodedItems;

                console.log('Navigating to print URL:', printUrl);
                window.open(printUrl, '_blank');
            });

        });
    </script>
@endpush
