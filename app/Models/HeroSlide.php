<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'badge_text',
        'image',
        'cta_text',
        'cta_url',
        'secondary_cta_text',
        'secondary_cta_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        });
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }

    public function getIsVideoAttribute()
    {
        return \Illuminate\Support\Str::endsWith(strtolower($this->image ?? ''), ['.mp4', '.webm', '.ogg', '.mov']);
    }
}
