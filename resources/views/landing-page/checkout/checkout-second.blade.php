@extends('layouts.landing')
@section('content')
    <div class="main_content flex flex-col lg:flex-row justify-between py-16 px-4 md:px-10 lg:py-40 lg:px-36 gap-8 lg:gap-16">
        <div class="left_content w-full lg:w-[60%]" data-aos="fade-up" data-aos-delay="100">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-6 md:mt-9">
                    <p>{{ auth()->user()?->name }}</p>
                    <p>{{ auth()->user()?->email }}</p>
                    <p>{{ auth()->user()?->pelanggan?->no_telp }}</p>
                </div>
            </div>
            <!-- form informasi penerima -->
            <div class="checkout_form informasi_penerima_form mt-8 md:mt-12" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-black mb-2">Informasi Penerima</h3>
                <form action="{{ route('cart.checkout.pengiriman.data') }}" method="POST">
                    @csrf
                    <!-- hidden id_transaksi -->
                    <input type="hidden" name="id_transaksi" id="id_transaksi"
                        value="{{ old('id_transaksi', $transaksi->id ?? '') }}" />
                    <!-- hidden id_order -->
                    <input type="hidden" name="id_order" id="id_order" value="{{ $transaksi->Orders[0]->id }}" />
                    <!-- input nama_penerima -->
                    <div class="mt-4">
                        <label for="nama_penerima">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="nama_penerima"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Nama Penerima"
                            value="{{ old('nama_penerima', auth()->user()?->name ?? '') }}" required maxlength="250" />
                    </div>
                    <!-- input alamat_penerima -->
                    <div class="mt-4">
                        <label for="alamat_penerima">Alamat Penerima</label>
                        <input type="text" name="alamat_penerima" id="alamat_penerima"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Alamat Penerima"
                            value="{{ old('alamat_penerima', auth()->user()?->pelanggan?->alamat_pelanggan ?? '') }}"
                            required maxlength="250" />
                    </div>
                    <!-- input telp_penerima -->
                    <div class="mt-4">
                        <label for="telp_penerima">Telepon Penerima</label>
                        <input type="text" name="telp_penerima" id="telp_penerima"
                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                            placeholder="Masukan Telepon Penerima"
                            value="{{ old('telp_penerima', auth()->user()?->pelanggan?->no_telp ?? '') }}" required
                            maxlength="255" />
                    </div>
                    <button class="w-full mt-8">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                            Lanjut Ke Pengiriman
                        </x-button>
                    </button>
                </form>
            </div>
        </div>

        <div class="right_content bg-white py-6 px-4 md:px-5 w-full lg:w-[40%] rounded-md h-fit mt-8 lg:mt-0" data-aos="fade-left" data-aos-delay="300">
            @php
                $subtotal = $transaksi->orders->sum('subtotal');
            @endphp

            @forelse($transaksi->orders as $item)
                <div class="product_container flex flex-col sm:flex-row justify-between pb-6 md:pb-9 gap-4">
                    <div class="flex gap-4 md:gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded-md">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-2 md:mb-4">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p>Jumlah : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-black font-bold">
                                Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <h4 class="text-black font-bold mt-2 sm:mt-0">Rp. {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                </div>
            @empty
                <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
            @endforelse
            <div class="product_sub flex justify-between mt-4">
                <p>Subtotal</p>
                <p class="text-black">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Biaya Pengiriman</p>
                <p>-</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection
