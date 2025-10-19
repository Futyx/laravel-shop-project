<div class="">
    
    <input 
        wire:model.live.debounce.300ms="query" 
        type="search" 
        placeholder="جستجو در محصولات..."
        class="w-full px-3 py-2 text-xs border border-gray-300  focus:ring-0 focus:border-red-500"
    >

    @if (count($products) > 0)
        <ul class="mt-4 border-t border-gray-200 divide-y divide-gray-100">
            @foreach ($products as $product)
                <li class="py-2 hover:bg-gray-50">
                    <a href="{{ route('products.show', $product->slug) }}" class="flex items-center">
                        <span class="mr-3 font-medium text-gray-800">{{ $product->title }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @elseif (strlen($query) > 2)
        <p class="mt-4 text-sm text-gray-500">نتیجه‌ای یافت نشد.</p>
    @endif
</div>