<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import log facade

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('created_at', 'desc')->get();
        
        // Menambahkan log ketika data kategori diambil
        Log::info('Menampilkan daftar kategori', ['total_kategori' => $kategoris->count()]);
        
        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Debugging inputan request
        // dd($request->all());

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Menambahkan log sebelum data kategori disimpan
        Log::info('Menambahkan kategori baru', ['nama_kategori' => $request->nama_kategori]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Log sukses penyimpanan
        Log::info('Kategori berhasil ditambahkan', ['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Menambahkan log sebelum kategori diperbarui
        Log::info('Memperbarui kategori', ['id' => $id, 'nama_kategori' => $validated['nama_kategori']]);

        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
        ]);

        // Log sukses update
        Log::info('Kategori berhasil diperbarui', ['id' => $id, 'nama_kategori' => $validated['nama_kategori']]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }
}