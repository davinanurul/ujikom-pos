<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('user_id', 'user_nama', 'user_hak', 'user_sts', 'created_at')
                    ->where('user_hak', '!=', 'owner')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengguna',
            'Hak Akses',
            'Status',
            'Tanggal Dibuat',
        ];
    }
}