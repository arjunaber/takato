@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@push('styles')
    <style>
        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 5px;
        }

        .product-name {
            font-weight: 600;
        }

        .product-category {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* == CSS BARU UNTUK GAMBAR THUMBNAIL == */
        .product-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* == AKHIR CSS GAMBAR THUMBNAIL == */

        /* CSS untuk Form Filter */
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
        <h1>Manajemen Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            + Tambah Produk Baru
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

    {{-- Form Filter & Search --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.products.index') }}" method="GET" class="filter-form">

            {{-- Search by Nama Produk / Kategori --}}
            <div class="filter-group" style="flex-grow: 2;">
                <label for="search">Cari Produk (Nama / Kategori)</label>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="cth: Kopi Susu atau 'Minuman'" value="{{ $filters['search'] ?? '' }}">
            </div>

            {{-- Filter Kategori --}}
            <div class="filter-group">
                <label for="category_id">Filter Kategori</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Produk --}}
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th> {{-- <<< KOLOM BARU --}}
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Mulai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td> {{-- <<< GAMBAR THUMBNAIL --}}
                                @if ($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                        class="product-thumb">
                                @else
                                    <span style="color: var(--text-muted); font-size: 14px;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="product-name">
                                    {{ $product->name }}
                                    @if ($product->is_favorite)
                                        <span style="color: #ffc107; margin-left: 5px;" title="Produk Favorit">
                                            ★
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="product-category">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                {{-- Ambil harga terendah dari variant, sama seperti di POS --}}
                                @php
                                    $minPrice = $product->variants->min('price');
                                @endphp
                                Rp {{ number_format($minPrice ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-secondary action-btn">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger action-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Tidak ada data produk yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 20px;">
            {{ $products->appends($filters)->links() }}
        </div>
    </div>
@endsection
