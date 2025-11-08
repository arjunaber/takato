@extends('layouts.admin')

@section('title', 'Manajemen Stok Bahan Baku')

@push('styles')
    {{-- CSS untuk Select2 (Dropdown yang bisa dicari) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
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
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            padding-bottom: 10px;
        }

        /* CSS Pagination Bootstrap */
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

        /* == CSS BARU: MODAL PENYESUAIAN STOK == */
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
            max-width: 600px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-md);
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
            justify-content: flex-end;
            gap: 10px;
        }

        /* Style agar Select2 di modal berfungsi */
        .select2-container--default .select2-selection--single {
            border: 1px solid var(--border-color);
            height: 44px;
            padding: 8px 10px;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }

        .select2-dropdown {
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Manajemen Stok Bahan Baku</h1>
        {{-- Tombol Aksi Baru --}}
        <div class="d-flex gap-2">
            <button type="button" id="open-stock-modal-btn" class="btn btn-secondary"
                style="background-color: var(--secondary-light); color: var(--text-color);">
                + Sesuaikan Stok
            </button>
            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-primary">
                + Tambah Bahan Baku
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    {{-- Tampilkan error validasi dari modal --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Search --}}
    <div class="card" style="margin-bottom: 24px;">
        <form action="{{ route('admin.ingredients.index') }}" method="GET" class="filter-form">
            {{-- ... (Form filter Anda) ... --}}
            <div class="filter-group" style="flex-grow: 3;">
                <label for="search">Cari Bahan Baku</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="cth: Biji Kopi"
                    value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.ingredients.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Bahan Baku --}}
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Nama Bahan Baku</th>
                        <th>Stok Saat Ini</th>
                        <th>Satuan</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->id }}</td>
                            <td><strong>{{ $ingredient->name }}</strong></td>
                            <td>{{ $ingredient->stock }}</td>
                            <td>{{ $ingredient->unit }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.ingredients.edit', $ingredient) }}"
                                    class="btn btn-secondary action-btn">
                                    Edit
                                </a>
                                <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus bahan baku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger action-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Belum ada data bahan baku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 20px;">
            {{ $ingredients->appends($filters)->links() }}
        </div>
    </div>


    {{-- =================================== --}}
    {{-- =  MODAL PENYESUAIAN STOK (BARU)  = --}}
    {{-- =================================== --}}
    <div class="modal-overlay" id="stock-adjust-modal">
        <div class="modal-content">
            <form id="stock-adjust-form" action="{{ route('admin.ingredients.adjust-stock') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2>Penyesuaian Stok</h2>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="ingredient-select">Bahan Baku</label>
                        {{-- Select2 akan ditargetkan ke ID ini --}}
                        <select id="ingredient-select" name="ingredient_id" class="form-control" style="width: 100%;">
                            <option value="">Pilih bahan baku...</option>
                            @foreach ($allIngredients as $item)
                                <option value="{{ $item->id }}" data-unit="{{ $item->unit }}"
                                    data-stock="{{ $item->stock }}">
                                    {{ $item->name }} (Sisa: {{ $item->stock }} {{ $item->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex" style="gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="action">Aksi</label>
                            <select name="action" id="action" class="form-control">
                                <option value="add">Tambah Stok (Stok Masuk)</option>
                                <option value="subtract">Kurangi Stok (Rusak/Opname)</option>
                            </select>
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label for="quantity">Jumlah</label>
                            <input type="number" step="0.01" name="quantity" id="quantity" class="form-control"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan (Opsional)</label>
                        <input type="text" name="notes" id="notes" class="form-control"
                            placeholder="cth: Stok masuk dari Supplier A">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="stock-adjust-close-btn" class="btn btn-secondary"
                        style="background-color: var(--secondary-light); color: var(--text-color);">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Penyesuaian</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Library JQuery & Select2 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#ingredient-select').select2({
                placeholder: "Cari bahan baku...",
                dropdownParent: $('#stock-adjust-modal') // Penting agar searchbox di modal berfungsi
            });

            // Ambil elemen modal
            const stockModal = document.getElementById('stock-adjust-modal');

            // Buka Modal
            $('#open-stock-modal-btn').on('click', () => {
                stockModal.style.display = 'flex';
            });

            // Tutup Modal
            $('#stock-adjust-close-btn').on('click', () => {
                stockModal.style.display = 'none';
            });

            // Tutup jika klik di luar
            $(stockModal).on('click', (e) => {
                if (e.target === stockModal) {
                    stockModal.style.display = 'none';
                }
            });

            // Jika ada error validasi dari server, buka modalnya lagi
            @if ($errors->any())
                stockModal.style.display = 'flex';
            @endif
        });
    </script>
@endpush
