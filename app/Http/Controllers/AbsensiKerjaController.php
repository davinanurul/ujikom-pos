<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsensiKerjaController extends Controller
{

    public function index()
    {
        $absensi = AbsensiKerja::all();
        return view('absensi_kerja.index', compact('absensi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'status_masuk' => 'required|in:masuk,sakit,cuti',
        ]);

        // Siapkan data untuk disimpan
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

        // Simpan data
        AbsensiKerja::create($data);

        // Kembali dengan pesan sukses
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

        // Perbarui waktu selesai dengan waktu saat ini
        $absensi->waktu_selesai_kerja = now();
        $absensi->save(); 

        return response()->json(['success' => true]);
    }
}
