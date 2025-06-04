@extends('layouts.landing')
@section('content')
    <section class="about_hero hero flex w-full justify-start items-end h-[100vh]">
            <div class="home_hero_content py-9 px-10">
                <p class="sub-heading text-white">Harmoni Tradisi dan Teknologi</p>
                <h1 class="text-white">Sarana Upacara Hindu yang<br> Mudah & Praktis</h1>
                <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                    Lihat Semua Produk
                </x-button>
            </div>
    </section>
    <section class="about_content w-full py-28 px-24 flex flex-col justify-center items-center gap-20">
        <div class="about_content_desc">
            <p class="sub-heading">Tentang Kami</p>
            <h2 class="w-95 text-black">Menghadirkan Sarana Upacara dengan Ketulusan</h2>
                <div class="desc_wrapper flex gap-4 mt-16">
                    <p>Kami berdedikasi untuk menyediakan berbagai perlengkapan upacara Hindu yang otentik dan berkualitas. Dengan pengalaman dalam menyediakan banten dan sarana upacara, kami memastikan setiap produk dibuat dengan penuh ketulusan dan mengikuti tradisi yang diwariskan turun-temurun.</p>
                    <p>Sejak berdiri, kami telah membantu banyak umat Hindu dalam mendapatkan sarana upacara yang autentik dan berkualitas. Kami bekerja sama dengan pengrajin dan produsen lokal untuk memastikan setiap produk dibuat dengan standar terbaik. Dengan layanan yang terus berkembang, kami berkomitmen untuk memberikan pengalaman berbelanja yang mudah, cepat, dan nyaman.</p>
                </div>
        </div>
        <div class="about_image w-[100vw] h-[561px]"></div>
        <div class="about_services_section w-full">
            <h2 class="w-95 text-black">Mengapa Memilih Kami?</h2>
            <div class="about_service_card_wrapper flex gap-5 mt-9">
                <div class="about_service_card_item flex flex-col w-100 p-5 items-start justify-between rounded-md h-64">
                    <p>01</p>
                    <p>Beragam Pilihan Banten: Mulai dari banten harian hingga upacara besar tersedia dalam satu platform.</p>
                </div>
                <div class="about_service_card_item flex flex-col w-100 p-5 items-start justify-between rounded-md h-64">
                    <p>02</p>
                    <p>Kualitas Terbaik: Setiap produk dibuat dengan bahan berkualitas tinggi oleh pengrajin berpengalaman</p>
                </div>
                <div class="about_service_card_item flex flex-col w-100 p-5 items-start justify-between rounded-md h-64">
                    <p>03</p>
                    <p>Pesan dengan Mudah: Proses pencarian, pemesanan, dan pembayaran yang sederhana dan cepat.</p>
                </div>
                <div class="about_service_card_item flex flex-col w-100 p-5 items-start justify-between rounded-md h-64">
                    <p>04</p>
                    <p>Pelestarian Budaya: Mendukung tradisi Bali dengan pendekatan modern yang praktis.</p>
                </div>
            </div>
        </div>
    </section>
@endsection