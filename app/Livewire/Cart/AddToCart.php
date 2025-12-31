<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class AddToCart extends Component
{
    public int $productId;
    public int $quantity = 1;
    public bool $busy = false;

    public Collection $items; // باید تعریف شده باشد
    public int $total = 0;

    public function mount(int $productId): void
    {
        if ($productId !== null) {
            $this->productId = $productId;
        }
        $this->loadCart();
    }
    public function add(): void
    {
        $this->busy = true;

        $product = Product::find($this->productId);
        if (!$product) {
            $this->dispatch('notify', type: 'error', message: 'محصول یافت نشد');
            $this->busy = false;
            return;
        }

        $cart = collect(session()->get('cart', []));
        $index = $cart->search(fn($row) => (int) ($row['product_id'] ?? 0) === $this->productId);

        $items = $cart->values()->all();
        if ($index !== false) {
            $currentQty = (int) ($items[$index]['quantity'] ?? 0);
            $items[$index]['quantity'] = $currentQty + $this->quantity;
        } else {
            $items[] = [
                'product_id' => $this->productId,
                'quantity' => $this->quantity,
            ];
        }

        session()->put('cart', array_values($items));


        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', message: 'به سبد خرید اضافه شد');

        $this->busy = false;
    }

    public function remove(int $productIdToRemove): void
    {
        $cart = collect(session()->get('cart', []));

        // 1. حذف آیتم از سشن
        $newCart = $cart->reject(fn($item) => (int) ($item['product_id'] ?? 0) === $productIdToRemove);
        session()->put('cart', $newCart->values()->all());

        // 2. به‌روزرسانی فوری داده‌های داخل کامپوننت
        // ⬇️ شما باید این متد را بسازید تا $items و $total را از سشن جدید محاسبه و پر کند.
        $this->loadCart();

        // 3. ارسال رویداد برای به‌روزرسانی سایر کامپوننت‌ها (مثل آیکون سبد خرید)
        $this->dispatch('cart-updated');

        $this->dispatch('notify', type: 'success', message: 'محصول با موفقیت از سبد حذف شد.');
    }

    public function loadCart(): void
    {
        // 1. تنظیم مجدد متغیرهای کامپوننت
        $cartData = collect(session()->get('cart', []));
        $this->items = collect(); // خالی کردن لیست فعلی
        $this->total = 0;

        // 2. پردازش آیتم‌های سشن
        foreach ($cartData as $cartItem) {
            $productId = (int) ($cartItem['product_id'] ?? 0);
            $quantity = (int) ($cartItem['quantity'] ?? 0);

            if ($productId === 0 || $quantity === 0) continue;

            // 3. بازیابی اطلاعات محصول از دیتابیس
            $product = Product::find($productId);

            if ($product) {
                // فرض می‌کنیم price یک فیلد در مدل Product باشد
                $price = $product->price ?? 0;
                $subtotal = $price * $quantity;

                // 4. ساختاردهی آیتم برای نمایش در View
                $this->items->push([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'product' => $product, // ارسال مدل کامل برای دسترسی به title و سایر فیلدها
                    'image_url' => $product->image_url ?? null, // یا فیلد تصویر محصول شما
                ]);

                // 5. محاسبه مجموع کل
                $this->total += $subtotal;
            }
        }
    }
    public function render()
    {
        return view('livewire.cart.add-to-cart');
    }
}
