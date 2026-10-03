<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'default_layer',
        'aroma_family',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_scent_notes')
                    ->withPivot('note_layer', 'prominence_percentage')
                    ->withTimestamps();
    }
}
