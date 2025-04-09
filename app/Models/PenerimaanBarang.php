<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang';
    protected $fillable = ['id_supplier', 'id_produk', 'id_varian', 'qty', 'harga_beli', 'user_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function varian()
    {
        return $this->belongsTo(ProdukVarian::class, 'id_varian');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}