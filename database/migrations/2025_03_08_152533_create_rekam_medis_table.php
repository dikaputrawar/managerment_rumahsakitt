<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id('rekam_id'); // Primary key dengan auto-increment
            $table->unsignedBigInteger('pasien_id'); // Foreign key ke tabel pasien
            $table->date('tanggal_kunjungan');
            $table->text('diagnosis');
            $table->text('tindakan');
            $table->text('obat');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('pasien_id')->references('pasien_id')->on('pasien')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('rekam_medis');
    }
};
