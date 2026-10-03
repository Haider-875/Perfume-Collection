<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'bundle_id',
        'product_name',
        'variant_label',
        'price',
        'quantity',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 0);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rs. ' . number_format($this->total, 0);
    }
}
