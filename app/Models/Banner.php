<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'title',
        'description_1',
        'description_2',
        'description_3',
        'button_text',
        'button_link',
        'is_active',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function items()
    {
        return $this->hasMany(BannerItem::class)->orderBy('order');
    }
}
