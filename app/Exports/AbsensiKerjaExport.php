<?php

namespace App\Exports;

use App\Models\AbsensiKerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiKerjaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua data absensi yang ingin diekspor
        return AbsensiKerja::select('id', 'nama_karyawan', 'tanggal_masuk', 'waktu_masuk', 'status_masuk', 'waktu_selesai_kerja') // Gantilah dengan kolom yang sesuai
            ->get();
    }

    public function headings(): array
    {
        // Menentukan kolom header yang akan ditampilkan di file Excel
        return [
            'ID',
            'Nama Karyawan',
            'Tanggal Masuk',
            'Waktu Masuk',
            'Status Masuk',
            'Waktu Selesai Kerja',
        ];
    }
}
