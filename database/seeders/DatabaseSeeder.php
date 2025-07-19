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
            "name" => "Mamak Putu (Klungkung)",
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
            "name" => "Jero Darmika (Badung)",
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
            "name" => "UD. Ayunda Lestari (Karangasem)",
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
            "name" => "Yadnya Rahayu (Gianyar)",
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
            "email" => "madesuriasih@gmail.com",
            "password" => bcrypt("pelanggan"), // Use bcrypt for bcrypt
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan->id,
            "alamat_pelanggan" => "Jl. Anggrek No. 10, Kelurahan Indah",
            "kode_pos" => "80111",
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
            "email" => "agungsuadnyana@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan2->id,
            "alamat_pelanggan" => "Jl. Mawar Gg. Tulip No. 5, Desa Harapan",
            "kode_pos" => "80222",
            "no_telp" => "081234567891",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 2,
            'id_order' => null,
            'id_user' => $pelanggan2->id,
            'deskripsi_ulasan' => 'Kualitas produk baik, sangat memuaskan.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan3 = User::create([
            "name" => "Nyoman Sri Utami",
            "email" => "utami@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan3->id,
            "alamat_pelanggan" => "Perumahan Griya Asri Blok C No. 12, Kota Damai",
            "kode_pos" => "80333",
            "no_telp" => "081234567892",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 2,
            'id_order' => null,
            'id_user' => $pelanggan3->id,
            'deskripsi_ulasan' => 'Produk sesuai pesanan, pelayanan ramah dan responsif.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan4 = User::create([
            "name" => "Adryan Wijaya",
            "email" => "adryan123@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan4->id,
            "alamat_pelanggan" => "Jl. Kenanga Raya No. 25, Kecamatan Sejahtera",
            "kode_pos" => "80444",
            "no_telp" => "08147264819",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 1,
            'id_order' => null,
            'id_user' => $pelanggan4->id,
            'deskripsi_ulasan' => 'Sangat puas dengan produknya, rekomended!',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan5 = User::create([
            "name" => "Putu Kevin",
            "email" => "kevin123@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan5->id,
            "alamat_pelanggan" => "Gg. Melati Putih No. 7, Desa Makmur",
            "kode_pos" => "80555",
            "no_telp" => "083126823910",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 5,
            'id_order' => null,
            'id_user' => $pelanggan5->id,
            'deskripsi_ulasan' => 'Barang diterima dalam kondisi baik, pengiriman lumayan cepat.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan6 = User::create([
            "name" => "Gede Nanda Wangsa",
            "email" => "nanda22@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan6->id,
            "alamat_pelanggan" => "Jl. Pahlawan No. 30, Komplek Permai",
            "kode_pos" => "80666",
            "no_telp" => "0817248572123",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 4,
            'id_order' => null,
            'id_user' => $pelanggan6->id,
            'deskripsi_ulasan' => 'Produk sesuai ekspektasi, kualitas bagus.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan7 = User::create([
            "name" => "Ida bagus surya",
            "email" => "gussurya@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan7->id,
            "alamat_pelanggan" => "Jl. Cendana No. 15, Lingkungan Hijau",
            "kode_pos" => "80777",
            "no_telp" => "08251752390572",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 6,
            'id_order' => null,
            'id_user' => $pelanggan7->id,
            'deskripsi_ulasan' => 'Pelayanan sangat baik, respons cepat.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan8 = User::create([
            "name" => "Putu Putra Denis",
            "email" => "denis@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan8->id,
            "alamat_pelanggan" => "Gg. Merpati No. 9, RT 03 RW 01, Dusun Jaya",
            "kode_pos" => "80888",
            "no_telp" => "082152123165",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 4,
            'id_order' => null,
            'id_user' => $pelanggan8->id,
            'deskripsi_ulasan' => 'Worth it dengan harganya, tidak mengecewakan.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan9 = User::create([
            "name" => "Bayu iswara mahen",
            "email" => "bayu@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan9->id,
            "alamat_pelanggan" => "Jl. Kamboja No. 22, Gang Kecil",
            "kode_pos" => "80999",
            "no_telp" => "081537249723",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 6,
            'id_order' => null,
            'id_user' => $pelanggan9->id,
            'deskripsi_ulasan' => 'Produk diterima utuh, packaging rapi.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan10 = User::create([
            "name" => "Satria Mahandika",
            "email" => "satria12@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan10->id,
            "alamat_pelanggan" => "Gg. Damai No. 8, Desa Maju",
            "kode_pos" => "80227",
            "no_telp" => "0812291835823",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 4,
            'id_order' => null,
            'id_user' => $pelanggan10->id,
            'deskripsi_ulasan' => 'Tidak mengecewakan, akan beli lagi.',
            'rating' => 4,
            'deleted_at' => null,
        ]);

        $pelanggan11 = User::create([
            "name" => "Dewi Lestari",
            "email" => "dewilestari@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan11->id,
            "alamat_pelanggan" => "Jl. Teratai No. 3, Gang Sehat",
            "kode_pos" => "80112",
            "no_telp" => "081312345678",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 3,
            'id_order' => null,
            'id_user' => $pelanggan11->id,
            'deskripsi_ulasan' => 'Produk berkualitas tinggi, sangat direkomendasikan!',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan12 = User::create([
            "name" => "Budi Santoso",
            "email" => "budisantoso@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan12->id,
            "alamat_pelanggan" => "Jl. Kutilang No. 8, Perumahan Elok",
            "kode_pos" => "80223",
            "no_telp" => "082198765432",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 7,
            'id_order' => null,
            'id_user' => $pelanggan12->id,
            'deskripsi_ulasan' => 'Pengiriman cepat dan barang sesuai gambar, top!',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan13 = User::create([
            "name" => "Citra Kirana",
            "email" => "citrakirana@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan13->id,
            "alamat_pelanggan" => "Blok A No. 1, Komplek Indah Permai",
            "kode_pos" => "80334",
            "no_telp" => "085711223344",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 1,
            'id_order' => null,
            'id_user' => $pelanggan13->id,
            'deskripsi_ulasan' => 'Sangat puas dengan pembelian ini, pelayanan ramah.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan14 = User::create([
            "name" => "Eko Prasetyo",
            "email" => "ekoprasetyo@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan14->id,
            "alamat_pelanggan" => "Gg. Mawar Merah No. 15, Desa Damai",
            "kode_pos" => "80445",
            "no_telp" => "081909876543",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 8,
            'id_order' => null,
            'id_user' => $pelanggan14->id,
            'deskripsi_ulasan' => 'Produk original dan berfungsi dengan baik.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan15 = User::create([
            "name" => "Fatimah Azzahra",
            "email" => "fatimahaz@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan15->id,
            "alamat_pelanggan" => "Jl. Nusa Indah No. 50, Kelurahan Bahagia",
            "kode_pos" => "80556",
            "no_telp" => "087856789012",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 2,
            'id_order' => null,
            'id_user' => $pelanggan15->id,
            'deskripsi_ulasan' => 'Kualitas produk sangat baik, sesuai harapan.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan16 = User::create([
            "name" => "Guntur Wijaya",
            "email" => "gunturwijaya@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan16->id,
            "alamat_pelanggan" => "Jl. Perjuangan No. 77, RT 02 RW 05",
            "kode_pos" => "80667",
            "no_telp" => "081267890123",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 6,
            'id_order' => null,
            'id_user' => $pelanggan16->id,
            'deskripsi_ulasan' => 'Produk bagus, pengemasan rapi dan aman.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan17 = User::create([
            "name" => "Hana Permata",
            "email" => "hanapermata@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan17->id,
            "alamat_pelanggan" => "Dusun Cempaka No. 40, Desa Sukamaju",
            "kode_pos" => "80778",
            "no_telp" => "085234567890",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 4,
            'id_order' => null,
            'id_user' => $pelanggan17->id,
            'deskripsi_ulasan' => 'Cepat sampai, produk sesuai dengan deskripsi.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan18 = User::create([
            "name" => "Irfan Hakim",
            "email" => "irfanhakim@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan18->id,
            "alamat_pelanggan" => "Jl. Gatot Subroto No. 99, Kecamatan Jaya",
            "kode_pos" => "80889",
            "no_telp" => "081122334455",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 5,
            'id_order' => null,
            'id_user' => $pelanggan18->id,
            'deskripsi_ulasan' => 'Produknya bagus, tidak ada cacat.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
        
        $pelanggan19 = User::create([
            "name" => "Jihan Fahira",
            "email" => "jihanfahira@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan19->id,
            "alamat_pelanggan" => "Perumahan Hijau Asri Blok B No. 20",
            "kode_pos" => "80990",
            "no_telp" => "089677889900",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 3,
            'id_order' => null,
            'id_user' => $pelanggan19->id,
            'deskripsi_ulasan' => 'Sangat puas, produknya melebihi ekspektasi.',
            'rating' => 5,
            'deleted_at' => null,
        ]);
        
        $pelanggan20 = User::create([
            "name" => "Kevin Sanjaya",
            "email" => "kevinsanjaya@gmail.com",
            "password" => bcrypt("pelanggan"),
            "role" => "pelanggan"
        ]);
        
        Pelanggan::create([
            "id_user" => $pelanggan20->id,
            "alamat_pelanggan" => "Jl. Damai Sejahtera No. 1, Kota Mandiri",
            "kode_pos" => "80100",
            "no_telp" => "081345678901",
        ]);
        
        Ulasan::create([
            'id_transaksi' => null,
            'id_produk' => 7,
            'id_order' => null,
            'id_user' => $pelanggan20->id,
            'deskripsi_ulasan' => 'Produknya oke, sesuai dengan harga.',
            'rating' => 4,
            'deleted_at' => null,
        ]);
    }
}