<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id('dokter_id'); // Primary key dengan auto-increment
            $table->string('nama', 100);
            $table->string('spesialisasi', 100);
            $table->string('no_telepon', 20);
            $table->string('email', 100)->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('dokter');
    }
};
