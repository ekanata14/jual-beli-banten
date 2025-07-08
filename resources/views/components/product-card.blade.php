@props([
    'name' => 'Nama Produk',
    'price' => 'Rp. 2,000/PCS',
    'image' => 'assets/images/product_img.png',
    'rating' => 5,
    'reviews' => 'Jumlah Review',
    'link' => '/product/product_detail',
])
<div class="product_card w-full">
    <a href="{{ $link }}">
        <div class="product_card_header">
            <img src="{{ Storage::url($image) }}" alt="">
        </div>
        <div class="product_card_footer mt-3 gap-2 flex flex-col">
            <div class="product_card_footer_title flex justify-between">
                <p class="text-black font-medium">{{ $name }}</p>
                @if (empty($reviews) || empty($rating))
                    <p>Belum ada Ulasan</p>
                @else
                    <p>({{ number_format($rating, 1) }}) {{ $reviews }}</p>
                @endif
            </div>
            <p class="text-black font-medium">{{ $name_penjual }}</p>
            <div class="product_card_price flex justify-between">
                <p>{{ $price }}</p>
                <div class="stars flex">
                    @if (empty($reviews) || empty($rating))
                        <span class="text-gray-400 text-sm">Belum ada Ulasan</span>
                    @else
                        @for ($i = 0; $i < 5; $i++)
                            <img src="{{ asset('assets/icons/star-' . ($i < $rating ? 'full' : 'empty') . '.svg') }}"
                                alt="Star" class="w-5 h-5">
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
