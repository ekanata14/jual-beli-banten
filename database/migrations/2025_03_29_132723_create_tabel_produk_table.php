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
        Schema::create('tabel_produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->unsignedBigInteger('id_penjual');
            $table->foreign('id_penjual')->references('id_penjual')->on('tabel_penjual')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_produk', 100);
            $table->text('deskripsi_produk');
            $table->decimal('harga',10,2);
            $table->integer('stok');
            $table->string('kategori', 50);
            $table->string('foto', 255);
            $table->integer('berat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_produks');
    }
};
