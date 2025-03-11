<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->string('periode');
            $table->integer('jumlah_pasien');
            $table->decimal('pendapatan', 15, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('laporan');
    }
};
