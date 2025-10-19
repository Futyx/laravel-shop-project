@props(['product'])

@php
    $images = $product->getAllImages();
    $first = $product->getFirstImageUrl('large');
@endphp

<div x-data="{ current: '{{ $first }}' }" class="w-full">
    <div class="w-full border rounded mb-3 bg-white">
        <img :src="current" alt="{{ $product->title }}" class="w-full h-80 object-contain">
    </div>

    <div class="grid grid-cols-5 gap-2">
        @foreach($images as $url)
            <button type="button"
                    class="border rounded p-1 hover:ring-2 hover:ring-blue-500"
                    @click="current='{{ $url }}'">
                <img src="{{ $url }}" alt="{{ $product->title }} thumbnail" class="w-full h-20 object-contain">
            </button>
        @endforeach

        @if($images->isEmpty())
            <div class="col-span-5 text-center text-gray-500 text-sm">
                تصویری برای این محصول موجود نیست
            </div>
        @endif
    </div>
</div>



