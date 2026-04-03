<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blognewsadd extends Model
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
        'breaking_news',
        'speciality_id',
        'news_reporter',
        'meta_keywords',       // JSON array: ["keyword1","keyword2"]
        'meta_description',
    ];

    protected $casts = [
        'date'          => 'date',
        'status'        => 'boolean',
        'breaking_news' => 'boolean',
        'meta_keywords' => 'array',   // Laravel auto JSON encode/decode
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

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

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * meta_keywords array কে comma-separated string হিসেবে দেয়
     * HTML meta tag এ ব্যবহারের জন্য
     */
    public function getMetaKeywordsStringAttribute(): string
    {
        return implode(', ', $this->meta_keywords ?? []);
    }
}
