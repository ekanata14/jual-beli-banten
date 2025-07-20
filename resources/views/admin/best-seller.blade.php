@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
            class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
            <a href="{{ route('admin.penjual.index') }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    {{ $totalPenjual }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Penjual</p>
            <a href="{{ route('admin.penjual.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
        <div
            class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
            <a href="{{ route('admin.pelanggan.index') }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    {{ $totalPelanggan }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Pelanggan</p>
            <a href="{{ route('admin.pelanggan.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
        <div
            class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
            <a href="{{ route('admin.transaksi.index') }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    {{ $totalTransaksi }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Transaksi</p>
            <a href="{{ route('admin.transaksi.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
        <div
            class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
            <a href="{{ route('admin.transaksi.index') }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    {{ 'Rp ' . number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Pemasukan</p>
            <a href="{{ route('admin.transaksi.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Detail
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-col gap-8 mt-12">
        <div>
            <ul class="flex border-b mb-4" id="dashboardTabs" role="tablist">
                <li class="mr-2">
                    <a class="inline-block px-4 py-2 {{ (request()->routeIs('admin.dashboard') || request()->routeIs('admin.dashboard.*')) && !request()->routeIs('admin.dashboard.best-seller') && !request()->routeIs('admin.dashboard.best-seller.*') ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent' }} border-b-2 font-bold focus:outline-none"
                        id="transaksi-tab" data-tab="transaksi" type="button" role="tab" aria-controls="transaksi"
                        aria-selected="{{ (request()->routeIs('admin.dashboard') || request()->routeIs('admin.dashboard.*')) && !request()->routeIs('admin.dashboard.best-seller') && !request()->routeIs('admin.dashboard.best-seller.*') ? 'true' : 'false' }}"
                        href="{{ route('admin.dashboard') }}">
                        Transaksi
                    </a>
                </li>
                <li class="mr-2">
                    <a class="inline-block px-4 py-2 {{ request()->routeIs('admin.dashboard.best-seller') || request()->routeIs('admin.dashboard.best-seller.*') ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent' }} border-b-2 font-bold focus:outline-none"
                        id="produk-terlaris-tab" data-tab="produk-terlaris" type="button" role="tab"
                        aria-controls="produk-terlaris"
                        aria-selected="{{ request()->routeIs('admin.dashboard.best-seller') || request()->routeIs('admin.dashboard.best-seller.*') ? 'true' : 'false' }}"
                        href="{{ route('admin.dashboard.best-seller') }}">
                        Produk Terlaris
                    </a>
                </li>
            </ul>
        </div>
        <div id="produk-terlaris-tab-content">
            <div class="relative overflow-x-auto">
                <p class="text-2xl md:text-3xl text-black mb-4">Produk Terlaris</p>

                <form method="GET" action="{{ route('admin.dashboard.best-seller.filter') }}"
                    class="mb-6 flex flex-wrap gap-4 items-end">
                    <div class="w-full md:w-auto">
                        <label for="penjual_id" class="block text-sm font-medium text-gray-700">Penjual</label>
                        <select name="penjual_id" id="penjual_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Semua Penjual --</option>
                            @foreach ($penjuals as $penjual)
                                <option value="{{ $penjual->id }}"
                                    {{ request('penjual_id') == $penjual->id ? 'selected' : '' }}>
                                    {{ $penjual->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-auto">
                        <label for="produk_id" class="block text-sm font-medium text-gray-700">Produk</label>
                        <select name="produk_id" id="produk_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Semua Produk --</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}"
                                    {{ request('produk_id') == $produk->id ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-auto">
                        <label for="tanggal_dari" class="block text-sm font-medium text-gray-700">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari"
                            value="{{ request('tanggal_dari') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="w-full md:w-auto">
                        <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                            value="{{ request('tanggal_sampai') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                        <a href="{{ route('admin.dashboard.best-seller') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Reset</a>
                    </div>
                </form>
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        id="default-table-2">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <span class="flex items-center">
                                        No
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="flex items-center">
                                        Nama Produk
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="flex items-center">
                                        Nama Penjual
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="flex items-center">
                                        Total Terjual
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="flex items-center">
                                        Total Pendapatan
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (collect($produkTerlaris)->sortByDesc('total_terjual') as $index => $produk)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-4 py-4">
                                        {{ $produk['nama_produk'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        {{-- You may need to fetch user name by id if not available in $produk --}}
                                        @php
                                            $penjual = $penjuals->firstWhere('id', $produk['id_user']);
                                        @endphp
                                        {{ $penjual ? $penjual->name : '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        {{ $produk['total_terjual'] ?? 0 }}
                                    </td>
                                    <td class="px-4 py-4">
                                        {{ 'Rp ' . number_format((float) ($produk['harga'] ?? 0) * (int) ($produk['total_terjual'] ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transaksiTab = document.getElementById('transaksi-tab');
            const produkTerlarisTab = document.getElementById('produk-terlaris-tab');
            const transaksiContent = document.getElementById('transaksi-tab-content');
            const produkTerlarisContent = document.getElementById('produk-terlaris-tab-content');

            transaksiTab.addEventListener('click', function() {
                transaksiTab.classList.add('text-blue-600', 'border-blue-600');
                transaksiTab.classList.remove('text-gray-600', 'border-transparent');
                produkTerlarisTab.classList.remove('text-blue-600', 'border-blue-600');
                produkTerlarisTab.classList.add('text-gray-600', 'border-transparent');
                transaksiContent.classList.remove('hidden');
                produkTerlarisContent.classList.add('hidden');
            });

            produkTerlarisTab.addEventListener('click', function() {
                produkTerlarisTab.classList.add('text-blue-600', 'border-blue-600');
                produkTerlarisTab.classList.remove('text-gray-600', 'border-transparent');
                transaksiTab.classList.remove('text-blue-600', 'border-blue-600');
                transaksiTab.classList.add('text-gray-600', 'border-transparent');
                produkTerlarisContent.classList.remove('hidden');
                transaksiContent.classList.add('hidden');
            });
        });
    </script>
@endsection
