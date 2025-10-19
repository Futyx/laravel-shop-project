<div>
    <button wire:click="add" wire:loading.attr="disabled" wire:target="add"
        class="w-full bg-blue-600  font-semibold text-white py-2 rounded hover:bg-blue-700 transition duration-150">
        <span wire:loading.remove wire:target="add">افزودن به سبد خرید</span>
        <svg wire:loading wire:target="add" class="animate-spin h-4 w-4 text-white"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
            <radialGradient id="a12" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)">
                <stop offset="0" stop-color="#FF156D"></stop>
                <stop offset=".3" stop-color="#FF156D" stop-opacity=".9"></stop>
                <stop offset=".6" stop-color="#FF156D" stop-opacity=".6"></stop>
                <stop offset=".8" stop-color="#FF156D" stop-opacity=".3"></stop>
                <stop offset="1" stop-color="#FF156D" stop-opacity="0"></stop>
            </radialGradient>
            <circle transform-origin="center" fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70">
                <animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="1.8" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform>
            </circle>
            <circle transform-origin="center" fill="none" opacity=".2" stroke="currentColor" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle>
        </svg>
    </button>
    <div x-data="notificationHandler()"
        x-cloak
        class="fixed bottom-4 left-4 z-50 transition transform duration-300 ease-in-out"
        :class="{ 'translate-x-0 opacity-100': show, 'translate-x-full opacity-0': !show }">
        <div x-show="show"
            :class="{ 'bg-green-600': type === 'success', 'bg-red-600': type === 'error' }"
            class="rounded-lg shadow-xl text-white p-4 max-w-sm"
            style="min-width: 250px;">
            <div class="flex items-center">
                <span x-text="message" class="flex-grow"></span>
                <button @click="show = false" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Logic for Notification Display in Alpine.js
        function notificationHandler() {
            return {
                show: false,
                message: '',
                type: 'success',
                timeout: null,

                init() {
                    // Listen for the 'notify' event dispatched by Livewire components
                    window.addEventListener('notify', e => {
                        this.message = e.detail.message;
                        this.type = e.detail.type || 'success';
                        this.show = true;

                        clearTimeout(this.timeout);
                        this.timeout = setTimeout(() => {
                            this.show = false;
                        }, 3000); // Hide after 3 seconds
                    });
                }
            }
        }
    </script>

</div>