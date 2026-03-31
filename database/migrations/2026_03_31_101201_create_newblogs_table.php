<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newblogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsblogcategory_id')
                  ->nullable()
                  ->constrained('newsblogcategories')
                  ->onDelete('set null');
            $table->foreignId('newssubblogcategory_id')
                  ->nullable()
                  ->constrained('newssubblogcategories')
                  ->onDelete('set null');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('tags')->nullable();
            $table->date('date')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1); // 1=Published, 0=Unpublished
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newblogs');
    }
};
