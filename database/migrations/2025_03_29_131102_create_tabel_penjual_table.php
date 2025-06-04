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
        Schema::create('tabel_penjual', function (Blueprint $table) {
            $table->bigIncrements('id_penjual');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_admin')->on('tabel_admin')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_penjual', 50);
            $table->text('alamat_penjual');
            $table->string('no_telp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_penjuals');
    }
};
