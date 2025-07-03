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
                <form action="#" method="GET">
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
                    <x-button href="{{ route('checkout.second', $transaksi->id) }}" type="submit"
                        icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                        Lanjut Ke Informasi Penerima
                    </x-button>
                </form>
            </div>
        </div>
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md h-full">
            @php
                $subtotal = $transaksi->orders->sum('subtotal');
            @endphp

            @forelse($transaksi->orders as $item)
                <div class="product_container flex justify-between pb-9">
                    <div class="flex gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-50">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-4">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p>Jumlah : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-black font-bold">
                                Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <h4 class="text-black font-bold">Rp. {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                </div>
            @empty
                <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
            @endforelse
            <h3 class="text-black font-bold mt-4">{{ $transaksi->invoice_number }}</h3>
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
