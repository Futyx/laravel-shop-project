<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\CartService;

class CartController extends Controller
{
    public function index(Request $request, CartService $cartService): View
    {
        $cart = $cartService->getDetails();

        $items       = $cart['items'];      
        $totalAmount = $cart['totalAmount'];

        $total = $items->sum('subtotal');

        return view('components.cart.index', compact('items', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = (int)($data['quantity'] ?? 1);
        $productId = (int)$data['product_id'];

        $cart = $request->session()->get('cart', []);


        // $cart = collect($request->session()->get('cart', []));

        $existingIndex = -1;
        foreach ($cart as $index => $item) {
            if ($item['product_id'] === $productId) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== -1) {
            // آیتم مستقیماً در آرایه PHP تغییر داده می‌شود (بدون خطای Collection)
            $cart[$existingIndex]['quantity'] += $quantity;
        } else {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }
        $request->session()->put('cart', array_values($cart)); // استفاده از array_values برای اطمینان از آرایه تمیز

        return back()->with('success', 'محصول به سبد انتظار پرداخت اضافه شد.');
    }
    public function remove(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $productId = (int)$data['product_id'];

        // 2. دریافت سبد خرید از سشن
        $cart = $request->session()->get('cart', []);

        // 3. پیدا کردن و حذف آیتم
        // ما از Collection استفاده می‌کنیم تا کار با آرایه راحت‌تر باشد
        $cartCollection = collect($cart);

        // findIndex یک متد Collection است که index آیتم مطابق شرط را پیدا می‌کند
        $existingIndex = $cartCollection->search(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });

        if ($existingIndex !== false) {
            // آیتم را بر اساس index آن حذف می‌کنیم
            $cartCollection->splice($existingIndex, 1);
        }

        // 4. ذخیره مجدد سبد خرید در سشن و ری‌ایندکس کردن کلیدها
        $request->session()->put('cart', $cartCollection->values()->all());

        return back()->with('success', 'محصول با موفقیت از سبد خرید حذف شد.');
    }
}
