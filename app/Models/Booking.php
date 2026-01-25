<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'booking_date',
        'booking_time',
        'total_price',
        'notes',
        'status',
        'payment_proof',
        'is_paid',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'booking_products');
    }
}
