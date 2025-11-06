@extends('layouts.admin')

@section('title', 'Edit Diskon')

@section('content')
    <div class="page-header">
        <h1>Edit Diskon: {{ $discount->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Diskon</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $discount->name) }}" placeholder="cth: Diskon Karyawan">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Tipe Diskon</label>
                <select name="type" id="type" class="form-control">
                    <option value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'selected' : '' }}>
                        Persentase (%)</option>
                    <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)
                    </option>
                </select>
                @error('type')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- 
              INI BAGIAN YANG DIPERBAIKI 
              - Logika 'value' diubah untuk menampilkan 30, bukan 0.3
            --}}
            <div class="form-group">
                <label for="value">Nilai</label>
                <input type="number" name="value" id="value" class="form-control" {{-- 
                       Logika Kunci:
                       Ambil old('value') jika ada (saat validasi error).
                       Jika tidak ada, cek tipe diskon. 
                       Jika 'percentage', kalikan value DB dengan 100 (0.3 -> 30).
                       Jika 'fixed', tampilkan apa adanya.
                    --}}
                    value="{{ old('value', $discount->type == 'percentage' ? $discount->value * 100 : $discount->value) }}"
                    placeholder="" min="0" step="any"> {{-- Placeholder di-set oleh JS --}}

                {{-- Helper text untuk Persentase --}}
                <small id="helper_percentage" style="color: var(--text-muted); margin-top: 5px; display: none;">
                    Isi <strong>30</strong> untuk memberikan diskon <strong>30%</strong>.
                </small>

                {{-- Helper text untuk Nominal --}}
                <small id="helper_fixed" style="color: var(--text-muted); margin-top: 5px; display: none;">
                    Isi <strong>10000</strong> untuk memberikan diskon <strong>Rp 10.000</strong>.
                </small>

                @error('value')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Update Diskon</button>
            </div>

        </form>
    </div>
@endsection

{{-- 
  TAMBAHAN JAVASCRIPT
  (Ini sama persis dengan yang ada di halaman 'create')
  Kode ini akan mengubah placeholder & helper text secara dinamis.
--}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const typeSelect = document.getElementById('type');
            const valueInput = document.getElementById('value');
            const helperPercentage = document.getElementById('helper_percentage');
            const helperFixed = document.getElementById('helper_fixed');

            function updateValueField() {
                const selectedType = typeSelect.value;

                if (selectedType === 'percentage') {
                    valueInput.placeholder = 'cth: 30';
                    helperPercentage.style.display = 'block';
                    helperFixed.style.display = 'none';
                } else if (selectedType === 'fixed') {
                    valueInput.placeholder = 'cth: 10000';
                    helperPercentage.style.display = 'none';
                    helperFixed.style.display = 'block';
                }
            }

            // 1. Panggil fungsi saat halaman pertama kali dibuka
            //    (Ini akan membaca 'selected' dari <option> dan mengatur helper text yg benar)
            updateValueField();

            // 2. Panggil fungsi setiap kali dropdown 'type' berubah
            typeSelect.addEventListener('change', updateValueField);
        });
    </script>
@endpush
