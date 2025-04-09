<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'nomor_transaksi',
        'tanggal',
        'user_id',
        'member_id',
        'total',
        'pembayaran'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id');
    }

    public static function generateNomorTransaksi()
    {
        $date = now()->format('Ymd');
        $latestNumber = DB::table('transaksi')
            ->whereDate('created_at', now())
            ->max('nomor_transaksi');

        if ($latestNumber) {
            $lastNumber = (int) substr($latestNumber, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return 'TRX-' . $date . '-' . $nextNumber;
    }

    public static function getTransaksiHarian()
    {
        return DB::table('transaksi')
            ->select(
                DB::raw('DATE(tanggal) as tanggal'), // Ambil tanggal saja (tanpa waktu)
                DB::raw('COUNT(id) as jumlah_transaksi'), // Hitung jumlah transaksi
                DB::raw('SUM(total) as total_pendapatan') // Hitung total pendapatan
            )
            ->groupBy('tanggal') // Kelompokkan berdasarkan tanggal
            ->orderBy('tanggal', 'asc') // Urutkan berdasarkan tanggal
            ->get();
    }
}
