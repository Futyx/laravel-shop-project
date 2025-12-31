<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SeoService;
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

        $seo = (new SeoService())
            ->setTitle('فروشگاه اینترنتی چیزمارت - محصولات آرایشی و بهداشتی')
            ->setDescription('خرید آنلاین محصولات آرایشی و بهداشتی و خوراکی‌های خاص خارجی از فروشگاه اینترنتی چیزمارت')
            ->setKeywords(['فروشگاه اینترنتی', 'خرید آنلاین', 'محصولات آرایشی', 'محصولات بهداشتی', 'چیزمارت'])
            ->setUrl(url('/'));

        $structuredData = $seo->generateWebsiteSchema() . "\n" . $seo->generateOrganizationSchema();

        return view('home.index', [
            'products' => $products,
            'seo' => $seo,
            'structuredData' => $structuredData
        ]);
        
    }
}
