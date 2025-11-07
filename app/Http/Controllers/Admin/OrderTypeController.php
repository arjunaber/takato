<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderType::latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $orderTypes = $query->paginate(20);

        return view('admin.order-types.index', [
            'orderTypes' => $orderTypes,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return view('admin.order-types.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:order_types',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
        ]);

        // == LOGIKA KONVERSI PERSENTASE ==
        // Jika user input 10 (untuk 10%), simpan sebagai 0.10
        if ($validatedData['type'] === 'percentage') {
            $validatedData['value'] = $validatedData['value'] / 100;
        }

        OrderType::create($validatedData);

        return redirect()->route('admin.order-types.index')
            ->with('success', 'Tipe pesanan berhasil ditambahkan.');
    }

    public function show(OrderType $orderType)
    {
        return redirect()->route('admin.order-types.edit', $orderType);
    }

    public function edit(OrderType $orderType)
    {
        return view('admin.order-types.edit', compact('orderType'));
    }

    public function update(Request $request, OrderType $orderType)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:order_types,name,' . $orderType->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
        ]);

        // == LOGIKA KONVERSI PERSENTASE ==
        if ($validatedData['type'] === 'percentage') {
            $validatedData['value'] = $validatedData['value'] / 100;
        }

        $orderType->update($validatedData);

        return redirect()->route('admin.order-types.index')
            ->with('success', 'Tipe pesanan berhasil diperbarui.');
    }

    public function destroy(OrderType $orderType)
    {
        // Safety Check: Jangan hapus "Dine In" (ID 1)
        if ($orderType->id == 1) {
            return redirect()->route('admin.order-types.index')
                ->with('error', 'Tipe pesanan "Dine In" tidak boleh dihapus.');
        }

        // Safety Check: Cek apakah pernah dipakai di order
        if ($orderType->orders()->count() > 0) {
            return redirect()->route('admin.order-types.index')
                ->with('error', 'Gagal! Tipe pesanan ini sudah pernah digunakan di histori pesanan.');
        }

        try {
            $orderType->delete();
            return redirect()->route('admin.order-types.index')
                ->with('success', 'Tipe pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.order-types.index')
                ->with('error', 'Gagal menghapus tipe pesanan.');
        }
    }
}
