@extends('layouts.landing')
@section('content')
    <div class="flex main_content py-40 px-10 gap-16 w-full">
        <!-- Left Content -->
        <div class="flex flex-col w-full">
            <!-- Stepper Navigation -->
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
                    <!-- Steps Section -->
                    <div class="w-full">
                        <!-- Step 1: Informasi Anda -->
                        <div class="checkout_step" id="step-1">
                            <div class="checkout_container">
                                <h3 class="text-black">Informasi Anda</h3>
                                <div class="informasi_data mt-9">
                                    <p>{{ auth()->user()->name }}</p>
                                    <p>{{ auth()->user()->email }}</p>
                                    <p>{{ auth()->user()->pelanggan->no_telp }}</p>
                                </div>
                            </div>
                            <div class="checkout_form informasi_anda_form">
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
                                    <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                        class="w-4 h-4">
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Informasi Penerima -->
                        <div class="checkout_step hidden" id="step-2">
                            <div class="checkout_container">
                                <h3 class="text-black">Informasi Penerima</h3>
                            </div>
                            <div class="checkout_form informasi_penerima_form">
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
                                <div class="mt-4 flex gap-5">
                                    <div class="input_kode_pos w-full">
                                        <label for="penerima_kode_pos">Kode Pos</label>
                                        <input type="text" id="kode_pos" name="penerima_kode_pos"
                                            class="block w-full p-4 ps-10 text-sm placeholder-gray-300 text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800 mt-3"
                                            placeholder="Masukkan Kode Pos" required />
                                    </div>
                                    <div class="input_cek_ongkir w-full flex flex-col">
                                        <label>&nbsp;</label>
                                        <div class="flex gap-2">
                                            <button type="button" id="cek_ongkir_btn"
                                                class="bg-amber-800 text-white px-4 py-3 rounded cursor-pointer w-full">
                                                Cek Ongkir
                                            </button>
                                            <select id="ongkir_list" name="ongkir_list"
                                                class="block w-full p-4 text-sm border border-gray-50 rounded-lg bg-gray-50 focus:ring-amber-800 focus:border-broring-amber-800">
                                                <option value="">Pilih Kurir</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-8">
                                    <button type="button" onclick="showStep(1)"
                                        class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                                    <button type="submit"
                                        class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer">
                                        Lanjut Ke Pembayaran
                                        <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                            class="w-4 h-4">
                                    </button>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                            <script>
                                document.getElementById('cek_ongkir_btn').addEventListener('click', function() {
                                    const kodePos = document.getElementById('kode_pos').value;

                                    fetch(`/ongkir?kode_pos=${kodePos}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            let list = document.getElementById('ongkir_list');
                                            list.innerHTML = '<option value="">Pilih Kurir</option>';
                                            if (Array.isArray(data.pricing)) {
                                                data.pricing.forEach(item => {
                                                    let opt = document.createElement('option');
                                                    opt.value = item.courier_name + ' - ' + item.price;
                                                    opt.text =
                                                        `${item.courier_name} (${item.service_name}) - Rp ${item.price.toLocaleString('id-ID')}`;
                                                    list.appendChild(opt);
                                                });
                                            }
                                        });
                                });
                            </script>
                        @endpush
                        {{-- <!-- Step 3: Pembayaran -->
                        <div class="checkout_step hidden" id="step-3">
                            <div class="checkout_container">
                                <h3 class="text-black">Pembayaran</h3>
                                <div class="informasi_data mt-9">
                                    <p>Bank BCA</p>
                                </div>
                            </div>
                            <div class="checkout_form informasi_anda_form">
                                <div class="w-full">
                                    <button data-modal-target="select-modal-pembayaran"
                                        data-modal-toggle="select-modal-pembayaran"
                                        class="modal-btn w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                                        type="button">
                                        Pilih Pembayaran
                                    </button>
                                    @include('components.modal-payment')
                                    <input type="hidden" name="payment_method" id="payment_method" value="">
                                </div>
                                <div class="flex justify-between mt-8">
                                    <button type="button" onclick="showStep(2)"
                                        class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                                    <button type="button"
                                        class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer"
                                        onclick="showStep(4)">
                                        Lanjut Ke Pengiriman
                                        <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                            class="w-4 h-4">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Pengiriman -->
                        <div class="checkout_step hidden" id="step-4">
                            <div class="checkout_container">
                                <h3 class="text-black">Pengiriman</h3>
                                <div class="informasi_data mt-9">
                                    <p>Grab Instant</p>
                                </div>
                            </div>
                            <div class="checkout_form informasi_anda_form">
                                <div class="w-full">
                                    <button data-modal-target="select-modal" data-modal-toggle="select-modal"
                                        class="modal-btn w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                                        type="button">
                                        Pilih Pengiriman
                                    </button>
                                    @include('components.modal-shipment')
                                    <input type="hidden" name="shipment_method" id="shipment_method" value="">
                                </div>
                                <div class="flex justify-between mt-8">
                                    <button type="button" onclick="showStep(3)"
                                        class="bg-gray-200 text-gray-700 px-6 py-3 rounded cursor-pointer">Kembali</button>
                                    <button type="submit"
                                        class="bg-amber-800 text-white px-6 py-3 rounded flex items-center gap-2 cursor-pointer">
                                        Selesaikan Pembayaran
                                        <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt="Next"
                                            class="w-4 h-4">
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Right Content (Order Summary) -->
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
                            <div
                                class="product_container flex justify-between pb-9 items-center border-b border-gray-100 mb-4">
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
                                        <h4 class="text-amber-800 font-bold mt-2 harga-item"
                                            id="harga-item-{{ $index }}">Rp.
                                            {{ number_format($harga, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" name="products[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="products[{{ $index }}][qty]"
                                id="form-qty-{{ $index }}" value="{{ $qty }}">
                        @endforeach

                        <div class="product_sub flex justify-between mt-6 text-base">
                            <p>Subtotal (<span id="total-qty">{{ $totalQty }}</span> barang)</p>
                            <h4 class="text-black font-bold" id="subtotal">Rp.
                                {{ number_format($subtotal, 0, ',', '.') }}</h4>
                        </div>
                        <div class="product_sub flex justify-between mt-2 text-base">
                            <p>Biaya Pengiriman</p>
                            <p>-</p>
                        </div>
                        <div class="product_sub flex justify-between mt-4 text-lg border-t border-gray-100 pt-4">
                            <p class="text-black font-semibold">Total</p>
                            <p class="text-black font-bold" id="total">Rp.
                                {{ number_format($subtotal, 0, ',', '.') }}</p>
                            <input type="hidden" name="total" id="total-input" value="{{ $subtotal }}">
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

                    document.addEventListener('DOMContentLoaded', function() {
                        let products = @json($products);

                        function updateTotals() {
                            let subtotal = 0;
                            let totalQty = 0;
                            products.forEach(function(item, idx) {
                                let qty = parseInt(document.getElementById('qty-input-' + idx).value) || 1;
                                let harga = item.harga * qty;
                                subtotal += harga;
                                totalQty += qty;
                                document.getElementById('harga-item-' + idx).textContent = 'Rp. ' + harga
                                    .toLocaleString('id-ID');
                                document.getElementById('form-qty-' + idx).value = qty;
                            });
                            document.getElementById('subtotal').textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
                            document.getElementById('total').textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
                            document.getElementById('total-qty').textContent = totalQty;
                        }

                        document.querySelectorAll('.qty-btn').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                let idx = this.dataset.index;
                                let input = document.getElementById('qty-input-' + idx);
                                let current = parseInt(input.value) || 1;
                                if (this.dataset.action === 'increment') {
                                    input.value = current + 1;
                                } else if (this.dataset.action === 'decrement' && current > 1) {
                                    input.value = current - 1;
                                }
                                updateTotals();
                            });
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
