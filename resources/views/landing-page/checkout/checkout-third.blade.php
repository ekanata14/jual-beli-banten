@extends('layouts.landing')
@section('content')
<div class="navigation mt-10 pt-40 px-36 flex items-center">
    <a href="{{ route('checkout', $transaksi->id) }}" class="text-[#534538]">
        Informasi Anda</a>/
    <a href="{{ route('checkout.second', $transaksi->id) }}" class="text-[#534538]">
        Informasi Penerima</a>/
    <p class="text-gray-400">Pengiriman</p>
</div>
<div
    class="main_content flex flex-col lg:flex-row justify-between py-6 px-4 md:px-10 lg:py-10 lg:px-36 gap-8 lg:gap-16">
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
                <p><strong>Nama Penerima:</strong> {{ $informasiPenerima[0]->nama_penerima ?? '-' }}</p>
                <p><strong>Alamat Penerima:</strong> {{ $informasiPenerima[0]->alamat_penerima ?? '-' }}</p>
                <p><strong>Kode Pos Penerima:</strong> {{ $informasiPenerima[0]->kode_pos_penerima ?? '-' }}</p>
                <p><strong>Telepon Penerima:</strong> {{ $informasiPenerima[0]->telp_penerima ?? '-' }}</p>
                <p><strong>Latitude Penerima:</strong> {{ $informasiPenerima[0]->latitude_penerima ?? '-' }}</p>
                <p><strong>Longitude Penerima:</strong> {{ $informasiPenerima[0]->longitude_penerima ?? '-' }}</p>
            </div>
        </div>
        @php
            $jumlahPengiriman = is_iterable($pengiriman) ? count($pengiriman) : 1;
        @endphp

        @for ($i = 0; $i < $jumlahPengiriman; $i++)
            <div class="checkout_container mb-8" data-aos="fade-up" data-aos-delay="{{ 400 + $i }}">
                <h3 class="text-black mb-4">Pengiriman #{{ $i + 1 }}</h3>
                <div class="w-full">
                    <button id="btn-pilih-pengiriman-{{ $i + 1 }}"
                        class="modal-btn w-full py-4 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-4 text-center cursor-pointer border border-gray-200 transition"
                        type="button">
                        Pilih Pengiriman #{{ $i + 1 }}
                    </button>
                </div>
                <!-- Fullscreen Modal -->
                @push('modals')
                    <div id="select-modal-{{ $i + 1 }}"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center w-screen h-screen top-0 left-0">
                        <div class="absolute inset-0 bg-black opacity-70"></div>
                        <div
                            class="bg-white rounded-none p-0 w-screen h-screen relative z-10 flex flex-col justify-center items-center md:rounded-none md:w-screen md:h-screen">
                            <div class="w-full max-w-lg mx-auto p-6 flex flex-col justify-center items-center h-full">
                                <h4 class="text-lg font-bold mb-4">Pilih Layanan Pengiriman #{{ $i + 1 }}</h4>
                                <div id="rates-list-{{ $i + 1 }}" class="overflow-y-auto w-full"
                                    style="max-height: 60vh;">
                                    <p class="text-center">Memuat data pengiriman...</p>
                                </div>
                                <button id="close-modal-{{ $i + 1 }}"
                                    class="mt-6 w-full bg-gray-200 hover:bg-gray-300 rounded py-2">Tutup</button>
                            </div>
                        </div>
                    </div>
                @endpush
            </div>
        @endfor

        <form id="shipment-form" action="{{ route('cart.checkout.biaya.pengiriman') }}" method="POST">
            @csrf
            @if (is_iterable($pengiriman) && count($pengiriman) > 1)
                @foreach ($pengiriman as $p)
                    <input type="hidden" name="id_pengiriman[]" value="{{ $p->id }}">
                @endforeach
            @else
                <input type="hidden" name="id_pengiriman"
                    value="{{ is_iterable($pengiriman) ? $pengiriman[0]->id : $pengiriman->id }}">
            @endif
            <input type="hidden" name="id_transaksi" value="{{ $transaksi->id }}">
            @for ($i = 0; $i < $jumlahPengiriman; $i++)
                <input type="hidden" name="selected_rate[{{ $i }}]"
                    id="selected_rate_{{ $i + 1 }}">
                <input type="hidden" name="biaya_pengiriman_{{ $i + 1 }}"
                    id="shipping_price_{{ $i + 1 }}">
            @endfor
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const jumlahPengiriman = {{ $jumlahPengiriman }};
                const subtotal = {{ $subtotal }};
                let prices = Array(jumlahPengiriman).fill(0);

                function updateBiayaDanTotal() {
                    let totalShipping = prices.reduce((a, b) => (parseInt(a) || 0) + (parseInt(b) || 0), 0);
                    const biayaPengiriman = document.getElementById('biaya-pengiriman');
                    const totalHarga = document.getElementById('total-harga');
                    if (biayaPengiriman) {
                        biayaPengiriman.textContent = 'Rp. ' + totalShipping.toLocaleString('id-ID');
                    }
                    if (totalHarga) {
                        totalHarga.textContent = 'Rp. ' + (subtotal + totalShipping).toLocaleString('id-ID');
                    }
                }

                // Prepare pengiriman data for JS
                const pengirimanData = @json($pengiriman);

                for (let i = 0; i < jumlahPengiriman; i++) {
                    const btn = document.getElementById('btn-pilih-pengiriman-' + (i + 1));
                    const modal = document.getElementById('select-modal-' + (i + 1));
                    const closeModal = document.getElementById('close-modal-' + (i + 1));
                    const ratesList = document.getElementById('rates-list-' + (i + 1));
                    const selectedRateInput = document.getElementById('selected_rate_' + (i + 1));
                    const shippingPriceInput = document.getElementById('shipping_price_' + (i + 1));

                    btn.addEventListener('click', function() {
                        modal.classList.remove('hidden');
                        ratesList.innerHTML = '<p class="text-center">Memuat data pengiriman...</p>';

                        // Get current pengiriman data
                        let pengirimanItem = Array.isArray(pengirimanData) ? pengirimanData[i] : pengirimanData;
                        let items = [];
                        if (pengirimanItem && pengirimanItem.orders) {
                            items = pengirimanItem.orders.map(order => ({
                                name: order.produk?.nama_produk || '',
                                description: '',
                                weight: order.produk?.berat || 1000,
                                value: order.subtotal || 0,
                                quantity: order.jumlah || 1
                            }));
                        }

                        fetch("{{ route('rates') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    origin_latitude: pengirimanItem?.latitude_penjual || '',
                                    origin_longitude: pengirimanItem?.longitude_penjual || '',
                                    destination_latitude: pengirimanItem?.latitude_penerima || '',
                                    destination_longitude: pengirimanItem?.longitude_penerima || '',
                                    items: items
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
                                            'block w-full text-left px-4 py-3 mb-2 border rounded hover:bg-gray-100 transition cursor-pointer';
                                        rateBtn.innerHTML = `
                        <div class="flex justify-between items-center">
                            <div>
                            <div class="font-semibold">${rate.courier_name || '-'} - ${rate.courier_service_name || '-'}</div>
                            <div class="text-xs text-gray-500">${rate.description || ''}</div>
                            </div>
                            <div class="font-bold">Rp. ${(rate.price || 0).toLocaleString('id-ID')}</div>
                        </div>
                        `;
                                        rateBtn.addEventListener('click', function() {
                                            // Store as JSON string, will be parsed as object on backend
                                            selectedRateInput.value = JSON.stringify(rate);
                                            shippingPriceInput.value = rate.price || 0;
                                            prices[i] = rate.price || 0;
                                            modal.classList.add('hidden');
                                            btn.textContent =
                                                `${rate.courier_name || '-'} - ${rate.courier_service_name || '-'} (Rp. ${(rate.price || 0).toLocaleString('id-ID')})`;
                                            updateBiayaDanTotal();
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
                }

                // Prevent submit if not all rates selected
                const shipmentForm = document.getElementById('shipment-form');
                shipmentForm.addEventListener('submit', function(e) {
                    let allSelected = true;
                    for (let i = 0; i < jumlahPengiriman; i++) {
                        if (!document.getElementById('selected_rate_' + (i + 1)).value) {
                            allSelected = false;
                            break;
                        }
                    }
                    if (!allSelected) {
                        e.preventDefault();
                        alert('Silakan pilih layanan pengiriman untuk semua pengiriman terlebih dahulu.');
                    }
                });
            });
        </script>
    </div>
    <div class="right_content bg-white py-6 px-4 md:px-5 w-full lg:w-[40%] rounded-md h-full" data-aos="fade-left"
        data-aos-delay="200">
        <h4 class="text-black font-bold pb-3 invoice_title">{{ $transaksi->invoice_number }}</h4>
        @php
            $subtotal = $transaksi->orders->sum('subtotal');
        @endphp

        @forelse($transaksi->orders as $item)
            <div class="product_container flex flex-col sm:flex-row justify-between pb-6 sm:pb-9 gap-4 sm:gap-0 mt-6">
                <div class="flex gap-4 sm:gap-5">
                    <img src="{{ asset($item->produk->foto ?? 'assets/images/product_img.png') }}"
                        alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded">
                    <div class="flex flex-col">
                        <h4 class="text-black font-bold mb-2 sm:mb-4">{{ $item->produk->nama_produk ?? '-' }}</h4>
                        <p>Jumlah : {{ $item->jumlah ?? 1 }}</p>
                        <!-- <p class="text-black font-bold">
                            Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p> -->
                    </div>
                </div>
                <h4 class="text-black font-bold mt-2 sm:mt-0">Rp.
                    {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
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
