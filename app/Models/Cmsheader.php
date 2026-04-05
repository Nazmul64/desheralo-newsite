<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cmsheader extends Model
{
    protected $fillable = ['name', 'image', 'is_active', 'status'];
}
