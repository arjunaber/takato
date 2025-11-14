@extends('layouts.admin')

@section('title', 'Edit Bahan Baku')

@section('content')
    <div class="page-header">
        <h1>Edit Bahan Baku: {{ $ingredient->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Bahan Baku</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $ingredient->name) }}" placeholder="cth: Biji Kopi Arabika">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 15px;">
                {{-- KOREKSI: STOK DIBUAT FLEX: 1 --}}
                <div class="form-group" style="flex: 1;">
                    <label for="stock">Stok Saat Ini</label>
                    <input type="number" step="0.01" name="stock" id="stock" class="form-control"
                        value="{{ old('stock', $ingredient->stock) }}" placeholder="cth: 1000">
                    @error('stock')
                        <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BARU: INPUT HARGA SATUAN (HPP/Unit Price) --}}
                <div class="form-group" style="flex: 1;">
                    <label for="unit_price">Harga Satuan (HPP)</label>
                    <input type="number" step="1" name="unit_price" id="unit_price" class="form-control"
                        value="{{ old('unit_price', $ingredient->unit_price) }}" placeholder="cth: 5000">
                    @error('unit_price')
                        <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KOREKSI: SATUAN DIBUAT FLEX: 1 --}}
                <div class="form-group" style="flex: 1;">
                    <label for="unit">Satuan</label>
                    <select name="unit" id="unit" class="form-control">
                        <option value="g" {{ old('unit', $ingredient->unit) == 'g' ? 'selected' : '' }}>g (gram)
                        </option>
                        <option value="ml" {{ old('unit', $ingredient->unit) == 'ml' ? 'selected' : '' }}>ml (mililiter)
                        </option>
                        <option value="pcs" {{ old('unit', $ingredient->unit) == 'pcs' ? 'selected' : '' }}>pcs (satuan)
                        </option>
                        <option value="kg" {{ old('unit', $ingredient->unit) == 'kg' ? 'selected' : '' }}>kg (kilogram)
                        </option>
                        <option value="liter" {{ old('unit', $ingredient->unit) == 'liter' ? 'selected' : '' }}>liter
                        </option>
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
                <button type="submit" class="btn btn-primary">Update Bahan Baku</button>
            </div>

        </form>
    </div>
@endsection
