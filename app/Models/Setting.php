<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone1',
        'phone2',
        'phone3',
        'phone_zalo',
        'link_tiktok',
        'link_fb',
        'link_zalo',
        'logo_id',
        'favicon_id',
        'website_name',
        'address',
        'map_iframe',
    ];
}
