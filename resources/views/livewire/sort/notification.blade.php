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
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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