<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekUserRole
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $role = $user->user_hak ?? null;
        $routeName = $request->route()->getName();

        // Akses untuk kasir (kasir bisa akses dashboard)
        if ($role === 'kasir') {
            if (
                str_starts_with($routeName, 'transaksi') ||
                str_starts_with($routeName, 'member') ||
                (str_starts_with($routeName, 'kategori') && !in_array($routeName, ['kategori.create', 'kategori.edit'])) ||
                (str_starts_with($routeName, 'produk') && !in_array($routeName, ['produk.create', 'produk.edit'])) ||
                (str_starts_with($routeName, 'produk_varian') && !in_array($routeName, ['produk_varian.create', 'produk_varian.edit'])) ||
                str_starts_with($routeName, 'dashboard') // Kasir bisa akses dashboard
            ) {
                return $next($request);
            }

            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Akses untuk admin
        if ($role === 'admin') {
            if (str_starts_with($routeName, 'transaksi')) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            return $next($request);
        }

        // Akses untuk owner
        if ($role === 'owner') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
