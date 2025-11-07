@extends('layouts.admin')

@section('title', 'Edit Add-On')

@section('content')
    <div class="page-header">
        <h1>Edit Add-On: {{ $addon->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.addons.update', $addon->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Method PUT untuk update --}}

            <div class="form-group">
                <label for="name">Nama Add-On</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $addon->name) }}"
                    {{-- Tampilkan data lama --}} placeholder="cth: Ekstra Keju">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" name="price" id="price" class="form-control"
                    value="{{ old('price', $addon->price) }}" {{-- Tampilkan data lama --}} placeholder="cth: 3000">
                @error('price')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Update Add-On</button>
            </div>

        </form>
    </div>
@endsection
