<div>
    {{-- In work, do what you enjoy. --}}

    <button wire:click="remove({{ $item['product_id'] }})"
        type="button"
        class="text-red-600 hover:text-red-800 transition duration-150">
        حذف
    </button>
    @if($message)
    <p class="text-sm text-green-500 mt-1">{{ $message }}</p>
    @endif
</div>