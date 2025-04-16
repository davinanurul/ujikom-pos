<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Member;
use App\Models\PengajuanBarang;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan berbagai data statistik.
     */
    public function index()
    {
        $produkCount = Produk::count();
        $supplierCount = Supplier::count();
        $memberCount = Member::count();
        $pengajuanBarangCount = PengajuanBarang::count();

        $totalPendapatanHariIni = Transaksi::whereDate('tanggal', now()->toDateString())
            ->sum('total');

        $stokTerjual = DetailTransaksi::whereDate('created_at', now()->toDateString())
            ->sum('qty');

        return view('dashboard', compact(
            'produkCount',
            'supplierCount',
            'memberCount',
            'totalPendapatanHariIni',
            'pengajuanBarangCount',
            'stokTerjual'
        ));
    }

    /**
     * Mengambil data transaksi harian dalam format JSON untuk digunakan di grafik (Chart.js).
     */
    public function getTransaksiHarian()
    {
        $transaksiHarian = Transaksi::getTransaksiHarian();

        $labels = $transaksiHarian->pluck('tanggal');
        $jumlahTransaksi = $transaksiHarian->pluck('jumlah_transaksi');
        $totalPendapatan = $transaksiHarian->pluck('total_pendapatan');

        return response()->json([
            'labels' => $labels,
            'jumlah_transaksi' => $jumlahTransaksi,
            'total_pendapatan' => $totalPendapatan,
        ]);
    }
}