<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderCode extends Model
{
    protected $table = 'header_codes';

    protected $fillable = [
        'google_analytics',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
