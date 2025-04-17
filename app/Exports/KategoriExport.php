<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Kategori::select('id', 'nama_kategori')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kategori',
        ];
    }
}