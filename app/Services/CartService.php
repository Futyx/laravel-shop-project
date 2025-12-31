<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getDetails()
    {
        $cartItems = collect(Session::get('cart', []));
        $productIds = $cartItems->pluck('product_id')->all();
        $products = Product::whereIn('id', $productIds)->with('media')->get()->keyBy('id');

        $items = $cartItems->map(function ($row) use ($products) {
            $product = $products->get($row['product_id']);
            return [
                'product' => $product,
                'quantity' => $row['quantity'],
                'price' => $product?->price ?? 0,
                'subtotal' => ($product?->price ?? 0) * $row['quantity'],
                'image_url' => $product ? $product->getThumbnailUrl() : null,
            ];
        });

        return [
            'items' => $items,
            'totalAmount' => $items->sum('subtotal'),
        ];
    }
}