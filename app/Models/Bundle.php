<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'tagline',
        'description',
        'original_price',
        'bundle_price',
        'savings_amount',
        'image',
        'badge_text',
        'is_active',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'bundle_price' => 'decimal:2',
        'savings_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items', 'bundle_id', 'product_id');
    }

    public function getPriceAttribute()
    {
        return $this->bundle_price;
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return 'Rs. ' . number_format($this->original_price, 0);
    }

    public function getFormattedBundlePriceAttribute()
    {
        return 'Rs. ' . number_format($this->bundle_price, 0);
    }

    public function getFormattedSavingsAttribute()
    {
        return 'Rs. ' . number_format($this->savings_amount, 0);
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image ?? 'assets/images/perfumes/discovery_set.svg');
    }
}
