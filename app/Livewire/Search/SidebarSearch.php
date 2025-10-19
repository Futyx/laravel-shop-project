<?php

namespace App\Livewire\Search;

use Livewire\Component;
use App\Models\Product;

class SidebarSearch extends Component
{

    public string $query = '';

    public $products = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->products = [];
            return;
        }

        $this->products = Product::where('title', 'like', '%' . $this->query . '%')
            ->take(5) 
            ->get();
    }
    public function render()
    {
        return view('livewire.search.sidebar-search');
    }
}
