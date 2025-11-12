{{-- File: resources/views/admin/receipts/print_stock_request.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permintaan Stok - {{ $date->format('d/m/Y') }}</title>
    <style>
        /* Mengatur halaman cetak menjadi Landscape */
        @page {
            size: A4 landscape;
            margin: 10mm;
            /* Margin lebih kecil untuk memaksimalkan ruang */
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 15mm;
            /* Padding di body agar konten tidak terlalu mepet tepi */
            color: #333;
            -webkit-print-color-adjust: exact;
            /* Penting untuk mencetak warna latar belakang */
        }

        /* Kop Surat */
        .header-kop {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Pusatkan kop surat */
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        .header-kop .logo {
            width: 80px;
            /* Ukuran logo */
            height: auto;
            margin-right: 20px;
        }

        .header-kop .cafe-info {
            text-align: center;
            /* Pusatkan teks info cafe */
            flex-grow: 1;
            /* Agar info cafe mengisi ruang */
        }

        .header-kop .cafe-info h2 {
            margin: 0;
            font-size: 18pt;
            color: #333;
            text-transform: uppercase;
        }

        .header-kop .cafe-info p {
            margin: 2px 0;
            font-size: 9pt;
        }

        h1 {
            text-align: center;
            font-size: 24pt;
            /* Ukuran judul lebih besar */
            margin-top: 25px;
            /* Jarak dari kop surat */
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #000;
        }

        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        .document-info .left,
        .document-info .right {
            width: 48%;
            /* Memberi ruang untuk info kiri dan kanan */
        }

        .document-info p {
            margin: 5px 0;
        }

        .document-info strong {
            display: inline-block;
            /* Agar label dan nilai sejajar */
            min-width: 100px;
            /* Lebar minimum untuk label */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 9pt;
            /* Ukuran font tabel lebih kecil */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }


        .footer-signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
            /* Menyebar tanda tangan */
            text-align: center;
            font-size: 9pt;
        }

        .signature-box {
            width: 28%;
            /* Sesuaikan lebar untuk 3 kolom */
            margin: 0 10px;
            /* Spasi antar kolom */
            page-break-inside: avoid;
            /* Hindari pemisahan tanda tangan antar halaman */
        }

        .signature-box p {
            margin-bottom: 5px;
            /* Jarak antara label dan garis */
        }

        .signature-line {
            display: block;
            margin: 50px auto 10px auto;
            /* Jarak dari teks ke garis, pusatkan garis */
            border-bottom: 1px solid #000;
            width: 90%;
            /* Lebar garis tanda tangan */
        }
    </style>
</head>

<body onload="window.print(); setTimeout(window.close, 1000);">

    {{-- Kop Surat --}}
    <div class="header-kop">
        <img src="{{ asset('cafe.png') }}" alt="Logo Cafe" class="logo">
        <div class="cafe-info">
            <h2>TAKATO</h2>
            <p>Jl. Babakan Palasari No. 1, Cihideung, Bogor</p>
            <p>Telp: 08123456789 | Email: info@takato.com</p>
        </div>
    </div>

    <h1>SURAT PERMINTAAN STOK</h1>

    <div class="document-info">
        <div class="left">
            <p><strong>Nomor Dokumen:</strong>
                SR-{{ $date->format('Ymd') }}-{{ str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Diajukan Oleh:</strong> {{ $user->name }}</p>
        </div>
        <div class="right" style="text-align: right;">
            <p><strong>Tanggal Permintaan:</strong> {{ $date->format('d F Y') }}</p>
            <p><strong>Waktu Permintaan:</strong> {{ $date->format('H:i') }} WIB</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No.</th>
                <th>Nama Bahan Baku</th>
                <th class="text-right" style="width: 15%;">Stok Saat Ini</th>
                <th class="text-right" style="width: 15%;">Jumlah Permintaan</th>
                <th class="text-center" style="width: 10%;">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-right">{{ number_format($item['stock'], 2) }}</td>
                    <td class="text-right">{{ number_format($item['amount'], 2) }}</td>
                    <td class="text-center">{{ $item['unit'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada item permintaan stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-signatures">
        <div class="signature-box">
            <p>Pengirim,</p>
            <span class="signature-line"></span>
            <p>({{ $user->name }})</p>
        </div>
        <div class="signature-box">
            <p>Penerima,</p>
            <span class="signature-line"></span>
            <p>(____________)</p>
        </div>
        <div class="signature-box">
            <p>Disetujui Oleh,</p>
            <span class="signature-line"></span>
            <p>(Manajer/Admin)</p>
        </div>
    </div>

</body>

</html>
