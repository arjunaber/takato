@extends('layouts.admin')

@section('title', 'POS Kasir')

{{-- 
======================================================================
 TAMBAHAN CSS KHUSUS POS (UNTUK OVERRIDE LAYOUT ADMIN)
======================================================================
--}}
@push('styles')
    <style>
        /* [ ... KODE CSS LAMA TIDAK BERUBAH ... ] */
        html,
        body {
            height: 100%;
            margin: 0;
            /* Penting: Set overflow hidden pada body untuk mencegah double scrollbar */
            overflow: hidden;
        }

        .main-content {
            padding: 0 !important;
            overflow-y: hidden !important;
            height: 100%;
        }

        .pos-container {
            display: flex;
            /* SOLUSI AMAN: Kurangi 55px (estimasi tinggi navbar/header admin). */
            height: calc(100vh - 55px);
            width: 100%;
        }

        .cart {
            flex: 2;
            background-color: var(--card-bg);
            padding: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .product-list {
            height: 100%;
            flex: 3;
            background-color: var(--body-bg);
            padding: 24px;
            overflow-y: hidden;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        /* ======================================================================
                                                                                                                                                                                                                                                                                                                                                                        * MODIFIKASI TOMBOL AKSI KERANJANG (BARU)
                                                                                                                                                                                                                                                                                                                                                                        * ====================================================================== */

        .cart-actions-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* Dua kolom utama: Open Bill/View Bill dan Bayar */
            gap: 10px;
            flex-shrink: 0;
            margin-top: 25px;
            margin-bottom: 100px;
        }

        /* Grup tombol kecil di kiri */
        .cart-actions-left {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Tombol 'Bayar' Utama */
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
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            transition: all 0.2s ease;
        }

        /* Tombol Sekunder (Open Bill & View Open Bills) */
        .pay-button-secondary {
            background-color: var(--secondary);
            color: white;
            padding: 16px 10px;
            font-size: 15px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
        }

        .pay-button-secondary:hover {
            background-color: #5a6268;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        .pay-button:disabled {
            background-color: var(--text-muted);
            cursor: not-allowed;
        }

        .cash-quick-input-buttons .btn-sm {
            flex: 1;
            font-weight: 600;
            background-color: var(--secondary-light);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        /* ======================================================================
                                                                                                                                                                                                                                                                                                                                                                        * MODAL OPEN BILLS
                                                                                                                                                                                                                                                                                                                                                                        * ====================================================================== */
        #open-bills-modal-overlay .modal-content {
            max-width: 700px;
        }

        .open-bill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--secondary-light);
        }

        .open-bill-item div {
            flex-grow: 1;
        }

        .open-bill-item .bill-info span {
            display: block;
            font-size: 14px;
        }

        .open-bill-item .bill-total {
            font-size: 18px;
            font-weight: 700;
            color: var(--danger);
        }


        /* ======================================================================
                                                                                                                                                                                                                                                                                                                                                                        * MODAL SPLIT BILL (Dipertahankan)
                                                                                                                                                                                                                                                                                                                                                                        * ====================================================================== */
        #split-bill-modal-overlay .modal-content {
            max-width: 900px;
        }

        #split-bill-modal-overlay h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--primary);
        }

        #split-bill-modal-overlay .cart-item {
            padding: 8px 0;
            border: none;
            border-bottom: 1px dashed var(--border-color);
            margin-bottom: 0;
            border-radius: 0;
        }

        #split-bill-modal-overlay .summary-row.total {
            border-top: 2px solid var(--border-color);
            padding-top: 10px;
            margin-top: 10px;
        }

        /* KRUSIAL: Atur Z-Index untuk Modal Flow */
        #split-bill-modal-overlay {
            z-index: 1000;
        }

        #payment-modal-overlay {
            z-index: 1010;
            /* Pastikan modal pembayaran selalu di atas split bill */
        }

        /* ... (CSS di bawah ini tidak diubah dari kode sebelumnya, hanya untuk kelengkapan) ... */

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

        .status-modal-icon svg {
            width: 40px;
            height: 40px;
        }

        #status-modal-overlay .modal-content.success {
            border-top: 5px solid var(--success);
        }

        .status-modal-icon-success {
            background-color: #eafbf0;
            color: var(--success);
            display: none;
        }

        #status-modal-overlay .modal-content.error {
            border-top: 5px solid var(--danger);
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

        .modal-body h2 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        #status-modal-message {
            font-size: 16px;
            color: var(--text-muted);
        }

        #status-modal-overlay .modal-footer {
            justify-content: center;
            gap: 10px;
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
            margin-right: 8px;
            font-size: 16px;
        }

        .cart-item-actions button:hover {
            background-color: #e9ecef;
        }

        .cart-item-actions span {
            font-weight: 600;
            font-size: 16px;
            margin: 0 12px;
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
                max-height: 95vh;
            }

            .product-nav {
                width: 100%;
            }

            .nav-tab {
                flex: 1;
            }
        }

        .product-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid var(--border-color);
        }

        /* KRUSIAL: Atur Z-Index untuk Modal Flow */
        #split-bill-modal-overlay {
            z-index: 1000;
        }

        #payment-modal-overlay {
            z-index: 1010;
            /* Pastikan modal pembayaran selalu di atas split bill */
        }
    </style>
