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
        Schema::create('tabel_kurir', function (Blueprint $table) {
            $table->bigIncrements('id_kurir');
            $table->string('kode_kurir', 250);
            $table->string('nama_kurir', 250);
            $table->string('kode_servis', 250);
            $table->string('nama_servis', 250);
            $table->string('rentan_durasi', 250);
            $table->string('unit_durasi', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_kurirs');
    }
};
