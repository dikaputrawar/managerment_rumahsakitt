<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntreanTable extends Migration
{
public function up(): void
{
    Schema::create('antrean', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pasien_id');
        $table->string('nomor_antrean');
        $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'batal'])->default('menunggu');
        $table->date('tanggal');
        $table->timestamps();

        $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
    });
}
}
