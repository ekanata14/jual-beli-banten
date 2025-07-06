@extends('layouts.landing')
@section('content')
    <!-- AOS CSS -->
    <div class="main_content py-20 px-4 md:py-40 md:px-36 gap-8 md:gap-16 flex flex-col md:flex-row justify-between">
        <div class="left_content w-full md:w-[60%]" data-aos="fade-up">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-9">
                    <p>{{ auth()->user()?->name }}</p>
                    <p>{{ auth()->user()?->email }}</p>
                    <p>{{ auth()->user()?->pelanggan?->no_telp }}</p>
                </div>
            </div>

            <!-- informasi penerima -->
            <div class="checkout_container mt-8">
                <h3 class="text-black">Informasi Penerima</h3>
                @foreach($informasiPenerima as $info)
                    <div class="informasi_data mt-6 mb-6 border-b pb-4">
                        <p><strong>Nama Penerima:</strong> {{ $info->nama_penerima ?? '-' }}</p>
                        <p><strong>Alamat Penerima:</strong> {{ $info->alamat_penerima ?? '-' }}</p>
                        <p><strong>Kode Pos Penerima:</strong> {{ $info->kode_pos_penerima ?? '-' }}</p>
                        <p><strong>Telepon Penerima:</strong> {{ $info->telp_penerima ?? '-' }}</p>
                        <p><strong>Latitude Penerima:</strong> {{ $info->latitude_penerima ?? '-' }}</p>
                        <p><strong>Longitude Penerima:</strong> {{ $info->longitude_penerima ?? '-' }}</p>
                    </div>
                @endforeach
            </div>

            <!-- detail pengiriman -->
            <div class="checkout_container mt-8">
                <h3 class="text-black">Detail Pengiriman</h3>
                @foreach($pengiriman as $kirim)
                    <div class="informasi_data mt-6 mb-6 border-b pb-4">
                        <p><strong>Kurir:</strong> {{ $kirim->kurir->nama_kurir }}</p>
                        <p><strong>Status Pengiriman:</strong> {{ ucfirst($kirim->status_pengiriman) }}</p>
                        <p><strong>Waktu Pengiriman:</strong> {{ $kirim->waktu_pengiriman }}</p>
                        <p><strong>Biaya Pengiriman:</strong> Rp. {{ number_format($kirim->biaya_pengiriman, 0, ',', '.') }}</p>
                        <p><strong>Penjual:</strong> {{ $kirim->alamat_penjual }}</p>
                        <p><strong>Kode Pos Penjual:</strong> {{ $kirim->kode_pos_penjual }}</p>
                        <p><strong>Latitude Penjual:</strong> {{ $kirim->latitude_penjual }}</p>
                        <p><strong>Longitude Penjual:</strong> {{ $kirim->longitude_penjual }}</p>
                        <p><strong>No. Resi:</strong> {{ $kirim->no_resi ?? '-' }}</p>
                    </div>
                @endforeach
            </div>

            <!-- pembayaran -->
            <div class="checkout_container mt-8">
                <h3 class="text-black">Pembayaran</h3>
            </div>
            <!-- form pembayaran -->
            <div class="checkout_form informasi_anda_form mt-8">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_transaksi" value="{{ $transaksi->id }}">
                    <input type="hidden" name="id_order" value="{{ $transaksi->Orders[0]->id ?? '' }}">
                    {{-- Pengiriman bisa lebih dari satu, kirim array id_pengiriman --}}
                    @foreach($pengiriman as $kirim)
                        <input type="hidden" name="id_pengiriman[]" value="{{ $kirim->id }}">
                    @endforeach
                    <input type="hidden" name="total_harga"
                        value="{{ $transaksi->orders->sum('subtotal') + $pengiriman->sum('biaya_pengiriman') }}">
                    <button type="button" id="confirm-payment" class="w-full">
                        <x-button href="#" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-15">
                            Lanjut Ke Pembayaran
                        </x-button>
                    </button>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.getElementById('confirm-payment').addEventListener('click', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Konfirmasi Pembayaran',
                                text: 'Apakah Anda yakin ingin melanjutkan ke pembayaran?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, lanjutkan',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.closest('form').submit();
                                }
                            });
                        });
                    </script>
                </form>
            </div>
        </div>

        <div class="right_content bg-white py-6 px-4 md:px-5 w-full md:w-[40%] rounded-md h-full mt-8 md:mt-0" data-aos="fade-left">
            @php
                $subtotal = $transaksi->orders->sum('subtotal');
                $totalBiayaPengiriman = $pengiriman->sum('biaya_pengiriman');
            @endphp

            @forelse($transaksi->orders as $item)
                <div class="product_container flex flex-col sm:flex-row justify-between pb-9">
                    <div class="flex gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded-md">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-2">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p>Jumlah : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-black font-bold">
                                Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <h4 class="text-black font-bold mt-4 sm:mt-0">Rp. {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
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
                <p id="biaya-pengiriman">Rp. {{ number_format($totalBiayaPengiriman, 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black" id="total-harga">Rp.
                    {{ number_format($subtotal + $totalBiayaPengiriman, 0, ',', '.') }}</p>
            </div>
        </div>
        @if ($snapToken)
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
            <script type="text/javascript">
                document.getElementById('pay-button').addEventListener('click', function(e) {
                    e.preventDefault();
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            window.location.href = '/transaction/success';
                        },
                        onPending: function(result) {
                            window.location.href = '/transaction/pending';
                        },
                        onError: function(result) {
                            alert('Payment error');
                            console.log(result);
                        }
                    });
                });
            </script>
        @endif
    </div>
    <style>
        @media (max-width: 768px) {
            .main_content {
                flex-direction: column;
                gap: 2rem;
                padding: 2rem 1rem;
            }
            .left_content, .right_content {
                width: 100% !important;
            }
            .right_content {
                margin-top: 2rem;
            }
        }
        .checkout_container {
            background: #f9f9f9;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
