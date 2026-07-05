<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek apakah user sudah login dan jabatannya SESUAI dengan pintu yang dituju
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request); // Silakan masuk!
        }

        // 2. Kalau Admin salah kamar ke halaman Warga, usir balik ke Admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 3. Kalau Warga salah kamar ke halaman Admin, usir balik ke Warga
        if (Auth::check() && Auth::user()->role === 'warga') {
            return redirect()->route('warga.dashboard');
        }

        // 4. Kalau belum login sama sekali, usir ke halaman login
        return redirect('/login');
    }
}