<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'address', 'avatar', 'status', 'last_login'
    ];

    protected $hidden = ['password'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}