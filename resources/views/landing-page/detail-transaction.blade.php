@extends('layouts.landing')
@section('content')
<div class="main_content py-40 px-36 flex flex-col justify-center items-center">
    <div class="heading flex justify-between w-full">
        <h3 class="text-black">Detail Transaksi</h3>
        <a href="#">Kembali ke halaman transaksi</a>
    </div>
    <div class="transaction_container bg-white py-9 px-14 mt-20 w-10/12 flex flex-col">
        <!-- section 1 -->
        <div class="section_one pb-9">
            <div class="flex justify-between mb-9">
                <div class="order_id">
                    <p>Order ID</p>
                    <h4 class="text-black font-semibold mt-4">67cec3a4f965640012f7b15f</h4>
                </div>
                <div class="status_transaksi">
                    <p class="mb-4">Status</p>
                    <span class="py-3 px-5 bg-[#DAEAFD] text-[#1D4ED8] rounded-md">Terkonfirmasi</span>
                </div>
            </div>
            <p>No Resi</p>
            <h4 class="text-black font-semibold mt-4">WYB-1741603748272</h4>
        </div>
        <!-- section 2 -->
        <div class="section_two mt-9">
            <div class="flex justify-between">
                <div class="tanggal_order">
                    <p>Tanggal Order</p>
                    <p class="text-black mt-4">10 Maret 2025</p>
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
                    <p class="text-black mt-4">Transfer Bank BCA</p>
                </div>
            </div>

            <div class="alamat_penerima mt-9 pb-9">
                <p>Alamat Penerima</p>
                <p class="text-black mt-4">Nama Orang</p>
                <p class="text-black">Nomor Telepon</p>
                <p class="text-black">Alamat</p>
            </div>
        </div>
        <!-- section 3 -->
        <div class="section_three mt-9">
            <p>Informasi Produk</p>
            <div class="informasi_produk mt-4 mb-4 flex justify-between">
                <img src="{{ asset('assets/images/product_img.png') }}" alt="Empty Star" class="w-50">
                <div class="informasi_produk flex flex-col gap-2">
                    <h4 class="text-black">Banten Pejati</h4>
                    <p>Kuantiti : 1</p>
                    <p>Berat Barang : 5kt</p>
                </div>
                <h4 class="text-black">Rp.50,000</h4>
            </div>
        </div>
        <!-- section 4 -->
         <div class="section_four mt-9">
            <div class="subtotal flex justify-between">
                <p>Subtotal</p>
                <p class=" mt-4">Rp.100,000</p>
            </div>
            <div class="biaya_pengiriman flex justify-between">
                <p>Biaya Pengiriman</p>
                <p class=" mt-4">Rp.24,000</p>
            </div>
            <div class="total_transaksi flex justify-between">
                <p class="text-black">Total Biaya</p>
                <p class="text-black mt-4 font-semibold">Rp.124,000</p>
            </div>
         </div>
         <div class="action_button self-center mt-9">
            <x-primary-button type="submit" class="">Konfirmasi Diterima</x-primary-button>
         </div>
    </div>
</div>
@endsection