<?php

namespace App\Imports;

use App\Models\Absensi;
use App\Models\AbsensiKerja;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsensiImport implements ToModel
{
    public function model(array $row)
    {
        return new AbsensiKerja([
            'nama_karyawan' => $row[0], // Kolom pertama adalah nama karyawan
            'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d'), // Kolom kedua adalah tanggal masuk
            'waktu_masuk' => $row[2], // Kolom ketiga adalah waktu masuk
            'status_masuk' => $row[3], // Kolom keempat adalah status masuk
            // Tambahkan kolom lain yang sesuai dengan struktur file Excel yang kamu miliki
        ]);
    }
}

