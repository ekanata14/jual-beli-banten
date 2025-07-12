@extends('layouts.app')

@section('content')
    <div class="mb-4">
        {{-- <a href="{{ route('admin.kurir.create') }}" class="btn-primary">Tambah Kurir</a> --}}
        @if (Route::has('admin.pelanggan.transaksi.detail.show'))
            <a href="{{ route('admin.pelanggan.index') }}" class="btn-white">Back</a>
        @else
        @endif
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nomor Invoice
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Transaksi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah Item
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Transaksi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
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
        <div class="mt-4">
            {{ $datas->links() }}
        </div>
        </table>
    </div>
@endsection
