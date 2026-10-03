<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FragranceFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'accent_color',
        'description',
        'icon',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
