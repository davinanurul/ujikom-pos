<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $daftarPengguna = User::all();
        return view('user.index', compact('daftarPengguna'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_nama' => 'required|string|max:255|unique:users,user_nama',
            'user_pass' => 'required|string|min:5',
            'user_hak' => 'required|string|in:admin,kasir',
        ]);

        $validated['user_sts'] = 1;
        $validated['created_at'] = now()->format('Y-m-d');

        $validated['user_pass'] = Hash::make($validated['user_pass']);

        User::create($validated);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function nonaktifkanAkun($userId)
    {
        $user = User::findOrFail($userId);
        $user->user_sts = false;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dinonaktifkan');
    }

    public function aktifkanAkun($userId)
    {
        $user = User::findOrFail($userId);
        $user->user_sts = true;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diaktifkan');
    }
}
