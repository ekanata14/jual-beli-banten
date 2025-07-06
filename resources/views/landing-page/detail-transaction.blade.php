@extends('layouts.landing')
@section('content')
    <!-- Add AOS CSS -->
    <div class="main_content py-10 px-4 md:py-40 md:px-36 flex flex-col justify-center items-center">
        <div class="heading flex flex-col md:flex-row md:justify-between w-full gap-4" data-aos="fade-down">
            <h3 class="text-black text-xl md:text-2xl">Detail Transaksi</h3>
            <a href="{{ route('history') }}" class="text-blue-600 hover:underline text-sm md:text-base">Kembali ke halaman transaksi</a>
        </div>
        <div class="transaction_container bg-white py-6 px-4 md:py-9 md:px-14 mt-10 md:mt-20 w-full md:w-10/12 flex flex-col rounded-lg shadow" data-aos="fade-up">
            <!-- section 1 -->
            <div class="section_one pb-6 md:pb-9">
                <div class="flex flex-col md:flex-row md:justify-between mb-6 md:mb-9 gap-4" data-aos="fade-right">
                    <div class="order_id">
                        <p class="text-sm">Order ID</p>
                        <h4 class="text-black font-semibold mt-2 md:mt-4 text-base md:text-lg">{{ $data->invoice_number }}</h4>
                    </div>
                    <div class="status_transaksi">
                        <p class="mb-2 md:mb-4 text-sm">Status</p>
                        <span class="py-2 px-4 md:py-3 md:px-5 bg-[#DAEAFD] text-[#1D4ED8] rounded-md text-sm md:text-base">{{ $data->status }}</span>
                    </div>
                </div>
                <p class="text-sm">No Resi</p>
                <h4 class="text-black font-semibold mt-2 md:mt-4 text-base md:text-lg">-</h4>
            </div>
            <!-- section 2 -->
            <div class="section_two mt-6 md:mt-9">
                <div class="flex flex-col md:flex-row md:justify-between gap-4" data-aos="fade-left">
                    <div class="tanggal_order">
                        <p class="text-sm">Tanggal Order</p>
                        <p class="text-black mt-2 md:mt-4 text-base">{{ $data->tanggal_transaksi }}</p>
                    </div>
                    <div class="kurir_order">
                        <p class="text-sm">Kurir</p>
                        <p class="text-black mt-2 md:mt-4 text-base">Grab Instant</p>
                    </div>
                    <div class="berat_order">
                        <p class="text-sm">Berat</p>
                        <p class="text-black mt-2 md:mt-4 text-base">4 Kg</p>
                    </div>
                    <div class="metode_order">
                        <p class="text-sm">Metode Pembayaran</p>
                        <p class="text-black mt-2 md:mt-4 text-base">Midtrans</p>
                    </div>
                </div>

                <div class="alamat_penerima mt-6 md:mt-9 pb-6 md:pb-9" data-aos="fade-up">
                    <p class="text-sm">Alamat Penerima</p>
                    <p class="text-black mt-2 md:mt-4 text-base">{{ $data->pengiriman->nama_penerima }}</p>
                    <p class="text-black text-base">{{ $data->pengiriman->telp_penerima }}</p>
                    <p class="text-black text-base">{{ $data->pengiriman->alamat_penerima }}</p>
                </div>
            </div>
            <!-- section 3 -->
            <div class="section_three mt-6 md:mt-9" data-aos="fade-right">
                <p class="text-base md:text-lg">Informasi Produk</p>
                @php
                    $subtotal = $data->orders->sum('subtotal');
                @endphp

                @forelse($data->orders as $item)
                    <div class="informasi_produk mt-4 mb-4 flex flex-col md:flex-row md:justify-between gap-4 items-center bg-gray-50 p-4 rounded" data-aos="zoom-in">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded">
                        <div class="informasi_produk flex flex-col gap-2 flex-1">
                            <h4 class="text-black text-base">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p class="text-sm">Kuantiti : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-sm">Berat Barang : {{ $item->produk->berat ?? '-' }}g</p>
                        </div>
                        <h4 class="text-black text-base md:text-lg">Rp. {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
                @endforelse
            </div>
            <!-- section 4 -->
            <div class="section_four mt-6 md:mt-9" data-aos="fade-left">
                <div class="subtotal flex justify-between text-sm md:text-base">
                    <p>Subtotal</p>
                    <p class="mt-2 md:mt-4">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
                <div class="biaya_pengiriman flex justify-between text-sm md:text-base">
                    <p>Biaya Pengiriman</p>
                    <p class="mt-2 md:mt-4">Rp. {{ number_format($data->pengiriman->biaya_pengiriman ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="total_transaksi flex justify-between">
                    <p class="text-black font-semibold text-base md:text-lg">Total Biaya</p>
                    <p class="text-black mt-2 md:mt-4 font-semibold text-base md:text-lg">
                        Rp. {{ number_format($subtotal + ($data->pengiriman->biaya_pengiriman ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="action_button self-center mt-6 md:mt-9" data-aos="zoom-in-up">
                <x-primary-button type="submit" class="w-full md:w-auto">Konfirmasi Diterima</x-primary-button>
            </div>
        </div>
    </div>
    <!-- Add AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            once: true
        });
    </script>
@endsection
