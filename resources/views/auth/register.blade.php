@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center gap-8 h-screen">
        <div class="flex flex-col justify-center items-center gap-15 w-full md:w-1/2">
            <div class="logo">
                <img src="../assets/icons/bhakti_logo.svg" alt="">
            </div>
            <!-- form section -->
            <div class="w-full flex flex-col gap-15">
                <div class="login_heading text-center">
                    <h3 class="text-black">Daftar Akun Baru</h3>
                    <p class="mt-1">Selamat datang di <span class="text-[#FF9D00]">Bhakti👋</span></p>
                </div>

                {{-- Display all errors at the top --}}
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
                    @csrf
                    <!-- Nama -->
                    <div>
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Nama Anda" required value="{{ old('name') }}" />
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Email Anda" required value="{{ old('email') }}" />
                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone_number">Nomor Telepon</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Nomor Telepon Anda" required value="{{ old('phone_number') }}" />
                        @error('phone_number')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Alamat -->
                    <div>
                        <label for="alamat_pelanggan">Alamat</label>
                        <textarea id="alamat_pelanggan" name="alamat_pelanggan"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                            placeholder="Masukan Alamat Anda" required>{{ old('alamat_pelanggan') }}</textarea>
                        @error('alamat_pelanggan')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div class="flex flex-col">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 my-3"
                            placeholder="Masukan Password Anda" required />
                        @error('password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="flex flex-col">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 my-3"
                            placeholder="Ulangi Password Anda" required />
                        @error('password_confirmation')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                        <a href="#" class="text-[#FF9D00] self-end">Lupa Password?</a>
                    <button type="submit">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
                            Masuk Sekarang
                        </x-button>
                    </button>
                    <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#FF9D00]">Masuk Disini</a></p>
                </form>
            </div>
        </div>
        <div class="flex justify-center items-center w-full md:w-1/2">
            <img src="../assets/images/register_img.png" alt="">
        </div>
    </div>
@endsection
