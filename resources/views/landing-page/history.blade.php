@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md">
            <h4 class="text-black ">Ringkasan</h4>
            <div class="product_sub flex justify-between mt-8">
                <p>Subtotal ({{ $datas->sum('jumlah') }} Produk</p>
                {{-- <p id="subtotal">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</p> --}}
            </div>
            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <x-button type="button" id="checkout-btn" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                    class="mt-24">
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
