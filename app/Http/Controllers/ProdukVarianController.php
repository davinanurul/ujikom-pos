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
        $request->validate([
            'id_produk'  => 'required|exists:produk,id',
            'size'       => 'required|in:S,M,L,XL',
            'warna'      => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        ProdukVarian::create([
            'id_produk'  => $request->id_produk,
            'size'       => $request->size,
            'warna'      => $request->warna,
            'harga_jual' => $request->harga_jual,
        ]);

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
