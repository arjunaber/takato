<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Takato POS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- INI ADALAH SEMUA CSS YANG ANDA BUTUHKAN UNTUK HALAMAN POS --}}
    <style>
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--body-bg);
        }

        ::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 10px;
            border: 2px solid var(--body-bg);
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
        }

        .pos-container {
            display: flex;
            height: 100vh;
            width: 100%;
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

        .cart {
            flex: 2;
            background-color: var(--card-bg);
            padding: 24px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.05);
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
            justify-content: space-between;
            align-items: center;
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
            .pos-container {
                flex-direction: column;
            }

            .product-list {
                flex: 1;
                height: 50vh;
            }

            .cart {
                flex: 1;
                height: 50vh;
                box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
            }

            body {
                overflow: auto;
            }

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
</head>

<body>
    {{-- Konten dari index.blade.php akan masuk di sini --}}
    @yield('content')

    {{-- Script dari index.blade.php akan masuk di sini --}}
    @stack('scripts')
</body>

</html>
