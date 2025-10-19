<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
</div>
@props(['sidebarOpen'])

<div
    x-show="sidebarOpen"
    x-cloak
    class="fixed inset-y-0 right-0 w-64 bg-white shadow-xl transform transition duration-300 ease-in-out z-50 lg:hidden"
    x-transition:enter="translate-x-full"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="translate-x-0"
    x-transition:leave-end="translate-x-full">
    <button @click="sidebarOpen = false" class="p-4 text-gray-500 hover:text-gray-900 absolute top-0 left-0">
        &times;
    </button>

    <div class="mt-16 p-4">
        <div class="text-gray-400 mb-6">
            @livewire('search.sidebar-search')
        </div>

        <div class="mt-12">
            <a href="/about" class="block py-2 text-gray-700 hover:bg-gray-100 border-ذ mt-4 pt-4">بلاگ</a>
            <a href="/categories/men" class="block py-2 text-gray-700 hover:bg-gray-100">محصولات غذایی</a>
            <a href="/categories/women" class="block py-2 text-gray-700 hover:bg-gray-100">محصولات بهداشتی</a>
        </div>
    </div>
</div>

<div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
    x-cloak></div>