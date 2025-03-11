<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
               // Tabel Pasien
               Schema::create('pasien', function (Blueprint $table) {
                $table->id('pasien_id');
                $table->string('nama', 100);
                $table->date('tanggal_lahir');
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
                $table->text('alamat');
                $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('pasien');
    }
};
