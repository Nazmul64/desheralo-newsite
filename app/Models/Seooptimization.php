<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seooptimization extends Model
{
    use HasFactory;

    // ── Table ─────────────────────────────────────────────────────────────────
    protected $table = 'seooptimizations';

    // ── Mass Assignable ───────────────────────────────────────────────────────
    protected $fillable = [
        'keywords',
        'author',
        'meta_title',
        'meta_description',
        'google_analytics',
    ];

    // ── Casts ─────────────────────────────────────────────────────────────────
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Return keywords as a clean array (split by comma).
     * Usage: $seo->keywords_array  → ['news', 'tech', 'updates']
     */
    public function getKeywordsArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            return [];
        }

        return array_values(
            array_filter(
                array_map('trim', explode(',', $this->keywords))
            )
        );
    }

    /**
     * Check whether a Google Analytics script has been set.
     * Usage: $seo->has_analytics  → true / false
     */
    public function getHasAnalyticsAttribute(): bool
    {
        return ! empty($this->google_analytics);
    }

    /**
     * Return a safe, truncated meta description for previews.
     * Usage: $seo->short_description  → 'Short description...'
     */
    public function getShortDescriptionAttribute(): string
    {
        if (empty($this->meta_description)) {
            return '';
        }

        return mb_strlen($this->meta_description) > 160
            ? mb_substr($this->meta_description, 0, 157) . '...'
            : $this->meta_description;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Only records that have a meta title set.
     * Usage: Seooptimization::withTitle()->get()
     */
    public function scopeWithTitle($query)
    {
        return $query->whereNotNull('meta_title')->where('meta_title', '!=', '');
    }

    /**
     * Only records that have Google Analytics configured.
     * Usage: Seooptimization::withAnalytics()->get()
     */
    public function scopeWithAnalytics($query)
    {
        return $query->whereNotNull('google_analytics')->where('google_analytics', '!=', '');
    }
}
