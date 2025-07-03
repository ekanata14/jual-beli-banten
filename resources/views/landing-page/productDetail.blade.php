@extends('layouts.landing')
@section('content')
    <section class="productdetail flex w-full py-40 px-24 gap-16">
        <div class="product_image w-1/3">
            <div class="product_image_primary w-full">
                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product['nama_produk'] }}" class="w-full">
            </div>
            <div class="product_image_list w-full flex justify-between mt-5 gap-4">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 w-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 w-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 h-2/9 h-20 object-cover rounded">
                <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                    class="flex-1 h-2/9 h-20 object-cover rounded">
            </div>
        </div>
        <div class="product_info flex flex-col gap-16 w-2/3">
            <div class="product_header">
                <h2 class="text-black text-4xl">{{ $product['nama_produk'] }}</h2>
                <div class="stars flex">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                    <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star" class="w-5 h-5">
                </div>
                <div class="product_price flex items-end">
                    <h2 class="text-black">Rp{{ number_format($product['harga'], 0, ',', '.') }}</h2>
                    <p class="text-black">/pcs</p>
                </div>
            </div>
            <div class="product_details_desc flex flex-col">
                <div class="product_desc flex flex-col gap-2">
                    <p class="text-black">Deskripsi</p>
                    <p>{{ $product['deskripsi_produk'] }}</p>
                </div>
                <div class="product_seller flex flex-col gap-2">
                    <p class="text-black">Kategori</p>
                    <p>{{ $product['kategori'] }}</p>
                </div>
            </div>
            <div class="product__footer">
                {{-- <div class="product_stock flex items-center gap-2"> --}}
                <p>Stok :</p>
                <p class="text-[#FF7006]">{{ $product['stok'] }}</p>
                <p>Tersedia</p>
                <div class="flex items-center gap-2 mt-4 mb-8">
                    <button type="button" id="decrement"
                        class="px-3 py-1 bg-gray-200 rounded text-lg font-bold cursor-pointer">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        max="{{ $product['stok'] }}" class="w-16 text-center border rounded" readonly>
                    <button type="button" id="increment"
                        class="px-3 py-1 bg-gray-200 rounded text-lg font-bold cursor-pointer">+</button>
                </div>
                <div class="product_button_cta">
                    <div class="flex flex-col gap-4 w-full">
                        <form action="{{ route('cart.checkout.direct') }}" method="POST" class="w-full" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="quantity" id="checkout_quantity" value="1">
                            <x-button type="submit" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                                class="w-full" id="checkoutBtn">
                                Beli Sekarang
                            </x-button>
                        </form>
                        <form action="{{ route('cart.add') }}" method="POST" class="w-full" id="cartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="quantity" id="cart_quantity" value="1">
                            <input type="hidden" name="id_pelanggan" value="{{ auth()->user()->id ?? '' }}">
                            <button type="submit"
                                class="w-full flex items-center justify-center bg-white text-black border border-[#FF7006] hover:bg-[#FF7006] hover:text-white transition-colors duration-200 rounded py-2 cursor-pointer"
                                id="cartBtn">
                                Tambah ke Keranjang
                            </button>
                        </form>
                        {{-- SweetAlert2 --}}
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Checkout confirmation
                                const checkoutForm = document.getElementById('checkoutForm');
                                const checkoutBtn = document.getElementById('checkoutBtn');
                                checkoutBtn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    Swal.fire({
                                        title: 'Konfirmasi Pembelian',
                                        text: 'Apakah Anda yakin ingin membeli produk ini sekarang?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Beli Sekarang',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            checkoutForm.submit();
                                        }
                                    });
                                });

                                // Add to cart confirmation
                                const cartForm = document.getElementById('cartForm');
                                const cartBtn = document.getElementById('cartBtn');
                                cartBtn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    Swal.fire({
                                        title: 'Tambah ke Keranjang',
                                        text: 'Apakah Anda ingin menambah produk ini ke keranjang?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Tambahkan',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            cartForm.submit();
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const decrement = document.getElementById('decrement');
                        const increment = document.getElementById('increment');
                        const quantity = document.getElementById('quantity');
                        const checkoutQty = document.getElementById('checkout_quantity');
                        const cartQty = document.getElementById('cart_quantity');
                        const max = parseInt(quantity.max);

                        function updateAllQtyInputs(val) {
                            quantity.value = val;
                            if (checkoutQty) checkoutQty.value = val;
                            if (cartQty) cartQty.value = val;
                        }

                        decrement.addEventListener('click', function() {
                            let val = parseInt(quantity.value);
                            if (val > 1) {
                                updateAllQtyInputs(val - 1);
                            }
                        });

                        increment.addEventListener('click', function() {
                            let val = parseInt(quantity.value);
                            if (val < max) {
                                updateAllQtyInputs(val + 1);
                            }
                        });

                        // In case user changes input manually (if not readonly)
                        quantity.addEventListener('input', function() {
                            let val = parseInt(quantity.value);
                            if (isNaN(val) || val < 1) val = 1;
                            if (val > max) val = max;
                            updateAllQtyInputs(val);
                        });
                    });
                </script>
            </div>
        </div>
    </section>
    <section class="home_testi pb-30">
        <div class="home_testi_content flex flex-col items-start gap-15">
            <h2 class="Ulasan Pembeli">Ulasan Pembeli </h2>
            <div class="home_testi_content_footer pl-1">
                @include('components.testi-card')
            </div>
        </div>
    </section>
@endsection
