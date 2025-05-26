<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengambilan_obat', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->foreignId('pasien_id')
                  ->constrained('pasien')
                  ->onDelete('cascade'); // Hapus otomatis jika pasien dihapus
            $table->date('tanggal_pengambilan');
            $table->string('obat');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengambilan_obat');
    }
};
