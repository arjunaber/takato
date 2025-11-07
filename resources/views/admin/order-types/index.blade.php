@extends('layouts.admin')

@section('title', 'Manajemen Tipe Pesanan')

@push('styles')
    <style>
        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 5px;
        }

        /* (CSS untuk filter, sama seperti halaman lain) */
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
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
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Manajemen Tipe Pesanan</h1>
        <a href="{{ route('admin.order-types.create') }}" class="btn btn-primary">
            + Tambah Tipe Pesanan
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Search --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.order-types.index') }}" method="GET" class="filter-form">
            <div class="filter-group" style="flex-grow: 3;">
                <label for="search">Cari Tipe Pesanan</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="cth: Take Away"
                    value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.order-types.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Tipe Pesanan --}}
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Nama Tipe Pesanan</th>
                        <th>Biaya Tambahan (Markup)</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td><strong>{{ $type->name }}</strong></td>
                            <td>
                                @if ($type->type == 'percentage')
                                    {{ $type->value * 100 }}%
                                @else
                                    Rp {{ number_format($type->value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.order-types.edit', $type) }}"
                                    class="btn btn-secondary action-btn">
                                    Edit
                                </a>
                                {{-- Kita tidak bisa hapus ID 1 (Dine In) --}}
                                @if ($type->id != 1)
                                    <form action="{{ route('admin.order-types.destroy', $type) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus tipe ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger action-btn">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Belum ada data tipe pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 20px;">
            {{ $orderTypes->appends($filters)->links() }}
        </div>
    </div>
@endsection
