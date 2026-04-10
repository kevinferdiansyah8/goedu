<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('keterangan');
            $table->enum('jenis', ['Masuk', 'Keluar']);
            $table->integer('nominal');
            $table->string('metode')->nullable();
            $table->string('bukti')->nullable();
            $table->string('status')->default('Terverifikasi');
            $table->nullableMorphs('transactionable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
