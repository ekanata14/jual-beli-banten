@extends('layouts.landing')
@section('content')
    <div class="main_content flex flex-col lg:flex-row justify-between py-16 px-4 md:px-10 lg:py-40 lg:px-36 gap-8 lg:gap-16"
        data-aos="fade-up">
        <div class="left_content w-full lg:w-[60%]" data-aos="fade-up">
            <!-- informasi anda -->
            <div class="checkout_container" data-aos="fade-up">
                <h3 class="text-black">Informasi Anda</h3>
                <div class="informasi_data mt-6 md:mt-9" data-aos="fade-up">
                    <p>{{ auth()->user()?->name }}</p>
                    <p>{{ auth()->user()?->email }}</p>
                    <p>{{ auth()->user()?->pelanggan?->no_telp }}</p>
                </div>
            </div>
            <!-- form informasi penerima -->
            <div class="checkout_form informasi_penerima_form mt-8 md:mt-12" data-aos="fade-up">
                <h3 class="text-black mb-4 text-lg font-semibold">Informasi Penerima</h3>
                <form action="{{ route('cart.checkout.pengiriman.data') }}" method="POST" class="space-y-5"
                    data-aos="fade-up">
                    @csrf
                    <input type="hidden" name="origin_latitude" value="{{ $product->user->penjual->latitude }}">
                    <input type="hidden" name="origin_longitude" value="{{ $product->user->penjual->longitude }}">
                    <!-- hidden id_transaksi -->
                    <input type="hidden" name="id_transaksi" id="id_transaksi"
                        value="{{ old('id_transaksi', $transaksi->id ?? '') }}" />
                    <!-- hidden id_order -->
                    <input type="hidden" name="id_order" id="id_order" value="{{ $transaksi->Orders[0]->id }}" />
                    <!-- input nama_penerima -->
                    <div data-aos="fade-up">
                        <label for="nama_penerima" class="block text-gray-700 font-medium mb-1">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="nama_penerima"
                            class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                            placeholder="Masukan Nama Penerima"
                            value="{{ old('nama_penerima', auth()->user()?->name ?? '') }}" required maxlength="250" />
                    </div>
                    <!-- input telp_penerima -->
                    <div data-aos="fade-up">
                        <label for="telp_penerima" class="block text-gray-700 font-medium mb-1">Telepon Penerima</label>
                        <input type="text" name="telp_penerima" id="telp_penerima"
                            class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                            placeholder="Masukan Telepon Penerima"
                            value="{{ old('telp_penerima', auth()->user()?->pelanggan?->no_telp ?? '') }}" required
                            maxlength="255" />
                    </div>
                    <!-- input alamat_penerima -->
                    <div data-aos="fade-up">
                        <label for="alamat_penerima" class="block text-gray-700 font-medium mb-1">Alamat Penerima</label>
                        <input type="text" name="alamat_penerima" id="alamat_penerima"
                            class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                            placeholder="Masukan Alamat Penerima"
                            value="{{ old('alamat_penerima', auth()->user()?->pelanggan?->alamat_pelanggan ?? '') }}"
                            required maxlength="250" autocomplete="off" />
                    </div>
                    <!-- input kode pos -->
                    <div data-aos="fade-up">
                        <label for="kode_pos" class="block text-gray-700 font-medium mb-1">Kode Pos</label>
                        <input type="text" name="kode_pos_penerima" id="kode_pos"
                            class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                            placeholder="Masukan Kode Pos"
                            value="{{ old('kode_pos', auth()->user()?->pelanggan?->kode_pos ?? '') }}" maxlength="10"
                            required autocomplete="off" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-aos="fade-up">
                        <!-- input latitude -->
                        <div>
                            <label for="latitude" class="block text-gray-700 font-medium mb-1">Latitude <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="latitude_penerima" id="latitude"
                                class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                                placeholder="Latitude"
                                value="{{ old('latitude', auth()->user()?->pelanggan?->latitude ?? '') }}" maxlength="30"
                                required readonly autocomplete="off" />
                        </div>
                        <!-- input longitude -->
                        <div>
                            <label for="longitude" class="block text-gray-700 font-medium mb-1">Longitude <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="longitude_penerima" id="longitude"
                                class="block w-full p-3 text-sm placeholder-gray-400 text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-amber-600 focus:border-amber-600 transition"
                                placeholder="Longitude"
                                value="{{ old('longitude', auth()->user()?->pelanggan?->longitude ?? '') }}" maxlength="30"
                                required readonly autocomplete="off" />
                        </div>
                    </div>
                    <!-- tombol lokasi otomatis dan pilih di peta -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-2" data-aos="fade-up">
                        <button type="button" onclick="getLocationAndAddress()"
                            class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg shadow hover:bg-amber-700 transition font-medium">
                            Dapatkan Lokasi Otomatis
                        </button>
                        <button type="button" onclick="openMapModal()"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition font-medium">
                            Pilih di Peta
                        </button>
                    </div>
                    <script>
                        // Prevent form submit if latitude/longitude is empty
                        document.querySelector('form').addEventListener('submit', function(e) {
                            const lat = document.getElementById('latitude').value.trim();
                            const lng = document.getElementById('longitude').value.trim();
                            if (!lat || !lng) {
                                alert(
                                    'Silakan pilih lokasi penerima dengan tombol "Dapatkan Lokasi Otomatis" atau "Pilih di Peta".');
                                e.preventDefault();
                            }
                        });
                    </script>
                    <button class="w-full mt-6" data-aos="fade-up">
                        <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                            Lanjut Ke Pengiriman
                        </x-button>
                    </button>
                </form>
            </div>
            <!-- Modal Map -->
            <div id="mapModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center"
                data-aos="fade-up">
                <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-6 relative animate-fadeIn">
                    <button onclick="closeMapModal()"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                    <h4 class="mb-4 font-bold text-lg text-gray-800">Pilih Lokasi di Peta</h4>
                    <div id="map" class="rounded-lg border border-gray-200" style="height: 400px; width: 100%;">
                    </div>
                    <div class="flex justify-end mt-4 gap-2">
                        <button onclick="closeMapModal()"
                            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</button>
                        <button onclick="setLocationFromMap()"
                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">Pilih
                            Lokasi</button>
                    </div>
                </div>
            </div>
            <!-- End Modal Map -->
        </div>

        @push('scripts')
            <!-- Leaflet CSS & JS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <style>
                #mapModal .animate-fadeIn {
                    animation: fadeIn 0.2s;
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            </style>
            <script>
                // Helper to update all fields from reverse geocode
                function updateAddressFields(data, lat, lng) {
                    if (data.address) {
                        let alamat = '';
                        if (data.address.road) alamat += data.address.road + ', ';
                        if (data.address.suburb) alamat += data.address.suburb + ', ';
                        if (data.address.village) alamat += data.address.village + ', ';
                        if (data.address.town) alamat += data.address.town + ', ';
                        if (data.address.city) alamat += data.address.city + ', ';
                        if (data.address.state) alamat += data.address.state + ', ';
                        if (data.address.country) alamat += data.address.country;
                        document.getElementById('alamat_penerima').value = alamat.replace(/, $/, '');
                        document.getElementById('kode_pos').value = data.address.postcode || '';
                    }
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }

                // Get location by GPS and fill address, kode pos, latitude, longitude
                function getLocationAndAddress() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            // Reverse geocode using Nominatim
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                                .then(response => response.json())
                                .then(data => {
                                    updateAddressFields(data, lat, lng);
                                })
                                .catch(() => {
                                    alert('Gagal mendapatkan alamat dari koordinat.');
                                    document.getElementById('latitude').value = lat;
                                    document.getElementById('longitude').value = lng;
                                });
                        }, function(error) {
                            alert('Gagal mendapatkan lokasi: ' + error.message);
                        });
                    } else {
                        alert('Geolocation tidak didukung browser ini.');
                    }
                }

                // Map modal logic
                let map, marker, selectedLatLng;

                function openMapModal() {
                    document.getElementById('mapModal').classList.remove('hidden');
                    setTimeout(initMap, 100); // Delay to ensure modal is visible
                }

                function closeMapModal() {
                    document.getElementById('mapModal').classList.add('hidden');
                }

                function initMap() {
                    if (!map) {
                        map = L.map('map').setView([-6.1751, 106.8650], 10); // Default: Jakarta
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        map.on('click', function(e) {
                            if (marker) {
                                marker.setLatLng(e.latlng);
                            } else {
                                marker = L.marker(e.latlng).addTo(map);
                            }
                            selectedLatLng = e.latlng;
                        });
                    }
                    setTimeout(function() {
                        map.invalidateSize();
                    }, 200);

                    // Set marker if already filled
                    let lat = document.getElementById('latitude').value;
                    let lng = document.getElementById('longitude').value;
                    if (lat && lng) {
                        let latlng = L.latLng(lat, lng);
                        if (marker) {
                            marker.setLatLng(latlng);
                        } else {
                            marker = L.marker(latlng).addTo(map);
                        }
                        map.setView(latlng, 15);
                        selectedLatLng = latlng;
                    }
                }

                function setLocationFromMap() {
                    if (selectedLatLng) {
                        const lat = selectedLatLng.lat;
                        const lng = selectedLatLng.lng;

                        // Reverse geocode using Nominatim
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                updateAddressFields(data, lat, lng);
                            })
                            .catch(() => {
                                alert('Gagal mendapatkan alamat dari koordinat.');
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;
                            });

                        closeMapModal();
                    } else {
                        alert('Silakan pilih lokasi pada peta.');
                    }
                }

                // If user manually edits address/kode pos, clear lat/lng to avoid mismatch
                document.getElementById('alamat_penerima').addEventListener('input', function() {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                });
                document.getElementById('kode_pos').addEventListener('input', function() {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                });
            </script>
            <script>
                document.querySelector('form').addEventListener('submit', function(e) {
                    const lat = document.getElementById('latitude').value.trim();
                    const lng = document.getElementById('longitude').value.trim();
                    if (!lat || !lng) {
                        alert(
                            'Silakan pilih lokasi penerima dengan tombol "Dapatkan Lokasi Otomatis" atau "Pilih di Peta".');
                        e.preventDefault();
                    }
                });
            </script>
        @endpush

        <div class="right_content bg-white py-6 px-4 md:px-5 w-full lg:w-[40%] rounded-md h-fit mt-8 lg:mt-0"
            data-aos="fade-up">
            @php
                $subtotal = $transaksi->orders->sum('subtotal');
            @endphp

            @forelse($transaksi->orders as $item)
                <div class="product_container flex flex-col sm:flex-row justify-between pb-6 md:pb-9 gap-4"
                    data-aos="fade-up">
                    <div class="flex gap-4 md:gap-5">
                        <img src="{{ asset('storage/' . ($item->produk->foto ?? 'assets/images/product_img.png')) }}"
                            alt="{{ $item->produk->nama_produk ?? 'Produk' }}" class="w-24 h-24 object-cover rounded-md">
                        <div class="flex flex-col">
                            <h4 class="text-black font-bold mb-2 md:mb-4">{{ $item->produk->nama_produk ?? '-' }}</h4>
                            <p>Jumlah : {{ $item->jumlah ?? 1 }}</p>
                            <p class="text-black font-bold">
                                Total : Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <h4 class="text-black font-bold mt-2 sm:mt-0">Rp.
                        {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</h4>
                </div>
            @empty
                <div class="text-gray-500 text-center py-8" data-aos="fade-up">Tidak ada produk dalam transaksi ini.</div>
            @endforelse
            <div class="product_sub flex justify-between mt-4" data-aos="fade-up">
                <p>Subtotal</p>
                <p class="text-black">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="product_sub flex justify-between mt-4" data-aos="fade-up">
                <p>Biaya Pengiriman</p>
                <p>-</p>
            </div>
            <div class="product_sub flex justify-between mt-4" data-aos="fade-up">
                <p class="text-black">Total</p>
                <p class="text-black">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection
