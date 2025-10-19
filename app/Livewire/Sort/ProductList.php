<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductList extends Component
{
    // ... existing properties (minPrice, maxPrice, etc.) ...

    // New property for sorting
    public $sortField = 'newest';
    public $sortDirection = 'desc';

    // Map the short key from the dropdown to DB fields and directions
    public function setSort($key)
    {
        $this->sortField = match ($key) {
            'price_asc' => 'price',
            'price_desc' => 'price',
            'popular' => 'views', // Assuming you track views/popularity
            default => 'created_at',
        };

        $this->sortDirection = match ($key) {
            'price_asc' => 'asc',
            default => 'desc',
        };

        // This will trigger the re-render and re-fetch of products
        $this->resetPage();
    }

    // Helper to get the human-readable text for the button
    public function getCurrentSortText()
    {
        return match (true) {
            $this->sortField === 'price' && $this->sortDirection === 'asc' => 'ارزان‌ترین',
            $this->sortField === 'price' && $this->sortDirection === 'desc' => 'گران‌ترین',
            $this->sortField === 'views' => 'محبوب‌ترین',
            default => 'جدیدترین',
        };
    }

    // Update the render method to apply sorting
    public function render()
    {
        $products = Product::whereBetween('price', [$this->min, $this->max])
            ->orderBy($this->sortField, $this->sortDirection) // Apply sorting
            ->get();

        return view('livewire.sort.product-list', compact('products'));
    }
}
