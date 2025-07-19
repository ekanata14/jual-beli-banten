@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap gap-4 mb-6">
        <!-- Responsive Cards: Total Pemasukan, Paid, Pending -->
        <div class="w-full flex flex-wrap gap-4 mb-6">
            <!-- Total Pemasukan -->
            <div
                class="flex-1 min-w-[220px] max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
                <a href="{{ route('admin.transaksi.index') }}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                        {{ 'Rp ' . number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Pemasukan</p>
                <a href="{{ route('admin.transaksi.index') }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Detail
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
            <!-- Total Paid -->
            <div
                class="flex-1 min-w-[220px] max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-700 dark:text-green-400 text-center">
                    {{ 'Rp ' . number_format($totalPaid ?? 0, 0, ',', '.') }}</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Paid</p>
                <a href="{{ route('admin.transaksi.index', ['status' => 'paid']) }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Detail
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
            <!-- Total Pending -->
            <div
                class="flex-1 min-w-[220px] max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-yellow-700 dark:text-yellow-400 text-center">
                    {{ 'Rp ' . number_format($totalPending ?? 0, 0, ',', '.') }}</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-center">Total Pending</p>
                <a href="{{ route('admin.transaksi.index', ['status' => 'pending']) }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                    Detail
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="mb-4">
        {{-- <a href="{{ route('admin.kurir.create') }}" class="btn-primary">Tambah Kurir</a> --}}
        @if (request()->routeIs('admin.transaksi.index'))
        @elseif(request()->routeIs('admin.transaksi.filter'))
        @else
            <a href="{{ route('admin.pelanggan.index') }}" class="btn-white">Back</a>
        @endif
    </div>
    @if (request()->routeIs('admin.transaksi.index'))
        <form method="GET" action="{{ route('admin.transaksi.filter') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        @else
            @if ($user)
                <form method="GET" action="{{ route('admin.pelanggan.transaksi.detail.filter', $user->id) }}"
                    class="mb-6 flex flex-wrap gap-4 items-end">
                @else
                    <form method="GET" action="{{ route('admin.transaksi.filter') }}"
                        class="mb-6 flex flex-wrap gap-4 items-end">
            @endif
    @endif
    <div>
        <label for="penjual_id" class="block text-sm font-medium text-gray-700">Penjual</label>
        <select name="penjual_id" id="penjual_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">-- Semua Penjual --</option>
            @foreach ($penjuals as $penjual)
                <option value="{{ $penjual->id }}" {{ request('penjual_id') == $penjual->id ? 'selected' : '' }}>
                    {{ $penjual->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="produk_id" class="block text-sm font-medium text-gray-700">Produk</label>
        <select name="produk_id" id="produk_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">-- Semua Produk --</option>
            @foreach ($produks as $produk)
                <option value="{{ $produk->id }}" {{ request('produk_id') == $produk->id ? 'selected' : '' }}>
                    {{ $produk->nama_produk }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="tanggal_dari" class="block text-sm font-medium text-gray-700">Tanggal Dari</label>
        <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700">Tanggal Sampai</label>
        <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
        @if ($user)
            @if (request()->routeIs('admin.transaksi.index'))
                <a href="{{ route('admin.transaksi.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md ml-2">Reset</a>
            @else
                <a href="{{ route('admin.pelanggan.transaksi.detail', $user->id) }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md ml-2">Reset</a>
            @endif
        @else
            <a href="{{ route('admin.transaksi.index') }}"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md ml-2">Reset</a>
        @endif
    </div>
    </form>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="default-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            No
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Nomor Invoice
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Tanggal Transaksi
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Jumlah Item
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Total Harga
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Status Transaksi
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="flex items-center">
                            Actions
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
                @foreach ($datas as $index => $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration }}
                        </th>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.transaksi.detail', $item->id) }}"
                                class="text-blue-600 hover:underline">
                                {{ $item->invoice_number ?? '-' }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->orders->sum('jumlah') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ 'Rp ' . number_format($item->total_harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
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
                        <td class="px-6 py-4">
                            @if (Route::has('admin.pelanggan.transaksi.detail.show'))
                                <a href="{{ route('admin.pelanggan.transaksi.detail.show', $item->id) }}"
                                    class="inline-block px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-100">
                                    Detail
                                </a>
                            @else
                                <a href="{{ route('admin.transaksi.detail', $item->id) }}"
                                    class="inline-block px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-100">
                                    Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
