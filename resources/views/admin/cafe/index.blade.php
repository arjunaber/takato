@extends('layouts.admin')

@section('title', 'POS Kasir')

{{-- 
======================================================================
 TAMBAHAN CSS KHUSUS POS (UNTUK OVERRIDE LAYOUT ADMIN)
======================================================================
--}}
@push('styles')
    <style>
        /* ... (CSS override .main-content, .pos-container, .cart Anda) ... */
        .main-content {
            padding: 0 !important;
            overflow-y: hidden !important;
        }

        .pos-container {
            display: flex;
            height: 100%;
            width: 100%;
        }

        .cart {
            flex: 2;
            background-color: var(--card-bg);
            padding: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.05);
        }

        /* ... (CSS Modal Pembayaran Anda) ... */
        .payment-total-display {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px dashed var(--border-color);
            display: flex;
            justify-content: space-between;
        }

        .payment-method-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .payment-method-selector .btn {
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            background-color: var(--secondary-light);
            color: var(--text-color);
            border: 2px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .payment-method-selector .btn.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }

        #cash-payment-section {
            margin-top: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
        }

        .payment-change-display {
            font-size: 24px;
            font-weight: 600;
            color: var(--success);
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
        }

        #payment-cash-change.negative {
            color: var(--danger);
        }


        /* ============================================================
                           CSS BARU: UNTUK MODAL STATUS (SUKSES/GAGAL)
                         ============================================================
                        */
        #status-modal-overlay .modal-content {
            max-width: 400px;
            /* Modal lebih kecil */
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

        .status-modal-icon svg {
            width: 40px;
            height: 40px;
        }

        /* Style untuk SUKSES */
        #status-modal-overlay .modal-content.success {
            border-top: 5px solid var(--success);
        }

        .status-modal-icon-success {
            background-color: #eafbf0;
            color: var(--success);
            display: none;
            /* Sembunyikan by default */
        }

        /* Style untuk GAGAL */
        #status-modal-overlay .modal-content.error {
            border-top: 5px solid var(--danger);
        }

        .status-modal-icon-danger {
            background-color: #fdeeee;
            color: var(--danger);
            display: none;
            /* Sembunyikan by default */
        }

        #status-modal-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        #status-modal-message {
            font-size: 16px;
            color: var(--text-muted);
        }

        #status-modal-overlay .modal-footer {
            justify-content: center;
            /* Tombol OK di tengah */
            gap: 10px;
            /* Beri jarak antar tombol */
        }

        /* ... (Sisa CSS POS Anda lainnya) ... */
        :root {
            --primary: #007bff;
            --primary-light: #e6f0ff;
            --secondary: #6c757d;
            --secondary-light: #f1f3f5;
            --success: #28a745;
            --purple: #6f42c1;
            --purple-light: #f4f0f9;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #495057;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .product-list {
            flex: 3;
            background-color: var(--body-bg);
            padding: 24px;
            overflow-y: hidden;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .product-nav-container {
            width: 100%;
            text-align: center;
            margin-bottom: 24px;
            flex-shrink: 0;
        }

        .product-nav {
            display: inline-flex;
            background-color: var(--secondary-light);
            border-radius: 10px;
            padding: 5px;
            border: 1px solid var(--border-color);
        }

        .nav-tab {
            background: none;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            color: var(--text-muted);
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .nav-tab.active {
            color: var(--primary);
            background-color: var(--card-bg);
            box-shadow: var(--shadow-sm);
        }

        .product-content {
            flex-grow: 1;
            overflow-y: auto;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .tab-pane h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
        }

        .category-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            box-shadow: var(--shadow-sm);
        }

        .category-item:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .category-icon {
            font-size: 32px;
            display: block;
            margin-bottom: 12px;
        }

        .category-name {
            font-weight: 600;
            font-size: 18px;
        }

        .library-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .library-header h2 {
            margin: 0 0 0 16px;
        }

        .back-button {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            font-weight: 600;
            font-size: 18px;
            height: 44px;
            width: 44px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background-color: #e2e6ea;
            border-color: #bBbcbe;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 20px;
        }

        .product-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            box-shadow: var(--shadow-sm);
        }

        .product-item:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .product-item .product-name {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .product-item .product-price {
            font-size: 14px;
            color: var(--text-muted);
        }

        .cart h2 {
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            flex-shrink: 0;
            font-weight: 700;
        }

        .cart-items {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 8px;
        }

        .cart-empty {
            text-align: center;
            color: var(--text-muted);
            padding-top: 50px;
        }

        .cart-item {
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 12px;
            background-color: var(--card-bg);
        }

        .cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-item-name {
            font-weight: 600;
            font-size: 16px;
        }

        .cart-item-price {
            font-weight: 600;
            font-size: 16px;
        }

        .cart-item-details {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        .cart-item-ordertype {
            display: inline-block;
            background-color: var(--secondary-light);
            color: var(--secondary);
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .cart-item-ordertype.custom {
            background-color: var(--purple-light);
            color: var(--purple);
        }

        .cart-item-details .detail-label {
            font-weight: 600;
            color: var(--text-color);
        }

        .cart-item-details ul {
            padding-left: 20px;
            margin: 4px 0 0 0;
        }

        .cart-item-note {
            font-style: italic;
        }

        .cart-item-discount {
            color: var(--success);
            font-weight: 600;
        }

        .cart-item-note,
        .cart-item-discount {
            font-size: 13px;
            margin-top: 5px;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            margin-top: 12px;
        }

        .cart-item-actions button {
            background: #f1f3f5;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: 30px;
            height: 30px;
            margin-right: 10px;
            font-size: 16px;
        }

        .cart-item-actions button:hover {
            background-color: #e9ecef;
        }

        .cart-item-actions span {
            font-weight: 600;
            font-size: 16px;
        }

        .cart-item-actions .remove-btn {
            background: #fff0f0;
            color: #dc3545;
            font-size: 12px;
            font-weight: 500;
            margin-left: auto;
            width: auto;
            padding: 0 10px;
            border-color: #f5c6cb;
        }

        .cart-summary {
            flex-shrink: 0;
            padding-top: 20px;
            border-top: 2px dashed var(--border-color);
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 16px;
            color: var(--text-muted);
        }

        .summary-row span:last-child {
            font-weight: 600;
            color: var(--text-color);
        }

        .summary-row.total {
            font-weight: 700;
            font-size: 20px;
            color: var(--text-color);
        }

        .summary-row.total span:last-child {
            color: var(--primary);
        }

        .pay-button {
            flex-shrink: 0;
            width: 100%;
            padding: 16px;
            font-size: 18px;
            font-weight: 700;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.2s ease;
        }

        .pay-button:hover {
            background-color: #0069d9;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .pay-button:disabled {
            background-color: var(--text-muted);
            cursor: not-allowed;
        }

        /* Modal POS Item */
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
            background-color: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 30px;
            font-weight: 400;
            color: var(--text-muted);
            cursor: pointer;
        }

        .modal-body {
            overflow-y: auto;
            padding-right: 10px;
        }

        .modal-body h3 {
            font-size: 16px;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
            color: var(--primary);
        }

        .modal-body h3:first-child {
            margin-top: 0;
        }

        .modal-body h3.ordertype-header {
            color: var(--secondary);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control-modern input,
        .form-control-modern textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            background-color: #fff;
        }

        .form-control-modern textarea {
            resize: vertical;
        }

        .custom-item-btn {
            width: 100%;
            background-color: var(--success);
            color: white;
            border: none;
            padding: 14px 22px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .custom-item-btn:hover {
            background-color: #218838;
        }

        .option-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-grid-2-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .option-item-wrapper {
            position: relative;
        }

        .option-item-wrapper input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
            z-index: 10;
        }

        .option-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s ease;
            background-color: #fff;
        }

        .option-name {
            font-weight: 500;
            font-size: 14px;
        }

        .option-price {
            font-weight: 600;
            color: var(--text-color);
            font-size: 14px;
        }

        .option-price-addon {
            font-weight: 600;
            color: var(--primary);
            font-size: 14px;
        }

        .option-price-discount {
            font-weight: 600;
            color: var(--success);
            font-size: 14px;
        }

        .option-price-ordertype {
            font-weight: 600;
            color: var(--secondary);
            font-size: 14px;
        }

        .option-item-wrapper input:hover+.option-item {
            border-color: var(--primary);
            background-color: #f8f9fa;
        }

        .option-item-wrapper input:checked+.option-item {
            border-color: var(--primary);
            background-color: var(--primary-light);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .option-item-wrapper input[type="checkbox"]+.option-item::before {
            content: '☐';
            font-size: 20px;
            margin-right: 12px;
            color: var(--text-muted);
        }

        .option-item-wrapper input[type="checkbox"]:checked+.option-item::before {
            content: '☑';
            color: var(--primary);
        }

        .option-item-wrapper input[type="radio"]+.option-item::before {
            content: '○';
            font-size: 20px;
            margin-right: 12px;
            color: var(--text-muted);
        }

        .option-item-wrapper input[type="radio"]:checked+.option-item::before {
            content: '●';
            color: var(--primary);
        }

        .modal-footer {
            margin-top: 25px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
            display: flex;
            align-items: center;
        }

        #item-modal-overlay .modal-footer {
            justify-content: space-between;
        }

        #payment-modal-overlay .modal-footer {
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer-price {
            font-size: 24px;
            font-weight: 700;
        }

        .modal-save-btn {
            background-color: var(--success);
            color: white;
            border: none;
            padding: 14px 22px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-save-btn:hover {
            background-color: #218838;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        @media (max-width: 1024px) {
            .product-list {
                flex: 1;
            }

            .cart {
                flex: 1;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .category-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .modal-content {
                max-height: 80vh;
            }

            .product-nav {
                width: 100%;
            }

            .nav-tab {
                flex: 1;
            }
        }
    </style>
@endpush


{{-- 
======================================================================
 KONTEN HTML POS ANDA
======================================================================
--}}
@section('content')
    <div class="pos-container">
        {{-- ... (Konten .product-list Anda) ... --}}
        <div class="product-list">
            <div class="product-nav-container">
                <div class="product-nav">
                    <button class="nav-tab active" onclick="showTab('favorit', this)">Favorit</button>
                    <button class="nav-tab" onclick="showTab('library', this)">Library</button>
                    <button class="nav-tab" onclick="showTab('custom', this)">Custom</button>
                </div>
            </div>
            <div class="product-content">
                <div id="tab-favorit" class="tab-pane active">
                    <h2>Produk Favorit</h2>
                    <div class="product-grid" id="favorit-product-grid"></div>
                </div>
                <div id="tab-library" class="tab-pane">
                    <div id="library-categories-view">
                        <h2>Kategori Produk</h2>
                        <div class="category-grid" id="category-grid-container"></div>
                    </div>
                    <div id="library-products-view" style="display: none;">
                        <div class="library-header">
                            <button class="back-button" onclick="showCategoryList()">←</button>
                            <h2 id="library-category-name">Nama Kategori</h2>
                        </div>
                        <div class="product-grid" id="library-product-grid"></div>
                    </div>
                </div>
                <div id="tab-custom" class="tab-pane">
                    <h2>Custom Item</h2>
                    <div class="custom-item-form">
                        <div class="form-group form-control-modern">
                            <label for="custom-item-name">Nama Item</label>
                            <input type="text" id="custom-item-name" placeholder="cth: Piring Pecah">
                        </div>
                        <div class="form-group form-control-modern">
                            <label for="custom-item-price">Harga (Rp)</label>
                            <input type="number" id="custom-item-price" placeholder="cth: 50000" min="0">
                        </div>
                        <button class="custom-item-btn" onclick="addCustomItemToCart()">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ... (Konten .cart Anda) ... --}}
        <div class="cart">
            <h2>Pesanan Saat Ini</h2>
            <div class="cart-items" id="cart-items-container"></div>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="summary-subtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span id="summary-tax">Rp 0</span>
                </div>
                <hr style="border:0; border-top: 1px dashed var(--border-color); margin: 10px 0;">
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="summary-total">Rp 0</span>
                </div>
            </div>
            <button class="pay-button" id="pay-button" onclick="openPaymentModal()">Bayar</button>
        </div>
    </div>

    {{-- ... (Modal Item Anda) ... --}}
    <div class="modal-overlay" id="item-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 id="modal-item-name">Nama Item</h2>
                <button class="modal-close-btn" onclick="closeItemModal()">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Pilih Varian (Wajib)</h3>
                <div class="option-group" id="modal-item-variants"></div>
                <h3>Pilih Add-Ons (Opsional)</h3>
                <div class="option-group" id="modal-item-addons"></div>
                <h3 class="ordertype-header">Pilih Tipe Pesanan</h3>
                <div class="option-group" id="modal-item-ordertypes"></div>
                <h3>Pilih Diskon (Opsional)</h3>
                <div class="option-grid-2-col" id="modal-item-discounts"></div>
                <h3>Detail Lainnya</h3>
                <div class="form-group form-control-modern">
                    <label for="modal-item-quantity">Jumlah</label>
                    <input type="number" id="modal-item-quantity" value="1" min="1"
                        oninput="updateModalPrice()">
                </div>
                <div class="form-group form-control-modern">
                    <label for="modal-item-note">Catatan per-Item</label>
                    <textarea id="modal-item-note" rows="2" placeholder="cth: Jangan terlalu pedas"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-price" id="modal-item-price">Rp 0</div>
                <button class="modal-save-btn" onclick="saveItemToCart()">Simpan ke Keranjang</button>
            </div>
        </div>
    </div>

    {{-- ... (Modal Pembayaran Anda) ... --}}
    <div class="modal-overlay" id="payment-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Pembayaran</h2>
                <button class="modal-close-btn" onclick="closePaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="payment-total-display">
                    <span>Total Belanja:</span>
                    <strong id="payment-modal-total">Rp 0</strong>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <div class="payment-method-selector">
                        <button id="pay-btn-cash" class="btn active">Tunai (Cash)</button>
                        <button id="pay-btn-gateway" class="btn">Non Cash</button>
                    </div>
                </div>
                <div id="cash-payment-section">
                    <div class="form-group form-control-modern">
                        <label for="payment-cash-amount">Nominal Uang Diterima (Rp)</label>
                        <input type="number" id="payment-cash-amount" class="form-control" placeholder="cth: 100000">
                    </div>
                    <div class="payment-change-display">
                        <span>Kembalian:</span>
                        <strong id="payment-cash-change">Rp 0</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closePaymentModal()"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Batal</button>
                <button type="button" id="payment-submit-btn" class="btn btn-primary" onclick="submitPayment()">
                    Proses Pesanan
                </button>
            </div>
        </div>
    </div>

    {{-- =================================== --}}
    {{-- ==  HTML MODAL STATUS (BARU)     == --}}
    {{-- =================================== --}}
    <div class="modal-overlay" id="status-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-body">
                <div id="status-modal-icon">
                    {{-- Ikon Sukses (SVG) --}}
                    <div class="status-modal-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    {{-- Ikon Gagal (SVG) --}}
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

            {{-- ==== PERUBAHAN HTML DI SINI ==== --}}
            <div class="modal-footer" id="status-modal-footer">
                {{-- Tombol Cetak (disembunyikan by default) --}}
                <button type="button" id="status-modal-print-btn" class="btn btn-secondary"
                    style="display: none; background-color: var(--secondary-light); color: var(--text-color);">
                    Cetak Struk
                </button>
                {{-- Tombol OK (ganti ID) --}}
                <button type="button" id="status-modal-ok-btn" class="btn btn-primary">OK</button>
            </div>
            {{-- ==== AKHIR PERUBAHAN ==== --}}

        </div>
    </div>
@endsection

{{-- 
======================================================================
 JAVASCRIPT POS ANDA + SCRIPT UNTUK TUTUP SIDEBAR
======================================================================
--}}
@push('scripts')
    <script>
        // ... (Script Sidebar Toggle) ...
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const storageKey = 'sidebarState';
            if (!body.classList.contains('sidebar-closed')) {
                body.classList.add('sidebar-closed');
                localStorage.setItem(storageKey, 'closed');
            }
        });

        // ===============================================
        // ==  SCRIPT ASLI POS ANDA
        // ===============================================
        const allCategories = @json($categories ?? []);
        const allLibraryProducts = @json($libraryProducts ?? []);
        const allFavoriteProducts = @json($favoriteProducts ?? []);
        const allDiscounts = @json($discounts ?? []);
        const allOrderTypes = @json($orderTypes ?? []);

        // Variabel global
        let cartItems = [];
        let currentEditingProduct = null;
        let currentTax = 0;
        let currentSubtotal = 0;
        let currentTotal = 0;
        let currentPaymentMethod = 'cash';
        let currentCashAmount = 0;
        let currentChange = 0;

        // == VARIABEL BARU UNTUK MODAL STATUS ==
        let isLastTransactionSuccess = false; // Flag untuk reset keranjang
        let lastSuccessfulOrderId = null; // **BARU**: Menyimpan ID order untuk print


        // ===============================================
        // ==  FUNGSI (TAB, KATEGORI, CUSTOM)
        // ===============================================
        function showTab(tabName, clickedButton) {
            /* ... (kode tidak berubah) ... */
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
            clickedButton.classList.add('active');
        }

        function addCustomItemToCart() {
            /* ... (kode tidak berubah) ... */
            const nameInput = document.getElementById('custom-item-name');
            const priceInput = document.getElementById('custom-item-price');
            const name = nameInput.value.trim();
            const price = parseFloat(priceInput.value) || 0;
            if (!name || price <= 0) {
                alert('Nama item dan harga (lebih dari 0) harus diisi.');
                return;
            }
            const cartItem = {
                id: 'custom-' + Date.now(),
                name: name,
                quantity: 1,
                note: '',
                finalPrice: price,
                isCustom: true
            };
            cartItems.push(cartItem);
            renderCart();
            updateSummary();
            nameInput.value = '';
            priceInput.value = '';
        }

        function renderCategories() {
            /* ... (kode tidak berubah) ... */
            const grid = document.getElementById('category-grid-container');
            grid.innerHTML = '';
            allCategories.forEach(cat => {
                const categoryElement = document.createElement('div');
                categoryElement.className = 'category-item';
                categoryElement.onclick = () => showCategoryProducts(cat.id, cat.name);
                categoryElement.innerHTML =
                    `<span class="category-icon">${cat.icon || '📁'}</span><span class="category-name">${cat.name}</span>`;
                grid.appendChild(categoryElement);
            });
        }

        function showCategoryProducts(categoryId, categoryName) {
            /* ... (kode tidak berubah) ... */
            document.getElementById('library-categories-view').style.display = 'none';
            document.getElementById('library-products-view').style.display = 'block';
            document.getElementById('library-category-name').innerText = categoryName;
            const filteredProducts = allLibraryProducts.filter(p => p.category_id === categoryId);
            renderProductsInGrid('library-product-grid', filteredProducts);
        }

        function showCategoryList() {
            /* ... (kode tidak berubah) ... */
            document.getElementById('library-categories-view').style.display = 'block';
            document.getElementById('library-products-view').style.display = 'none';
        }

        // ===============================================
        // ==  FUNGSI UTAMA (Sistem & Keranjang)
        // ===============================================
        function formatRupiah(number) {
            /* ... (kode tidak berubah) ... */
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function renderProductsInGrid(gridId, productArray) {
            /* ... (kode tidak berubah) ... */
            const grid = document.getElementById(gridId);
            grid.innerHTML = '';
            if (!productArray || productArray.length === 0) {
                grid.innerHTML = '<p style="color: var(--text-muted); grid-column: 1 / -1;">Tidak ada produk.</p>';
                return;
            }
            productArray.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'product-item';
                productElement.onclick = () => openItemModal(product);
                let minPrice = 0;
                if (product.variants && product.variants.length > 0) {
                    minPrice = Math.min(...product.variants.map(v => parseFloat(v.price)));
                }
                productElement.innerHTML =
                    `<div class="product-name">${product.name}</div><div class="product-price">Mulai ${formatRupiah(minPrice)}</div>`;
                grid.appendChild(productElement);
            });
        }

        function renderFavoriteProducts() {
            /* ... (kode tidak berubah) ... */
            renderProductsInGrid('favorit-product-grid', allFavoriteProducts);
        }

        function renderCart() {
            /* ... (kode tidak berubah) ... */
            const cartContainer = document.getElementById('cart-items-container');
            cartContainer.innerHTML = '';
            if (cartItems.length === 0) {
                // HAPUS showStatusModal() DARI SINI
                // CUKUP TAMPILKAN PESAN KOSONG
                cartContainer.innerHTML = '<p class="cart-empty">Keranjang masih kosong.</p>';
                return;
            }
            cartItems.forEach((item, index) => {
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                if (item.isCustom) {
                    cartItemElement.innerHTML = `
                    <div class="cart-item-ordertype custom">Custom</div>
                    <div class="cart-item-header"><span class="cart-item-name">${item.name}</span><span class="cart-item-price">${formatRupiah(item.finalPrice)}</span></div>
                    <div class="cart-item-actions">
                        <button onclick="updateCartQuantity(${index}, -1)">-</button><span>${item.quantity}</span><button onclick="updateCartQuantity(${index}, 1)">+</button>
                        <button class="remove-btn" onclick="removeCartItem(${index})">Hapus</button>
                    </div>`;
                } else {
                    let addonsHtml = '<ul>';
                    if (item.selectedAddons.length > 0) {
                        item.selectedAddons.forEach(addon => {
                            addonsHtml += `<li>${addon.name} (+${formatRupiah(addon.price)})</li>`;
                        });
                    } else {
                        addonsHtml += '<li>-</li>';
                    }
                    addonsHtml += '</ul>';
                    let discountHtml = '';
                    if (item.discount.id > 1) {
                        discountHtml = `<div class="cart-item-discount">Diskon: ${item.discount.name}</div>`;
                    }
                    let noteHtml = '';
                    if (item.note.trim() !== '') {
                        noteHtml = `<div class="cart-item-note">Catatan: ${item.note}</div>`;
                    }
                    let orderTypeHtml = `<div class="cart-item-ordertype">${item.selectedOrderType.name}</div>`;
                    cartItemElement.innerHTML = `
                    ${orderTypeHtml}
                    <div class="cart-item-header"><span class="cart-item-name">${item.name} (${item.selectedVariant.name})</span><span class="cart-item-price">${formatRupiah(item.finalPrice)}</span></div>
                    <div class="cart-item-details"><span class="detail-label">Add-ons:</span>${addonsHtml}${discountHtml}${noteHtml}</div>
                    <div class="cart-item-actions">
                        <button onclick="updateCartQuantity(${index}, -1)">-</button><span>${item.quantity}</span><button onclick="updateCartQuantity(${index}, 1)">+</button>
                        <button class="remove-btn" onclick="removeCartItem(${index})">Hapus</button>
                    </div>`;
                }
                cartContainer.appendChild(cartItemElement);
            });
        }

        function updateCartQuantity(index, change) {
            /* ... (kode tidak berubah) ... */
            cartItems[index].quantity += change;
            if (cartItems[index].quantity <= 0) {
                cartItems.splice(index, 1);
            }
            renderCart();
            updateSummary();
        }

        function removeCartItem(index) {
            /* ... (kode tidak berubah) ... */
            cartItems.splice(index, 1);
            renderCart();
            updateSummary();
        }

        function updateSummary() {
            /* ... (kode tidak berubah) ... */
            let subtotal = 0;
            cartItems.forEach(item => {
                subtotal += item.finalPrice * item.quantity;
            });
            const taxRate = 0.10;
            const tax = subtotal * taxRate;
            const total = subtotal + tax;
            currentSubtotal = subtotal;
            currentTax = tax;
            currentTotal = total;
            document.getElementById('summary-subtotal').innerText = formatRupiah(subtotal);
            document.getElementById('summary-tax').innerText = formatRupiah(tax);
            document.getElementById('summary-total').innerText = formatRupiah(total);
        }

        // ===============================================
        // ==  Fungsi submitPayment (AJAX) - DIMODIFIKASI
        // ===============================================
        async function submitPayment() {
            const payButton = document.getElementById('payment-submit-btn');
            payButton.disabled = true;
            payButton.innerText = 'Memproses...';
            isLastTransactionSuccess = false; // Reset flag
            lastSuccessfulOrderId = null; // Reset flag ID

            const dataToSend = {
                cartItems: cartItems,
                subtotal: currentSubtotal,
                tax: currentTax,
                total: currentTotal,
                paymentMethod: currentPaymentMethod,
                cashReceived: (currentPaymentMethod === 'cash') ? currentCashAmount : null,
                cashChange: (currentPaymentMethod === 'cash') ? currentChange : null,
            };

            try {
                const response = await fetch("{{ route('admin.pos.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataToSend)
                });

                const result = await response.json();
                if (!response.ok) {
                    throw new Error(result.error || result.message || 'Terjadi kesalahan server');
                }

                // == SUKSES ==
                isLastTransactionSuccess = true;
                lastSuccessfulOrderId = result.order_id; // Simpan ID untuk print
                showStatusModal('success', 'Pesanan Berhasil', 'Order ID: ' + result.order_id +
                    ' telah berhasil disimpan.');

            } catch (error) {
                console.error('Error submitting payment:', error);
                // == GAGAL ==
                isLastTransactionSuccess = false;
                lastSuccessfulOrderId = null;
                showStatusModal('error', 'Gagal Menyimpan', error.message);

            } finally {
                payButton.disabled = false;
                payButton.innerText = 'Proses Pesanan';
            }
        }

        // ===============================================
        // ==  FUNGSI MODAL ITEM (Lama, tidak berubah)
        // ===============================================
        function openItemModal(product) {
            /* ... (kode tidak berubah) ... */
            currentEditingProduct = product;
            document.getElementById('modal-item-name').innerText = product.name;
            const variantsContainer = document.getElementById('modal-item-variants');
            variantsContainer.innerHTML = '';
            product.variants.forEach((variant, index) => {
                const isChecked = index === 0 ? 'checked' : '';
                const variantId = `variant-${product.id}-${index}`;
                variantsContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${variantId}" name="variant-${product.id}" value="${index}" ${isChecked} onchange="updateModalPrice()"><label class="option-item" for="${variantId}"><span class="option-name">${variant.name}</span><span class="option-price">${formatRupiah(variant.price)}</span></label></div>`;
            });
            const addonsContainer = document.getElementById('modal-item-addons');
            addonsContainer.innerHTML = '';
            if (!product.addons || product.addons.length === 0) {
                addonsContainer.innerHTML =
                    '<p style="font-size: 14px; color: var(--text-muted);">Tidak ada add-on untuk item ini.</p>';
            } else {
                product.addons.forEach((addon, index) => {
                    const addonId = `addon-${product.id}-${index}`;
                    addonsContainer.innerHTML +=
                        `<div class="option-item-wrapper"><input type="checkbox" id="${addonId}" name="addon-${product.id}" value="${index}" onchange="updateModalPrice()"><label class="option-item" for="${addonId}"><span class="option-name">${addon.name}</span><span class="option-price-addon">+ ${formatRupiah(addon.price)}</span></label></div>`;
                });
            }
            const orderTypesContainer = document.getElementById('modal-item-ordertypes');
            orderTypesContainer.innerHTML = '';
            allOrderTypes.forEach(type => {
                const isChecked = type.id === 1 ? 'checked' : '';
                const typeId = `ordertype-${type.id}`;
                let priceText = '';
                if (type.type === 'percentage') priceText = `+ ${parseFloat(type.value) * 100}%`;
                else if (parseFloat(type.value) > 0) priceText = `+ ${formatRupiah(type.value)}`;
                orderTypesContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${typeId}" name="ordertype" value="${type.id}" ${isChecked} onchange="updateModalPrice()"><label class="option-item" for="${typeId}"><span class="option-name">${type.name}</span><span class="option-price-ordertype">${priceText}</span></label></div>`;
            });
            const discountsContainer = document.getElementById('modal-item-discounts');
            discountsContainer.innerHTML = '';
            allDiscounts.forEach(discount => {
                const isChecked = discount.id === 1 ? 'checked' : '';
                const discountId = `discount-${discount.id}`;
                let priceText = '';
                if (discount.type === 'percentage') priceText = `${parseFloat(discount.value) * 100}%`;
                else if (parseFloat(discount.value) > 0) priceText = `-${formatRupiah(discount.value)}`;
                discountsContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${discountId}" name="discount" value="${discount.id}" ${isChecked} onchange="updateModalPrice()"><label class="option-item" for="${discountId}"><span class="option-name">${discount.name}</span><span class="option-price-discount">${priceText}</span></label></div>`;
            });
            document.getElementById('modal-item-quantity').value = 1;
            document.getElementById('modal-item-note').value = '';
            updateModalPrice();
            document.getElementById('item-modal-overlay').style.display = 'flex';
        }

        function closeItemModal() {
            /* ... (kode tidak berubah) ... */
            document.getElementById('item-modal-overlay').style.display = 'none';
            currentEditingProduct = null;
        }

        function updateModalPrice() {
            /* ... (kode tidak berubah) ... */
            if (!currentEditingProduct) return;
            const selectedVariantIndex = document.querySelector(`input[name="variant-${currentEditingProduct.id}"]:checked`)
                .value;
            const variant = currentEditingProduct.variants[selectedVariantIndex];
            let price = parseFloat(variant.price);
            const selectedAddonCheckboxes = document.querySelectorAll(
                `input[name="addon-${currentEditingProduct.id}"]:checked`);
            selectedAddonCheckboxes.forEach(checkbox => {
                const addon = currentEditingProduct.addons[checkbox.value];
                price += parseFloat(addon.price);
            });
            const selectedOrderTypeRadio = document.querySelector('input[name="ordertype"]:checked');
            const selectedOrderTypeId = selectedOrderTypeRadio ? selectedOrderTypeRadio.value : 1;
            const selectedOrderType = allOrderTypes.find(t => t.id == selectedOrderTypeId);
            if (selectedOrderType) {
                if (selectedOrderType.type === 'percentage') {
                    price = price * (1 + parseFloat(selectedOrderType.value));
                } else {
                    price = price + parseFloat(selectedOrderType.value);
                }
            }
            const selectedDiscountRadio = document.querySelector('input[name="discount"]:checked');
            const selectedDiscountId = selectedDiscountRadio ? selectedDiscountRadio.value : 1;
            const selectedDiscount = allDiscounts.find(d => d.id == selectedDiscountId);
            if (selectedDiscount) {
                let discountAmount = 0;
                if (selectedDiscount.type === 'percentage') {
                    discountAmount = price * parseFloat(selectedDiscount.value);
                } else {
                    discountAmount = parseFloat(selectedDiscount.value);
                }
                let priceAfterDiscount = price - discountAmount;
                if (priceAfterDiscount < 0) priceAfterDiscount = 0;
                price = priceAfterDiscount;
            }
            const quantity = parseInt(document.getElementById('modal-item-quantity').value) || 1;
            const totalPrice = price * quantity;
            document.getElementById('modal-item-price').innerText = formatRupiah(totalPrice);
        }

        function saveItemToCart() {
            /* ... (kode tidak berubah) ... */
            const variantIndex = document.querySelector(`input[name="variant-${currentEditingProduct.id}"]:checked`).value;
            const selectedVariant = currentEditingProduct.variants[variantIndex];
            const selectedAddons = [];
            if (currentEditingProduct.addons && currentEditingProduct.addons.length > 0) {
                const addonCheckboxes = document.querySelectorAll(
                    `input[name="addon-${currentEditingProduct.id}"]:checked`);
                addonCheckboxes.forEach(checkbox => {
                    selectedAddons.push(currentEditingProduct.addons[checkbox.value]);
                });
            }
            const selectedOrderTypeRadio = document.querySelector('input[name="ordertype"]:checked');
            const selectedOrderTypeId = selectedOrderTypeRadio ? selectedOrderTypeRadio.value : 1;
            const selectedOrderType = allOrderTypes.find(t => t.id == selectedOrderTypeId);
            const selectedDiscountRadio = document.querySelector('input[name="discount"]:checked');
            const selectedDiscountId = selectedDiscountRadio ? selectedDiscountRadio.value : 1;
            const selectedDiscount = allDiscounts.find(d => d.id == selectedDiscountId);
            const quantity = parseInt(document.getElementById('modal-item-quantity').value) || 1;
            const note = document.getElementById('modal-item-note').value;
            let basePrice = parseFloat(selectedVariant.price);
            selectedAddons.forEach(addon => {
                basePrice += parseFloat(addon.price);
            });
            if (selectedOrderType.type === 'percentage') {
                basePrice = basePrice * (1 + parseFloat(selectedOrderType.value));
            } else {
                basePrice = basePrice + parseFloat(selectedOrderType.value);
            }
            let discountAmount = 0;
            if (selectedDiscount.type === 'percentage') {
                discountAmount = basePrice * parseFloat(selectedDiscount.value);
            } else {
                discountAmount = parseFloat(selectedDiscount.value);
            }
            const finalPricePerItem = basePrice - discountAmount < 0 ? 0 : basePrice - discountAmount;
            const cartItem = {
                id: currentEditingProduct.id,
                name: currentEditingProduct.name,
                quantity: quantity,
                note: note,
                selectedVariant: selectedVariant,
                selectedAddons: selectedAddons,
                selectedOrderType: selectedOrderType,
                discount: selectedDiscount,
                finalPrice: finalPricePerItem,
                isCustom: false
            };
            cartItems.push(cartItem);
            renderCart();
            updateSummary();
            closeItemModal();
        }


        // ===============================================
        // ==  SCRIPT MODAL PEMBAYARAN (Lama, tidak berubah)
        // ===============================================
        const paymentModal = document.getElementById('payment-modal-overlay');
        const paymentTotalEl = document.getElementById('payment-modal-total');
        const cashSection = document.getElementById('cash-payment-section');
        const cashAmountInput = document.getElementById('payment-cash-amount');
        const cashChangeEl = document.getElementById('payment-cash-change');
        const payBtnCash = document.getElementById('pay-btn-cash');
        const payBtnGateway = document.getElementById('pay-btn-gateway');
        const finalSubmitBtn = document.getElementById('payment-submit-btn');

        function openPaymentModal() {
            /* ... (kode tidak berubah) ... */
            if (cartItems.length === 0) {
                showStatusModal('error', 'Keranjang Kosong', 'Anda belum menambahkan item apapun ke keranjang.');
                return;
            }
            paymentTotalEl.innerText = formatRupiah(currentTotal);
            currentPaymentMethod = 'cash';
            cashAmountInput.value = '';
            cashChangeEl.innerText = 'Rp 0';
            cashChangeEl.classList.remove('negative');
            cashSection.style.display = 'block';
            payBtnCash.classList.add('active');
            payBtnGateway.classList.remove('active');
            finalSubmitBtn.disabled = true;
            paymentModal.style.display = 'flex';
        }

        function closePaymentModal() {
            /* ... (kode tidak berubah) ... */
            paymentModal.style.display = 'none';
        }
        payBtnCash.addEventListener('click', () => {
            /* ... (kode tidak berubah) ... */
            currentPaymentMethod = 'cash';
            cashSection.style.display = 'block';
            payBtnCash.classList.add('active');
            payBtnGateway.classList.remove('active');
            calculateChange();
        });
        payBtnGateway.addEventListener('click', () => {
            /* ... (kode tidak berubah) ... */
            currentPaymentMethod = 'gateway';
            cashSection.style.display = 'none';
            payBtnCash.classList.remove('active');
            payBtnGateway.classList.add('active');
            finalSubmitBtn.disabled = false;
        });
        cashAmountInput.addEventListener('input', calculateChange);

        function calculateChange() {
            /* ... (kode tidak berubah) ... */
            const cashAmount = parseFloat(cashAmountInput.value) || 0;
            currentCashAmount = cashAmount;
            if (cashAmount <= 0) {
                cashChangeEl.innerText = 'Rp 0';
                cashChangeEl.classList.remove('negative');
                finalSubmitBtn.disabled = true;
                return;
            }
            const change = cashAmount - currentTotal;
            currentChange = change;
            if (change < 0) {
                cashChangeEl.innerText = `Uang Kurang: ${formatRupiah(change)}`;
                cashChangeEl.classList.add('negative');
                finalSubmitBtn.disabled = true;
            } else {
                cashChangeEl.innerText = formatRupiah(change);
                cashChangeEl.classList.remove('negative');
                finalSubmitBtn.disabled = false;
            }
        }

        // ===============================================
        // ==  SCRIPT MODAL STATUS (DIMODIFIKASI)
        // ===============================================

        const statusModal = document.getElementById('status-modal-overlay');
        const statusModalContent = statusModal.querySelector('.modal-content');
        const statusModalTitle = document.getElementById('status-modal-title');
        const statusModalMessage = document.getElementById('status-modal-message');
        const statusIconSuccess = statusModal.querySelector('.status-modal-icon-success');
        const statusIconDanger = statusModal.querySelector('.status-modal-icon-danger');

        // **PERUBAHAN 1: Ganti nama variabel**
        const statusOkBtn = document.getElementById('status-modal-ok-btn');
        // **PERUBAHAN 2: Tambahkan tombol print**
        const statusPrintBtn = document.getElementById('status-modal-print-btn');

        /**
         * Menampilkan modal status
         * @param {'success'|'error'} type Tipe modal
         * @param {string} title Judul modal
         * @param {string} message Pesan di modal
         */
        function showStatusModal(type, title, message) {
            statusModalTitle.innerText = title;
            statusModalMessage.innerText = message;

            // **PERUBAHAN 3: Reset tombol print**
            statusPrintBtn.style.display = 'none';
            statusPrintBtn.onclick = null;

            if (type === 'success') {
                statusModalContent.classList.remove('error');
                statusModalContent.classList.add('success');
                statusIconSuccess.style.display = 'flex';
                statusIconDanger.style.display = 'none';

                // **PERUBAHAN 4: Tampilkan tombol print jika sukses**
                if (lastSuccessfulOrderId) {
                    statusPrintBtn.style.display = 'block'; // Tampilkan
                    // Atur fungsi kliknya
                    statusPrintBtn.onclick = () => printReceipt(lastSuccessfulOrderId);
                }
            } else { // 'error'
                statusModalContent.classList.remove('success');
                statusModalContent.classList.add('error');
                statusIconSuccess.style.display = 'none';
                statusIconDanger.style.display = 'flex';
            }
            statusModal.style.display = 'flex';
        }

        // **FUNGSI BARU: Untuk print**
        function printReceipt(orderId) {
            const url = `/admin/orders/${orderId}/receipt`;
            window.open(url, '_blank');
        }

        // Fungsi untuk menutup modal status
        function closeStatusModal() {
            statusModal.style.display = 'none';
            if (isLastTransactionSuccess) {
                closePaymentModal();
                cartItems = [];
                renderCart();
                updateSummary();
                isLastTransactionSuccess = false;
                lastSuccessfulOrderId = null; // **BARU**: Reset ID
            }
        }

        // Ganti event listener ke tombol 'OK'
        statusOkBtn.addEventListener('click', closeStatusModal);


        // ===============================================
        // ==  Panggil fungsi saat halaman dimuat
        // ===============================================
        window.onload = () => {
            renderProductsInGrid('favorit-product-grid', allFavoriteProducts);
            renderCategories();
            renderCart();
            updateSummary();

            document.getElementById('item-modal-overlay').onclick = closeItemModal;
            document.getElementById('payment-modal-overlay').onclick = closePaymentModal;
            document.getElementById('status-modal-overlay').onclick = closeStatusModal;
        };
    </script>
@endpush
