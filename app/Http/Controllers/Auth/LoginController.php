<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // BARIS INI WAJIB ADA UNTUK INJEKSI $request
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Kredensial
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba Otentikasi
        // Auth::attempt akan mencoba login dan mengembalikan boolean (true jika berhasil)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // 3. Regenerasi session untuk mencegah session fixation attacks
            $request->session()->regenerate();

            // Dapatkan objek pengguna yang berhasil login
            $user = Auth::user();

            // 4. Logika Redirect Berdasarkan Peran
            if ($user->isOwner()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isAdmin()) {
                return redirect()->intended(route('admin.pos.index'));
            } else {
                // Pengguna biasa
                return redirect()->intended('/');
            }
        }

        // 5. Gagal Otentikasi: Kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); // Hanya simpan input email
    }

    // Perbaikan: Request $request sudah ada di parameter
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
