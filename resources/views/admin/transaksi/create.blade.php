@extends('layouts.app')

@section('content')
    <form class="bg-white p-8 rounded-xl" method="POST" action="{{ route('admin.kurir.store') }}">
        @csrf
        <div class="mb-6">
            <label for="kode_kurir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Kurir</label>
            <input type="text" id="kode_kurir" name="kode_kurir"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Kode Kurir" value="{{ old('kode_kurir') }}" required />
            @error('kode_kurir')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="nama_kurir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kurir</label>
            <input type="text" id="nama_kurir" name="nama_kurir"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nama Kurir" value="{{ old('nama_kurir') }}" required />
            @error('nama_kurir')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="kode_servis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                Servis</label>
            <input type="text" id="kode_servis" name="kode_servis"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Kode Servis" value="{{ old('kode_servis') }}" required />
            @error('kode_servis')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="nama_servis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                Servis</label>
            <input type="text" id="nama_servis" name="nama_servis"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nama Servis" value="{{ old('nama_servis') }}" required />
            @error('nama_servis')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="rentan_durasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rentan
                Durasi</label>
            <input type="number" id="rentan_durasi" name="rentan_durasi"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Rentan Durasi" value="{{ old('rentan_durasi') }}" required />
            @error('rentan_durasi')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="unit_durasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit
                Durasi</label>
            <input type="text" id="unit_durasi" name="unit_durasi"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Unit Durasi" value="{{ old('unit_durasi') }}" required />
            @error('unit_durasi')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn-primary">Submit</button>
        <a href={{ route('admin.admin.index') }} class="btn-white">Back</a>
    </form>
@endsection
