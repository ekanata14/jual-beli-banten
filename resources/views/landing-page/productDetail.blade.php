@extends('layouts.landing')
@section('content')
    <section class="productdetail flex w-full py-40 px-24 gap-16">
        <div class="product_image w-1/3">
            <div class="product_image_primary w-full">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}" class="w-full">
            </div>
            <div class="product_image_list w-full flex justify-between mt-5 gap-4">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 w-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 w-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 h-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 h-2/9 h-20 object-cover rounded">
            </div>
        </div>
        <div class="product_info flex flex-col gap-16 w-2/3">
            <div class="product_header">
                <h2 class="text-black text-4xl">{{ $product['nama_produk'] }}</h2>
                <div class="stars flex">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                </div>
                <div class="product_price flex items-end">
                    <h2 class="text-black">Rp{{ number_format($product['harga'], 0, ',', '.') }}</h2>
                    <p class="text-black">/pcs</p>
                </div>
            </div>
            <div class="product_details_desc flex flex-col">
                <div class="product_desc flex flex-col gap-2">
                    <p class="text-black">Deskripsi</p>
                    <p>{{ $product['deskripsi_produk'] }}</p>
                </div>
                <div class="product_seller flex flex-col gap-2">
                    <p class="text-black">Kategori</p>
                    <p>{{ $product['kategori'] }}</p>
                </div>
            </div>
            <div class="product__footer">
                <div class="product_stock flex items-center gap-2">
                    <p>Stok :</p>
                    <p class="text-[#FF7006]">{{ $product['stok'] }}</p>
                    <p>Tersedia</p>
                </div>
                <div class="product_button_cta">
                    <x-button href="{{ route('checkout', ['id' => $product['id'] ?? 1]) }}"
                        icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
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
