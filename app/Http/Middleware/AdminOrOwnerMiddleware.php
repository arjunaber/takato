<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role ?? null;

        if (auth()->check() && in_array($role, ['owner', 'admin'])) {
            return $next($request);
        }

        // Jika bukan owner atau admin, tolak akses
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}