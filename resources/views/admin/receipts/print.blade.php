<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $order->invoice_number }}</title>
    <style>
        /* Pengaturan Umum untuk Struk 80mm */
        * {
            margin: 0;
            padding: 0;
            /* Ukuran font lebih kecil untuk kertas 80mm, biasanya 8pt-10pt */
            font-family: 'monospace', 'Courier New', Courier, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            /* Mengurangi jarak antar baris */
            box-sizing: border-box;
            /* Pastikan padding tidak menambah lebar elemen */
        }

        /* Batasi Body untuk memastikan tidak melebihi lebar kertas */
        body {
            /* Lebar kertas 80mm. Kami menggunakan lebar yang sedikit lebih kecil untuk margin printer. */
            width: 78mm;
            padding: 5px;
            /* Padding aman untuk konten (menggantikan margin @page) */
            margin: 0 auto;
        }

        /* === Elemen Header dan Info === */
        .logo-container {
            text-align: center;
            margin: 5px 0 5px;
        }

        .logo-container img {
            max-width: 50mm;
            /* Atur lebar maksimal logo */
            height: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 12pt;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 8pt;
            margin-bottom: 2px;
        }

        /* Pembatas Garis */
        .separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
            height: 0;
            overflow: hidden;
        }

        .info {
            padding: 5px 0;
            margin-bottom: 5px;
        }

        .info-item,
        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            margin-bottom: 1px;
        }

        /* === Tabel Item === */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 5px;
        }

        table thead tr {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        table th,
        table td {
            padding: 2px 0;
            text-align: left;
            vertical-align: top;
        }

        /* Penjajaran untuk kolom tabel */
        table th:nth-child(2),
        table td:nth-child(2) {
            /* Qty */
            text-align: center;
            width: 15%;
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            /* Harga */
            text-align: right;
            width: 30%;
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            /* Total */
            text-align: right;
            width: 25%;
        }

        table th:first-child,
        table td:first-child {
            /* Item Name */
            width: 30%;
        }

        .item-row td {
            padding-bottom: 0px;
            /* Jarak antar item */
        }

        .item-name {
            white-space: normal;
            /* Biarkan nama item membungkus */
        }

        .item-addons,
        .item-addons small {
            display: block;
            font-size: 7.5pt !important;
            margin-top: 1px;
            padding-left: 5px;
        }

        /* === Ringkasan Total === */
        .summary {
            padding: 5px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin-bottom: 5px;
        }

        .summary-total-separator {
            border-top: 1px solid #000;
            margin: 3px 0;
        }

        .summary-item span:first-child {
            font-weight: normal;
        }

        .summary-item:nth-child(4) span {
            /* TOTAL */
            font-size: 10pt;
            font-weight: bold;
        }

        .summary-item.space {
            margin-top: 5px;
        }

        /* === Info Tambahan & Footer === */
        .editable-info {
            text-align: left;
            /* PERUBAHAN DI SINI: Rata Kiri */
            padding: 5px;
            /* Tambahkan padding agar tidak terlalu mepet tepi */
        }

        .footer {
            text-align: center;
            /* Tetap di tengah */
            padding: 5px 0;
        }

        .editable-info p,
        .footer p {
            font-size: 8.5pt;
            line-height: 1.2;
        }

        /* === Print Media Queries === */
        @media print {

            /* Hapus margin cetak default */
            @page {
                size: 80mm auto;
                /* Tentukan lebar kertas 80mm dan tinggi otomatis */
                margin: 0;
                /* Hapus semua margin default printer */
            }

            html,
            body {
                width: 78mm;
                /* Lebar pastikan 78mm atau 79mm untuk toleransi */
                overflow: hidden;
            }

            body {
                /* Padding aman untuk konten (menggantikan margin @page) */
                padding: 5px;
                margin: 0;
            }

            /* Hindari pemutusan elemen penting */
            .info,
            table,
            .summary,
            .editable-info,
            .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
{{-- Script ini akan otomatis memanggil print dialog dan menutup jendela setelah 1 detik --}}

<body onload="window.print(); setTimeout(window.close, 1000);">

    {{-- =================================== --}}
    {{-- == 1. LOGO ATAS --}}
    {{-- =================================== --}}
    <div class="logo-container">
        <img src="{{ asset('/cafe.png') }}" alt="Logo Takato">
    </div>

    <div class="header">
        <h1>TAKATO</h1>
        <p>Jl. Babakan Palasari No. 1, Cihideung, Bogor</p>
        <p>Telp: 08123456789</p>
    </div>

    <div class="info">
        <div class="info-item">
            <span>No. Struk:</span>
            <span>{{ $order->invoice_number }}</span>
        </div>
        <div class="info-item">
            <span>Tanggal:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-item">
            <span>Kasir:</span>
            <span>{{ $order->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span>Metode Bayar:</span>
            <span>{{ ucfirst($order->payment_method) }}</span>
        </div>
        {{-- Tampilkan Shift ID jika ada --}}
        @if ($order->cashier_shift_id)
            <div class="info-item">
                <span>Shift ID:</span>
                <span>{{ $order->cashier_shift_id }}</span>
            </div>
        @endif

    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Harga</th>
                <th class="item-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr class="item-row">
                    <td class="item-name">
                        {{ $item->item_name }}
                        {{-- Tampilkan addons jika ada --}}
                        @if ($item->addons->isNotEmpty())
                            <small class="item-addons">
                                + {{ $item->addons->pluck('addon_name')->join(', ') }}
                            </small>
                        @endif
                        {{-- Tampilkan Catatan jika ada --}}
                        @if ($item->notes)
                            <small class="item-addons" style="color: #666; font-style: italic;">
                                Catatan: {{ $item->notes }}
                            </small>
                        @endif
                        {{-- Tampilkan Diskon Item jika ada --}}
                        @if ($item->discount_amount > 0)
                            <small class="item-addons" style="color: red;">
                                Diskon: ({{ number_format($item->discount_amount, 0, ',', '.') }})
                            </small>
                        @endif

                    </td>
                    <td class="item-qty">{{ $item->quantity }}x</td>
                    <td class="item-price">
                        {{ number_format($item->unit_price_final, 0, ',', '.') }}</td>
                    <td class="item-total">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item">
            <span>Subtotal:</span>
            <span>{{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span>Pajak:</span>
            <span>{{ number_format($order->tax_amount, 0, ',', '.') }}</span>
        </div>

        {{-- Tambahkan pemisah setelah Pajak --}}
        <div class="summary-total-separator"></div>

        <div class="summary-item">
            <span>TOTAL:</span>
            <span>{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>

        {{-- Tampilkan info kembalian HANYA jika pembayaran cash --}}
        @if ($order->payment_method == 'cash')
            <div class="summary-item space">
                <span>Tunai:</span>
                <span>{{ number_format($order->cash_received, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Kembali:</span>
                <span>{{ number_format($order->cash_change, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    {{-- =================================== --}}
    {{-- == 2. EDITABLE INFO SECTION --}}
    {{-- =================================== --}}
    <div class="editable-info">
        <p> INFO TAMBAHAN </p>
        {{-- AREA INI MENGGUNAKAN VARIABEL $settings --}}
        <p><strong>Free Wi-Fi</strong>: {{ $settings['wifi_ssid'] }}</p>
        <p><strong>Pass</strong>: {{ $settings['wifi_password'] }}</p>
        <p>Jangan lupa follow Instagram kami @takato.id</p>
        {{-- Akhir Area Edit --}}
    </div>


    <div class="footer">
        <p>{{ $settings['footer_message'] }}</p>
    </div>
</body>

</html>
