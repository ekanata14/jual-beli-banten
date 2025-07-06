@extends('layouts.landing')
@section('content')
    <div class="main_content flex flex-col lg:flex-row justify-between py-16 lg:py-40 px-4 md:px-12 lg:px-36 gap-8 lg:gap-16">
        @php
            $subtotal = $transaksi->orders->sum('subtotal');
        @endphp
        <div class="left_content w-full lg:w-[60%]" data-aos="fade-up" data-aos-delay="100">
            <!-- informasi anda -->
            <div class="checkout_container mb-8" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-6">
                    <p>{{ auth()->user()?->name }}</p>
                    <p>{{ auth()->user()?->email }}</p>
                    <p>{{ auth()->user()?->pelanggan?->no_telp }}</p>
                </div>
            </div>

            <!-- informasi penerima -->
            <div class="checkout_container mb-8" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-black">Informasi Penerima</h3>
                <div class="informasi_data mt-6">
                    <p><strong>Nama Penerima:</strong> {{ $informasiPenerima->nama_penerima ?? '-' }}</p>
                    <p><strong>Alamat Penerima:</strong> {{ $informasiPenerima->alamat_penerima ?? '-' }}</p>
                    <p><strong>Telepon Penerima:</strong> {{ $informasiPenerima->telp_penerima ?? '-' }}</p>
                </div>
            </div>
            <!-- pengiriman -->
            <div class="checkout_container mb-8" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-black mb-4">Pengiriman</h3>
                <div class="w-full">
                    <!-- Modal toggle -->
                    <button id="btn-pilih-pengiriman"
                        class="modal-btn w-full py-4 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-4 text-center cursor-pointer border border-gray-200 transition"
                        type="button">
                        Pilih Pengiriman
                    </button>
                </div>
                <!-- Modal for shipment rates -->
                <div id="select-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                    <!-- Modal background overlay -->
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <!-- Modal content -->
                    <div class="bg-white rounded-lg p-6 w-[90%] max-w-md relative z-10">
                        <h4 class="text-lg font-bold mb-4">Pilih Layanan Pengiriman</h4>
                        <div id="rates-list" class="overflow-y-auto" style="max-height: 300px;">
                            <p class="text-center">Memuat data pengiriman...</p>
                        </div>
                        <button id="close-modal"
                            class="mt-6 w-full bg-gray-200 hover:bg-gray-300 rounded py-2">Tutup</button>
                    </div>
                </div>
                <form id="shipment-form" action="{{ route('cart.checkout.biaya.pengiriman') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_pengiriman" value="{{ $pengiriman->id }}">
                    <input type="hidden" name="id_transaksi" value="{{ $transaksi->id }}">
                    <input type="hidden" name="selected_rate" id="selected_rate">
                    <input type="hidden" name="biaya_pengiriman" id="shipping_price">
                    <button type="submit" id="btn-lanjut-pembayaran" class="w-full">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-4 w-full">
                            Lanjut Ke Pembayaran
                        </x-button>
                    </button>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const btnLanjut = document.getElementById('btn-lanjut-pembayaran');
                            const shipmentForm = document.getElementById('shipment-form');
                            btnLanjut.addEventListener('click', function(e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Konfirmasi',
                                    text: 'Apakah Anda yakin ingin melanjutkan ke pembayaran?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, lanjutkan',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        shipmentForm.submit();
                                    }
                                });
                            });
                        });
                    </script>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('btn-pilih-pengiriman');
                    const modal = document.getElementById('select-modal');
                    const closeModal = document.getElementById('close-modal');
                    const ratesList = document.getElementById('rates-list');
                    const selectedRateInput = document.getElementById('selected_rate');
                    const shippingPriceInput = document.getElementById('shipping_price');
                    const shipmentForm = document.getElementById('shipment-form');
                    const biayaPengiriman = document.getElementById('biaya-pengiriman');
                    const totalHarga = document.getElementById('total-harga');
                    const subtotal = {{ $subtotal }};

                    btn.addEventListener('click', function() {
                        modal.classList.remove('hidden');
                        ratesList.innerHTML = '<p class="text-center">Memuat data pengiriman...</p>';

                        fetch("{{ route('rates') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    origin_postal_code: "{{ $transaksi->orders[0]->Produk->user->penjual->kode_pos }} ",
                                    destination_postal_code: "{{ auth()->user()->pelanggan->kode_pos }}"
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data && Array.isArray(data.pricing) && data.pricing.length > 0) {
                                    ratesList.innerHTML = '';
                                    data.pricing.forEach(rate => {
                                        const rateBtn = document.createElement('button');
                                        rateBtn.type = 'button';
                                        rateBtn.className =
                                            'block w-full text-left px-4 py-3 mb-2 border rounded hover:bg-gray-100 transition';
                                        rateBtn.innerHTML = `
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="font-semibold">${rate.courier_name || '-'} - ${rate.service_name || '-'}</div>
                                                    <div class="text-xs text-gray-500">${rate.description || ''}</div>
                                                </div>
                                                <div class="font-bold">Rp. ${(rate.price || 0).toLocaleString('id-ID')}</div>
                                            </div>
                                        `;
                                        rateBtn.addEventListener('click', function() {
                                            selectedRateInput.value = JSON.stringify(rate);
                                            shippingPriceInput.value = rate.price || 0;
                                            modal.classList.add('hidden');
                                            btn.textContent =
                                                `${rate.courier_name || '-'} - ${rate.service_name || '-'} (Rp. ${(rate.price || 0).toLocaleString('id-ID')})`;
                                            // Update biaya pengiriman and total
                                            if (biayaPengiriman) {
                                                biayaPengiriman.textContent = 'Rp. ' + (rate
                                                    .price || 0).toLocaleString('id-ID');
                                            }
                                            if (totalHarga) {
                                                totalHarga.textContent = 'Rp. ' + (subtotal + (
                                                    rate.price || 0)).toLocaleString(
                                                    'id-ID');
                                            }
                                        });
                                        ratesList.appendChild(rateBtn);
                                    });
                                } else {
                                    ratesList.innerHTML =
                                        '<p class="text-center text-red-500">Tidak ada layanan pengiriman tersedia.</p>';
                                }
                            })
                            .catch(() => {
                                ratesList.innerHTML =
                                    '<p class="text-center text-red-500">Gagal memuat data pengiriman.</p>';
                            });
                    });

                    closeModal.addEventListener('click', function() {
                        modal.classList.add('hidden');
                    });

                    // Prevent submit if no rate selected
                    shipmentForm.addEventListener('submit', function(e) {
                        if (!selectedRateInput.value) {
                            e.preventDefault();
                            alert('Silakan pilih layanan pengiriman terlebih dahulu.');
                        }
                    });
                });
            </script>
        </div>
        <div class="right_content bg-white py-6 px-4 md:px-5 w-full lg:w-[40%] rounded-md h-full" data-aos="fade-left" data-aos-delay="200">
            @php
                $subtotal = $transaksi->orders->sum('subtotal');
            @endphp

            @forelse($transaksi->orders as $item)
                <div class="product_container flex flex-col sm:flex-row justify-between pb-6 sm:pb-9 gap-4 sm:gap-0">
                    <div class="flex gap-4 sm:gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-2 sm:mb-4">{{ $item->produk->nama_produk ?? '-' }}</h4>
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
                <p id="biaya-pengiriman">-</p>
                <input type="hidden" name="biaya_pengiriman" id="input-biaya-pengiriman" value="">
                <script>
                    // Update hidden input when biaya pengiriman changes
                    const biayaPengirimanElem = document.getElementById('biaya-pengiriman');
                    const inputBiayaPengiriman = document.getElementById('input-biaya-pengiriman');
                    // Observe changes to biayaPengirimanElem
                    const observer = new MutationObserver(function() {
                        // Extract numeric value from text (e.g., "Rp. 10.000")
                        const value = biayaPengirimanElem.textContent.replace(/[^\d]/g, '');
                        inputBiayaPengiriman.value = value ? parseInt(value, 10) : '';
                    });
                    observer.observe(biayaPengirimanElem, {
                        childList: true,
                        characterData: true,
                        subtree: true
                    });
                </script>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black" id="total-harga">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection
