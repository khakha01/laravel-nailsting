<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Nail extends Model implements HasMedia
{
use InteractsWithMedia;

    protected $table = 'nails';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Đăng ký Collection để quản lý ảnh Nail
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('nail_images')
             ->useDisk('public'); // Lưu vào storage/app/public
    }

    // ===== Relations =====

    /**
     * Nail có nhiều images
     */
    public function images(): HasMany
    {
        return $this->hasMany(NailImage::class);
    }

    /**
     * Nail có nhiều prices
     */
    public function prices(): HasMany
    {
        return $this->hasMany(NailPrice::class);
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo Nail
     */
    public static function make(
        string $name,
        string $slug,
        ?string $description = null,
        string $status = 'active'
    ): static {
        return new static([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
        ]);
    }

    // ===== Scopes =====

    /**
     * Chỉ lấy nails đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Sắp xếp theo name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    // ===== Methods =====

    /**
     * Kiểm tra có phải active không
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Lấy primary image
     */
    public function getPrimaryImage(): ?NailImage
    {
        return $this->images()->where('is_primary', true)->first();
    }

    /**
     * Lấy default price
     */
    public function getDefaultPrice(): ?NailPrice
    {
        return $this->prices()->where('is_default', true)->first();
    }
}

