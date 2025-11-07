@extends('layouts.admin')

@section('title', 'Edit Tipe Pesanan')

@section('content')
    <div class="page-header">
        <h1>Edit Tipe Pesanan: {{ $orderType->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.order-types.update', $orderType->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Tipe Pesanan</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $orderType->name) }}" placeholder="cth: Take Away">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Tipe Biaya Tambahan</label>
                <select name="type" id="type" class="form-control">
                    <option value="fixed" {{ old('type', $orderType->type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)
                    </option>
                    <option value="percentage" {{ old('type', $orderType->type) == 'percentage' ? 'selected' : '' }}>
                        Persentase (%)</option>
                </select>
                @error('type')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="value">Nilai Biaya Tambahan</label>
                {{-- Logika untuk menampilkan 0.1 sebagai 10 --}}
                <input type="number" name="value" id="value" class="form-control"
                    value="{{ old('value', $orderType->type == 'percentage' ? $orderType->value * 100 : $orderType->value) }}"
                    placeholder="" min="0" step="any">

                <small id="helper_percentage" style="color: var(--text-muted); margin-top: 5px; display: none;">
                    Isi <strong>10</strong> untuk biaya tambahan <strong>10%</strong>. (cth: untuk pajak PB1)
                </small>
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
                <button type="submit" class="btn btn-primary">Update Tipe Pesanan</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    {{-- JavaScript ini sama persis dengan di form Diskon/Create --}}
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
