@props(['currentSort' => 'جدیدترین'])

<div x-data="{ open: false }" @click.away="open = false" class="relative">
    
    <button 
        @click="open = ! open" 
        class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48"
    >
        <span class="truncate">مرتب سازی براساس: {{ $currentSort }}</span>
        
        <svg 
            :class="{'rotate-180': open}" 
            class="size-4 ml-1 transition-transform duration-200" 
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <div 
        x-show="open" 
        x-transition:enter="ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute left-0 w-48 mt-1 bg-white border border-gray-200 rounded-md shadow-lg z-20" 
        style="display: none;" 
        x-cloak
    >
        <div class="py-1">
            <a href="#" @click="$wire.setSort('newest'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                جدیدترین
            </a>
            <a href="#" @click="$wire.setSort('price_asc'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                ارزان‌ترین
            </a>
            <a href="#" @click="$wire.setSort('price_desc'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                گران‌ترین
            </a>
            <a href="#" @click="$wire.setSort('popular'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                محبوب‌ترین
            </a>
        </div>
    </div>
</div>