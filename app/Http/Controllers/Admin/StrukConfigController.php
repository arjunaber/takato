<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukConfig;
use Illuminate\Support\Facades\DB;

class StrukConfigController extends Controller
{
    /**
     * Menampilkan formulir edit konfigurasi struk.
     */
    public function edit()
    {
        // Ambil semua konfigurasi yang relevan dari database
        $configs = [
            'wifi_ssid' => StrukConfig::getValue('wifi_ssid'),
            'wifi_password' => StrukConfig::getValue('wifi_password'),
            'footer_message' => StrukConfig::getValue('footer_message'),
        ];

        return view('admin.config.struk_edit', compact('configs'));
    }

    /**
     * Menyimpan perubahan konfigurasi struk.
     */
    public function update(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'wifi_ssid' => 'required|string|max:100',
            'wifi_password' => 'required|string|max:100',
            'footer_message' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Simpan setiap nilai ke database
            foreach ($request->all() as $key => $value) {
                if (in_array($key, ['wifi_ssid', 'wifi_password', 'footer_message'])) {
                    StrukConfig::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value ?? '']
                    );
                }
            }
            
            DB::commit();

            return redirect()->route('admin.config.struk.edit')->with('success', 'Konfigurasi struk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui konfigurasi: ' . $e->getMessage());
        }
    }
}