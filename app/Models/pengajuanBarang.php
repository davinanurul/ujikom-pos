<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengajuanBarang extends Model
{
    protected $table = 'pengajuan_barang';

    protected $fillable = [
        'nama_pengaju',
        'nama_barang',
        'tanggal_pengajuan',
        'qty',
        'terpenuhi'
    ];

    protected $casts = [
        'terpenuhi' => 'boolean',
    ];

    // Set default tanggal_pengajuan to now if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tanggal_pengajuan)) {
                $model->tanggal_pengajuan = now()->format('Y-m-d');
            }
        });
    }

    public static function getDataPengajuan()
    {
        return DB::table('pengajuan_barang')
            ->select(
                DB::raw('COUNT(*) as total'),
                'terpenuhi'
            )
            ->groupBy('terpenuhi')
            ->get();
    }
}
