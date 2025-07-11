@extends('layouts.auth')
@section('content')
<div class="flex justify-center items-center h-screen w-full">
    <div class="flex flex-col justify-start p-10 w-1/2">
        <div class="logo flex justify-left items-left">
            <img src="{{ asset('assets/icons/bhakti_logo.svg') }}" alt="logo">
        </div>

        <div class="w-full flex flex-col gap-2 pl-10">
            <div class="login_heading text-center mb-5">
                <h3 class="text-black text-2xl font-semibold">Daftar Akun Baru</h3>
                <p class="mt-1">Selamat datang di <span class="text-[#FF9D00]">Bhakti👋</span></p>
            </div>

            @if ($errors->any())
            <div class="mb-4">
                <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4 w-full">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama -->
                    <div class="flex flex-col">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 valid:bg-[#f6f5f5] mt-3"
                            placeholder="Masukan Nama Anda" required value="{{ old('name') }}" />
                        @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 valid:bg-[#f6f5f5] mt-3"
                            placeholder="Masukan Email Anda" required value="{{ old('email') }}" />
                        @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="flex flex-col md:col-span-2">
                        <label for="phone_number">Nomor Telepon</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                            placeholder="Masukan Nomor Telepon Anda" required value="{{ old('phone_number') }}" />
                        @error('phone_number')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Deteksi Lokasi -->
                <div class="flex flex-col gap-2">
                    <label>Deteksi Lokasi Otomatis</label>
                    <button type="button" onclick="detectLocation()"
                        class="bg-blue-500 text-white px-4 py-2 rounded w-full cursor-pointer">
                        Deteksi Lokasi Saya
                    </button>
                </div>

                <!-- Alamat -->
                <div class="flex flex-col">
                    <label for="alamat_pelanggan">Alamat</label>
                    <textarea id="alamat_pelanggan" name="alamat_pelanggan"
                        class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3 resize-y min-h-[38px] max-h-30"
                        placeholder="Masukan Alamat Anda" required>{{ old('alamat_pelanggan') }}</textarea>
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
                            placeholder="Masukan Kode Pos Anda" required value="{{ old('kode_pos') }}" />
                        @error('kode_pos')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Latitude -->
                    {{-- <div class="flex flex-col">
                            <label for="latitude">Latitude</label> --}}
                    <input type="hidden" id="latitude" name="latitude"
                        class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3" placeholder="Latitude"
                        readonly required value="{{ old('latitude') }}" />
                    @error('latitude')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                    {{-- </div> --}}

                    <!-- Longitude -->
                    {{-- <div class="flex flex-col">
                            <label for="longitude">Longitude</label> --}}
                    <input type="hidden" id="longitude" name="longitude"
                        class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3" placeholder="Longitude"
                        readonly required value="{{ old('longitude') }}" />
                    @error('longitude')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                    {{-- </div> --}}
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="flex flex-col justify-between">
                        <div class="flex w-full justify-between">
                            <label for="password">Password</label>
                            <a href="{{ route('forgot.password') }}" class="text-[#FF9D00]">Lupa Password?</a>
                        </div>
                        <input type="password" id="password" name="password"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                            placeholder="Masukan Password Anda" required />
                        @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-between">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="block w-full p-4 text-sm border rounded-lg bg-gray-50 mt-3"
                            placeholder="Ulangi Password Anda" required />
                        @error('password_confirmation')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit">
                    <x-button icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="w-full mt-8">
                        Daftar Sekarang
                    </x-button>
                </button>
                <p class="text-center">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#FF9D00]">Masuk
                        Disini</a></p>

            </form>
        </div>
    </div>

    <div class="hidden md:flex justify-center items-center w-1/2 h-full">
        <img src="{{ asset('assets/images/register_img.png') }}" alt="Register Image"
            class="max-w-full max-h-[100vh] object-contain">
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