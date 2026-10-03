<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_code',
        'discount_amount',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTotalAttribute()
    {
        return max(0, $this->subtotal - $this->discount_amount);
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rs. ' . number_format($this->subtotal, 0);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rs. ' . number_format($this->total, 0);
    }
}
