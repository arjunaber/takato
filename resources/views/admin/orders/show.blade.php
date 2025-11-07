@extends('layouts.admin')

{{-- Judul halaman akan dinamis berdasarkan nomor invoice --}}
@section('title', 'Detail Pesanan #' . $order->invoice_number)

@push('styles')
    <style>
        /* Tata letak dua kolom */
        .order-show-layout {
            display: flex;
            align-items: flex-start;
            gap: 24px;
        }

        .order-details-main {
            flex: 2;
        }

        .order-summary-sidebar {
            flex: 1;
            /* Menghapus sticky agar layout normal */
        }

        /* Kartu untuk item pesanan */
        .order-item-card {
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .order-item-header {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .order-item-price-details {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .order-item-details {
            color: var(--text-color);
            font-size: 0.9rem;
            margin-top: 8px;
        }

        .order-item-details ul {
            margin: 5px 0 0 20px;
            color: var(--text-muted);
        }

        .order-item-details p {
            margin-top: 8px;
        }

        /* Kartu untuk ringkasan */
        .summary-card .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .summary-card .summary-row span {
            color: var(--text-muted);
        }

        .summary-card .summary-row strong {
            color: var(--text-color);
        }

        .summary-card hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px solid var(--border-color);
        }

        .summary-card .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            border-top: 2px solid var(--text-color);
            padding-top: 12px;
            margin-top: 5px;
        }

        /* Badge Status */
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

        /* Media query responsif */
        @media (max-width: 992px) {
            .order-show-layout {
                flex-direction: column;
            }

            .order-summary-sidebar {
                width: 100%;
            }
        }

        /* ================================== */
        /* ==   PERBAIKAN TOMBOL OFFSIDE   == */
        /* ================================== */
        .summary-card .btn-primary {
            width: 100%;
            box-sizing: border-box;
            /* <-- Ini adalah perbaikannya */
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Detail Pesanan: #{{ $order->invoice_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"
            style="background-color: var(--secondary-light); color: var(--text-color);">
            Kembali ke Histori
        </a>
    </div>

    <div class="order-show-layout">

        {{-- =================================== --}}
        {{-- =     KOLOM KIRI (ITEM DETAIL)    = --}}
        {{-- =================================== --}}
        <div class="order-details-main">
            <div class="card">
                <h3>Item Dipesan ({{ $order->orderItems->count() }})</h3>
                <hr style="margin: 15px 0;">

                @foreach ($order->orderItems as $item)
                    <div class="order-item-card">
                        <div class="order-item-header">
                            <span>
                                {{-- Tampilkan kuantitas dan nama item --}}
                                {{ $item->quantity }}x {{ $item->item_name }}
                            </span>
                            <span>
                                {{-- Tampilkan total harga untuk item ini (Qty * Harga Final) --}}
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Rincian harga per item --}}
                        <div class="order-item-price-details">
                            ( @ Rp {{ number_format($item->unit_price_final, 0, ',', '.') }} / item )
                        </div>

                        <div class="order-item-details">
                            {{-- Tampilkan Add-ons jika ada --}}
                            @if ($item->addons->isNotEmpty())
                                <strong>Add-ons:</strong>
                                <ul>
                                    @foreach ($item->addons as $addon)
                                        {{-- Kita ambil dari data snapshot di tabel pivot --}}
                                        <li>
                                            {{ $addon->pivot->addon_name }}
                                            (+Rp {{ number_format($addon->pivot->addon_price, 0, ',', '.') }})
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            {{-- Tampilkan Diskon & Tipe Order jika ada --}}
                            @if ($item->discount_id > 1)
                                {{-- Asumsi ID 1 = Tanpa Diskon --}}
                                <p><strong>Diskon:</strong> {{ $item->discount->name ?? 'N/A' }}
                                    (-Rp {{ number_format($item->discount_amount, 0, ',', '.') }})</p>
                            @endif

                            @if ($item->order_type_id > 1)
                                {{-- Asumsi ID 1 = Dine In (tanpa biaya) --}}
                                <p><strong>Tipe:</strong> {{ $item->orderType->name ?? 'N/A' }}
                                    (+Rp {{ number_format($item->order_type_fee, 0, ',', '.') }})</p>
                            @endif

                            {{-- Tampilkan Catatan jika ada --}}
                            @if ($item->notes)
                                <p><strong>Catatan:</strong> {{ $item->notes }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- =================================== --}}
        {{-- =    KOLOM KANAN (RINGKASAN)      = --}}
        {{-- =================================== --}}
        <div class="order-summary-sidebar">
            <div class="card summary-card">
                {{-- Tombol Cetak Struk --}}
                <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-primary"
                    style="width: 100%; margin-bottom: 15px;" target="_blank">
                    Cetak Struk
                </a>

                <h3>Ringkasan</h3>
                <hr>
                <div class="summary-row">
                    <span>Tanggal:</span>
                    <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Kasir:</span>
                    <strong>{{ $order->user->name ?? 'N/A' }}</strong>
                </div>
                <div class="summary-row">
                    <span>Status Order:</span>
                    <strong>
                        @if ($order->status == 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($order->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </strong>
                </div>
                <div class="summary-row">
                    <span>Status Bayar:</span>
                    <strong>
                        @if ($order->payment_status == 'paid')
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Unpaid</span>
                        @endif
                    </strong>
                </div>

                <h3>Total</h3>
                <hr>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Pajak (Tax):</span>
                    <strong>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-row total">
                    <span>Total Bayar:</span>
                    <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>

                <h3>Pembayaran</h3>
                <hr>
                <div class="summary-row">
                    <span>Metode Bayar:</span>
                    <strong>{{ ucfirst($order->payment_method) }}</strong>
                </div>

                {{-- Hanya tampilkan ini jika metodenya 'cash' --}}
                @if ($order->payment_method == 'cash')
                    <div class="summary-row">
                        <span>Uang Tunai:</span>
                        <strong>Rp {{ number_format($order->cash_received, 0, ',', '.') }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Kembalian:</span>
                        <strong>Rp {{ number_format($order->cash_change, 0, ',', '.') }}</strong>
                    </div>
                @endif

                {{-- Tampilkan jika ada referensi gateway --}}
                @if ($order->payment_gateway_ref)
                    <div class="summary-row">
                        <span>Ref Gateway:</span>
                        <strong>{{ $order->payment_gateway_ref }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
