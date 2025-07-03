@extends('layouts.landing')
@section('content')
    <div class="main_content py-32 px-56">
        <div class="transaction_success_heading flex flex-col items-center justify-center">
            <img src="{{ asset('assets/images/icon_success.png') }}" alt="Empty Star" class="w-50">
            <h3>Transaksi Berhasil !</h3>
            <p class="mt-4">Transaksi Telah Berhasil. Pengiriman sedang diproses, klik tombol lihat transaksi untuk lebih
                lanjut</p>
        </div>
        <div class="transaction_detail_container w-full bg-white py-14 px-8 mt-20 rounded-md">
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
            <div class="product_sub flex justify-between mt-9">
                <p>Tanggal Transaksi</p>
                <p class="">{{ $transaksi->tanggal_transaksi }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Metode Pembayaran</p>
                <p class="">Midtrans</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Metode Pengiriman</p>
                <p class="">Grab Instant</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Subtotal</p>
                <p class="">Rp. {{ number_format($transaksi->orders->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Biaya Pengiriman</p>
                <p class="">Rp. {{ number_format($transaksi->total_harga - $transaksi->orders->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black">Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            </div>
            <x-button href="{{ route('history.detail', $transaksi->id) }}" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                Lihat Detail Transaksi
            </x-button>
        </div>

    </div>
@endsection
