<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get full path from root to this folder
     * Example: "nails/hands/long" for nested folders
     */
    public function getFullPath(): string
    {
        $path = [];
        $current = $this;
        
        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }
        
        return implode('/', $path);
    }

    /**
     * Get all media in this folder and all subfolders recursively
     */
    public function getAllMedia(): \Illuminate\Support\Collection
    {
        $media = $this->media;
        
        foreach ($this->children as $child) {
            $media = $media->merge($child->getAllMedia());
        }
        
        return $media;
    }

    /**
     * Get all subfolders recursively
     */
    public function getAllSubfolders(): \Illuminate\Support\Collection
    {
        $folders = collect([$this]);
        
        foreach ($this->children as $child) {
            $folders = $folders->merge($child->getAllSubfolders());
        }
        
        return $folders;
    }
}

