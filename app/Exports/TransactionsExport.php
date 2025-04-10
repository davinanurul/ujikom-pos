<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaksi::all([
            'id', 'nomor_transaksi', 'tanggal','user_id', 'total', 'pembayaran', 'member_id' // sesuaikan dengan kolommu
        ]);
    }

    public function headings(): array
    {
        return [
            'ID', 'Nomor Transaksi', 'Tanggal', 'Kasir', 'Total', 'Pembayaran', 'Member'
        ];
    }
}
