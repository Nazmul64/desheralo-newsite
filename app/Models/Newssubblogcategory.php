<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newssubblogcategory extends Model
{
    protected $fillable = [
        'newsblogcategory_id',
        'name',
        'status',
        'sort_order',
    ];

    protected $casts = ['status' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Newsblogcategory::class, 'newsblogcategory_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
