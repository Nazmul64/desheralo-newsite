<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themecolors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('primary_color', 7);
            $table->string('secondary_color', 7);
            $table->string('accent_color', 7)->nullable();
            $table->string('background_color', 7)->default('#FFFFFF');
            $table->string('text_color', 7)->default('#000000');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('status')->default(true); // 1=active, 0=inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themecolors');
    }
};
