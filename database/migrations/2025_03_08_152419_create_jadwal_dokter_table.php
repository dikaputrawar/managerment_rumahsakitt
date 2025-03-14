<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id('jadwal_id'); 
            $table->unsignedBigInteger('dokter_id'); 
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('dokter_id')->references('dokter_id')->on('dokter')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('jadwal_dokter');
    }
};
