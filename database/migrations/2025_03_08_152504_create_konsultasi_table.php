<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('konsultasi_id'); // Primary key dengan auto-increment
            $table->unsignedBigInteger('pasien_id'); // Foreign key ke tabel pasien
            $table->unsignedBigInteger('dokter_id'); // Foreign key ke tabel dokter
            $table->unsignedBigInteger('jadwal_id'); // Foreign key ke tabel jadwal_dokter
            $table->date('tanggal_konsultasi');
            $table->enum('status', ['Dijadwalkan', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pasien_id')->references('pasien_id')->on('pasien')->onDelete('cascade');
            $table->foreign('dokter_id')->references('dokter_id')->on('dokter')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal_dokter')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('konsultasi');
    }
};
