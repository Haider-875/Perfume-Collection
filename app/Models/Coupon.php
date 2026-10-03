<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_spend',
        'max_discount',
        'expires_at',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'expires_at' => 'date',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function isValid($cartSubtotal)
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($cartSubtotal < $this->min_spend) return false;
        return true;
    }

    public function calculateDiscount($cartSubtotal)
    {
        if (!$this->isValid($cartSubtotal)) return 0;

        if ($this->type === 'percentage') {
            $discount = ($cartSubtotal * $this->value) / 100;
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return $discount;
        }

        return min($this->value, $cartSubtotal);
    }
}
