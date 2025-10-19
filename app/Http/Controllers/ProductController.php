<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
        $products = Product::all();

        return view('guest.home', ['products' => $products]);
    }

    public function mount(Product $product)
    {
        return view('guest.product', ['product' => $product]);
    }
}
