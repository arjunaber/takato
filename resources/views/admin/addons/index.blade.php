@extends('layouts.admin')

@section('title', 'Manajemen Add-On')

@push('styles')
    <style>
        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 5px;
        }

        /* CSS untuk Form Filter/Search */
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

        /* == CSS BARU UNTUK PAGINATION BOOTSTRAP == */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: center;
            /* Opsional: Posisikan di tengah */
        }

        .page-item {
            margin: 0 2px;
        }

        .page-item.disabled .page-link {
            color: var(--text-muted);
            pointer-events: none;
            background-color: var(--secondary-light);
            border-color: var(--border-color);
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            line-height: 1.25;
            color: var(--primary);
            background-color: #fff;
            border: 1px solid var(--border-color);
            text-decoration: none;
            border-radius: 0.25rem;
        }

        .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Manajemen Add-On</h1>
        <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">
            + Tambah Add-On
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Search --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.addons.index') }}" method="GET" class="filter-form">
            <div class="filter-group" style="flex-grow: 3;">
                <label for="search">Cari Add-On</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="cth: Ekstra Keju"
                    value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Add-On --}}
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Nama Add-On</th>
                        <th>Harga</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($addons as $addon)
                        <tr>
                            <td>{{ $addon->id }}</td>
                            <td><strong>{{ $addon->name }}</strong></td>
                            <td>Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.addons.edit', $addon) }}" class="btn btn-secondary action-btn">
                                    Edit
                                </a>
                                <form action="{{ route('admin.addons.destroy', $addon) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus add-on ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger action-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Tidak ada data add-on.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 20px;">
            {{ $addons->appends($filters)->links() }}
        </div>
    </div>
@endsection
