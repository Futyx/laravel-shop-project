<?php

namespace App\Livewire\Cart;

use Livewire\Attributes\On;
use Livewire\Component;

class CartBadge extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->refreshCount();
    }

    #[On('cart-updated')]
    public function refreshCount(): void
    {
        $items = collect(session()->get('cart', []));
        $this->count = (int) $items->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart.cart-badge');
    }
}



