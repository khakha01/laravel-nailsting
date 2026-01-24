<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'file_path',
        'folder_id',
        'mime_type',
        'size',
    ];

    protected $appends = ['url'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Media can be used by many nails through nail_images pivot table
     */
    public function nails()
    {
        return $this->hasMany(NailImage::class);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('minio')->url($this->file_path);
    }
}
