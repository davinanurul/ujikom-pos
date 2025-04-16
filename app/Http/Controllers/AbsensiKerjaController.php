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

        if (in_array($request->status_masuk, ['sakit', 'cuti'])) {
            $data['waktu_selesai_kerja'] = '00:00:00';
        }

        AbsensiKerja::create($data);
        return redirect()->back()->with('success', 'Data berhasil di simpan');
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
}
