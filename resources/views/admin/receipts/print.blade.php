<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Hapus elemen <title> agar browser tidak mencetak judul halaman/struk --}}
    <title></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'monospace', 'Courier New', Courier;
            font-size: 10pt;
            line-height: 1.4;
        }

        body {
            width: 80mm;
            /* Lebar standar printer thermal */
            margin: 0 auto;
            padding: 10px;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        /* CSS Tambahan untuk Logo */
        .logo-container {
            text-align: center;
            margin-bottom: 5px;
        }

        .logo-container img {
            max-width: 40mm;
            /* Mengurangi lebar maksimal logo dari 50mm menjadi 40mm. */
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Akhir CSS Tambahan Logo */

        .header h1 {
            font-size: 14pt;
            margin: 0;
        }

        .header p {
            font-size: 9pt;
            margin: 0;
        }

        .info {
            margin-bottom: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
            font-size: 9pt;
        }

        tbody td {
            padding: 5px 0;
        }

        .item-row .item-name {
            font-size: 9pt;
        }

        .item-row .item-addons {
            font-size: 8pt;
            padding-left: 10px;
            display: block;
        }

        .item-qty,
        .item-price,
        .item-total {
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
        }

        .summary {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        /* Tambahkan style untuk memisahkan Subtotal/Pajak dengan TOTAL */
        .summary-total-separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        /* Akhir penambahan style */


        .summary-item {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .summary-item.space {
            margin-top: 10px;
        }

        .footer {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 9pt;
        }

        /* CSS Tambahan untuk Info Kaki Struk yang Bisa Diedit */
        .editable-info {
            margin-top: 10px;
            text-align: center;
            font-size: 9pt;
        }

        /* Akhir CSS Tambahan Info Kaki Struk */


        /* Aturan untuk print */
        @media print {
            body {
                padding: 0;
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
        {{-- GANTI DENGAN PATH ASLI LOGO ANDA --}}
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
                                + {{ $item->addons->pluck('name')->join(', ') }}
                            </small>
                        @endif
                    </td>
                    <td class="item-qty">{{ $item->quantity }}x</td>
                    <td class="item-price">{{ number_format($item->unit_price_final, 0, ',', '.') }}</td>
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
        {{-- AREA INI MUDAH DIEDIT: Ubah teks di bawah ini --}}
        <p><strong>Free Wi-Fi</strong>: TAKATO-Guest</p>
        <p><strong>Pass</strong>: takato123</p>
        <p>Jangan lupa follow Instagram kami @takato.id</p>
        {{-- Akhir Area Edit --}}
    </div>


    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>

    {{-- =================================== --}}
    {{-- == 3. LOGO BAWAH --}}
    {{-- =================================== --}}
    <div class="logo-container">
        {{-- GANTI DENGAN PATH ASLI LOGO ANDA --}}
        <img src="{{ asset('/cafe.png') }}" alt="Logo Takato">
    </div>

</body>

</html>
