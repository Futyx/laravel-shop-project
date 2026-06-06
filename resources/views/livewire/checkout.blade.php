<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">تکمیل سفارش</h1>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Cart Summary -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">خلاصه سفارش</h2>

                @if(empty($cartItems))
                <p class="text-gray-500 text-center py-8">سبد خرید شما خالی است.</p>
                @else
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-4 p-4 border-b">
                        <div class="flex-shrink-0">
                            <img
                                src="{{ $item['image_url'] ?? asset('images/no-image.svg') }}"
                                alt="{{ $item['product']['title'] ?? 'محصول' }}"
                                class="w-20 h-20 object-cover rounded"
                                onerror="this.src='{{ asset('images/no-image.svg') }}'">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $item['product']['title'] ?? 'محصول' }}</h3>
                            <p class="text-sm text-gray-600">تعداد: {{ $item['quantity'] }}</p>
                            <p class="text-sm text-gray-600">قیمت واحد: @rial($item['price']) تومان</p>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-red-600">@rial($item['subtotal']) تومان</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">مجموع کل:</span>
                        <span class="text-xl font-bold text-red-600">@rial($totalAmount) تومان</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="md:col-span-1">
            <form wire:submit.prevent="submit" class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">اطلاعات ارسال</h2>

                @if($errors->has('cart'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $errors->first('cart') }}
                </div>
                @endif

                @if($errors->has('submit'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $errors->first('submit') }}
                </div>
                @endif

                <div class="space-y-4">
                    <!-- Shipping Address -->
                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">
                            آدرس ارسال <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            wire:model="shipping_address"
                            id="shipping_address"
                            rows="4"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('shipping_address') border-red-500 @enderror"
                            placeholder="آدرس کامل خود را وارد کنید"
                            required></textarea>
                        @error('shipping_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shipping Phone -->
                    <div>
                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            شماره تماس <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            wire:model="shipping_phone"
                            id="shipping_phone"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('shipping_phone') border-red-500 @enderror"
                            placeholder="09123456789"
                            required>
                        @error('shipping_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                            کد پستی <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            wire:model="postal_code"
                            id="postal_code"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('postal_code') border-red-500 @enderror"
                            placeholder="1234567890"
                            maxlength="10"
                            required>
                        @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-blue-700 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                       
                        <span wire:loading.remove wire:target="submit">ادامه به پرداخت</span>
                        <span wire:loading wire:target="submit" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            در حال پردازش...
                        </span>
                    </button>

                    <a href="{{ route('cart.index') }}" class="block text-center text-blue-600 hover:text-blue-800 text-sm mt-2">
                        بازگشت به سبد خرید
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>