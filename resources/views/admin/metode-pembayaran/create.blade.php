@extends('layouts.app')

@section('content')
    <form class="bg-white p-8 rounded-xl" method="POST" action="{{ route('admin.metode-pembayaran.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label for="nama_metode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Metode</label>
            <input type="text" id="nama_metode" name="nama_metode"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nama Metode" value="{{ old('nama_metode') }}" required />
            @error('nama_metode')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="tipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe</label>
            <input type="text" id="tipe" name="tipe"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Tipe" value="{{ old('tipe') }}" required />
            @error('tipe')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode</label>
            <input type="text" id="kode" name="kode"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Kode" value="{{ old('kode') }}" required />
            @error('kode')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="logo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo</label>
            <input type="file" id="logo" name="logo"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            @error('logo')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn-primary">Submit</button>
        <a href={{ route('admin.admin.index') }} class="btn-white">Back</a>
    </form>
@endsection
