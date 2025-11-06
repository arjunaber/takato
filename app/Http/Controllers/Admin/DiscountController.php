<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount; // <-- Import Model

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        // Lakukan validasi seperti biasa
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        // === INI LOGIKA PENTINGNYA ===
        if ($validatedData['type'] === 'percentage') {
            // Ubah input '30' (dari user) menjadi '0.3' (untuk database)
            $validatedData['value'] = $validatedData['value'] / 100;
        }
        // =============================

        // Simpan data ke database
        Discount::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        // Lakukan validasi
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        // === LOGIKA INI JUGA BERLAKU UNTUK UPDATE ===
        if ($validatedData['type'] === 'percentage') {
            // Ubah input '30' (dari user) menjadi '0.3' (untuk database)
            $validatedData['value'] = $validatedData['value'] / 100;
        }
        // ===========================================

        // Update data di database
        $discount->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil dihapus.');
    }
}
