<a 
    href="{{ $href ?? '#' }}" 
    {{ $attributes->merge(['class' => 'flex items-center gap-1']) }}>
    
    <p class="py-3 px-12 bg-[#36302c] rounded-md text-white text-center w-full">
        {{ $slot }}
    </p>

    @if($icon)
        <img 
            src="{{ $icon }}" 
            alt="" 
            class="h-11 py-4 px-4 bg-[#36302c] rounded-md"
        >
    @endif
</a>