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

        $penjual1 = User::create([
            "name" => "Penjual 1",
            "email" => "penjual_1@penjual.com",
            "password" => bcrypt("penjual"),
            "role" => "penjual"
        ]);

        // Penjual 1
        Penjual::create([
            "id_user" => $penjual1->id,
            "alamat_penjual" => "Jl. Penjual 1",
            'latitude' => -8.650925521554344,
            'longitude' => 115.2087778064643,
            "kode_pos" => "80226",
            "no_telp" => "081234567890"
        ]);

        $categories = ['Pejati', 'Prasista', 'Beakaon', 'Penyeneng', 'Pras Pengambaian'];

        // Produk Penjual 1 (10 items, 2 per category)
        for ($i = 1; $i <= 10; $i++) {
            $category = $categories[($i - 1) % count($categories)];
            Produk::create([
                "id_user" => $penjual1->id,
                "nama_produk" => "Banten $category",
                "deskripsi_produk" => "Deskripsi Produk Banten $category",
                "harga" => 100000 * $i,
                "stok" => 10 * $i,
                "berat" => 500 + ($i * 50),
                "kategori" => $category,
                "foto" => "produk/produk1_$i.jpg",
            ]);
        }

        // Penjual 2
        $penjual2 = User::create([
            "name" => "Penjual 2",
            "email" => "penjual_2@penjual.com",
            "password" => bcrypt("penjual2"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual2->id,
            "alamat_penjual" => "Jl. Penjual 2",
            'latitude' => -8.651000,
            'longitude' => 115.209000,
            "kode_pos" => "80228",
            "no_telp" => "081234567891"
        ]);

        // Produk Penjual 2 (10 items, 2 per category, nama sesuai permintaan)
        for ($i = 1; $i <= 10; $i++) {
            $category = $categories[($i - 1) % count($categories)];
            Produk::create([
                "id_user" => $penjual2->id,
                "nama_produk" => "Banten $category",
                "deskripsi_produk" => "Deskripsi Produk Banten $category",
                "harga" => 120000 + ($i * 5000),
                "stok" => 15 + $i,
                "berat" => 300 + ($i * 30),
                "kategori" => $category,
                "foto" => "produk/produk2_$i.jpg",
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
