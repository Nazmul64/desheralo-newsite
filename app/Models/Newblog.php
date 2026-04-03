<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newblog extends Model
{
    protected $table = 'newblogs'; // explicitly set

    protected $fillable = [
        'newsblogcategory_id',
        'newssubblogcategory_id',
        'speciality_id',
        'title',
        'summary',
        'description',
        'tags',
        'date',
        'image',
        'status',
        'breaking_news',
        'news_reporter',
        'meta_keyword',
        'meta_description',
    ];

    protected $casts = [
        'date'          => 'date',
        'status'        => 'boolean',
        'breaking_news' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Newsblogcategory::class, 'newsblogcategory_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Newssubblogcategory::class, 'newssubblogcategory_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
