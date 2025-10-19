<div x-data="{ open: false }" @click.away="open=false" class="relative w-full">

    <div class="items-center flex  pb-2 px-1 w-full   lg:justify-start lg:bg-gray-100 justify-between  lg:border-gray-100 bg-white h-[44px] border-2 border-[rgb(224,224,224)] rounded-full  focus:ring-red-500 focus:border-red-500">

    <button class="hidden rounded-full h-[33px] w-[33px] mt-2 flex-shrink-0 lg:flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="CurrentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </button>


    <input
        wire:model.live.debounce.250ms="search"
        @focus="open=true" @keydown.escape.window="open=false"
        type="search"
        placeholder="جستجو در محصولات"
        class=" lg:bg-gray-100 lg:placeholder-gray-400 lg:text-[14px] text-sm border-0 h-4 w-full  mt-2 mr-3 focus:ring-0">

    <button class="bg-red-600 lg:hidden rounded-full h-[33px] w-[33px] mt-2 flex-shrink-0 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </button>
    </div>

    @if(strlen($search) >= 2)
        <div x-show="open" x-transition.origin.top.left class="absolute z-50 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            @if($products->isEmpty())
                <div class="p-3 text-sm text-gray-500">نتیجه‌ای یافت نشد</div>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($products as $product)
                        <li>
                            <a href="{{ url('/products/'.$product->id) }}" class="flex items-center gap-3 p-2 hover:bg-gray-50">
                                <img src="{{ $product->getThumbnailUrl() }}" class="w-10 h-10 object-contain flex-shrink-0" alt="{{ $product->title }}">
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-800 truncate">{{ $product->title }}</div>
                                    <div class="text-xs text-gray-500">@rial($product->price) تومان</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li class="p-2 text-center bg-gray-50">
                        <a href="{{ url('/search?q='.urlencode($search)) }}" class="text-xs text-blue-600 hover:underline">نمایش همه نتایج</a>
                    </li>
                </ul>
            @endif
        </div>
    @endif

</div>