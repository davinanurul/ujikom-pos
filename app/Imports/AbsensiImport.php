<?php

namespace App\Imports;

use App\Models\AbsensiKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class AbsensiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek apakah nilai tanggal angka
        if (is_numeric($row['tanggal_masuk'])) {
            $tanggalMasuk = Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d');
        } else {
            $tanggalMasuk = Carbon::parse($row['tanggal_masuk'])->format('Y-m-d');
        }

        return new AbsensiKerja([
            'nama_karyawan' => $row['nama_karyawan'],
            'tanggal_masuk' => $tanggalMasuk,
            'waktu_masuk' => $row['waktu_masuk'],
            'status_masuk' => $row['status_masuk'],
        ]);
    }
}
