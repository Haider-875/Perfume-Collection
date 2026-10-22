<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'banner_image',
        'badge_text',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
            \Illuminate\Support\Facades\Cache::flush();
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
            \Illuminate\Support\Facades\Cache::flush();
        });
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
            if (!str_ends_with(strtolower($this->image), '.svg')) {
                return asset($this->image);
            }
        }
        return asset('assets/images/categories/collection_signature.jpg');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_collection')
                    ->withPivot('sort_order')
                    ->orderBy('product_collection.sort_order', 'asc');
    }

    public function activeProducts()
    {
        return $this->belongsToMany(Product::class, 'product_collection')
                    ->where('products.is_active', true)
                    ->withPivot('sort_order')
                    ->orderBy('product_collection.sort_order', 'asc');
    }
}
