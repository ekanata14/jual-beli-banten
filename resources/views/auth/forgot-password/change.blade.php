@extends('layouts.auth')
@section('content')
    <div class="flex justify-center items-center h-screen gap-8 bg-[#faf6ed]">
        <div class="order-2 lg:order-1 flex flex-col justify-center p-10 gap-40 w-full">
            <div class="logo flex justify-center items-center mb-10">
                <img src="{{ asset('assets/icons/bhakti_logo.svg') }}" alt="">
            </div>
            <!-- form section -->
            <div class="flex flex-col gap-15 px-0 md:px-15">
                <div class="text-center">
                    <h3 class="text-black">Ganti Password</h3>
                    <p class="mt-1">Silakan masukkan password baru Anda untuk <span class="text-[#FF9D00]">Bhakti👋</span>
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('forgot.password.store') }}" class="flex flex-col gap-5">
                    @csrf
                    <!-- Hidden Email Input -->
                    <input type="hidden" name="email" value="{{ old('email', $email) }}" />

                    <!-- Password -->
                    <div>
                        <label for="password">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Password Baru" required />
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Konfirmasi Password Baru" required />
                    </div>

                    <button type="submit">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
                            Simpan Password Baru
                        </x-button>
                    </button>
                </form>
            </div>
        </div>
        <div class="order-1 lg:order-2 hidden md:flex justify-center items-center w-full">
            <img src="{{ asset('assets/images/login_img.png') }}" alt="">
        </div>
    </div>
@endsection
