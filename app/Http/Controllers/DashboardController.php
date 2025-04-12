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
    public function index()
    {
        // Hitung jumlah produk, supplier, dan member
        $produkCount = Produk::count();
        $supplierCount = Supplier::count();
        $memberCount = Member::count();
        $pengajuanBarangCount = PengajuanBarang::count();

        // Hitung total pendapatan hari ini
        $totalPendapatanHariIni = Transaksi::whereDate('tanggal', now()->toDateString())
            ->sum('total');

        // Hitung total pendapatan hari ini
        $stokTerjual = DetailTransaksi::whereDate('created_at', now()->toDateString())
            ->sum('qty');

        // Kirim data ke Blade
        return view('dashboard', compact(
            'produkCount',
            'supplierCount',
            'memberCount',
            'totalPendapatanHariIni',
            'pengajuanBarangCount',
            'stokTerjual'
        ));
    }

    public function getTransaksiHarian()
    {
        $transaksiHarian = Transaksi::getTransaksiHarian();

        // Format data untuk Chart.js
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
