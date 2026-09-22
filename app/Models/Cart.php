<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'customer_id', 'medicine_id', 'quantity', 'unit_price'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}