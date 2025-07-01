@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-9">
                    @foreach ($informasiAnda as $info)
                        <p>{{ $info }}</p>
                    @endforeach
                </div>
            </div>
            <!-- form informasi penerima -->
            <div class="checkout_form informasi_penerima_form">
                <h3 class="text-black mb-2">Informasi Penerima</h3>
                <form action="{{ route('checkout.third') }}" method="GET">
                    @foreach ($informasiAnda as $key => $info)
                        <input type="hidden" name="[{{ $key }}]" value="{{ $info }}">
                    @endforeach
                    <!-- input nama -->
                    <div>
                        <label for="penerima_nama">Nama</label>
                        <input type="text" name="penerima_nama" id="penerima_nama"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Nama Penerima"
                            value="{{ old('penerima_nama', auth()->user()->name ?? '') }}" required />
                    </div>

                    <!-- input nomor telepon -->
                    <div class="mt-4">
                        <label for="penerima_no_telp">Nomor Telepon</label>
                        <input type="text" name="penerima_no_telp" id="penerima_no_telp"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan No Telepon Anda"
                            value="{{ old('penerima_no_telp', auth()->user()->pelanggan->no_telp ?? '') }}" required />
                    </div>
                    <!-- input alamat -->
                    <div class="mt-4">
                        <label for="penerima_alamat">Alamat</label>
                        <input type="text" name="penerima_alamat" id="penerima_alamat"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Alamat Anda"
                            value="{{ old('penerima_alamat', auth()->user()->pelanggan->alamat_pelanggan ?? '') }}"
                            required />
                    </div>
                    <!-- input kode pos -->
                    <div class="mt-4">
                        <label for="penerima_kode_pos">Kode Pos</label>
                        <input type="text" name="penerima_kode_pos" id="penerima_kode_pos"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Kode Pos Anda"
                            value="{{ old('penerima_kode_pos', auth()->user()->pelanggan->kode_pos ?? '') }}" required />
                    </div>
                    <!-- input kota dan kabupaten -->
                    <div class="mt-4 flex gap-5">
                        <!-- input kota -->
                        <div class="input_kota w-full">
                            <label for="penerima_kota">Kota</label>
                            <input type="text" name="penerima_kota" id="penerima_kota"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Kota Anda"
                                value="{{ old('penerima_kota', $informasiPenerima['penerima_kota'] ?? '') }}" required />
                        </div>
                        <!-- input kabupaten -->
                        <div class="input_kabupaten w-full">
                            <label for="penerima_kabupaten">Kabupaten</label>
                            <input type="text" name="penerima_kabupaten" id="penerima_kabupaten"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Kabupaten Anda"
                                value="{{ old('penerima_kabupaten', $informasiPenerima['penerima_kabupaten'] ?? '') }}"
                                required />
                        </div>
                    </div>
                    <button class="w-full">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                            Lanjut Ke Pengiriman
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
