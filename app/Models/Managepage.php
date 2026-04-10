<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Managepage extends Model
{
    protected $fillable = [
        // Home One
        'top_category',
        'most_popular_title',
        'stay_connected_title',
        'follower_text_one',
        'follower_text_two',
        'follower_text_three',
        'follower_text_four',
        'dont_miss_title',

        // Home Two
        'breaking_news_title',
        'trending_news_title',
        'weekly_reviews',
        'editors_picks',
        'button_text',
        'feature_post',
        'feature_video_title',

        // Menu Title
        'menu_title_one',
        'menu_title_two',

        // All Pages
        'home_title',
        'popular_post_title',
        'gallery_title',
        'recent_post_title',
        'tag_title',

        // Contact Us
        'get_in_touch',
        'address',
        'phone_text',
        'email_text',
        'form_button_text',

        // Footer Section
        'post_title',
        'news',
        'about',
        'news_tags_title',
        'subscribe_text',
    ];

    /**
     * Always return the single settings row, create it if missing.
     */
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
