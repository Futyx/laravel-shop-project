<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = collect($request->session()->get('cart', []));
        $productIds = $cart->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = $cart->map(function ($row) use ($products) {
            $product = $products->get($row['product_id']);
            return [
                'product' => $product,
                'quantity' => $row['quantity'],
                'price' => $product?->price ?? 0,
                'subtotal' => ($product?->price ?? 0) * $row['quantity'],
            ];
        });

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
    public function remove(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        echo($cart);
    }
}

