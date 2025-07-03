@extends('layouts.landing')
@section('content')
    <div class="main_content py-40 px-36 flex flex-col justify-center items-center">
        <div class="heading flex justify-between w-full">
            <h3 class="text-black">Detail Transaksi</h3>
            <a href="{{ route('history') }}">Kembali ke halaman transaksi</a>
        </div>
        <div class="transaction_container bg-white py-9 px-14 mt-20 w-10/12 flex flex-col">
            <!-- section 1 -->
            <div class="section_one pb-9">
                <div class="flex justify-between mb-9">
                    <div class="order_id">
                        <p>Order ID</p>
                        <h4 class="text-black font-semibold mt-4">{{ $data->invoice_number }}</h4>
                    </div>
                    <div class="status_transaksi">
                        <p class="mb-4">Status</p>
                        <span class="py-3 px-5 bg-[#DAEAFD] text-[#1D4ED8] rounded-md">{{ $data->status }}</span>
                    </div>
                </div>
                <p>No Resi</p>
                <h4 class="text-black font-semibold mt-4">-</h4>
            </div>
            <!-- section 2 -->
            <div class="section_two mt-9">
                <div class="flex justify-between">
                    <div class="tanggal_order">
                        <p>Tanggal Order</p>
                        <p class="text-black mt-4">{{ $data->tanggal_transaksi }}</p>
                    </div>
                    <div class="kurir_order">
                        <p>Kurir</p>
                        <p class="text-black mt-4">Grab Instant</p>
                    </div>
                    <div class="berat_order">
                        <p>Berat</p>
                        <p class="text-black mt-4">4 Kg</p>
                    </div>
                    <div class="metode_order">
                        <p>Metode Pembayaran</p>
                        <p class="text-black mt-4">Midtrans</p>
                    </div>
                </div>

                <div class="alamat_penerima mt-9 pb-9">
                    <p>Alamat Penerima</p>
                    <p class="text-black mt-4">{{ $data->pengiriman->nama_penerima }}</p>
                    <p class="text-black">{{ $data->pengiriman->telp_penerima }}</p>
                    <p class="text-black">{{ $data->pengiriman->alamat_penerima }}</p>
                </div>
            </div>
            <!-- section 3 -->
            <div class="section_three mt-9">
                <p>Informasi Produk</p>
                @php
                    $subtotal = $data->orders->sum('subtotal');
                @endphp

                @forelse($data->orders as $item)
                    <div class="informasi_produk mt-4 mb-4 flex justify-between">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-50">
                        <div class="informasi_produk flex flex-col gap-2">
                            <h4 class="text-black">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p>Kuantiti : {{ $item->jumlah ?? 1 }}</p>
                            <p>Berat Barang : {{ $item->produk->berat ?? '-' }}g</p>
                        </div>
                        <h4 class="text-black">Rp. {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
                @endforelse
            </div>
            <!-- section 4 -->
            <div class="section_four mt-9">
                <div class="subtotal flex justify-between">
                    <p>Subtotal</p>
                    <p class="mt-4">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
                <div class="biaya_pengiriman flex justify-between">
                    <p>Biaya Pengiriman</p>
                    <p class="mt-4">Rp. {{ number_format($data->pengiriman->biaya_pengiriman ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="total_transaksi flex justify-between">
                    <p class="text-black">Total Biaya</p>
                    <p class="text-black mt-4 font-semibold">
                        Rp. {{ number_format($subtotal + ($data->pengiriman->biaya_pengiriman ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="action_button self-center mt-9">
                <x-primary-button type="submit" class="">Konfirmasi Diterima</x-primary-button>
            </div>
        </div>
    </div>
@endsection
