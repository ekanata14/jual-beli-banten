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

        Schema::create('tabel_ulasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->foreign('id_transaksi')->references('id')->on('tabel_transaksi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->foreign('id_produk')->references('id')->on('tabel_produk')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_order')->nullable();
            $table->foreign('id_order')->references('id')->on('tabel_order')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('deskripsi_ulasan');
            $table->integer('rating');
            $table->softDeletesTz('deleted_at', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_ulasan');
    }
};
