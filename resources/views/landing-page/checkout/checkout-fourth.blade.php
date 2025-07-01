@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="left_content w-[60%]">
            <!-- pembayaran -->
            <div class="checkout_container">
                <h3 class="text-black">Pembayaran</h3>
                <div class="informasi_data mt-9">
                    <p>Bank BCA</p>
                </div>
            </div>
            <!-- form pembayaran -->
            <div class="checkout_form informasi_anda_form">
                <form action="#" method="">
                    <!-- input nama -->
                    <div class="w-full">
                        <!-- Modal toggle -->
                        <button data-modal-target="select-modal-pembayaran" data-modal-toggle="select-modal-pembayaran"
                            class="modal-btn w-full py-5 bg-[#fff] hover:bg-[#F9F9F9] rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                            type="button">
                            Pilih Pembayaran
                        </button>
                        @include('components.modal-payment')
                    </div>
                    <x-button href="{{ route('checkout.fourth') }}" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                        class="mt-15">
                        Lanjut Ke Pembayaran
                    </x-button>
                </form>
            </div>

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
