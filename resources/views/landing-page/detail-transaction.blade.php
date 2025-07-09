@extends('layouts.landing')
@section('content')
    <!-- Add AOS CSS -->
    <div class="main_content py-10 px-4 md:py-40 md:px-36 flex flex-col justify-center items-center mt-20">
        <div class="heading flex flex-col md:flex-row md:justify-between w-full gap-4" data-aos="fade-up">
            <h3 class="text-black text-xl md:text-2xl">Detail Transaksi</h3>
            <a href="{{ route('history') }}" class="text-blue-600 hover:underline text-sm md:text-base">Kembali ke halaman
                transaksi</a>
        </div>
        <div class="transaction_container bg-white py-6 px-4 md:py-9 md:px-14 mt-10 md:mt-20 w-full md:w-10/12 flex flex-col rounded-lg shadow"
            data-aos="fade-up">
            <!-- section 1 -->
            <div class="section_one pb-6 md:pb-9">
                <div class="flex flex-col md:flex-row md:justify-between mb-6 md:mb-9 gap-4" data-aos="fade-up">
                    <div class="order_id">
                        <p class="text-sm">Order ID</p>
                        <h4 class="text-black font-semibold mt-2 md:mt-4 text-base md:text-lg">{{ $data->invoice_number }}
                        </h4>
                    </div>
                    <div class="status_transaksi">
                        <p class="mb-2 md:mb-4 text-sm">Status</p>

                        @if ($data->status === 'pending')
                            <span
                                class="py-2 px-4 md:py-3 md:px-5 bg-yellow-100 text-yellow-800 rounded-md text-sm md:text-base">Pending</span>
                        @elseif ($data->status === 'denied')
                            <span
                                class="py-2 px-4 md:py-3 md:px-5 bg-red-100 text-red-800 rounded-md text-sm md:text-base">Denied</span>
                        @elseif ($data->status === 'waiting')
                            <span
                                class="py-2 px-4 md:py-3 md:px-5 bg-blue-100 text-blue-800 rounded-md text-sm md:text-base">Waiting</span>
                        @elseif ($data->status === 'paid')
                            <span
                                class="py-2 px-4 md:py-3 md:px-5 bg-green-100 text-green-800 rounded-md text-sm md:text-base">Paid</span>
                        @else
                            <span
                                class="py-2 px-4 md:py-3 md:px-5 bg-gray-100 text-gray-800 rounded-md text-sm md:text-base">{{ ucfirst($data->status ?? 'Unknown') }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-sm">No Resi</p>
                <h4 class="text-black font-semibold mt-2 md:mt-4 text-base md:text-lg">-</h4>
            </div>
            <!-- section 2 -->
            <div class="section_two mt-6 md:mt-9">
                <div class="flex flex-col md:flex-row md:justify-between gap-4" data-aos="fade-up">
                    <div class="tanggal_order">
                        <p class="text-sm">Tanggal Order</p>
                        <p class="text-black mt-2 md:mt-4 text-base">{{ $data->tanggal_transaksi }}</p>
                    </div>
                    <div class="kurir_order">
                        <p class="text-sm">Kurir</p>
                        <p class="text-black mt-2 md:mt-4 text-base">Grab Instant</p>
                    </div>
                    <div class="berat_order">
                        <p class="text-sm">Berat</p>
                        <p class="text-black mt-2 md:mt-4 text-base">4 Kg</p>
                    </div>
                    <div class="metode_order">
                        <p class="text-sm">Metode Pembayaran</p>
                        <p class="text-black mt-2 md:mt-4 text-base">Midtrans</p>
                    </div>
                </div>

                <div class="alamat_penerima mt-6 md:mt-9 pb-6 md:pb-9" data-aos="fade-up">
                    <p class="text-sm">Alamat Penerima</p>
                    <p class="text-black mt-2 md:mt-4 text-base">{{ $data->pengiriman->nama_penerima }}</p>
                    <p class="text-black text-base">{{ $data->pengiriman->telp_penerima }}</p>
                    <p class="text-black text-base">{{ $data->pengiriman->alamat_penerima }}</p>
                    <p class="text-black text-base">Kode Pos: {{ $data->pengiriman->kode_pos_penerima }}</p>
                    <p class="text-black text-base">Latitude: {{ $data->pengiriman->latitude_penerima }}</p>
                    <p class="text-black text-base">Longitude: {{ $data->pengiriman->longitude_penerima }}</p>
                </div>
            </div>
            <!-- section 3 -->
            <div class="section_three mt-6 md:mt-9" data-aos="fade-up">
                <p class="text-base md:text-lg">Informasi Produk</p>
                @php
                    $subtotal = $data->orders->sum('subtotal');
                @endphp
                @forelse($data->orders as $item)
                    <div class="informasi_produk mt-4 mb-4 flex flex-col md:flex-row md:justify-between gap-4 items-center bg-gray-50 p-4 rounded"
                        data-aos="fade-up">
                        <img src="{{ asset($item->produk->foto ?? 'assets/images/product_img.png') }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded">
                        <div class="informasi_produk flex flex-col gap-2 flex-1">
                            <h4 class="text-black text-base">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p class="text-sm">Penjual : {{ $item->produk->user->name ?? '-' }}</p>
                            <p class="text-sm">Kuantiti : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-sm">Berat Barang : {{ $item->produk->berat ?? '-' }}g</p>
                        </div>
                        <h4 class="text-black text-base md:text-lg">Rp.
                            {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-8">Tidak ada produk dalam transaksi ini.</div>
                @endforelse
            </div>
            <!-- section 3 -->
            @php
                // Get all unique pengiriman from orders (in case of multiple shipping data)
                $pengirimanList = $data->orders->pluck('pengiriman')->filter()->unique('id');
            @endphp
            @foreach ($pengirimanList as $pengiriman)
                <div class="section_three mt-8 md:mt-12" data-aos="fade-up"
                    id="biteship-shipping-info-{{ $pengiriman->id }}">
                    <div
                        class="bg-gradient-to-br from-blue-50 via-white to-blue-100 border border-blue-200 rounded-2xl p-6 md:p-10 mb-8 shadow-lg transition-all duration-300 hover:shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-100 rounded-full p-2">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89-5.26a2 2 0 012.22 0L21 8m-9 13V10m0 0L3 8m9 2l9-2m-9 2v11"></path>
                                </svg>
                            </div>
                            <p class="text-lg md:text-xl font-bold text-blue-700 tracking-wide">Informasi Pengiriman
                                (Biteship)
                            </p>
                        </div>
                        <div id="biteship-loading-{{ $pengiriman->id }}"
                            class="flex items-center gap-2 text-gray-500 text-sm py-4 px-3 bg-blue-50 rounded-lg mb-2">
                            <svg class="animate-spin h-4 w-4 text-blue-400" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            Memuat Data Pengiriman...
                        </div>
                        <div id="biteship-error-{{ $pengiriman->id }}" class="text-red-500 text-sm hidden mt-2 px-3">Gagal
                            Memuat Data Pengiriman.</div>
                        <div id="biteship-data-{{ $pengiriman->id }}" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2 pb-2">
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Order ID</p>
                                    <p class="text-black font-semibold text-base"
                                        id="biteship-order-id-{{ $pengiriman->id }}"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Status</p>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold shadow-sm"
                                        id="biteship-status-{{ $pengiriman->id }}"></span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Kurir</p>
                                    <p class="text-black font-medium" id="biteship-courier-{{ $pengiriman->id }}"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Waybill ID</p>
                                    <p class="text-black" id="biteship-waybill-{{ $pengiriman->id }}"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Tracking Link</p>
                                    <a href="#" target="_blank"
                                        class="text-blue-600 underline font-medium hover:text-blue-800 transition"
                                        id="biteship-link-{{ $pengiriman->id }}">Lihat Tracking</a>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Biaya Pengiriman</p>
                                    <p class="text-black font-bold" id="biteship-fee-{{ $pengiriman->id }}"></p>
                                </div>
                            </div>
                            <div class="border-t border-blue-100 my-6"></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Nama Pengirim</p>
                                    <p class="text-black font-medium" id="biteship-shipper-name-{{ $pengiriman->id }}">
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Telepon Pengirim</p>
                                    <p class="text-black" id="biteship-shipper-phone-{{ $pengiriman->id }}"></p>
                                    <p class="text-xs text-gray-500 mt-1">Alamat Asal</p>
                                    <p class="text-black" id="biteship-origin-address-{{ $pengiriman->id }}"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500">Nama Penerima</p>
                                    <p class="text-black font-medium" id="biteship-dest-name-{{ $pengiriman->id }}"></p>
                                    <p class="text-xs text-gray-500 mt-1">Telepon Penerima</p>
                                    <p class="text-black" id="biteship-dest-phone-{{ $pengiriman->id }}"></p>
                                    <p class="text-xs text-gray-500 mt-1">Alamat Tujuan</p>
                                    <p class="text-black" id="biteship-dest-address-{{ $pengiriman->id }}"></p>
                                </div>
                            </div>
                            @if ($pengiriman->status_pengiriman !== 'received')
                                <form action="{{ route('confirm.shipment', $pengiriman->id) }}" method="POST"
                                    class="mt-8 flex justify-center" onsubmit="return confirmShipment(event, this)">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $pengiriman->id }}">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        Konfirmasi Diterima
                                    </button>
                                </form>
                            @else
                                <div class="mt-8 flex justify-center">
                                    <span
                                        class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg shadow">
                                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        Sudah Dikonfirmasi
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h4 class="text-base font-semibold mb-2 text-center text-gray-700">Beri Ulasan Produk
                                    </h4>
                                    <div class="flex flex-col gap-4">
                                        @foreach ($pengiriman->orders as $order)
                                            <div
                                                class="flex flex-col md:flex-row md:items-center md:justify-between bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 shadow-sm">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ asset($order->produk->foto ?? 'assets/images/product_img.png') }}"
                                                        alt="{{ $order->produk->nama_produk ?? 'Produk' }}"
                                                        class="w-12 h-12 object-cover rounded">
                                                    <div>
                                                        <p class="text-sm font-medium text-black">
                                                            {{ $order->produk->nama_produk ?? '-' }}</p>
                                                        <p class="text-xs text-gray-500">Penjual:
                                                            {{ $order->produk->user->name ?? '-' }}</p>
                                                    </div>
                                                </div>
                                                <div class="mt-3 md:mt-0 flex items-center gap-2">
                                                    @if ($order->ulasan)
                                                        <span
                                                            class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 text-xs rounded shadow">
                                                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Sudah Diulas
                                                        </span>
                                                    @else
                                                        <button type="button"
                                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded shadow transition"
                                                            onclick="openRatingModal({{ $order->id }})">
                                                            Beri Ulasan
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div id="rating-modal-{{ $order->id }}"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                                <div
                                                    class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative animate-fade-in">
                                                    <button
                                                        class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl"
                                                        onclick="closeRatingModal({{ $order->id }})"
                                                        aria-label="Tutup">
                                                        &times;
                                                    </button>
                                                    <h3 class="text-lg font-semibold mb-4 text-center">Beri Ulasan untuk
                                                        <span
                                                            class="text-blue-700">{{ $order->produk->nama_produk ?? '-' }}</span>
                                                    </h3>
                                                    <form action="{{ route('rating.store') }}" method="POST"
                                                        class="space-y-4">
                                                        @csrf
                                                        <input type="hidden" name="id_transaksi"
                                                            value="{{ $data->id }}">
                                                        <input type="hidden" name="id_produk"
                                                            value="{{ $order->produk->id }}">
                                                        <input type="hidden" name="id_order"
                                                            value="{{ $order->id }}">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <label class="text-sm mr-2">Rating:</label>
                                                            <div class="flex items-center gap-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <svg class="w-7 h-7 cursor-pointer transition text-gray-300"
                                                                        fill="currentColor" viewBox="0 0 20 20"
                                                                        onclick="setStarRating({{ $order->id }}, {{ $i }})"
                                                                        id="star-{{ $order->id }}-{{ $i }}">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.462a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.388-2.462a1 1 0 00-1.176 0l-3.388 2.462c-.784.57-1.838-.196-1.539-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.045 9.394c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z" />
                                                                    </svg>
                                                                @endfor
                                                                <input type="hidden" name="rating"
                                                                    id="rating-input-{{ $order->id }}" value="5">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm mb-1">Ulasan:</label>
                                                            <textarea name="deskripsi_ulasan" rows="3"
                                                                class="w-full border rounded px-2 py-1 focus:ring focus:ring-blue-100" placeholder="Tulis ulasan Anda..."
                                                                required></textarea>
                                                        </div>
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button"
                                                                onclick="closeRatingModal({{ $order->id }})"
                                                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                                                            <button type="submit"
                                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition cursor-pointer">
                                                                Kirim
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <script>
                                    function openRatingModal(orderId) {
                                        document.getElementById('rating-modal-' + orderId).classList.remove('hidden');
                                        setStarRating(orderId, 5); // default to 5 stars
                                        document.body.classList.add('overflow-hidden');
                                    }

                                    function closeRatingModal(orderId) {
                                        document.getElementById('rating-modal-' + orderId).classList.add('hidden');
                                        document.body.classList.remove('overflow-hidden');
                                    }

                                    function setStarRating(orderId, rating) {
                                        document.getElementById('rating-input-' + orderId).value = rating;
                                        for (let i = 1; i <= 5; i++) {
                                            const star = document.getElementById('star-' + orderId + '-' + i);
                                            if (star) {
                                                star.classList.toggle('text-yellow-400', i <= rating);
                                                star.classList.toggle('text-gray-300', i > rating);
                                            }
                                        }
                                    }
                                    // Optional: close modal on ESC
                                    document.addEventListener('keydown', function(e) {
                                        if (e.key === "Escape") {
                                            document.querySelectorAll('[id^="rating-modal-"]').forEach(function(modal) {
                                                modal.classList.add('hidden');
                                            });
                                            document.body.classList.remove('overflow-hidden');
                                        }
                                    });
                                </script>
                                <style>
                                    .animate-fade-in {
                                        animation: fadeIn .2s ease;
                                    }

                                    @keyframes fadeIn {
                                        from {
                                            opacity: 0;
                                            transform: scale(.95);
                                        }

                                        to {
                                            opacity: 1;
                                            transform: scale(1);
                                        }
                                    }
                                </style>
                            @endif
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                function confirmShipment(event, form) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: 'Konfirmasi Diterima?',
                                        text: "Pastikan Anda sudah menerima barang dengan baik.",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#16a34a',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, sudah diterima!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    });
                                    return false;
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const orderId = '{{ $pengiriman->biteship_order_id ?? '' }}';
                        const id = '{{ $pengiriman->id }}';
                        if (!orderId) {
                            document.getElementById('biteship-loading-' + id).classList.add('hidden');
                            document.getElementById('biteship-error-' + id).classList.remove('hidden');
                            document.getElementById('biteship-error-' + id).textContent = 'Order ID Biteship Tidak Ditemukan.';
                            return;
                        }
                        fetch(`/history/detail/biteship/order/shpping/${orderId}`)
                            .then(res => res.json())
                            .then(res => {
                                if (!res.success) throw new Error('API Gagal');
                                const o = res;
                                document.getElementById('biteship-order-id-' + id).textContent = o.id || '-';
                                document.getElementById('biteship-status-' + id).textContent = o.status ? o.status.replace(
                                    /\b\w/g, c => c.toUpperCase()) : '-';
                                document.getElementById('biteship-courier-' + id).textContent = ((o.courier?.company || '-')
                                    .replace(/\b\w/g, c => c.toUpperCase())) + ' (' + ((o.courier?.type || '-').replace(
                                    /\b\w/g, c => c.toUpperCase())) + ')';
                                document.getElementById('biteship-waybill-' + id).textContent = o.courier?.waybill_id ||
                                    '-';
                                document.getElementById('biteship-link-' + id).href = o.courier?.link || '#';
                                document.getElementById('biteship-shipper-name-' + id).textContent = o.shipper?.name ? o
                                    .shipper.name.replace(/\b\w/g, c => c.toUpperCase()) : '-';
                                document.getElementById('biteship-shipper-phone-' + id).textContent = o.shipper?.phone ||
                                    '-';
                                document.getElementById('biteship-origin-address-' + id).textContent = o.origin?.address ? o
                                    .origin.address.replace(/\b\w/g, c => c.toUpperCase()) : '-';
                                document.getElementById('biteship-dest-name-' + id).textContent = o.destination
                                    ?.contact_name ? o.destination.contact_name.replace(/\b\w/g, c => c.toUpperCase()) :
                                    '-';
                                document.getElementById('biteship-dest-phone-' + id).textContent = o.destination
                                    ?.contact_phone || '-';
                                document.getElementById('biteship-dest-address-' + id).textContent = o.destination
                                    ?.address ? o.destination.address.replace(/\b\w/g, c => c.toUpperCase()) : '-';
                                document.getElementById('biteship-fee-' + id).textContent = 'Rp. ' + (o.courier
                                    ?.shipment_fee ? o.courier.shipment_fee.toLocaleString('id-ID') : '0');
                                document.getElementById('biteship-loading-' + id).classList.add('hidden');
                                document.getElementById('biteship-data-' + id).classList.remove('hidden');
                            })
                            .catch(() => {
                                document.getElementById('biteship-loading-' + id).classList.add('hidden');
                                document.getElementById('biteship-error-' + id).classList.remove('hidden');
                            });
                    });
                </script>
            @endforeach
            <!-- section 4 -->
            <div class="section_four mt-6 md:mt-9" data-aos="fade-up">
                <div class="subtotal flex justify-between text-sm md:text-base">
                    <p>Subtotal</p>
                    <p class="mt-2 md:mt-4">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
                <div class="biaya_pengiriman flex justify-between text-sm md:text-base">
                    <p>Biaya Pengiriman</p>
                    <p class="mt-2 md:mt-4">Rp.
                        {{ number_format($data->pengiriman->biaya_pengiriman ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="total_transaksi flex justify-between">
                    <p class="text-black font-semibold text-base md:text-lg">Total Biaya</p>
                    <p class="text-black mt-2 md:mt-4 font-semibold text-base md:text-lg">
                        Rp. {{ number_format($subtotal + ($data->pengiriman->biaya_pengiriman ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="action_button self-center mt-6 md:mt-9" data-aos="fade-up">
            </div>
        </div>
    </div>
    <!-- Add AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            once: true
        });
    </script>
@endsection
