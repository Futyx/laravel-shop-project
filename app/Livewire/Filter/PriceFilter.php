<?php

namespace App\Livewire;

use Livewire\Component;

class PriceFilter extends Component
{
    // These will hold the current minimum and maximum values selected by the user
    public $minPrice = 0;
    public $maxPrice = 500000; // Example initial max value

    // The actual min/max prices available in your products (optional but good for context)
    public $priceRangeMin = 0;
    public $priceRangeMax = 500000; 

    // Listeners and initialization logic
    public function mount()
    {
        // Typically, you would fetch the true min/max range from your database here.
        // For now, we use the default examples.
        // $this->priceRangeMax = Product::max('price');
        $this->maxPrice = $this->priceRangeMax; 
    }

    // This method is called every time a change is made to minPrice or maxPrice
    public function updated($field)
    {
        // Ensure min doesn't exceed max and vice-versa
        if ($this->minPrice > $this->maxPrice) {
            $this->minPrice = $this->maxPrice;
        }
        if ($this->maxPrice < $this->minPrice) {
            $this->maxPrice = $this->minPrice;
        }

        // Emit an event that your product listing component can listen to
        $this->dispatch('price-filter-updated', min: $this->minPrice, max: $this->maxPrice);
    }

    public function render()
    {
        return view('livewire.price-filter');
    }
}