@extends('layouts.admin')

{{-- Page Title --}}
@section('title', 'Table Management - Floor Map')

@push('styles')
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --border-color: #e2e8f0;
            --blue-outline: #3b82f6;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* --- RESET & GLOBAL --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            background-color: var(--light);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--dark);
        }

        /* --- MAIN CONTAINER --- */
        .h-screen-custom {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
            background: white;
        }

        .container-table-management {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin: 0;
            background: white;
            overflow: hidden;
        }

        /* --- HEADER & FILTER --- */
        .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: var(--shadow-sm);
        }

        .header-left h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-left h2 i {
            color: var(--primary);
            font-size: 24px;
        }

        .header-left p {
            font-size: 12px;
            color: var(--gray-600);
            margin-top: 2px;
        }

        .header-right {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* --- FILTER BAR --- */
        .filter-bar {
            padding: 12px 20px;
            background-color: var(--gray-100);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            min-height: 56px;
        }

        .filter-left {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            background-color: white;
            color: var(--dark);
            cursor: pointer;
        }

        .filter-status {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge.available {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.occupied {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-badge.cleaning {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* --- FLOOR PLAN WRAPPER --- */
        .floor-plan-wrapper {
            flex: 1;
            display: flex;
            overflow: hidden;
            gap: 0;
        }

        .floor-plan-container {
            flex: 1;
            position: relative;
            background-color: #fafbfc;
            background-image: repeating-linear-gradient(0deg, transparent, transparent 49px, rgba(0, 0, 0, 0.03) 49px, rgba(0, 0, 0, 0.03) 50px),
                repeating-linear-gradient(90deg, transparent, transparent 49px, rgba(0, 0, 0, 0.03) 49px, rgba(0, 0, 0, 0.03) 50px);
            background-size: 50px 50px;
            overflow: auto;
            border-right: 1px solid var(--border-color);
            padding: 16px;
            -webkit-user-select: none;
            user-select: none;
        }

        .floor-plan-content {
            position: relative;
            min-width: 100%;
            min-height: 100%;
            touch-action: none;
        }

        /* --- TABLE ITEMS --- */
        .table-item {
            position: absolute;
            width: 120px;
            height: 120px;
            padding: 8px;
            cursor: grab;
            user-select: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-outline);
        }

        .table-item:hover {
            transform: scale(1.08);
            z-index: 100;
        }

        .table-item.dragging {
            opacity: 0.95;
            cursor: grabbing;
            z-index: 1000;
            transform: scale(1.12);
        }

        .table-shape-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2.5px solid var(--blue-outline);
            background-color: white;
            padding: 8px;
            box-shadow: var(--shadow-md);
            border-radius: 8px;
        }

        /* Status Colors */
        .table-item.status-available .table-shape-wrapper {
            border-color: var(--success);
            color: var(--success);
        }

        .table-item.status-occupied .table-shape-wrapper {
            border-color: var(--danger);
            color: var(--danger);
            background-color: #fef2f2;
        }

        .table-item.status-cleaning .table-shape-wrapper {
            border-color: var(--warning);
            color: var(--warning);
            background-color: #fffbeb;
        }

        /* Shapes */
        .table-item.shape-round .table-shape-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .table-item.shape-square .table-shape-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 6px;
        }

        .table-item.shape-rectangle .table-shape-wrapper {
            width: 100px;
            height: 60px;
            border-radius: 6px;
        }

        /* --- CHAIRS (KURSI) --- */
        .chair {
            position: absolute;
            width: 14px;
            height: 14px;
            background-color: #94a3b8;
            border: 1.5px solid #64748b;
            border-radius: 3px;
            z-index: 10;
            display: block;
            /* Pastikan selalu tampil */
        }

        /* POSISI KURSI DEFAULT (Untuk Capacity 1) */
        .chair-1 {
            /* Default position overrides */
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Khusus Meja Rectangle 1 Orang */
        .capacity-1.shape-rectangle .chair-1 {
            top: 50%;
            left: -4px;
            transform: translateY(-50%);
        }


        /* 2 Kursi */
        .capacity-2.shape-round .chair:nth-child(1),
        .capacity-2.shape-square .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-2.shape-round .chair:nth-child(2),
        .capacity-2.shape-square .chair:nth-child(2) {
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-2.shape-rectangle .chair:nth-child(1) {
            top: 50%;
            left: -4px;
            transform: translateY(-50%);
        }

        .capacity-2.shape-rectangle .chair:nth-child(2) {
            top: 50%;
            right: -4px;
            transform: translateY(-50%);
        }

        /* 3 Kursi */
        .capacity-3 .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-3 .chair:nth-child(2) {
            bottom: -4px;
            left: 25%;
            transform: translateX(-25%);
        }

        .capacity-3 .chair:nth-child(3) {
            bottom: -4px;
            right: 25%;
            transform: translateX(25%);
        }

        .capacity-3.shape-rectangle .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-3.shape-rectangle .chair:nth-child(2) {
            bottom: -4px;
            left: 20%;
            transform: translateX(-20%);
        }

        .capacity-3.shape-rectangle .chair:nth-child(3) {
            bottom: -4px;
            right: 20%;
            transform: translateX(20%);
        }

        /* 4 Kursi */
        .capacity-4.shape-round .chair:nth-child(1),
        .capacity-4.shape-square .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-4.shape-round .chair:nth-child(2),
        .capacity-4.shape-square .chair:nth-child(2) {
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-4.shape-round .chair:nth-child(3),
        .capacity-4.shape-square .chair:nth-child(3) {
            top: 50%;
            left: -4px;
            transform: translateY(-50%);
        }

        .capacity-4.shape-round .chair:nth-child(4),
        .capacity-4.shape-square .chair:nth-child(4) {
            top: 50%;
            right: -4px;
            transform: translateY(-50%);
        }

        .capacity-4.shape-rectangle .chair:nth-child(1) {
            top: 50%;
            left: -4px;
            transform: translateY(-50%);
        }

        .capacity-4.shape-rectangle .chair:nth-child(2) {
            top: 50%;
            right: -4px;
            transform: translateY(-50%);
        }

        .capacity-4.shape-rectangle .chair:nth-child(3) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-4.shape-rectangle .chair:nth-child(4) {
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* 5 Kursi */
        .capacity-5 .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-5 .chair:nth-child(2) {
            bottom: -4px;
            left: 30%;
            transform: translateX(-30%);
        }

        .capacity-5 .chair:nth-child(3) {
            bottom: -4px;
            right: 30%;
            transform: translateX(30%);
        }

        .capacity-5 .chair:nth-child(4) {
            top: 40%;
            left: -4px;
            transform: translateY(-40%);
        }

        .capacity-5 .chair:nth-child(5) {
            top: 40%;
            right: -4px;
            transform: translateY(-40%);
        }

        /* 6 Kursi */
        .capacity-6.shape-round .chair:nth-child(1),
        .capacity-6.shape-square .chair:nth-child(1) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-6.shape-round .chair:nth-child(2),
        .capacity-6.shape-square .chair:nth-child(2) {
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-6.shape-round .chair:nth-child(3),
        .capacity-6.shape-square .chair:nth-child(3) {
            top: 10%;
            left: -4px;
            transform: translateY(-10%);
        }

        .capacity-6.shape-round .chair:nth-child(4),
        .capacity-6.shape-square .chair:nth-child(4) {
            top: 10%;
            right: -4px;
            transform: translateY(-10%);
        }

        .capacity-6.shape-round .chair:nth-child(5),
        .capacity-6.shape-square .chair:nth-child(5) {
            bottom: 10%;
            left: -4px;
            transform: translateY(10%);
        }

        .capacity-6.shape-round .chair:nth-child(6),
        .capacity-6.shape-square .chair:nth-child(6) {
            bottom: 10%;
            right: -4px;
            transform: translateY(10%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(1) {
            top: -4px;
            left: 20%;
            transform: translateX(-20%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(2) {
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(3) {
            top: -4px;
            right: 20%;
            transform: translateX(20%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(4) {
            bottom: -4px;
            left: 20%;
            transform: translateX(-20%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(5) {
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .capacity-6.shape-rectangle .chair:nth-child(6) {
            bottom: -4px;
            right: 20%;
            transform: translateX(20%);
        }

        /* 8 Kursi */
        .capacity-8.shape-round .chair:nth-child(1),
        .capacity-8.shape-square .chair:nth-child(1) {
            top: -4px;
            left: 25%;
            transform: translateX(-25%);
        }

        .capacity-8.shape-round .chair:nth-child(2),
        .capacity-8.shape-square .chair:nth-child(2) {
            top: -4px;
            right: 25%;
            transform: translateX(25%);
        }

        .capacity-8.shape-round .chair:nth-child(3),
        .capacity-8.shape-square .chair:nth-child(3) {
            bottom: -4px;
            left: 25%;
            transform: translateX(-25%);
        }

        .capacity-8.shape-round .chair:nth-child(4),
        .capacity-8.shape-square .chair:nth-child(4) {
            bottom: -4px;
            right: 25%;
            transform: translateX(25%);
        }

        .capacity-8.shape-round .chair:nth-child(5),
        .capacity-8.shape-square .chair:nth-child(5) {
            top: 25%;
            left: -4px;
            transform: translateY(-25%);
        }

        .capacity-8.shape-round .chair:nth-child(6),
        .capacity-8.shape-square .chair:nth-child(6) {
            top: 25%;
            right: -4px;
            transform: translateY(-25%);
        }

        .capacity-8.shape-round .chair:nth-child(7),
        .capacity-8.shape-square .chair:nth-child(7) {
            bottom: 25%;
            left: -4px;
            transform: translateY(25%);
        }

        .capacity-8.shape-round .chair:nth-child(8),
        .capacity-8.shape-square .chair:nth-child(8) {
            bottom: 25%;
            right: -4px;
            transform: translateY(25%);
        }

        /* Table Text */
        .table-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            line-height: 1.2;
            z-index: 20;
            pointer-events: none;
        }

        .table-text .table-name {
            font-size: 11px;
            font-weight: 700;
            margin: 0;
            line-height: 1.1;
        }

        .table-text .table-capacity {
            font-size: 9px;
            opacity: 0.7;
            margin: 0;
            line-height: 1.1;
        }

        /* --- SIDE PANEL --- */
        .side-panel {
            width: 300px;
            border-left: 1px solid var(--border-color);
            overflow-y: auto;
            background-color: white;
            display: flex;
            flex-direction: column;
        }

        .panel-header {
            padding: 14px 16px;
            background-color: var(--gray-100);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 13px;
        }

        .panel-content {
            padding: 16px;
            flex: 1;
            overflow-y: auto;
        }

        .detail-item {
            margin-bottom: 12px;
            font-size: 13px;
        }

        .detail-label {
            color: var(--gray-600);
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .detail-value {
            color: var(--dark);
            font-size: 13px;
        }

        /* --- BUTTONS --- */
        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-default {
            background-color: var(--gray-200);
            color: var(--dark);
        }

        .btn-default:hover {
            background-color: var(--gray-300);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 11px;
        }

        /* --- MODAL --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 5000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 480px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray-600);
        }

        .modal-body {
            padding: 16px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
        }

        .modal-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        /* --- ALERT --- */
        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background-color: #cffafe;
            color: #164e63;
            border: 1px solid #a5f3fc;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .side-panel {
                display: none;
            }

            .floor-plan-container {
                border-right: none;
            }
        }

        @media (max-width: 768px) {
            .h-screen-custom {
                height: auto;
                min-height: 100vh;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .header-right {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .filter-bar {
                flex-direction: column;
                align-items: flex-start;
                height: auto;
            }

            .filter-left,
            .filter-group,
            .filter-status {
                width: 100%;
            }

            .filter-group select {
                width: 100%;
            }

            .filter-status {
                justify-content: space-between;
            }

            .status-badge {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div id="layoutAlertContainer"
        style="position: fixed; top: 10px; right: 10px; z-index: 6000; display: flex; flex-direction: column; gap: 10px;">
    </div>

    <div class="h-screen-custom">
        <div class="container-table-management">

            <div class="table-header">
                <div class="header-left">
                    <h2><i class="fas fa-map"></i> Table Map</h2>
                    <p>Manage and arrange your restaurant tables</p>
                </div>
                <div class="header-right">
                    <button class="btn btn-primary" data-action="add-table"><i class="fas fa-plus"></i> Add Table</button>
                    <button class="btn btn-success" data-action="save-layout"><i class="fas fa-save"></i> Save
                        Layout</button>
                    <button class="btn btn-default" data-action="reset-layout"><i class="fas fa-undo"></i> Reset
                        Layout</button>
                </div>
            </div>

            <div class="filter-bar">
                <div class="filter-left">
                    <div class="filter-group">
                        <select id="area-filter" class="area-filter">
                            @if (count($areas) > 0)
                                <option value="{{ $areas[0] }}">{{ $areas[0] }}</option>
                                @foreach ($areas->slice(1) as $areaName)
                                    <option value="{{ $areaName }}">{{ $areaName }}</option>
                                @endforeach
                            @else
                                <option value="indoor">indoor</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="filter-status">
                    <span class="status-badge available">
                        <i class="fas fa-check-circle"></i> Available: <span
                            id="available-count">{{ $stats['available'] }}</span>
                    </span>
                    <span class="status-badge occupied">
                        <i class="fas fa-users"></i> Occupied: <span id="occupied-count">{{ $stats['occupied'] }}</span>
                    </span>
                    <span class="status-badge cleaning">
                        <i class="fas fa-broom"></i> Cleaning: <span id="cleaning-count">{{ $stats['cleaning'] }}</span>
                    </span>
                </div>
            </div>

            <div class="floor-plan-wrapper">
                <div class="floor-plan-container" id="floorPlan">
                    <div class="floor-plan-content">
                        @foreach ($tables as $table)
                            @php
                                // Cek apakah ada order PAID
                                $hasPaidOrder = $table->activeOrder && $table->activeOrder->payment_status === 'paid';

                                // LOGIKA BARU: Prioritas Tampilan
                                if ($hasPaidOrder) {
                                    // 1. Jika sudah bayar -> PASTI OCCUPIED
                                    $displayStatus = 'occupied';
                                } else {
                                    // 3. Sisanya (termasuk jika ada order tapi UNPAID/PENDING) -> AVAILABLE
                                    // Kita memaksa tampil available meskipun di database statusnya 'occupied'
                                    $displayStatus = 'available';
                                }

                                $shapeClass = 'shape-' . $table->shape;
                                $capacityClass = 'capacity-' . $table->capacity;
                            @endphp
                            <div class="table-item status-{{ $displayStatus }} {{ $shapeClass }} {{ $capacityClass }}"
                                data-table-id="{{ $table->id }}" data-table-name="{{ $table->name }}"
                                data-status="{{ $displayStatus }}" data-capacity="{{ $table->capacity }}"
                                data-area="{{ $table->area }}" data-shape="{{ $table->shape }}"
                                style="left: {{ $table->position_x ?? 50 }}px; top: {{ $table->position_y ?? 50 }}px;"
                                title="Click for details, drag to move">

                                <div class="table-shape-wrapper">
                                    {{-- RENDER KURSI SESUAI KAPASITAS --}}
                                    @for ($i = 1; $i <= $table->capacity; $i++)
                                        <div class="chair chair-{{ $i }}"></div>
                                    @endfor

                                    <div class="table-text">
                                        <div class="table-name">{{ $table->name }}</div>
                                        <div class="table-capacity">{{ $table->capacity }} pax</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- SIDEBAR TETAP ADA --}}
                <div class="side-panel">
                    <div class="panel-header">
                        <i class="fas fa-info-circle"></i> Table Details
                    </div>
                    <div class="panel-content" id="panelContent">
                        <p style="color: #999; text-align: center; padding: 40px 0;">
                            Click on a table to view details
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CRUD MEJA --}}
    <div class="modal-overlay" id="tableModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Table</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tableForm" method="POST" action="{{ route('admin.tables.store') }}">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">

                    <div class="form-group">
                        <label>Table Name *</label>
                        <input type="text" id="tableName" name="name" placeholder="e.g., Table 1, VIP A" required>
                    </div>

                    <div class="form-group">
                        <label>Area *</label>
                        <select id="tableArea" name="area" required></select>
                    </div>

                    <div class="form-group">
                        <label>Capacity *</label>
                        <input type="number" id="tableCapacity" name="capacity" min="1" value="4" required>
                    </div>

                    <div class="form-group">
                        <label>Shape *</label>
                        <select id="tableShape" name="shape" required>
                            <option value="square">Square</option>
                            <option value="round">Round</option>
                            <option value="rectangle">Rectangle</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status *</label>
                        <select id="tableStatus" name="status" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="cleaning">Cleaning</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeModal()">Cancel</button>
                <button class="btn btn-primary" onclick="saveTable()">Save Table</button>
            </div>
        </div>
    </div>

    {{-- MODAL SAVE LAYOUT --}}
    <div class="modal-overlay" id="saveLayoutModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 id="saveModalTitle"><i class="fas fa-question-circle"></i> Confirm Save Layout</h3>
                <button class="close-btn" onclick="closeSaveModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to save the current table layout? This will permanently update the positions.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeSaveModal()">Cancel</button>
                <button class="btn btn-success" onclick="confirmSaveLayout()"><i class="fas fa-save"></i> Yes,
                    Save</button>
            </div>
        </div>
    </div>

    {{-- MODAL RESET LAYOUT --}}
    <div class="modal-overlay" id="resetLayoutModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 id="resetModalTitle"><i class="fas fa-exclamation-triangle"></i> Confirm Reset</h3>
                <button class="close-btn" onclick="closeResetModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p class="alert alert-danger">WARNING: This will reset ALL table positions to default. Cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeResetModal()">Cancel</button>
                <button class="btn btn-danger" onclick="confirmResetLayout()"><i class="fas fa-undo"></i> Yes,
                    Reset</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ADMIN_TABLES_URL = "{{ url('admin/tables') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        let isDragging = false;
        let dragElement = null;
        let currentEditingTableId = null;
        let startX, startY;
        let allAreas = @json($areas ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            initializeTableItems();
            setupModalHandlers();

            const filterAreaSelect = document.getElementById('area-filter');
            const initialArea = filterAreaSelect.options.length > 0 ? filterAreaSelect.options[0].value : 'indoor';
            filterAreaSelect.value = initialArea;
            filterAreaSelect.dispatchEvent(new Event('change'));

            updateTableAreaSelect();
        });

        // --- DRAG & DROP ---
        function initializeTableItems() {
            document.querySelectorAll('.table-item').forEach(item => {
                item.addEventListener('mousedown', dragStart);
                item.addEventListener('touchstart', dragStart, {
                    passive: false
                });
                item.addEventListener('click', (e) => {
                    if (!isDragging) showTableDetails(item);
                });
            });
            document.addEventListener('mousemove', drag);
            document.addEventListener('mouseup', dragEnd);
            document.addEventListener('touchmove', drag, {
                passive: false
            });
            document.addEventListener('touchend', dragEnd);
        }

        function getClientCoords(e) {
            if (e.touches && e.touches.length) {
                return {
                    clientX: e.touches[0].clientX,
                    clientY: e.touches[0].clientY
                };
            }
            return {
                clientX: e.clientX,
                clientY: e.clientY
            };
        }

        function dragStart(e) {
            const coords = getClientCoords(e);
            dragElement = e.target.closest('.table-item');
            if (!dragElement) return;

            if (e.type === 'touchstart') e.preventDefault();
            else if (e.button !== 0) return;

            isDragging = false;
            startX = coords.clientX;
            startY = coords.clientY;

            const rect = dragElement.getBoundingClientRect();
            dragElement.offsetX = coords.clientX - rect.left;
            dragElement.offsetY = coords.clientY - rect.top;
        }

        function drag(e) {
            if (!dragElement) return;
            const coords = getClientCoords(e);
            if (e.type === 'touchmove') e.preventDefault();

            const movementX = coords.clientX - startX;
            const movementY = coords.clientY - startY;

            if (Math.abs(movementX) > 5 || Math.abs(movementY) > 5) {
                isDragging = true;
                dragElement.classList.add('dragging');
            }

            if (!isDragging) return;

            const container = document.getElementById('floorPlan');
            const rect = container.getBoundingClientRect();
            const floorPlanContent = document.querySelector('.floor-plan-content');
            const contentRect = floorPlanContent.getBoundingClientRect();

            let newX = coords.clientX - rect.left - dragElement.offsetX;
            let newY = coords.clientY - rect.top - dragElement.offsetY;

            const maxRight = contentRect.width - dragElement.offsetWidth;
            const maxBottom = contentRect.height - dragElement.offsetHeight;

            newX = Math.max(0, Math.min(newX, maxRight));
            newY = Math.max(0, Math.min(newY, maxBottom));

            // Snap to grid
            newX = Math.round(newX / 10) * 10; // Smooth snap 10px
            newY = Math.round(newY / 10) * 10;

            dragElement.style.left = newX + 'px';
            dragElement.style.top = newY + 'px';
        }

        function dragEnd(e) {
            if (!dragElement) return;
            if (e.type === 'touchend' && e.targetTouches.length > 0) return;

            dragElement.classList.remove('dragging');
            dragElement = null;
        }

        // --- API ACTIONS ---
        function getLayoutData() {
            const tableElements = document.querySelectorAll('.table-item');
            const layoutData = [];
            tableElements.forEach(element => {
                layoutData.push({
                    id: element.getAttribute('data-table-id'),
                    position_x: parseFloat(element.style.left) || 50,
                    position_y: parseFloat(element.style.top) || 50
                });
            });
            return layoutData;
        }

        async function confirmSaveLayout() {
            closeSaveModal();
            showLayoutAlert('info', 'Saving layout...');
            try {
                const response = await fetch(`${ADMIN_TABLES_URL}/save-layout`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        tables: getLayoutData()
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) showLayoutAlert('success', 'Layout saved!');
                else showLayoutAlert('danger', 'Failed to save.');
            } catch (error) {
                showLayoutAlert('danger', 'Error connecting to server.');
            }
        }

        async function confirmResetLayout() {
            closeResetModal();
            showLayoutAlert('info', 'Resetting...');
            try {
                const response = await fetch(`${ADMIN_TABLES_URL}/reset-layout`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                if (response.ok) window.location.reload();
                else showLayoutAlert('danger', 'Failed to reset.');
            } catch (error) {
                showLayoutAlert('danger', 'Error connecting to server.');
            }
        }

        // --- UI HELPERS ---
        function showLayoutAlert(type, message) {
            const container = document.getElementById('layoutAlertContainer');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i> ${message}`;
            container.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        function capitalizeWords(str) {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        }

        function formatNumber(num) {
            return parseFloat(num).toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
        }

        function showTableDetails(element) {
            const tableId = element.getAttribute('data-table-id');
            const panel = document.getElementById('panelContent');
            panel.innerHTML = '<p style="text-align:center; padding:20px;">Loading...</p>';

            fetch(`${ADMIN_TABLES_URL}/${tableId}/details`)
                .then(response => response.json())
                .then(data => {
                    const table = data.table;
                    const isAvailable = data.status === 'available';
                    const disabledStyle = isAvailable ? '' :
                        'opacity: 0.6; cursor: not-allowed; background-color: #ccc; border: 1px solid #bbb;';
                    const disabledAttr = isAvailable ? '' : 'disabled';

                    let html = `
                <h4 style="margin-bottom:10px;">${table.name} (${table.area})</h4>
                <div class="detail-item"><div class="detail-label">Capacity</div><div class="detail-value">${table.capacity} Pax</div></div>
                <div class="detail-item"><div class="detail-label">Shape</div><div class="detail-value">${capitalizeWords(table.shape)}</div></div>
            `;

                    // ✅ Hanya tampilkan detail order jika status OCCUPIED (artinya PAID)
                    if (data.status === 'occupied' && data.order) {
                        html += `<hr>
                     <h5 style="color:var(--danger); margin:10px 0;">
                        <i class="fas fa-info-circle"></i> Active Order (PAID)
                     </h5>
                     <div class="detail-item">
                        <div class="detail-label">Invoice</div>
                        <div class="detail-value">${data.order.invoice_number}</div>
                     </div>
                     <div class="detail-item">
                        <div class="detail-label">Total</div>
                        <div class="detail-value">Rp ${formatNumber(data.order.total_price)}</div>
                     </div>
                     <div class="detail-item">
                        <div class="detail-label">Created</div>
                        <div class="detail-value">${data.order.created_at}</div>
                     </div>
                     
                     <button class="btn btn-danger btn-sm" style="margin-top:10px; width:100%;" onclick="clearTable(${table.id}, '${table.name}')">
                        <i class="fas fa-broom"></i> Free Table (Clear)
                     </button>`;
                    } else if (data.status === 'cleaning') {
                        html +=
                            `<hr><div class="alert alert-warning"><i class="fas fa-broom"></i> Sedang Dibereskan</div>
                      <button class="btn btn-success btn-sm" onclick="clearTable(${table.id}, '${table.name}')">
                        <i class="fas fa-check"></i> Selesai
                      </button>`;
                    } else {
                        html +=
                            `<hr><p style="color:green; font-weight:bold;"><i class="fas fa-check-circle"></i> Available</p>`;
                    }

                    html += `<div style="margin-top:20px; border-top:1px dashed #ccc; padding-top:10px; display:flex; gap:5px;">
                        <button class="btn btn-primary btn-sm" 
                            style="flex:1; ${disabledStyle}" 
                            ${disabledAttr} 
                            onclick="${isAvailable ? `editTable(${table.id})` : ''}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm" style="flex:1;" onclick="deleteTable(${table.id}, '${table.name}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                     </div>`;

                    if (!isAvailable) {
                        html +=
                            `<p style="font-size:10px; color:#888; margin-top:5px; text-align:center;">*Meja harus kosong (Free) untuk diedit.</p>`;
                    }

                    panel.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    panel.innerHTML =
                        '<p style="color:red;"><i class="fas fa-exclamation-circle"></i> Error loading details.</p>';
                });
        }

        function clearTable(id, name) {
            if (!confirm(`Clear table ${name}?`)) return;
            fetch(`${ADMIN_TABLES_URL}/${id}/clear-table`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            }).then(res => res.json()).then(data => {
                if (data.success) window.location.reload();
                else showLayoutAlert('danger', 'Failed');
            });
        }

        // --- MODAL FUNCTIONS ---
        function openSaveModal() {
            document.getElementById('saveLayoutModal').classList.add('show');
        }

        function closeSaveModal() {
            document.getElementById('saveLayoutModal').classList.remove('show');
        }

        function openResetModal() {
            document.getElementById('resetLayoutModal').classList.add('show');
        }

        function closeResetModal() {
            document.getElementById('resetLayoutModal').classList.remove('show');
        }

        function closeModal() {
            document.getElementById('tableModal').classList.remove('show');
        }

        function editTable(id) {
            const el = document.querySelector(`[data-table-id="${id}"]`);
            document.getElementById('modalTitle').textContent = 'Edit Table';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('tableForm').action = `${ADMIN_TABLES_URL}/${id}`;
            document.getElementById('tableName').value = el.getAttribute('data-table-name');
            updateTableAreaSelect();
            document.getElementById('tableArea').value = el.getAttribute('data-area');
            document.getElementById('tableCapacity').value = el.getAttribute('data-capacity');
            document.getElementById('tableShape').value = el.getAttribute('data-shape');
            document.getElementById('tableStatus').value = el.getAttribute('data-status');
            document.getElementById('tableModal').classList.add('show');
        }

        function saveTable() {
            if (document.getElementById('tableForm').checkValidity()) document.getElementById('tableForm').submit();
            else alert('Please fill all fields');
        }

        function deleteTable(id, name) {
            if (!confirm(`Delete ${name}?`)) return;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `${ADMIN_TABLES_URL}/${id}`;
            form.innerHTML =
                `<input type="hidden" name="_token" value="${CSRF_TOKEN}"><input type="hidden" name="_method" value="DELETE">`;
            document.body.appendChild(form);
            form.submit();
        }

        function updateTableAreaSelect() {
            const select = document.getElementById('tableArea');
            select.innerHTML = '';
            const areas = [...new Set(['indoor', 'outdoor', ...(Array.isArray(allAreas) ? allAreas : [])])].sort();
            areas.forEach(a => {
                const opt = document.createElement('option');
                opt.value = a;
                opt.textContent = capitalizeWords(a);
                select.appendChild(opt);
            });
        }

        function setupModalHandlers() {
            document.querySelectorAll('[data-action]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const action = btn.getAttribute('data-action');
                    if (action === 'add-table') {
                        document.getElementById('modalTitle').textContent = 'Add New Table';
                        document.getElementById('formMethod').value = 'POST';
                        document.getElementById('tableForm').reset();
                        document.getElementById('tableForm').action = ADMIN_TABLES_URL;
                        updateTableAreaSelect();
                        document.getElementById('tableModal').classList.add('show');
                    } else if (action === 'save-layout') openSaveModal();
                    else if (action === 'reset-layout') openResetModal();
                });
            });

            document.getElementById('area-filter').addEventListener('change', (e) => {
                const area = e.target.value;
                document.querySelectorAll('.table-item').forEach(t => {
                    t.style.display = (t.getAttribute('data-area') === area) ? 'flex' : 'none';
                });
            });
        }
    </script>
@endpush
