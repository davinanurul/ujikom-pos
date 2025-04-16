<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Produk;
use App\Models\ProdukVarian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProdukVarianController extends Controller
{
    // Menampilkan daftar varian produk dengan filter berdasarkan produk tertentu (jika ada)
    public function index(Request $request)
    {
        // Mengambil daftar produk untuk digunakan sebagai filter
        $produkList = Produk::all();

        // Mengambil ID produk dari query parameter (jika ada), default null jika kosong
        $idProduk = $request->query('id_produk');

        // Mengambil varian produk, dengan total terjual berdasarkan transaksi jika ada
        $produkVarians = ProdukVarian::with(['detailTransaksi' => function ($query) {
            $query->selectRaw('id_varian, SUM(qty) as total_terjual')
                ->groupBy('id_varian');
        }])
            // Menambahkan filter berdasarkan ID produk jika ada
            ->when(!empty($idProduk), function ($query) use ($idProduk) {
                return $query->where('id_produk', $idProduk);
            })
            // Mengambil semua produk varian sesuai query
            ->get();

        // Mengembalikan tampilan produk_varian.index dengan data produk varian dan produk
        return view('produk_varian.index', compact('produkVarians', 'produkList', 'idProduk'));
    }

    // Menampilkan form untuk menambahkan varian produk baru
    public function create()
    {
        // Mengambil semua produk untuk dipilih pada form pembuatan varian
        $produks = Produk::all();

        // Mengembalikan tampilan produk_varian.create dengan daftar produk
        return view('produk_varian.create', compact('produks'));
    }

    // Menyimpan varian produk baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input dari user untuk memastikan data yang diterima valid
        $request->validate([
            'id_produk'  => 'required|exists:produk,id', // Pastikan id_produk ada di tabel produk
            'size'       => 'required|in:S,M,L,XL', // Pastikan size yang diterima valid
            'warna'      => 'required|string|max:50', // Pastikan warna berupa string
            'harga_jual' => 'required|numeric|min:0', // Pastikan harga jual valid
        ]);

        // Mengambil produk berdasarkan id_produk dari request
        $produk = Produk::findOrFail($request->id_produk);

        // Menghasilkan SKU berdasarkan kode produk, warna, dan size varian
        $sku = ProdukVarian::generateSKU($produk->kode, $request->warna, $request->size);

        // Menyimpan data varian produk ke dalam database
        ProdukVarian::create([
            'id_produk'  => $request->id_produk,
            'size'       => $request->size,
            'warna'      => $request->warna,
            'harga_jual' => $request->harga_jual,
            'sku'        => $sku, // Menyimpan SKU yang dihasilkan
        ]);

        // Mengalihkan kembali ke halaman produk varian dengan pesan sukses
        return redirect()->route('produk_varian.index')->with('success', 'Varian produk berhasil ditambahkan.');
    }

    // Mengekspor daftar varian produk dalam format PDF
    public function exportPDF(Request $request)
    {
        // Mengambil ID produk dari query parameter (jika ada)
        $idProduk = $request->query('id_produk');

        // Mengambil data varian produk dan total terjualnya, dengan filter ID produk jika ada
        $produkVarians = ProdukVarian::with(['detailTransaksi' => function ($query) {
            $query->selectRaw('id_varian, SUM(qty) as total_terjual')
                ->groupBy('id_varian');
        }])
            // Menambahkan filter berdasarkan ID produk jika ada
            ->when(!empty($idProduk), function ($query) use ($idProduk) {
                return $query->where('id_produk', $idProduk);
            })
            // Mengambil semua varian produk sesuai query
            ->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'produkVarians' => $produkVarians,
            'idProduk' => $idProduk,
        ];

        // Memuat tampilan untuk PDF dan menghasilkan file PDF
        $pdf = Pdf::loadView('produk_varian.pdf', $data);

        // Mengunduh file PDF
        return $pdf->download('laporan-produk-varian.pdf');
    }

    // Mengekspor daftar varian produk dalam format Excel
    public function export(Request $request)
    {
        // Mengambil ID produk dari request
        $idProduk = $request->get('id_produk');

        // Mengekspor data varian produk ke dalam file Excel
        return Excel::download(
            new ProductsExport($idProduk),
            'produk_varians.xlsx'
        );
    }
}