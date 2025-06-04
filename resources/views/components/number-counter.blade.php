<div class="flex h-10">
    <button id="decrement-btn"
        class="flex justify-center items-center w-5 h-full rounded-s-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD]">
        <p>-</p>
    </button>
    <span id="counter" class="flex justify-center items-center px-4 text-black focus:outline-none bg-[#fff] h-full">1</span>
    <button id="increment-btn"
        class="flex justify-center items-center w-5 h-full rounded-e-sm text-black focus:outline-none bg-[#F0E5DA] hover:bg-[#C4B8AD]">
        <p>+</p>
    </button>
</div>

<script>
    var counterEl = document.getElementById('counter');
    var decrementBtn = document.getElementById('decrement-btn');
    var incrementBtn = document.getElementById('increment-btn');
    let count = 1;

    decrementBtn.addEventListener('click', () => {
        if (count > 1) {
            count--;
            counterEl.textContent = count;
        }
    });

    incrementBtn.addEventListener('click', () => {
        count++;
        counterEl.textContent = count;
    });
</script>