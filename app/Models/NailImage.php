<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NailImage extends Model
{
    protected $table = 'nail_images';

    protected $fillable = [
        'nail_id',
        'media_id',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'nail_id' => 'integer',
        'media_id' => 'integer',
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

    /**
     * Image linked to Media
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
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

