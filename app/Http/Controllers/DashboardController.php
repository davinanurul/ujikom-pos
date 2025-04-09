<?php

namespace App\Http\Controllers;

use App\Models\Member;
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

        // Hitung total pendapatan hari ini
        $totalPendapatanHariIni = Transaksi::whereDate('tanggal', now()->toDateString())
            ->sum('total');

        // Kirim data ke Blade
        return view('dashboard', compact('produkCount', 'supplierCount', 'memberCount', 'totalPendapatanHariIni'));
    }
}
