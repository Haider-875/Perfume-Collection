<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'customer_name',
        'customer_city',
        'rating',
        'title',
        'comment',
        'verified_purchase',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute()
    {
        return $this->attributes['customer_name'] ?? ($this->user->name ?? 'Verified Patron');
    }

    public function getUserCityAttribute()
    {
        return $this->attributes['customer_city'] ?? 'Pakistan';
    }
}
