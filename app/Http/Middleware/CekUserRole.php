<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekUserRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $role = $user->user_hak ?? null;
        $routeName = $request->route()->getName();

        // Akses untuk kasir
        if ($role === 'kasir') {
            // Kasir hanya bisa mengakses transaksi, member, kategori (selain create dan edit), produk (selain create dan edit), varian (selain create dan edit)
            if (
                str_starts_with($routeName, 'transaksi') || 
                str_starts_with($routeName, 'member') ||
                (str_starts_with($routeName, 'kategori') && !in_array($routeName, ['kategori.create', 'kategori.edit'])) ||
                (str_starts_with($routeName, 'produk') && !in_array($routeName, ['produk.create', 'produk.edit'])) ||
                (str_starts_with($routeName, 'produk_varian') && !in_array($routeName, ['produk_varian.create', 'produk_varian.edit']))
            ) {
                return $next($request);
            }

            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Akses untuk admin
        if ($role === 'admin') {
            // Admin bisa mengakses semuanya kecuali transaksi
            if (str_starts_with($routeName, 'transaksi')) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            return $next($request);
        }

        // Akses untuk Owner
        if ($role === 'owner') {
            // Owner bisa mengakses semuanya
            return $next($request);
        }

        // Jika tidak ada role yang sesuai, redirect ke login
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
