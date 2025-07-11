<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Ulasan;

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
            "name" => "Owner",
            "email" => "owner@bhakti.com",
            "password" => bcrypt("owner"),
            "role" => "owner"
        ]);

        User::create([
            "name" => "Admin",
            "email" => "admin@bhakti.com",
            "password" => bcrypt("admin"),
            "role" => "admin"
        ]);

        // Penjual 1
        $penjual1 = User::create([
            "name" => "Dagang Canang Mamak Putu",
            "email" => "mamakputu@gmail.com",
            "password" => bcrypt("mamakputu123"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual1->id,
            "alamat_penjual" => "Jl. Puputan No.38, Semarapura Kangin, Klungkung",
            'latitude' => -8.540172413961283,
            'longitude' => 115.40275130985128,
            "kode_pos" => "80761",
            "no_telp" => "085847596995"
        ]);

        $products = [
            [
                "nama_produk" => "Canang Sari",
                "deskripsi_produk" => "Canang Sari adalah persembahan harian umat Hindu yang berisi janur, bunga, dan unsur simbolik. Digunakan untuk persembahyangan di rumah, pura, atau tempat kerja. Sebaiknya digunakan dalam 1 hari karena mudah layu.",
                "harga" => 2000,
                "stok" => 500,
                "berat" => 20,
                "kategori" => "Persembahan Harian",
                "foto" => "assets/images/Canang sari.png"
            ],
            [
                "nama_produk" => "Banten Pejati",
                "deskripsi_produk" => "Banten Pejati adalah banten utama yang berisi lauk-pauk, kue, dan buah sebagai simbol persembahan utama kepada Tuhan. Digunakan dalam upacara besar seperti odalan atau piodalan. Daya tahan 1 hari karena terdiri dari bahan makanan segar.",
                "harga" => 85000,
                "stok" => 50,
                "berat" => 1000,
                "kategori" => "Upacara Besar",
                "foto" => "assets/images/Banten Pejati.png"
            ],
            [
                "nama_produk" => "Banten Prasista",
                "deskripsi_produk" => "Banten Prasista adalah sarana upakara pendukung dalam berbagai jenis upacara seperti potong gigi atau manusa yadnya. Digunakan untuk melengkapi pelaksanaan yadnya. Tahan 1 hari karena mengandung bahan segar.",
                "harga" => 45000,
                "stok" => 30,
                "berat" => 800,
                "kategori" => "Upacara Manusa Yadnya",
                "foto" => "assets/images/Banten Prasista.png"
            ],
            [
                "nama_produk" => "Dupa",
                "deskripsi_produk" => "Dupa adalah batang harum yang dibakar sebagai simbol pemanggilan roh suci dan pembersihan spiritual. Digunakan saat sembahyang dan ritual. Tidak memiliki masa expired jika disimpan kering.",
                "harga" => 10000,
                "stok" => 200,
                "berat" => 150,
                "kategori" => "Pelengkap Persembahan",
                "foto" => "assets/images/Dupa.png"
            ],
            [
                "nama_produk" => "Banten Oton Tumpeng 7",
                "deskripsi_produk" => "Banten Oton Tumpeng 7 adalah banten khusus untuk otonan (peringatan kelahiran) dengan 7 tumpeng sebagai simbol umur dan doa keselamatan. Digunakan pada upacara otonan. Masa tahan 1 hari.",
                "harga" => 90000,
                "stok" => 20,
                "berat" => 1200,
                "kategori" => "Upacara Otonan",
                "foto" => "assets/images/Banten Oton Tumpeng 7.png"
            ],
            [
                "nama_produk" => "Sorohan Tumpek Landep",
                "deskripsi_produk" => "Sorohan Tumpek Landep adalah banten yang digunakan untuk menghaturkan syukur atas benda tajam dan ilmu pengetahuan. Dipakai saat upacara Tumpek Landep. Daya tahan 1 hari karena komponen utamanya segar.",
                "harga" => 60000,
                "stok" => 25,
                "berat" => 1000,
                "kategori" => "Hari Raya Khusus",
                "foto" => "assets/images/Sorohan Tumpek Landep.png"
            ],
            [
                "nama_produk" => "Sodan",
                "deskripsi_produk" => "Sodan adalah banten kecil yang biasanya digunakan dalam persembahyangan harian atau pelengkap yadnya kecil. Dibakar bersama dupa untuk menyampaikan doa. Sebaiknya digunakan dalam 1 hari.",
                "harga" => 5000,
                "stok" => 100,
                "berat" => 100,
                "kategori" => "Persembahan Harian",
                "foto" => "assets/images/Sodan.png"
            ],
            [
                "nama_produk" => "Daksina Hias",
                "deskripsi_produk" => "Daksina Hias adalah banten simbolik berisi janur, bunga, dan sesajen yang disusun indah. Digunakan untuk upacara besar dan seremonial. Bertahan 1 hari, tergantung kondisi suhu ruangan.",
                "harga" => 75000,
                "stok" => 15,
                "berat" => 900,
                "kategori" => "Upacara Besar",
                "foto" => "assets/images/Daksina Hias.png"
            ],
            [
                "nama_produk" => "Paket Persembahyangan",
                "deskripsi_produk" => "Paket Persembahyangan adalah kombinasi canang, dupa, sodan, dan air suci dalam satu paket. Cocok untuk persembahyangan harian di rumah. Sebaiknya digunakan dalam 1 hari untuk kesegaran bahan.",
                "harga" => 20000,
                "stok" => 100,
                "berat" => 300,
                "kategori" => "Paket Hemat",
                "foto" => "assets/images/Paket Persembahyangan.png"
            ],
        ];

        // Penjual 1 dapat semua produk
        foreach ($products as $product) {
            Produk::create([
                "id_user" => $penjual1->id,
                "nama_produk" => $product["nama_produk"],
                "deskripsi_produk" => $product["deskripsi_produk"],
                "harga" => $product["harga"],
                "stok" => $product["stok"],
                "berat" => $product["berat"],
                "kategori" => $product["kategori"],
                "foto" => $product["foto"]
            ]);
        }

        // Penjual 2 dapat 3 produk pertama
        $penjual2 = User::create([
            "name" => "Jual Canang Banten milik Jero Darmika",
            "email" => "jerodarmika@gmail.com",
            "password" => bcrypt("jerodarmika123"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual2->id,
            "alamat_penjual" => "Jl. Gandapura IV A No.19, Kesiman Kertalangu, Denpasar Timur",
            'latitude' => -8.645650318632827,
            'longitude' => 115.25260766115304,
            "kode_pos" => "80237",
            "no_telp" => "082340041818"
        ]);

        foreach (array_slice($products, 0, 3) as $product) {
            Produk::create([
                "id_user" => $penjual2->id,
                "nama_produk" => $product["nama_produk"],
                "deskripsi_produk" => $product["deskripsi_produk"],
                "harga" => $product["harga"],
                "stok" => $product["stok"],
                "berat" => $product["berat"],
                "kategori" => $product["kategori"],
                "foto" => $product["foto"]
            ]);
        }

        // Penjual 3 dapat produk ke-4 sampai ke-6
        $penjual3 = User::create([
            "name" => "UD. Ayunda Lestari",
            "email" => "ayundalestari@gmail.com",
            "password" => bcrypt("ayundalestari123"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual3->id,
            "alamat_penjual" => "Jl. Raya Selumbung, Selumbung, Manggis",
            'latitude' => -8.47920998672976,
            'longitude' => 115.5355889106258,
            "kode_pos" => "80871",
            "no_telp" => "085333573600"
        ]);

        foreach (array_slice($products, 3, 3) as $product) {
            Produk::create([
                "id_user" => $penjual3->id,
                "nama_produk" => $product["nama_produk"],
                "deskripsi_produk" => $product["deskripsi_produk"],
                "harga" => $product["harga"],
                "stok" => $product["stok"],
                "berat" => $product["berat"],
                "kategori" => $product["kategori"],
                "foto" => $product["foto"]
            ]);
        }

        // Penjual 4 dapat produk ke-7 sampai ke-9
        $penjual4 = User::create([
            "name" => "Dagang Banten Yadnya Rahayu",
            "email" => "yadnyarahayu@gmail.com",
            "password" => bcrypt("yadnyarahayu123"),
            "role" => "penjual"
        ]);

        Penjual::create([
            "id_user" => $penjual4->id,
            "alamat_penjual" => "Jl. Batuyang Batubulan No. 44x, Batubulan",
            'latitude' => -8.628289123758945,
            'longitude' => 115.25909092676265,
            "kode_pos" => "80582",
            "no_telp" => "081236163676"
        ]);

        foreach (array_slice($products, 6, 3) as $product) {
            Produk::create([
                "id_user" => $penjual4->id,
                "nama_produk" => $product["nama_produk"],
                "deskripsi_produk" => $product["deskripsi_produk"],
                "harga" => $product["harga"],
                "stok" => $product["stok"],
                "berat" => $product["berat"],
                "kategori" => $product["kategori"],
                "foto" => $product["foto"]
            ]);
        }

        // Pelanggan
        $pelanggan = User::create([
            "name" => "Made Suriasih",
            "email" => "pelanggan_1@pelanggan.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);

        Pelanggan::create([
            "id_user" => $pelanggan->id,
            "alamat_pelanggan" => "Jl. mawar gg.melati no.20",
            "kode_pos" => "80227",
            "no_telp" => "081234567890",
        ]);

        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 1,
            'id_order' => null,
            'id_user' => $pelanggan->id,
            'deskripsi_ulasan' => 'Produk sangat bagus dan sesuai deskripsi. Pengiriman cepat!',
            'rating' => 5,
            'deleted_at' => null,
        ]);

        $pelanggan2 = User::create([
            "name" => "Agung Suadnyana",
            "email" => "pelanggan_2@pelanggan.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);

        Pelanggan::create([
            "id_user" => $pelanggan2->id,
            "alamat_pelanggan" => "Jl. mawar gg.melati no.20",
            "kode_pos" => "80227",
            "no_telp" => "081234567890",
        ]);


        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 2,
            'id_order' => null,
            'id_user' => $pelanggan2->id,
            'deskripsi_ulasan' => 'Kualitas produk baik, sangat bagus.',
            'rating' => 4,
            'deleted_at' => null,
        ]);

        $pelanggan3 = User::create([
            "name" => "Nyoman Sri Utami",
            "email" => "pelanggan_3@pelanggan.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);

        Pelanggan::create([
            "id_user" => $pelanggan3->id,
            "alamat_pelanggan" => "Jl. mawar gg.melati no.20",
            "kode_pos" => "80227",
            "no_telp" => "081234567890",
        ]);

        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 3,
            'id_order' => null,
            'id_user' => $pelanggan3->id,
            'deskripsi_ulasan' => 'Produk sesuai pesanan, pelayanan ramah.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
    }
}