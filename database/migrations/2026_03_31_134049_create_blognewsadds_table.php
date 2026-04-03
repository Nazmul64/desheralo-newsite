<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blognewsadds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('newsblogcategory_id')
                  ->nullable()
                  ->constrained('newsblogcategories')
                  ->nullOnDelete();

            $table->foreignId('newssubblogcategory_id')
                  ->nullable()
                  ->constrained('newssubblogcategories')
                  ->nullOnDelete();

            $table->foreignId('speciality_id')
                  ->nullable()
                  ->constrained('specialities')
                  ->nullOnDelete();

            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('tags', 500)->nullable();
            $table->date('date')->nullable();
            $table->string('image')->nullable();

            $table->boolean('status')->default(1);
            $table->boolean('breaking_news')->default(0);
            $table->string('news_reporter')->nullable();

            $table->json('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blognewsadds');
    }
};
