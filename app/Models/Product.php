<?php

namespace App\Models;

use App\Enums\ProductUnitEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'slug',
        'description',
        'unit',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'unit' => ProductUnitEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * Product thuộc về 1 Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product có nhiều ProductPrice
     */
    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }



    // ===== Factory Methods =====

    /**
     * Factory method để tạo Product
     */
    public static function make(
        int $categoryId,
        string $name,
        ?string $code = null,
        string $slug,
        ?string $description = null,
        ProductUnitEnum $unit = ProductUnitEnum::LAN,
        bool $isActive = true,
        int $displayOrder = 0
    ): static {
        // Generate slug tự động: #tensanpham-randomnumber
        $code = '#' . Str::slug($name, '-') . '-' . rand(100000, 999999);

        return new static([
            'category_id' => $categoryId,
            'name' => $name,
            'code' => $code,
            'slug' => $slug,
            'description' => $description,
            'unit' => $unit,
            'is_active' => $isActive,
            'display_order' => $displayOrder,
        ]);
    }

    // ===== Scopes =====

    /**
     * Chỉ lấy products đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Lấy products theo danh mục
     */
    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Sắp xếp theo display_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    // ===== Methods =====

    /**
     * Format giá để hiển thị
     */
    public function getFormattedPrice(): string
    {
        $priceObj = $this->prices->first();

        if (!$priceObj) {
            return 'Liên hệ';
        }

        switch ($priceObj->price_type) {
            case 'range':
                $min = number_format($priceObj->price_min ?? 0, 0, ',', '.');
                $max = number_format($priceObj->price_max ?? 0, 0, ',', '.');
                return "{$min} - {$max} VNĐ";

            case 'per_nail':
                return number_format($priceObj->price ?? 0, 0, ',', '.') . ' VNĐ / ngón';

            case 'fixed':
            default:
                return number_format($priceObj->price ?? 0, 0, ',', '.') . ' VNĐ';
        }
    }
}
