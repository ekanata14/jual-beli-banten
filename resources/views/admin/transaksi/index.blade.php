@extends('layouts.app')

@section('content')
    <div class="mb-4">
        {{-- <a href="{{ route('admin.kurir.create') }}" class="btn-primary">Tambah Kurir</a> --}}
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Pelanggan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nomor Resi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Penerima
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alamat Penerima
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Telepon
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Transaksi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Pengiriman
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->no_resi }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->Pengiriman->nama_penerima ?? "-" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->Pengiriman->alamat_penerima ?? "-" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->Pengiriman->telp_penerima ?? "-" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->unit_durasi }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->unit_durasi }}
                        </td>
                        <td class="px-6 py-4">
                            {{ 'Rp ' . number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            {{-- <a href="{{ route('admin.kurir.edit', $item->id_kurir) }}" class="btn-yellow">Edit</a>
                            <form action="{{ route('admin.kurir.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_kurir" value="{{ $item->id_kurir }}">
                                <button type="button" class="btn-danger" onclick="confirmDelete(this)">Delete</button>
                                <script>
                                    function confirmDelete(button) {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "You won't be able to revert this!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                button.closest('form').submit();
                                            }
                                        });
                                    }
                                </script>
                            </form> --}}
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