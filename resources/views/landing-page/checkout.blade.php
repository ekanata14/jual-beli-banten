@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-9">
                    <p>Agung Aditya</p>
                    <p>cokadit1@gmail.com</p>
                    <p>081353263831</p>
                </div>
            </div>
            <!-- form informasi user -->
            <div class="checkout_form informasi_anda_form">
                <form action="#" method="">
                    <!-- input nama -->
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Nama Anda" required />
                    </div>
                    <!-- input email -->
                    <div class="mt-4">
                        <label for="email">Email</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Email Anda" required />
                    </div>
                    <!-- input nomor telepon -->
                    <div class="mt-4">
                        <label for="nama">Nomor Telepon</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan No Telepon Anda" required />
                    </div>
                    <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                        Lanjut Ke Informasi Penerima
                    </x-button>
                </form>
            </div>

            <!-- informasi penerima -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Penerima</h3>
                <div class="informasi_data mt-9">
                    <p>Agung Aditya</p>
                    <p>081353263831</p>
                    <p>Jl. Raya Mawar GG.Nusa Ambengan, Denpasar, Bali, 80512</p>
                </div>
            </div>
            <!-- form informasi penerima -->
            <div class="checkout_form informasi_penerima_form">
                <form action="#" method="">
                    <!-- input nama -->
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Nama Penerima" required />
                    </div>
                    
                    <!-- input nomor telepon -->
                    <div class="mt-4">
                        <label for="nama">Nomor Telepon</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan No Telepon Anda" required />
                    </div>
                    <!-- input alamat -->
                    <div class="mt-4">
                        <label for="email">Alamat</label>
                        <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Email Anda" required />
                    </div>
                    <!-- input kota dan kabupaten -->
                    <div class="mt-4 flex gap-5">
                        <!-- input kota -->
                        <div class="input_kota w-full">
                            <label for="email">Kota</label>
                            <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Email Anda" required />
                        </div>
                        <!-- input kabupaten -->
                        <div class="input_kabupaten w-full">
                            <label for="email">Kabupaten</label>
                            <input type="text" id="default-text" class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3" placeholder="Masukan Email Anda" required />
                        </div>
                    </div>
                    <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                        Lanjut Ke Pengiriman
                    </x-button>
                </form>
            </div>

            <!-- pengiriman -->
            <div class="checkout_container">
                <h3 class="text-black">Pengiriman</h3>
                <div class="informasi_data mt-9">
                    <p>Grab Instant</p>
                </div>
            </div>
            

            <!-- pembayaran -->
            <div class="checkout_container">
                <h3 class="text-black">Pembayaran</h3>
                <div class="informasi_data mt-9">
                    <p>Bank BCA</p>
                </div>
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