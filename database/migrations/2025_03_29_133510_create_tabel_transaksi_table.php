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
        Schema::create('tabel_transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi'); 
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tabel_pelanggan')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('total_harga', 10, 2);
            $table->string('status', 50);
            $table->enum('metode_pembayaran', ['transfer', 'cod']);
            $table->datetime('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_transaksis');
    }
};
