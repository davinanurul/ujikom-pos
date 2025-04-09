<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = ['user_id', 'kategori_id', 'supplier_id', 'kode', 'nama', 'gambar',];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function varian()
    {
        return $this->hasMany(ProdukVarian::class, 'id_produk', 'id');
    }

    public static function generateKodeBarang()
    {
        $currentYear = Carbon::now()->format('Y');
        $prefix = 'CLTH' . $currentYear;

        // Ambil kode barang terakhir yang dimulai dengan prefix
        $lastKode = self::where('kode', 'like', "$prefix%")
            ->orderBy('kode', 'desc')
            ->value('kode');

        if ($lastKode) {
            // Ambil nomor urut terakhir dari kode barang
            $lastNumber = (int)substr($lastKode, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada kode barang di tahun ini
            $newNumber = 1;
        }

        // Format nomor urut menjadi 4 digit
        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Gabungkan prefix dengan nomor urut baru
        return $prefix . $formattedNumber;
    }
}
