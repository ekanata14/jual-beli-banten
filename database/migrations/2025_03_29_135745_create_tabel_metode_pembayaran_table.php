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
        Schema::create('tabel_metode_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id_metode');
            $table->string('nama_metode', 50);
            $table->string('tipe', 50);
            $table->string('kode', 50);
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_metode_pembayarans');
    }
};
