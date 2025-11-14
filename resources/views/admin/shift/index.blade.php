@extends('layouts.admin')

@section('title', 'Manajemen Shift Kasir')

{{-- =======================================
     == CSS KUSTOM UNTUK MODAL & DATATABLES ==
     ======================================= --}}
@push('styles')
    <style>
        /* CSS Modal Overlay dan Konten (Wajib di semua modal) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            /* Lebar kustom untuk modal status */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        /* CSS Status Modal Khusus */
        .status-modal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content.success .status-modal-icon-success {
            background-color: #eafbf0;
            color: #28a745;
            display: flex !important;
        }

        .modal-content.error .status-modal-icon-danger {
            background-color: #fdeeee;
            color: #dc3545;
            display: flex !important;
        }

        #status-modal-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            white-space: pre-wrap;
        }

        #status-modal-message {
            white-space: pre-wrap;
            text-align: left;
            margin: 0 auto;
            max-width: 90%;
            font-family: monospace;
            /* Menggunakan font monospace untuk rekonsiliasi yang rapi */
        }

        .modal-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: center;
        }
    </style>
    {{-- Tambahkan link CSS DataTables di sini jika diperlukan --}}
    {{-- <link rel="stylesheet" href="path/to/datatables.css"> --}}
@endpush

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Manajemen Shift Kasir</h2>

        <div class="row">
            {{-- Bagian Status Shift Aktif --}}
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Status Shift Saat Ini</h6>
                    </div>
                    <div class="card-body" id="current-shift-status">

                        @if ($activeShift)
                            {{-- TAMPILAN JIKA SHIFT AKTIF --}}
                            <div class="alert alert-success">
                                <h4 class="alert-heading">Shift Aktif!</h4>
                                <p class="mb-0">
                                    **Shift #{{ $activeShift->id }}** dibuka oleh
                                    **{{ $activeShift->user->name ?? 'Anda' }}**
                                    sejak **{{ $activeShift->start_time->format('d M Y H:i:s') }}**.
                                    <br>Kas Awal: **{{ number_format($activeShift->initial_cash, 0, ',', '.') }} IDR**
                                </p>
                            </div>

                            <hr>

                            <form id="close-shift-form" onsubmit="closeShift(event, {{ $activeShift->id }})">
                                @csrf
                                <div class="form-group">
                                    <label for="closing_cash">Kas Akhir (Uang Fisik di Laci) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="1000" id="closing_cash" name="closing_cash"
                                        class="form-control form-control-lg" placeholder="Masukkan total uang di laci"
                                        min="0" required>
                                    <small class="form-text text-muted">Total uang tunai yang ada di laci kasir saat
                                        ini.</small>
                                </div>
                                <div class="form-group">
                                    <label for="close_notes">Catatan Penutupan (Opsional)</label>
                                    <textarea id="close_notes" name="notes" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-3">Tutup Shift</button>
                            </form>
                        @else
                            {{-- TAMPILAN JIKA SHIFT TIDAK AKTIF --}}
                            <div class="alert alert-warning">
                                <h4 class="alert-heading">Shift Tidak Aktif.</h4>
                                <p class="mb-0">
                                    Harap buka shift untuk memulai transaksi di Point of Sale (POS).
                                </p>
                            </div>

                            <hr>

                            <form id="open-shift-form" onsubmit="openShift(event)">
                                @csrf
                                <div class="form-group">
                                    <label for="initial_cash">Kas Awal (Petty Cash) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="1000" id="initial_cash" name="initial_cash"
                                        class="form-control form-control-lg" value="0" min="0" required>
                                    <small class="form-text text-muted">Jumlah uang tunai modal awal yang dimasukkan ke laci
                                        kasir.</small>
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg mt-3">Buka Shift</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bagian Riwayat Shift (DataTable) --}}
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Shift (Detail Rekonsiliasi)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="shiftDataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kasir</th>
                                        <th>Mulai</th>
                                        <th>Modal Awal</th>
                                        <th>Penjualan Tunai</th>
                                        <th>Penjualan Non-Kas</th>
                                        <th>Kas Akhir Fisik</th>
                                        <th>Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data akan diisi oleh DataTables --}}
                                    @foreach ($history as $shift)
                                        <tr>
                                            <td>{{ $shift->id }}</td>
                                            <td>{{ $shift->user->name ?? 'N/A' }}</td>
                                            <td>{{ $shift->start_time->format('H:i') }} -
                                                {{ $shift->end_time->format('H:i') }}</td>
                                            <td>{{ number_format($shift->initial_cash, 0, ',', '.') }}</td>
                                            <td>{{ number_format($shift->system_cash_sales, 0, ',', '.') }}</td>
                                            <td>{{ number_format($shift->system_noncash_sales, 0, ',', '.') }}</td>
                                            <td>{{ number_format($shift->closing_cash, 0, ',', '.') }}</td>
                                            <td
                                                class="{{ $shift->cash_difference == 0 ? 'text-success font-weight-bold' : ($shift->cash_difference > 0 ? 'text-primary font-weight-bold' : 'text-danger font-weight-bold') }}">
                                                {{ number_format($shift->cash_difference, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================= --}}
    {{-- == HTML MODAL STATUS (Untuk Feedback Kustom) == --}}
    {{-- ======================================= --}}
    <div class="modal-overlay" id="status-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-body">
                <div id="status-modal-icon">
                    <div class="status-modal-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="status-modal-icon-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
                <h2 id="status-modal-title"></h2>
                <p id="status-modal-message"></p>
            </div>

            <div class="modal-footer" id="status-modal-footer">
                <button type="button" id="status-modal-print-btn" class="btn btn-secondary"
                    style="display: none;">Cetak
                    Struk</button>
                <button type="button" id="status-modal-ok-btn" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{-- Pastikan Anda memuat DataTables JS di sini atau di layouts.admin --}}
    {{-- <script src="path/to/jquery.dataTables.min.js"></script> --}}

    <script>
        // Variabel untuk melacak status transaksi shift
        let isLastShiftTransactionSuccess = false;

        // Fungsi untuk memformat angka menjadi Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        // ===============================================
        // == FUNGSI MODAL KUSTOM
        // ===============================================

        function showStatusModal(type, title, message) {
            const statusModal = document.getElementById('status-modal-overlay');
            const statusModalContent = statusModal.querySelector('.modal-content');
            const statusModalTitle = document.getElementById('status-modal-title');
            const statusModalMessage = document.getElementById('status-modal-message');
            const statusIconSuccess = statusModal.querySelector('.status-modal-icon-success');
            const statusIconDanger = statusModal.querySelector('.status-modal-icon-danger');

            // Atur tampilan ikon dan border
            if (type === 'success' || type === 'pending') {
                statusModalContent.classList.remove('error');
                statusModalContent.classList.add('success');
                statusIconSuccess.style.display = 'flex';
                statusIconDanger.style.display = 'none';
            } else {
                statusModalContent.classList.remove('success');
                statusModalContent.classList.add('error');
                statusIconSuccess.style.display = 'none';
                statusIconDanger.style.display = 'flex';
            }

            statusModalTitle.innerText = title;
            statusModalMessage.innerText = message;

            // Tombol print disembunyikan di halaman shift
            document.getElementById('status-modal-print-btn').style.display = 'none';

            statusModal.style.display = 'flex';
        }

        function closeStatusModal() {
            document.getElementById('status-modal-overlay').style.display = 'none';
            // PENTING: Jika transaksi shift sukses, reload halaman
            if (isLastShiftTransactionSuccess) {
                // Hapus flag success agar tidak terjadi loop reload
                isLastShiftTransactionSuccess = false;
                window.location.reload();
            }
        }

        document.getElementById('status-modal-ok-btn').addEventListener('click', closeStatusModal);


        // ===============================================
        // == LOGIKA BUKA SHIFT
        // ===============================================

        async function openShift(event) {
            event.preventDefault();
            const initialCash = document.getElementById('initial_cash').value;
            const csrfToken = document.querySelector('#open-shift-form input[name="_token"]').value;

            if (initialCash === null || isNaN(parseFloat(initialCash)) || parseFloat(initialCash) < 0) {
                showStatusModal('error', 'Input Tidak Valid', "Jumlah kas awal tidak valid.");
                return;
            }

            try {
                const response = await fetch("{{ route('admin.shift.open') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        initial_cash: parseFloat(initialCash)
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    isLastShiftTransactionSuccess = true;
                    showStatusModal('success', 'Shift Dibuka! 🟢',
                        `Kasir berhasil membuka shift dengan saldo awal ${formatRupiah(result.shift.initial_cash)}.`
                    );
                } else {
                    showStatusModal('error', 'Gagal Membuka Shift ❌', result.error || 'Gagal membuka shift.');
                }
            } catch (error) {
                console.error('Error opening shift:', error);
                showStatusModal('error', 'Error Server 🛑', 'Terjadi kesalahan saat berkomunikasi dengan server.');
            }
        }

        // ===============================================
        // == LOGIKA TUTUP SHIFT
        // ===============================================

        async function closeShift(event, shiftId) {
            event.preventDefault();

            if (!confirm("PERINGATAN: Menutup shift berarti mengakhiri sesi kasir Anda. Lanjutkan?")) return;

            const closingCash = document.getElementById('closing_cash').value;
            const notes = document.getElementById('close_notes').value;
            const csrfToken = document.querySelector('#close-shift-form input[name="_token"]').value;

            if (closingCash === null || isNaN(parseFloat(closingCash)) || parseFloat(closingCash) < 0) {
                showStatusModal('error', 'Input Tidak Valid', "Jumlah kas akhir tidak valid.");
                return;
            }

            try {
                const response = await fetch("{{ route('admin.shift.close') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        shift_id: shiftId,
                        closing_cash: parseFloat(closingCash),
                        notes: notes
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    isLastShiftTransactionSuccess = true;
                    const diff = result.report.cash_difference;
                    const systemNonCash = result.report.system_noncash_sales;

                    let title;
                    if (diff == 0) {
                        title = 'Shift Ditutup (Sempurna) 💰';
                    } else if (diff > 0) {
                        title = 'Shift Ditutup (Kas Berlebih) ⬆️';
                    } else {
                        title = 'Shift Ditutup (Kas Kurang) ⬇️';
                    }

                    // Format pesan rekonsiliasi agar lebih mudah dibaca
                    // Catatan: \n digunakan di JS string literal, tetapi di message HTML (di showStatusModal) 
                    // kita sudah menggunakan white-space: pre-wrap untuk memprosesnya.
                    let message = `
Rekonsiliasi Shift # ${shiftId}
-------------------------------------
Kas Awal:         ${formatRupiah(result.report.initial_cash)}
Penjualan Tunai:  ${formatRupiah(result.report.system_cash_sales)}
Penjualan Non-Kas: ${formatRupiah(systemNonCash)}
-------------------------------------
Total Kas Seharusnya: ${formatRupiah(result.report.initial_cash + result.report.system_cash_sales)}
Kas Fisik Dihitung:  ${formatRupiah(result.report.closing_cash)}
-------------------------------------
Selisih Kas:      ${formatRupiah(diff)}
`;

                    if (diff != 0) {
                        message += "\n\nHarap periksa selisih kas ini!";
                    }

                    const modalType = diff == 0 ? 'success' : 'error';

                    showStatusModal(modalType, title, message);

                } else {
                    showStatusModal('error', 'Gagal Menutup Shift ❌', result.error || 'Gagal menutup shift.');
                }
            } catch (error) {
                console.error('Error closing shift:', error);
                // Menangkap error 404/500/SQL dari server
                showStatusModal('error', 'Error Server 🛑', 'Terjadi kesalahan saat menutup shift. Cek Log Laravel.');
            }
        }

        window.onload = () => {
            // FIX: Inisialisasi DataTables saat dokumen siap
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
                $('#shiftDataTable').DataTable({
                    // Nonaktifkan ordering (pengurutan) untuk semua kolom agar sesuai tampilan.
                    "ordering": false,
                    // Nonaktifkan fitur pencarian, paging, dan info jika Anda hanya menampilkan 10 item.
                    "searching": true,
                    "paging": true,
                    "info": true,
                    // Default bahasa (optional)
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                    }
                });
            }

            // Pasangkan event listener untuk tombol OK
            document.getElementById('status-modal-ok-btn').addEventListener('click', closeStatusModal);
        }
    </script>
@endpush
