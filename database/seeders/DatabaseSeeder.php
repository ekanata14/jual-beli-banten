<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Pelanggan;
use App\Models\Produk;

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

        User::create([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => bcrypt("admin"),
            "role" => "admin"
        ]);

        $penjual = User::create([
            "name" => "Penjual 1",
            "email" => "penjual_1@penjual.com",
            "password" => bcrypt("penjual"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual->id,
            "alamat_penjual" => "Jl. Penjual 1",
            "kode_pos" => "80226",
            "no_telp" => "081234567890"
        ]);
        for ($i = 1; $i <= 8; $i++) {
            Produk::create([
                "id_user" => $penjual->id,
                "nama_produk" => "Produk $i",
                "deskripsi_produk" => "Deskripsi Produk $i",
                "harga" => 100000 * $i,
                "stok" => 10 * $i,
                "berat" => 1000,
                "kategori" => "Upacara",
                "foto" => "produk/produk.jpg",
            ]);
        }

        $pelanggan = User::create([
            "name" => "Pelanggan 1",
            "email" => "pelanggan_1@pelanggan.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);

        Pelanggan::create([
            "id_user" => $pelanggan->id,
            "alamat_pelanggan" => "Jl. Pelanggan 1",
            "kode_pos" => "80227",
            "no_telp" => "081234567890",
        ]);
    }
}
