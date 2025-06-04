@extends('layouts.landing')
@section('content')
<div class="main_content py-32 px-56">
    <div class="flex justify-between">
        <h3>Profile Anda</h3>
        <x-primary-button>Edit Profile</x-primary-button>
    </div>
    <div class="profile_container w-full bg-white py-14 px-8 mt-15 rounded-md">
        <div class="Nama_lengkap">
            <h4 class="text-black">Nama Lengkap</h4>
            <p class="mt-1">Anak Agung Gede Agung Aditya Widnyana</p>
        </div>
        <div class="telp mt-6">
            <h4 class="text-black">Nomor Telepon</h4>
            <p class="mt-1">Anak Agung Gede Agung Aditya Widnyana</p>
        </div>
        <div class="Email mt-6">
            <h4 class="text-black">Email</h4>
            <p class="mt-1">cokadit1@gmail.com</p>
        </div>
        <div class="Alamat mt-6">
            <h4 class="text-black">Alamat</h4>
            <p class="mt-1">Jl. Raya Rangkan GG.Nusa Indah, Sukawati Gianyar</p>
        </div>
        <div class="riwayat mt-6">
            <h4 class="text-black">Riwayat Pembelian</h4>
            <p class="mt-1"><a href="#" class="text-[#FF9D00] hover:text-[#85562b]">Lihat Riwayat Pembelian Disini</a></p>
        </div>
    </div>
</div>
@endsection