<?php

namespace App\Livewire\Search;

use Livewire\Component;
use App\Models\Product;


class NavbarSearch extends Component
{
    public $search = '';
    public int $dropdownLimit = 5;

    public function render()
    {
        $products = strlen($this->search) >= 2
            ? Product::where('title', 'like', '%' . $this->search . '%')
                ->orderByDesc('id')
                ->limit($this->dropdownLimit)
                ->get()
            : collect();
        return view('livewire.search.navbar-search', [
            'products' => $products,
        
        ]);
    }
}
