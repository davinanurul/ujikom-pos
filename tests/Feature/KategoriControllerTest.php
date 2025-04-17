<?php

namespace Tests\Feature;

use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KategoriControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreSuccesfully()
    {
        $user = User::create([
            'user_nama' => 'owner',
            'user_pass' => bcrypt('owner'),
            'user_hak' => 'owner',
        ]);

        $this->actingAs($user);

        $data = [
            'nama_kategori' => 'Test Kategori',
        ];

        $response = $this->withoutMiddleware()->post('/kategori/store', $data);

        $response->assertStatus(302);

        $this->assertDatabaseHas('kategori', $data);
    }

    public function testIndexKategori()
    {
        $user = User::create([
            'user_nama' => 'owner',
            'user_pass' => bcrypt('owner'),
            'user_hak' => 'owner',
        ]);

        $this->actingAs($user);

        // Buat data kategori dummy
        Kategori::create(['nama_kategori' => 'Kategori A']);
        Kategori::create(['nama_kategori' => 'Kategori B']);

        // Kirim request GET ke halaman index
        $response = $this->withoutMiddleware()->get('/kategori');

        $response->assertStatus(200);
        $response->assertSee('Kategori A');
        $response->assertSee('Kategori B');
    }


    public function testUpdateSuccessfully()
    {
        $user = User::create([
            'user_nama' => 'owner',
            'user_pass' => bcrypt('owner'),
            'user_hak' => 'owner',
        ]);

        $this->actingAs($user);

        // Simpan kategori awal
        $kategori = DB::table('kategori')->insertGetId([
            'nama_kategori' => 'Kategori Lama',
        ]);

        $updatedData = [
            'nama_kategori' => 'Kategori Baru',
        ];

        $response = $this->withoutMiddleware()->put("/kategori/{$kategori}", $updatedData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('kategori', [
            'id' => $kategori,
            'nama_kategori' => 'Kategori Baru',
        ]);
    }
}
