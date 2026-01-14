<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    protected $table = 'product_prices';

    protected $fillable = [
        'product_id',
        'price',
        'price_min',
        'price_max',
        'price_type',
        'note',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'price_min' => 'decimal:0',
        'price_max' => 'decimal:0',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * ProductPrice thuộc về 1 Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo ProductPrice
     */
    public static function make(
        int $productId,
        string $priceType = 'fixed',
        ?float $price = null,
        ?float $priceMin = null,
        ?float $priceMax = null,
        ?string $note = null
    ): static {
        return new static([
            'product_id' => $productId,
            'price_type' => $priceType,
            'price' => $price,
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'note' => $note,
        ]);
    }

    // ===== Methods =====

    /**
     * Lấy giá hiển thị (fixed, min-max, hoặc null)
     */
    public function getDisplayPrice(): string
    {
        if ($this->price_type === 'fixed' && $this->price) {
            return number_format($this->price, 0, ',', '.') . ' VNĐ';
        }

        if ($this->price_type === 'range' && $this->price_min && $this->price_max) {
            $min = number_format($this->price_min, 0, ',', '.');
            $max = number_format($this->price_max, 0, ',', '.');
            return "{$min} - {$max} VNĐ";
        }

        return 'Liên hệ';
    }

}
