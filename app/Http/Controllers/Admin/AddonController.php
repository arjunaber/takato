<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addon; // <-- Import Model

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::latest()->paginate(10);
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons',
            'price' => 'required|numeric|min:0',
        ]);

        Addon::create($request->all());

        return redirect()->route('admin.addons.index')->with('success', 'Add-on berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $addon = Addon::findOrFail($id);
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, string $id)
    {
        $addon = Addon::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:addons,name,' . $addon->id,
            'price' => 'required|numeric|min:0',
        ]);

        $addon->update($request->all());

        return redirect()->route('admin.addons.index')->with('success', 'Add-on berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $addon = Addon::findOrFail($id);
        // Tambahkan validasi: Cek jika addon masih terpakai di 'addon_product'
        if (DB::table('addon_product')->where('addon_id', $id)->exists()) {
            return back()->with('error', 'Add-on tidak bisa dihapus karena masih terhubung ke produk.');
        }

        $addon->delete();
        return redirect()->route('admin.addons.index')->with('success', 'Add-on berhasil dihapus.');
    }
}
