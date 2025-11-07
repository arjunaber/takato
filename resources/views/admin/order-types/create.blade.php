@extends('layouts.admin')

@section('title', 'Tambah Tipe Pesanan Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Tipe Pesanan Baru</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.order-types.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Tipe Pesanan</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    placeholder="cth: Take Away">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Tipe Biaya Tambahan</label>
                <select name="type" id="type" class="form-control">
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                </select>
                @error('type')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="value">Nilai Biaya Tambahan</label>
                <input type="number" name="value" id="value" class="form-control" value="{{ old('value', 0) }}"
                    placeholder="" min="0" step="any">

                {{-- Helper text untuk Persentase --}}
                <small id="helper_percentage" style="color: var(--text-muted); margin-top: 5px; display: none;">
                    Isi <strong>10</strong> untuk biaya tambahan <strong>10%</strong>. (cth: untuk pajak PB1)
                </small>

                {{-- Helper text untuk Nominal --}}
                <small id="helper_fixed" style="color: var(--text-muted); margin-top: 5px; display: none;">
                    Isi <strong>2000</strong> untuk biaya tambahan <strong>Rp 2.000</strong>. (cth: untuk biaya bungkus)
                </small>

                @error('value')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>


            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.order-types.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Tipe Pesanan</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {{-- JavaScript ini sama persis dengan di form Diskon --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const valueInput = document.getElementById('value');
            const helperPercentage = document.getElementById('helper_percentage');
            const helperFixed = document.getElementById('helper_fixed');

            function updateValueField() {
                const selectedType = typeSelect.value;
                if (selectedType === 'percentage') {
                    valueInput.placeholder = 'cth: 10';
                    helperPercentage.style.display = 'block';
                    helperFixed.style.display = 'none';
                } else { // 'fixed'
                    valueInput.placeholder = 'cth: 2000';
                    helperPercentage.style.display = 'none';
                    helperFixed.style.display = 'block';
                }
            }
            updateValueField(); // Panggil saat load
            typeSelect.addEventListener('change', updateValueField); // Panggil saat ganti
        });
    </script>
@endpush
