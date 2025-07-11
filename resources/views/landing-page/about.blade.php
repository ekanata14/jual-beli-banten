@extends('layouts.landing')
@section('content')
<section class="home_hero hero flex w-full justify-start items-end h-[100vh]" data-aos="fade-up" data-aos-delay="100"
    style="background-image: url('{{ asset('assets/images/about_hero_img.jpg') }}');">
    <div class="home_hero_content py-9 px-10 w-full md:w-1/2" data-aos="fade-right" data-aos-delay="300">
        <h1 class="text-white" data-aos="zoom-in" data-aos-delay="700">Melayani Kebutuhan Banten Modern dengan Sentuhan
            Tradisi
        </h1>
        <x-button class="mt-5" href="{{ route('product') }}" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
            data-aos="fade-up" data-aos-delay="900">
            Belanja Sekarang
        </x-button>
    </div>
</section>

<section
    class="about_content w-full py-16 md:py-28 px-4 md:px-24 flex flex-col justify-center items-center gap-12 md:gap-20"
    data-aos="fade-up">
    <div class="about_content_desc w-full max-w-5xl" data-aos="fade-up" data-aos-delay="100">
        <p class="sub-heading">Tentang Kami</p>
        <h2 class="w-full md:w-11/12 text-black">Menghadirkan Sarana Upacara dengan Ketulusan</h2>
        <div class="desc_wrapper flex flex-col md:flex-row gap-4 mt-8 md:mt-16">
            <p class="w-full md:w-1/2">Kami berdedikasi untuk menyediakan berbagai perlengkapan upacara Hindu yang
                otentik dan berkualitas. Dengan pengalaman dalam menyediakan banten dan sarana upacara, kami memastikan
                setiap produk dibuat dengan penuh ketulusan dan mengikuti tradisi yang diwariskan turun-temurun.</p>
            <p class="w-full md:w-1/2">Sejak berdiri, kami telah membantu banyak umat Hindu dalam mendapatkan sarana
                upacara yang autentik dan berkualitas. Kami bekerja sama dengan pengrajin dan produsen lokal untuk
                memastikan setiap produk dibuat dengan standar terbaik. Dengan layanan yang terus berkembang, kami
                berkomitmen untuk memberikan pengalaman berbelanja yang mudah, cepat, dan nyaman.</p>
        </div>
    </div>
    <div class="about_image w-screen max-w-none h-56 md:h-[561px] bg-cover bg-center" data-aos="zoom-in"
        data-aos-delay="200"></div>
    <div class="about_services_section w-full max-w-5xl" data-aos="fade-up" data-aos-delay="300">
        <h2 class="w-full md:w-11/12 text-black">Mengapa Memilih Kami?</h2>
        <div class="about_service_card_wrapper flex flex-col md:flex-row gap-5 mt-6 md:mt-9">
            <div class="about_service_card_item flex flex-col w-full md:w-1/4 p-5 items-start justify-between rounded-md h-48 md:h-64 bg-white shadow"
                data-aos="fade-up" data-aos-delay="400">
                <p class="font-bold text-lg mb-2">01</p>
                <p>Beragam Pilihan Banten: Mulai dari banten harian hingga upacara besar tersedia dalam satu platform.
                </p>
            </div>
            <div class="about_service_card_item flex flex-col w-full md:w-1/4 p-5 items-start justify-between rounded-md h-48 md:h-64 bg-white shadow"
                data-aos="fade-up" data-aos-delay="500">
                <p class="font-bold text-lg mb-2">02</p>
                <p>Kualitas Terbaik: Setiap produk dibuat dengan bahan berkualitas tinggi oleh pengrajin berpengalaman
                </p>
            </div>
            <div class="about_service_card_item flex flex-col w-full md:w-1/4 p-5 items-start justify-between rounded-md h-48 md:h-64 bg-white shadow"
                data-aos="fade-up" data-aos-delay="600">
                <p class="font-bold text-lg mb-2">03</p>
                <p>Pesan dengan Mudah: Proses pencarian, pemesanan, dan pembayaran yang sederhana dan cepat.</p>
            </div>
            <div class="about_service_card_item flex flex-col w-full md:w-1/4 p-5 items-start justify-between rounded-md h-48 md:h-64 bg-white shadow"
                data-aos="fade-up" data-aos-delay="700">
                <p class="font-bold text-lg mb-2">04</p>
                <p>Pelestarian Budaya: Mendukung tradisi Bali dengan pendekatan modern yang praktis.</p>
            </div>
        </div>
    </div>
</section>
@endsection