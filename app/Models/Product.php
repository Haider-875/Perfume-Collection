<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'fragrance_family_id',
        'name',
        'impression_of',
        'slug',
        'sku',
        'tagline',
        'concentration',
        'gender',
        'volume_ml',
        'price',
        'sale_price',
        'compare_at_price',
        'stock',
        'in_stock',
        'longevity',
        'sillage',
        'season',
        'time_of_day',
        'top_notes_summary',
        'heart_notes_summary',
        'base_notes_summary',
        'fragrance_notes_pyramid',
        'story',
        'description',
        'application_guide',
        'ingredients',
        'is_featured',
        'is_bestseller',
        'is_new_arrival',
        'is_limited_edition',
        'is_bundle',
        'is_collaboration',
        'is_active',
        'rating_avg',
        'reviews_count',
        'views_count',
        'thumbnail_image',
        'hover_image',
        'lifestyle_image',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'stock' => 'integer',
        'fragrance_notes_pyramid' => 'array',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_limited_edition' => 'boolean',
        'is_bundle' => 'boolean',
        'is_collaboration' => 'boolean',
        'is_active' => 'boolean',
        'rating_avg' => 'float',
        'reviews_count' => 'integer',
        'views_count' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'product_collection')
                    ->withPivot('sort_order')
                    ->orderBy('product_collection.sort_order', 'asc');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function fragranceFamily()
    {
        return $this->belongsTo(FragranceFamily::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function scentNotes()
    {
        return $this->belongsToMany(ScentNote::class, 'product_scent_notes')
                    ->withPivot('note_layer', 'prominence_percentage')
                    ->withTimestamps();
    }

    public function topNotes()
    {
        return $this->scentNotes()->wherePivot('note_layer', 'top');
    }

    public function heartNotes()
    {
        return $this->scentNotes()->wherePivot('note_layer', 'heart');
    }

    public function baseNotes()
    {
        return $this->scentNotes()->wherePivot('note_layer', 'base');
    }

    // Accessors & Helper Methods
    public function getEffectivePriceAttribute()
    {
        return ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price)
            ? $this->sale_price
            : $this->price;
    }

    public function getHasDiscountAttribute()
    {
        return ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price) || ($this->compare_at_price && $this->compare_at_price > $this->price);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        if ($this->compare_at_price && $this->compare_at_price > $this->price) {
            return round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 0);
    }

    public function getFormattedCompareAtPriceAttribute()
    {
        $comp = $this->compare_at_price ?? ($this->sale_price ? $this->price : null);
        return $comp ? 'Rs. ' . number_format($comp, 0) : null;
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? 'Rs. ' . number_format($this->sale_price, 0) : null;
    }

    public function getFormattedEffectivePriceAttribute()
    {
        return 'Rs. ' . number_format($this->effective_price, 0);
    }

    public function getPrimaryImageUrlAttribute()
    {
        if ($this->thumbnail_image) {
            return asset($this->thumbnail_image);
        }
        return asset('assets/images/perfumes/prod_signature.jpg');
    }

    public function getHoverImageUrlAttribute()
    {
        if ($this->hover_image) {
            return asset($this->hover_image);
        }
        return $this->primary_image_url;
    }

    // WhatsApp Direct Order Message Generator
    public function getWhatsAppOrderUrlAttribute()
    {
        $phone = function_exists('settings') ? settings('site_whatsapp', '923363685732') : config('app.whatsapp_number', '923363685732');
        $phone = preg_replace('/[^0-9]/', '', (string)$phone) ?: '923363685732';
        if (str_starts_with($phone, '03')) {
            $phone = '92' . substr($phone, 1);
        }
        $msg = "Salam! I would like to order *{$this->name}* ({$this->concentration}, {$this->volume_ml}ml) for {$this->formatted_effective_price}. Please confirm stock and 24h courier delivery.";
        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeBundles($query)
    {
        return $query->where('is_bundle', true);
    }

    public function scopeCollaborations($query)
    {
        return $query->where('is_collaboration', true);
    }
}
