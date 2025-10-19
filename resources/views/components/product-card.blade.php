@props(['product'])

{{-- اعمال تابع format_price و to_farsi_numbers را در اینجا انجام می‌دهیم --}}

<div class="p-2 border rounded shadow-md flex flex-col h-full">
   
    <a href="{{ route('product.show', $product) }}">



        <img src="{{ $product->getFirstImageUrl() }}" alt="{{ $product->title }}" class="w-full h-36 object-contain mb-2 rounded-t">

        <div class="min-h-[2rem] mb-1">
            <p class="font-semibold text-gray-800 line-clamp-2">{{ $product->title }}</p>
        </div>

        <div class="text-[14px] font-bold text-red-600 mb-2 gap-1 flex ">
            <span>@rial($product->price)</span><span>تومان</span>
        </div>
    </a>
    @livewire('cart.add-to-cart', ['productId' => $product->id])


</div>