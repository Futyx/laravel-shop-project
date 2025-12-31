<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
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

    public function mount(Product $product)
    {
        $seo = (new SeoService())
            ->setTitle($product->title . ' - چیزمارت')
            ->setDescription($product->description ?? $product->title)
            ->setImage($product->getFirstImageUrl() ?: asset('images/logo.png'))
            ->setUrl(route('product.show', $product))
            ->setType('product');

        $breadcrumbs = [
            ['name' => 'خانه', 'url' => url('/')],
            ['name' => $product->category->name ?? 'محصولات', 'url' => url('/')],
            ['name' => $product->title, 'url' => route('product.show', $product)]
        ];

        $structuredData = $seo->generateProductSchema($product) . "\n" . 
                         $seo->generateBreadcrumbSchema($breadcrumbs) . "\n" . 
                         $seo->generateOrganizationSchema();

        return view('guest.product', [
            'product' => $product,
            'seo' => $seo,
            'structuredData' => $structuredData
        ]);
    }
}
