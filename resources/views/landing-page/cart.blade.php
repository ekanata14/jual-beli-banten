@extends('layouts.landing')
@section('content')
    <div
        class="main_content flex flex-col lg:flex-row justify-between py-20 lg:py-40 px-4 md:px-12 lg:px-36 gap-8 lg:gap-16">
        <div class="left_content w-full lg:w-[60%]" data-aos="fade-up">
            <h3 class="text-black text-xl md:text-2xl font-bold">Keranjang Belanja</h3>
            <p class="text-base md:text-lg">{{ $datas->sum('jumlah') }} Produk</p>
            @php
                $totalPrice = 0;
            @endphp
            @foreach ($datas as $keranjang)
                @php
                    $itemTotal = $keranjang->jumlah * $keranjang->produk->harga;
                    $totalPrice += $itemTotal;
                @endphp
                <div class="product_container flex flex-col md:flex-row w-full mt-8 pb-10 border-b border-gray-200"
                    data-id="{{ $keranjang->id }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <img src="{{ asset('storage/' . $keranjang->produk->foto) }}" alt="{{ $keranjang->produk->nama_produk }}"
                        class="w-32 h-32 object-cover rounded-md mx-auto md:mx-0">
                    <div class="product_desc flex flex-col justify-between md:ml-10 w-full mt-4 md:mt-0">
                        <div
                            class="product_heading flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                            <div class="flex flex-col gap-2">
                                <h4 class="text-black font-bold text-lg">{{ $keranjang->produk->nama_produk }}</h4>
                                <h5 class="text-black font-bold text-md">{{ $keranjang->produk->user->name }}</h5>
                            </div>
                            <h4 class="text-black font-bold text-base">Rp.
                                {{ number_format($keranjang->produk->harga, 0, ',', '.') }}</h4>
                        </div>
                        <div
                            class="product_action flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mt-4">
                            <div class="flex h-10">
                                <button type="button"
                                    class="decrement-btn flex justify-center items-center w-8 h-full rounded-s-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD] cursor-pointer"
                                    data-id="{{ $keranjang->id }}">
                                    <p>-</p>
                                </button>
                                <span
                                    class="counter flex justify-center items-center px-4 text-black focus:outline-none bg-[#fff] h-full jumlah"
                                    data-id="{{ $keranjang->id }}">{{ $keranjang->jumlah }}</span>
                                <button type="button"
                                    class="increment-btn flex justify-center items-center w-8 h-full rounded-e-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD] cursor-pointer"
                                    data-id="{{ $keranjang->id }}">
                                    <p>+</p>
                                </button>
                            </div>
                            <div class="ml-0 md:ml-6 text-black font-semibold item-total" data-id="{{ $keranjang->id }}">
                                Total: Rp. {{ number_format($itemTotal, 0, ',', '.') }}
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST" class="remove-cart-form"
                                data-id="{{ $keranjang->id }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $keranjang->id }}">
                                <button type="button"
                                    class="hover:text-[#FF9D00] text-red-600 remove-cart-btn cursor-pointer text-sm md:text-base"
                                    data-id="{{ $keranjang->id }}">X Hapus Produk</button>
                            </form>
                            @push('scripts')
                                <script>
                                    document.querySelectorAll('.remove-cart-btn').forEach(function(btn) {
                                        btn.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const id = this.getAttribute('data-id');
                                            const form = document.querySelector('.remove-cart-form[data-id="' + id + '"]');
                                            Swal.fire({
                                                title: 'Hapus produk dari keranjang?',
                                                text: "Produk akan dihapus dari keranjang Anda.",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#FF9D00',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit();
                                                }
                                            });
                                        });
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="right_content bg-white py-6 px-5 w-full lg:w-[40%] rounded-md shadow-md" data-aos="fade-left">
            <h4 class="text-black text-lg font-bold">Ringkasan</h4>
            <div class="product_sub flex justify-between mt-8">
                <p>Subtotal ({{ $datas->sum('jumlah') }} Produk)</p>
                <p id="subtotal">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>
            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <x-button type="button" id="checkout-btn" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                    class="mt-16 w-full">
                    Checkout
                </x-button>
            </form>
            @push('scripts')
                <script>
                    document.getElementById('checkout-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Lanjut ke Checkout?',
                            text: "Anda akan diarahkan ke halaman checkout.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#FF9D00',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, lanjut!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('checkout-form').submit();
                            }
                        });
                    });
                </script>
            @endpush
        </div>

        @push('scripts')
            <script>
                document.querySelectorAll('.decrement-btn, .increment-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const isIncrement = this.classList.contains('increment-btn');
                        const jumlahSpan = document.querySelector('.counter[data-id="' + id + '"]');
                        let jumlah = parseInt(jumlahSpan.textContent);
                        if (isIncrement) {
                            jumlah++;
                        } else if (jumlah > 1) {
                            jumlah--;
                        }
                        fetch("{{ route('cart.update') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    id: id,
                                    quantity: jumlah
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    jumlahSpan.textContent = jumlah;
                                    const harga = data.harga;
                                    const itemTotal = jumlah * harga;
                                    document.querySelector('.item-total[data-id="' + id + '"]').textContent =
                                        'Total: Rp. ' + itemTotal.toLocaleString('id-ID');
                                    document.getElementById('subtotal').textContent = 'Rp. ' + data.totalPrice
                                        .toLocaleString('id-ID');
                                    document.querySelector('.product_sub p').textContent =
                                        `Subtotal (${data.totalJumlah} Produk)`;
                                }
                            });
                    });
                });
            </script>
            <!-- AOS JS init -->
            <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
            <script>
                AOS.init({
                    duration: 700,
                    once: true,
                });
            </script>
        @endpush

        <!-- AOS CSS -->
        @push('styles')
            <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
        @endpush

    </div>
@endsection
