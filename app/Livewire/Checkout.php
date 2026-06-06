<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Checkout extends Component
{
    public string $shipping_address = '';
    public string $shipping_phone = '';
    public string $postal_code = '';
    
    public $cartItems = [];
    public $totalAmount = 0;
    public bool $isSubmitting = false;

    public function mount(CartService $cartService)
    {
        $cart = $cartService->getDetails();
        $this->cartItems = $cart['items']->toArray();
        $this->totalAmount = $cart['totalAmount'];

        // Pre-fill user data if available
        if (Auth::check()) {
            $user = Auth::user();
            $this->shipping_phone = $user->phone ?? '';
        }

        // Redirect if cart is empty
        if (empty($this->cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'سبد خرید شما خالی است.');
        }
    }

    protected function rules()
    {
        return [
            'shipping_address' => ['required', 'string', 'min:10', 'max:500'],
            'shipping_phone' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'postal_code' => ['required', 'string', 'regex:/^\d{10}$/'],
        ];
    }

    protected function messages()
    {
        return [
            'shipping_address.required' => 'آدرس ارسال الزامی است.',
            'shipping_address.min' => 'آدرس ارسال باید حداقل ۱۰ کاراکتر باشد.',
            'shipping_phone.required' => 'شماره تماس الزامی است.',
            'shipping_phone.regex' => 'شماره تماس باید به فرمت 09xxxxxxxxx باشد.',
            'postal_code.required' => 'کد پستی الزامی است.',
            'postal_code.regex' => 'کد پستی باید ۱۰ رقم باشد.',
        ];
    }

   public function submit()
{
    $this->validate();

    $this->isSubmitting = true;

    $cartService = app(CartService::class);
    $cart = $cartService->getDetails();
    $cartItems = $cart['items'];
    $totalAmount = $cart['totalAmount'];

    if ($cartItems->isEmpty()) {
        $this->addError('cart', 'سبد خرید شما خالی است.');
        $this->isSubmitting = false;
        return;
    }

    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $totalAmount,
        'status' => 'new',
        'payment_status' => 'pending',
        'shipping_address' => $this->shipping_address,
        'shipping_phone' => $this->shipping_phone,
        'postal_code' => $this->postal_code,
        'phone' => $this->shipping_phone,
        'email' => Auth::user()->email ?? null,
    ]);

    foreach ($cartItems as $item) {
        $product = Product::find($item['product']['id']);
        
        if ($product) {
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
            ]);
        }
    }

    session()->forget('cart');

    return redirect()->route('payment.pay', ['order' => $order->id]);
}

    public function render()
    {
        return view('livewire.checkout')
        ->layout('layouts.app');
    }
}

