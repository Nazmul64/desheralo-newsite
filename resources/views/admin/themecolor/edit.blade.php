@extends('admin.master')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --ink: #0a0a0f;
        --ink-soft: #1c1c2e;
        --ink-muted: #6b7280;
        --surface: #f8f7ff;
        --surface-card: #ffffff;
        --border: #e8e6f0;
        --accent: #5b4fcf;
        --accent-glow: rgba(91,79,207,0.10);
        --accent-hover: #4a3fbe;
        --warning-clr: #d97706;
        --warning-bg: rgba(217,119,6,0.08);
        --radius-card: 16px;
        --radius-input: 10px;
        --shadow-card: 0 4px 24px rgba(91,79,207,0.08), 0 1px 4px rgba(0,0,0,0.04);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --font-display: 'Syne', sans-serif;
        --font-body: 'DM Sans', sans-serif;
    }

    * { font-family: var(--font-body); box-sizing: border-box; }
    .tc-page { background: var(--surface); min-height: 100vh; padding: 2rem 2.5rem; }

    /* ── Header ── */
    .tc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 2px solid var(--border);
    }
    .tc-page-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--warning-clr);
        margin-bottom: 4px;
    }
    .tc-page-title {
        font-family: var(--font-display);
        font-size: 26px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.5px;
        margin: 0;
    }
    .tc-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: transparent;
        color: var(--ink-muted);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }
    .tc-btn-back:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }

    /* ── Edit badge ── */
    .editing-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: var(--warning-bg);
        border: 1px solid rgba(217,119,6,0.25);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: var(--warning-clr);
        margin-bottom: 8px;
    }
    .editing-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--warning-clr);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* ── Layout ── */
    .tc-layout { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }
    @media (max-width: 900px) { .tc-layout { grid-template-columns: 1fr; } }

    /* ── Card ── */
    .tc-card {
        background: var(--surface-card);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .tc-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tc-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tc-card-icon.edit-icon { background: var(--warning-bg); }
    .tc-card-icon.edit-icon svg { color: var(--warning-clr); }
    .tc-card-icon svg { width: 18px; height: 18px; }
    .tc-card-title {
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        margin: 0;
    }
    .tc-id-chip {
        margin-left: auto;
        font-size: 11px;
        font-weight: 700;
        color: var(--ink-muted);
        background: var(--surface);
        padding: 3px 10px;
        border-radius: 20px;
        border: 1px solid var(--border);
        letter-spacing: 0.04em;
    }
    .tc-card-body { padding: 24px; }

    /* ── Form Grid ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-grid .full { grid-column: 1 / -1; }
    @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }

    /* ── Form Elements ── */
    .field-group { display: flex; flex-direction: column; gap: 6px; }
    .field-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--ink-soft);
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .field-label .req { color: #e03e3e; margin-left: 2px; }

    .form-control-tc {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-input);
        font-size: 14px;
        color: var(--ink);
        background: #fff;
        transition: var(--transition);
        outline: none;
    }
    .form-control-tc:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
    .form-control-tc.is-invalid { border-color: #e03e3e; }
    .invalid-msg { font-size: 12px; color: #e03e3e; margin-top: 4px; }

    /* ── Color Picker ── */
    .color-input-wrap { display: flex; align-items: center; gap: 10px; }
    .color-thumb-btn {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        border: 2px solid rgba(255,255,255,0.8);
        box-shadow: 0 2px 8px rgba(0,0,0,0.14), 0 0 0 1px rgba(0,0,0,0.08);
        cursor: pointer;
        flex-shrink: 0;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .color-thumb-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 60%);
    }
    .color-thumb-btn:hover { transform: scale(1.08); box-shadow: 0 4px 16px rgba(0,0,0,0.2); }

    /* ── Section Divider ── */
    .section-divider { display: flex; align-items: center; gap: 12px; margin: 4px 0; }
    .section-divider-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--ink-muted);
        white-space: nowrap;
    }
    .section-divider-line { flex: 1; height: 1px; background: var(--border); }

    /* ── Toggles Row ── */
    .toggles-row { display: flex; gap: 28px; flex-wrap: wrap; padding-top: 4px; }
    .toggle-item { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .tc-toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
    .tc-toggle input { opacity: 0; width: 0; height: 0; }
    .tc-toggle-slider {
        position: absolute;
        inset: 0;
        background: #d1d5db;
        border-radius: 12px;
        cursor: pointer;
        transition: .25s;
    }
    .tc-toggle-slider::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        left: 3px;
        top: 3px;
        background: white;
        border-radius: 50%;
        transition: .25s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .tc-toggle input:checked + .tc-toggle-slider { background: var(--accent); }
    .tc-toggle input:checked + .tc-toggle-slider::before { transform: translateX(20px); }
    .toggle-label { font-size: 14px; font-weight: 600; color: var(--ink-soft); }
    .toggle-sublabel { font-size: 11px; color: var(--ink-muted); margin-top: 1px; }

    /* ── Submit Row ── */
    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .btn-update {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        background: var(--warning-clr);
        color: #fff;
        border: none;
        border-radius: var(--radius-input);
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(217,119,6,0.3);
        letter-spacing: 0.02em;
    }
    .btn-update:hover { background: #b45309; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(217,119,6,0.4); }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: transparent;
        color: var(--ink-muted);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-input);
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }
    .btn-cancel:hover { border-color: #9ca3af; color: var(--ink); }

    /* ── Preview ── */
    .preview-sticky { position: sticky; top: 24px; }
    .preview-inner { padding: 24px; }
    .preview-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 20px;
        text-align: center;
    }

    .preview-phone {
        width: 200px;
        margin: 0 auto;
        background: var(--ink-soft);
        border-radius: 28px;
        padding: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }
    .preview-screen { border-radius: 18px; overflow: hidden; background: #fff; }
    .preview-header-bar {
        height: 48px;
        display: flex;
        align-items: center;
        padding: 0 14px;
        gap: 8px;
        transition: background 0.3s;
    }
    .preview-logo-dot { width: 22px; height: 22px; border-radius: 6px; background: rgba(255,255,255,0.3); }
    .preview-logo-text { display: flex; flex-direction: column; gap: 3px; }
    .preview-logo-line { height: 5px; border-radius: 3px; background: rgba(255,255,255,0.7); }
    .preview-logo-line:first-child { width: 36px; }
    .preview-logo-line:last-child { width: 22px; opacity: 0.5; }
    .preview-nav-dots { margin-left: auto; display: flex; gap: 4px; }
    .preview-nav-dot { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5); }

    .preview-body-area { background: #f5f5f5; padding: 10px; display: flex; flex-direction: column; gap: 8px; }
    .preview-hero {
        border-radius: 12px;
        padding: 16px;
        transition: background 0.3s;
        position: relative;
        overflow: hidden;
    }
    .preview-hero::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }
    .preview-hero-label { font-size: 7px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.7); margin-bottom: 4px; }
    .preview-hero-name { font-family: var(--font-display); font-size: 13px; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .preview-hero-btn { display: inline-block; padding: 4px 10px; border-radius: 5px; font-size: 7px; font-weight: 700; color: #fff; transition: background 0.3s; }

    .preview-cards-row { display: flex; gap: 6px; }
    .preview-mini-card { flex: 1; border-radius: 8px; padding: 8px; background: #fff; display: flex; flex-direction: column; gap: 4px; }
    .preview-mini-dot { width: 18px; height: 18px; border-radius: 5px; transition: background 0.3s; }
    .preview-mini-line-a { height: 4px; border-radius: 2px; background: #e5e7eb; width: 70%; }
    .preview-mini-line-b { height: 3px; border-radius: 2px; background: #e5e7eb; width: 50%; }

    .preview-swatches { display: flex; gap: 8px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
    .ps-item { display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .ps-dot { width: 30px; height: 30px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.12); transition: background 0.3s; }
    .ps-label { font-size: 9px; font-weight: 600; color: var(--ink-muted); letter-spacing: 0.04em; }
    .preview-theme-name {
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 800;
        color: var(--ink);
        text-align: center;
        margin-top: 16px;
        min-height: 22px;
        letter-spacing: -0.2px;
    }

    /* ── Change indicator ── */
    .changed-indicator {
        display: none;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: rgba(251,191,36,0.1);
        border: 1px solid rgba(251,191,36,0.3);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--warning-clr);
        margin-top: 12px;
    }
    .changed-indicator.show { display: flex; }
</style>

<div class="tc-page">

    {{-- Header --}}
    <div class="tc-header">
        <div>
            <div class="editing-badge">Editing Mode</div>
            <p class="tc-page-label">Appearance → Themes</p>
            <h1 class="tc-page-title">Edit Theme</h1>
        </div>
        <a href="{{ route('themecolor.index') }}" class="tc-btn-back">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>

    <div class="tc-layout">

        {{-- ── Left: Form ── --}}
        <div class="tc-card">
            <div class="tc-card-header">
                <div class="tc-card-icon edit-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h2 class="tc-card-title">Update Theme Details</h2>
                <span class="tc-id-chip">ID #{{ $themecolor->id }}</span>
            </div>
            <div class="tc-card-body">
                <form action="{{ route('themecolor.update', $themecolor->id) }}" method="POST" id="editForm">
                    @csrf @method('PUT')
                    <div class="form-grid">

                        {{-- Name --}}
                        <div class="field-group">
                            <label class="field-label">Theme Name <span class="req">*</span></label>
                            <input type="text" name="name" id="nameInput"
                                   value="{{ old('name', $themecolor->name) }}"
                                   class="form-control-tc {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="e.g. Ocean Blue">
                            @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
                        </div>

                        {{-- Description --}}
                        <div class="field-group">
                            <label class="field-label">Description</label>
                            <input type="text" name="description"
                                   value="{{ old('description', $themecolor->description) }}"
                                   class="form-control-tc"
                                   placeholder="Optional short description">
                        </div>

                        {{-- Divider --}}
                        <div class="full">
                            <div class="section-divider">
                                <span class="section-divider-label">Color Palette</span>
                                <span class="section-divider-line"></span>
                            </div>
                        </div>

                        {{-- Color Fields --}}
                        @php
                        $colorFields = [
                            ['primary_color',    'Primary Color',    $themecolor->primary_color,           true,  'Main brand color'],
                            ['secondary_color',  'Secondary Color',  $themecolor->secondary_color,         true,  'Supporting brand color'],
                            ['accent_color',     'Accent Color',     $themecolor->accent_color ?? '#F59E0B', false, 'Highlight elements'],
                            ['background_color', 'Background Color', $themecolor->background_color,        true,  'Page backgrounds'],
                            ['text_color',       'Text Color',       $themecolor->text_color,              true,  'Body text & headings'],
                        ];
                        @endphp

                        @foreach($colorFields as [$field, $label, $default, $required, $hint])
                        <div class="field-group">
                            <label class="field-label">{{ $label }} @if($required)<span class="req">*</span>@endif</label>
                            <div class="color-input-wrap">
                                <div class="color-thumb-btn" id="thumb_{{ $field }}"
                                     style="background:{{ old($field, $default) }}"
                                     onclick="document.getElementById('pick_{{ $field }}').click()"
                                     title="{{ $hint }}">
                                </div>
                                <input type="color" id="pick_{{ $field }}" name="{{ $field }}"
                                       value="{{ old($field, $default) }}"
                                       class="d-none color-picker" data-field="{{ $field }}"
                                       data-original="{{ old($field, $default) }}">
                                <input type="text" id="hex_{{ $field }}"
                                       value="{{ old($field, $default) }}"
                                       class="form-control-tc hex-input {{ $errors->has($field) ? 'is-invalid' : '' }}"
                                       maxlength="7"
                                       data-field="{{ $field }}">
                            </div>
                            @error($field)<p class="invalid-msg">{{ $message }}</p>@enderror
                        </div>
                        @endforeach

                        {{-- Divider --}}
                        <div class="full">
                            <div class="section-divider">
                                <span class="section-divider-label">Settings</span>
                                <span class="section-divider-line"></span>
                            </div>
                        </div>

                        {{-- Toggles --}}
                        <div class="full">
                            <div class="toggles-row">
                                <label class="toggle-item">
                                    <label class="tc-toggle">
                                        <input type="checkbox" name="status" id="statusToggle"
                                               {{ old('status', $themecolor->status) ? 'checked' : '' }}>
                                        <span class="tc-toggle-slider"></span>
                                    </label>
                                    <div>
                                        <div class="toggle-label">Active</div>
                                        <div class="toggle-sublabel">Visible to users</div>
                                    </div>
                                </label>
                                <label class="toggle-item">
                                    <label class="tc-toggle">
                                        <input type="checkbox" name="is_default" id="defaultToggle"
                                               {{ old('is_default', $themecolor->is_default) ? 'checked' : '' }}>
                                        <span class="tc-toggle-slider"></span>
                                    </label>
                                    <div>
                                        <div class="toggle-label">Set as Default</div>
                                        <div class="toggle-sublabel">Replaces current default</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Change indicator --}}
                        <div class="full">
                            <div class="changed-indicator" id="changeIndicator">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                You have unsaved changes
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="full">
                            <div class="form-actions">
                                <button type="submit" class="btn-update">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Update Theme
                                </button>
                                <a href="{{ route('themecolor.index') }}" class="btn-cancel">Discard Changes</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- ── Right: Live Preview ── --}}
        <div class="preview-sticky">
            <div class="tc-card">
                <div class="tc-card-header">
                    <div class="tc-card-icon" style="background:var(--accent-glow)">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:var(--accent)">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h2 class="tc-card-title">Live Preview</h2>
                </div>
                <div class="preview-inner">
                    <p class="preview-title">Real-time UI Preview</p>

                    <div class="preview-phone">
                        <div class="preview-screen">
                            <div class="preview-header-bar" id="pv_header" style="background:{{ $themecolor->primary_color }}">
                                <div class="preview-logo-dot"></div>
                                <div class="preview-logo-text">
                                    <div class="preview-logo-line"></div>
                                    <div class="preview-logo-line"></div>
                                </div>
                                <div class="preview-nav-dots">
                                    <div class="preview-nav-dot"></div>
                                    <div class="preview-nav-dot"></div>
                                    <div class="preview-nav-dot"></div>
                                </div>
                            </div>
                            <div class="preview-body-area">
                                <div class="preview-hero" id="pv_hero" style="background:{{ $themecolor->secondary_color }}">
                                    <div class="preview-hero-label">Welcome</div>
                                    <div class="preview-hero-name" id="pv_heroName">{{ old('name', $themecolor->name) }}</div>
                                    <div class="preview-hero-btn" id="pv_accentBtn" style="background:{{ $themecolor->accent_color ?? '#F59E0B' }}">
                                        Explore →
                                    </div>
                                </div>
                                <div class="preview-cards-row">
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot1" style="background:{{ $themecolor->primary_color }}"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot2" style="background:{{ $themecolor->secondary_color }}"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot3" style="background:{{ $themecolor->accent_color ?? '#F59E0B' }}"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="preview-swatches">
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_primary" style="background:{{ $themecolor->primary_color }}"></div>
                            <span class="ps-label">Primary</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_secondary" style="background:{{ $themecolor->secondary_color }}"></div>
                            <span class="ps-label">Secondary</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_accent" style="background:{{ $themecolor->accent_color ?? '#F59E0B' }}"></div>
                            <span class="ps-label">Accent</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_bg" style="background:{{ $themecolor->background_color }};box-shadow:0 0 0 1px #e5e7eb inset,0 2px 8px rgba(0,0,0,0.12)"></div>
                            <span class="ps-label">BG</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_text" style="background:{{ $themecolor->text_color }}"></div>
                            <span class="ps-label">Text</span>
                        </div>
                    </div>

                    <div class="preview-theme-name" id="pv_name">{{ old('name', $themecolor->name) }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
let hasChanged = false;

// ── Color Picker Sync ──
document.querySelectorAll('.color-picker').forEach(picker => {
    const field    = picker.dataset.field;
    const hex      = document.getElementById(`hex_${field}`);
    const thumb    = document.getElementById(`thumb_${field}`);

    picker.addEventListener('input', () => {
        hex.value = picker.value;
        thumb.style.background = picker.value;
        updatePreview();
        markChanged();
    });

    hex.addEventListener('input', () => {
        const val = hex.value.trim();
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            picker.value = val;
            thumb.style.background = val;
            updatePreview();
            markChanged();
        }
    });
});

// ── Name Sync ──
document.getElementById('nameInput').addEventListener('input', function () {
    const v = this.value || 'Theme Name';
    document.getElementById('pv_name').textContent = v;
    document.getElementById('pv_heroName').textContent = v;
    markChanged();
});

// ── Preview ──
function get(f) { return document.getElementById(`pick_${f}`).value; }
function updatePreview() {
    const p = get('primary_color');
    const s = get('secondary_color');
    const a = get('accent_color');
    const b = get('background_color');
    const t = get('text_color');

    document.getElementById('pv_header').style.background    = p;
    document.getElementById('pv_hero').style.background      = s;
    document.getElementById('pv_accentBtn').style.background = a;
    document.getElementById('pv_dot1').style.background      = p;
    document.getElementById('pv_dot2').style.background      = s;
    document.getElementById('pv_dot3').style.background      = a;
    document.getElementById('sw_primary').style.background   = p;
    document.getElementById('sw_secondary').style.background = s;
    document.getElementById('sw_accent').style.background    = a;
    document.getElementById('sw_bg').style.background        = b;
    document.getElementById('sw_text').style.background      = t;
}

// ── Change indicator ──
function markChanged() {
    if (!hasChanged) {
        hasChanged = true;
        document.getElementById('changeIndicator').classList.add('show');
    }
}

// ── Discard warning ──
window.addEventListener('beforeunload', function (e) {
    if (hasChanged && !document.getElementById('editForm').submitted) {
        e.preventDefault();
        e.returnValue = '';
    }
});
document.getElementById('editForm').addEventListener('submit', function () {
    this.submitted = true;
});
</script>

@endsection
