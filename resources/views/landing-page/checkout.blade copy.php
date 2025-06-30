@extends('layouts.landing')

@section('content')
    <div class="flex main_content py-40 px-10 gap-16 w-full">
        <div class="flex flex-col w-full">
            <!-- Stepper -->
            <div class="flex justify-center items-center mb-8 gap-4">
                @foreach ([1 => 'Informasi Anda', 2 => 'Penerima'] as $step => $label)
                    <button type="button"
                        class="step-btn px-4 py-2 rounded {{ $step === 1 ? 'bg-amber-800 text-white' : 'bg-gray-200 text-gray-700' }} font-bold cursor-pointer"
                        data-step="{{ $step }}">{{ $step }}. {{ $label }}</button>
                    @if ($step < 4)
                        <span class="text-gray-400">→</span>
                    @endif
                @endforeach
            </div>

            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="w-full">
                @csrf
                <div class="flex gap-4">
                    <!-- Form kiri -->
                    <div class="w-full">
                        <!-- Step 1 -->
                        <div class="checkout_step" id="step-1">
                            <h3 class="text-black">Informasi Anda</h3>
                            <div class="informasi_data mt-9">
                                <p>{{ auth()->user()->name }}</p>
                                <p>{{ auth()->user()->email }}</p>
                                <p>{{ auth()->user()->pelanggan->no_telp }}</p>
                            </div>
                            <div class="checkout_form mt-6">
                                <label>Nama</label>
                                <input type="text" name="name" required value="{{ auth()->user()->name }}"
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <label class="mt-4">Email</label>
                                <input type="text" name="email" required value="{{ auth()->user()->email }}"
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <label class="mt-4">No Telepon</label>
                                <input type="text" name="no_telp" required
                                    value="{{ auth()->user()->pelanggan->no_telp }}"
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <button type="button" onclick="showStep(2)"
                                    class="mt-8 bg-amber-800 text-white px-6 py-3 rounded">Lanjut Ke Informasi
                                    Penerima</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="checkout_step hidden" id="step-2">
                            <h3 class="text-black">Informasi Penerima</h3>
                            <div class="checkout_form mt-6">
                                <label>Nama</label>
                                <input type="text" name="penerima_nama" required
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <label class="mt-4">No Telepon</label>
                                <input type="text" name="penerima_no_telp" required
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <label class="mt-4">Alamat</label>
                                <input type="text" name="penerima_alamat" required
                                    class="w-full p-4 mt-2 bg-gray-50 border rounded" />

                                <div class="flex gap-4 mt-4">
                                    <div class="w-full">
                                        <label>Kota</label>
                                        <input type="text" name="penerima_kota" required
                                            class="w-full p-4 mt-2 bg-gray-50 border rounded" />
                                    </div>
                                    <div class="w-full">
                                        <label>Kabupaten</label>
                                        <input type="text" name="penerima_kabupaten" required
                                            class="w-full p-4 mt-2 bg-gray-50 border rounded" />
                                    </div>
                                </div>

                                <div class="flex gap-4 mt-4">
                                    <div class="w-full">
                                        <label>Kode Pos Pengirim</label>
                                        <input type="text" id="pengirim_kode_pos" name="pengirim_kode_pos" required
                                            class="w-full p-4 mt-2 bg-gray-50 border rounded" />
                                    </div>
                                    <div class="w-full">
                                        <label>Kode Pos Penerima</label>
                                        <input type="text" id="penerima_kode_pos" name="penerima_kode_pos" required
                                            class="w-full p-4 mt-2 bg-gray-50 border rounded" />
                                    </div>
                                </div>

                                <!-- Cek Ongkir -->
                                <div class="mt-4">
                                    <button type="button" id="cek_ongkir_btn"
                                        class="bg-amber-800 text-white px-6 py-3 rounded w-full">Cek Ongkir</button>

                                    <div id="ongkir_dropdown_wrapper" class="hidden mt-4">
                                        <label class="block mb-2">Pilih Kurir</label>
                                        <select id="ongkir_list" name="ongkir_list"
                                            class="w-full p-4 bg-gray-50 border rounded">
                                            <option value="">Pilih Kurir</option>
                                        </select>
                                    </div>

                                    <!-- Hidden untuk form -->
                                    <input type="hidden" name="courier_code" id="courier_code">
                                    <input type="hidden" name="courier_service_code" id="courier_service_code">
                                    <input type="hidden" name="shipping_cost" id="shipping_cost">
                                </div>

                                <div class="flex justify-between mt-8">
                                    <button type="button" onclick="showStep(1)"
                                        class="bg-gray-200 px-6 py-3 rounded">Kembali</button>
                                    <button type="submit" class="bg-amber-800 text-white px-6 py-3 rounded">Lanjut Ke
                                        Pembayaran</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Pesanan -->
                    <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md h-full">
                        @php
                            $products = is_iterable($product) ? $product : [$product];
                            $subtotal = 0;
                            $totalQty = 0;
                        @endphp

                        @foreach ($products as $index => $item)
                            @php
                                $qty = $item->qty ?? 1;
                                $harga = $item->harga * $qty;
                                $subtotal += $harga;
                                $totalQty += $qty;
                            @endphp
                            <div class="mb-4 pb-4 border-b">
                                <h4 class="text-black font-bold">{{ $item->nama_produk }}</h4>
                                <p>Qty: {{ $qty }}</p>
                                <p>Rp {{ number_format($harga, 0, ',', '.') }}</p>
                                <input type="hidden" name="products[{{ $index }}][id]"
                                    value="{{ $item->id }}">
                                <input type="hidden" name="products[{{ $index }}][qty]"
                                    value="{{ $qty }}">
                            </div>
                        @endforeach

                        <div class="flex justify-between mt-4">
                            <p>Subtotal (<span id="total-qty">{{ $totalQty }}</span> barang)</p>
                            <p id="subtotal-text">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p>Biaya Pengiriman</p>
                            <p id="shipping-cost">-</p>
                        </div>
                        <div class="flex justify-between mt-4 border-t pt-4 text-lg font-bold">
                            <p>Total</p>
                            <p id="total">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            <input type="hidden" name="total" id="total-input" value="{{ $subtotal }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function showStep(step) {
                document.querySelectorAll('.checkout_step').forEach(el => el.classList.add('hidden'));
                document.getElementById('step-' + step).classList.remove('hidden');

                document.querySelectorAll('.step-btn').forEach(btn => {
                    if (parseInt(btn.dataset.step) === step) {
                        btn.classList.remove('bg-gray-200', 'text-gray-700');
                        btn.classList.add('bg-amber-800', 'text-white');
                    } else {
                        btn.classList.remove('bg-amber-800', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-700');
                    }
                });
            }

            showStep(1);

            // Ongkir
            document.getElementById('cek_ongkir_btn').addEventListener('click', async function() {
                const origin = document.getElementById('pengirim_kode_pos').value;
                const destination = document.getElementById('penerima_kode_pos').value;
                const wrapper = document.getElementById('ongkir_dropdown_wrapper');
                const list = document.getElementById('ongkir_list');

                list.innerHTML = '<option value="">Pilih Kurir</option>';
                wrapper.classList.add('hidden');

                if (!origin || !destination) {
                    alert('Mohon isi kode pos pengirim dan penerima.');
                    return;
                }

                list.innerHTML += '<option disabled selected>Memuat...</option>';
                wrapper.classList.remove('hidden');

                const res = await fetch("{{ route('rates') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        origin_postal_code: origin,
                        destination_postal_code: destination
                    })
                });

                const data = await res.json();
                list.innerHTML = '<option value="">Pilih Kurir</option>';
                if (Array.isArray(data.pricing)) {
                    data.pricing.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = `${item.courier_code}|${item.courier_service_code}|${item.price}`;
                        opt.textContent =
                            `${item.courier_name} - ${item.courier_service_name} (${item.duration}) - Rp ${item.price.toLocaleString('id-ID')}`;
                        list.appendChild(opt);
                    });
                } else {
                    const opt = document.createElement('option');
                    opt.textContent = 'Tidak ada layanan';
                    opt.disabled = true;
                    list.appendChild(opt);
                }
            });

            // Update total saat pilih kurir
            document.getElementById('ongkir_list').addEventListener('change', function() {
                const val = this.value;
                const subtotal = {{ $subtotal }};
                const totalText = document.getElementById('total');
                const shippingText = document.getElementById('shipping-cost');
                const totalInput = document.getElementById('total-input');
                const shippingInput = document.getElementById('shipping_cost');

                if (!val.includes('|')) {
                    shippingText.textContent = '-';
                    totalText.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    totalInput.value = subtotal;
                    shippingInput.value = 0;
                    return;
                }

                const [courierCode, serviceCode, priceRaw] = val.split('|');
                const shipping = parseInt(priceRaw);
                const total = subtotal + shipping;

                shippingText.textContent = 'Rp ' + shipping.toLocaleString('id-ID');
                totalText.textContent = 'Rp ' + total.toLocaleString('id-ID');
                totalInput.value = total;
                shippingInput.value = shipping;

                document.getElementById('courier_code').value = courierCode;
                document.getElementById('courier_service_code').value = serviceCode;
            });
        </script>
    @endpush
@endsection
