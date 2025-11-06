<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderType; // <-- Import Model

class OrderTypeController extends Controller
{
    public function index()
    {
        $orderTypes = OrderType::latest()->paginate(10);
        return view('admin.ordertypes.index', compact('orderTypes'));
    }

    public function create()
    {
        return view('admin.ordertypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:order_types',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        OrderType::create($request->all());
        return redirect()->route('admin.ordertypes.index')->with('success', 'Tipe Pesanan berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $orderType = OrderType::findOrFail($id);
        return view('admin.ordertypes.edit', compact('orderType'));
    }

    public function update(Request $request, string $id)
    {
        $orderType = OrderType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:order_types,name,' . $orderType->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        $orderType->update($request->all());
        return redirect()->route('admin.ordertypes.index')->with('success', 'Tipe Pesanan berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $orderType = OrderType::findOrFail($id);
        $orderType->delete();
        return redirect()->route('admin.ordertypes.index')->with('success', 'Tipe Pesanan berhasil dihapus.');
    }
}