@endpush


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
                        <button class="custom-item-btn" onclick="saveCustomItem()">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ... (Konten .cart Anda) ... --}}
        <div class="cart">
            <h2>Pesanan Saat Ini <span id="current-order-id"
                    style="font-size: 14px; font-weight: normal; color: var(--danger);"></span></h2>
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

            {{-- ==== TOMBOL AKSI DISIMPLIFIKASI (Open Bill, View Open Bills, Bayar) ==== --}}
            <div class="cart-actions-bottom">
                <div class="cart-actions-left">
                    <button class="pay-button-secondary" id="open-bill-button" onclick="openBill()">Open Bill</button>
                    <button class="pay-button-secondary" id="view-bills-button" onclick="openOpenBillsModal()">View Open
                        Bills</button>
                </div>
                <button class="pay-button" id="pay-button" onclick="openPaymentModal()">Bayar</button>
            </div>
            {{-- ================================================= --}}
        </div>
    </div>

    {{-- ======================================= --}}
    {{-- ==  HTML MODAL CONFIRM BILL ACTION (BARU) == --}}
    {{-- ======================================= --}}
    <div class="modal-overlay" id="confirm-bill-action-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 400px; text-align: center;">
            <div class="modal-header">
                <h2>Aksi Tagihan</h2>
                <button class="modal-close-btn" onclick="closeConfirmBillActionModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Pilih bagaimana Anda ingin melanjutkan dengan <strong id="bill-action-invoice-num">#INV-XXX</strong>:</p>
            </div>
            <div class="modal-footer" style="justify-content: center; gap: 10px;">
                <button type="button" class="btn btn-primary" id="btn-action-pay-full" style="padding: 12px 20px;">Bayar
                    Penuh</button>
                <button type="button" class="btn btn-secondary" id="btn-action-split" style="padding: 12px 20px;">Split
                    Bill</button>
            </div>
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

                    {{-- TOMBOL UANG CEPAT (BARU) --}}
                    <div class="cash-quick-input-buttons" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="quickCashInput(20000)">Rp
                            20K</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="quickCashInput(50000)">Rp
                            50K</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="quickCashInput(100000)">Rp
                            100K</button>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="quickCashInput('clear')">Clear</button>
                    </div>
                    {{-- AKHIR TOMBOL UANG CEPAT --}}

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

    {{-- ... (Modal View Open Bills Anda) ... --}}
    <div class="modal-overlay" id="open-bills-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Tagihan Terbuka (Open Bills)</h2>
                <button class="modal-close-btn" onclick="closeOpenBillsModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="open-bills-container">
                    <p id="loading-open-bills">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeOpenBillsModal()">Tutup</button>
            </div>
        </div>
    </div>


    {{-- ... (Modal Split Bill Anda) ... --}}
    <div class="modal-overlay" id="split-bill-modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 900px;">
            <div class="modal-header">
                <h2>Split Bill Berdasarkan Menu</h2>
                <button class="modal-close-btn" onclick="closeSplitBillModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div style="display: flex; gap: 20px;">
                    {{-- KIRI: Keranjang Utama (Source) --}}
                    <div style="flex: 1; border-right: 1px solid var(--border-color); padding-right: 15px;">
                        <h3>Keranjang Utama (Sisa: <span id="split-main-total">Rp 0</span>)</h3>
                        <div id="split-main-cart-container" class="cart-items"
                            style="max-height: 40vh; overflow-y: auto;">
                        </div>
                    </div>

                    {{-- KANAN: Keranjang Split (Destination) --}}
                    <div style="flex: 1; padding-left: 15px;">
                        <h3>Keranjang Split (Bayar: <span id="split-split-total">Rp 0</span>)</h3>
                        <div id="split-split-cart-container" class="cart-items"
                            style="max-height: 40vh; overflow-y: auto;">
                        </div>
                        <div style="margin-top: 20px;">
                            <div class="summary-row total">
                                <span>Total Split Bill</span>
                                <span id="split-total-final">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" onclick="closeSplitBillModal()">Batal</button>
                <button type="button" class="modal-save-btn" id="split-confirm-btn" onclick="confirmSplitBill()">
                    Bayar Split Bill (<span id="split-pay-amount">Rp 0</span>)
                </button>
            </div>
        </div>
    </div>

    {{-- ... (Modal Status Anda) ... --}}
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

            <div class="modal-footer" id="status-modal-footer">
                {{-- Tombol Cetak (disembunyikan by default) --}}
                <button type="button" id="status-modal-print-btn" class="btn btn-secondary"
                    style="display: none; background-color: var(--secondary-light); color: var(--text-color);">
                    Cetak Struk
                </button>
                {{-- Tombol OK (ganti ID) --}}
                <button type="button" id="status-modal-ok-btn" class="btn btn-primary">OK</button>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    {{-- =============================================== --}}
    {{-- ==  1. TAMBAHKAN SCRIPT SNAP.JS DARI MIDTRANS  == --}}
    {{-- =============================================== --}}
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>


    <script>
        // Script Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const storageKey = 'sidebarState';
            if (!body.classList.contains('sidebar-closed')) {
                body.classList.add('sidebar-closed');
                localStorage.setItem(storageKey, 'closed');
            }
        });

        // ===============================================
        // == DATA DARI CONTROLLER
        // ===============================================
        const allCategories = @json($categories ?? []);
        const allLibraryProducts = @json($libraryProducts ?? []);
        const allFavoriteProducts = @json($favoriteProducts ?? []);
        const allDiscounts = @json($discounts ?? []);
        const allOrderTypes = @json($orderTypes ?? []);

        // ===============================================
        // == VARIABEL GLOBAL
        // ===============================================
        let cartItems = [];
        let splitCartItems = [];
        let currentEditingProduct = null;
        let currentEditingIndex = -1;
        let currentTax = 0;
        let currentSubtotal = 0;
        let currentTotal = 0;
        let currentPaymentMethod = 'cash';
        let currentCashAmount = 0;
        let currentChange = 0;
        let isLastTransactionSuccess = false;
        let lastSuccessfulOrderId = null;
        let activeOpenBillId = null;
        let currentSelectedOpenBillId = null;
        let currentSelectedOpenBillInvoice = null;
        let remainingCartItems = [];
        let paidItemIds = [];
        let activeShift = null;
        let shouldRedirectToShift = false;

        // ===============================================
        // == FUNGSI UTILITAS
        // ===============================================
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }
        // ===============================================
        // == FUNGSI KONTROL SHIFT
        // ===============================================

        async function checkActiveShift() {
            try {
                // Panggil endpoint untuk mendapatkan shift aktif
                const response = await fetch("{{ route('admin.shift.active') }}");
                const result = await response.json();

                activeShift = result.shift;
                updatePosControls();

            } catch (error) {
                console.error('Gagal memuat status shift aktif:', error);
                activeShift = null;
                updatePosControls();
            }
        }

        function updatePosControls() {
            const payButton = document.getElementById('pay-button');
            const openBillButton = document.getElementById('open-bill-button');
            const viewBillsButton = document.getElementById('view-bills-button');
            const cartEmpty = cartItems.length === 0;

            if (activeShift) {
                // Shift AKTIF: Aktifkan fungsionalitas POS
                payButton.disabled = cartEmpty;
                openBillButton.disabled = cartEmpty;
                viewBillsButton.disabled = false;

                payButton.title = '';
                openBillButton.title = '';
                viewBillsButton.title = '';

            } else {
                // Shift TIDAK AKTIF: Nonaktifkan fungsionalitas transaksi
                const statusMessage = 'Harap Buka Shift Kasir Terlebih Dahulu.';

                payButton.disabled = true;
                openBillButton.disabled = true;
                viewBillsButton.disabled = true;

                payButton.title = statusMessage;
                openBillButton.title = statusMessage;
                viewBillsButton.title = statusMessage;

                // Tampilkan peringatan visual di keranjang
                if (cartEmpty) {
                    const container = document.getElementById('cart-items-container');
                    container.innerHTML = `<p class="cart-empty text-danger">${statusMessage}</p>`;
                }
            }
        }

        function requireActiveShift() {
            // 1. Set flag pengalihan
            shouldRedirectToShift = true;

            // 2. Tampilkan pesan
            showStatusModal('error', 'Akses Ditolak',
                'Harap buka sesi shift kasir Anda terlebih dahulu di halaman manajemen Shift sebelum melakukan transaksi.'
            );

            // Pastikan modal ditampilkan secara eksplisit (redundancy yang aman)
            document.getElementById('status-modal-overlay').style.display = 'flex';
        }
        // ===============================================
        // == FUNGSI TAB NAVIGATION
        // ===============================================
        function showTab(tabName, clickedButton) {
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
            clickedButton.classList.add('active');

            if (tabName !== 'custom') {
                resetCustomItemForm();
            }

            if (tabName === 'favorit') {
                renderFavoriteProducts();
            }
            if (tabName === 'library') {
                // Pastikan tampilan kembali ke kategori jika pindah tab dari favorit/custom
                showCategoryList();
            }
        }

        // ===============================================
        // == FUNGSI CUSTOM ITEM
        // ===============================================
        function resetCustomItemForm() {
            document.getElementById('custom-item-name').value = '';
            document.getElementById('custom-item-price').value = '';
            document.querySelector('.custom-item-btn').innerText = 'Tambah ke Keranjang';
            currentEditingIndex = -1;
        }

        function saveCustomItem() {
            if (!activeShift) {
                requireActiveShift();
                return;
            }

            const nameInput = document.getElementById('custom-item-name');
            const priceInput = document.getElementById('custom-item-price');
            const name = nameInput.value.trim();
            const price = parseFloat(priceInput.value) || 0;

            if (!name || price <= 0) {
                showStatusModal('error', 'Input Tidak Valid', 'Nama item dan harga (lebih dari 0) harus diisi.');
                return;
            }

            if (currentEditingIndex > -1) {
                cartItems[currentEditingIndex].name = name;
                cartItems[currentEditingIndex].finalPrice = price;
            } else {
                const cartItem = {
                    id: 'custom-' + Date.now(),
                    name: name,
                    quantity: 1,
                    note: '',
                    finalPrice: price,
                    isCustom: true
                };
                cartItems.push(cartItem);
            }

            renderCart();
            updateSummary();
            resetCustomItemForm();
        }

        function editCustomItem(index) {
            const item = cartItems[index];
            currentEditingIndex = index;
            const customTabButton = document.querySelector('.nav-tab[onclick*="showTab(\'custom\')"]');
            showTab('custom', customTabButton);

            document.getElementById('custom-item-name').value = item.name;
            document.getElementById('custom-item-price').value = item.finalPrice;
            document.querySelector('.custom-item-btn').innerText = 'Simpan Perubahan';
            document.getElementById('custom-item-name').focus();
        }

        // ===============================================
        // == FUNGSI KATEGORI & PRODUK
        // ===============================================
        function renderCategories() {
            const grid = document.getElementById('category-grid-container');
            grid.innerHTML = '';

            if (allCategories.length === 0) {
                document.getElementById('library-categories-view').style.display = 'none';
                document.getElementById('library-products-view').style.display = 'block';
                document.getElementById('library-category-name').innerText = 'Semua Produk';
                renderProductsInGrid('library-product-grid', allLibraryProducts);
                return;
            }

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
            document.getElementById('library-categories-view').style.display = 'none';
            document.getElementById('library-products-view').style.display = 'block';
            document.getElementById('library-category-name').innerText = categoryName;
            const filteredProducts = allLibraryProducts.filter(p => p.category_id === categoryId);
            renderProductsInGrid('library-product-grid', filteredProducts);
        }

        function showCategoryList() {
            document.getElementById('library-categories-view').style.display = 'block';
            document.getElementById('library-products-view').style.display = 'none';
            renderCategories();
        }

        function renderProductsInGrid(gridId, productArray) {
            const grid = document.getElementById(gridId);
            grid.innerHTML = '';

            if (!productArray || productArray.length === 0) {
                grid.innerHTML = '<p style="color: var(--text-muted); grid-column: 1 / -1;">Tidak ada produk.</p>';
                return;
            }

            productArray.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'product-item';

                let minPrice = 0;
                if (product.variants && product.variants.length > 0) {
                    minPrice = Math.min(...product.variants.map(v => parseFloat(v.price)));
                } else if (product.base_price) {
                    minPrice = parseFloat(product.base_price);
                }

                let imageHtml = '';
                if (product.image_url) {
                    const imageUrl = `{{ asset('storage') }}/${product.image_url}`;
                    imageHtml = `<img src="${imageUrl}" alt="${product.name}" />`;
                } else {
                    imageHtml =
                        `<div style="height: 80px; width: 80px; background: var(--secondary-light); margin: 0 auto 10px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: var(--text-muted);">No Image</div>`;
                }

                // PERBAIKAN: Cek limiting_stock dengan benar
                const limitingStock = parseInt(product.limiting_stock) || 0;
                let stockPriceDisplay = '';
                let isSoldOut = false;
                let stockText = '';

                // Logika Penentuan Teks Stok (Fokus pada Angka Sisa)
                if (isNaN(limitingStock) || limitingStock === 0) {
                    // Stok Habis
                    stockText = `<span style="color: #dc3545; font-weight: 700;">SOLD OUT</span>`;
                    isSoldOut = true;
                } else if (limitingStock < 10 && limitingStock !== 9999) {
                    // Stok Kritis (1-9)
                    stockText = `<span style="color: orange; font-weight: 600;">Sisa: ${limitingStock} unit</span>`;
                    productElement.style.border = '2px solid orange';
                } else if (limitingStock >= 9999) {
                    // Stok tidak terhitung/unlimited (Limit di Controller 9999)
                    stockText = `<span style="color: var(--text-muted);">Stock > 9999</span>`;
                } else {
                    // Stok Cukup (10 - 9998)
                    // Tampilkan QTY-nya secara eksplisit
                    stockText = `<span style="color: #28a745;">Sisa: ${limitingStock} unit</span>`;
                }

                // KOMBINASI: Harga di atas, Stok di bawah
                stockPriceDisplay = `
                    <div class="product-price" style="font-weight: 600; color: var(--text-color);">
                        Mulai ${formatRupiah(minPrice)}
                    </div>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                        ${stockText}
                    </div>
                `;

                productElement.innerHTML =
                    `${imageHtml}<div class="product-name">${product.name}</div>${stockPriceDisplay}`;

                // Atur onclick berdasarkan status stok
                if (isSoldOut) {
                    productElement.onclick = () => {
                        showStatusModal('error', 'Stok Habis', 'Bahan baku untuk produk ini tidak mencukupi.');
                    };
                    productElement.style.opacity = 0.5;
                    productElement.style.cursor = 'not-allowed';
                } else {
                    productElement.onclick = () => openItemModal(product); // Pasang kembali onclick normal
                }

                grid.appendChild(productElement);
            });
        }

        function renderFavoriteProducts() {
            renderProductsInGrid('favorit-product-grid', allFavoriteProducts);
        }

        // ===============================================
        // == FUNGSI KERANJANG
        // ===============================================
        function renderCart() {
            const cartContainer = document.getElementById('cart-items-container');
            const orderIdDisplay = document.getElementById('current-order-id');
            cartContainer.innerHTML = '';

            if (activeOpenBillId) {
                orderIdDisplay.innerText = `(Order ID: #${activeOpenBillId})`;
            } else {
                orderIdDisplay.innerText = '';
            }

            if (cartItems.length === 0) {
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
                    <button class="remove-btn" onclick="editCustomItem(${index})" style="background-color: var(--primary-light); color: var(--primary); border-color: var(--primary); margin-left: 12px; margin-right: 8px; width: auto; padding: 0 10px;">Edit</button>
                    <button class="remove-btn" onclick="removeCartItem(${index})" style="margin-left: 0;">Hapus</button>
                </div>`;
                } else {
                    let addonsHtml = '<ul>';
                    if (item.selectedAddons && item.selectedAddons.length > 0) {
                        item.selectedAddons.forEach(addon => {
                            addonsHtml += `<li>${addon.name} (+${formatRupiah(addon.price)})</li>`;
                        });
                    } else {
                        addonsHtml += '<li>-</li>';
                    }
                    addonsHtml += '</ul>';

                    let discountHtml = '';
                    if (item.discount && item.discount.id > 1) {
                        discountHtml = `<div class="cart-item-discount">Diskon: ${item.discount.name}</div>`;
                    }

                    let noteHtml = '';
                    if (item.note && item.note.trim() !== '') {
                        noteHtml = `<div class="cart-item-note">Catatan: ${item.note}</div>`;
                    }

                    let orderTypeHtml =
                        `<div class="cart-item-ordertype">${item.selectedOrderType ? item.selectedOrderType.name : 'Dine In'}</div>`;

                    cartItemElement.innerHTML = `
                ${orderTypeHtml}
                <div class="cart-item-header"><span class="cart-item-name">${item.name} (${item.selectedVariant ? item.selectedVariant.name : 'N/A'})</span><span class="cart-item-price">${formatRupiah(item.finalPrice)}</span></div>
                <div class="cart-item-details"><span class="detail-label">Add-ons:</span>${addonsHtml}${discountHtml}${noteHtml}</div>
                <div class="cart-item-actions">
                    <button onclick="updateCartQuantity(${index}, -1)">-</button><span>${item.quantity}</span><button onclick="updateCartQuantity(${index}, 1)">+</button>
                    <button class="remove-btn" onclick="editProductItem(${index})" style="background-color: var(--primary-light); color: var(--primary); border-color: var(--primary); margin-left: auto; margin-right: 8px; width: auto; padding: 0 10px;">Edit</button>
                    <button class="remove-btn" onclick="removeCartItem(${index})" style="margin-left: 0;">Hapus</button>
                </div>`;
                }
                cartContainer.appendChild(cartItemElement);
            });
        }

        function updateCartQuantity(index, change) {
            cartItems[index].quantity += change;
            if (cartItems[index].quantity <= 0) {
                cartItems.splice(index, 1);
            }
            renderCart();
            updateSummary();
        }

        function removeCartItem(index) {
            cartItems.splice(index, 1);
            renderCart();
            updateSummary();
            resetCustomItemForm();
        }

        function updateSummary() {
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

            const isDisabled = cartItems.length === 0;
            const payButton = document.getElementById('pay-button');

            if (activeOpenBillId) {
                payButton.innerText = 'Selesaikan Tagihan';
            } else {
                payButton.innerText = 'Bayar';
            }

            // payButton.disabled = isDisabled;
            // document.getElementById('open-bill-button').disabled = isDisabled;
            // document.getElementById('view-bills-button').disabled = false;
            updatePosControls();
        }

        function editProductItem(index) {
            const itemToEdit = cartItems[index];
            const allProducts = [...allLibraryProducts, ...allFavoriteProducts];
            // Temukan produk berdasarkan ID
            const originalProduct = allProducts.find(p => p.id == itemToEdit
                .product_id); // Gunakan product_id dari item cart

            if (!originalProduct) {
                showStatusModal('error', 'Gagal Edit', 'Data produk asli tidak ditemukan.');
                return;
            }

            openItemModal(originalProduct, index);
        }

        // ===============================================
        // == FUNGSI MODAL ITEM
        // ===============================================
        function openItemModal(product, editIndex = -1) {
            // KRUSIAL: Blokir jika shift tidak aktif
            if (!activeShift) {
                requireActiveShift();
                return;
            }
            currentEditingProduct = product;
            currentEditingIndex = editIndex;

            document.getElementById('modal-item-name').innerText = product.name;

            // Render Variants
            const variantsContainer = document.getElementById('modal-item-variants');
            variantsContainer.innerHTML = '';
            product.variants.forEach((variant, index) => {
                let isChecked = index === 0;
                if (editIndex > -1 && cartItems[editIndex].selectedVariant && cartItems[editIndex].selectedVariant
                    .name === variant.name) {
                    isChecked = true;
                }
                const variantId = `variant-${product.id}-${index}`;
                variantsContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${variantId}" name="variant-${product.id}" value="${index}" ${isChecked ? 'checked' : ''} onchange="updateModalPrice()"><label class="option-item" for="${variantId}"><span class="option-name">${variant.name}</span><span class="option-price">${formatRupiah(variant.price)}</span></label></div>`;
            });
            // Jika tidak ada yang terpilih, pilih varian pertama secara default
            if (product.variants.length > 0 && !document.querySelector(`input[name="variant-${product.id}"]:checked`)) {
                document.querySelector(`input[name="variant-${product.id}"][value="0"]`).checked = true;
            }

            // Render Addons
            const addonsContainer = document.getElementById('modal-item-addons');
            addonsContainer.innerHTML = '';
            if (!product.addons || product.addons.length === 0) {
                addonsContainer.innerHTML =
                    '<p style="font-size: 14px; color: var(--text-muted);">Tidak ada add-on untuk item ini.</p>';
            } else {
                product.addons.forEach((addon, index) => {
                    let isChecked = false;
                    if (editIndex > -1) {
                        // Periksa berdasarkan ID Addon
                        isChecked = cartItems[editIndex].selectedAddons.some(a => a.id === addon.id);
                    }
                    const addonId = `addon-${product.id}-${index}`;
                    addonsContainer.innerHTML +=
                        `<div class="option-item-wrapper"><input type="checkbox" id="${addonId}" name="addon-${product.id}" value="${index}" ${isChecked ? 'checked' : ''} onchange="updateModalPrice()"><label class="option-item" for="${addonId}"><span class="option-name">${addon.name}</span><span class="option-price-addon">+ ${formatRupiah(addon.price)}</span></label></div>`;
                });
            }

            // Render Order Types
            const orderTypesContainer = document.getElementById('modal-item-ordertypes');
            orderTypesContainer.innerHTML = '';
            allOrderTypes.forEach(type => {
                let isChecked = type.id === 1;
                if (editIndex > -1 && cartItems[editIndex].selectedOrderType && cartItems[editIndex]
                    .selectedOrderType.id === type.id) {
                    isChecked = true;
                }
                const typeId = `ordertype-${type.id}`;
                let priceText = '';
                if (type.type === 'percentage') priceText = `+ ${parseFloat(type.value) * 100}%`;
                else if (parseFloat(type.value) > 0) priceText = `+ ${formatRupiah(type.value)}`;
                orderTypesContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${typeId}" name="ordertype" value="${type.id}" ${isChecked ? 'checked' : ''} onchange="updateModalPrice()"><label class="option-item" for="${typeId}"><span class="option-name">${type.name}</span><span class="option-price-ordertype">${priceText}</span></label></div>`;
            });

            // Render Discounts
            const discountsContainer = document.getElementById('modal-item-discounts');
            discountsContainer.innerHTML = '';
            allDiscounts.forEach(discount => {
                let isChecked = discount.id === 1;
                if (editIndex > -1 && cartItems[editIndex].discount && cartItems[editIndex].discount.id === discount
                    .id) {
                    isChecked = true;
                }
                const discountId = `discount-${discount.id}`;
                let priceText = '';
                if (discount.type === 'percentage') priceText = `${parseFloat(discount.value) * 100}%`;
                else if (parseFloat(discount.value) > 0) priceText = `-${formatRupiah(discount.value)}`;
                discountsContainer.innerHTML +=
                    `<div class="option-item-wrapper"><input type="radio" id="${discountId}" name="discount" value="${discount.id}" ${isChecked ? 'checked' : ''} onchange="updateModalPrice()"><label class="option-item" for="${discountId}"><span class="option-name">${discount.name}</span><span class="option-price-discount">${priceText}</span></label></div>`;
            });

            // Set quantity and note
            if (editIndex > -1) {
                document.getElementById('modal-item-quantity').value = cartItems[editIndex].quantity;
                document.getElementById('modal-item-note').value = cartItems[editIndex].note || '';
            } else {
                document.getElementById('modal-item-quantity').value = 1;
                document.getElementById('modal-item-note').value = '';
            }

            updateModalPrice();
            document.getElementById('item-modal-overlay').style.display = 'flex';
        }

        function closeItemModal() {
            document.getElementById('item-modal-overlay').style.display = 'none';
            currentEditingProduct = null;
            currentEditingIndex = -1;
        }

        function updateModalPrice() {
            if (!currentEditingProduct) return;

            // Pastikan varian terpilih ada
            const selectedVariantRadio = document.querySelector(
                `input[name="variant-${currentEditingProduct.id}"]:checked`);
            if (!selectedVariantRadio) {
                document.getElementById('modal-item-price').innerText = formatRupiah(0);
                return;
            }
            const selectedVariantIndex = selectedVariantRadio.value;
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
            const selectedVariantRadio = document.querySelector(
                `input[name="variant-${currentEditingProduct.id}"]:checked`);
            if (!selectedVariantRadio) {
                showStatusModal('error', 'Varian Belum Dipilih', 'Anda harus memilih satu varian produk.');
                return;
            }

            const variantIndex = selectedVariantRadio.value;
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

            // === Hitung Harga Final Per Item ===
            let basePrice = parseFloat(selectedVariant.price); // Harga Varian

            // Tambah Addons
            selectedAddons.forEach(addon => {
                basePrice += parseFloat(addon.price);
            });

            // Tambah Order Type Fee (Markup)
            let priceAfterMarkup = basePrice;
            if (selectedOrderType.type === 'percentage') {
                priceAfterMarkup = basePrice * (1 + parseFloat(selectedOrderType.value));
            } else {
                priceAfterMarkup = basePrice + parseFloat(selectedOrderType.value);
            }

            // Kurangi Diskon
            let discountAmount = 0;
            if (selectedDiscount.type === 'percentage') {
                discountAmount = priceAfterMarkup * parseFloat(selectedDiscount.value);
            } else {
                discountAmount = parseFloat(selectedDiscount.value);
            }
            const finalPricePerItem = priceAfterMarkup - discountAmount < 0 ? 0 : priceAfterMarkup - discountAmount;
            // ===================================

            const cartItem = {
                // KRUSIAL: Jika ini item baru, id adalah ID produk. Jika edit item OpenBill, id adalah ID OrderItem.
                // Saat menyimpan item baru, id adalah ID Produk.
                id: currentEditingProduct.id,
                product_id: currentEditingProduct.id, // Simpan ID produk asli
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

            // Jika kita sedang mengedit Order Item dari Open Bill:
            if (currentEditingIndex > -1 && activeOpenBillId) {
                // Pertahankan ID Order Item lama (yang sudah ada di cartItems[currentEditingIndex].id)
                cartItem.id = cartItems[currentEditingIndex].id;
            }

            if (currentEditingIndex > -1) {
                cartItems[currentEditingIndex] = cartItem;
            } else {
                cartItems.push(cartItem);
            }

            renderCart();
            updateSummary();
            closeItemModal();
        }

        // ===============================================
        // == FUNGSI OPEN BILL
        // ===============================================
        async function openBill() {

            if (!activeShift) {
                requireActiveShift();
                return;
            }
            if (cartItems.length === 0) {
                showStatusModal('error', 'Keranjang Kosong', 'Tidak ada item untuk disimpan sebagai Open Bill.');
                return;
            }

            const openBillButton = document.getElementById('open-bill-button');
            openBillButton.disabled = true;
            openBillButton.innerText = 'Menyimpan...';

            activeOpenBillId = null;

            const dataToSend = {
                cartItems: cartItems,
                subtotal: currentSubtotal,
                tax: currentTax,
                total: currentTotal,
                paymentMethod: 'openbill',
                cashReceived: null,
                cashChange: null,
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
                    credentials: "include",
                    body: JSON.stringify(dataToSend)
                });

                const result = await response.json();

                if (!response.ok || result.status !== 'openbill') {
                    throw new Error(result.error || result.message || 'Gagal menyimpan Open Bill.');
                }

                isLastTransactionSuccess = false;
                lastSuccessfulOrderId = result.order_id;
                showStatusModal('pending', 'Open Bill Berhasil', 'Order ID: ' + result.order_id +
                    ' disimpan sebagai tagihan terbuka.');

                cartItems = [];
                activeOpenBillId = null;
                renderCart();
                updateSummary();

            } catch (error) {
                console.error('Error saving Open Bill:', error);
                showStatusModal('error', 'Gagal Open Bill', error.message);
            } finally {
                openBillButton.disabled = false;
                openBillButton.innerText = 'Open Bill';
            }
        }

        function openOpenBillsModal() {

            if (!activeShift) {
                requireActiveShift();
                return;
            }

            document.getElementById('open-bills-modal-overlay').style.display = 'flex';
            loadOpenBills();
        }

        function closeOpenBillsModal() {
            document.getElementById('open-bills-modal-overlay').style.display = 'none';
        }

        async function loadOpenBills() {
            const container = document.getElementById('open-bills-container');
            container.innerHTML = '<p id="loading-open-bills">Memuat data...</p>';

            try {
                const response = await fetch("{{ route('admin.pos.open_bills') }}");
                const bills = await response.json();

                container.innerHTML = '';

                if (bills.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted">Tidak ada tagihan terbuka saat ini.</p>';
                    return;
                }

                bills.forEach(bill => {
                    const date = new Date(bill.created_at).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    container.innerHTML += `
                <div class="open-bill-item">
                    <div class="bill-info">
                        <span style="font-weight: 600;">${bill.invoice_number}</span>
                        <span style="color: var(--text-muted);">${date}</span>
                    </div>
                    <div class="bill-total">${formatRupiah(bill.total)}</div>
                    <button class="btn btn-primary btn-sm" style="margin-left: 15px;" onclick="selectBillAction(${bill.id}, '${bill.invoice_number}')">Pilih</button>
                </div>
            `;
                });

            } catch (error) {
                console.error('Error loading open bills:', error);
                container.innerHTML =
                    '<p class="text-center text-danger">Gagal memuat tagihan. Cek koneksi server.</p>';
            }
        }

        function selectBillAction(orderId, invoiceNumber) {
            const validOrderId = parseInt(orderId);

            currentSelectedOpenBillId = validOrderId;
            currentSelectedOpenBillInvoice = invoiceNumber;
            document.getElementById('bill-action-invoice-num').innerText = `#${invoiceNumber}`;
            document.getElementById('confirm-bill-action-modal-overlay').style.display = 'flex';
            closeOpenBillsModal();

            const btnPayFull = document.getElementById('btn-action-pay-full');
            const btnSplit = document.getElementById('btn-action-split');
            btnPayFull.onclick = null;
            btnSplit.onclick = null;

            if (!validOrderId || isNaN(validOrderId)) {
                showStatusModal('error', 'Gagal Memuat', 'ID tagihan yang dipilih tidak valid. Coba refresh.');
                return;
            }

            btnPayFull.onclick = () => {
                closeConfirmBillActionModal();
                loadBillToCart(validOrderId).then(() => {
                    openPaymentModal();
                }).catch(() => {});
            };

            btnSplit.onclick = () => {
                closeConfirmBillActionModal();
                loadBillToCart(validOrderId).then(() => {
                    openSplitBillModal();
                }).catch(() => {});
            };
        }

        async function loadBillToCart(orderId) {
            if (cartItems.length > 0 && activeOpenBillId === null) {
                const confirmClear = confirm(
                    "Keranjang saat ini masih berisi item. Apakah Anda yakin ingin memuat tagihan ini dan menghapus isi keranjang?"
                );
                if (!confirmClear) return Promise.reject(false);
            }

            if (!orderId || isNaN(orderId)) {
                return Promise.reject(new Error("ID Order tidak valid (null/NaN)."));
            }
            activeOpenBillId = orderId;

            try {
                // Gunakan route helper dengan string replacement
                const urlTemplate = "{{ route('admin.pos.load_bill', ['order' => 'ID_PLACEHOLDER'], false) }}";
                const url = urlTemplate.replace('ID_PLACEHOLDER', orderId);

                if (url.includes('ID_PLACEHOLDER')) {
                    throw new Error("Gagal membentuk URL: Placeholder masih ada.");
                }

                const response = await fetch(url);

                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    const text = await response.text();
                    console.error('Server returned HTML/Non-JSON response:', text);
                    if (response.status === 404) {
                        throw new Error(`Endpoint tidak ditemukan. Cek Route.`);
                    }
                    if (response.status === 403) {
                        throw new Error(`Akses Ditolak (403). Cek Middleware/Peran Pengguna.`);
                    }
                    throw new Error(`Server Error (${response.status}). Cek Log Laravel.`);
                }

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || result.message || 'Gagal memuat tagihan.');
                }

                cartItems = result.cartItems;
                currentSubtotal = result.subtotal;
                currentTax = result.tax;
                currentTotal = result.total;
                activeOpenBillId = result.order_id;

                renderCart();
                updateSummary();
                return Promise.resolve(true);
            } catch (error) {
                console.error('Error loading bill to cart:', error);
                showStatusModal('error', 'Gagal Memuat', error.message);
                activeOpenBillId = null;
                return Promise.reject(false);
            }
        }

        // ===============================================
        // == FUNGSI SPLIT BILL
        // ===============================================
        function openSplitBillModal() {
            if (cartItems.length === 0) {
                // Ini seharusnya tidak terjadi jika loadBillToCart berhasil
                showStatusModal('error', 'Keranjang Kosong', 'Tidak ada item untuk dibagi.');
                return;
            }

            if (!activeOpenBillId) {
                // Ini seharusnya tidak terjadi setelah loadBillToCart
                showStatusModal('error', 'Aksi Tidak Valid',
                    'Split Bill hanya dapat dilakukan pada Tagihan Terbuka (Open Bill). Silakan pilih tagihan dari "View Open Bills" terlebih dahulu.'
                );
                return;
            }

            splitCartItems = [];
            document.getElementById('split-bill-modal-overlay').style.display = 'flex';
            renderSplitCart();
        }

        function closeSplitBillModal() {
            if (splitCartItems.length > 0) {
                cartItems.push(...splitCartItems);
                splitCartItems = [];
                renderCart();
                updateSummary();
            }
            document.getElementById('split-bill-modal-overlay').style.display = 'none';
        }

        function closeConfirmBillActionModal() {
            document.getElementById('confirm-bill-action-modal-overlay').style.display = 'none';
            currentSelectedOpenBillId = null;
            currentSelectedOpenBillInvoice = null;
        }

        function renderSplitCart() {
            const mainContainer = document.getElementById('split-main-cart-container');
            const splitContainer = document.getElementById('split-split-cart-container');
            mainContainer.innerHTML = '';
            splitContainer.innerHTML = '';

            let mainSubtotal = cartItems.reduce((sum, item) => sum + item.finalPrice * item.quantity, 0);
            const mainTotalWithTax = mainSubtotal * 1.1;

            let splitSubtotal = splitCartItems.reduce((sum, item) => sum + item.finalPrice * item.quantity, 0);
            const splitTotalWithTax = splitSubtotal * 1.1;

            cartItems.forEach((item, index) => {
                const itemHtml = renderSplitItem(item, index, 'main');
                mainContainer.innerHTML += itemHtml;
            });

            splitCartItems.forEach((item, index) => {
                const itemHtml = renderSplitItem(item, index, 'split');
                splitContainer.innerHTML += itemHtml;
            });

            document.getElementById('split-main-total').innerText = formatRupiah(mainTotalWithTax);
            document.getElementById('split-split-total').innerText = formatRupiah(splitSubtotal);
            document.getElementById('split-total-final').innerText = formatRupiah(splitTotalWithTax);

            document.getElementById('split-confirm-btn').disabled = splitSubtotal === 0;
            document.getElementById('split-pay-amount').innerText = formatRupiah(splitTotalWithTax);
        }

        function renderSplitItem(item, index, type) {
            const itemName = item.isCustom ? item.name :
                `${item.name} (${item.selectedVariant ? item.selectedVariant.name : 'N/A'})`;
            const isMain = type === 'main';
            const btnText = isMain ? '→' : '←';
            const btnAction = isMain ? `moveItemToSplit(${index})` : `moveItemToMain(${index})`;

            return `
        <div class="cart-item" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="flex-grow: 1;">
                <span class="cart-item-name">${item.quantity}x ${itemName}</span>
                <span class="cart-item-price" style="margin-left: 10px;">${formatRupiah(item.finalPrice * item.quantity)}</span>
            </div>
            <button class="btn btn-sm" style="background-color: var(--primary); color: white; border-radius: 4px; padding: 5px 10px;" 
                    onclick="${btnAction}">${btnText}</button>
        </div>
    `;
        }

        function moveItemToSplit(mainIndex) {
            const item = cartItems.splice(mainIndex, 1)[0];
            splitCartItems.push(item);
            renderSplitCart();
        }

        function moveItemToMain(splitIndex) {
            const item = splitCartItems.splice(splitIndex, 1)[0];
            cartItems.push(item);
            renderSplitCart();
        }

        function confirmSplitBill() {
            if (splitCartItems.length === 0) {
                showStatusModal('error', 'Keranjang Split Kosong', 'Pilih item yang ingin dibayar pada Split Cart.');
                return;
            }

            const splitSubtotalBeforeTax = splitCartItems.reduce((sum, item) => sum + item.finalPrice * item.quantity,
                0);
            const splitTaxRate = 0.10;
            const splitTax = splitSubtotalBeforeTax * splitTaxRate;
            const splitTotal = splitSubtotalBeforeTax + splitTax;

            // 1. Simpan Item yang TERSISA dan ID item yang dibayar
            const remainingCartItemsTemp = cartItems;
            const itemsToPay = splitCartItems;
            const paidItemIdsTemp = itemsToPay.map(item => item.id); // ID Order Item lama

            // 2. Set variabel global untuk TRANSAKSI SPLIT BILL
            currentSubtotal = splitSubtotalBeforeTax;
            currentTax = splitTax;
            currentTotal = splitTotal;

            // 3. Atur ulang cartItems untuk transaksi baru, dan reset splitCartItems
            cartItems = itemsToPay;
            splitCartItems = [];

            // 4. Buka Modal Pembayaran dengan flag isSplit=true
            openPaymentModal(true, remainingCartItemsTemp, paidItemIdsTemp);
        }

        // ===============================================
        // == FUNGSI PAYMENT MODAL
        // ===============================================
        function openPaymentModal(isSplit = false, remainingItems = [], itemIds = []) {
            if (!activeShift) {
                requireActiveShift();
                return;
            }

            if (cartItems.length === 0) {
                showStatusModal('error', 'Keranjang Kosong', 'Anda belum menambahkan item apapun ke keranjang.');
                return;
            }

            const payButton = document.getElementById('payment-submit-btn');
            payButton.dataset.isSplit = isSplit;

            // Set global state dari parameter
            remainingCartItems = remainingItems;
            paidItemIds = itemIds;

            const paymentTotalEl = document.getElementById('payment-modal-total');
            paymentTotalEl.innerText = formatRupiah(currentTotal);

            currentPaymentMethod = 'cash';
            document.getElementById('payment-cash-amount').value = '';
            document.getElementById('payment-cash-change').innerText = 'Rp 0';
            document.getElementById('payment-cash-change').classList.remove('negative');
            document.getElementById('cash-payment-section').style.display = 'block';
            document.getElementById('pay-btn-cash').classList.add('active');
            document.getElementById('pay-btn-gateway').classList.remove('active');

            document.getElementById('payment-submit-btn').disabled = true;

            document.getElementById('payment-modal-overlay').style.display = 'flex';

            calculateChange();
        }

        function closePaymentModal() {
            document.getElementById('payment-modal-overlay').style.display = 'none';
        }

        function quickCashInput(value) {
            const input = document.getElementById('payment-cash-amount');

            if (value === 'clear') {
                input.value = '';
            } else {
                input.value = value;
            }
            calculateChange();
        }

        function calculateChange() {
            const cashAmount = parseFloat(document.getElementById('payment-cash-amount').value) || 0;
            currentCashAmount = cashAmount;

            if (cashAmount <= 0) {
                document.getElementById('payment-cash-change').innerText = 'Rp 0';
                document.getElementById('payment-cash-change').classList.remove('negative');
                document.getElementById('payment-submit-btn').disabled = true;
                return;
            }

            const change = cashAmount - currentTotal;
            currentChange = change;

            if (change < 0) {
                document.getElementById('payment-cash-change').innerText = `Uang Kurang: ${formatRupiah(change)}`;
                document.getElementById('payment-cash-change').classList.add('negative');
                document.getElementById('payment-submit-btn').disabled = true;
            } else {
                document.getElementById('payment-cash-change').innerText = formatRupiah(change);
                document.getElementById('payment-cash-change').classList.remove('negative');
                document.getElementById('payment-submit-btn').disabled = false;
            }
        }

        async function submitPayment() {
            const payButton = document.getElementById('payment-submit-btn');
            payButton.disabled = true;
            payButton.innerText = 'Memproses...';
            isLastTransactionSuccess = false;
            lastSuccessfulOrderId = null;

            const isSplit = payButton.dataset.isSplit === 'true';

            // === 1. Tentukan ENDPOINT dan LOGIKA ===
            let endpointUrl;
            let isUpdatingOldBill = false;
            const oldOrderId = activeOpenBillId;

            if (oldOrderId && !isSplit) {
                // Logika: BAYAR PENUH (Update Order Lama)
                endpointUrl = `{{ route('admin.pos.complete_open_bill', ['order' => 'ORDER_ID_PLACEHOLDER'], false) }}`
                    .replace('ORDER_ID_PLACEHOLDER', oldOrderId);
                isUpdatingOldBill = true;
            } else {
                // Logika: TRANSAKSI NORMAL atau SPLIT BILL (membuat Order Baru)
                endpointUrl = "{{ route('admin.pos.store') }}";
            }

            const dataToSend = {
                cartItems: cartItems,
                subtotal: currentSubtotal,
                tax: currentTax,
                total: currentTotal,
                paymentMethod: currentPaymentMethod,
                cashReceived: (currentPaymentMethod === 'cash') ? currentCashAmount : null,
                cashChange: (currentPaymentMethod === 'cash') ? currentChange : null,
                isSplit: isSplit
            };

            let fullPayDataToSend = {};
            if (isUpdatingOldBill) {
                fullPayDataToSend = {
                    paymentMethod: dataToSend.paymentMethod,
                    cashReceived: dataToSend.cashReceived,
                    cashChange: dataToSend.cashChange
                };
            }

            try {
                const response = await fetch(endpointUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    },
                    credentials: "include",
                    body: JSON.stringify(isUpdatingOldBill ? fullPayDataToSend : dataToSend)
                });

                const result = await response.json();
                if (!response.ok) {
                    if (response.headers.get("content-type") && !response.headers.get("content-type").includes(
                            "application/json")) {
                        throw new Error(`Server Error (${response.status}). Cek Log.`);
                    }
                    throw new Error(result.error || result.message || 'Terjadi kesalahan server');
                }

                // === LOGIKA RESPONSE ===

                // 1. CEK PENDING / SNAP TOKEN DULU (Untuk Kasus Gateway: Split maupun Full)
                if (result.status === 'pending' && result.snap_token) {

                    isLastTransactionSuccess = true;
                    lastSuccessfulOrderId = result.order_id;
                    closePaymentModal(); // Tutup modal input pembayaran

                    // Panggil Midtrans Snap
                    snap.pay(result.snap_token, {
                        onSuccess: function(trxResult) {
                            showStatusModal('success', 'Pembayaran Berhasil',
                            'Transaksi berhasil dibayar.');
                            // Bersihkan cart setelah sukses
                            activeOpenBillId = null;
                            cartItems = [];
                            renderCart();
                            updateSummary();
                        },
                        onPending: function(trxResult) {
                            showStatusModal('pending', 'Menunggu Pembayaran',
                                'Silakan selesaikan pembayaran Anda.');
                        },
                        onError: function(trxResult) {
                            showStatusModal('error', 'Pembayaran Gagal',
                                'Terjadi kesalahan saat pembayaran.');
                        },
                        onClose: function() {
                            // Opsional: Beri tahu user mereka menutup popup
                        }
                    });
                    return; // Hentikan eksekusi di sini, biarkan Snap JS bekerja
                }

                // 2. JIKA CASH / SUKSES LANGSUNG
                if (isUpdatingOldBill) {
                    // KASUS 1: BAYAR PENUH CASH (Order Lama Selesai)
                    isLastTransactionSuccess = true;
                    lastSuccessfulOrderId = oldOrderId;

                    closePaymentModal();
                    showStatusModal('success', 'Tagihan Selesai',
                        `Order ID: ${oldOrderId} berhasil diselesaikan dan ditutup.`);

                    activeOpenBillId = null;
                    cartItems = [];
                    renderCart();
                    updateSummary();

                } else if (result.status === 'completed') {
                    // KASUS 2: TRANSAKSI NORMAL / SPLIT CASH (Order Baru)
                    isLastTransactionSuccess = true;
                    lastSuccessfulOrderId = result.order_id;

                    if (oldOrderId && isSplit) {
                        // SUB-KASUS: SPLIT BILL CASH
                        const newOrderId = result.order_id;
                        const idsToMarkPaid = paidItemIds;

                        // Update Order Lama (Hapus item yang sudah dibayar)
                        const updateUrl =
                            `{{ route('admin.pos.update_bill_status', ['order' => 'ORDER_ID_PLACEHOLDER'], false) }}`
                            .replace('ORDER_ID_PLACEHOLDER', oldOrderId);

                        const updateResponse = await fetch(updateUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                            credentials: "include",
                            body: JSON.stringify({
                                isSplit: true,
                                paidItemIds: idsToMarkPaid,
                                new_order_id: newOrderId
                            })
                        });

                        const updateResult = await updateResponse.json();
                        closePaymentModal();

                        if (updateResult.old_order_status === 'completed') {
                            showStatusModal('success', 'Tagihan Selesai',
                                `Order utama ID: ${oldOrderId} telah ditutup. Pembayaran Split ID: ${newOrderId}.`);
                            document.getElementById('split-bill-modal-overlay').style.display = 'none';
                            activeOpenBillId = null;
                            cartItems = [];
                            renderCart();
                            updateSummary();
                        } else {
                            // Reload sisa tagihan
                            await loadBillToCart(oldOrderId);
                            openSplitBillModal();
                            showStatusModal('success', 'Pembayaran Split Berhasil',
                                `Pembayaran ID: ${newOrderId} berhasil. Sisa tagihan: ${formatRupiah(updateResult.new_total)} dimuat.`
                                );
                        }
                        remainingCartItems = [];
                        paidItemIds = [];

                    } else {
                        // Transaksi Biasa Cash
                        closePaymentModal();
                        showStatusModal('success', 'Pesanan Berhasil', 'Order ID: ' + result.order_id +
                            ' telah disimpan.');
                        activeOpenBillId = null;
                        cartItems = [];
                        renderCart();
                        updateSummary();
                    }
                }

            } catch (error) {
                console.error('Error submitting payment:', error);
                isLastTransactionSuccess = false;
                lastSuccessfulOrderId = null;

                if (isSplit) {
                    splitCartItems = cartItems;
                    if (oldOrderId) loadBillToCart(oldOrderId);
                }
                showStatusModal('error', 'Gagal Menyimpan', error.message);

            } finally {
                payButton.disabled = false;
                payButton.innerText = 'Proses Pesanan';
            }
        }

        // ... (Fungsi showStatusModal, closeStatusModal, printReceipt, dan Event Listeners lainnya)

        function showStatusModal(type, title, message) {
            const statusModal = document.getElementById('status-modal-overlay');
            const statusModalContent = statusModal.querySelector('.modal-content');
            const statusModalTitle = document.getElementById('status-modal-title');
            const statusModalMessage = document.getElementById('status-modal-message');
            const statusIconSuccess = statusModal.querySelector('.status-modal-icon-success');
            const statusIconDanger = statusModal.querySelector('.status-modal-icon-danger');
            const statusPrintBtn = document.getElementById('status-modal-print-btn');

            statusModalTitle.innerText = title;
            statusModalMessage.innerText = message;
            statusPrintBtn.style.display = 'none';
            statusPrintBtn.onclick = null;

            if (type === 'success' || type === 'pending') {
                statusModalContent.classList.remove('error');
                statusModalContent.classList.add('success');
                statusIconSuccess.style.display = 'flex';
                statusIconDanger.style.display = 'none';

                if (lastSuccessfulOrderId) {
                    statusPrintBtn.style.display = 'block';
                    statusPrintBtn.onclick = () => printReceipt(lastSuccessfulOrderId);
                }
            } else {
                statusModalContent.classList.remove('success');
                statusModalContent.classList.add('error');
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
                window.location.href = "{{ route('admin.shift.index') }}"; // Ganti dengan route yang benar
                return;
            }

            if (isLastTransactionSuccess) {
                closePaymentModal();
                isLastTransactionSuccess = false;
                lastSuccessfulOrderId = null;
            }
        }

        function printReceipt(orderId) {
            const url = `{{ url('admin/orders') }}/${orderId}/receipt`;
            window.open(url, '_blank');
        }

        document.getElementById('pay-btn-cash').addEventListener('click', () => {
            currentPaymentMethod = 'cash';
            document.getElementById('cash-payment-section').style.display = 'block';
            document.getElementById('pay-btn-cash').classList.add('active');
            document.getElementById('pay-btn-gateway').classList.remove('active');
            calculateChange();
        });

        document.getElementById('pay-btn-gateway').addEventListener('click', () => {
            currentPaymentMethod = 'gateway';
            document.getElementById('cash-payment-section').style.display = 'none';
            document.getElementById('pay-btn-cash').classList.remove('active');
            document.getElementById('pay-btn-gateway').classList.add('active');
            document.getElementById('payment-submit-btn').disabled = false;
        });

        document.getElementById('payment-cash-amount').addEventListener('input', calculateChange);
        document.getElementById('status-modal-ok-btn').addEventListener('click', closeStatusModal);

        window.onload = () => {
            renderFavoriteProducts();
            renderCategories();
            renderCart();
            updateSummary();
            checkActiveShift();

            document.getElementById('item-modal-overlay').onclick = closeItemModal;
            document.getElementById('payment-modal-overlay').onclick = closePaymentModal;
            document.getElementById('status-modal-overlay').onclick = closeStatusModal;
        }
    </script>
@endpush
