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
        --success-bg: #059669;
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
        color: var(--accent);
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
    .tc-btn-back:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: var(--accent-glow);
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
        background: var(--accent-glow);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tc-card-icon svg { width: 18px; height: 18px; color: var(--accent); }
    .tc-card-title {
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        margin: 0;
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
    .form-control-tc:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .form-control-tc.is-invalid { border-color: #e03e3e; }
    .invalid-msg { font-size: 12px; color: #e03e3e; margin-top: 4px; }

    /* ── Color Picker ── */
    .color-input-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }
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
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 4px 0;
    }
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
    .tc-toggle {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
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
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius-input);
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 14px rgba(91,79,207,0.3);
        letter-spacing: 0.02em;
    }
    .btn-save:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,79,207,0.38); }
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

    /* ── Preview Card ── */
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

    /* Preview Phone Mockup */
    .preview-phone {
        width: 200px;
        margin: 0 auto;
        background: var(--ink-soft);
        border-radius: 28px;
        padding: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }
    .preview-screen {
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
    }
    .preview-header-bar {
        height: 48px;
        display: flex;
        align-items: center;
        padding: 0 14px;
        gap: 8px;
        transition: background 0.3s;
    }
    .preview-logo-dot {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: rgba(255,255,255,0.3);
    }
    .preview-logo-text {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .preview-logo-line {
        height: 5px;
        border-radius: 3px;
        background: rgba(255,255,255,0.7);
    }
    .preview-logo-line:first-child { width: 36px; }
    .preview-logo-line:last-child { width: 22px; opacity: 0.5; }
    .preview-nav-dots {
        margin-left: auto;
        display: flex;
        gap: 4px;
    }
    .preview-nav-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
    }

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
    .preview-hero-label {
        font-size: 7px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
        margin-bottom: 4px;
    }
    .preview-hero-name {
        font-family: var(--font-display);
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 8px;
        transition: none;
    }
    .preview-hero-btn {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 7px;
        font-weight: 700;
        color: #fff;
        transition: background 0.3s;
    }

    .preview-cards-row { display: flex; gap: 6px; }
    .preview-mini-card {
        flex: 1;
        border-radius: 8px;
        padding: 8px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .preview-mini-dot {
        width: 18px;
        height: 18px;
        border-radius: 5px;
        transition: background 0.3s;
    }
    .preview-mini-line-a { height: 4px; border-radius: 2px; background: #e5e7eb; width: 70%; }
    .preview-mini-line-b { height: 3px; border-radius: 2px; background: #e5e7eb; width: 50%; }

    /* Swatches */
    .preview-swatches {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .ps-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    .ps-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        transition: background 0.3s;
    }
    .ps-label { font-size: 9px; font-weight: 600; color: var(--ink-muted); letter-spacing: 0.04em; }

    /* Theme Name Below */
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
</style>

<div class="tc-page">

    {{-- Header --}}
    <div class="tc-header">
        <div>
            <p class="tc-page-label">Appearance → Themes</p>
            <h1 class="tc-page-title">Add New Theme</h1>
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
                <div class="tc-card-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z"/>
                    </svg>
                </div>
                <h2 class="tc-card-title">Theme Details</h2>
            </div>
            <div class="tc-card-body">
                <form action="{{ route('themecolor.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">

                        {{-- Name --}}
                        <div class="field-group">
                            <label class="field-label">Theme Name <span class="req">*</span></label>
                            <input type="text" name="name" id="nameInput"
                                   value="{{ old('name') }}"
                                   class="form-control-tc {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="e.g. Ocean Blue">
                            @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
                        </div>

                        {{-- Description --}}
                        <div class="field-group">
                            <label class="field-label">Description</label>
                            <input type="text" name="description"
                                   value="{{ old('description') }}"
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
                            ['primary_color',    'Primary Color',    '#7C3AED', true,  'Main brand color used for headers & CTAs'],
                            ['secondary_color',  'Secondary Color',  '#8B5CF6', true,  'Supporting brand color'],
                            ['accent_color',     'Accent Color',     '#F59E0B', false, 'Highlight & interactive elements'],
                            ['background_color', 'Background Color', '#FFFFFF', true,  'Page & component backgrounds'],
                            ['text_color',       'Text Color',       '#111827', true,  'Body text & headings'],
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
                                       class="d-none color-picker" data-field="{{ $field }}">
                                <input type="text" id="hex_{{ $field }}"
                                       value="{{ old($field, $default) }}"
                                       class="form-control-tc hex-input {{ $errors->has($field) ? 'is-invalid' : '' }}"
                                       maxlength="7"
                                       placeholder="{{ $default }}"
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
                                               {{ old('status', '1') ? 'checked' : '' }}>
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
                                               {{ old('is_default') ? 'checked' : '' }}>
                                        <span class="tc-toggle-slider"></span>
                                    </label>
                                    <div>
                                        <div class="toggle-label">Set as Default</div>
                                        <div class="toggle-sublabel">Replaces current default</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="full">
                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4zm-5 16a3 3 0 110-6 3 3 0 010 6zm3-10H5V5h10v4z"/>
                                    </svg>
                                    Save Theme
                                </button>
                                <a href="{{ route('themecolor.index') }}" class="btn-cancel">Cancel</a>
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
                    <div class="tc-card-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h2 class="tc-card-title">Live Preview</h2>
                </div>
                <div class="preview-inner">
                    <p class="preview-title">Real-time UI Preview</p>

                    {{-- Phone --}}
                    <div class="preview-phone">
                        <div class="preview-screen">
                            {{-- Header Bar --}}
                            <div class="preview-header-bar" id="pv_header" style="background:#7C3AED">
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
                            {{-- Body --}}
                            <div class="preview-body-area">
                                {{-- Hero --}}
                                <div class="preview-hero" id="pv_hero" style="background:#8B5CF6">
                                    <div class="preview-hero-label">Welcome</div>
                                    <div class="preview-hero-name" id="pv_heroName">Theme Name</div>
                                    <div class="preview-hero-btn" id="pv_accentBtn" style="background:#F59E0B">
                                        Explore →
                                    </div>
                                </div>
                                {{-- Mini Cards --}}
                                <div class="preview-cards-row">
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot1" style="background:#7C3AED"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot2" style="background:#8B5CF6"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                    <div class="preview-mini-card">
                                        <div class="preview-mini-dot" id="pv_dot3" style="background:#F59E0B"></div>
                                        <div class="preview-mini-line-a"></div>
                                        <div class="preview-mini-line-b"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Swatches --}}
                    <div class="preview-swatches">
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_primary" style="background:#7C3AED"></div>
                            <span class="ps-label">Primary</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_secondary" style="background:#8B5CF6"></div>
                            <span class="ps-label">Secondary</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_accent" style="background:#F59E0B"></div>
                            <span class="ps-label">Accent</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_bg" style="background:#FFFFFF; box-shadow:0 0 0 1px #e5e7eb inset,0 2px 8px rgba(0,0,0,0.12)"></div>
                            <span class="ps-label">BG</span>
                        </div>
                        <div class="ps-item">
                            <div class="ps-dot" id="sw_text" style="background:#111827"></div>
                            <span class="ps-label">Text</span>
                        </div>
                    </div>

                    <div class="preview-theme-name" id="pv_name">Theme Name</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// ── Color Picker Sync ──
document.querySelectorAll('.color-picker').forEach(picker => {
    const field = picker.dataset.field;
    const hex   = document.getElementById(`hex_${field}`);
    const thumb = document.getElementById(`thumb_${field}`);

    picker.addEventListener('input', () => {
        hex.value = picker.value;
        thumb.style.background = picker.value;
        updatePreview();
    });

    hex.addEventListener('input', () => {
        const val = hex.value.trim();
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            picker.value = val;
            thumb.style.background = val;
            updatePreview();
        }
    });
});

// ── Name Sync ──
document.getElementById('nameInput').addEventListener('input', function () {
    const v = this.value || 'Theme Name';
    document.getElementById('pv_name').textContent = v;
    document.getElementById('pv_heroName').textContent = v;
});

// ── Preview Update ──
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
updatePreview();
</script>

@endsection
