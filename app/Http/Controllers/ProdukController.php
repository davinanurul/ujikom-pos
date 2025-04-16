<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Menampilkan daftar semua produk
    public function index()
    {
        // Mengambil semua data produk dari database
        $produks = Produk::all();
        
        // Mengembalikan tampilan produk.index dengan data produk yang diambil
        return view('produk.index', compact('produks'));
    }

    // Menampilkan form untuk menambahkan produk baru
    public function create()
    {
        // Mengambil semua kategori dan supplier dari database
        $categories = Kategori::all();
        $suppliers = Supplier::all();
        
        // Mengembalikan tampilan produk.create dengan data kategori dan supplier
        return view('produk.create', compact('categories', 'suppliers'));
    }

    // Menyimpan produk baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',  // Validasi kategori
            'supplier_id' => 'required|exists:supplier,id',  // Validasi supplier
            'nama' => 'required|string|max:255',  // Validasi nama produk
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi gambar (jika ada)
        ]);

        // Jika ada gambar yang diupload
        $gambarNama = null;
        if ($request->hasFile('gambar')) {
            // Menyimpan gambar ke dalam folder produk-img dan menyimpan nama file
            $gambarNama = $request->file('gambar')->store('produk-img', 'public');
            $gambarNama = basename($gambarNama); // Ambil nama file-nya saja
        }

        // Membuat produk baru
        $produk = Produk::create([
            'kode' => Produk::generateKodeBarang(),  // Menghasilkan kode barang secara otomatis
            'nama' => $request->nama,  // Nama produk dari input
            'kategori_id' => $request->kategori_id,  // ID kategori dari input
            'supplier_id' => $request->supplier_id,  // ID supplier dari input
            'user_id' => auth()->id(),  // ID user yang sedang login
            'gambar' => $gambarNama,  // Nama gambar (jika ada)
        ]);

        // Mengalihkan ke halaman produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        // Mengambil produk berdasarkan ID
        $produk = Produk::findOrFail($id);
        // Mengambil semua kategori dan supplier
        $categories = Kategori::all();
        $suppliers = Supplier::all();

        // Mengembalikan tampilan produk.edit dengan data produk, kategori, dan supplier
        return view('produk.edit', compact('produk', 'categories', 'suppliers'));
    }

    // Memperbarui data produk yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input dari user
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mengambil produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Menghapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::disk('public')->delete('produk-img/' . $produk->gambar);
            }

            // Menyimpan gambar baru dan mengambil nama file-nya
            $gambarPath = $request->file('gambar')->store('produk-img', 'public');
            $gambarName = basename($gambarPath);
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $gambarName = $produk->gambar;
        }

        // Memperbarui data produk
        $produk->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'gambar' => $gambarName,
        ]);

        // Mengalihkan ke halaman produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menampilkan detail produk
    public function details($id)
    {
        // Mengambil produk berdasarkan ID
        $produk = Produk::findOrFail($id);
        // Mengambil varians produk terkait
        $produkVarians = $produk->varian;

        // Mengembalikan tampilan produk.details dengan data produk dan varians
        return view('produk.details', compact('produk', 'produkVarians'));
    }
}
