<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengambilanObatTable extends Migration
{
    public function up(): void
    {
        Schema::create('obat_pengambilan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('inventory_id');
            $table->integer('jumlah');
            $table->date('tanggal_ambil');
            $table->enum('status', ['Diambil', 'Belum']);
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat_pengambilan');
    }
}
