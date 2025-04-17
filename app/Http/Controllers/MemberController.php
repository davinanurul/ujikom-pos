<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Imports\MemberImport;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar semua member.
     */
    public function index()
    {
        $members = Member::all();
        return view('member.index', compact('members'));
    }

    /**
     * Menampilkan form untuk membuat member baru.
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Menyimpan data member baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $validatedData['tanggal_bergabung'] = now();
        $validatedData['status'] = 'aktif';

        Member::create($validatedData);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk data member tertentu.
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    /**
     * Memperbarui data member yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string|max:255',
        ]);

        $member = Member::findOrFail($id);
        $member->nama = $request->nama;
        $member->telepon = $request->telepon;
        $member->alamat = $request->alamat;
        $member->save();

        return redirect()->route('member.index')->with('success', 'Data member berhasil diperbarui.');
    }

    /**
     * Menonaktifkan status akun member.
     */
    public function nonaktifkanAkun($memberId)
    {
        $member = Member::findOrFail($memberId);
        $member->status = 'nonaktif';
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member berhasil dinonaktifkan.');
    }

    /**
     * Mengaktifkan kembali akun member.
     */
    public function aktifkanAkun($memberId)
    {
        $member = Member::findOrFail($memberId);
        $member->status = 'aktif';
        $member->save();

        return redirect()->route('member.index')->with('success', 'Pengguna berhasil diaktifkan.');
    }

    /**
     * Mengimpor data member dari file Excel.
     */
    public function import(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Memproses impor data dari file Excel
        Excel::import(new MemberImport, $request->file('file'));

        // Redirect kembali setelah impor berhasil
        return redirect()->route('member.index')->with('success', 'Data member berhasil diimpor!');
    }

    /**
     * Mengekspor data ke file pdf
     */
    public function exportPDF()
    {
        $members = Member::all();

        $pdf = Pdf::loadView('member.pdf', compact('members'));

        return $pdf->download('daftar_member.pdf');
    }

    /**
     * Mengekspor data ke file excel/xls
     */
    public function exportExcel()
    {
        return Excel::download(new MemberExport, 'daftar_member.xlsx');
    }
}
