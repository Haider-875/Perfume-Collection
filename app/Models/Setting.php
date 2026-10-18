<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get($key, $default = null)
    {
        static $cachedDict = null;
        if ($cachedDict === null) {
            try {
                $cachedDict = \Illuminate\Support\Facades\Cache::remember('app_settings_all_dict', 86400, function () {
                    return static::all()->pluck('value', 'key')->toArray();
                });
            } catch (\Throwable $e) {
                $cachedDict = [];
            }
        }
        return array_key_exists($key, $cachedDict) ? $cachedDict[$key] : $default;
    }

    public static function set($key, $value, $group = 'general')
    {
        \Illuminate\Support\Facades\Cache::forget('app_settings_all_dict');
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }
}
