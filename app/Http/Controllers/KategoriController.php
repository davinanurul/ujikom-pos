<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Imports\KategoriImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar semua kategori ke halaman index.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('created_at', 'desc')->get();

        // Menambahkan log ketika data kategori diambil
        Log::info('Menampilkan daftar kategori', ['total_kategori' => $kategoris->count()]);

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Log::info('Menambahkan kategori baru', ['nama_kategori' => $request->nama_kategori]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        Log::info('Kategori berhasil ditambahkan', ['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk kategori tertentu berdasarkan ID.
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Log::info('Memperbarui kategori', ['id' => $id, 'nama_kategori' => $validated['nama_kategori']]);

        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
        ]);

        Log::info('Kategori berhasil diperbarui', ['id' => $id, 'nama_kategori' => $validated['nama_kategori']]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Mengembalikan data kategori dalam bentuk JSON (biasanya digunakan untuk modal).
     */
    public function showModal($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json(['kategori' => $kategori]);
    }

    /**
     * Mengimpor data kategori dari file Excel (xlsx, xls, csv).
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new KategoriImport, $request->file('file'));
            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }

    /**
     * Mengekspor data ke file pdf
     */
    public function exportPDF()
    {
        $data = Kategori::all();
        $pdf = Pdf::loadView('kategori.pdf', compact('data'));

        return $pdf->download('kategori-produk.pdf');
    }
}
