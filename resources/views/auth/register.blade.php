@extends('layouts.app')
@section('content')
<div class="main_content flex w-full justify-between items-center">
    <div class="left_content flex flex-col justify-start p-10 gap-15 w-[60vw] h-[100vh]">
        <div class="logo">
            <img src="../assets/icons/bhakti_logo.svg" alt="">
        </div>
        <!-- form section -->
        <div class="main_container flex flex-col gap-15 px-15">
            <div class="login_heading text-center">
                <h3 class="text-black">Daftar Akun Baru</h3>
                <p class="mt-1">Selamat datang di <span class="text-[#FF9D00]">Bhakti👋</span></p>
            </div>
            
            <form method="" action="#" class="flex flex-col gap-5">
                <!-- Email Address -->
                <div>
                    <label for="name">Nama</label>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3" placeholder="Masukan Nama Anda" required />
                </div>
                <div>
                    <label for="phone_number">Nomor Telepon</label>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3" placeholder="Masukan Nomor Telepon Anda" required />
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mt-3" placeholder="Masukan Email Anda" required />
                </div>
                <div class="flex flex-col">
                    <label for="email">Password</label>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 my-3" placeholder="Masukan Password Anda" required/>
                    <a href="#" class="text-[#FF9D00] self-end">Lupa Password?</a>
                </div>
                <x-button href="#" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-24 w-full">
                    Masuk Sekarang
                </x-button>
                <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#FF9D00]">Masuk Disini</a></p>
            </form>
        </div>
        
    </div>
    <div class="right_content m-1">
        <img src="../assets/images/register_img.png" alt="">
    </div>
</div>
@endsection