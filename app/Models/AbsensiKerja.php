<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiKerja extends Model
{
    protected $table = 'tbl_absen_kerja';

    protected $fillable = [
        'nama_karyawan',
        'tanggal_masuk',
        'waktu_masuk',
        'status_masuk',
        'waktu_selesai_kerja',
    ];

    public function selesaiKerjaSekarang()
    {
        $this->update(['waktu_selesai_kerja' => now()->format('H:i:s')]);
    }
}
