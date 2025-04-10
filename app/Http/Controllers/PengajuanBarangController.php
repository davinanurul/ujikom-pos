<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PengajuanBarang;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanBarang::orderBy('created_at', 'desc');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

            $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }

        $pengajuans = $query->get();
        $members = \App\Models\Member::all();

        return view('pengajuan_barang.index', compact('pengajuans', 'members'));
    }

    public function store(Request $request)
    {
        Log::info('Menyimpan pengajuan barang', $request->all());

        $request->validate([
            'nama_pengaju' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        $barangSudahDiterima = DB::table('penerimaan_barang')
            ->join('produk', 'penerimaan_barang.id_produk', '=', 'produk.id')
            ->where('produk.nama', $request->nama_barang)
            ->exists();

        if ($barangSudahDiterima) {
            Log::warning('Barang sudah tersedia, tidak bisa diajukan lagi', ['nama_barang' => $request->nama_barang]);
            return redirect()->route('pengajuanBarang.index')
                ->with('error', 'Barang yang anda ajukan sudah tersedia!');
        }

        PengajuanBarang::create([
            'nama_pengaju' => $request->nama_pengaju,
            'nama_barang' => $request->nama_barang,
            'tanggal_pengajuan' => now(),
            'qty' => $request->qty,
            'terpenuhi' => 0,
        ]);

        Log::info('Pengajuan barang berhasil ditambahkan', ['nama_barang' => $request->nama_barang]);

        return redirect()->route('pengajuanBarang.index')
            ->with('success', 'Pengajuan barang berhasil ditambahkan!');
    }

    public function cekTerpenuhi()
    {
        Log::info('Cek status terpenuhi untuk pengajuan barang');

        $pengajuans = PengajuanBarang::where('terpenuhi', false)->get();

        foreach ($pengajuans as $pengajuan) {
            if (Produk::where('nama', $pengajuan->nama_barang)->exists()) {
                $pengajuan->update(['terpenuhi' => true]);
                Log::info('Pengajuan barang terpenuhi', ['nama_barang' => $pengajuan->nama_barang]);
            }
        }

        return redirect()->route('pengajuanBarang.index')->with('success', 'Cek terpenuhi selesai!');
    }

    public function update(Request $request, $id)
    {
        Log::info('Memperbarui pengajuan barang', ['id' => $id, 'data' => $request->all()]);

        $pengajuan = PengajuanBarang::findOrFail($id);

        $validated = $request->validate([
            'nama_pengaju' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        $pengajuan->update($validated);

        Log::info('Pengajuan barang berhasil diperbarui', ['id' => $id]);

        return redirect()->route('pengajuanBarang.index')->with('success', 'Pengajuan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Log::info('Menghapus pengajuan barang', ['id' => $id]);

        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->delete();

        Log::info('Pengajuan barang berhasil dihapus', ['id' => $id]);

        return redirect()->route('pengajuanBarang.index')->with('success', 'Pengajuan berhasil dihapus!');
    }

    public function getDataPengajuan()
    {
        Log::info('Mengambil data pengajuan untuk chart');
        $dataPengajuan = PengajuanBarang::getDataPengajuan();

        $labels = ['Belum Terpenuhi', 'Terpenuhi'];
        $data = [0, 0];

        foreach ($dataPengajuan as $item) {
            if ($item->terpenuhi == 0) {
                $data[0] = $item->total;
            } else {
                $data[1] = $item->total;
            }
        }

        Log::info('Data pengajuan untuk chart', compact('labels', 'data'));

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function exportPDF(Request $request)
    {
        $query = PengajuanBarang::orderBy('created_at', 'desc');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();

            $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }

        $pengajuans = $query->get();
        $members = Member::all();

        $pdf = Pdf::loadView('Pengajuan_barang.pdf', compact('pengajuans', 'members'));
        return $pdf->download('Pengajuan_barang.pdf');
    }

    public function updateTerpenuhi(Request $request, $id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->terpenuhi = $request->terpenuhi;
        $pengajuan->save();

        return response()->json(['message' => 'Status berhasil diperbarui.']);
    }
}
