<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $fillable = [
        'hero_badge', 'hero_title', 'hero_subtitle', 'hero_image', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}