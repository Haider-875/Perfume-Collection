<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'ip_address',
        'page_url',
        'referer',
        'user_agent',
        'device_type',
        'utm_source',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
