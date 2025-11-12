<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Mengizinkan Owner dan Admin (Kasir/Supervisor) mengakses panel admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->isOwner() || $user->isAdmin()) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses ke panel Administrator.');
    }
}