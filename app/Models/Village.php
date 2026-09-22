<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'name', 'district', 'state', 'pincode', 'delivery_charge', 'status'
    ];

    // Scope: only active villages
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function pharmacies()
    {
        return $this->hasMany(Pharmacy::class);
    }

    public function deliveryPartners()
    {
        return $this->hasMany(DeliveryPartner::class);
    }
}