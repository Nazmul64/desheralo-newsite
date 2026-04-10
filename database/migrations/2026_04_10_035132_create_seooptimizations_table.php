<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seooptimizations', function (Blueprint $table) {
            $table->id();

            // ── SEO Meta Fields ───────────────────────────────────────────
            $table->text('keywords')->nullable()->comment('Comma-separated keywords for meta tag');
            $table->string('author', 255)->nullable()->comment('Meta author name');
            $table->string('meta_title', 255)->nullable()->comment('Page meta title (recommended 50–60 chars)');
            $table->text('meta_description')->nullable()->comment('Page meta description (recommended 150–160 chars)');

            // ── Tracking ──────────────────────────────────────────────────
            $table->longText('google_analytics')->nullable()->comment('Google Analytics / GA4 tracking script');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seooptimizations');
    }
};
