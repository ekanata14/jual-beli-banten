@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
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
            <div class="checkout_container">
                <h3 class="text-black">Informasi Penerima</h3>
                <div class="informasi_data mt-9">
                    <p><strong>Nama Penerima:</strong> {{ $informasiPenerima->nama_penerima ?? '-' }}</p>
                    <p><strong>Alamat Penerima:</strong> {{ $informasiPenerima->alamat_penerima ?? '-' }}</p>
                    <p><strong>Telepon Penerima:</strong> {{ $informasiPenerima->telp_penerima ?? '-' }}</p>
                </div>
            </div>
            <!-- pembayaran -->
            <div class="checkout_container">
                <h3 class="text-black">Pembayaran</h3>
            </div>
            <!-- form pembayaran -->
            <div class="checkout_form informasi_anda_form">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_transaksi" value="{{ $transaksi->id }}">
                    <input type="hidden" name="id_order" value="{{ $transaksi->Orders[0]->id }}">
                    <input type="hidden" name="id_pengiriman" value="{{ $pengiriman->id }}">
                    <input type="hidden" name="total_harga"
                        value="{{ $transaksi->Orders->sum('subtotal') + $pengiriman->biaya_pengiriman }}">
                    <!-- input nama_penerima -->
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
            <div class="product_sub flex justify-between mt-4">
                <p>Subtotal</p>
                <p class="text-black">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Biaya Pengiriman</p>
                <p id="biaya-pengiriman">Rp. {{ number_format($pengiriman->biaya_pengiriman, 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black" id="total-harga">Rp.
                    {{ number_format($subtotal + $pengiriman->biaya_pengiriman, 0, ',', '.') }}</p>
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
    @endsection
