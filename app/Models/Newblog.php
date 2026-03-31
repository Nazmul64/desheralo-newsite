<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newblog extends Model
{
    protected $fillable = [
        'newsblogcategory_id',
        'newssubblogcategory_id',
        'title',
        'summary',
        'description',
        'tags',
        'date',
        'image',
        'status',
    ];

    protected $casts = [
        'date'   => 'date',
        'status' => 'boolean',
    ];

    // ─── Relations ────────────────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Newsblogcategory::class, 'newsblogcategory_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Newssubblogcategory::class, 'newssubblogcategory_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
