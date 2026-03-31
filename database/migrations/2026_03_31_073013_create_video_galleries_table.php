<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('video_type', ['upload', 'youtube'])->default('youtube');
            $table->string('youtube_url')->nullable();       // YouTube link
            $table->string('video_path')->nullable();        // uploads/videogallery/filename.mp4
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('status')->default(1);       // 1=published, 0=unpublished
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_galleries');
    }
};
