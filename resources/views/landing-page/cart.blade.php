@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <h3 class="text-black">Keranjang Belanja</h3>
            <p>{{ $datas->sum('jumlah') }} Produk</p>
            @php
                $totalPrice = 0;
            @endphp
            @foreach ($datas as $keranjang)
                @php
                    $itemTotal = $keranjang->jumlah * $keranjang->produk->harga;
                    $totalPrice += $itemTotal;
                @endphp
                <div class="product_container flex w-full mt-8 pb-10" data-id="{{ $keranjang->id }}">
                    <img src="{{ asset('storage/' . $keranjang->produk->foto) }}" alt="{{ $keranjang->produk->nama_produk }}"
                        class="w-50">
                    <div class="product_desc flex flex-col justify-between ml-10 w-full">
                        <div class="product_heading flex justify-between items-center">
                            <h4 class="text-black font-bold">{{ $keranjang->produk->nama_produk }}</h4>
                            <h4 class="text-black font-bold">Rp. {{ number_format($keranjang->produk->harga, 0, ',', '.') }}
                            </h4>
                        </div>
                        <div class="product_action flex justify-between items-center">
                            <div class="flex h-10">
                                <button type="button"
                                    class="decrement-btn flex justify-center items-center w-5 h-full rounded-s-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD]"
                                    data-id="{{ $keranjang->id }}">
                                    <p>-</p>
                                </button>
                                <span
                                    class="counter flex justify-center items-center px-4 text-black focus:outline-none bg-[#fff] h-full jumlah"
                                    data-id="{{ $keranjang->id }}">{{ $keranjang->jumlah }}</span>
                                <button type="button"
                                    class="increment-btn flex justify-center items-center w-5 h-full rounded-e-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD]"
                                    data-id="{{ $keranjang->id }}">
                                    <p>+</p>
                                </button>
                            </div>
                            <div class="ml-6 text-black font-semibold item-total" data-id="{{ $keranjang->id }}">
                                Total: Rp. {{ number_format($itemTotal, 0, ',', '.') }}
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST" class="remove-cart-form" data-id="{{ $keranjang->id }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $keranjang->id }}">
                                <button type="button" class="hover:text-[#FF9D00] text-red-600 remove-cart-btn cursor-pointer"
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

        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md">
            <h4 class="text-black ">Ringkasan</h4>
            <div class="product_sub flex justify-between mt-8">
                <p>Subtotal ({{ $datas->sum('jumlah') }} Produk)</p>
                <p id="subtotal">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>
            <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24">
                Checkout
            </x-button>
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
                        // Optionally, send AJAX to update on server
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
                                    // Update item total
                                    const harga = data.harga;
                                    const itemTotal = jumlah * harga;
                                    document.querySelector('.item-total[data-id="' + id + '"]').textContent =
                                        'Total: Rp. ' + itemTotal.toLocaleString('id-ID');
                                    // Update subtotal
                                    document.getElementById('subtotal').textContent = 'Rp. ' + data.totalPrice
                                        .toLocaleString('id-ID');
                                    // Update subtotal product count
                                    document.querySelector('.product_sub p').textContent =
                                        `Subtotal (${data.totalJumlah} Produk)`;
                                }
                            });
                    });
                });
            </script>
        @endpush

    </div>
@endsection
