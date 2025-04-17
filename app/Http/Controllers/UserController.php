<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna kecuali pengguna dengan hak akses 'owner'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data user kecuali yang memiliki hak akses 'owner'
        $daftarPengguna = User::where('user_hak', '!=', 'owner')->get();

        // Menampilkan view dengan data pengguna
        return view('user.index', compact('daftarPengguna'));
    }

    /**
     * Menampilkan form untuk menambahkan pengguna baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Menyimpan data pengguna baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'user_nama' => 'required|string|max:255|unique:users,user_nama', // nama pengguna harus unik
            'user_pass' => 'required|string|min:8', // password minimal 8 karakter
            'user_hak' => 'required|string|in:admin,kasir,owner', // hak akses harus salah satu dari admin, kasir, atau owner
        ]);

        // Set status pengguna aktif
        $validated['user_sts'] = 1;

        // Set tanggal pembuatan akun
        $validated['created_at'] = now()->format('Y-m-d');

        // Enkripsi password sebelum disimpan ke database
        $validated['user_pass'] = Hash::make($validated['user_pass']);

        // Simpan data pengguna
        User::create($validated);

        // Redirect ke halaman index pengguna dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menonaktifkan akun pengguna berdasarkan ID.
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function nonaktifkanAkun($userId)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Set status pengguna menjadi tidak aktif (false)
        $user->user_sts = false;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dinonaktifkan');
    }

    /**
     * Mengaktifkan kembali akun pengguna berdasarkan ID.
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function aktifkanAkun($userId)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Set status pengguna menjadi aktif (true)
        $user->user_sts = true;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diaktifkan');
    }

    // Expor data ke pdf
    public function exportPDF()
    {
        $suppliers = Supplier::all();

        $pdf = Pdf::loadView('supplier.pdf', compact('suppliers'));
        return $pdf->download('daftar_supplier.pdf');
    }

    // Expor data ke excel/xls
    public function exportExcel()
    {
        return Excel::download(new UserExport, 'daftar_pengguna.xlsx');
    }
}
