@extends('layouts.landing')
@section('content')
    <section
        class="productdetail flex flex-col lg:flex-row w-full py-10 px-4 md:py-20 md:px-10 lg:py-40 lg:px-24 gap-8 lg:gap-16"
        data-aos="fade-up" data-aos-delay="100">
        <div class="product_image w-full lg:w-1/3" data-aos="fade-right" data-aos-delay="200">
            <div class="product_image_primary w-full">
                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product['nama_produk'] }}"
                    class="w-full rounded-lg object-cover">
            </div>
            <div class="product_image_list w-full flex justify-between mt-5 gap-2 md:gap-4">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ asset('storage/' . $product['foto']) }}" alt="{{ $product['nama_produk'] }}"
                        class="flex-1 w-1/4 h-16 md:h-20 object-cover rounded" data-aos="zoom-in"
                        data-aos-delay="{{ 300 + $i * 100 }}">
                @endfor
            </div>
        </div>

        <div class="product_info flex flex-col gap-8 lg:gap-16 w-full lg:w-2/3" data-aos="fade-left" data-aos-delay="300">
            <div class="product_header">
                <h2 class="text-[#1C1917] font-serif text-2xl md:text-4xl font-semibold">{{ $product['nama_produk'] }}
                </h2>

                <div class="flex items-center space-x-2 mt-2">
                    <div class="flex">
                        @for ($i = 0; $i < 5; $i++)
                            <img src="{{ asset('assets/icons/star-full.svg') }}" alt="Star"
                                class="w-4 h-4 text-[#FF7006]">
                        @endfor
                    </div>
                    <span class="text-sm text-[#1C1917] font-medium">4.9 / 5.0</span>
                </div>

                <div class="flex items-end mt-3">
                    <h2 class="text-[#1C1917] text-2xl md:text-3xl font-semibold">
                        Rp{{ number_format($product['harga'], 0, ',', '.') }}</h2>
                    <p class="text-[#1C1917] ml-2 text-sm md:text-base">/pcs</p>
                </div>
                <div class="flex items-end mt-3">
                    <h3 class="text-[#1C1917] text-2xl md:text-3xl font-semibold">
                        {{ $product->user->name }}</h3>
                </div>
            </div>

            <div class="product_details_desc flex flex-col gap-4">
                <div class="product_desc flex flex-col gap-1">
                    <p class="text-[#1C1917] font-semibold">Deskripsi</p>
                    <p class="text-[#4B4B4B] text-sm md:text-base leading-relaxed">{{ $product['deskripsi_produk'] }}</p>
                </div>
                <div class="product_seller flex flex-col gap-1">
                    <p class="text-[#1C1917] font-semibold">Kategori</p>
                    <p class="text-[#4B4B4B] text-sm md:text-base">{{ $product['kategori'] }}</p>
                </div>
            </div>

            <div class="product__footer">
                <div class="flex items-center gap-1 text-sm md:text-base text-[#1C1917] font-medium">
                    <p>Stok:</p>
                    <p class="text-[#FF7006] font-semibold">{{ $product['stok'] }}</p>
                    <p>Tersisa</p>
                </div>

                <div class="flex items-center gap-3 mt-4 mb-8">
                    <button type="button" id="decrement"
                        class="w-9 h-9 flex items-center justify-center bg-gray-100 text-[#1C1917] text-lg rounded-md font-bold cursor-pointer">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        max="{{ $product['stok'] }}" class="w-12 md:w-16 text-center border border-gray-300 rounded-md"
                        readonly>
                    <button type="button" id="increment"
                        class="w-9 h-9 flex items-center justify-center bg-gray-100 text-[#1C1917] text-lg rounded-md font-bold cursor-pointer">+</button>
                </div>

                <div class="product_button_cta">
                    <div class="flex flex-col gap-3 w-full">
                        <form action="{{ route('cart.checkout.direct') }}" method="POST" class="w-full" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="quantity" id="checkout_quantity" value="1">
                            <x-button type="submit" icon="{{ asset('assets/icons/arrow_right_white.svg') }}"
                                class="w-full bg-[#594B3C] text-white hover:bg-[#463c31] transition duration-300"
                                id="checkoutBtn">
                                Beli Sekarang
                            </x-button>
                        </form>

                        <form action="{{ route('cart.add') }}" method="POST" class="w-full" id="cartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="quantity" id="cart_quantity" value="1">
                            <input type="hidden" name="id_pelanggan" value="{{ auth()->user()->id ?? '' }}">
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-white text-[#1C1917] hover:text-dark transition-colors duration-200 rounded-md py-2 text-sm md:text-base cursor-pointer"
                                id="cartBtn">
                                <span class="text-xl font-bold">+</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7H18M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="related_products_wrapper w-full mt-16">
        <div class="flex items-center justify-between px-4 md:px-10 mb-6">
            <div>
                <p class="text-sm text-gray-500">🟧 Produk</p>
                <h3 class="text-2xl md:text-3xl font-semibold text-[#1C1917]">Produk Terkait</h3>
            </div>
            <a href="{{ route('product') }}"
                class="flex items-center gap-2 bg-[#4B3621] text-white px-4 py-2 rounded-md hover:bg-[#3a2a19] transition">
                Lihat Semua Produk
                <span class="text-lg">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 md:px-10">
            @foreach ($relatedProducts as $related)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    @include('components.product-card', [
                        'name' => $related->nama_produk ?? 'Nama Produk',
                        'name_penjual' => $related->user->name ?? 'Nama Penjual',
                        'price' => $related->harga
                            ? 'Rp. ' . number_format($related->harga, 0, ',', '.') . '/PCS'
                            : 'Rp. 2,000/PCS',
                        'image' => $related->foto ?? 'assets/images/product_img.png',
                        'rating' => $related->rating ?? 5,
                        'reviews' => $related->reviews ?? 'Jumlah Review',
                        'link' => route('product.detail', ['id' => $related->id ?? 1]),
                    ])
                </div>
            @endforeach
        </div>
    </section>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.getElementById('checkoutForm');
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Pembelian',
                    text: 'Apakah Anda yakin ingin membeli produk ini sekarang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Beli Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        checkoutForm.submit();
                    }
                });
            });

            const cartForm = document.getElementById('cartForm');
            const cartBtn = document.getElementById('cartBtn');
            cartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambah ke Keranjang',
                    text: 'Apakah Anda ingin menambah produk ini ke keranjang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tambahkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cartForm.submit();
                    }
                });
            });

            const decrement = document.getElementById('decrement');
            const increment = document.getElementById('increment');
            const quantity = document.getElementById('quantity');
            const checkoutQty = document.getElementById('checkout_quantity');
            const cartQty = document.getElementById('cart_quantity');
            const max = parseInt(quantity.max);

            function updateAllQtyInputs(val) {
                quantity.value = val;
                if (checkoutQty) checkoutQty.value = val;
                if (cartQty) cartQty.value = val;
            }

            decrement.addEventListener('click', function() {
                let val = parseInt(quantity.value);
                if (val > 1) {
                    updateAllQtyInputs(val - 1);
                }
            });

            increment.addEventListener('click', function() {
                let val = parseInt(quantity.value);
                if (val < max) {
                    updateAllQtyInputs(val + 1);
                }
            });

            quantity.addEventListener('input', function() {
                let val = parseInt(quantity.value);
                if (isNaN(val) || val < 1) val = 1;
                if (val > max) val = max;
                updateAllQtyInputs(val);
            });
        });
    </script>

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
                        class="carousel flex gap-6 md:gap-8 overflow-x-auto scrollbar-thin scrollbar-thumb-stone-300 scrollbar-track-stone-100 py-4 md:py-6 px-4 md:px-0 w-full"
                        style="scroll-behavior: smooth;">
                        @foreach ($testimonials as $index => $testi)
                            <div class="testimonial-card flex flex-col flex-shrink-0 w-[90vw] sm:w-[45vw] md:w-[32vw] lg:w-[30vw] xl:w-[25vw] px-5 py-6 bg-white rounded-lg shadow-md gap-6"
                                data-index="{{ $index }}" data-aos="flip-left"
                                data-aos-delay="{{ 200 + $index * 100 }}">
                                <img src="{{ asset('assets/icons/quote.svg') }}" alt=""
                                    class="self-end w-8 h-8">
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
