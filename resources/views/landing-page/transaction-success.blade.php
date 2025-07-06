@extends('layouts.landing')
@section('content')
    {{-- AOS CSS --}}
    <div class="main_content py-16 px-4 md:py-32 md:px-20 lg:px-56">
        <div class="transaction_success_heading flex flex-col items-center justify-center" data-aos="fade-down">
            <img src="{{ asset('assets/images/icon_success.png') }}" alt="Empty Star" class="w-32 md:w-40 lg:w-50">
            <h3 class="text-xl md:text-2xl lg:text-3xl mt-4">Transaksi Berhasil !</h3>
            <p class="mt-4 text-center text-sm md:text-base max-w-lg">
                Transaksi Telah Berhasil. Pengiriman sedang diproses, klik tombol lihat transaksi untuk lebih lanjut
            </p>
        </div>
        <div class="transaction_detail_container w-full bg-white py-8 px-4 md:py-14 md:px-8 mt-10 md:mt-20 rounded-md shadow"
            data-aos="fade-up">
            @forelse($transaksi->orders as $item)
                <div class="product_container flex flex-col md:flex-row justify-between pb-6 md:pb-9 border-b last:border-b-0"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="flex gap-4 md:gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}"
                            class="w-20 md:w-32 lg:w-50 object-cover rounded">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-2 md:mb-4 text-base md:text-lg">
                                {{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p class="text-sm md:text-base">Jumlah : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-black font-bold text-sm md:text-base">
                                Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <h4 class="text-black font-bold mt-2 md:mt-0 text-base md:text-lg">Rp.
                        {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                </div>
            @empty
                <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
            @endforelse
            <div class="product_sub flex justify-between mt-6 md:mt-9 text-sm md:text-base" data-aos="fade-up"
                data-aos-delay="200">
                <p>Jumlah Produk</p>
                <p>{{ $transaksi->orders->count() }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-sm md:text-base" data-aos="fade-up" data-aos-delay="250">
                <p>Total Kuantitas</p>
                <p>{{ $transaksi->orders->sum('jumlah') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-sm md:text-base" data-aos="fade-up" data-aos-delay="300">
                <p>Daftar Produk</p>
                <p>
                    @foreach ($transaksi->orders as $order)
                        {{ $order->produk->nama_produk ?? '-' }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-sm md:text-base" data-aos="fade-up" data-aos-delay="325">
                <p>Metode Pengiriman</p>
                <p>
                    @php
                        $kurirNames = $transaksi->orders
                            ->map(function ($order) {
                                return $order->pengiriman->kurir->nama_kurir ?? null;
                            })
                            ->filter()
                            ->unique()
                            ->values();
                    @endphp
                    {{ $kurirNames->isNotEmpty() ? $kurirNames->implode(', ') : '-' }}
                </p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-sm md:text-base" data-aos="fade-up" data-aos-delay="350">
                <p>Subtotal</p>
                <p>Rp. {{ number_format($transaksi->orders->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-sm md:text-base" data-aos="fade-up" data-aos-delay="400">
                <p>Biaya Pengiriman</p>
                <p>Rp. {{ number_format($transaksi->total_harga - $transaksi->orders->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-base md:text-lg font-bold" data-aos="fade-up"
                data-aos-delay="450">
                <p class="text-black">Total</p>
                <p class="text-black">Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-center mt-10" data-aos="zoom-in" data-aos-delay="500">
                <x-button href="{{ route('history.detail', $transaksi->id) }}"
                    icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                    Lihat Detail Transaksi
                </x-button>
            </div>
        </div>
    </div>

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 700,
        });
    </script>
@endsection
