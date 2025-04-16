<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\AbsensiKerjaExport;
use App\Imports\AbsensiImport;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiKerjaController extends Controller
{

    public function index()
    {
        $absensi = AbsensiKerja::orderBy('created_at', 'desc')->get();
        return view('absensi_kerja.index', compact('absensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'status_masuk' => 'required|in:masuk,sakit,cuti',
        ]);

        $data = [
            'nama_karyawan' => $request->nama_karyawan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'waktu_masuk' => $request->waktu_masuk,
            'status_masuk' => $request->status_masuk,
        ];

        // Jika status sakit atau cuti, set waktu_selesai_kerja
        if (in_array($request->status_masuk, ['sakit', 'cuti'])) {
            $data['waktu_selesai_kerja'] = '00:00:00';
        }

        AbsensiKerja::create($data);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_karyawan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'waktu_masuk' => 'nullable',
            'status_masuk' => 'required|in:masuk,sakit,cuti',
        ]);

        $absensi = AbsensiKerja::findOrFail($id);

        $absensi->update([
            'nama_karyawan' => $request->nama_karyawan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'waktu_masuk' => $request->waktu_masuk,
            'status_masuk' => $request->status_masuk,
        ]);

        if (in_array($request->status_masuk, ['sakit', 'cuti'])) {
            $absensi->waktu_selesai_kerja = '00:00:00';
        }

        return redirect()->back()->with('success', 'Data berhasil di update');
    }

    public function destroy(string $id)
    {
        $absensi = AbsensiKerja::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absen.index')->with('success', 'Data berhasil dihapus');
    }

    public function updateWaktuSelesai($id, Request $request)
    {
        $absensi = AbsensiKerja::findOrFail($id);

        $absensi->waktu_selesai_kerja = now();
        $absensi->save();

        return response()->json(['success' => true]);
    }

    public function exportPdf()
    {
        $absensi = AbsensiKerja::all();

        $pdf = Pdf::loadView('absensi_kerja.pdf', compact('absensi'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-absensi.pdf');
    }

    public function export()
    {
        return Excel::download(new AbsensiKerjaExport, 'absensi_kerja.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Proses impor file
        try {
            Excel::import(new AbsensiImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data absensi berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_masuk' => 'required|in:masuk,sakit,cuti',
        ]);

        $absensi = AbsensiKerja::findOrFail($id);

        $absensi->status_masuk = $request->status_masuk;

        // Jika status sakit atau cuti, set waktu selesai kerja ke 00:00:00
        if (in_array($request->status_masuk, ['sakit', 'cuti'])) {
            $absensi->waktu_selesai_kerja = '00:00:00';
        }

        $absensi->save();

        Log::info("Absensi ID: {$id} - Status masuk updated to: {$request->status_masuk}");

 
        return back()->with('success', 'Status absensi berhasil diperbarui');
    }
}
