<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Models\ProdukVarian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;


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
            'bayar' => 'required|numeric|min:0',
        ]);

        $total = preg_replace('/[^\d]/', '', $request->total);
        $bayar = preg_replace('/[^\d]/', '', $request->bayar);

        // Validasi jika bayar kurang dari total
        if ($bayar < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah bayar kurang dari total yang harus dibayar.',
            ], 422);
        }

        $kembalian = $bayar - $total;
        $nomor_transaksi = Transaksi::generateNomorTransaksi();

        $transaksi = Transaksi::create([
            'nomor_transaksi' => $nomor_transaksi,
            'tanggal' => now(),
            'member_id' => $request->member_id,
            'pembayaran' => $request->pembayaran,
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
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

        try {
            $connector = new WindowsPrintConnector("POS-58");
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Busana Bumi\n");
            $printer->text("Jl. Pasarean 01/12\n");
            $printer->feed();

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Tanggal     : " . $transaksi->created_at->format('d-m-Y H:i') . "\n");
            $printer->text("No. Transaksi: " . $transaksi->nomor_transaksi . "\n");
            $printer->text("Kasir         : " . $transaksi->user->user_nama . "\n");
            $printer->text("--------------------------------\n");

            foreach ($transaksi->detailTransaksi as $item) {
                $namaProduk = $item->produk->nama;
                $warna = $item->produkVarian->warna;
                $ukuran = $item->produkVarian->size;

                $printer->text($namaProduk . "\n");
                $printer->text("  " . $warna . " / " . $ukuran . "\n");
                $printer->text(sprintf("  %d x %s = %s\n", $item->qty, number_format($item->harga, 0, ',', '.'), number_format($item->subtotal, 0, ',', '.')));
            }

            $printer->text("--------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Total     : Rp " . number_format($transaksi->total, 0, ',', '.') . "\n");
            $printer->text("Bayar     : Rp " . number_format($transaksi->bayar, 0, ',', '.') . "\n");
            $printer->text("Kembalian : Rp " . number_format($transaksi->kembalian, 0, ',', '.') . "\n");
            $printer->feed(2);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih!\n");
            $printer->pulse();
            $printer->cut();
        } catch (\Exception $e) {
            Log::error('Gagal mencetak struk: ' . $e->getMessage());
        } finally {
            if (isset($printer)) {
                $printer->close();
            }
        }

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

    public function export(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        return Excel::download(new TransactionsExport($tanggalMulai, $tanggalSelesai), 'transactions.xlsx');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);

        // Buat koneksi ke printer (nama printer harus sesuai dengan yang ada di Windows)
        $connector = new WindowsPrintConnector("POS-80"); // Ganti dengan nama printer kamu
        $printer = new Printer($connector);

        // Contoh cetak struk
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Toko Ujikom\n");
        $printer->text("Jl. Contoh Alamat\n");
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Tanggal: " . $transaksi->created_at->format('d-m-Y H:i') . "\n");
        $printer->text("No Transaksi: #" . $transaksi->id . "\n");
        $printer->text("--------------------------------\n");

        foreach ($transaksi->detailTransaksi as $item) {
            $line = sprintf("%-15s %5d x %5d\n", $item->produk->nama, $item->qty, $item->harga);
            $printer->text($line);
        }

        $printer->text("--------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Total: Rp " . number_format($transaksi->total, 0, ',', '.') . "\n");
        $printer->feed(2);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih!\n");

        $printer->cut();
        $printer->close();

        return back()->with('success', 'Struk berhasil dicetak.');
    }
}
