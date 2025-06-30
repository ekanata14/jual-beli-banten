@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <!-- LEFT CONTENT -->
        <div class="left_content w-[60%]">
            <!-- STEPPER NAVIGATION -->
            <div class="flex justify-center items-center mb-8 gap-4">
                @foreach ([1 => 'Informasi Anda', 2 => 'Penerima', 3 => 'Pengiriman', 4 => 'Pembayaran'] as $step => $label)
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
                <!-- STEP 1: INFORMASI ANDA -->
                <div class="checkout_step" id="step-1">
                    <div class="checkout_container">
                        <h3 class="text-black">Informasi Anda</h3>
                        <div class="informasi_data mt-9">
                            <p>{{ auth()->user()->name }}</p>
                            <p>{{ auth()->user()->email }}</p>
                            <p>{{ auth()->user()->pelanggan->no_telp }}</p>
                        </div>
                    </div>
                    <div class="checkout_form informasi_anda_form mt-6">
                        <div>
                            <label for="nama">Nama</label>
                            <input type="text" name="name"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Nama Anda" required value="{{ auth()->user()->name }}" />
                        </div>
                        <div class="mt-4">
                            <label for="email">Email</label>
                            <input type="text" name="email"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Email Anda" required value="{{ auth()->user()->email }}" />
                        </div>
                        <div class="mt-4">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="text" name="no_telp"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan No Telepon Anda" required
                                value="{{ auth()->user()->pelanggan->no_telp }}" />
                        </div>
                        <button type="button"
                            class="mt-8 bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer"
                            onclick="showStep(2)">
                            Lanjut Ke Informasi Penerima
                            <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next" class="w-4 h-4">
                        </button>
                    </div>
                </div>

                <!-- STEP 2: INFORMASI PENERIMA -->
                <div class="checkout_step hidden" id="step-2">
                    <div class="checkout_container">
                        <h3 class="text-black">Informasi Penerima</h3>
                        <div class="informasi_data mt-9">
                            <p>-</p>
                            <p>-</p>
                            <p>-</p>
                        </div>
                    </div>
                    <div class="checkout_form informasi_penerima_form mt-6">
                        <div>
                            <label for="penerima_nama">Nama</label>
                            <input type="text" name="penerima_nama"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Nama Penerima" required />
                        </div>
                        <div class="mt-4">
                            <label for="penerima_no_telp">Nomor Telepon</label>
                            <input type="text" name="penerima_no_telp"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan No Telepon Anda" required />
                        </div>
                        <div class="mt-4">
                            <label for="penerima_alamat">Alamat</label>
                            <input type="text" name="penerima_alamat"
                                class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                placeholder="Masukan Alamat Anda" required />
                        </div>
                        <div class="mt-4 flex gap-5">
                            <div class="input_kota w-full">
                                <label for="penerima_kota">Kota</label>
                                <input type="text" name="penerima_kota"
                                    class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                    placeholder="Masukan Kota" required />
                            </div>
                            <div class="input_kabupaten w-full">
                                <label for="penerima_kabupaten">Kabupaten</label>
                                <input type="text" name="penerima_kabupaten"
                                    class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                    placeholder="Masukan Kabupaten" required />
                            </div>
                        </div>
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="showStep(1)"
                                class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                            <button type="button"
                                class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer"
                                onclick="showStep(3)">
                                Lanjut Ke Pengiriman
                                <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                    class="w-4 h-4">
                            </button>
                        </div>
                    </div>
                </div>
                <!-- STEP 3: PENGIRIMAN -->
                <div class="checkout_step hidden" id="step-3">
                    <div class="checkout_container">
                        <h3 class="text-black">Pengiriman</h3>
                        <div class="informasi_data mt-9">
                            <p>-</p>
                        </div>
                    </div>
                    <div class="checkout_form informasi_anda_form mt-6">
                        <div class="w-full mb-6">
                            <div class="flex gap-5">
                                <div class="w-1/2">
                                    <label for="pengirim_kode_pos">Kode Pos Pengirim</label>
                                    <input type="text" id="pengirim_kode_pos" name="origin_postal_code"
                                        class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                        placeholder="Kode Pos Pengirim"
                                        value="{{ auth()->user()->pelanggan->kode_pos ?? '' }}" required />
                                </div>
                                <div class="w-1/2">
                                    <label for="penerima_kode_pos">Kode Pos Penerima</label>
                                    <input type="text" id="penerima_kode_pos" name="destination_postal_code"
                                        class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                        placeholder="Kode Pos Penerima" value="" required />
                                </div>
                            </div>
                        </div>
                        <div class="w-full mb-6">
                            <button type="button"
                                class="w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 text-center cursor-pointer"
                                id="cek_ongkir_btn">
                                Cek Ongkir
                            </button>
                            <div id="ongkir_dropdown_wrapper" class="hidden mt-4">
                                <label for="ongkir_list" class="block mb-2">Pilih Kurir</label>
                                <select id="ongkir_list" class="block w-full p-3 border border-gray-200 rounded"></select>
                            </div>
                            <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                            <input type="hidden" name="courier_code" id="courier_code" value="">
                            <input type="hidden" name="courier_service_code" id="courier_service_code" value="">
                        </div>
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="showStep(2)"
                                class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                            <button type="button"
                                class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer"
                                onclick="showStep(4)">
                                Lanjut Ke Pembayaran
                                <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                    class="w-4 h-4">
                            </button>
                        </div>
                    </div>
                </div>

                @push('scripts')
                    <script>
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
                                        `${item.courier_name} - ${item.courier_service_name} (${item.duration.replace('days','hari')}) - Rp ${Number(item.price).toLocaleString('id-ID')}`;
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
                            @php
                                $productsSubtotal = 0;
                                $productsArray = is_iterable($product) ? $product : (is_object($product) ? [$product] : []);
                                foreach ($productsArray as $item) {
                                    $qty = $item->qty ?? 1;
                                    $productsSubtotal += ($item->harga ?? 0) * $qty;
                                }
                            @endphp
                            const subtotal = {{ $productsSubtotal }};
                            const subtotalText = document.getElementById('subtotal');
                            const totalText = document.getElementById('total');
                            const shippingText = document.getElementById('shipping-cost');
                            const totalInput = document.getElementById('total-input');
                            const shippingInput = document.getElementById('shipping_cost');

                            if (!val.includes('|')) {
                                if (shippingText) shippingText.textContent = '-';
                                if (subtotalText) subtotalText.textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
                                totalText.textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
                                totalInput.value = subtotal;
                                shippingInput.value = 0;
                                document.getElementById('courier_code').value = '';
                                document.getElementById('courier_service_code').value = '';
                                return;
                            }

                            const [courierCode, serviceCode, priceRaw] = val.split('|');
                            const shipping = parseInt(priceRaw);
                            const total = subtotal + shipping;

                            if (shippingText) shippingText.textContent = 'Rp. ' + shipping.toLocaleString('id-ID');
                            if (subtotalText) subtotalText.textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
                            totalText.textContent = 'Rp. ' + total.toLocaleString('id-ID');
                            totalInput.value = total;
                            shippingInput.value = shipping;

                            document.getElementById('courier_code').value = courierCode;
                            document.getElementById('courier_service_code').value = serviceCode;
                        });
                    </script>
                @endpush
                <!-- STEP 4: PEMBAYARAN -->
                <div class="checkout_step hidden" id="step-4">
                    <div class="checkout_container">
                        <h3 class="text-black">Pembayaran</h3>
                        <div class="informasi_data mt-9">
                            <p>-</p>
                        </div>
                    </div>
                    <div class="checkout_form informasi_anda_form mt-6">
                        <div class="w-full">
                            <button data-modal-target="select-modal-pembayaran"
                                data-modal-toggle="select-modal-pembayaran"
                                class="modal-btn w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                                type="button">
                                Pilih Pembayaran
                            </button>
                            @include('components.modal-payment')
                        </div>
                        <div class="flex justify-between mt-8">
                            <button type="button" onclick="showStep(3)"
                                class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                            <button type="submit"
                                id="pay-button"
                                class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer">
                                Selesaikan Pembayaran
                                <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                    class="w-4 h-4">
                            </button>

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
                    </div>
                </div>
            </form>

            @push('scripts')
                <script>
                    function showStep(step) {
                        document.querySelectorAll('.checkout_step').forEach(function(el) {
                            el.classList.add('hidden');
                        });
                        document.getElementById('step-' + step).classList.remove('hidden');
                        document.querySelectorAll('.step-btn').forEach(function(btn) {
                            if (parseInt(btn.dataset.step) === step) {
                                btn.classList.remove('bg-gray-200', 'text-gray-700');
                                btn.classList.add('bg-amber-800', 'text-white');
                            } else {
                                btn.classList.remove('bg-amber-800', 'text-white');
                                btn.classList.add('bg-gray-200', 'text-gray-700');
                            }
                        });
                    }
                    document.querySelectorAll('.step-btn').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            showStep(parseInt(this.dataset.step));
                        });
                    });
                    showStep(1);
                </script>
            @endpush
        </div>

        <!-- RIGHT CONTENT (ORDER SUMMARY) -->
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md h-full">
            @php
                $products = is_iterable($product) ? $product : [$product];
                $subtotal = 0;
                $totalQty = 0;
            @endphp

            @foreach ($products as $index => $item)
                @php
                    $qty = isset($item->qty) ? $item->qty : 1;
                    $harga = $item->harga * $qty;
                    $subtotal += $harga;
                    $totalQty += $qty;
                @endphp
                <div class="product_container flex justify-between pb-9 items-center border-b border-gray-100 mb-4">
                    <div class="flex gap-5 items-center">
                        <img src="{{ asset('assets/images/product_img.png') }}" alt="Product Image"
                            class="w-20 h-20 object-cover rounded">
                        <div class="flex flex-col justify-between h-full">
                            <h4 class="text-black font-bold mb-2">{{ $item->nama_produk }}</h4>
                            <div class="flex items-center gap-2 mt-2">
                                <button type="button"
                                    class="qty-btn bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-lg font-bold transition"
                                    data-index="{{ $index }}" data-action="decrement">-</button>
                                <input type="text" readonly
                                    class="qty-input w-12 text-center border border-gray-200 rounded font-semibold text-base bg-gray-50"
                                    id="qty-input-{{ $index }}" value="{{ $qty }}"
                                    data-index="{{ $index }}">
                                <button type="button"
                                    class="qty-btn bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-lg font-bold transition"
                                    data-index="{{ $index }}" data-action="increment">+</button>
                            </div>
                            <h4 class="text-amber-800 font-bold mt-2 harga-item" id="harga-item-{{ $index }}">Rp.
                                {{ number_format($harga, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="products[{{ $index }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="products[{{ $index }}][qty]" id="form-qty-{{ $index }}"
                    value="{{ $qty }}">
            @endforeach

            <div class="product_sub flex justify-between mt-6 text-base">
                <p>Subtotal (<span id="total-qty">{{ $totalQty }}</span> barang)</p>
                <h4 class="text-black font-bold" id="subtotal">Rp.
                    {{ number_format($subtotal, 0, ',', '.') }}</h4>
            </div>
            <div class="product_sub flex justify-between mt-2 text-base">
                <p>Biaya Pengiriman</p>
                <p id="shipping-cost">-</p>
            </div>
            <div class="product_sub flex justify-between mt-4 text-lg border-t border-gray-100 pt-4">
                <p class="text-black font-semibold">Total</p>
                <p class="text-black font-bold" id="total">Rp.
                    {{ number_format($subtotal, 0, ',', '.') }}</p>
                <input type="hidden" name="total" id="total-input" value="{{ $subtotal }}">
            </div>
        </div>
    </div>
@endsection
