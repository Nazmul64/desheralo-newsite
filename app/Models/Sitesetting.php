<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sitesetting extends Model
{
    protected $fillable = [
        'title',
        'name',
        'short_name',
        'footer_content',
        'play_store_url',
        'app_store_url',
        'favicon',
        'icon',
        'logo',
        'footer_logo',
    ];
}
