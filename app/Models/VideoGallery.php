<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $fillable = [
        'title',
        'video_type',   // 'upload' | 'youtube'
        'youtube_url',
        'video_path',
        'thumbnail',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Return the embeddable YouTube URL (used in <iframe>).
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if ($this->video_type !== 'youtube' || !$this->youtube_url) {
            return null;
        }

        // Support both full URL and short youtu.be links
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/',
            $this->youtube_url,
            $matches
        );

        return isset($matches[1])
            ? 'https://www.youtube.com/embed/' . $matches[1]
            : null;
    }

    /**
     * Return the YouTube thumbnail URL.
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        $embed = $this->youtube_embed_url;
        if (!$embed) return null;

        $id = basename($embed);
        return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
    }

    /**
     * Public-facing video URL (uploaded file).
     */
    public function getVideoUrlAttribute(): ?string
    {
        return $this->video_path
            ? asset($this->video_path)
            : null;
    }
}
