<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // The line needed if you want to check login status

class HomeController extends Controller
{

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('profile.edit'); 
    }

  
    // public function show() { 
    //     return $this->profile(); 
    // }

    public function show() {

        $products = Product::all();


        return view('home.index', ['products' => $products]);
        
    }
}
