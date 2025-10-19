<div x-data="{ open: false }" @click.away="open = false" class="relative">
    
    <div class="bg-[rgb(255,220,228)] px-2 py-1 w-[220px] h-[45px] mt-1 rounded-t-md flex items-center">
        <button 
            @click="open = ! open" 
            class="flex text-[14px] w-full items-center justify-between"
        >
            <p>دسته بندی کالاها</p>
            <div> 
                <svg 
                    :class="{'rotate-180': open}" 
                    class="size-3 transition-transform duration-200" 
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </button>
    </div>

    <div 
        x-show="open" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 w-[220px] mt-0 bg-white shadow-lg rounded-b-md z-30" 
        style="display: none;" 
        x-cloak
    >
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">محصولات غذایی</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">محصولات بهداشتی</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">ابزارهای خانه</a>
    </div>
</div>