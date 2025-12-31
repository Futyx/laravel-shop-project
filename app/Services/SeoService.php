<?php

namespace App\Services;

class SeoService
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $image;
    protected $url;
    protected $type;
    protected $siteName;
    protected $locale;

    public function __construct()
    {
        $this->siteName = config('app.name', 'ChizMart');
        $this->locale = app()->getLocale() ?? 'fa';
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setKeywords(string|array $keywords): self
    {
        $this->keywords = is_array($keywords) ? implode(', ', $keywords) : $keywords;
        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title ?? $this->siteName;
    }

    public function getDescription(): string
    {
        return $this->description ?? 'فروشگاه اینترنتی چیزمارت - خرید آنلاین محصولات آرایشی و بهداشتی و خوراکی‌های خاص خارجی';
    }

    public function getKeywords(): string
    {
        return $this->keywords ?? 'فروشگاه اینترنتی, خرید آنلاین, محصولات آرایشی, محصولات بهداشتی, چیزمارت';
    }

    public function getImage(): string
    {
        return $this->image ?? asset('images/logo.png');
    }

    public function getUrl(): string
    {
        return $this->url ?? url('/');
    }

    public function getType(): string
    {
        return $this->type ?? 'website';
    }

    public function generateMetaTags(): string
    {
        $title = $this->getTitle();
        $description = $this->getDescription();
        $keywords = $this->getKeywords();
        $image = $this->getImage();
        $url = $this->getUrl();
        $type = $this->getType();
        $siteName = $this->siteName;

        $html = "<title>{$title}</title>\n";
        $html .= "<meta name=\"description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta name=\"keywords\" content=\"" . htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta name=\"author\" content=\"{$siteName}\">\n";
        $html .= "<link rel=\"canonical\" href=\"" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\">\n";
        
        // Open Graph
        $html .= "<meta property=\"og:title\" content=\"" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta property=\"og:description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta property=\"og:image\" content=\"" . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta property=\"og:url\" content=\"" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta property=\"og:type\" content=\"{$type}\">\n";
        $html .= "<meta property=\"og:site_name\" content=\"{$siteName}\">\n";
        $html .= "<meta property=\"og:locale\" content=\"{$this->locale}\">\n";
        
        // Twitter Card
        $html .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        $html .= "<meta name=\"twitter:title\" content=\"" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta name=\"twitter:description\" content=\"" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "\">\n";
        $html .= "<meta name=\"twitter:image\" content=\"" . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "\">\n";
        
        // Additional SEO
        $html .= "<meta name=\"robots\" content=\"index, follow\">\n";
        $html .= "<meta name=\"googlebot\" content=\"index, follow\">\n";
        $html .= "<meta name=\"language\" content=\"{$this->locale}\">\n";
        $html .= "<meta name=\"revisit-after\" content=\"7 days\">\n";

        return $html;
    }

    public function generateProductSchema($product): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->title,
            'description' => $product->description ?? $product->title,
            'image' => $product->getFirstImageUrl() ?: asset('images/no-image.svg'),
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->siteName
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $product->price,
                'priceCurrency' => 'IRR',
                'availability' => 'https://schema.org/InStock',
                'url' => route('product.show', $product)
            ]
        ];

        $rating = $this->getProductRating($product);
        if ($rating) {
            $schema['aggregateRating'] = $rating;
        }

        if ($product->category) {
            $schema['category'] = $product->category->name;
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    public function generateOrganizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->siteName,
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'description' => 'فروشگاه اینترنتی چیزمارت - خرید آنلاین محصولات آرایشی و بهداشتی و خوراکی‌های خاص خارجی',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+98-902-259-3643',
                'contactType' => 'customer service',
                'areaServed' => 'IR',
                'availableLanguage' => ['fa']
            ],
            'sameAs' => [
                // Add social media links here when available
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    public function generateBreadcrumbSchema($items): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        $position = 1;
        foreach ($items as $item) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => $item['url']
            ];
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    public function generateWebsiteSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $this->siteName,
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/') . '/search?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    protected function getProductRating($product)
    {
        if ($product->reviews && $product->reviews->count() > 0) {
            $avgRating = $product->reviews->avg('rating');
            $reviewCount = $product->reviews->count();
            
            return [
                '@type' => 'AggregateRating',
                'ratingValue' => round($avgRating, 1),
                'reviewCount' => $reviewCount
            ];
        }
        
        return null;
    }
}

