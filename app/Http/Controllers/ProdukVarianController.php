<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukVarian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProdukVarianController extends Controller
{
    public function index(Request $request)
    {
        $produkList = Produk::all();

        // Ambil ID produk dari request (jika ada), default ke null jika kosong
        $idProduk = $request->query('id_produk');

        // Query produk varian (tampilkan semua jika tidak difilter)
        $produkVarians = ProdukVarian::with(['detailTransaksi' => function ($query) {
            $query->selectRaw('id_varian, SUM(qty) as total_terjual')
                ->groupBy('id_varian');
        }])
            ->when(!empty($idProduk), function ($query) use ($idProduk) {
                return $query->where('id_produk', $idProduk);
            }) // Jika tidak ada filter, biarkan query menampilkan semua data
            ->get();

        return view('produk_varian.index', compact('produkVarians', 'produkList', 'idProduk'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('produk_varian.create', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'id_produk'  => 'required|exists:produk,id', // Pastikan id_produk ada di tabel produk
            'size'       => 'required|in:S,M,L,XL', // Pastikan size yang diterima valid
            'warna'      => 'required|string|max:50', // Pastikan warna berupa string
            'harga_jual' => 'required|numeric|min:0', // Pastikan harga jual valid
        ]);

        // Ambil produk berdasarkan id_produk
        $produk = Produk::findOrFail($request->id_produk);

        // Generate SKU berdasarkan kode produk, warna, dan size
        $sku = ProdukVarian::generateSKU($produk->kode, $request->warna, $request->size);

        // Simpan varian produk ke dalam database
        ProdukVarian::create([
            'id_produk'  => $request->id_produk,
            'size'       => $request->size,
            'warna'      => $request->warna,
            'harga_jual' => $request->harga_jual,
            'sku'        => $sku, // Simpan SKU yang sudah di-generate
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('produk_varian.index')->with('success', 'Varian produk berhasil ditambahkan.');
    }


    public function exportPDF(Request $request)
    {
        // Ambil ID produk dari request (jika ada), default ke null jika kosong
        $idProduk = $request->query('id_produk');

        // Query produk varian (tampilkan semua jika tidak difilter)
        $produkVarians = ProdukVarian::with(['detailTransaksi' => function ($query) {
            $query->selectRaw('id_varian, SUM(qty) as total_terjual')
                ->groupBy('id_varian');
        }])
            ->when(!empty($idProduk), function ($query) use ($idProduk) {
                return $query->where('id_produk', $idProduk);
            })
            ->get();

        // Data untuk PDF
        $data = [
            'produkVarians' => $produkVarians,
            'idProduk' => $idProduk,
        ];

        // Load view dan generate PDF
        $pdf = Pdf::loadView('produk_varian.pdf', $data);

        // Download PDF
        return $pdf->download('laporan-produk-varian.pdf');
    }
}
