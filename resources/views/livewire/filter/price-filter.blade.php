<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
<div class="p-4 bg-white rounded-lg shadow" x-data="priceFilter()">
    <h3 class="font-bold text-lg mb-4 border-b pb-2">فیلتر قیمت</h3>

    <div class="flex justify-between text-sm mb-4">
        <span class="font-semibold text-gray-700">
            حداقل: {{ number_format($minPrice) }} تومان
        </span>
        <span class="font-semibold text-gray-700">
            حداکثر: {{ number_format($maxPrice) }} تومان
        </span>
    </div>

    <div class="relative pt-2">
        <input
            wire:model.live="minPrice"
            type="range"
            min="{{ $priceRangeMin }}"
            max="{{ $priceRangeMax }}"
            class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm absolute top-0">

        <input
            wire:model.live="maxPrice"
            type="range"
            min="{{ $priceRangeMin }}"
            max="{{ $priceRangeMax }}"
            class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm absolute top-0"
            style="z-index: 2;">

    </div>

    <div class="flex justify-between mt-6 pt-4 border-t">
        <input
            wire:model.live="minPrice"
            type="number"
            min="{{ $priceRangeMin }}"
            max="{{ $priceRangeMax }}"
            placeholder="حداقل"
            class="w-5/12 p-2 border rounded-lg text-center text-sm">
        <input
            wire:model.live="maxPrice"
            type="number"
            min="{{ $priceRangeMin }}"
            max="{{ $priceRangeMax }}"
            placeholder="حداکثر"
            class="w-5/12 p-2 border rounded-lg text-center text-sm">
    </div>
</div>