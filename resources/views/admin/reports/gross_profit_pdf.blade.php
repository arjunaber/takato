<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Laba Kotor</title>
    <style>
        @page {
            size: A4 landscape;
            /* Set halaman ke Landscape */
            margin: 15mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 16pt;
        }

        h2 {
            text-align: center;
            margin-top: 0;
            font-size: 12pt;
            color: #555;
        }

        .info-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .info-header p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tfoot th {
            background-color: #d1ecf1;
            border-top: 2px solid #000;
            font-size: 11pt;
        }
    </style>
</head>

<body>

    <h1>LAPORAN ANALISIS LABA KOTOR</h1>
    <h2>Periode: {{ $startDate->format('d F Y') }} s/d {{ $endDate->format('d F Y') }}</h2>

    <div class="info-header">
        <p><strong>Grand Total Revenue:</strong> Rp {{ number_format($grandRevenue, 0, ',', '.') }}</p>
        <p><strong>Grand Total COGS:</strong> Rp {{ number_format($grandCogs, 0, ',', '.') }}</p>
        <p><strong>Grand Total Profit:</strong> Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">Shift ID</th>
                <th style="width: 25%;">Nama Produk</th>
                <th style="width: 10%;" class="text-center">Kuantitas</th>
                <th style="width: 15%;" class="text-right">Total Revenue (Rp)</th>
                <th style="width: 15%;" class="text-right">Total COGS (Rp)</th>
                <th style="width: 15%;" class="text-right">Laba Kotor (Rp)</th>
                <th style="width: 10%;" class="text-center">Margin (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reportData as $item)
                @php
                    $margin = $item->total_revenue > 0 ? ($item->gross_profit / $item->total_revenue) * 100 : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $item->shift_id ?? 'N/A' }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-center">{{ number_format($item->total_quantity, 0) }}</td>
                    <td class="text-right">{{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->total_cogs, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->gross_profit, 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($margin, 2) }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            @php
                $grandMargin = $grandRevenue > 0 ? ($grandTotal / $grandRevenue) * 100 : 0;
            @endphp
            <tr>
                <th colspan="3" class="text-right">TOTAL KESELURUHAN</th>
                <th class="text-right">{{ number_format($grandRevenue, 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($grandCogs, 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($grandTotal, 0, ',', '.') }}</th>
                <th class="text-center">{{ number_format($grandMargin, 2) }}%</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
