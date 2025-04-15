<?php

namespace App\Exports;

use App\Models\ProdukVarian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $idProduk;

    public function __construct($idProduk = null)
    {
        $this->idProduk = $idProduk;
    }

    public function collection()
    {
        $query = ProdukVarian::with(['produk', 'detailTransaksi']);

        if ($this->idProduk) {
            $query->where('id_produk', $this->idProduk);
        }

        return $query->get();
    }

    public function map($varian): array
    {
        return [
            $varian->id,
            $varian->sku,
            $varian->produk->nama ?? '-',
            $varian->size,
            $varian->warna,
            number_format($varian->harga_jual),
            $varian->stok,
            $varian->detailTransaksi->sum('qty') ?? 0,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'SKU',
            'Nama Produk',
            'Size',
            'Warna',
            'Harga Jual',
            'Stok',
            'Total Terjual',
        ];
    }
}
