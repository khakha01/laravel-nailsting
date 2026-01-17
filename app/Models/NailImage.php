<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NailImage extends Model
{
    protected $table = 'nail_images';

    protected $fillable = [
        'nail_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'nail_id' => 'integer',
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relations =====

    /**
     * Image thuộc về 1 Nail
     */
    public function nail(): BelongsTo
    {
        return $this->belongsTo(Nail::class);
    }

    // ===== Factory Methods =====

    /**
     * Factory method để tạo NailImage
     */
    public static function make(
        string $imagePath,
        bool $isPrimary = false,
        int $sortOrder = 0
    ): static {
        return new static([
            'image_path' => $imagePath,
            'is_primary' => $isPrimary,
            'sort_order' => $sortOrder,
        ]);
    }

    // ===== Scopes =====

    /**
     * Sắp xếp theo sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}

