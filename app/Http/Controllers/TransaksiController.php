<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Models\ProdukVarian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'member'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        $transaksi = $query->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $produks = Produk::whereHas('varian', function ($query) {
            $query->where('stok', '>', 0);
        })->get();
        $members = Member::all();
        return view('transaksi.create', compact('produks', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:member,id',
            'pembayaran' => 'required|in:TUNAI,DEBIT,QRIS',
            'produk_id' => 'required|array',
            'warna' => 'required|array',
            'size' => 'required|array',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array',
            'subtotal' => 'required|array',
        ]);

        $nomor_transaksi = Transaksi::generateNomorTransaksi();

        $transaksi = Transaksi::create([
            'nomor_transaksi' => $nomor_transaksi,
            'tanggal' => now(),
            'member_id' => $request->member_id,
            'pembayaran' => $request->pembayaran,
            'total' => preg_replace('/[^\d]/', '', $request->total),
            'user_id' => Auth::id(),
        ]);

        foreach ($request->produk_id as $index => $produk_id) {
            $varian = ProdukVarian::where([
                'id_produk' => $produk_id,
                'warna' => $request->warna[$index],
                'size' => $request->size[$index],
            ])->first();

            if ($varian) {
                $transaksi->DetailTransaksi()->create([
                    'produk_id' => $produk_id,
                    'id_varian' => $varian->id,
                    'qty' => $request->qty[$index],
                    'harga' => preg_replace('/[^\d]/', '', $request->harga[$index]),
                    'subtotal' => preg_replace('/[^\d]/', '', $request->subtotal[$index]),
                ]);

                // Kurangi stok
                $varian->stok -= $request->qty[$index];
                $varian->save();
            }
        }

        // Kembalikan response JSON dengan pilihan
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'transaksi_id' => $transaksi->id,
        ]);
    }

    public function getVariansByProduk($produkId)
    {
        $warnaList = ProdukVarian::where('id_produk', $produkId)
            ->where('stok', '>', 0)
            ->select('warna')
            ->distinct()
            ->get();

        return response()->json(['warna' => $warnaList]);
    }

    public function getSizesByWarna($produkId, $warna)
    {
        $sizeList = ProdukVarian::where('id_produk', $produkId)
            ->where('warna', $warna)
            ->where('stok', '>', 0)
            ->select('size')
            ->distinct()
            ->get();

        return response()->json(['sizes' => $sizeList]);
    }

    public function getHarga($produkId, $warna, $size)
    {
        $varian = ProdukVarian::where('id_produk', $produkId)
            ->where('warna', $warna)
            ->where('size', $size)
            ->where('stok', '>', 0)
            ->first();

        return response()->json([
            'harga' => $varian ? $varian->harga_jual : 0,
            'id_varian' => $varian ? $varian->id : null,
        ]);
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

    public function exportPDF(Request $request)
    {
        // Query data transaksi
        $query = Transaksi::with(['user', 'member'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        // Ambil data transaksi
        $transaksi = $query->get();

        // Data untuk PDF
        $data = [
            'transaksi' => $transaksi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ];

        // Load view dan generate PDF
        $pdf = Pdf::loadView('transaksi.pdf', $data);

        // Download PDF
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function details($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $detailTransaksi = $transaksi->detailTransaksi; // Ambil detail transaksi berdasarkan transaksi_id

        return view('transaksi.details', compact('transaksi', 'detailTransaksi'));
    }
}
