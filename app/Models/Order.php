<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'pharmacy_id', 'delivery_partner_id', 'prescription_id',
        'subtotal', 'delivery_fee', 'tax', 'discount', 'total_amount',
        'coupon_code', 'delivery_address', 'notes',
        'payment_method', 'payment_status', 'order_status', 'status'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(DeliveryPartner::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}