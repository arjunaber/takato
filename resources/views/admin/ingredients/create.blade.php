@extends('layouts.admin')

@section('title', 'Tambah Bahan Baku Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Bahan Baku Baru</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.ingredients.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Bahan Baku</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    placeholder="cth: Biji Kopi Arabika">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 15px;">
                {{-- KOREKSI: Stok Awal (Sekarang flex: 1) --}}
                <div class="form-group" style="flex: 1;">
                    <label for="stock">Stok Awal</label>
                    <input type="number" step="0.01" name="stock" id="stock" class="form-control"
                        value="{{ old('stock', 0) }}" placeholder="cth: 1000">
                    @error('stock')
                        <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BARU: Harga Satuan (HPP) (flex: 1) --}}
                <div class="form-group" style="flex: 1;">
                    <label for="unit_price">Harga Satuan (HPP)</label>
                    <input type="number" step="1" name="unit_price" id="unit_price" class="form-control"
                        value="{{ old('unit_price', 0) }}" placeholder="cth: 5000">
                    @error('unit_price')
                        <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KOREKSI: Satuan (Sekarang flex: 1) --}}
                <div class="form-group" style="flex: 1;">
                    <label for="unit">Satuan</label>
                    <select name="unit" id="unit" class="form-control">
                        <option value="g" {{ old('unit') == 'g' ? 'selected' : '' }}>g (gram)</option>
                        <option value="ml" {{ old('unit') == 'ml' ? 'selected' : '' }}>ml (mililiter)</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs (satuan)</option>
                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg (kilogram)</option>
                        <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>liter</option>
                    </select>
                    @error('unit')
                        <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Form "Ambang Stok Rendah" dihapus --}}

            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.ingredients.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Bahan Baku</button>
            </div>

        </form>
    </div>
@endsection
