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
