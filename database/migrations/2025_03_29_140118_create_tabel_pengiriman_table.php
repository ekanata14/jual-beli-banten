<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tabel_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id')->on('tabel_transaksi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_order');
            $table->foreign('id_order')->references('id')->on('tabel_order')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_kurir')->nullable();
            $table->foreign('id_kurir')->references('id')->on('tabel_kurir')->onUpdate('cascade')->onDelete('cascade');
            $table->string('no_resi', 250)->nullable();
            $table->string('biteship_order_id', 250)->nullable();
            $table->string('nama_penerima', 250);
            $table->string('alamat_penerima', 250);
            $table->string('latitude_penerima', 250)->nullable();
            $table->string('longitude_penerima', 250)->nullable();
            $table->string('kode_pos_penerima', 20)->nullable();
            $table->string('telp_penerima');
            $table->unsignedBigInteger('id_penjual')->nullable();
            $table->foreign('id_penjual')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('alamat_penjual', 250);
            $table->string('latitude_penjual', 250)->nullable();
            $table->string('longitude_penjual', 250)->nullable();
            $table->string('kode_pos_penjual', 20)->nullable();
            $table->string('telp_penjual', 20)->nullable();
            $table->string('status_pengiriman', 250)->default('pending');
            $table->string('waktu_pengiriman')->nullable();
            $table->integer('biaya_pengiriman')->nullable();
            $table->softDeletesTz('deleted_at', precision: 0);
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
