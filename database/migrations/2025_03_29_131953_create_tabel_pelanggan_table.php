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
        Schema::create('tabel_pelanggan', function (Blueprint $table) {
            $table->bigIncrements('id_pelanggan');
            $table->string('nama_pelanggan', 50);
            $table->text('alamat_pelanggan');
            $table->string('no_telp');
            $table->string('email', 50);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_pelanggans');
    }
};
