<div class="flex justify-center gap-2 md:gap-2 border-2 border-gray-200  px-2 md:px-1 rounded-md max-w-[100px] ">
    <button  wire:click="decrement" wire:loading.attr="disabled "

        class="border-l-2 pl-2 md:pl-1">-</button>
        <span wire:loading.remove class="text-xs font-normal mt-1">@persian($count)</span>    <span wire:loading class="mt-1 text-gray-500"><svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg></span>
    <button wire:click="increment" wire:click="increment"
        wire:loading.attr="disabled"

        class="border-r-2 pr-2 md:pr-1">+</button>
</div>