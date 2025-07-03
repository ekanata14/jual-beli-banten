@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.metode-pembayaran.create') }}" class="btn-primary">Tambah Metode Pembayaran</a>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Metode
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kode
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Logo
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
                            {{ $item->nama_metode }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->tipe }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->kode }}
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="h-8">
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.metode-pembayaran.edit', $item->id_metode) }}" class="btn-yellow">Edit</a>
                            <form action="{{ route('admin.metode-pembayaran.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_metode" value="{{ $item->id_metode }}">
                                <button type="button" class="btn-danger" onclick="confirmInactive(this)">Nonaktifkan</button>
                                <script>
                                    function confirmInactive(button) {
                                        Swal.fire({
                                            title: 'Nonaktifkan metode pembayaran?',
                                            text: "Metode pembayaran akan dinonaktifkan dan tidak dapat digunakan.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, nonaktifkan'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                button.closest('form').submit();
                                            }
                                        });
                                    }
                                </script>
                            </form>
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
