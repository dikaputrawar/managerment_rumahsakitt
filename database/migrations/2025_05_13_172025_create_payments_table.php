<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('konsultasi_id');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->date('payment_date');
            $table->enum('method', ['Cash', 'Credit Card', 'Transfer']);
            $table->enum('status', ['Pending', 'Paid', 'Cancelled']);
            $table->timestamps();

            $table->foreign('konsultasi_id')
                ->references('konsultasi_id')
                ->on('konsultasi')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
