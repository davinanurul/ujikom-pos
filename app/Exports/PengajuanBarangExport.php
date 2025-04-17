<?php

namespace App\Exports;

use App\Models\PengajuanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanBarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PengajuanBarang::select('id', 'nama_pengaju', 'nama_barang', 'qty', 'tanggal_pengajuan', 'terpenuhi')
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id,
                    'Nama Pengaju' => $item->nama_pengaju,
                    'Nama Barang' => $item->nama_barang,
                    'Qty' => $item->qty,
                    'Tanggal Pengajuan' => $item->tanggal_pengajuan,
                    'Status Terpenuhi' => $item->terpenuhi ? 'Terpenuhi' : 'Belum Terpenuhi',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengaju',
            'Nama Barang',
            'Qty',
            'Tanggal Pengajuan',
            'Status Terpenuhi',
        ];
    }
}