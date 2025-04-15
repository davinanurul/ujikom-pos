<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MemberImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Member([
            'nama' => $row['nama'],
            'telepon' => $row['telepon'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'tanggal_bergabung' => Carbon::now(),
            'status' => 'aktif',
        ]);
    }
}
