<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Member::select('id', 'nama', 'telepon', 'alamat', 'tanggal_bergabung', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Telepon',
            'Alamat',
            'Tanggal Bergabung',
            'Status',
        ];
    }
}
