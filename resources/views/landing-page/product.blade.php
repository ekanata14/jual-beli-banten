@extends('layouts.landing')
@section('content')
    <!-- Add AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <section
        class="product_hero flex flex-col md:flex-row w-full justify-between pt-32 md:pt-52 pb-10 md:pb-14 gap-8 md:gap-14 px-4 md:px-14"
        data-aos="fade-down">
        <div class="product_heading flex flex-col w-full md:w-1/2">
            <h2 class="text-black text-2xl md:text-3xl font-bold flex flex-col">Semua Produk</h2>
            <p class="mt-3 text-base md:text-lg">E-Banten adalah platform e-commerce pertama di Bali yang dikhususkan untuk
                memenuhi</p>
        </div>
        <div class="product_search w-full md:w-1/2 flex flex-col gap-3 items-end">
            <form class="w-full md:w-1/2" action="{{ route('product.search') }}" method="GET">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukan Nama Produk" value="{{ old('search', $search ?? '') }}" required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-[#534538] hover:bg-[#36302c] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Cari
                        Produk</button>
                </div>
            </form>
        </div>
    </section>
    <section class="product_filter w-full mb-8 md:mb-10 flex flex-col md:flex-row gap-4 md:gap-0" data-aos="fade-up">
        @php
            $activeCategory = request('category');
        @endphp
        @if (($categories ?? collect())->count() > 2)
            <div class="product_category flex flex-wrap py-4 md:py-6 px-4 md:px-10 gap-4 md:gap-6 items-center">
                <p class="font-semibold mr-2">Kategori:</p>
                <form action="{{ route('product.search') }}" method="GET">
                    <select name="category" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-[#534538] focus:border-[#534538]">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ $activeCategory == $category ? 'selected' : '' }}>
                                {{ $category ?? 'Kategori' }}
                            </option>
                        @endforeach
                    </select>
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>
            </div>
            <style>
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-in {
                    animation: fade-in 0.2s ease;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('dropdownCategoryButton');
                    const dropdown = document.getElementById('dropdownCategory');
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        dropdown.classList.toggle('hidden');
                    });
                    document.addEventListener('click', function(e) {
                        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });
                });
            </script>
        @else
            <div class="product_category flex flex-wrap py-4 md:py-6 px-4 md:px-10 gap-4 md:gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('product.find.category', ['category' => $category]) }}"
                        class="cursor-pointer hover:underline {{ $activeCategory == $category ? 'font-bold underline text-[#534538]' : '' }}">
                        {{ $category ?? 'Kategori' }}
                    </a>
                @endforeach
            </div>
        @endif
        <div class="product_category flex flex-wrap py-4 md:py-6 px-4 md:px-10 gap-4 md:gap-6">
            <p class="font-semibold">Urutkan Berdasarkan</p>
            <a href="{{ route('product.sort.atoz') }}"
                class="cursor-pointer hover:underline {{ request('sort') == 'atoz' ? 'font-bold underline text-[#534538]' : '' }}">
                (A-Z)
            </a>
            <a href="{{ route('product.sort.price_lowest') }}"
                class="cursor-pointer hover:underline {{ request('sort') == 'price_lowest' ? 'font-bold underline text-[#534538]' : '' }}">
                (Harga Terendah)
            </a>
            <a href="{{ route('product.sort.price_highest') }}"
                class="cursor-pointer hover:underline {{ request('sort') == 'price_highest' ? 'font-bold underline text-[#534538]' : '' }}">
                (Harga Tertinggi)
            </a>
        </div>
    </section>
    <section
        class="product_products_wrapper w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-center self-stretch gap-6 px-4 md:px-10 mb-10 md:mb-14">
        @foreach ($products as $product)
            @php
                $ulasans = $product->ulasans ?? collect();
                $rating = $ulasans->count() > 0 ? round($ulasans->avg('rating'), 1) : 0;
                $reviews = $ulasans->count();
            @endphp
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @include('components.product-card', [
                    'name' => $product->nama_produk ?? 'Nama Produk',
                    'name_penjual' => $product->user->name ?? 'Nama Penjual',
                    'price' => $product->harga
                        ? 'Rp. ' . number_format($product->harga, 0, ',', '.') . '/PCS'
                        : 'Rp. 2,000/PCS',
                    'image' => $product->foto ?? 'assets/images/product_img.png',
                    'rating' => $rating,
                    'reviews' => $reviews,
                    'link' => route('product.detail', ['id' => $product->id ?? 1]),
                ])
            </div>
        @endforeach
    </section>
    <section class="flex items-center justify-center w-full mb-10" data-aos="fade-up">
        {{ $products->links() }}
    </section>

    <!-- Add AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
        });
    </script>
@endsection
