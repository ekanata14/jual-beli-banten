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
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}"> -->
</head>

<body>
    <header class="w-full">
        <nav class="nav flex justify-between items-center fixed">
            <div class="logo">
                <img src="../assets/icons/bhakti_logo.svg" alt="">
            </div>
            <div>
                <ul class="nav-list gap-[53px]">
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">
                            <p>Beranda</p>
                        </a></li>
                    <li class="nav-item {{ request()->is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">
                            <p>Tentang Kami</p>
                        </a></li>
                    <li class="nav-item {{ request()->is('product') && 'product/product_detail' ? 'active' : '' }}"><a
                            href="{{ route('product') }}">
                            <p>Produk</p>
                        </a></li>
                </ul>
            </div>
            <div class="nav-icon flex gap-2">
                @if (auth()->check())
                    <a href="{{ route('cart') }}"><img src="../assets/icons/cart_icon.svg" alt=""></a>
                    <a href="/"><img src="../assets/icons/profile_icon.svg" alt=""></a>
                @else
                    <a href="{{ route('login') }}"><img src="../assets/icons/login_icon.svg" alt="" class="btn-gray">Masuk
                    </a>
                @endif
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <section class="finalcta flex flex-col items-start w-full px-24 py-12 text-white mb-[-1px]">
        <div class="finalcta_content flex py-24 items-center justify-between">
            <div class="finalcta_contentleft w-1/2">
                <p>Join Our Growing Wellness Community</p>
                <h1 class="text-white">Mudahnya Memenuhi Kebutuhan Upacara Anda</h1>
            </div>
            <div class="finalcta_contentright w-1/4">
                <p>Kami siap membantu Anda mendapatkan banten dan sarana upacara terbaik dengan mudah.</p>
                <a href="#" class="btn btn-primary flex items-center gap-1 mt-9">
                    <p class="py-3 px-12 bg-[#36302c] rounded-md text-white text-center">Lihat Semua Produk</p>
                    <img src="../assets/icons/arrow_right_white.svg" alt=""
                        class="h-11 py-4 px-4 bg-[#36302c] rounded-md">
                </a>
            </div>
        </div>
    </section>

    <footer class="flex w-full flex-col items-start">
        <div class="footer_content flex flex-col items-start w-full gap-[220px]">
            <div class="footer_contentTop flex justify-between items-start w-[60vw]">

                <div class="footer_logo">
                    <img src="../assets/icons/bhakti_logo_footer.svg" alt="" srcset="">
                </div>
                <div class="footer_menu flex gap-[61px]">
                    <ul class="footer_menu_left flex flex-col items-start justify-between">
                        <li>
                            <p class="text-white text-sm mb-4">Menu</p>
                        </li>
                        <div class="footer_menu_list pr-12 gap-[15px] flex flex-col">
                            <li class=""><a href="#">Beranda</a></li>
                            <li class=""><a href="#">Tentang Kami</a></li>
                            <li class=""><a href="#">Produk</a></li>
                            <li class=""><a href="#">Keranjang</a></li>
                            <li class=""><a href="#">Profil</a></li>
                        </div>
                    </ul>

                    <div class="footer_menu_right flex flex-col items-center justify-between gap-[48px]">
                        <div class="footer_contactInfo">
                            <p class="text-white text-sm mb-4">Contact Us</p>
                            <h3>Bhakti@gmail.com</h3>
                        </div>
                        <div class="footer_socialInfo">
                            <ul class="footer_menu_right flex flex-col items-start">
                                <li>
                                    <p class="text-white text-sm mb-4">Sosial Media</p>
                                </li>
                                <div class="footer_menu_list pr-12 gap-[25px] flex">
                                    <li class=""><a href="#">Twitter</a></li>
                                    <li class=""><a href="#">Instagram</a></li>
                                    <li class=""><a href="#">X</a></li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer_contentBottom flex flex-col w-full gap-5">
                <div class="footer_contentBottom_1 flex justify-between items-end">
                    <img src="../assets/icons/scroll_top.svg" alt="Logo Bhakti" srcset="">
                    <p class="text-xs">©2025 — Copyright — Anak Agung Gede Agung Aditya Widnyana — 210030008 — Sistem
                        Informasi</p>
                </div>
                <div
                    class="footer_contentBottom_2 flex justify-between items-center h-[150px] px-16 py-3 rounded-2xl bg-(--dark-brown) w-full">
                    <h4 class="w-50 ">Bergabung Menjadi Supplier</h4>
                    <img src="../assets/icons/righttop_arrow.svg" alt="" srcset="">
                </div>
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
</body>

</html>
