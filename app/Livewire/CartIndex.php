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

        // پیدا کردن سطر محصول بر اساس productId
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
            
            // فراخوانی رندر مجدد
            // نیازی به $this->js('$refresh') نیست زیرا رندر کردن متد updateQuantity View را به روز می‌کند
        }
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
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $row) {
            $productId = $row['product_id'];
            $quantity = $row['quantity'];
            
            $product = $products->get($productId);

            // اگر محصولی در دیتابیس موجود بود، داده‌ها را غنی‌سازی کن
            if ($product) {
                // فرض بر این است که قیمت در ستون 'price' مدل Product ذخیره شده است
                $price = $product->price; 
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $items[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'product' => $product, // ارسال مدل کامل محصول
                ];
            }
        }

        // تغییر نام View به livewire.cart-index برای هماهنگی با نام کلاس (CartIndex)
        return view('livewire.cart-index', [ 
            'items' => collect($items),
            'total' => $total,
        ]);
    }
}
