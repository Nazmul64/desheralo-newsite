<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admanager extends Model
{
    protected $table = 'admanagers';

    protected $fillable = [
        'header_ads',
        'header_ads_type',
        'sidebar_ads',
        'sidebar_ads_type',
        'before_post_ads',
        'before_post_ads_type',
        'after_post_ads',
        'after_post_ads_type',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function isImage(string $field): bool
    {
        return $this->{$field . '_type'} === 'image';
    }

    public function imageUrl(string $field): ?string
    {
        $path = $this->{$field};
        if (! $path) {
            return null;
        }
        return asset('uploads/ads/' . basename($path));
    }
}
