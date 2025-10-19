<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;




class Product extends Model implements HasMedia
{

    use InteractsWithMedia;
    use HasFactory;
    // use Sluggable;
    use HasTags;

    protected $guarded = [
        'id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the first product image
     */
    public function getFirstImageUrl(string $conversion = ''): string
    {
        $media = $this->getFirstMedia('product_images');
        return $media ? $media->getUrl($conversion) : asset('images/no-image.svg');
    }

    /**
     * Get all product images
     */
    public function getAllImages(string $conversion = ''): \Illuminate\Support\Collection
    {
        return $this->getMedia('product_images')->map(function ($media) use ($conversion) {
            return $media->getUrl($conversion);
        });
    }

    /**
     * Get product thumbnail
     */
    public function getThumbnailUrl(): string
    {
        return $this->getFirstImageUrl('thumb');
    }

    /**
     * Check if product has images
     */
    public function hasImages(): bool
    {
        return $this->hasMedia('product_images');
    }

    /**
     * Register media conversions for product images
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('product_images');

        $this->addMediaConversion('medium')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->performOnCollections('product_images');

        $this->addMediaConversion('large')
            ->width(800)
            ->height(800)
            ->sharpen(10)
            ->performOnCollections('product_images');
    }
}
