<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsSubcategory extends Model
{
    protected $table = 'news_subcategories';

    protected $fillable = [
        'newscategory_id',
        'name',
        'slug',
        'image',
        'menu_publish',
    ];

    protected $casts = [
        'menu_publish' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Newscategory::class, 'newscategory_id');
    }
}
