<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // $this->call([KategoriSeeder::class]);
        // Produk::factory()->count(50)->create();

        DB::table('users')->insert([
            [
                'user_nama' => 'admin',
                'user_pass' => Hash::make('admin'),
                'user_hak' => 'admin',
                'user_sts' => '1'
            ],
        ]);
    }
}
