<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCategory extends Model
{
    protected $table = 'post_categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    /**
     * Category con thuộc về 1 category cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    /**
     * Category có thể có nhiều posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_category_id');
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
