<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    use HasFactory;

    protected $table = 'produk_varian';

    protected $fillable = [
        'id_produk',
        'sku',
        'size',
        'warna',
        'stok',
        'harga_jual',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_varian', 'id');
    }

    public static function generateSKU($kodeProduk, $warna, $size)
    {
        // Ambil 3 huruf pertama dari warna tanpa spasi, uppercase
        $warnaCode = strtoupper(substr(preg_replace('/\s+/', '', $warna), 0, 3));

        // Size uppercase
        $sizeCode = strtoupper($size);

        // Gabungkan menjadi SKU
        return "{$kodeProduk}-{$warnaCode}-{$sizeCode}";
    }
}
