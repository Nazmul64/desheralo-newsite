<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newscategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'menu_publish',
    ];

    protected $casts = [
        'menu_publish' => 'boolean',
    ];
}
