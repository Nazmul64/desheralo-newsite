<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
   protected $fillable = ['name'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
