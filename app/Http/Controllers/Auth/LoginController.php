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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek apakah user adalah OWNER atau ADMIN.
            if ($user->isOwner() || $user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika peran lain (yaitu 'customer'), redirect ke landing page umum.
            return redirect()->intended('/landing');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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