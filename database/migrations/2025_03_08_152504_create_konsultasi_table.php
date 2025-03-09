<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwal_dokter')->onDelete('cascade');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('konsultasi');
    }
};
