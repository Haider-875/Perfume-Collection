<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductScentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'scent_note_id',
        'note_layer',
        'prominence_percentage',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scentNote()
    {
        return $this->belongsTo(ScentNote::class);
    }
}
