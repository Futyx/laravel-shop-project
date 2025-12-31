<?php

namespace App\Livewire;

use App\Models\Product; // مدل محصول را اضافه کنید
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CartIndex extends Component // تغییر نام کلاس به CartIndex
{
    // این متد Listen Livewire است که رویداد 'update-cart-quantity' را مدیریت می‌کند
    #[On('update-cart-quantity')]
    public function updateQuantity(int $productId, int $newQuantity): void
    {
        $cart = collect(session()->get('cart', []));

        $index = $cart->search(fn($row) => ($row['product_id'] ?? 0) === $productId);

        if ($index !== false) {
            $items = $cart->values()->all();

            if ($newQuantity <= 0) {
                // اگر تعداد صفر یا کمتر شد، آیتم را حذف کن
                unset($items[$index]);
            } else {
                // در غیر این صورت، تعداد را به روز رسانی کن
                $items[$index]['quantity'] = $newQuantity;
            }

            session()->put('cart', array_values($items)); // ذخیره آرایه تمیز در سشن
            $this->dispatch('cart-updated');
            $this->dispatch('notify', type: 'success', message: 'تعداد سبد خرید به‌روز شد.');
            // فراخوانی رندر مجدد
            // نیازی به $this->js('$refresh') نیست زیرا رندر کردن متد updateQuantity View را به روز می‌کند
        }
    }

    public function remove(int $productIdToRemove): void
    {
        $cart = collect(session()->get('cart', []));

        // 1. حذف آیتم از سشن بر اساس شناسه محصول
        $newCart = $cart->reject(fn($item) => ($item['product_id'] ?? 0) === $productIdToRemove);
        session()->put('cart', $newCart->values()->all());

        // 2. ارسال رویداد برای به‌روزرسانی سایر بخش‌های UI
        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', message: 'محصول با موفقیت از سبد حذف شد.');

        // 3. رندر مجدد: Livewire به طور خودکار متد render را فراخوانی می‌کند.
    }

    /**
     * متد رندر: داده‌های سبد خرید را از سشن بارگذاری و غنی‌سازی می‌کند.
     */
    public function render()
    {
        $cart = collect(session()->get('cart', []));
        $total = 0;
        $items = [];

        // شناسه تمام محصولات برای کوئری به دیتابیس
        $productIds = $cart->pluck('product_id')->unique()->toArray();
        // بارگذاری تمام مدل‌های محصول مورد نیاز یکجا
        // Note: Spatie Media Library loads media automatically, no need to eager load
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $row) {
            $productId = $row['product_id'];
            $quantity = $row['quantity'];


            $product = $products->get($productId);

            // اگر محصولی در دیتابیس موجود بود، داده‌ها را غنی‌سازی کن
            if ($product) {
                $price = $product->price;
                $subtotal = $price * $quantity;
                $total += $subtotal;
                
                // Get image URL - check media directly
                $media = $product->getFirstMedia('product_images');
                if ($media) {
                    $imageUrl = $media->getUrl();
                } else {
                    $imageUrl = asset('images/no-image.svg');
                }
                
                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'product' => $product,
                    'image_url' => $imageUrl,
                ];
            }
        }


        return view('livewire.cart-index', [
            'items' => collect($items),
            'total' => $total,
        ]);
    }
}
