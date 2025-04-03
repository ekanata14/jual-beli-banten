@extends('layouts.app')

@section('content')
    <form class="bg-white p-8 rounded-xl" method="POST" action="{{ route('admin.produk.store') }}"
        enctype="multipart/form-data">
        @csrf
        {{-- <input type="hidden" id="id_penjual" name="id_penjual" value="{{ auth()->user()->id }}" /> --}}

        {{-- FOR PENJUAL --}}
        {{-- {{ auth()->guard('admin')->user()->id_admin }} --}}

        <div class="mb-6">
            <label for="penjual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penjual</label>
            <select id="penjual" name="id_admin"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
                <option value="" disabled selected>Pilih Penjual</option>
                @foreach ($penjuals as $penjual)
                    <option value="{{ $penjual->id_admin }}"
                        {{ old('penjual') == $penjual->id_admin || (isset($idPenjual) && $idPenjual == $penjual->id_admin) ? 'selected' : '' }}>
                        {{ $penjual->nama }}
                    </option>
                @endforeach
            </select>
            @error('penjual')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="nama_produk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                Produk</label>
            <input type="text" id="nama_produk" name="nama_produk"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nama Produk" value="{{ old('nama_produk') }}" required />
            @error('nama_produk')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="deskripsi_produk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                Produk</label>
            <textarea id="deskripsi_produk" name="deskripsi_produk"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Deskripsi Produk" required>{{ old('deskripsi_produk') }}</textarea>
            @error('deskripsi_produk')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
            <input type="number" id="harga" name="harga"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Harga Produk" value="{{ old('harga') }}" required />
            @error('harga')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
            <input type="number" id="stok" name="stok"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Jumlah Stok" value="{{ old('stok') }}" required />
            @error('stok')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
            <input type="text" id="kategori" name="kategori"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Kategori Produk" value="{{ old('kategori') }}" required />
            @error('kategori')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Produk</label>
            <input type="file" id="foto" name="foto"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            @error('foto')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="berat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berat (gram)</label>
            <input type="number" id="berat" name="berat"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Berat Produk dalam gram" value="{{ old('berat') }}" required />
            @error('berat')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Submit</button>
        <a href={{ route('admin.produk.index') }} class="btn-white">Back</a>
    </form>
@endsection
