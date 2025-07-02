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
        Schema::create('tabel_admin', function (Blueprint $table) {
            $table->bigIncrements('id_admin');
            $table->string('nama', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 255);
            $table->timestamps();
            $table->softDeletesTz('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_admins');
    }
};
