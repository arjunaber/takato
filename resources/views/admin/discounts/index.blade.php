@extends('layouts.admin')

@section('title', 'Daftar Diskon')
@push('styles')
    <style>
        /* == CSS BARU UNTUK PAGINATION BOOTSTRAP == */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: center;
            /* Opsional: Posisikan di tengah */
        }

        .page-item {
            margin: 0 2px;
        }

        .page-item.disabled .page-link {
            color: var(--text-muted);
            pointer-events: none;
            background-color: var(--secondary-light);
            border-color: var(--border-color);
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            line-height: 1.25;
            color: var(--primary);
            background-color: #fff;
            border: 1px solid var(--border-color);
            text-decoration: none;
            border-radius: 0.25rem;
        }

        .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Manajemen Diskon</h1>
        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
            + Tambah Diskon
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                    <tr>
                        <td>{{ $discount->name }}</td>
                        <td>{{ $discount->type == 'percentage' ? 'Persentase' : 'Nominal (Rp)' }}</td>
                        <td>
                            @if ($discount->type == 'percentage')
                                {{ $discount->value * 100 }}%
                            @else
                                Rp {{ number_format($discount->value, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus diskon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada diskon.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $discounts->links() }}
        </div>
    </div>
@endsection
