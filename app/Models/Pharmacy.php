<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'pharmacy_name', 'owner_name', 'email', 'phone', 'password',
        'license_number', 'village_id', 'address', 'logo', 'status', 'last_login'
    ];

    protected $hidden = ['password'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}