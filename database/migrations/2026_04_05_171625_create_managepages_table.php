<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('managepages', function (Blueprint $table) {
            $table->id();

            // ── Home One ──────────────────────────────────────────────────
            $table->string('top_category')->default('Top Categories');
            $table->string('most_popular_title')->default('Most Popular');
            $table->string('stay_connected_title')->default('Stay Connected');
            $table->string('follower_text_one')->default('Facebook Follower');
            $table->string('follower_text_two')->default('Instagram Follower');
            $table->string('follower_text_three')->default('Twitter Follower');
            $table->string('follower_text_four')->default('Youtube Follower');
            $table->string('dont_miss_title')->default("Don't Miss");

            // ── Home Two ──────────────────────────────────────────────────
            $table->string('breaking_news_title')->default('Breaking News');
            $table->string('trending_news_title')->default('TRENDING NEWS');
            $table->string('weekly_reviews')->default('Weekly Review');
            $table->string('editors_picks')->default("Editor's Picks");
            $table->string('button_text')->default('Show All');
            $table->string('feature_post')->default('FEATURED POSTS');
            $table->string('feature_video_title')->default('FEATURED VIDEO');

            // ── Menu Title ────────────────────────────────────────────────
            $table->string('menu_title_one')->default('Home Menu One');
            $table->string('menu_title_two')->default('Home Menu Two');

            // ── All Pages ─────────────────────────────────────────────────
            $table->string('home_title')->default('Home');
            $table->string('popular_post_title')->default('Popular Post');
            $table->string('gallery_title')->default('Gallery');
            $table->string('recent_post_title')->default('Recent Post');
            $table->string('tag_title')->default('Tags');

            // ── Contact Us ────────────────────────────────────────────────
            $table->string('get_in_touch')->default('Get in touch');
            $table->string('address')->default('Address');
            $table->string('phone_text')->default('Phone');
            $table->string('email_text')->default('Email');
            $table->string('form_button_text')->default('Send Message');

            // ── Footer Section ────────────────────────────────────────────
            $table->string('post_title')->default('Most Viewed Post');
            $table->string('news')->default('News');
            $table->string('about')->default('About');
            $table->string('news_tags_title')->default("News Tag's");
            $table->string('subscribe_text')->default('Subscribe Now');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('managepages');
    }
};
