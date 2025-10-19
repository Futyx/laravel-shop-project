<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    // شناسه محصول
    public int $productId;
    
    // تعداد محصول
    public int $count; 
    
    // متد mount برای دریافت پارامترها
    public function mount(int $productId, int $initialQuantity)
    {
        $this->productId = $productId;
        $this->count = $initialQuantity; 
    }
    
    // تابع کمکی خصوصی برای ارسال رویداد به والد
    private function dispatchUpdate(): void
    {
        // ارسال رویداد به کامپوننت والد (CartIndex) با شناسه محصول و مقدار جدید
        $this->dispatch('update-cart-quantity', productId: $this->productId, newQuantity: $this->count);
    }
    
    // متد برای افزایش تعداد
    public function increment()
    {
        $this->count++;
        // فراخوانی تابع ارسال رویداد
        $this->dispatchUpdate();
    }
    
    // متد برای کاهش تعداد
    public function decrement()
    {
        if ($this->count > 0) {
            $this->count--;
        }
        
        // فراخوانی تابع ارسال رویداد
        $this->dispatchUpdate();
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
