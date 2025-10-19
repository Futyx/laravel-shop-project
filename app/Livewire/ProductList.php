<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductList extends Component
{
    public $search = '';
    public $dropdownLimit = 5;

    public function getSearchReasults()
    {
        if (strlen($this->search) < 2) {
            return collect();
        }
        return Product::where('title', 'like', '%' . $this->search . '%')
            ->limit($this->dropdownLimit)
            ->get();
    }

    public function render()
    {
        $products = $this->search
            ? Product::where('title', 'like', '%' . $this->search . '%')->get()
            : Product::all();
        return view('livewire.product-list', compact('products'));
    }
}
