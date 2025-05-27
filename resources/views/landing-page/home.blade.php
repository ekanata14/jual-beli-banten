@extends('layouts.landing')
@section('content')
    <section class="home_hero hero flex w-full justify-start items-end h-[100vh]">
        <div class="home_hero_content py-9 px-10">
            <p class="sub-heading text-white">Harmoni Tradisi dan Teknologi</p>
            <h1 class="text-white">Sarana Upacara Hindu yang<br> Mudah & Praktis</h1>
            <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                Lihat Semua Produk
            </x-button>
        </div>
    </section>

    <section class="home_about flex flex-col w-full pt-40 ">
        <div class="home_about_content flex flex-col justify-center items-center">
            <div class="home_about_heading flex flex-col items-center">
                <p class="sub-heading">Tentang Kami</p>
                <h2 class="text-black w-[90%] text-center">Menghadirkan Sarana Upacara dengan Ketulusan</h2>
            </div>
            <p class="w-1/3 text-center mt-9">Dengan pengalaman dalam menyediakan banten dan sarana upacara, kami memastikan setiap produk dibuat dengan penuh          ketulusan dan mengikuti tradisi yang    diwariskan turun-temurun.</p>
            <!-- button -->
            <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24">
                Baca Lebih Lengkap
            </x-button>
            <div class="home_about_images">
                <img class="mt-24" src="assets/images/about_img.png" alt="">
            </div>
        </div>
    </section>

    <section class="home_product flex flex-col w-full pt-[200px] px-10 mb-12">
        <div class="home_product_content gap-16 flex flex-col">
            <div class="home_product_heading flex justify-between items-end">
                <div class="home_product_heading_text ">
                    <p class="sub-heading">Tentang Kami</p>
                    <h2 class="text-black">Produk Terlaris</h2>
                </div>
                <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                    Lihat Semua Produk
                </x-button>
            </div>
            <div class="home_product_wrapper flex items-center self-stretch gap-6">
                @include('components.product-card')
                @include('components.product-card')
                @include('components.product-card')
                @include('components.product-card')
            </div>
        </div>
    </section>

    <section class="home_testi pt-50 pb-30">
        <div class="home_testi_content flex flex-col items-center gap-44">
            <div class="home_testi_content_header flex flex-col items-center justify-center w-1/2">
                <p class="sub-heading">Pendapat pelanggan tentang produk kami</p>
                <h2 class="text-center text-black mt-2">Setiap banten diproses dengan penuh ketulusan agar sesuai dengan nilai-nilai spiritual yang dijunjung tinggi.</h2>
            </div>
            <div class="home_testi_content_footer pl-1">
                @include('components.testi-card')
            </div>
        </div>
    </section>
    

    
@endsection
