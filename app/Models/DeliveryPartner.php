<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'village_id', 'address',
        'vehicle_type', 'vehicle_number', 'aadhar_number', 'license_dl',
        'rating', 'total_deliveries', 'total_earnings', 'availability', 'status', 'last_login'
    ];

    protected $hidden = ['password', 'aadhar_number'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}