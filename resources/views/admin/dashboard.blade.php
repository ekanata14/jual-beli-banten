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
        <div class="relative overflow-x-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Transaksi</h2>
            <form method="GET" action="{{ route('admin.dashboard.transaksi.filter') }}"
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
                    <select name="produk_id" id="produk_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                    <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="w-full md:w-auto">
                    <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Reset</a>
                </div>
            </form>
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Nomor Invoice</th>
                            <th scope="col" class="px-4 py-3">Tanggal Transaksi</th>
                            <th scope="col" class="px-4 py-3">Jumlah Item</th>
                            <th scope="col" class="px-4 py-3">Total Harga</th>
                            <th scope="col" class="px-4 py-3">Status Transaksi</th>
                            <th scope="col" class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $index => $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration }}
                                </th>
                                <td class="px-4 py-4">
                                    <a href="{{ route('admin.transaksi.detail', $item->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $item->invoice_number ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-4 py-4">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $item->orders->sum('jumlah') ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ 'Rp ' . number_format($item->total_harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4">
                                    @if ($item->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">
                                            Pending
                                        </span>
                                    @elseif ($item->status === 'denied')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded bg-red-100 text-red-800 text-xs font-medium">
                                            Denied
                                        </span>
                                    @elseif ($item->status === 'waiting')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-medium">
                                            Waiting
                                        </span>
                                    @elseif ($item->status === 'paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded bg-green-100 text-green-800 text-xs font-medium">
                                            Paid
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-100 text-gray-800 text-xs font-medium">
                                            {{ ucfirst($item->status_pembayaran ?? 'Unknown') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('admin.transaksi.detail', $item->id) }}"
                                        class="inline-block px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-100">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Produk Terlaris</h2>
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Nama Produk</th>
                            <th scope="col" class="px-4 py-3">Nama Penjual</th>
                            <th scope="col" class="px-4 py-3">Total Terjual</th>
                            <th scope="col" class="px-4 py-3">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produkTerlaris->sortByDesc(function ($produk) {
            return $produk->orders->sum('jumlah');
        }) as $index => $produk)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration }}
                                </th>
                                <td class="px-4 py-4">
                                    {{ $produk->nama_produk ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $produk->user->name ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $produk->orders->sum('jumlah') ?? 0 }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ 'Rp ' . number_format($produk->orders->sum('subtotal') ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
