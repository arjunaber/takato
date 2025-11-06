@extends('layouts.admin')

@section('title', 'Daftar Diskon')

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
