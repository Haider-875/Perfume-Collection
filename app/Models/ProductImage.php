<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('homepage_curated_data_v3');
            Cache::forget('homepage_curated_data_v1');
            Cache::forget('homepage_curated_data_v2');
            Cache::flush();
        });

        static::deleted(function () {
            Cache::forget('homepage_curated_data_v3');
            Cache::forget('homepage_curated_data_v1');
            Cache::forget('homepage_curated_data_v2');
            Cache::flush();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute()
    {
        if (empty($this->image_path)) {
            return asset('assets/images/perfumes/prod_signature.jpg');
        }
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }
        return asset(ltrim(str_replace('\\', '/', $this->image_path), '/'));
    }
}
