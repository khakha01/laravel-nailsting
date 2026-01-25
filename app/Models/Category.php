<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'description',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lft' => 'integer',
        'rgt' => 'integer',
        'depth' => 'integer',
        'display_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * Category có thể có nhiều categories con
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Category con thuộc về 1 category cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Category có thể có nhiều products
     */
    public function products(): HasMany
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo Category
     */
    public static function make(
        string $name,
        string $slug,
        ?int $parentId = null,
        ?string $description = null,
        bool $isActive = true,
        int $displayOrder = 0
    ): static {
        return new static([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => $parentId,
            'description' => $description,
            'is_active' => $isActive,
            'display_order' => $displayOrder,
            'lft' => 0,
            'rgt' => 0,
            'depth' => 0,
        ]);
    }

    // ===== Scopes =====

    /**
     * Chỉ lấy categories đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Lấy categories gốc (không có parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
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
     * Kiểm tra có phải category gốc không
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Lấy toàn bộ children recursively
     */
    public function getAllChildren()
    {
        return $this->children()->with('children')->get()->flatMap(function ($category) {
            return array_merge([$category], $category->getAllChildren()->all());
        });
    }
}
