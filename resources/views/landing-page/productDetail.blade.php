@extends('layouts.landing')
@section('content')
<section class="productdetail flex w-full py-40 px-24 gap-16">
    <div class="product_image w-lvw">
        <div class="product_image_primary w-full">
            <img src="{{asset('assets/images/product_img.png')}}" alt="" class="w-full">
        </div>
        <div class="product_image_list w-full flex justify-between mt-5">
            <img src="{{asset('assets/images/product_img.png')}}" alt="" class="w-2/9">
            <img src="{{asset('assets/images/product_img.png')}}" alt="" class="w-2/9">
            <img src="{{asset('assets/images/product_img.png')}}" alt="" class="w-2/9">
            <img src="{{asset('assets/images/product_img.png')}}" alt="" class="w-2/9">
        </div>
    </div>
    <div class="product_info flex flex-col gap-16">
        <div class="product_header">
            <h2 class="text-black text-4xl">Canang Sari</h2>
            <div class="stars flex">
                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Empty Star" class="w-5 h-5">
                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Empty Star" class="w-5 h-5">
                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Empty Star" class="w-5 h-5">
                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Empty Star" class="w-5 h-5">
                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Empty Star" class="w-5 h-5">
            </div>
            <div class="product_price flex items-end">
                <h2 class="text-black">Rp1.200</h2>
                <p class="text-black">/pcs</p>
            </div>
        </div>
        <div class="product_details_desc flex flex-col">
            <div class="product_desc flex flex-col gap-2">
                <p class="text-black">Deskripsi</p>
                <p>Canang Sari adalah sebuah persembahan harian yang dibuat oleh umat Hindu di Bali sebagai bentuk rasa syukur dan penghormatan kepada Tuhan, dewa-dewi, dan alam semesta. Canang Sari biasanya terbuat dari janur atau daun kelapa yang dibentuk menjadi wadah kecil, kemudian diisi dengan bunga berwarna-warni, daun sirih, irisan pinang, dan kadang-kadang tambahan dupa atau sesari (uang).</p>
            </div>
            <div class="product_seller flex flex-col gap-2">
                <p class="text-black">Penjual</p>
                <p>Komang Sudiarti(Denpasar)</p>
            </div>
        </div>
        <div class="product__footer">
            <div class="product_stock">
                <p>Stok : </p> <p class="text-[#FF7006]">30</p><p> Tersedia</p>
            </div>
            <div class="product_button_cta">
                <x-button href="/checkout" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
                    Beli Sekarang
                </x-button>

            </div>
        </div>
    </div>
</section>
<section class="home_testi pb-30">
    <div class="home_testi_content flex flex-col items-start gap-15">
        <h2 class="Ulasan Pembeli">Ulasan Pembeli </h2>
        <div class="home_testi_content_footer pl-1">
            @include('components.testi-card')
        </div>
    </div>
</section>
@endsection