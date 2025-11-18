<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Menu Meja {{ $tableNumber }} | Takato Self-Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #2979FF;
            --primary-light: #e6f0ff;
            --success: #00C853;
            --warning: #FF9800;
            --danger: #FF1744;
            --body-bg: #f5f5f5;
            --card-bg: #ffffff;
            --text-color: #212121;
            --text-muted: #757575;
            --border-color: #e0e0e0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--body-bg);
            padding-bottom: 100px;
            color: var(--text-color);
            line-height: 1.4;
        }

        /* HEADER */
        .order-header {
            background-color: var(--card-bg);
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
            text-align: center;
        }

        .order-header h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .order-header p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* NAVIGATION TABS (SCROLLABLE ON MOBILE) */
        .product-nav-container {
            padding: 10px 20px;
            background-color: var(--card-bg);
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            border-bottom: 1px solid var(--border-color);
        }

        .product-nav {
            display: inline-flex;
            gap: 8px;
        }

        .nav-tab {
            background: var(--body-bg);
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            color: var(--text-color);
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-tab.active {
            color: white;
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        /* CATEGORY GRID */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 0 10px;
        }

        .category-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .category-item:active {
            transform: scale(0.98);
        }

        .category-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .category-name {
            font-weight: 600;
            font-size: 12px;
        }

        /* PRODUCT LIST & GRID */
        .product-content {
            padding: 20px 10px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        @media (min-width: 600px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .product-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .product-item:active {
            transform: scale(0.98);
        }

        .product-item.sold-out {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f5f5f5;
        }

        .product-item.low-stock {
            border-color: var(--danger);
        }

        .product-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .no-image-placeholder {
            width: 100%;
            height: 100px;
            background-color: var(--body-bg);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .product-name {
            font-weight: 600;
            font-size: 13px;
            min-height: 32px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.2;
        }

        .product-price-main {
            font-weight: 700;
            color: var(--text-color);
            font-size: 14px;
            margin: 4px 0;
        }

        .product-stock {
            font-size: 10px;
            margin-top: 2px;
            font-weight: 600;
        }

        .stock-out {
            color: var(--danger);
        }

        .stock-low {
            color: var(--warning);
        }

        .stock-ok {
            color: var(--success);
        }

        /* BACK BUTTON */
        .back-button {
            background: none;
            border: none;
            padding: 8px 0;
            margin-bottom: 15px;
            cursor: pointer;
            color: var(--primary);
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        /* FLOATING CART BUTTON - DIUBAH POSISI LEBIH TINGGI */
        .floating-cart-button {
            position: fixed;
            bottom: 120px;
            /* DIUBAH: Lebih tinggi dari sebelumnya */
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 998;
            transition: all 0.3s;
        }

        .floating-cart-button:hover {
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        /* FOOTER & CHECKOUT */
        .floating-cart-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            padding: 12px 20px;
            z-index: 999;
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cart-summary-row strong {
            font-size: 16px;
            color: var(--primary);
        }

        .pay-button-online {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 700;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pay-button-online:disabled {
            background-color: var(--text-muted);
            cursor: not-allowed;
        }

        /* CART MODAL */
        .cart-modal-content {
            background-color: var(--card-bg);
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: var(--shadow-md);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .cart-item-details {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .cart-item-note {
            font-size: 11px;
            color: var(--text-muted);
            font-style: italic;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            /* DIKECILKAN GAP-NYA */
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--body-bg);
            border-radius: 8px;
            padding: 4px;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 6px;
            background: var(--primary);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .quantity-btn:disabled {
            background: var(--text-muted);
            cursor: not-allowed;
        }

        .quantity-display {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        /* TOMBOL EDIT BARU */
        .edit-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edit-btn:hover {
            background-color: var(--primary-light);
        }

        .delete-btn {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .delete-btn:hover {
            background-color: #ffebee;
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--primary);
            min-width: 80px;
            text-align: right;
        }

        .cart-empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .cart-actions {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
        }

        .cart-actions button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .continue-shopping-btn {
            background: var(--body-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .checkout-btn {
            background: var(--primary);
            color: white;
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 20px;
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-md);
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: 700;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
        }

        .modal-body {
            padding: 15px 20px;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-footer-price {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }

        .modal-save-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* FORM ELEMENTS */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 60px;
        }

        /* OPTION GROUPS */
        .option-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .option-group h3 {
            font-size: 16px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .option-item-wrapper {
            position: relative;
        }

        .option-item-wrapper input[type="radio"],
        .option-item-wrapper input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 10;
            top: 0;
            left: 0;
        }

        .option-item {
            flex: 1;
            display: flex;
            justify-content: space-between;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--body-bg);
            transition: all 0.2s;
        }

        .option-name {
            font-weight: 500;
        }

        .option-price {
            font-weight: 600;
            color: var(--primary);
        }

        .option-item-wrapper input:checked+.option-item {
            border-color: var(--primary);
            background-color: var(--primary-light);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        /* CHECKOUT ITEMS */
        .checkout-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px dashed var(--border-color);
            padding: 10px 0;
        }

        /* STATUS MODAL */
        .status-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .status-icon.success {
            background-color: var(--primary-light);
            color: var(--success);
        }

        .status-icon.error {
            background-color: #ffebee;
            color: var(--danger);
        }

        .status-icon svg {
            width: 30px;
            height: 30px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Debug Info -->
    <div style="display: none;">
        <div id="debug-favorite-count">{{ count($favoriteProducts) }}</div>
        <div id="debug-all-count">{{ count($products) }}</div>
    </div>

    <div class="order-header">
        <h1>Menu Pesanan</h1>
        <p>Meja Aktif: <strong style="color: #2979FF;">{{ $tableNumber }}</strong></p>
    </div>

    <div class="product-nav-container">
        <div class="product-nav">
            <button class="nav-tab active" data-tab="favorit">Favorit</button>
            <button class="nav-tab" data-tab="library">Semua Menu</button>
        </div>
    </div>

    <div class="product-content">
        <div id="tab-favorit" class="tab-pane active">
            <div class="product-grid" id="favorit-product-grid"></div>
        </div>

        <div id="tab-library" class="tab-pane">
            <div id="library-categories-view">
                <div class="category-grid" id="category-grid-container"></div>
            </div>
            <div id="library-products-view" style="display: none;">
                <button class="back-button" onclick="showCategoryList()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali
                </button>
                <h2 id="library-category-name" style="font-size: 20px; margin-bottom: 15px;"></h2>
                <div class="product-grid" id="library-product-grid"></div>
            </div>
        </div>
    </div>

    <!-- Floating Cart Button - DIUBAH POSISINYA LEBIH TINGGI -->
    <div class="floating-cart-button" onclick="openCartModal()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <div class="cart-badge" id="cart-badge">0</div>
    </div>

    <div class="floating-cart-footer">
        <div class="cart-summary-row">
            <span>Total (<span id="floating-cart-count">0</span> item)</span>
            <strong id="floating-summary-total">Rp 0</strong>
        </div>
        <button class="pay-button-online" id="pay-button-online" onclick="openCheckout()" disabled>
            Lanjut ke Pembayaran
        </button>
    </div>

    <!-- Cart Modal -->
    <div class="modal-overlay" id="cart-modal-overlay" onclick="closeCartModal()">
        <div class="cart-modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Keranjang Saya</h2>
                <button class="modal-close-btn" onclick="closeCartModal()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div id="cart-items-list"></div>
            </div>
            <div class="cart-actions">
                <button class="continue-shopping-btn" onclick="closeCartModal()">Lanjut Belanja</button>
                <button class="checkout-btn" onclick="closeCartModal(); openCheckout();">Checkout</button>
            </div>
        </div>
    </div>

    <!-- Item Modal -->
    <div class="modal-overlay" id="item-modal-overlay" onclick="closeItemModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 id="modal-item-name"></h2>
                <button class="modal-close-btn" onclick="closeItemModal()">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Pilih Varian *</h3>
                <div class="option-group" id="modal-item-variants"></div>

                <h3>Tambahan (Opsional)</h3>
                <div class="option-group" id="modal-item-addons"></div>

                <h3>Tipe Pesanan</h3>
                <div class="option-group" id="modal-item-ordertypes"></div>

                <div class="form-group">
                    <label for="modal-item-quantity">Jumlah</label>
                    <input type="number" id="modal-item-quantity" value="1" min="1"
                        oninput="updateModalPrice()">
                </div>

                <div class="form-group">
                    <label for="modal-item-note">Catatan (Opsional)</label>
                    <textarea id="modal-item-note" rows="2" placeholder="Contoh: Tanpa cabai"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-price" id="modal-item-price">Rp 0</div>
                <button class="modal-save-btn" onclick="saveItemToCart()">+ Tambah</button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal-overlay" id="checkout-modal-overlay" onclick="closeCheckoutModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Ringkasan Pesanan</h2>
                <button class="modal-close-btn" onclick="closeCheckoutModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="checkout-items-list"></div>
                <div style="border-top: 2px solid var(--border-color); margin: 20px 0; padding-top: 15px;">
                    <div class="cart-summary-row">
                        <span>Subtotal</span>
                        <span id="checkout-subtotal">Rp 0</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Pajak (10%)</span>
                        <span id="checkout-tax">Rp 0</span>
                    </div>
                    <div class="cart-summary-row" style="font-size: 18px; font-weight: 700;">
                        <span>Total</span>
                        <span id="checkout-total">Rp 0</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="flex-direction: column; gap: 10px;">
                <button class="modal-save-btn" style="width: 100%;" id="payment-submit-btn-online"
                    onclick="processPayment()">
                    💳 Bayar Sekarang
                </button>
                <button onclick="closeCheckoutModal()"
                    style="background: var(--body-bg); color: var(--text-color); border: 1px solid var(--border-color); padding: 10px; border-radius: 8px; width: 100%; cursor: pointer;">
                    Kembali ke Menu
                </button>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div class="modal-overlay" id="status-modal-overlay" onclick="closeStatusModal()">
        <div class="modal-content" onclick="event.stopPropagation()" style="text-align: center;">
            <div class="modal-body">
                <div id="status-icon" class="status-icon"></div>
                <h2 id="status-title" style="margin-bottom: 10px;"></h2>
                <p id="status-message" style="color: var(--text-muted);"></p>
                <div id="status-loading" style="display: none;">
                    <div class="spinner"></div>
                    <p>Memproses pembayaran...</p>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button class="modal-save-btn" id="status-ok-btn" onclick="closeStatusModal()">OK</button>
            </div>
        </div>
    </div>

    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        // Data dari Controller
        const tableNumber = @json($tableNumber);
        const allCategories = @json($categories);
        const allProducts = @json($products);
        const allFavoriteProducts = @json($favoriteProducts);
        const allDiscounts = @json($discounts);
        const allOrderTypes = @json($orderTypes);

        // Debug: Cek data
        console.log('=== DEBUG DATA ===');
        console.log('Favorite Products:', allFavoriteProducts);
        console.log('All Products:', allProducts);
        console.log('Favorite count from PHP:', document.getElementById('debug-favorite-count').textContent);
        console.log('All count from PHP:', document.getElementById('debug-all-count').textContent);

        // Cek apakah ada produk dengan is_favorite = true di semua produk
        const favoriteFromAll = allProducts.filter(p => p.is_favorite === true);
        console.log('Favorite from all products:', favoriteFromAll);

        // Perbaikan 2: Filter Order Types untuk Web Order (Hanya Dine In dan Takeaway)
        const webOrderTypes = allOrderTypes.filter(t => t.name === 'Dine In' || t.name === 'Takeaway');

        // State Management
        let cartItems = [];
        let currentEditingProduct = null;
        let currentEditingIndex = -1;
        let currentTax = 0;
        let currentSubtotal = 0;
        let currentTotal = 0;
        let lastSuccessfulOrderId = null;

        // Utility Functions
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function showTab(tabName, button) {
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
            button.classList.add('active');

            if (tabName === 'library') {
                showCategoryList();
            } else if (tabName === 'favorit') {
                // FIX UTAMA: Render produk favorit
                renderProductsInGrid('favorit-product-grid', allFavoriteProducts);
            }
        }

        // Render Functions
        function renderCategories() {
            const grid = document.getElementById('category-grid-container');
            grid.innerHTML = '';

            if (allCategories.length === 0) {
                document.getElementById('library-categories-view').style.display = 'none';
                document.getElementById('library-products-view').style.display = 'block';
                document.getElementById('library-category-name').innerText = 'Semua Produk';
                renderProductsInGrid('library-product-grid', allProducts);
                return;
            }

            allCategories.forEach(cat => {
                grid.innerHTML += `
                <div class="category-item" onclick="showCategoryProducts(${cat.id}, '${cat.name}')">
                    <div class="category-icon">${cat.icon || '🍽️'}</div>
                    <div class="category-name">${cat.name}</div>
                </div>
            `;
            });
        }

        function showCategoryProducts(categoryId, categoryName) {
            document.getElementById('library-categories-view').style.display = 'none';
            document.getElementById('library-products-view').style.display = 'block';
            document.getElementById('library-category-name').innerText = categoryName;

            const filtered = allProducts.filter(p => p.category_id === categoryId);
            renderProductsInGrid('library-product-grid', filtered);
        }

        function showCategoryList() {
            document.getElementById('library-categories-view').style.display = 'block';
            document.getElementById('library-products-view').style.display = 'none';
            renderCategories();
        }

        function renderProductsInGrid(gridId, products) {
            const grid = document.getElementById(gridId);
            grid.innerHTML = '';

            console.log(`Rendering ${gridId}:`, products);

            if (!products || products.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 40px;">
                        <p style="margin-bottom: 10px;">Tidak ada produk</p>
                        <small>${gridId === 'favorit-product-grid' ? 'Belum ada produk favorit' : 'Tidak ada produk dalam kategori ini'}</small>
                    </div>
                `;
                return;
            }

            products.forEach(product => {
                const stock = parseInt(product.limiting_stock) || 0;
                const isSoldOut = stock === 0;
                const isLowStock = stock > 0 && stock < 10 && stock < 9999;

                let stockClass = 'stock-ok';
                let stockText = 'Tersedia';
                let itemClass = '';

                if (isSoldOut) {
                    stockClass = 'stock-out';
                    stockText = 'HABIS';
                    itemClass = 'sold-out';
                } else if (isLowStock) {
                    stockClass = 'stock-low';
                    stockText = `Sisa ${stock}`;
                    itemClass = 'low-stock';
                } else if (stock < 9999) {
                    stockText = `Stok ${stock}`;
                }

                const minPrice = product.variants && product.variants.length > 0 ?
                    Math.min(...product.variants.map(v => parseFloat(v.price))) :
                    0;

                const imageHtml = product.image_url ?
                    `<img src="/storage/${product.image_url}" alt="${product.name}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">` :
                    '';

                grid.innerHTML += `
                <div class="product-item ${itemClass}" data-product-id="${product.id}">
                    ${imageHtml}
                    <div class="no-image-placeholder" style="${product.image_url ? 'display:none' : ''}">Tidak ada gambar</div>
                    <div class="product-name">${product.name}</div>
                    <div class="product-price-main">Mulai ${formatRupiah(minPrice)}</div>
                    <div class="product-stock ${stockClass}">${stockText}</div>
                </div>
            `;
            });

            // Pasang event listener pada grid container
            document.querySelectorAll(`#${gridId} .product-item`).forEach(card => {
                const productId = parseInt(card.dataset.productId);
                const isSoldOut = card.classList.contains('sold-out');

                card.onclick = () => {
                    if (isSoldOut) {
                        showSoldOutAlert();
                    } else {
                        openItemModal(productId);
                    }
                };
            });
        }

        function showSoldOutAlert() {
            showStatusModal('error', 'Stok Habis', 'Maaf, produk ini sedang tidak tersedia.');
        }

        // ===============================================
        // == FUNGSI KERANJANG & CART MODAL
        // ===============================================

        function updateCartQuantity(index, change) {
            cartItems[index].quantity += change;
            if (cartItems[index].quantity <= 0) {
                cartItems.splice(index, 1);
            }
            updateSummary();
            renderCartItems();
        }

        function removeCartItem(index) {
            cartItems.splice(index, 1);
            updateSummary();
            renderCartItems();
        }

        // FUNGSI EDIT ITEM BARU
        function editCartItem(index) {
            const item = cartItems[index];
            const product = allProducts.find(p => p.id === item.product_id);

            if (!product) {
                showStatusModal('error', 'Error', 'Produk tidak ditemukan');
                return;
            }

            currentEditingProduct = product;
            currentEditingIndex = index;

            document.getElementById('modal-item-name').innerText = product.name;

            // Render Variants dengan memilih varian yang sudah dipilih
            const variantsHtml = product.variants.map((v, i) => {
                const isSelected = v.id === item.selectedVariant.id;
                return `
                <div class="option-item-wrapper">
                    <input type="radio" name="variant" value="${i}" ${isSelected ? 'checked' : ''} onchange="updateModalPrice()">
                    <div class="option-item">
                        <span class="option-name">${v.name}</span>
                        <span class="option-price">${formatRupiah(v.price)}</span>
                    </div>
                </div>
            `;
            }).join('');
            document.getElementById('modal-item-variants').innerHTML = variantsHtml;

            // Render Addons dengan menandai yang sudah dipilih
            const addonsHtml = product.addons && product.addons.length > 0 ?
                product.addons.map((a, i) => {
                    const isSelected = item.selectedAddons.some(selected => selected.id === a.id);
                    return `
                    <div class="option-item-wrapper">
                        <input type="checkbox" name="addon" value="${i}" ${isSelected ? 'checked' : ''} onchange="updateModalPrice()">
                        <div class="option-item">
                            <span class="option-name">${a.name}</span>
                            <span class="option-price">+ ${formatRupiah(a.price)}</span>
                        </div>
                    </div>
                `;
                }).join('') :
                '<p style="color: var(--text-muted);">Tidak ada tambahan</p>';
            document.getElementById('modal-item-addons').innerHTML = addonsHtml;

            // Render Order Types dengan memilih yang sudah dipilih
            const orderTypesHtml = webOrderTypes.map((t, i) => {
                const isSelected = t.id === item.selectedOrderType.id;
                let feeDisplay = '';
                if (t.type === 'fixed' && parseFloat(t.value) > 0) {
                    feeDisplay = `+ ${formatRupiah(parseFloat(t.value))}`;
                } else if (t.type === 'percentage') {
                    feeDisplay = `+ ${parseFloat(t.value) * 100}%`;
                }

                return `
                <div class="option-item-wrapper">
                    <input type="radio" name="ordertype" value="${t.id}" ${isSelected ? 'checked' : ''} onchange="updateModalPrice()">
                    <div class="option-item">
                        <span class="option-name">${t.name}</span>
                        <span class="option-price">${feeDisplay}</span>
                    </div>
                </div>
            `;
            }).join('');
            document.getElementById('modal-item-ordertypes').innerHTML = orderTypesHtml;

            // Set nilai quantity dan note
            document.getElementById('modal-item-quantity').value = item.quantity;
            document.getElementById('modal-item-note').value = item.note || '';

            updateModalPrice();
            document.getElementById('item-modal-overlay').style.display = 'flex';
        }

        function updateSummary() {
            let subtotal = 0;
            let totalItems = 0;
            cartItems.forEach(item => {
                subtotal += item.finalPrice * item.quantity;
                totalItems += item.quantity;
            });

            const taxRate = 0.10;
            const tax = subtotal * taxRate;
            const total = subtotal + tax;

            currentSubtotal = subtotal;
            currentTax = tax;
            currentTotal = total;

            document.getElementById('floating-cart-count').innerText = totalItems;
            document.getElementById('floating-summary-total').innerText = formatRupiah(total);
            document.getElementById('cart-badge').innerText = totalItems;

            const payButton = document.getElementById('pay-button-online');
            payButton.disabled = totalItems === 0;
            payButton.innerText = totalItems === 0 ? 'Pilih Menu' : `Lanjut ke Pembayaran (${totalItems} item)`;
        }

        function renderCartItems() {
            const listContainer = document.getElementById('cart-items-list');
            listContainer.innerHTML = '';

            if (cartItems.length === 0) {
                listContainer.innerHTML = `
                    <div class="cart-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 15px;">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <p>Keranjang Anda kosong</p>
                        <small>Silakan pilih menu terlebih dahulu</small>
                    </div>
                `;
                return;
            }

            cartItems.forEach((item, index) => {
                const itemTotal = item.finalPrice * item.quantity;
                const addonsList = item.selectedAddons.map(a =>
                    `<span style="display: block; font-size: 11px;">+ ${a.name}</span>`).join('');

                listContainer.innerHTML += `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-details">
                            ${item.selectedVariant.name}
                            ${addonsList}
                        </div>
                        ${item.note ? `<div class="cart-item-note">Catatan: ${item.note}</div>` : ''}
                    </div>
                    <div class="cart-item-controls">
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="updateCartQuantity(${index}, -1)" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                            <span class="quantity-display">${item.quantity}</span>
                            <button class="quantity-btn" onclick="updateCartQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="edit-btn" onclick="editCartItem(${index})" title="Edit item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                        <button class="delete-btn" onclick="removeCartItem(${index})" title="Hapus item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="cart-item-price">${formatRupiah(itemTotal)}</div>
                </div>
            `;
            });
        }

        function openCartModal() {
            renderCartItems();
            document.getElementById('cart-modal-overlay').style.display = 'flex';
        }

        function closeCartModal() {
            document.getElementById('cart-modal-overlay').style.display = 'none';
        }

        // ===============================================
        // == FUNGSI MODAL ITEM
        // ===============================================
        function openItemModal(productId) {
            const product = allProducts.find(p => p.id === productId);
            if (!product) return;

            currentEditingProduct = product;
            currentEditingIndex = -1;

            document.getElementById('modal-item-name').innerText = product.name;

            // Render Variants
            const variantsHtml = product.variants.map((v, i) => `
                <div class="option-item-wrapper">
                    <input type="radio" name="variant" value="${i}" ${i === 0 ? 'checked' : ''} onchange="updateModalPrice()">
                    <div class="option-item">
                        <span class="option-name">${v.name}</span>
                        <span class="option-price">${formatRupiah(v.price)}</span>
                    </div>
                </div>
            `).join('');
            document.getElementById('modal-item-variants').innerHTML = variantsHtml;

            // Render Addons
            const addonsHtml = product.addons && product.addons.length > 0 ?
                product.addons.map((a, i) => `
                    <div class="option-item-wrapper">
                        <input type="checkbox" name="addon" value="${i}" onchange="updateModalPrice()">
                        <div class="option-item">
                            <span class="option-name">${a.name}</span>
                            <span class="option-price">+ ${formatRupiah(a.price)}</span>
                        </div>
                    </div>
                `).join('') :
                '<p style="color: var(--text-muted);">Tidak ada tambahan</p>';
            document.getElementById('modal-item-addons').innerHTML = addonsHtml;

            // Render Order Types
            const orderTypesHtml = webOrderTypes.map((t, i) => {
                const isDefault = t.name === 'Dine In';
                let feeDisplay = '';
                if (t.type === 'fixed' && parseFloat(t.value) > 0) {
                    feeDisplay = `+ ${formatRupiah(parseFloat(t.value))}`;
                } else if (t.type === 'percentage') {
                    feeDisplay = `+ ${parseFloat(t.value) * 100}%`;
                }

                return `
                <div class="option-item-wrapper">
                    <input type="radio" name="ordertype" value="${t.id}" ${isDefault ? 'checked' : ''} onchange="updateModalPrice()">
                    <div class="option-item">
                        <span class="option-name">${t.name}</span>
                        <span class="option-price">${feeDisplay}</span>
                    </div>
                </div>
            `;
            }).join('');
            document.getElementById('modal-item-ordertypes').innerHTML = orderTypesHtml;

            document.getElementById('modal-item-quantity').value = 1;
            document.getElementById('modal-item-note').value = '';

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

            const variantIdx = document.querySelector('input[name="variant"]:checked')?.value;
            if (variantIdx === undefined) return;

            let price = parseFloat(currentEditingProduct.variants[variantIdx].price);

            // Add addons
            currentEditingProduct.addons.forEach((addon, index) => {
                if (document.querySelector(`input[name="addon"][value="${index}"]:checked`)) {
                    price += parseFloat(addon.price);
                }
            });

            // Add order type fee
            const orderTypeId = document.querySelector('input[name="ordertype"]:checked')?.value;
            const orderType = allOrderTypes.find(t => t.id == orderTypeId);
            if (orderType) {
                if (orderType.type === 'percentage') {
                    price *= (1 + parseFloat(orderType.value));
                } else {
                    price += parseFloat(orderType.value);
                }
            }

            const qty = parseInt(document.getElementById('modal-item-quantity').value) || 1;
            document.getElementById('modal-item-price').innerText = formatRupiah(price * qty);
        }

        function saveItemToCart() {
            const variantIdx = document.querySelector('input[name="variant"]:checked')?.value;
            if (variantIdx === undefined) {
                showStatusModal('error', 'Varian Belum Dipilih', 'Silakan pilih varian terlebih dahulu');
                return;
            }

            const variant = currentEditingProduct.variants[variantIdx];

            // 1. Addons
            const selectedAddons = [];
            currentEditingProduct.addons.forEach((addon, index) => {
                if (document.querySelector(`input[name="addon"][value="${index}"]:checked`)) {
                    selectedAddons.push(addon);
                }
            });

            // 2. Order Type
            const orderTypeId = document.querySelector('input[name="ordertype"]:checked')?.value;
            const selectedOrderType = allOrderTypes.find(t => t.id == orderTypeId);

            // 3. Discount (Selalu default ID 1 / Tanpa Diskon)
            const selectedDiscount = allDiscounts.find(d => d.id == 1);

            // 4. Quantity & Note
            const quantity = parseInt(document.getElementById('modal-item-quantity').value) || 1;
            const note = document.getElementById('modal-item-note').value;

            // --- HITUNG HARGA FINAL ---
            let basePrice = parseFloat(variant.price);
            selectedAddons.forEach(addon => {
                basePrice += parseFloat(addon.price);
            });

            let priceAfterMarkup = basePrice;
            if (selectedOrderType && selectedOrderType.type === 'percentage') {
                priceAfterMarkup *= (1 + parseFloat(selectedOrderType.value));
            } else if (selectedOrderType && selectedOrderType.type === 'fixed') {
                priceAfterMarkup += parseFloat(selectedOrderType.value);
            }

            const finalPricePerItem = Math.max(0, priceAfterMarkup);

            // --- SIMPAN KE KERANJANG ---
            const cartItem = {
                id: currentEditingProduct.id,
                product_id: currentEditingProduct.id,
                name: currentEditingProduct.name,
                quantity: quantity,
                note: note,
                selectedVariant: variant,
                selectedAddons: selectedAddons,
                selectedOrderType: selectedOrderType,
                discount: selectedDiscount,
                finalPrice: finalPricePerItem,
                isCustom: false
            };

            // Jika sedang edit item, update item yang ada
            if (currentEditingIndex !== -1) {
                cartItems[currentEditingIndex] = cartItem;
                showStatusModal('success', 'Berhasil', 'Item berhasil diupdate');
            } else {
                // Jika menambah item baru
                cartItems.push(cartItem);
                showStatusModal('success', 'Berhasil', 'Item berhasil ditambahkan ke keranjang');
            }

            closeItemModal();
            updateSummary();
            renderCartItems();
        }

        // ===============================================
        // == FUNGSI CHECKOUT MODAL
        // ===============================================

        function openCheckout() {
            if (cartItems.length === 0) {
                showStatusModal('error', 'Keranjang Kosong', 'Silakan pilih menu terlebih dahulu.');
                return;
            }

            const listContainer = document.getElementById('checkout-items-list');
            listContainer.innerHTML = '';

            // Render Items for Checkout Summary
            cartItems.forEach(item => {
                const itemTotal = item.finalPrice * item.quantity;
                const addonsList = item.selectedAddons.map(a =>
                    `<span style="font-style: italic;">+ ${a.name}</span>`).join(', ');

                listContainer.innerHTML += `
                <div class="checkout-item">
                    <div style="flex: 1;">
                        <span style="font-weight: 600;">${item.quantity}x ${item.name} (${item.selectedVariant.name})</span>
                        <br><small style="color: var(--text-muted);">${addonsList}</small>
                    </div>
                    <span style="font-weight: 700;">${formatRupiah(itemTotal)}</span>
                </div>
            `;
            });

            // Update Summary Totals
            document.getElementById('checkout-subtotal').innerText = formatRupiah(currentSubtotal);
            document.getElementById('checkout-tax').innerText = formatRupiah(currentTax);
            document.getElementById('checkout-total').innerText = formatRupiah(currentTotal);

            document.getElementById('checkout-modal-overlay').style.display = 'flex';
        }

        function closeCheckoutModal() {
            document.getElementById('checkout-modal-overlay').style.display = 'none';
        }

        async function processPayment() {
            const payButton = document.getElementById('payment-submit-btn-online');
            payButton.disabled = true;
            payButton.innerText = 'Memproses Pembayaran...';

            const dataToSend = {
                tableNumber: tableNumber,
                cartItems: cartItems,
                subtotal: currentSubtotal,
                tax: currentTax,
                total: currentTotal,
                paymentMethod: 'gateway',
            };

            try {
                const response = await fetch("{{ route('online.order.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataToSend)
                });

                const result = await response.json();

                if (!response.ok) {
                    if (result.message && result.message.includes("Stok tidak cukup")) {
                        throw new Error(result.message);
                    }
                    throw new Error(result.error || result.message || 'Gagal menyimpan pesanan.');
                }

                // === Panggil Midtrans Snap ===
                if (result.snap_token) {
                    snap.pay(result.snap_token, {
                        onSuccess: function(trxResult) {
                            showStatusModal('success', 'Pembayaran Sukses',
                                'Pesanan Anda telah dibayar dan sedang diproses. Order ID: ' + result
                                .order_id);
                            cartItems = [];
                            updateSummary();
                            renderCartItems();
                            closeCheckoutModal();
                        },
                        onPending: function(trxResult) {
                            showStatusModal('pending', 'Pembayaran Menunggu',
                                'Pesanan menunggu pembayaran. Order ID: ' + result.order_id);
                            cartItems = [];
                            updateSummary();
                            renderCartItems();
                            closeCheckoutModal();
                        },
                        onError: function(trxResult) {
                            showStatusModal('error', 'Pembayaran Gagal',
                                'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.innerText = 'Bayar Sekarang';
                        }
                    });
                } else {
                    throw new Error('Gagal mendapatkan token pembayaran.');
                }

            } catch (error) {
                console.error('Error submitting payment:', error);
                showStatusModal('error', 'Gagal Pesan', error.message);
                payButton.disabled = false;
                payButton.innerText = 'Bayar Sekarang';
            }
        }

        // === FUNGSI STATUS MODAL ===
        function showStatusModal(type, title, message) {
            const statusModal = document.getElementById('status-modal-overlay');
            const statusIcon = document.getElementById('status-icon');
            const statusTitle = document.getElementById('status-title');
            const statusMessage = document.getElementById('status-message');

            statusTitle.innerText = title;
            statusMessage.innerText = message;

            statusIcon.className = 'status-icon ' + (type === 'success' || type === 'pending' ? 'success' : 'error');

            if (type === 'success' || type === 'pending') {
                statusIcon.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            } else {
                statusIcon.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
            }

            statusModal.style.display = 'flex';
        }

        function closeStatusModal() {
            document.getElementById('status-modal-overlay').style.display = 'none';
        }

        // Initialize on load
        window.onload = () => {
            console.log('=== INITIALIZING ===');

            // Render produk favorit pertama kali
            renderProductsInGrid('favorit-product-grid', allFavoriteProducts);
            renderCategories();
            updateSummary();
            renderCartItems();

            // Event listener untuk tab
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    showTab(this.dataset.tab, this);
                });
            });

            document.getElementById('status-ok-btn').addEventListener('click', closeStatusModal);
            document.getElementById('pay-button-online').addEventListener('click', openCheckout);

            console.log('=== INITIALIZATION COMPLETE ===');
        }
    </script>
</body>

</html>
