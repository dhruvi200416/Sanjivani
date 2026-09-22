<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineReview extends Model
{
    protected $fillable = [
        'medicine_id', 'customer_id', 'rating', 'comment', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}