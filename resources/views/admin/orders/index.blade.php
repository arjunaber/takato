@extends('layouts.admin')

@section('title', 'Histori Pesanan')

@push('styles')
    <style>
        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            line-height: 1;
            color: #fff;
        }

        .badge-success {
            background-color: var(--success);
        }

        .badge-warning {
            background-color: var(--warning);
            color: #333;
        }

        .badge-danger {
            background-color: var(--danger);
        }

        .badge-secondary {
            background-color: var(--secondary);
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 5px;
        }

        /* CSS untuk Form Filter */
        .filter-form {
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
            /* Sesuaikan padding dengan form-control Anda */
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            padding-bottom: 10px;
            /* Agar sejajar dengan form-control */
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Histori Pesanan</h1>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ====================================================== --}}
    {{-- ==   TAMBAHAN: FORM FILTER & SEARCH                 == --}}
    {{-- ====================================================== --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="filter-form">

            {{-- Search by ID / Nama Kasir --}}
            <div class="filter-group" style="flex-grow: 2;">
                <label for="search">Cari (ID Pesanan / Nama Kasir)</label>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="Contoh: 123 atau 'Admin'" value="{{ $filters['search'] ?? '' }}">
            </div>

            {{-- Filter Tanggal --}}
            <div class="filter-group">
                <label for="date">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control"
                    value="{{ $filters['date'] ?? '' }}">
            </div>

            {{-- Filter Status --}}
            <div class="filter-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                    <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled
                    </option>
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    {{-- ====================================================== --}}
    {{-- ==   TABEL HISTORI PESANAN                         == --}}
    {{-- ====================================================== --}}
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total Harga</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td> {{-- Menampilkan nama kasir --}}
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                            <td>
                                @if ($order->status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary action-btn">
                                    Detail
                                </a>
                                {{-- Form untuk "Cancel Order" --}}
                                @if ($order->status != 'cancelled')
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger action-btn">Batal</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Tidak ada data pesanan yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        <div style="padding: 20px;">
            {{-- .appends($filters) akan membuat pagination tetap mengingat filter/search Anda --}}
            {{ $orders->appends($filters)->links() }}
        </div>
    </div>
@endsection
