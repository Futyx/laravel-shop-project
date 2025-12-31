<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;

class OrderController extends Controller
{
    public function store(Request $request, CartService $cartService)
    {
        $cart = $cartService->getDetails();
        $cartItems = $cart['items'];
        $totalAmount = $cart['totalAmount'];
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'سبد خرید شما خالی است.');
        }
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'new',
            'payment_status' => 'pending',
            'phone' => $request->phone, 
            'email' => $request->email,
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['product']['id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        if ($order->payment_status === 'paid') {
            $request->session()->forget('cart');
        }

        return redirect()->route('payment.pay', ['order' => $order->id]);
    }
}
