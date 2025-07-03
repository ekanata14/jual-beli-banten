@extends('layouts.landing')
@section('content')
    <div class="flex justify-between main_content py-40 px-36 gap-16">
        <div class="right_content bg-white py-6 px-5 w-[40%] rounded-md">
            <!-- Transaction History Card -->
            <div class="transaction-history mt-10">
                <h5 class="text-lg font-semibold mb-4">Riwayat Transaksi</h5>
                @if($datas->count())
                    <div class="space-y-4">
                        @foreach($datas as $index => $data)
                            <div class="bg-gray-50 p-4 rounded shadow flex flex-col gap-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-700">No: {{ $index + 1 }}</span>
                                    <span class="text-xs text-gray-500">{{ $data->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <div><span class="font-semibold">Nama Pelanggan:</span> {{ $data->user->name ?? '-' }}</div>
                                        <div><span class="font-semibold">Nomor Resi:</span> {{ $data->nomor_resi ?? '-' }}</div>
                                        <div><span class="font-semibold">Nama Penerima:</span> {{ $data->nama_penerima ?? '-' }}</div>
                                        <div><span class="font-semibold">Alamat Penerima:</span> {{ $data->alamat_penerima ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <div><span class="font-semibold">Telepon:</span> {{ $data->telepon ?? '-' }}</div>
                                        <div><span class="font-semibold">Status Transaksi:</span> {{ $data->status_transaksi ?? '-' }}</div>
                                        <div><span class="font-semibold">Status Pengiriman:</span> {{ $data->status_pengiriman ?? '-' }}</div>
                                        <div><span class="font-semibold">Total Harga:</span> Rp. {{ number_format($data->total_harga, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('transaction.show', $data->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 text-center py-8">Belum ada riwayat transaksi.</div>
                @endif
            </div>
            @push('scripts')
                <script>
                    document.getElementById('checkout-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Lanjut ke Checkout?',
                            text: "Anda akan diarahkan ke halaman checkout.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#FF9D00',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, lanjut!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('checkout-form').submit();
                            }
                        });
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
