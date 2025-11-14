<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'owner') {
            return $next($request);
        }

        // Jika bukan owner, arahkan ke halaman 403 atau dashboard
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}