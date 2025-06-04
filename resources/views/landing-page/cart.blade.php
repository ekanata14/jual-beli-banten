@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <h3 class="text-black">Keranjang Belanja</h3>
            <p>2 Produk</p>

            <div class="product_container flex w-full mt-16 pb-10">
                <img src="{{ asset('assets/images/product_img.png') }}" alt="Empty Star" class="w-50">
                <div class="product_desc flex flex-col justify-between ml-10 w-full">
                    <div class="product_heading flex justify-between items-center">
                        <h4 class="text-black font-bold">Nama Produk</h4>
                        <h4 class="text-black font-bold">Rp. 50,000</h4>
                    </div>
                    <div class="product_action flex justify-between items-center">
                        @include('components.number-counter')
                        <a href="#" class="hover:text-[#FF9D00]">X Hapus Produk</a>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md">
            <h4 class="text-black ">Ringkasan</h4>
            <div class="product_sub flex justify-between mt-8">
                <p>Subtotal (2 Produk)</p>
                <p>Rp. 100,000</p>
            </div>
            <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24">
                Checkout
            </x-button>
        </div>
        
    </div>
@endsection