<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NailPrice extends Model
{
    protected $table = 'nail_prices';

    protected $fillable = [
        'nail_id',
        'price',
        'price_min',
        'price_max',
        'price_type',
        'note',
        'is_default',
    ];

    protected $casts = [
        'nail_id' => 'integer',
        'price' => 'decimal:0',
        'price_min' => 'decimal:0',
        'price_max' => 'decimal:0',
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * Price thuộc về 1 Nail
     */
    public function nail(): BelongsTo
    {
        return $this->belongsTo(Nail::class);
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo NailPrice
     */
    public static function make(
        string $priceType = 'fixed',
        ?float $price = null,
        ?float $priceMin = null,
        ?float $priceMax = null,
        ?string $note = null,
        bool $isDefault = false
    ): static {
        return new static([
            'price_type' => $priceType,
            'price' => $price,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'note' => $note,
            'is_default' => $isDefault,
        ]);
    }

    // ===== Scopes =====

    /**
     * Lấy giá mặc định
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Sắp xếp theo price
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('price');
    }
}
