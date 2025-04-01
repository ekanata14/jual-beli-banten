<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Pelanggan;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Admin::create([
            "nama" => "Admin",
            "email" => "admin@admin.com",
            "password" => bcrypt("admin"),
            "role" => "admin"
        ]);

        $penjual = Admin::create([
            "nama" => "Penjual 1",
            "email" => "penjual_1@penjual.com",
            "password" => bcrypt("penjual"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_admin" => $penjual->id_admin,
            "nama_penjual" => "Penjual 1",
            "alamat_penjual" => "Jl. Penjual 1",
            "no_telp" => "081234567890"
        ]);

        Pelanggan::create([
            "nama_pelanggan" => "Pelanggan 1",
            "alamat_pelanggan" => "Jl. Pelanggan 1",
            "no_telp" => "081234567890",
            "email" => "pelanggan_1@pelanggan.com",
            "password" => bcrypt("pelanggan")
        ]);
    }
}
