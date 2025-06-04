<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-3 rounded-md bg-[#23AD07] text-white hover:bg-[#1A7608] cursor-pointer']) }}>
    {{ $slot }}
</button>
