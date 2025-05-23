<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use App\Models\Produk;
use App\Models\ProdukVarian;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    /**
     * Menampilkan daftar seluruh data penerimaan barang.
     */
    public function index()
    {
        $restoks = PenerimaanBarang::all();
        return view('penerimaan_barang.index', compact('restoks'));
    }

    /**
     * Menampilkan form untuk menambahkan data penerimaan barang.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('penerimaan_barang.create', compact('suppliers'));
    }

    /**
     * Mengambil daftar produk berdasarkan supplier yang dipilih (digunakan oleh AJAX).
     */
    public function getProdukBySupplier($supplierId)
    {
        $produks = Produk::where('supplier_id', $supplierId)->get();
        return response()->json($produks);
    }

    /**
     * Mengambil daftar varian produk berdasarkan produk yang dipilih (digunakan oleh AJAX).
     */
    public function getVarianByProduk($produkId)
    {
        $produkVarians = ProdukVarian::where('id_produk', $produkId)->get();
        return response()->json($produkVarians);
    }

    /**
     * Menyimpan data penerimaan barang ke database, dan update stok produk varian.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|exists:supplier,id',
            'id_produk' => 'required|exists:produk,id',
            'id_varian' => 'required|exists:produk_varian,id',
            'qty' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:1',
        ]);

        $penerimaan = PenerimaanBarang::create([
            'id_supplier' => $request->id_supplier,
            'id_produk' => $request->id_produk,
            'id_varian' => $request->id_varian,
            'qty' => $request->qty,
            'harga_beli' => $request->harga_beli,
            'user_id' => auth()->id(),
        ]);

        // Update stok produk_varian
        ProdukVarian::where('id', $request->id_varian)->increment('stok', $request->qty);

        // Panggil fungsi cekTerpenuhi dari controller pengajuan barang
        $pengajuanBarangController = new PengajuanBarangController();
        $pengajuanBarangController->cekTerpenuhi();

        return redirect()->route('penerimaan_barang.index')->with('success', 'Data Penerimaan Barang berhasil disimpan dan stok telah diperbarui!');
    }

    /**
     * Menampilkan detail dari data penerimaan barang tertentu.
     */
    public function details($id)
    {
        $penerimaan = PenerimaanBarang::findOrFail($id);
        return view('penerimaan_barang.details', compact('penerimaan'));
    }
}