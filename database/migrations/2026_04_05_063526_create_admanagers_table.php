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
        Schema::create('admanagers', function (Blueprint $table) {
            $table->id();
            $table->text('header_ads')->nullable();
            $table->string('header_ads_type')->default('code');
            $table->text('sidebar_ads')->nullable();
            $table->string('sidebar_ads_type')->default('code');
            $table->text('before_post_ads')->nullable();
            $table->string('before_post_ads_type')->default('code');
            $table->text('after_post_ads')->nullable();
            $table->string('after_post_ads_type')->default('code');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admanagers');
    }
};
