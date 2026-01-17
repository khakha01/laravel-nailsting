<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NailCategory extends Model
{
    protected $table = 'nail_categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * Category có thể có nhiều categories con
     */
    public function children(): HasMany
    {
        return $this->hasMany(NailCategory::class, 'parent_id');
    }

    /**
     * Category con thuộc về 1 category cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NailCategory::class, 'parent_id');
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo NailCategory
     */
    public static function make(
        string $name,
        string $slug,
        ?int $parentId = null
    ): static {
        return new static([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => $parentId,
        ]);
    }

    // ===== Scopes =====

    /**
     * Lấy categories gốc (không có parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
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
     * Kiểm tra có phải category gốc không
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }
}

