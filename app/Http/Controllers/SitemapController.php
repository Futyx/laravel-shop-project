<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $sitemap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $sitemap .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9';
        $sitemap .= ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        // Homepage
        $sitemap .= $this->url(url('/'), now(), 'daily', '1.0');

        // Products
        $products = Product::all();
        foreach ($products as $product) {
            $sitemap .= $this->url(
                route('product.show', $product),
                $product->updated_at ?? now(),
                'weekly',
                '0.8'
            );
        }

        // Categories (if you have category pages)
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= $this->url(
                url('/?category=' . $category->id),
                $category->updated_at ?? now(),
                'weekly',
                '0.7'
            );
        }

        // Static pages
        $staticPages = [
            route('conditions'),
        ];

        foreach ($staticPages as $page) {
            $sitemap .= $this->url($page, now(), 'monthly', '0.5');
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    protected function url($loc, $lastmod, $changefreq, $priority)
    {
        $url = "  <url>\n";
        $url .= "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        $url .= "    <lastmod>" . $lastmod->format('Y-m-d') . "</lastmod>\n";
        $url .= "    <changefreq>" . $changefreq . "</changefreq>\n";
        $url .= "    <priority>" . $priority . "</priority>\n";
        $url .= "  </url>\n";
        return $url;
    }
}


