<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GrossProfitReportExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Shift ID',
            'Nama Produk',
            'Kuantitas Terjual',
            'Total Revenue (Rp)',
            'Total COGS (Rp)',
            'Laba Kotor (Rp)',
            'Margin (%)'
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            // Margin dihitung dari hasil query
            $margin = ($item->total_revenue > 0) ? (($item->gross_profit / $item->total_revenue) * 100) : 0;

            // Pengembalian dalam numeric array sesuai urutan headings()
            return [
                $item->shift_id ?? 'N/A',
                $item->product_name,
                $item->total_quantity,
                $item->total_revenue,
                $item->total_cogs,
                $item->gross_profit,
                number_format($margin, 2) . '%',
            ];
        });
    }
}
