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
        Schema::create('tabel_pengiriman', function (Blueprint $table) {
            $table->bigIncrements('id_pengiriman');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('tabel_transaksi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_order');
            $table->foreign('id_order')->references('id_order')->on('tabel_order')->onUpdate('cascade')->onDelete('cascade');e('cascade');
            $table->unsignedBigInteger('id_kurir');
            $table->foreign('id_kurir')->references('id_kurir')->on('tabel_kurir')->onUpdate('cascade')->onDelete('cascade');
            $table->string('no_resi', 250);
            $table->string('nama_penerima', 250);
            $table->string('alamat_penerima', 250);
            $table->string('telp_penerima');
            $table->string('status_pengiriman', 250);
            $table->datetime('waktu_pengiriman');
            $table->integer('biaya_pengiriman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_pengirimen');
    }
};
