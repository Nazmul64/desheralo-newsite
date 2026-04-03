<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sitesettings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('short_name');
            $table->text('footer_content')->nullable();
            $table->string('play_store_url')->nullable();
            $table->string('app_store_url')->nullable();
            // App Icon Tab
            $table->string('favicon')->nullable();         // stored in uploads/settings
            $table->string('icon')->nullable();            // stored in uploads/settings
            // App Logo Tab
            $table->string('logo')->nullable();            // stored in uploads/settings
            $table->string('footer_logo')->nullable();     // stored in uploads/settings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitesettings');
    }
};
