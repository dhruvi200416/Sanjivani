<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = [
        'banner_text', 'story_heading', 'story_lead', 'story_para1', 'story_para2',
        'main_image', 'sub_image', 'founder_name', 'founder_designation',
        'mission_text', 'vision_text', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}