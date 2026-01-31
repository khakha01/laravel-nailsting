<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NailBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'nail_id',
        'nail_price',
        'booking_date',
        'booking_time',
        'deposit_amount',
        'total_amount',
        'remaining_amount',
        'payment_proof',
        'status',
        'payment_status',
        'notes',
        'terms_accepted',
        'admin_notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'nail_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'terms_accepted' => 'boolean',
    ];

    // Relationships
    public function nail()
    {
        return $this->belongsTo(Nail::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function hasDepositPaid()
    {
        return $this->payment_status === 'deposit_paid' || $this->payment_status === 'fully_paid';
    }

    public function isFullyPaid()
    {
        return $this->payment_status === 'fully_paid';
    }
}
