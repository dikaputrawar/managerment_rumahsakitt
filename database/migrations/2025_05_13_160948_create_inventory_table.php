<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigIncrements('inventory_id');
            $table->string('nama_obat')->unique();
            $table->enum('kategori', ['Tablet', 'Syrup', 'Capsule', 'Injection']);
            $table->unsignedInteger('stok')->default(0);
            $table->decimal('harga', 10, 2)->unsigned();
            $table->date('exp_date');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
