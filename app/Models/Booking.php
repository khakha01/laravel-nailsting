<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'booking_date',
        'booking_time',
        'total_price',
        'paid_amount',
        'paid_at',
        'notes',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'booking_products');
    }
}
