<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Themecolor extends Model
{
    use HasFactory;

    protected $table = 'themecolors';

    protected $fillable = [
        'name',
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_color',
        'text_color',
        'description',
        'is_default',
        'status',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status'     => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // ── Helpers ─────────────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }
}
