<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

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

        $response = $this->withoutMiddleware()->post('/kategori', $data);

        $response->assertStatus(302);

        $this->assertDatabaseHas('kategori', $data);
    }
}