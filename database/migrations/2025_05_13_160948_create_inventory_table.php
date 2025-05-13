<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('inventory_id');
            $table->string('nama_obat');
            $table->enum('kategori', ['Tablet', 'Syrup', 'Capsule', 'Injection']);
            $table->integer('stok');
            $table->decimal('harga', 10, 2);
            $table->date('exp_date');
            $table->timestamps(); // untuk created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
}
