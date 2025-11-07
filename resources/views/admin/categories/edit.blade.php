@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="page-header">
        <h1>Edit Kategori: {{ $category->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Method PUT untuk update --}}

            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $category->name) }}" {{-- Tampilkan data lama --}} placeholder="cth: Minuman Dingin">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon">Ikon (Emoji)</label>
                <input type="text" name="icon" id="icon" class="form-control"
                    value="{{ old('icon', $category->icon) }}" {{-- Tampilkan data lama --}} placeholder="cth: 🥤 (Opsional)">
                <small style="color: var(--text-muted); margin-top: 5px;">
                    Anda bisa copy-paste emoji dari keyboard atau web.
                </small>
                @error('icon')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Update Kategori</button>
            </div>

        </form>
    </div>
@endsection
