<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'area',
        'landmark',
        'city',
        'province',
        'postal_code',
        'order_notes',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_receipt',
        'bank_transaction_id',
        'order_status',
        'tracking_number',
        'courier_name',
        'tracking_link',
        'is_whatsapp_order',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_whatsapp_order' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rs. ' . number_format($this->total_amount, 0);
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rs. ' . number_format($this->subtotal, 0);
    }

    public function getFormattedShippingAttribute()
    {
        return $this->shipping_cost == 0 ? 'FREE' : 'Rs. ' . number_format($this->shipping_cost, 0);
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->order_status) {
            'confirmed' => 'badge-gold',
            'processing' => 'badge-info',
            'shipped' => 'badge-purple',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger',
            default => 'badge-warning',
        };
    }
}
