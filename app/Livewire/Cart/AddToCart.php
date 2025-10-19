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

    public function mount(int $productId): void
    {
        $this->productId = $productId;
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
        $this->dispatch('notify', type: 'success', message: 'به سبد انتظار پرداخت اضافه شد');

        $this->busy = false;
        
    }

    public function remove(int $productIdToRemove): void
    {


        $cart = collect(session()->get('cart', []));
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart');
    }
}
