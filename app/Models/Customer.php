<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'village_id',
        'address',
        'avatar',
        'gender',
        'dob',
        'status',
        'email_notifications',
        'sms_notifications',
        'promo_notifications',
        'rx_reminders',
        'last_login'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'dob' => 'date',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'promo_notifications' => 'boolean',
        'rx_reminders' => 'boolean',
    ];

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

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function reviews()
    {
        return $this->hasMany(MedicineReview::class);
    }
}
