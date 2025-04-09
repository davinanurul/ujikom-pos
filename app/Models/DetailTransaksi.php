<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_varian',
        'qty',
        'harga',
        'subtotal',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }

    public function produk()
    {
        return $this->hasOneThrough(Produk::class, ProdukVarian::class, 'id', 'id', 'id_varian', 'id_produk');
    }

    public function varian()
    {
        return $this->belongsTo(ProdukVarian::class, 'id_varian', 'id');
    }
}
