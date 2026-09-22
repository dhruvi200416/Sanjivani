<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'file_name',
        'file_path',
        'doctor_name',
        'patient_name',
        'village_id',
        'notes',
        'urgency',
        'status',
        'review_status',
    ];

    /**
     * Scope to get active prescriptions (status = active and review_status = pending or approved)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->whereIn('review_status', ['pending', 'approved']);
    }

    /**
     * Scope to get pending reviews
     */
    public function scopePendingReview($query)
    {
        return $query->where('review_status', 'pending');
    }

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
