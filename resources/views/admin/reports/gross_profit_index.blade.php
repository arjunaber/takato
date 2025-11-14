@extends('layouts.admin')

@section('title', 'Laporan Analisis Laba Kotor')

@push('styles')
    <style>
        /* Variabel yang mungkin tidak ada (untuk fallback) */
        :root {
            --card-bg: #fff;
            --border-color: #e0e0e0;
            --primary: #007bff;
            --primary-light: #e6f7ff;
            --secondary-light: #f8f9fa;
            --text-color: #333;
            --text-muted: #6c757d;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* --- STYLING FILTER/CONTROL BAR --- */
        .report-controls-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 14px;
            color: var(--text-color);
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            background-color: var(--card-bg);
            color: var(--text-color);
            appearance: none;
            /* Menghilangkan style default select */
        }

        /* Gaya Tombol */
        .btn {
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: 1px solid #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        /* --- STYLING TABLE --- */

        /* Gaya Umum */
        h1 {
            margin-bottom: 5px;
            font-size: 24px;
            color: var(--text-color);
        }

        .card-header small {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Gaya Tabel */
        .table-responsive table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .table-responsive th,
        .table-responsive td {
            padding: 12px 10px;
            border: 1px solid var(--border-color);
        }

        .table-responsive thead th {
            background-color: var(--secondary-light);
            font-weight: 600;
            color: var(--text-color);
        }

        /* Penyesuaian Lebar & Alignment Kolom */
        .table-responsive thead tr th:nth-child(1) {
            width: 8%;
        }

        /* Shift ID */
        .table-responsive thead tr th:nth-child(2) {
            width: auto;
        }

        /* Nama Produk */
        .table-responsive thead tr th:nth-child(3) {
            width: 12%;
        }

        /* Kuantitas */
        .table-responsive thead tr th:nth-child(4) {
            width: 15%;
        }

        /* Revenue */
        .table-responsive thead tr th:nth-child(5) {
            width: 15%;
        }

        /* COGS */
        .table-responsive thead tr th:nth-child(6) {
            width: 15%;
        }

        /* Laba Kotor */
        .table-responsive thead tr th:nth-child(7) {
            width: 10%;
        }

        /* Margin */

        .table-responsive .text-end {
            text-align: right !important;
            font-weight: 500;
        }

        .table-responsive .text-center {
            text-align: center !important;
        }

        .table-responsive .text-success {
            color: #28a745;
            /* Pastikan laba kotor berwarna hijau */
            font-weight: 600;
        }

        /* Gaya Footer (Total) */
        .table-responsive tfoot tr {
            font-size: 1rem;
            font-weight: 700;
        }

        .table-responsive tfoot .table-primary {
            background-color: var(--primary-light) !important;
            color: var(--primary);
            border-top: 2px solid var(--primary);
        }

        .table-responsive tfoot th {
            white-space: nowrap;
        }

        .table-responsive tfoot th:first-child {
            text-align: left !important;
            padding-left: 20px;
        }
    </style>
@endpush

@section('content')

    <h1>Laporan Analisis Laba Kotor</h1>

    {{-- 1. Formulir Filter --}}
    <div class="report-controls-card">
        <div class="card-header" style="border: none; padding: 0;">Filter Laporan</div>
        <div class="card-body" style="padding: 10px 0 0 0;">
            <form method="GET" action="{{ route('admin.reports.gross_profit.index') }}">
                <div class="filter-grid">
                    {{-- Filter Tanggal Mulai --}}
                    <div class="filter-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ $startDate->format('Y-m-d') }}" required>
                    </div>

                    {{-- Filter Tanggal Selesai --}}
                    <div class="filter-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ $endDate->format('Y-m-d') }}" required>
                    </div>

                    {{-- Filter Shift --}}
                    <div class="filter-group">
                        <label for="shift_id">Shift</label>
                        <select class="form-select" id="shift_id" name="shift_id">
                            <option value="">-- Semua Shift --</option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" {{ $shiftId == $shift->id ? 'selected' : '' }}>
                                    Shift ID: {{ $shift->id }} ({{ substr($shift->start_time, 0, 5) }} -
                                    {{ substr($shift->end_time, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Produk --}}
                    <div class="filter-group">
                        <label for="product_id">Produk</label>
                        <select class="form-select" id="product_id" name="product_id">
                            <option value="">-- Semua Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                    <a href="{{ route('admin.reports.gross_profit.export', ['type' => 'excel', 'start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d'), 'shift_id' => $shiftId, 'product_id' => $productId]) }}"
                        class="btn btn-success" target="_blank">Export Excel</a>
                    <a href="{{ route('admin.reports.gross_profit.export', ['type' => 'pdf', 'start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d'), 'shift_id' => $shiftId, 'product_id' => $productId]) }}"
                        class="btn btn-danger" target="_blank">Export PDF</a>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. Tabel Hasil Laporan --}}
    <div class="card">
        <div class="card-header">
            Detail Laba Kotor
            <small class="text-muted d-block">Periode: {{ $startDate->format('d M Y') }} s/d
                {{ $endDate->format('d M Y') }}</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Shift ID</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Kuantitas Terjual</th>
                            <th class="text-end">Total Revenue (Rp)</th>
                            <th class="text-end">Total COGS (Rp)</th>
                            <th class="text-end">Laba Kotor (Rp)</th>
                            <th class="text-center">Margin (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotalRevenue = 0;
                            $grandTotalCogs = 0;
                            $grandTotalProfit = 0;
                        @endphp
                        @forelse ($reportData as $item)
                            @php
                                $margin =
                                    $item->total_revenue > 0 ? ($item->gross_profit / $item->total_revenue) * 100 : 0;

                                $grandTotalRevenue += $item->total_revenue;
                                $grandTotalCogs += $item->total_cogs;
                                $grandTotalProfit += $item->gross_profit;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $item->shift_id ?? 'N/A' }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td class="text-center">{{ number_format($item->total_quantity, 0) }}</td>
                                <td class="text-end">{{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item->total_cogs, 0, ',', '.') }}</td>
                                <td class="text-end text-success">{{ number_format($item->gross_profit, 0, ',', '.') }}
                                </td>
                                <td class="text-center">{{ number_format($margin, 2) }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        @php
                            $grandMargin = $grandTotalRevenue > 0 ? ($grandTotalProfit / $grandTotalRevenue) * 100 : 0;
                        @endphp
                        <tr class="table-primary">
                            <th colspan="3" class="text-end" style="text-align: left !important;">TOTAL KESELURUHAN</th>
                            <th class="text-end">{{ number_format($grandTotalRevenue, 0, ',', '.') }}</th>
                            <th class="text-end">{{ number_format($grandTotalCogs, 0, ',', '.') }}</th>
                            <th class="text-end">{{ number_format($grandTotalProfit, 0, ',', '.') }}</th>
                            <th class="text-center">{{ number_format($grandMargin, 2) }}%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
