<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsblogcategory extends Model
{
    protected $fillable = ['name', 'status', 'sort_order'];

    protected $casts = ['status' => 'boolean'];

    public function subcategories()
    {
        return $this->hasMany(Newssubblogcategory::class, 'newsblogcategory_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
