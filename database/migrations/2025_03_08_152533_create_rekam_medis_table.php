<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->text('diagnosis');
            $table->text('tindakan');
            $table->text('obat');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('rekam_medis');
    }
};
