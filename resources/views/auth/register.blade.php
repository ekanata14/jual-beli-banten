@extends('layouts.auth')
@section('content')
    <div class="flex flex-col md:flex-row justify-center items-center gap-2 h-screen w-full px-4">
        <div class="flex flex-col justify-center items-center gap-2 w-full md:w-1/2 mx-auto max-w-lg">
            <div class="logo flex justify-center items-center">
                <img src="{{ asset('assets/icons/bhakti_logo.svg') }}" alt="" class="h-12 md:h-16">
            </div>
            <!-- form section -->
            <div class="w-full flex flex-col gap-2">
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

                <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4 w-full">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nama -->
                        <div class="flex flex-col">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                                placeholder="Masukan Nama Anda" required value="{{ old('name') }}" />
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                                placeholder="Masukan Email Anda" required value="{{ old('email') }}" />
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Nomor Telepon -->
                        <div class="flex flex-col md:col-span-2">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" id="phone_number" name="phone_number"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3"
                                placeholder="Masukan Nomor Telepon Anda" required value="{{ old('phone_number') }}" />
                            @error('phone_number')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Alamat -->
                        <div class="flex flex-col md:col-span-2">
                            <label for="alamat_pelanggan">Alamat</label>
                            <textarea id="alamat_pelanggan" name="alamat_pelanggan"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3 resize-y min-h-[48px] max-h-40"
                                placeholder="Masukan Alamat Anda" required>{{ old('alamat_pelanggan') }}</textarea>
                            @error('alamat_pelanggan')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Kode Pos -->
                        <div class="flex flex-col col-span-2 md:w-1/2">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3 col-span-2"
                                placeholder="Masukan Kode Pos Anda" required value="{{ old('kode_pos') }}" />
                            @error('kode_pos')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Password & Konfirmasi Password in two columns on desktop -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div class="flex flex-col">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 my-3"
                                placeholder="Masukan Password Anda" required />
                            @error('password')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Konfirmasi Password -->
                        <div class="flex flex-col">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 my-3"
                                placeholder="Ulangi Password Anda" required />
                            @error('password_confirmation')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col md:items-center md:justify-between gap-2 w-full">
                        <a href="#" class="text-[#FF9D00] self-end md:self-auto">Lupa Password?</a>
                        <button type="submit" class="w-full">
                            <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="w-full md:w-auto">
                                Masuk Sekarang
                            </x-button>
                        </button>
                    </div>
                    <p class="text-center">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#FF9D00]">Masuk Disini</a></p>
                </form>
            </div>
        </div>
        <div class="hidden md:flex justify-center items-center w-1/2 h-full">
            <img src="{{ asset('assets/images/register_img.png') }}" alt="" class="max-w-full max-h-[80vh] object-contain">
        </div>
    </div>
@endsection
