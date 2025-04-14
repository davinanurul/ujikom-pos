<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input user
        $request->validate([
            'user_nama' => 'required|string',
            'user_pass' => 'required|string',
        ]);

        // Cari user berdasarkan user_nama
        $user = User::where('user_nama', $request->user_nama)->first();

        // Verifikasi apakah user ada, status aktif, dan cocokkan password
        if (!$user || $user->user_sts == 0 || !Hash::check($request->user_pass, $user->user_pass)) {
            $reason = !$user ? 'User tidak ditemukan' : ($user->user_sts == 0 ? 'Akun tidak aktif' : 'Password salah');

            // Logging kegagalan login
            Log::warning('Gagal login', [
                'user_nama' => $request->user_nama,
                'alasan' => $reason,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors([
                'user_nama' => $user && $user->user_sts == 0 ? 'Akun anda tidak aktif.' : 'Username atau password salah.',
            ]);
        }

        // Logging keberhasilan login
        Log::info('Login berhasil', [
            'user_id' => $user->id,
            'user_nama' => $user->user_nama,
            'ip' => $request->ip(),
        ]);

        // Login user jika validasi berhasil
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        // Logging logout
        Log::info('User logout', [
            'user_id' => Auth::id(),
            'user_nama' => Auth::user()->user_nama ?? 'Guest',
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Logout berhasil!');
    }
}