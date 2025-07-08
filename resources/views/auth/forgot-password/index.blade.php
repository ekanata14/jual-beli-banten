@extends('layouts.auth')
@section('content')
    <div class="flex justify-center items-center h-screen gap-8">
        <div class="order-2 lg:order-1 flex flex-col justify-center p-10 gap-40 w-full">
            <div class="logo flex justify-center items-center mb-10">
                <img src="../assets/icons/bhakti_logo.svg" alt="">
            </div>
            <!-- form section -->
            <div class="flex flex-col gap-15 px-0 md:px-15">
                <div class="text-center">
                    <h3 class="text-black">Lupa Password</h3>
                    <p class="mt-1">Masukkan email Anda untuk mengatur ulang password</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 text-green-700 bg-green-100 border border-green-400 px-4 py-3 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('forgot.password.find.email') }}" class="flex flex-col gap-5">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Email Anda" required value="{{ old('email') }}" />
                    </div>

                    <button type="submit">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
                            Reset Password
                        </x-button>
                    </button>
                    <p>Sudah ingat password? <a href="{{ route('login') }}" class="text-[#FF9D00]">Masuk Disini</a></p>
                </form>
            </div>
        </div>
        <div class="order-1 lg:order-2 hidden md:flex justify-center items-center w-full">
            <img src="../assets/images/login_img.png" alt="">
        </div>
    </div>
@endsection
