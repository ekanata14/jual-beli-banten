@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-9">
                    <p>{{ auth()->user()->name }}</p>
                    <p>{{ auth()->user()->email }}</p>
                    <p>{{ auth()->user()->pelanggan->no_telp }}</p>
                </div>
            </div>
            <!-- form informasi user -->
            <div class="checkout_form informasi_anda_form">
                <form action="{{ route('checkout.second') }}" method="GET">
                    <!-- input nama -->
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="name"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Nama Anda" required value="{{ auth()->user()->name }}" />
                    </div>
                    <!-- input email -->
                    <div class="mt-4">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Email Anda" required value="{{ auth()->user()->email }}" />
                    </div>
                    <!-- input nomor telepon -->
                    <div class="mt-4">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" id="no_telp" name="no_telp"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan No Telepon Anda" required
                            value="{{ auth()->user()->pelanggan->no_telp }}" />
                    </div>
                    <button type="submit"class="w-full">
                        <x-button type="submit" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                            Lanjut Ke Informasi Penerima
                        </x-button>
                    </button>
                </form>
            </div>
        </div>
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md h-full">
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
            <div class="product_sub flex justify-between mt-4">
                <p>Subtotal</p>
                <p class="text-black">Rp. 100,000</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Biaya Pengiriman</p>
                <p>-</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black">Rp.100,000</p>
            </div>
        </div>

    </div>
@endsection
