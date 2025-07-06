@extends('layouts.landing')
@section('content')
    <section class="home_hero hero flex w-full justify-start items-end h-[100vh]" data-aos="fade-up" data-aos-delay="100"
        style="background-image: url('{{ asset('assets/images/Hero_bg.jpg') }}');">
        <div class="home_hero_content py-9 px-10" data-aos="fade-right" data-aos-delay="300">
            <p class="sub-heading text-white" data-aos="fade-down" data-aos-delay="500">Harmoni Tradisi dan Teknologi</p>
            <h1 class="text-white" data-aos="zoom-in" data-aos-delay="700">Sarana Upacara Hindu yang<br> Mudah & Praktis
            </h1>
            <x-button href="{{ route('product') }}" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                data-aos="fade-up" data-aos-delay="900">
                Lihat Semua Produk
            </x-button>
        </div>
    </section>

    <section class="home_about flex flex-col w-full pt-20 md:pt-40 px-4 md:px-0" data-aos="fade-up" data-aos-delay="100">
        <div class="home_about_content flex flex-col justify-center items-center max-w-5xl mx-auto">
            <div class="home_about_heading flex flex-col items-center" data-aos="fade-down" data-aos-delay="200">
                <p class="sub-heading">Tentang Kami</p>
                <h2 class="text-black w-full md:w-[90%] text-center text-2xl md:text-4xl font-semibold">
                    Menghadirkan Sarana Upacara dengan Ketulusan
                </h2>
            </div>
            <p class="w-full md:w-1/2 text-center mt-6 md:mt-9 text-base md:text-lg" data-aos="fade-up"
                data-aos-delay="400">
                Dengan pengalaman dalam menyediakan banten dan sarana upacara, kami memastikan
                setiap produk dibuat dengan penuh ketulusan dan mengikuti tradisi yang diwariskan turun-temurun.
            </p>
            <!-- button -->
            <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}" class="mt-12 md:mt-24"
                data-aos="zoom-in" data-aos-delay="600">
                Baca Lebih Lengkap
            </x-button>
            <div class="home_about_images w-full flex justify-center" data-aos="fade-up" data-aos-delay="800">
                <img class="mt-12 md:mt-24 w-full max-w-md md:max-w-xl rounded-lg shadow-lg object-cover"
                    src="{{ asset('assets/images/about_img.png') }}" alt="">
            </div>
        </div>
    </section>

    <section class="home_product flex flex-col w-full pt-32 md:pt-[200px] px-4 md:px-10 mb-12" data-aos="fade-up"
        data-aos-delay="100">
        <div class="home_product_content flex flex-col gap-10 md:gap-16">
            <div class="home_product_heading flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
                data-aos="fade-down" data-aos-delay="200">
                <div class="home_product_heading_text">
                    <p class="sub-heading">Tentang Kami</p>
                    <h2 class="text-black text-2xl md:text-3xl font-semibold">Produk Terlaris</h2>
                </div>
                <x-button href="/produk" icon="{{ asset('assets/icons/arrow_right_white.svg') }}">
                    Lihat Semua Produk
                </x-button>
            </div>
            <div class="home_product_wrapper grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                @foreach ($products as $product)
                    <div data-aos="zoom-in-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
                        @include('components.product-card', [
                            'name' => $product->nama_produk ?? 'Nama Produk',
                            'price' => 'Rp. ' . number_format($product->harga ?? 2000, 0, ',', '.') . '/PCS',
                            'image' => $product->foto ?? 'assets/images/product_img.png',
                            'rating' => $product->rating ?? 5,
                            'reviews' => $product->jumlah_review ?? 'Jumlah Review',
                            'link' => route('product.detail', ['id' => $product->id ?? 1]),
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="home_testi py-16 md:py-24 px-0 w-full" data-aos="fade-up" data-aos-delay="100">
        <div class="home_testi_content flex flex-col items-center gap-16 md:gap-24 max-w-7xl mx-auto w-full">
            <div class="home_testi_content_header flex flex-col items-center justify-center w-full md:w-2/3"
                data-aos="fade-down" data-aos-delay="200">
                <p class="sub-heading text-center">Pendapat pelanggan tentang produk kami</p>
                <h2 class="text-center text-black mt-2 text-lg md:text-2xl font-semibold">
                    Setiap banten diproses dengan penuh ketulusan agar sesuai dengan
                    nilai-nilai spiritual yang dijunjung tinggi.
                </h2>
            </div>
            <div class="home_testi_content_footer w-full" data-aos="zoom-in" data-aos-delay="400">
                @php
                    $testimonials = [
                        [
                            'name' => 'I Gusti Ayu Raka Suryani',
                            'rating' => 5,
                            'text' =>
                                'Saya langganan beli banten di sini karena selalu lengkap dan rapi. Bungkusannya bersih, susunan bantennya tertata bagus, dan semua sarana upacara yang saya pesan selalu datang tepat waktu. Sangat membantu untuk persiapan upacara di rumah.',
                        ],
                        [
                            'name' => 'Made Putra Wijaya',
                            'rating' => 4,
                            'text' =>
                                'Pelayanan ramah dan produk berkualitas. Pengiriman cepat dan banten yang diterima sesuai pesanan. Sangat direkomendasikan!',
                        ],
                        [
                            'name' => 'Ni Luh Komang Dewi',
                            'rating' => 5,
                            'text' =>
                                'Banten yang saya terima sangat bagus dan lengkap. Proses pemesanan mudah dan admin sangat membantu.',
                        ],
                        [
                            'name' => 'Kadek Arta',
                            'rating' => 5,
                            'text' =>
                                'Produk sangat berkualitas dan harga terjangkau. Saya sangat puas dengan pelayanannya.',
                        ],
                        [
                            'name' => 'Putu Eka Yasa',
                            'rating' => 4,
                            'text' =>
                                'Banten dikirim dengan cepat dan sesuai pesanan. Akan order lagi untuk upacara berikutnya.',
                        ],
                        [
                            'name' => 'Komang Sari Dewi',
                            'rating' => 5,
                            'text' => 'Sangat membantu untuk persiapan upacara keluarga. Produk lengkap dan rapi.',
                        ],
                        [
                            'name' => 'Wayan Sudarma',
                            'rating' => 5,
                            'text' => 'Saya sangat merekomendasikan toko ini. Pelayanan ramah dan produk selalu fresh.',
                        ],
                        [
                            'name' => 'Dewa Gede Putra',
                            'rating' => 4,
                            'text' =>
                                'Banten yang diterima sangat bagus dan sesuai tradisi. Terima kasih atas pelayanannya.',
                        ],
                        [
                            'name' => 'Ayu Lestari',
                            'rating' => 5,
                            'text' => 'Pesanan datang tepat waktu dan kualitasnya sangat baik. Terima kasih banyak!',
                        ],
                        [
                            'name' => 'Ketut Suardika',
                            'rating' => 5,
                            'text' => 'Sarana upacara lengkap dan mudah dipesan. Sangat membantu untuk keluarga kami.',
                        ],
                    ];
                @endphp

                <div class="relative w-full">
                    <div id="carousel"
                        class="carousel flex gap-6 md:gap-8 overflow-x-auto scrollbar-none py-4 md:py-6 px-4 md:px-0 w-full"
                        style="scroll-behavior: smooth;">
                        @foreach ($testimonials as $index => $testi)
                            <div class="testimonial-card flex flex-col flex-shrink-0 w-[90vw] sm:w-[45vw] md:w-[32vw] lg:w-[30vw] xl:w-[25vw] px-5 py-6 bg-white rounded-lg shadow-md gap-6"
                                data-index="{{ $index }}" data-aos="flip-left"
                                data-aos-delay="{{ 200 + $index * 100 }}">
                                <img src="{{ asset('assets/icons/quote.svg') }}" alt="" class="self-end w-8 h-8">
                                <div class="testimonial-card_content">
                                    <div class="stars flex mb-2">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $testi['rating'])
                                                <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star"
                                                    class="w-5 h-5">
                                            @else
                                                <img src="{{ asset('assets/icons/star-empty.svg') }}" alt="Star"
                                                    class="w-5 h-5">
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-black font-semibold">{{ $testi['name'] }}</p>
                                    <p class="text-gray-700 mt-4 text-sm md:text-base">"{{ $testi['text'] }}"</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center mt-8 md:mt-10" id="dots-container">
                        {{-- Dots will be generated by JS --}}
                    </div>
                </div>
                <style>
                    /* Hide scrollbar for all browsers */
                    #carousel {
                        scrollbar-width: none;
                        /* Firefox */
                        -ms-overflow-style: none;
                        /* IE and Edge */
                    }

                    #carousel::-webkit-scrollbar {
                        display: none;
                        /* Chrome, Safari, Opera */
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const carousel = document.getElementById('carousel');
                        const cards = carousel.querySelectorAll('.testimonial-card');
                        const dotsContainer = document.getElementById('dots-container');

                        function getCardWidth() {
                            return cards[0].offsetWidth + parseInt(getComputedStyle(cards[0]).marginRight);
                        }

                        function getVisibleCards() {
                            return Math.floor(carousel.offsetWidth / getCardWidth()) || 1;
                        }

                        function setupDots() {
                            dotsContainer.innerHTML = '';
                            const cardWidth = getCardWidth();
                            const visibleCards = getVisibleCards();
                            const totalCards = cards.length;
                            const totalDots = Math.max(1, totalCards - visibleCards + 1);

                            for (let i = 0; i < totalDots; i++) {
                                const dot = document.createElement('span');
                                dot.className =
                                    'dot cursor-pointer bg-stone-400 w-2 h-2 rounded-full mx-1 transition-all duration-200 inline-block';
                                dot.dataset.index = i;
                                dotsContainer.appendChild(dot);
                            }
                            return dotsContainer.querySelectorAll('.dot');
                        }

                        let dots = setupDots();

                        function setActiveDot(idx) {
                            dots.forEach((dot, i) => {
                                if (i === idx) {
                                    dot.classList.add('bg-stone-900', 'scale-125');
                                    dot.classList.remove('bg-stone-400');
                                } else {
                                    dot.classList.remove('bg-stone-900', 'scale-125');
                                    dot.classList.add('bg-stone-400');
                                }
                            });
                        }

                        function updateDotOnScroll() {
                            const cardWidth = getCardWidth();
                            const idx = Math.round(carousel.scrollLeft / cardWidth);
                            setActiveDot(idx);
                        }

                        function scrollToIndex(idx) {
                            const cardWidth = getCardWidth();
                            carousel.scrollTo({
                                left: idx * cardWidth,
                                behavior: 'smooth'
                            });
                        }

                        dots.forEach((dot, idx) => {
                            dot.addEventListener('click', () => {
                                scrollToIndex(idx);
                            });
                        });

                        setActiveDot(0);
                        carousel.addEventListener('scroll', updateDotOnScroll);

                        let autoScrollInterval = setInterval(() => {
                            const cardWidth = getCardWidth();
                            const visibleCards = getVisibleCards();
                            const totalCards = cards.length;
                            const totalDots = Math.max(1, totalCards - visibleCards + 1);
                            let idx = Math.round(carousel.scrollLeft / cardWidth);
                            if (idx >= totalDots - 1) {
                                idx = 0;
                            } else {
                                idx++;
                            }
                            scrollToIndex(idx);
                        }, 3000);

                        carousel.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
                        carousel.addEventListener('mouseleave', () => {
                            autoScrollInterval = setInterval(() => {
                                const cardWidth = getCardWidth();
                                const visibleCards = getVisibleCards();
                                const totalCards = cards.length;
                                const totalDots = Math.max(1, totalCards - visibleCards + 1);
                                let idx = Math.round(carousel.scrollLeft / cardWidth);
                                if (idx >= totalDots - 1) {
                                    idx = 0;
                                } else {
                                    idx++;
                                }
                                scrollToIndex(idx);
                            }, 3000);
                        });

                        window.addEventListener('resize', () => {
                            dots = setupDots();
                            setActiveDot(Math.round(carousel.scrollLeft / getCardWidth()));
                            dots.forEach((dot, idx) => {
                                dot.addEventListener('click', () => {
                                    scrollToIndex(idx);
                                });
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </section>
@endsection
