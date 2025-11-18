@extends('layouts.admin')

{{-- Judul Halaman --}}
@section('title', 'Pesanan Online')

@push('styles')
    <style>
        /* [Style CSS Anda tetap di sini] */
        :root {
            /* Contoh variabel warna */
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --secondary: #6c757d;
            --primary: #007bff;
            --secondary-light: #e9ecef;
            --text-muted: #6c757d;
            --text-color: #333;
            --border-color: #dee2e6;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            line-height: 1;
            color: #fff;
        }

        .badge-success {
            background-color: var(--success);
        }

        .badge-warning {
            background-color: var(--warning);
            color: #333;
        }

        .badge-danger {
            background-color: var(--danger);
        }

        .badge-secondary {
            background-color: var(--secondary);
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
        }

        /* CSS untuk Form Filter */
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .filter-group .form-control {
            width: 100%;
            padding: 10px 14px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            padding-bottom: 10px;
        }

        /* == CSS BARU UNTUK PAGINATION BOOTSTRAP == */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: center;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-item.disabled .page-link {
            color: var(--text-muted);
            pointer-events: none;
            background-color: var(--secondary-light);
            border-color: var(--border-color);
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            line-height: 1.25;
            color: var(--primary);
            background-color: #fff;
            border: 1px solid var(--border-color);
            text-decoration: none;
            border-radius: 0.25rem;
        }

        .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* CSS untuk Action Buttons yang tidak rusak layout */
        .action-cell {
            white-space: nowrap;
            position: relative;
        }

        /* Dropdown Custom Styling (Hanya untuk modal flow) */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            z-index: 1000;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            border: 1px solid #dee2e6;
            padding: 8px 0;
            margin-top: 4px;
            right: 0;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            color: #333;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-success {
            color: #28a745 !important;
        }

        .dropdown-item.text-danger {
            color: #dc3545 !important;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            /* Z-Index lebih tinggi agar di atas elemen lain */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-dialog {
            position: relative;
            margin: 10% auto;
            max-width: 500px;
            animation: slideDown 0.3s;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            padding: 20px 24px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            line-height: 1;
        }

        .modal-close:hover {
            color: #000;
        }

        .modal-body {
            padding: 24px;
            color: #555;
            line-height: 1.6;
        }

        .modal-footer {
            padding: 16px 24px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-btn-cancel {
            background-color: #6c757d;
            color: #fff;
        }

        .modal-btn-cancel:hover {
            background-color: #5a6268;
        }

        .modal-btn-confirm-cancel {
            background-color: var(--danger);
            color: #fff;
        }

        .modal-btn-confirm-cancel:hover {
            background-color: #c82333;
        }

        .modal-btn-confirm {
            background-color: #28a745;
            color: #fff;
        }

        .modal-btn-confirm:hover {
            background-color: #218838;
        }

        /* CSS untuk Modal Status (diambil dari POS) */
        #status-modal-overlay {
            z-index: 3000;
            /* Paling tinggi */
        }

        #status-modal-overlay .modal-content {
            max-width: 400px;
            text-align: center;
        }

        .status-modal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-modal-icon-success {
            background-color: #eafbf0;
            color: var(--success);
            display: none;
        }

        .status-modal-icon-danger {
            background-color: #fdeeee;
            color: var(--danger);
            display: none;
        }

        #status-modal-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Daftar Pesanan Online</h1>
        {{-- **PERBAIKAN: Tampilkan Status Shift Aktif** --}}
        <div style="margin-top: 10px; font-size: 14px;">
            Status Shift: <strong id="shift-status-display" style="color: var(--danger);">Memuat...</strong>
        </div>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="margin-bottom: 24px;">
        {{-- Action Form menuju route 'admin.orders.online' --}}
        <form action="{{ route('admin.orders.online') }}" method="GET" class="filter-form">

            {{-- Search by ID / Invoice / No Meja --}}
            <div class="filter-group" style="flex-grow: 2;">
                <label for="search">Cari (ID / Invoice / No. Meja)</label>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="Contoh: 123 atau 'WEB-...' atau 'C2'" value="{{ $filters['search'] ?? '' }}">
            </div>

            {{-- Filter Tanggal --}}
            <div class="filter-group">
                <label for="date">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control"
                    value="{{ $filters['date'] ?? '' }}">
            </div>

            {{-- Filter Status --}}
            <div class="filter-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                    <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled
                    </option>
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary">Filter</button>
                {{-- Link Reset menuju route 'admin.orders.online' --}}
                <a href="{{ route('admin.orders.online') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>No. Meja</th>
                        <th>Total Harga</th>
                        <th>Metode Bayar</th>
                        <th>Status Bayar</th>
                        <th>Status Order</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $order->table->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->payment_method) }}</td>

                            {{-- Kolom Status Pembayaran --}}
                            <td>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($order->payment_status == 'unpaid')
                                    <span class="badge badge-warning">Unpaid</span>
                                @else
                                    <span class="badge badge-danger">{{ ucfirst($order->payment_status) }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($order->status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>

                            {{-- Aksi menggunakan tombol langsung dan Modal --}}
                            <td class="action-cell">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- Tombol 1: Detail --}}
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="btn btn-secondary action-btn">
                                        Detail
                                    </a>

                                    @if ($order->status != 'cancelled')
                                        {{-- Tombol 2: Selesaikan (Hanya jika Pending dan Paid) - Menggunakan Modal Complete --}}
                                        @if ($order->status == 'pending' && $order->payment_status == 'paid')
                                            <button type="button" class="btn btn-success action-btn"
                                                style="background-color: var(--success);"
                                                onclick="openCompleteModal({{ $order->id }})">
                                                Selesaikan
                                            </button>
                                            <form id="completeForm{{ $order->id }}"
                                                action="{{ route('admin.orders.update', $order) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <input type="hidden" name="cashier_shift_id"
                                                    id="completeShiftId{{ $order->id }}" value="">
                                            </form>
                                        @endif

                                        {{-- Tombol 3: Batalkan - Menggunakan Modal Cancel BARU --}}
                                        <button type="button" class="btn btn-danger action-btn"
                                            style="background-color: var(--danger);"
                                            onclick="openCancelModal({{ $order->id }})">
                                            Batalkan
                                        </button>
                                        <form id="cancelForm{{ $order->id }}"
                                            action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="cashier_shift_id"
                                                id="cancelShiftId{{ $order->id }}" value="">
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 20px; color: var(--text-muted);">
                                Tidak ada data pesanan online yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 20px;">
            {{-- .appends($filters) akan membuat pagination tetap mengingat filter/search Anda --}}
            {{ $orders->appends($filters)->links() }}
        </div>
    </div>

    {{-- Modal Status (Diperlukan untuk pesan error shift) --}}
    <div class="modal" id="status-modal-overlay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="status-modal-icon" class="status-modal-icon">
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
                    <h2 id="status-modal-title" style="text-align: center;"></h2>
                    <p id="status-modal-message" style="text-align: center; color: var(--text-muted);"></p>
                </div>
                <div class="modal-footer" id="status-modal-footer">
                    <button type="button" id="status-modal-ok-btn" class="modal-btn modal-btn-cancel">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal 1: Konfirmasi Selesaikan Pesanan --}}
    <div id="completeOrderModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Selesaikan Pesanan</h5>
                    <button type="button" class="modal-close" onclick="closeCompleteModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Yakin pesanan <strong id="orderIdTextComplete"></strong> sudah selesai diproses/diantar?</p>
                    <p style="color: #dc3545; font-weight: 500;">⚠️ Tindakan ini akan mengurangi stok produk.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeCompleteModal()">
                        Batal
                    </button>
                    <button type="button" class="modal-btn modal-btn-confirm" onclick="submitCompleteForm()">
                        Ya, Selesaikan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal 2: Konfirmasi Batalkan Pesanan --}}
    <div id="cancelOrderModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembatalan Pesanan</h5>
                    <button type="button" class="modal-close" onclick="closeCancelModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin **membatalkan** pesanan <strong id="orderIdTextCancel"></strong>?</p>
                    <p style="color: #dc3545; font-weight: 500;">⚠️ Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeCancelModal()">
                        Tutup
                    </button>
                    <button type="button" class="modal-btn modal-btn-confirm-cancel" onclick="submitCancelForm()">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentOrderId = null;
        // Variabel Shift (Diambil dari kode POS)
        let activeShift = null;
        let shouldRedirectToShift = false;

        // ===============================================
        // == FUNGSI KONTROL SHIFT (DIAMBIL DARI POS)
        // ===============================================
        async function checkActiveShift() {
            try {
                // Asumsi: Route ini valid dan mengembalikan objek { shift: { id, user_name, ... } } atau null
                const response = await fetch("{{ route('admin.shift.active') }}");
                const result = await response.json();

                activeShift = result.shift;
                updateShiftDisplay();

            } catch (error) {
                console.error('Gagal memuat status shift aktif:', error);
                activeShift = null;
                updateShiftDisplay();
            }
        }

        function updateShiftDisplay() {
            const displayEl = document.getElementById('shift-status-display');
            if (activeShift) {
                // PERBAIKAN: Gunakan Optional Chaining (?.) untuk mengakses user_name 
                // dan berikan string fallback jika user_name tidak ada.
                const cashierName = activeShift.user_name || 'N/A';

                // Ganti properti yang diakses jika nama kasir disimpan di properti lain (misalnya activeShift.user.name)
                // const cashierName = activeShift.user?.name || 'N/A'; // Coba jika activeShift berisi objek User

                displayEl.innerHTML = `AKTIF | Kasir: ${cashierName}`;
                displayEl.style.color = 'var(--success)';
            } else {
                displayEl.innerHTML = `TIDAK AKTIF (Harap buka shift untuk aksi)`;
                displayEl.style.color = 'var(--danger)';
            }
            // Tambahkan disabled state visual pada tombol jika diperlukan
            document.querySelectorAll('.action-cell button').forEach(button => {
                button.disabled = !activeShift;
                if (!activeShift) {
                    button.title = 'Harap Buka Shift Kasir Terlebih Dahulu.';
                } else {
                    button.title = '';
                }
            });
        }

        function requireActiveShift() {
            shouldRedirectToShift = true;
            showStatusModal('error', 'Akses Ditolak',
                'Harap buka sesi shift kasir Anda terlebih dahulu di halaman manajemen Shift sebelum memproses pesanan.'
            );
        }

        // ===============================================
        // == FUNGSI MODAL STATUS (Diperlukan untuk requireActiveShift)
        // ===============================================
        function showStatusModal(type, title, message) {
            const statusModal = document.getElementById('status-modal-overlay');
            const statusModalContent = statusModal.querySelector('.modal-content');
            const statusModalTitle = document.getElementById('status-modal-title');
            const statusModalMessage = document.getElementById('status-modal-message');
            const statusIconSuccess = statusModal.querySelector('.status-modal-icon-success');
            const statusIconDanger = statusModal.querySelector('.status-modal-icon-danger');

            statusModalTitle.innerText = title;
            statusModalMessage.innerText = message;

            // Reset kelas dan tampilkan ikon yang sesuai
            if (statusModalContent) {
                statusModalContent.classList.remove('success', 'error');
            }

            if (type === 'success' || type === 'pending') {
                if (statusModalContent) statusModalContent.classList.add('success');
                statusIconSuccess.style.display = 'flex';
                statusIconDanger.style.display = 'none';
            } else {
                if (statusModalContent) statusModalContent.classList.add('error');
                statusIconSuccess.style.display = 'none';
                statusIconDanger.style.display = 'flex';
            }

            statusModal.style.display = 'flex';
        }

        function closeStatusModal() {
            document.getElementById('status-modal-overlay').style.display = 'none';

            if (shouldRedirectToShift) {
                // Jika flag pengalihan aktif, lakukan pengalihan dan reset flag
                shouldRedirectToShift = false;
                window.location.href = "{{ route('admin.shift.index') }}";
                return;
            }
        }

        // --- Fungsi Global Modal Aksi ---

        function closeAllModals() {
            closeCompleteModal();
            closeCancelModal();
            currentOrderId = null;
        }

        // --- Fungsi Modal Selesaikan (Complete) ---

        function openCompleteModal(orderId) {
            if (!activeShift) {
                requireActiveShift();
                return;
            }
            currentOrderId = orderId;
            document.getElementById('orderIdTextComplete').textContent = '#' + orderId;
            document.getElementById('completeOrderModal').style.display = 'flex';
            // **PERBAIKAN JS: Isi ID Shift**
            if (activeShift && activeShift.id) {
                document.getElementById('completeShiftId' + orderId).value = activeShift.id;
            }
        }

        function closeCompleteModal() {
            document.getElementById('completeOrderModal').style.display = 'none';
        }

        function submitCompleteForm() {
            if (currentOrderId) {
                document.getElementById('completeForm' + currentOrderId).submit();
                closeAllModals();
            }
        }

        // --- Fungsi Modal Batalkan (Cancel) ---

        function openCancelModal(orderId) {
            if (!activeShift) {
                requireActiveShift();
                return;
            }
            currentOrderId = orderId;
            document.getElementById('orderIdTextCancel').textContent = '#' + orderId;
            document.getElementById('cancelOrderModal').style.display = 'flex';

            // **PERBAIKAN JS: Isi ID Shift**
            if (activeShift && activeShift.id) {
                document.getElementById('cancelShiftId' + orderId).value = activeShift.id;
            }
        }

        function closeCancelModal() {
            document.getElementById('cancelOrderModal').style.display = 'none';
        }

        function submitCancelForm() {
            if (currentOrderId) {
                const form = document.getElementById('cancelForm' + currentOrderId);
                const shiftId = document.getElementById('cancelShiftId' + currentOrderId).value;

                if (!shiftId) {
                    showStatusModal(
                        'error',
                        'Shift Tidak Terbaca',
                        'ID shift tidak ditemukan. Silakan refresh halaman atau buka shift kembali.'
                    );
                    return;
                }

                form.submit();
                closeAllModals();
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const completeModal = document.getElementById('completeOrderModal');
            const cancelModal = document.getElementById('cancelOrderModal');
            const statusModal = document.getElementById('status-modal-overlay');

            if (event.target == completeModal || event.target == cancelModal) {
                closeAllModals();
            }
            // Logika terpisah untuk Modal Status agar tidak mengganggu modal lain
            if (event.target == statusModal) {
                closeStatusModal();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAllModals();
                closeStatusModal();
            }
        });

        // Event listener untuk tombol OK di modal status
        document.getElementById('status-modal-ok-btn').addEventListener('click', closeStatusModal);

        // Panggil saat halaman dimuat
        window.addEventListener('load', checkActiveShift);
    </script>
@endpush
