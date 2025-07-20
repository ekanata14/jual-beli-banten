<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/reset-css.css">
    <link rel="stylesheet" href="../assets/fonts/reckless_neue/stylesheet.css">
    <link rel="stylesheet" href="../assets/fonts/neue_montreal/stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Scripts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>
    <header class="w-full fixed top-0 z-50 flex justify-center pt-4" data-aos="fade-up" data-aos-delay="100">
        <nav class="nav flex justify-between items-center bg-white bg-opacity-90 backdrop-blur fixed w-full px-4 md:px-8 lg:px-10 py-3 mt-4"
            style="margin:0;">
            <div class="logo flex-shrink-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/icons/bhakti_logo.svg') }}" alt="Logo Bhakti"
                        class="h-6 object-contain">
                </a>
            </div>
            <!-- Hamburger Button (Mobile) -->
            <button id="navbar-toggle"
                class="md:hidden flex items-center px-3 py-2 border rounded text-gray-700 border-gray-400 focus:outline-none"
                aria-label="Toggle navigation">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Nav Links (Desktop & Responsive Centered) -->
            <div id="navbar-menu" class="hidden lg:flex flex-1 justify-center items-center">
                <ul class="nav-list flex flex-col lg:flex-row gap-6 lg:gap-[53px] bg-white lg:bg-transparent absolute lg:static top-full left-0 w-full lg:w-auto z-40 lg:z-auto px-6 py-4 lg:p-0
                    lg:justify-center justify-center items-center text-center">
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="block py-2 px-2 hover:text-blue-700 transition">
                            <p>Beranda</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}" class="block py-2 px-2 hover:text-blue-700 transition">
                            <p>Tentang Kami</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('product*') ? 'active' : '' }}">
                        <a href="{{ route('product') }}" class="block py-2 px-2 hover:text-blue-700 transition">
                            <p>Produk</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Icons/User -->
            @if (auth()->check())
            <div class="nav-icon hidden md:flex items-center gap-2 ml-4">
                <!-- History Icon (sm and up) -->
                <a href="{{ route('history') }}" class="hidden sm:inline-block" title="Riwayat">
                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </a>
                <!-- Cart Icon (sm and up) -->
                <a href="{{ route('cart') }}" class="hidden sm:inline-block" title="Keranjang">
                    <img src="{{ asset('assets/icons/cart_icon.svg') }}" alt="Keranjang" class="h-6 object-contain"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=Cart';">
                </a>
                <!-- Profile Dropdown (md and up) -->
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <button class="hidden md:flex items-center focus:outline-none" aria-haspopup="true"
                        :aria-expanded="open" @click="open = !open" type="button">
                        <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil" class="h-6 object-contain"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=User';">
                        <span
                            class="ml-2 hidden sm:inline">{{ Str::limit(auth()->user()->name ?? 'Profil', 14) }}</span>
                        <svg class="w-4 h-4 ml-1 hidden sm:inline" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-40 bg-white rounded-md transition-opacity z-50"
                        x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @mouseenter="open = true" @mouseleave="open = false"
                        style="display: none;">
                        <a href="{{ route('profile.user') }}"
                            class="hidden md:block px-4 py-2 text-gray-800 hover:bg-gray-100">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
                <!-- Alpine.js for dropdown -->
                <script src="//unpkg.com/alpinejs" defer></script>
                <!-- Mobile: Only show icons, no dropdown -->
                <a href="#" class="md:hidden flex items-center" title="Profil">
                    <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil" class="h-6 object-contain"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=User';">
                </a>
            </div>
            @else
            <div class="nav-icon hidden md:flex items-center gap-2 ml-4">
                <a href="{{ route('login') }}"
                    class="flex items-center gap-1 px-3 py-2 rounded hover:bg-gray-100 transition">
                    {{-- <img src="{{ asset('assets/icons/login_icon.svg') }}" alt="Masuk"
                    class="h-6 object-contain"
                    onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=Login';"> --}}
                    <span class="hidden sm:inline">Masuk</span>
                </a>
            </div>
            @endif
        </nav>
        <!-- Fullscreen Mobile Menu -->
        <div id="fullscreen-menu"
            class="fixed inset-0 bg-white bg-opacity-95 z-[100] flex flex-col items-center justify-center transition-all duration-500 ease-in-out transform translate-y-[-100%] opacity-0 pointer-events-none lg:hidden px-4 sm:px-8 md:px-10"
            style="margin:0;">
            <button id="close-fullscreen-menu" class="absolute top-6 right-6 text-3xl text-gray-700 focus:outline-none"
                aria-label="Close menu">&times;</button>
            <ul class="flex flex-col gap-10 text-2xl font-semibold items-center text-center">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-blue-700 transition"
                        onclick="closeFullscreenMenu()">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="hover:text-blue-700 transition"
                        onclick="closeFullscreenMenu()">
                        Tentang Kami
                    </a>
                </li>
                <li>
                    <a href="{{ route('product') }}" class="hover:text-blue-700 transition"
                        onclick="closeFullscreenMenu()">
                        Produk
                    </a>
                </li>
                @if (auth()->check())
                <li>
                    <a href="#" class="hover:text-blue-700 transition flex items-center gap-2"
                        onclick="closeFullscreenMenu()">
                        <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil" class="h-6 object-contain"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=User';">
                        <span>Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('history') }}" class="hover:text-blue-700 transition flex items-center gap-2"
                        onclick="closeFullscreenMenu()">
                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Riwayat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart') }}" class="hover:text-blue-700 transition flex items-center gap-2"
                        onclick="closeFullscreenMenu()">
                        <img src="{{ asset('assets/icons/cart_icon.svg') }}" alt="Keranjang" class="h-6 object-contain"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/24?text=Cart';">
                        <span>Keranjang</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="hover:text-blue-700 transition w-full text-left flex items-center gap-2"
                            onclick="closeFullscreenMenu()">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a href="{{ route('login') }}" class="hover:text-blue-700 transition flex items-center gap-2"
                        onclick="closeFullscreenMenu()">
                        <span>Masuk</span>
                    </a>
                </li>
                @endif
            </ul>
            @if (auth()->check())
            <div class="flex flex-col items-center mt-8 gap-2">
                <span class="text-base text-gray-700 font-medium">{{ auth()->user()->name ?? 'Profil' }}</span>
            </div>
            @endif
        </div>
        <script>
        // Responsive Navbar Toggle with Fullscreen Animated Menu
        const toggleBtn = document.getElementById('navbar-toggle');
        const fullscreenMenu = document.getElementById('fullscreen-menu');
        const closeBtn = document.getElementById('close-fullscreen-menu');
        const body = document.body;

        function openFullscreenMenu() {
            fullscreenMenu.classList.remove('translate-y-[-100%]', 'opacity-0', 'pointer-events-none');
            fullscreenMenu.classList.add('translate-y-0', 'opacity-100');
            body.style.overflow = 'hidden';
        }

        function closeFullscreenMenu() {
            fullscreenMenu.classList.add('translate-y-[-100%]', 'opacity-0', 'pointer-events-none');
            fullscreenMenu.classList.remove('translate-y-0', 'opacity-100');
            body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', openFullscreenMenu);
        closeBtn.addEventListener('click', closeFullscreenMenu);

        // Close menu on link click (mobile)
        document.querySelectorAll('#fullscreen-menu a, #fullscreen-menu button[type="submit"]').forEach(link => {
            link.addEventListener('click', closeFullscreenMenu);
        });

        // Desktop nav menu (unchanged)
        const menu = document.getElementById('navbar-menu');
        document.querySelectorAll('#navbar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) menu.classList.add('hidden');
            });
        });
        </script>
    </header>
    <main>
        @yield('content')
    </main>
    <section
        class="finalcta flex flex-col items-start w-full px-6 md:px-12 lg:px-24 py-8 md:py-16 lg:py-12 text-white mb-[-1px]">
        <div class="finalcta_content flex flex-col lg:flex-row py-8 md:py-16 lg:py-20 items-start lg:items-center justify-between w-full gap-10"
            data-aos="fade-up" data-aos-delay="300">
            <div class="finalcta_contentleft w-full lg:w-1/2 mb-6 lg:mb-0" data-aos="fade-up" data-aos-delay="400">
                <p class="text-sm md:text-base lg:text-lg mb-2">Menyediakan sarana upacara terlengkap</p>
                <h1 class="text-white text-xl md:text-3xl lg:text-4xl xl:text-5xl font-bold leading-tight">
                    Mudahnya
                    Memenuhi Kebutuhan Upacara Anda</h1>
            </div>
            <div class="finalcta_contentright w-full lg:w-1/3" data-aos="fade-up" data-aos-delay="500">
                <p class="mb-6 text-xs md:text-sm lg:text-base">Kami siap membantu Anda mendapatkan banten dan
                    sarana
                    upacara terbaik dengan mudah.</p>
                <a href="{{ route('product') }}" class="btn btn-primary flex items-center gap-2 mt-6 md:mt-9"
                    data-aos="fade-up" data-aos-delay="600">
                    <span
                        class="py-2 px-6 md:py-3 md:px-10 lg:px-12 bg-[#36302c] rounded-md text-white text-center text-xs md:text-sm lg:text-base">Lihat
                        Semua Produk</span>
                    <img src="{{ asset('assets/icons/arrow_right_white.svg') }}" alt=""
                        class="h-8 w-8 md:h-10 md:w-10 p-2 bg-[#36302c] rounded-md" />
                </a>
            </div>
        </div>
    </section>
    <footer class="w-full bg-[#36302c] text-white h-full">
        <div class="footer_content justify-between h-full max-w-10xl mx-auto py-10 flex flex-col gap-10">
            <div class="footer_contentTop flex flex-col md:flex-row md:justify-between md:items-start gap-8">
                <div class="footer_logo mb-6 md:mb-0 flex-shrink-0 flex justify-center md:justify-start"
                    data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ asset('assets/icons/bhakti_logo_footer.svg') }}" alt="Logo Bhakti" class="h-12 w-auto">
                </div>
                <div class="footer_menu flex flex-col sm:flex-row gap-8 md:gap-16 w-full md:w-auto">
                    <ul class="footer_menu_left flex flex-col items-start mb-6 sm:mb-0" data-aos="fade-up"
                        data-aos-delay="300">
                        <li class="mb-4">
                            <p class="text-white text-sm mb-3">Menu</p>
                        </li>
                        <li class="mb-2"><a href="{{ route('home') }}" class="opacity-50 hover:underline">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="opacity-50 hover:underline">Tentang
                                Kami</a>
                        </li>
                        <li class="mb-2"><a href="{{ route('product') }}" class="opacity-50 hover:underline">Produk</a>
                        </li>
                        <li class="mb-2"><a href="{{ route('cart') }}" class="opacity-50 hover:underline">Keranjang</a>
                        </li>
                        <li class="mb-2"><a href="#" class="opacity-50 hover:underline">Profil</a></li>
                    </ul>
                    <div class="footer_menu_right flex flex-col gap-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="footer_contactInfo mb-4 sm:mb-0">
                            <p class="text-white text-sm pb-4">Contact Us</p>
                            <h3 class="text-base break-all opacity-50 ">Bhakti@gmail.com</h3>
                        </div>
                        <div class="footer_socialInfo">
                            <p class="text-white text-sm pb-4">Sosial Media</p>
                            <div class="flex gap-4 flex-wrap">
                                <a href="#" class=" opacity-50 hover:underline">Twitter</a>
                                <a href="#" class=" opacity-50 hover:underline">Instagram</a>
                                <a href="#" class=" opacity-50 hover:underline">X</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_contentBottom flex flex-col gap-4">
                <div class="footer_contentBottom_1 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Scroll to top"
                        class="fixed right-6 bottom-6 z-50 bg-[#36302c] rounded-full p-2 hover:bg-[#222] transition-all"
                        data-aos="fade-up" data-aos-delay="600">
                        <img src="{{ asset('assets/icons/scroll_top.svg') }}" alt="Scroll Top"
                            class="h-8 w-8 cursor-pointer" />
                    </button>
                </div>
            </div>
            <div class="w-full pb-10" data-aos="fade-up" data-aos-delay="100">
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                    class="flex justify-between items-center w-full bg-[#2D2723] text-white font-normal text-base rounded-xl py-12 px-12 hover:opacity-90 transition-all duration-200">
                    <div class="text-left">
                        <p class="text-sm md:text-base leading-tight">Daftar</p>
                        <p class="text-sm md:text-base font-semibold">Sebagai Mitra</p>
                    </div>
                    <div class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 7l-10 10m10 0V7H7" />
                        </svg>
                    </div>
                </a>
                <p class="text-xs text-left mt-10" data-aos="fade-up" data-aos-delay="100">
                    ©2025 — Copyright — Anak Agung Gede Agung Aditya
                    Widnyana — 210030008 — Sistem Informasi
                </p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
    const carousel = document.querySelector('.carousel');
    const testimonials = document.querySelectorAll('.testimonial-card');
    const dots = document.querySelectorAll('.dot');
    const totalTestimonials = testimonials.length;
    let currentIndex = 0;

    function updateCarousel() {
        const offset = -currentIndex * 37; // Move the carousel
        carousel.style.transform = `translateX(${offset}%)`;
        updateDots();
    }

    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-stone-800', index === currentIndex);
            dot.classList.toggle('bg-stone-400', index !== currentIndex);
        });
    }

    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            currentIndex = parseInt(e.target.dataset.index);
            updateCarousel();
        });
    });

    updateDots(); // Initialize dots
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    @if (session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('
        success ') }}',
        showConfirmButton: true,
        confirmButtonColor: '#1C4ED8',
    });
    </script>
    @endif

    @if (session('error'))
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('
        error ') }}',
        showConfirmButton: true,
        confirmButtonColor: '#E02423',
    });
    </script>
    @endif
    {{-- Add AOS CSS & JS --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 900,
            once: true, // animate only once
            easing: 'cubic-bezier(.12, .57, .63, .21)',
            delay: 200,
            offset: 80,
            mirror: true,
            anchorPlacement: 'top-bottom',
        });
    });
    </script>
    @stack('modals')
</body>

</html>