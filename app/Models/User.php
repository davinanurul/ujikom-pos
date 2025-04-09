<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_nama',
        'user_pass',
        'user_hak',
        'user_sts',
    ];

    protected $primaryKey = 'user_id';    // Tentukan kolom primary key jika berbeda dari 'id'

    public function getAuthIdentifierName()
    {
        return 'user_id';  // Pastikan sesuai dengan kolom ID di tabel Anda
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;  // Kolom ID yang digunakan untuk autentikasi
    }

    public function getAuthPassword()
    {
        return $this->user_pass;  // Kolom password yang digunakan
    }

    protected $rememberTokenName = 'remember_token';
}
