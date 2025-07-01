@extends('layouts.landing')
@section('content')
    <section class="product_hero flex w-full justify-between pt-52 pb-14 gap-14 px-14">
        <div class="product_heading flex flex-col w-full">
            <h2 class="text-black flex flex-col">Semua Produk</h2>
            <p class="mt-3">E-Banten adalah platform e-commerce pertama di Bali yang dikhususkan untuk memenuhi</p>
        </div>
        <div class="product_search w-full flex flex-col gap-3 items-end">
            <!-- <p class="mb-3">Cari Produk</p> -->
            <!-- input search -->
            <form class="w-1/2">
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
                    <input type="search" id="default-search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-50 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukan Nama Produk" required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-[#534538] hover:bg-[#36302c] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Cari
                        Produk</button>
                </div>
            </form>
        </div>
    </section>
    <section class="product_filter w-full mb-10 flex">
        <div class="product_category flex py-6 px-10 gap-6">
            <p>Semua kategori</p>
            <p>Persembahyangan</p>
            <p>Banten</p>
        </div>
        <div class="product_category flex py-6 px-10 gap-6">
            <p>Urutkan Berdasarkan</p>
            <p>(A-Z)</p>
            <p>(Harga Terendah)</p>
            <p>(Harga Tertinggi)</p>
        </div>
    </section>
    <section class="product_products_wrapper w-full flex items-center self-stretch gap-6 px-10 mb-14">
        @foreach ($products as $product)
            @include('components.product-card', [
                'name' => $product->name ?? 'Nama Produk',
                'price' => $product->price
                    ? 'Rp. ' . number_format($product->price, 0, ',', '.') . '/PCS'
                    : 'Rp. 2,000/PCS',
                'image' => $product->foto ?? 'assets/images/product_img.png',
                'rating' => $product->rating ?? 5,
                'reviews' => $product->reviews ?? 'Jumlah Review',
                'link' => route('product.detail', ['id' => $product->id ?? 1]),
            ])
        @endforeach
    </section>
    <section class="flex items-center justify-center w-full mb-10">
        {{ $products->links() }}
    </section>
@endsection
