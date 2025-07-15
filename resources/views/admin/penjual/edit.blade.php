@extends('layouts.app')

@section('content')
    <form class="bg-white p-8 rounded-xl" method="POST" action="{{ route('admin.penjual.update') }}">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 border border-red-400 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="hidden" name="id" value="{{ $data->id }}">

        <div class="mb-6">
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
            <input type="text" id="name" name="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="John Doe" value="{{ old('name', $data->name) }}" required />
            @error('nama')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
            <input type="email" id="email" name="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="john.doe@company.com" value="{{ old('email', $data->email) }}" required />
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="alamat_penjual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat
                Penjual</label>
            <input type="text" id="alamat_penjual" name="alamat_penjual"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Alamat lengkap" value="{{ old('alamat_penjual', optional($data->penjual)->alamat_penjual) }}"
                required />
            @error('alamat_penjual')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="kode_pos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos</label>
            <input type="text" id="kode_pos" name="kode_pos"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="12345" value="{{ old('kode_pos', optional($data->penjual)->kode_pos) }}" required />
            @error('kode_pos')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Latitude <span
                        class="text-red-500">*</span></label>
                <input type="text" id="latitude" name="latitude"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Latitude" value="{{ old('latitude', optional($data->penjual)->latitude) }}" maxlength="30"
                    required readonly autocomplete="off" />
                @error('latitude')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Longitude <span
                        class="text-red-500">*</span></label>
                <input type="text" id="longitude" name="longitude"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Longitude" value="{{ old('longitude', optional($data->penjual)->longitude) }}"
                    maxlength="30" required readonly autocomplete="off" />
                @error('longitude')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mb-6">
            <button type="button" onclick="getLocationAndAddress()"
                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition font-medium"
                id="btnGetLocation">
                Dapatkan Lokasi Otomatis
            </button>
            <button type="button" onclick="openMapModal()"
                class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg shadow hover:bg-amber-700 transition font-medium"
                id="btnOpenMap">
                Pilih di Peta
            </button>
        </div>
        <!-- Modal Map -->
        <div id="mapModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-6 relative animate-fadeIn">
                <button type="button" onclick="closeMapModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                <h4 class="mb-4 font-bold text-lg text-gray-800">Pilih Lokasi di Peta</h4>
                <div id="map" class="rounded-lg border border-gray-200" style="height: 400px; width: 100%;"></div>
                <div class="flex justify-end mt-4 gap-2">
                    <button type="button" onclick="closeMapModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</button>
                    <button type="button" onclick="setLocationFromMap()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Pilih
                        Lokasi</button>
                </div>
            </div>
        </div>
        @push('scripts')
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
                        document.getElementById('alamat_penjual').value = alamat.replace(/, $/, '');
                        document.getElementById('kode_pos').value = data.address.postcode || '';
                    }
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }

                function getLocationAndAddress() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
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
                let map, marker, selectedLatLng;

                function openMapModal() {
                    document.getElementById('mapModal').classList.remove('hidden');
                    setTimeout(initMap, 100);
                }

                function closeMapModal() {
                    document.getElementById('mapModal').classList.add('hidden');
                }

                function initMap() {
                    if (!map) {
                        map = L.map('map').setView([-6.1751, 106.8650], 10);
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
                document.getElementById('alamat_penjual').addEventListener('input', function(e) {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                    e.preventDefault();
                });
                document.getElementById('kode_pos').addEventListener('input', function(e) {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                    e.preventDefault();
                });
                document.getElementById('btnGetLocation').addEventListener('mousedown', function(e) {
                    e.preventDefault();
                });
                document.getElementById('btnOpenMap').addEventListener('mousedown', function(e) {
                    e.preventDefault();
                });
            </script>
        @endpush
        <div class="mb-6">
            <label for="no_telp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon</label>
            <input type="number" id="no_telp" name="no_telp"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="081234567890" value="{{ old('no_telp', optional($data->penjual)->no_telp) }}" required />
            @error('no_telp')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="•••••••••" />
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="•••••••••" />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-yellow">Update</button>
        <a href="{{ route('admin.penjual.index') }}" class="btn-white">Back</a>
    </form>
@endsection
