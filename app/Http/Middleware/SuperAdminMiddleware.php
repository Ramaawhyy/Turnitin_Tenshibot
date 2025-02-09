<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Menggunakan atribut 'role' untuk memeriksa superadmin
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            return $next($request);
        }

        // Jika bukan superadmin, arahkan ke halaman utama atau tampilkan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
