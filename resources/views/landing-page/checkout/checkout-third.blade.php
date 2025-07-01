@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <!-- informasi anda -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-9">
                    @foreach ($informasiAnda as $info)
                        <p>{{ $info }}</p>
                    @endforeach
                </div>
            </div>

            <!-- informasi penerima -->
            <div class="checkout_container">
                <h3 class="text-black">Informasi Penerima</h3>
                <div class="informasi_data mt-9">
                    @foreach ($informasiPenerima as $key => $value)
                        <p>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </div>
            </div>
            <!-- pengiriman -->
            <div class="checkout_container">
                <h3 class="text-black mb-4">Pengiriman</h3>
                <div class="w-full">
                    <!-- Modal toggle -->
                    <button id="btn-pilih-pengiriman"
                        class="modal-btn w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                        type="button">
                        Pilih Pengiriman
                    </button>
                </div>
                <!-- Modal for shipment rates -->
                <div id="select-modal"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-25">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md fixed top-50">
                        <h4 class="text-lg font-bold mb-4">Pilih Layanan Pengiriman</h4>
                        <div id="rates-list" class="overflow-y-auto" style="max-height: 300px;">
                            <p class="text-center">Memuat data pengiriman...</p>
                        </div>
                        <button id="close-modal"
                            class="mt-6 w-full bg-gray-200 hover:bg-gray-300 rounded py-2">Tutup</button>
                    </div>
                </div>
                <form id="shipment-form" action="{{ route('checkout.fourth') }}" method="GET">
                    <input type="hidden" name="selected_rate" id="selected_rate">
                    <x-button type="submit" icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                        Lanjut Ke Pembayaran
                    </x-button>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('btn-pilih-pengiriman');
                    const modal = document.getElementById('select-modal');
                    const closeModal = document.getElementById('close-modal');
                    const ratesList = document.getElementById('rates-list');
                    const selectedRateInput = document.getElementById('selected_rate');
                    const shipmentForm = document.getElementById('shipment-form');

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
                                    origin_postal_code: "{{ $product->user->penjual->kode_pos }}",
                                    destination_postal_code: "{{ $informasiPenerima['penerima_kode_pos'] }}"
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
                                            'block w-full text-left px-4 py-3 mb-2 border rounded hover:bg-gray-100';
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
                                            modal.classList.add('hidden');
                                            btn.textContent =
                                                `${rate.courier_name || '-'} - ${rate.service_name || '-'} (Rp. ${(rate.price || 0).toLocaleString('id-ID')})`;
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

        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md h-full">
            <div class="product_container flex justify-between pb-9">
                <div class="flex gap-5">
                    <img src="{{ asset('assets/images/product_img.png') }}" alt="Empty Star" class="w-50">
                    <div class="flex flex-col">
                        <h4 class="text-black font-bold mb-4">Nama Produk</h4>
                        <p>Kuantiti : 1</p>
                    </div>
                </div>
                <h4 class="text-black font-bold">Rp. 50,000</h4>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Subtotal</p>
                <p class="text-black">Rp. 100,000</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p>Biaya Pengiriman</p>
                <p>-</p>
            </div>
            <div class="product_sub flex justify-between mt-4">
                <p class="text-black">Total</p>
                <p class="text-black">Rp.100,000</p>
            </div>
        </div>

    </div>
@endsection
