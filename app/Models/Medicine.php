<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'pharmacy_id', 'name', 'brand', 'category', 'composition',
        'description', 'price', 'mrp', 'stock', 'image',
        'featured', 'prescription_required', 'expiry_date', 'status'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'prescription_required' => 'boolean',
        'expiry_date' => 'date',
        'price' => 'decimal:2',
        'mrp' => 'decimal:2',
    ];

    // Scope: only active medicines (used in all frontend queries)
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope: featured + active
    public function scopeFeatured($query)
    {
        return $query->active()->where('featured', true);
    }

    // Scope: in stock + active
    public function scopeInStock($query)
    {
        return $query->active()->where('stock', '>', 0);
    }

    // Scope: low stock
    public function scopeLowStock($query, $threshold = 20)
    {
        return $query->active()->where('stock', '>', 0)->where('stock', '<=', $threshold);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function reviews()
    {
        return $this->hasMany(MedicineReview::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}