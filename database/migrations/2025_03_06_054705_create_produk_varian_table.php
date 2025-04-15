<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produk_varian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade'); // Relasi dengan tabel produk
            $table->string('size', 10); // Menyimpan size varian (misal: S, M, L, XL)
            $table->string('warna', 50); // Menyimpan warna varian
            $table->integer('stok')->default(0); // Menyimpan jumlah stok varian
            $table->bigInteger('harga_jual'); // Menyimpan harga jual varian
            $table->string('sku')->unique(); // Menyimpan SKU yang unik berdasarkan kombinasi produk, warna, dan size
            $table->timestamps(); // Timestamp untuk created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_varian');
    }
};
