@extends('layouts.admin')

@section('title', 'Tambah Add-On Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Add-On Baru</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.addons.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Add-On</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    placeholder="cth: Ekstra Keju">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                    placeholder="cth: 3000">
                @error('price')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Add-On</button>
            </div>

        </form>
    </div>
@endsection
