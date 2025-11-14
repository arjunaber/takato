@extends('layouts.admin')

@section('title', 'Edit Konfigurasi Struk')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Pengaturan Struk Penjualan</h2>
        <p>Halaman ini memungkinkan Anda menyesuaikan informasi yang muncul di bagian bawah struk (seperti Wi-Fi, pesan
            terima kasih, dll.).</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Kustom Struk</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.config.struk.update') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="wifi_ssid">Nama Jaringan Wi-Fi (SSID)</label>
                        <input type="text" name="wifi_ssid" id="wifi_ssid" class="form-control"
                            value="{{ $configs['wifi_ssid'] }}" required>
                        @error('wifi_ssid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="wifi_password">Password Wi-Fi</label>
                        <input type="text" name="wifi_password" id="wifi_password" class="form-control"
                            value="{{ $configs['wifi_password'] }}" required>
                        @error('wifi_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="footer_message">Pesan Terima Kasih (Footer Struk)</label>
                        <textarea name="footer_message" id="footer_message" class="form-control" rows="3">{{ $configs['footer_message'] }}</textarea>
                        @error('footer_message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Konfigurasi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
