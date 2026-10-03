<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_label',
        'volume_ml',
        'price',
        'sale_price',
        'sku',
        'stock',
        'is_default',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'is_default' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute()
    {
        return ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price)
            ? $this->sale_price
            : $this->price;
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 0);
    }

    public function getFormattedEffectivePriceAttribute()
    {
        return 'Rs. ' . number_format($this->effective_price, 0);
    }
}
