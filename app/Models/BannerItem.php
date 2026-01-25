<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_id',
        'media_id',
        'title',
        'description_1',
        'description_2',
        'description_3',
        'button_text',
        'button_link',
        'order',
        'is_active',
    ];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
