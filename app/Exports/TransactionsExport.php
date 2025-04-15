<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $tanggalMulai;
    protected $tanggalSelesai;

    public function __construct($tanggalMulai, $tanggalSelesai)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
    }

    public function collection()
    {
        $query = Transaksi::query();

        if ($this->tanggalMulai && $this->tanggalSelesai) {
            $query->whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalSelesai]);
        }

        return $query->get([
            'id',
            'nomor_transaksi',
            'tanggal',
            'user_id',
            'total',
            'bayar',
            'kembalian',
            'pembayaran',
            'member_id'
        ]);
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nomor Transaksi',
            'Tanggal',
            'Kasir',
            'Total',
            'Bayar',
            'kembalian',
            'Pembayaran',
            'Member'
        ];
    }
}
