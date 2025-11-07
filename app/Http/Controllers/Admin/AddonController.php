<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon; // <-- Import
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * Menampilkan daftar semua add-on.
     */
    public function index(Request $request)
    {
        $query = Addon::latest();

        // Fungsi search
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $addons = $query->paginate(20);

        return view('admin.addons.index', [
            'addons' => $addons,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Menampilkan form untuk membuat add-on baru.
     */
    public function create()
    {
        return view('admin.addons.create');
    }

    /**
     * Menyimpan add-on baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:addons',
            'price' => 'required|numeric|min:0', // Validasi harga
        ]);

        Addon::create($validatedData);

        return redirect()->route('admin.addons.index')
            ->with('success', 'Add-on baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit.
     */
    public function show(Addon $addon)
    {
        return redirect()->route('admin.addons.edit', $addon);
    }

    /**
     * Menampilkan form untuk mengedit add-on.
     */
    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    /**
     * Update add-on di database.
     */
    public function update(Request $request, Addon $addon)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:addons,name,' . $addon->id,
            'price' => 'required|numeric|min:0', // Validasi harga
        ]);

        $addon->update($validatedData);

        return redirect()->route('admin.addons.index')
            ->with('success', 'Add-on berhasil diperbarui.');
    }

    /**
     * Menghapus add-on.
     */
    public function destroy(Addon $addon)
    {
        try {
            // Cek relasi. Jika add-on sudah terpakai di produk, jangan hapus.
            if ($addon->products()->count() > 0) {
                return redirect()->route('admin.addons.index')
                    ->with('error', 'Gagal! Add-on ini masih terpakai di beberapa produk.');
            }

            // Tambahan: Anda juga bisa cek di OrderItemAddon jika perlu
            // if ($addon->orderItems()->count() > 0) { ... }

            $addon->delete();
            return redirect()->route('admin.addons.index')
                ->with('success', 'Add-on berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangkap error database lainnya
            return redirect()->route('admin.addons.index')
                ->with('error', 'Gagal menghapus add-on.');
        }
    }
}
