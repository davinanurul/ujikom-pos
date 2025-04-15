<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Supplier([
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'alamat' => $row['alamat'],
        ]);
    }
}
