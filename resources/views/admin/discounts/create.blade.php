@extends('layouts.admin')

@section('title', 'Tambah Diskon')

@section('content')
    <div class="page-header">
        <h1>Tambah Diskon Baru</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.discounts.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Diskon</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    placeholder="cth: Diskon Karyawan">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Tipe Diskon</label>
                <select name="type" id="type" class="form-control">
                    {{-- Urutan 'percentage' di atas agar jadi default --}}
                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                </select>
                @error('type')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- 
              INI BAGIAN YANG DIPERBAIKI 
              - Placeholder akan di-set oleh JavaScript
              - Helper text (<small>) ada 2, dan akan tampil/sembunyi
              - step="any" agar bisa desimal (jika perlu), min="0" agar tidak negatif
            --}}
            <div class="form-group">
                <label for="value">Nilai</label>
                <input type="number" name="value" id="value" class="form-control" value="{{ old('value') }}"
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
                <button type="submit" class="btn btn-primary">Simpan Diskon</button>
            </div>

        </form>
    </div>
@endsection

{{-- 
  TAMBAHAN JAVASCRIPT
  Letakkan ini di bawah. Kode ini akan mengubah placeholder & helper text
  secara dinamis saat Tipe Diskon diubah.
--}}
@push('scripts')
    <script>
        // Pastikan DOM sudah ter-load
        document.addEventListener('DOMContentLoaded', function() {

            // Ambil elemen-elemen yang kita butuhkan
            const typeSelect = document.getElementById('type');
            const valueInput = document.getElementById('value');
            const helperPercentage = document.getElementById('helper_percentage');
            const helperFixed = document.getElementById('helper_fixed');

            // Buat fungsi untuk update tampilan
            function updateValueField() {
                const selectedType = typeSelect.value;

                if (selectedType === 'percentage') {
                    valueInput.placeholder = 'cth: 30'; // Placeholder untuk %
                    helperPercentage.style.display = 'block'; // Tampilkan helper %
                    helperFixed.style.display = 'none'; // Sembunyikan helper Rp
                } else if (selectedType === 'fixed') {
                    valueInput.placeholder = 'cth: 10000'; // Placeholder untuk Rp
                    helperPercentage.style.display = 'none'; // Sembunyikan helper %
                    helperFixed.style.display = 'block'; // Tampilkan helper Rp
                }
            }

            // 1. Panggil fungsi ini saat halaman pertama kali dibuka
            //    (Ini penting untuk menangani `old('type')` saat validasi error)
            updateValueField();

            // 2. Panggil fungsi ini setiap kali nilai dropdown 'type' berubah
            typeSelect.addEventListener('change', updateValueField);
        });
    </script>
@endpush
