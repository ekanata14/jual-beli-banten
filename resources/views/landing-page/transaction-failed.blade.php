@extends('layouts.landing')
@section('content')
<div class="main_content py-32 px-56">
    <div class="transaction_success_heading flex flex-col items-center justify-center">
        <img src="{{ asset('assets/images/icon_failed.png') }}" alt="Empty Star" class="w-50">
        <h3>Transaksi Gagal!</h3>
        <p class="mt-4">Transaksi Gagal. Pengiriman sedang dibatalkan, klik tombol lihat transaksi untuk lebih lanjut</p>
    </div>
    <div class="transaction_detail_container w-full bg-white py-14 px-8 mt-20">
        <div class="product_container flex justify-between pb-9">
            <div class="flex gap-5">
                <img src="{{ asset('assets/images/product_img.png') }}" alt="Empty Star" class="w-50">
                <div class="flex flex-col">
                    <h4 class="text-black font-bold mb-4">Nama Produk</h4>
                    <p>Kuantiti : 1</p>
                </div>
            </div>
            <h4 class="text-black font-bold">Rp. 50,000</h4>
        </div>
        <div class="product_sub flex justify-between mt-9">
            <p>Tanggal Transaksi</p>
            <p class="">Rp. 100,000</p>
        </div>
        <div class="product_sub flex justify-between mt-4">
            <p>Metode Pembayaran</p>
            <p class="">Bank BCA - Virtual Account</p>
        </div>
        <div class="product_sub flex justify-between mt-4">
            <p>Metode Pengiriman</p>
            <p class="">Grab Instant</p>
        </div>
        <div class="product_sub flex justify-between mt-4">
            <p>Subtotal</p>
            <p class="">Rp. 100,000</p>
        </div>
        <div class="product_sub flex justify-between mt-4">
            <p>Biaya Pengiriman</p>
            <p>Rp. 20,000</p>
        </div>
        <div class="product_sub flex justify-between mt-4">
            <p class="text-black">Total</p>
            <p class="text-black">Rp.120,000</p>
        </div>
        <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
            Lihat Detail Transaksi
        </x-button>
    </div>
    
</div>
@endsection