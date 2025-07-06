@extends('layouts.landing')
@section('content')
    <div class="flex main_content py-40 px-4 md:px-36 gap-16" data-aos="fade-up">
        <div class="bg-white py-6 px-5 w-full rounded-md" data-aos="fade-up" data-aos-delay="100">
            <!-- Transaction History Card -->
            <div class="transaction-history mt-10" data-aos="fade-up" data-aos-delay="200">
                <h5 class="text-lg font-semibold mb-4" data-aos="fade-up" data-aos-delay="300">Riwayat Transaksi</h5>
                @if ($datas->count())
                    <div class="space-y-4">
                        @foreach ($datas as $index => $item)
                            <div
                                class="p-6 bg-white rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between"
                                data-aos="fade-up" data-aos-delay="{{ 400 + ($index * 100) }}">
                                <div class="flex flex-col gap-1" data-aos="fade-up" data-aos-delay="{{ 450 + ($index * 100) }}">
                                    <a href="{{ route('history.detail', $item->id) }}"
                                        class="text-lg font-semibold text-blue-600 hover:underline">{{ $item->invoice_number ?? '-' }}</a>
                                    <span
                                        class="text-sm text-gray-500">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span>
                                </div>

                                <div class="mt-4 md:mt-0 md:text-center" data-aos="fade-up" data-aos-delay="{{ 500 + ($index * 100) }}">
                                    <p class="text-sm text-gray-500">
                                        <span
                                            class="font-medium text-gray-900">{{ $item->orders->sum('jumlah') ?? '-' }}</span>
                                        items
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">IDR
                                            {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</span>
                                    </p>
                                </div>

                                <div class="mt-4 md:mt-0" data-aos="fade-up" data-aos-delay="{{ 550 + ($index * 100) }}">
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
                                </div>

                                <div class="mt-4 md:mt-0" data-aos="fade-up" data-aos-delay="{{ 600 + ($index * 100) }}">
                                    <a href="{{ route('history.detail', $item->id) }}"
                                        class="inline-block px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-100">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 text-center py-8" data-aos="fade-up" data-aos-delay="400">Belum ada riwayat transaksi.</div>
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
