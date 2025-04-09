<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanBarangTable extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengaju');
            $table->string('nama_barang');
            $table->date('tanggal_pengajuan');
            $table->integer('qty');
            $table->boolean('terpenuhi')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_barang');
    }
}