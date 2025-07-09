@extends('layouts.landing')
@section('content')
    <div class="flex flex-col md:flex-row justify-center items-center gap-2 h-screen w-full px-4 overflow-y-auto">
        <div class="flex flex-col justify-center items-center gap-2 w-full md:w-1/2 mx-auto max-w-lg py-8 mt-20 md:mt-32">

            <div class="w-full flex flex-col gap-2">

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.user.update') }}" class="flex flex-col gap-4 w-full">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nama -->
                        <div class="flex flex-col">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Masukan Nama Anda" required value="{{ old('name', auth()->user()->name) }}" />
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Masukan Email Anda" required
                                value="{{ old('email', auth()->user()->email) }}" />
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="flex flex-col md:col-span-2">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" id="phone_number" name="phone_number"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Masukan Nomor Telepon Anda" required
                                value="{{ old('phone_number', auth()->user()->pelanggan->no_telp) }}" />
                            @error('phone_number')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Deteksi Lokasi -->
                    <div class="flex flex-col gap-2">
                        <label>Deteksi Lokasi Otomatis</label>
                        <button type="button" onclick="detectLocation()"
                            class="bg-blue-500 text-white px-4 py-2 rounded w-max cursor-pointer">
                            Deteksi Lokasi Saya
                        </button>
                    </div>

                    <!-- Alamat -->
                    <div class="flex flex-col">
                        <label for="alamat_pelanggan">Alamat</label>
                        <textarea id="alamat_pelanggan" name="alamat_pelanggan"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3 resize-y min-h-[48px] max-h-40"
                            placeholder="Masukan Alamat Anda" required>{{ old('alamat_pelanggan', auth()->user()->pelanggan->alamat_pelanggan) }}</textarea>
                        @error('alamat_pelanggan')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Kode Pos -->
                        <div class="flex flex-col col-span-2">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Masukan Kode Pos Anda" required
                                value="{{ old('kode_pos', auth()->user()->pelanggan->kode_pos) }}" />
                            @error('kode_pos')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Latitude -->
                        {{-- <div class="flex flex-col">
                            <label for="latitude">Latitude</label> --}}
                        <input type="hidden" id="latitude" name="latitude"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3" placeholder="Latitude"
                            readonly required value="{{ old('latitude', auth()->user()->pelanggan->latitude) }}" />
                        @error('latitude')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}

                        <!-- Longitude -->
                        {{-- <div class="flex flex-col">
                            <label for="longitude">Longitude</label> --}}
                        <input type="hidden" id="longitude" name="longitude"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3" placeholder="Longitude"
                            readonly required value="{{ old('longitude', auth()->user()->longitude) }}" />
                        @error('longitude')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}
                    </div>
                    <!-- Password -->
                        <span class="text-blue-500 text-xs">(Kosongkan jika tidak ingin mengubah password)</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="password">Password </label>
                            <input type="password" id="password" name="password"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Masukan Password Baru (opsional)" />
                            @error('password')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label for="password_confirmation">Konfirmasi Password </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                                placeholder="Ulangi Password Baru (opsional)" />
                            @error('password_confirmation')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex flex-col md:items-center md:justify-between gap-2 w-full">
                        <button type="submit" id="updateProfileBtn" class="w-full bg-[#36302c] text-white py-3 rounded font-semibold cursor-pointer">
                            Update Profile
                        </button>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const form = document.querySelector('form[action="{{ route('profile.user.update') }}"]');
                                const btn = document.getElementById('updateProfileBtn');
                                if (form && btn) {
                                    btn.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Apakah Anda yakin ingin memperbarui profil?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ya, Update!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        });
                                    });
                                }
                            });
                        </script>
                    </div>
                    <a href="{{ route('forgot.password') }}" class="text-[#FF9D00] text-center self-end md:self-auto">Lupa
                        Password?</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function detectLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        if (data.display_name) {
                            document.getElementById("alamat_pelanggan").value = data.display_name;
                        }
                        if (data.address && data.address.postcode) {
                            document.getElementById("kode_pos").value = data.address.postcode;
                        }
                    }
                }).catch(err => {
                    console.error("Gagal mendapatkan data lokasi:", err);
                });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Izin akses lokasi ditolak.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Informasi lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    alert("Permintaan lokasi melebihi batas waktu.");
                    break;
                default:
                    alert("Terjadi kesalahan saat mengambil lokasi.");
            }
        }
    </script>
@endsection
