<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function index()
    {
        $appUrl = config('app.url', url('/'));
        $sitemapUrl = $appUrl . '/sitemap.xml';

        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n\n";
        $robots .= "# Sitemap\n";
        $robots .= "Sitemap: {$sitemapUrl}\n\n";
        $robots .= "# Disallow admin and private areas\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /dashboard/\n";
        $robots .= "Disallow: /profile/\n";
        $robots .= "Disallow: /cart/\n";
        $robots .= "Disallow: /payment/\n";
        $robots .= "Disallow: /storage/\n";
        $robots .= "Disallow: /vendor/\n\n";
        $robots .= "# Allow important resources\n";
        $robots .= "Allow: /css/\n";
        $robots .= "Allow: /js/\n";
        $robots .= "Allow: /images/\n";
        $robots .= "Allow: /build/\n\n";
        $robots .= "# Crawl-delay (optional, adjust as needed)\n";
        $robots .= "Crawl-delay: 1\n";

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}


