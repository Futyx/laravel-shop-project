<div class="relative w-full mb-8" 
     x-data="{ open: @entangle('search').live }" 
     @click.away="open = false" 
     @keydown.escape.window="open = false">
    
    <input 
        wire:model.live.debounce.300ms="search" 
        type="text" 
        placeholder="جستجوی محصول..." 
        class="border p-2 rounded-lg w-full focus:ring-blue-500 focus:border-blue-500"
        @focus="open = true" 
        autocomplete="off"
    >

    @if ($this->getSearchResults()->isNotEmpty() || (strlen($search) > 1 && $this->getSearchResults()->isEmpty()))
        <div 
            x-show="open" 
            x-transition:enter="ease-out duration-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="absolute right-0 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg z-50 py-1"
        >
            @forelse ($this->getSearchResults() as $product)
                <a href="{{ route('product.show', $product) }}" 
                   class="flex items-center p-2 hover:bg-gray-100 transition duration-100 border-b last:border-b-0">
                    
                    <img src="{{ asset('images/placeholder.jpg') }}" alt="{{ $product->title }}" class="w-10 h-10 object-cover rounded-md ml-2">
                    
                    <span class="text-sm font-medium text-gray-800">{{ $product->title }}</span>
                </a>
            @empty
                <div class="p-3 text-sm text-gray-500 text-center">
                    نتیجه‌ای برای "{{ $search }}" یافت نشد.
                </div>
            @endforelse
        </div>
    @endif
</div>