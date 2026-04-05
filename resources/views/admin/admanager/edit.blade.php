@extends('admin.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
:root {
    --primary:      #4f46e5;
    --primary-soft: #eef2ff;
    --primary-mid:  #c7d2fe;
    --danger:       #ef4444;
    --danger-soft:  #fff1f1;
    --success:      #10b981;
    --success-soft: #ecfdf5;
    --warn:         #f59e0b;
    --warn-soft:    #fffbeb;
    --bg:           #f4f6fb;
    --surface:      #ffffff;
    --border:       #e8eaf0;
    --border-dark:  #d1d5db;
    --text-primary:   #111827;
    --text-secondary: #6b7280;
    --text-muted:     #9ca3af;
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --radius-xl: 18px;
    --shadow-xs: 0 1px 2px rgba(0,0,0,.05);
    --shadow-sm: 0 2px 8px rgba(0,0,0,.07);
    --shadow-md: 0 4px 20px rgba(0,0,0,.09);
    --shadow-lg: 0 8px 32px rgba(0,0,0,.12);
    --font: 'Plus Jakarta Sans', system-ui, sans-serif;
}

.adm-wrap { font-family: var(--font); background: var(--bg); min-height: 100vh; padding: 28px 24px 48px; }

/* TAB BAR */
.tab-bar {
    display: flex; align-items: center; gap: 2px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius-lg); padding: 5px;
    width: fit-content; margin-bottom: 22px;
    box-shadow: var(--shadow-xs);
}
.tab-bar a {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 18px; border-radius: var(--radius-md);
    font-size: 13px; font-weight: 600; color: var(--text-secondary);
    text-decoration: none; transition: all .18s; white-space: nowrap;
}
.tab-bar a:hover { color: var(--text-primary); background: var(--bg); }
.tab-bar a.active { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(79,70,229,.35); }

/* BREADCRUMB */
.adm-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; margin-bottom: 20px; color: var(--text-muted);
}
.adm-breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 600; }
.adm-breadcrumb a:hover { text-decoration: underline; }
.adm-breadcrumb .sep { color: var(--text-muted); }
.adm-breadcrumb .current { color: var(--text-secondary); font-weight: 600; }

/* EDIT BADGE */
.edit-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--warn-soft); color: var(--warn);
    border: 1px solid #fde68a; border-radius: 20px;
    font-size: 11px; font-weight: 700; padding: 3px 10px;
    margin-left: 8px;
}

/* LAYOUT */
.create-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
}
@media(max-width:900px){ .create-layout{ grid-template-columns:1fr; } }

/* MAIN FORM CARD */
.form-main-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.form-main-head {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #fffbeb 0%, #fafbff 100%);
    display: flex; align-items: center; gap: 14px;
}
.form-main-icon {
    width: 42px; height: 42px;
    background: var(--warn-soft); border: 1px solid #fde68a;
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.form-main-title { font-size: 16px; font-weight: 800; color: var(--text-primary); }
.form-main-sub   { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.form-main-body  { padding: 20px 24px 24px; }

/* SLOT CARD */
.slot-card {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 14px;
    transition: box-shadow .15s;
}
.slot-card:last-of-type { margin-bottom: 0; }
.slot-card:hover { box-shadow: var(--shadow-sm); }
.slot-card-head {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    cursor: pointer; user-select: none;
}
.slot-card-head:hover { background: #fefdf5; }
.slot-icon {
    width: 34px; height: 34px; flex-shrink: 0;
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
}
.slot-card-title { font-size: 13px; font-weight: 700; color: var(--text-primary); }
.slot-card-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
.slot-chevron {
    margin-left: auto; color: var(--text-muted); font-size: 13px;
    transition: transform .2s;
}
.slot-card.collapsed .slot-chevron { transform: rotate(-90deg); }
.slot-card.collapsed .slot-body { display: none; }

/* has-content indicator */
.slot-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--border-dark); flex-shrink: 0;
    transition: background .2s;
}
.slot-dot.filled { background: var(--success); }

.slot-body { padding: 16px 18px; }
.slot-radios {
    display: flex; gap: 0; margin-bottom: 14px;
    background: var(--bg); border: 1px solid var(--border-dark);
    border-radius: var(--radius-md); padding: 3px;
}
.slot-radio-opt {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 7px 10px; border-radius: var(--radius-sm);
    cursor: pointer; font-size: 12px; font-weight: 600;
    color: var(--text-secondary); transition: all .15s;
}
.slot-radio-opt input[type=radio] { display: none; }
.slot-radio-opt.selected {
    background: var(--surface); color: var(--primary);
    box-shadow: var(--shadow-xs); border: 1px solid var(--primary-mid);
}
.slot-radio-opt i { font-size: 13px; }

.slot-textarea {
    width: 100%; padding: 10px 12px;
    border: 1px solid var(--border-dark); border-radius: var(--radius-md);
    font-size: 12px; font-family: 'Courier New', monospace;
    color: var(--text-primary); resize: vertical; min-height: 80px;
    background: var(--surface); outline: none;
    transition: border-color .15s, box-shadow .15s; line-height: 1.6;
}
.slot-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.slot-textarea.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

.slot-file-wrap {
    border: 2px dashed var(--border-dark); border-radius: var(--radius-md);
    padding: 14px 16px; text-align: center;
    cursor: pointer; transition: all .18s; background: var(--surface);
    position: relative;
}
.slot-file-wrap:hover { border-color: var(--primary); background: var(--primary-soft); }
.slot-file-wrap input[type=file] {
    position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0;
}
.slot-file-icon  { font-size: 24px; margin-bottom: 4px; }
.slot-file-text  { font-size: 12px; font-weight: 600; color: var(--text-secondary); }
.slot-file-sub   { font-size: 10px; color: var(--text-muted); margin-top: 2px; }

/* current image box */
.current-img-box {
    display: flex; align-items: center; gap: 10px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius-md); padding: 10px 12px;
    margin-bottom: 10px;
}
.current-img-box img {
    width: 80px; height: 44px; object-fit: cover;
    border-radius: var(--radius-sm); border: 1px solid var(--border);
    flex-shrink: 0;
}
.current-img-info { flex: 1; min-width: 0; }
.current-img-label {
    font-size: 11px; font-weight: 700; color: var(--success);
    display: flex; align-items: center; gap: 4px; margin-bottom: 2px;
}
.current-img-note { font-size: 10px; color: var(--text-muted); }
.btn-remove-img {
    width: 26px; height: 26px; flex-shrink: 0;
    background: var(--danger-soft); color: var(--danger);
    border: 1px solid #fecaca; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: all .15s;
}
.btn-remove-img:hover { background: var(--danger); color: #fff; }

/* new preview */
.new-preview-box {
    display: none; margin-top: 10px;
    position: relative; display: none;
}
.new-preview-box img {
    max-height: 80px; border-radius: var(--radius-md);
    border: 1px solid var(--border); box-shadow: var(--shadow-xs); display: block;
}
.btn-clear-preview {
    position: absolute; top: -7px; right: -7px;
    width: 20px; height: 20px;
    background: var(--danger); color: #fff;
    border: none; border-radius: 50%;
    font-size: 11px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}

.field-hint {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; color: var(--text-muted); margin-top: 6px;
}
.field-error {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; color: var(--danger); font-weight: 600; margin-top: 6px;
}
.field-error i { font-size: 11px; }

/* SIDEBAR */
.side-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius-xl); overflow: hidden;
    box-shadow: var(--shadow-sm); margin-bottom: 14px;
}
.side-card-head {
    padding: 14px 18px; border-bottom: 1px solid var(--border);
    background: #f8f9fc; font-size: 12px; font-weight: 700;
    color: var(--text-secondary); text-transform: uppercase; letter-spacing: .6px;
    display: flex; align-items: center; gap: 7px;
}
.side-card-body { padding: 14px 18px; }

.meta-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; border-bottom: 1px solid #f3f4f8;
    font-size: 12px;
}
.meta-row:last-child { border-bottom: none; }
.meta-label { color: var(--text-muted); font-weight: 500; }
.meta-val   { color: var(--text-primary); font-weight: 700; }
.meta-val.green { color: var(--success); }
.meta-val.amber { color: var(--warn); }
.meta-val.red   { color: var(--danger); }

.warn-box {
    background: var(--warn-soft); border: 1px solid #fde68a;
    border-radius: var(--radius-md); padding: 12px 14px;
    display: flex; gap: 10px; align-items: flex-start;
}
.warn-box-icon { font-size: 16px; flex-shrink: 0; }
.warn-box-text { font-size: 12px; color: #92400e; line-height: 1.5; font-weight: 500; }

.tips-list { list-style: none; padding: 0; margin: 0; }
.tips-list li {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12px; color: var(--text-secondary); padding: 6px 0;
    border-bottom: 1px solid #f3f4f8; line-height: 1.5;
}
.tips-list li:last-child { border-bottom: none; }
.tips-list li i { color: var(--success); font-size: 12px; margin-top: 2px; flex-shrink: 0; }

/* ACTION BUTTONS */
.form-actions {
    display: flex; gap: 10px; margin-top: 20px;
    padding-top: 20px; border-top: 1px solid var(--border);
}
.btn-cancel {
    flex: 1; padding: 11px;
    background: var(--surface); border: 1px solid var(--border-dark);
    border-radius: var(--radius-md); font-size: 13px; font-weight: 600;
    color: var(--text-secondary); cursor: pointer; font-family: var(--font);
    text-decoration: none; text-align: center; transition: all .15s;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-cancel:hover { background: var(--danger-soft); color: var(--danger); border-color: #fecaca; }
.btn-save {
    flex: 2; padding: 11px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: 1px solid #f59e0b; border-radius: var(--radius-md);
    font-size: 13px; font-weight: 700; color: #fff;
    cursor: pointer; font-family: var(--font);
    box-shadow: 0 2px 8px rgba(245,158,11,.3);
    transition: all .15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-save:hover { background: linear-gradient(135deg,#d97706,#b45309); box-shadow: 0 4px 14px rgba(245,158,11,.4); }
.btn-save:disabled { opacity: .6; cursor: not-allowed; }

/* TOAST */
#adm-toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 99999;
    display: flex; align-items: center; gap: 10px;
    padding: 12px 20px; border-radius: var(--radius-lg);
    font-size: 13px; font-weight: 600; font-family: var(--font);
    color: #fff; min-width: 220px;
    opacity: 0; pointer-events: none;
    transform: translateY(16px);
    transition: opacity .3s, transform .3s;
    box-shadow: var(--shadow-lg);
}
#adm-toast.show { opacity: 1; transform: translateY(0); }
#adm-toast.t-success { background: linear-gradient(135deg,#059669,#10b981); }
#adm-toast.t-error   { background: linear-gradient(135deg,#dc2626,#ef4444); }
</style>

<div class="adm-wrap">

    {{-- TAB BAR --}}
    <div class="tab-bar">
        <a href="{{ route('admin.admanager.index') }}" class="active">
            <i class="bi bi-layout-wtf"></i> Ads Settings
        </a>
        <a href="{{ route('admin.headercode.index') }}">
            <i class="bi bi-code-slash"></i> Header Code
        </a>
    </div>

    {{-- BREADCRUMB --}}
    <div class="adm-breadcrumb">
        <i class="bi bi-house-door" style="font-size:12px;"></i>
        <a href="{{ route('admin.admanager.index') }}">Ad Spaces</a>
        <span class="sep"><i class="bi bi-chevron-right" style="font-size:10px;"></i></span>
        <span class="current">
            Edit Ad #{{ $ad->id }}
            <span class="edit-badge"><i class="bi bi-pencil-fill"></i> Editing</span>
        </span>
    </div>

    <div class="create-layout">

        {{-- ── MAIN FORM ── --}}
        <div>
            <div class="form-main-card">
                <div class="form-main-head">
                    <div class="form-main-icon">✎</div>
                    <div>
                        <div class="form-main-title">Edit Ad Space <span style="color:var(--warn);font-size:14px;">#{{ $ad->id }}</span></div>
                        <div class="form-main-sub">Update your advertisement configuration</div>
                    </div>
                </div>
                <div class="form-main-body">

                    <form id="editAdPageForm"
                        action="{{ route('admin.admanager.update', $ad->id) }}"
                        method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        @php
                            $slots = [
                                ['key'=>'header_ads',      'pfx'=>'ha', 'label'=>'Header Ads',      'sub'=>'728×90 — top of every page',         'icon'=>'🗞',  'color'=>'#eef2ff'],
                                ['key'=>'sidebar_ads',     'pfx'=>'sa', 'label'=>'Sidebar Ads',     'sub'=>'300×250 — sidebar widget area',      'icon'=>'📐', 'color'=>'#ecfdf5'],
                                ['key'=>'before_post_ads', 'pfx'=>'bp', 'label'=>'Before Post Ads', 'sub'=>'728×90 — above article content',     'icon'=>'⬆',  'color'=>'#fffbeb'],
                                ['key'=>'after_post_ads',  'pfx'=>'ap', 'label'=>'After Post Ads',  'sub'=>'728×90 — below article content',     'icon'=>'⬇',  'color'=>'#fff1f1'],
                            ];
                        @endphp

                        @foreach($slots as $slot)
                        @php
                            $type     = old($slot['key'].'_type', $ad->{$slot['key'].'_type'} ?? 'code');
                            $codeVal  = old($slot['key'], $ad->{$slot['key'].'_type'} === 'code' ? $ad->{$slot['key']} : '');
                            $hasImg   = ($ad->{$slot['key'].'_type'} === 'image' && $ad->{$slot['key']});
                            $imgSrc   = $hasImg ? asset('uploads/ads/' . basename($ad->{$slot['key']})) : '';
                            $hasFill  = $type === 'code' ? !empty($codeVal) : $hasImg;
                        @endphp
                        <div class="slot-card" id="slotCard_{{ $slot['pfx'] }}">
                            <div class="slot-card-head" onclick="toggleSlot('{{ $slot['pfx'] }}')">
                                <div class="slot-icon" style="background:{{ $slot['color'] }};">{{ $slot['icon'] }}</div>
                                <div style="flex:1;">
                                    <div class="slot-card-title">{{ $slot['label'] }}</div>
                                    <div class="slot-card-sub">{{ $slot['sub'] }}</div>
                                </div>
                                <div class="slot-dot {{ $hasFill ? 'filled' : '' }}" id="dot_{{ $slot['pfx'] }}" title="{{ $hasFill ? 'Has content' : 'Empty' }}"></div>
                                <i class="bi bi-chevron-down slot-chevron" style="margin-left:8px;"></i>
                            </div>
                            <div class="slot-body">
                                {{-- Radio toggle --}}
                                <div class="slot-radios" id="radios_{{ $slot['pfx'] }}">
                                    <label class="slot-radio-opt {{ $type === 'code' ? 'selected' : '' }}"
                                        onclick="ptoggle('{{ $slot['pfx'] }}','code')">
                                        <input type="radio" name="{{ $slot['key'] }}_type"
                                            value="code" {{ $type === 'code' ? 'checked' : '' }}>
                                        <i class="bi bi-code-square"></i> Ad Code
                                    </label>
                                    <label class="slot-radio-opt {{ $type === 'image' ? 'selected' : '' }}"
                                        onclick="ptoggle('{{ $slot['pfx'] }}','image')">
                                        <input type="radio" name="{{ $slot['key'] }}_type"
                                            value="image" {{ $type === 'image' ? 'checked' : '' }}>
                                        <i class="bi bi-image"></i> Image Upload
                                    </label>
                                </div>

                                {{-- Code wrap --}}
                                <div id="{{ $slot['pfx'] }}_code_wrap" style="{{ $type === 'image' ? 'display:none;' : '' }}">
                                    <textarea class="slot-textarea @error($slot['key']) is-invalid @enderror"
                                        name="{{ $slot['key'] }}" rows="4"
                                        placeholder="Paste your ad code here...">{{ $codeVal }}</textarea>
                                    @error($slot['key'])
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                    <div class="field-hint"><i class="bi bi-info-circle"></i> Paste Google AdSense or any HTML ad code</div>
                                </div>

                                {{-- Image wrap --}}
                                <div id="{{ $slot['pfx'] }}_img_wrap" style="{{ $type !== 'image' ? 'display:none;' : '' }}">
                                    {{-- Current image --}}
                                    @if($hasImg)
                                    <div class="current-img-box" id="curImg_{{ $slot['pfx'] }}">
                                        <img src="{{ $imgSrc }}" alt="Current" onerror="this.parentElement.style.display='none'">
                                        <div class="current-img-info">
                                            <div class="current-img-label"><i class="bi bi-check-circle-fill"></i> Current Image</div>
                                            <div class="current-img-note">Upload a new file below to replace it</div>
                                        </div>
                                        <button type="button" class="btn-remove-img"
                                            onclick="removeCurrent('{{ $slot['pfx'] }}')" title="Remove current image">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    @endif

                                    {{-- Upload zone --}}
                                    <div class="slot-file-wrap" onclick="document.getElementById('file_{{ $slot['pfx'] }}').click()">
                                        <input type="file" id="file_{{ $slot['pfx'] }}"
                                            name="{{ $slot['key'] }}_image" accept="image/*"
                                            onchange="previewImage(this,'newPrev_{{ $slot['pfx'] }}','dot_{{ $slot['pfx'] }}')">
                                        <div class="slot-file-icon">🖼</div>
                                        <div class="slot-file-text">{{ $hasImg ? 'Click to replace image' : 'Click to upload image' }}</div>
                                        <div class="slot-file-sub">JPG, PNG, GIF, WEBP — Max 2MB</div>
                                    </div>

                                    @error($slot['key'].'_image')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                    <div class="field-hint"><i class="bi bi-folder"></i> Saved to <code style="font-size:10px;background:#f3f4f6;padding:1px 5px;border-radius:3px;">uploads/ads/</code></div>

                                    {{-- New preview --}}
                                    <div class="new-preview-box" id="newPrev_{{ $slot['pfx'] }}">
                                        <img src="" alt="New Preview">
                                        <button type="button" class="btn-clear-preview"
                                            onclick="clearPreview('newPrev_{{ $slot['pfx'] }}','file_{{ $slot['pfx'] }}')">×</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="form-actions">
                            <a href="{{ route('admin.admanager.index') }}" class="btn-cancel">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn-save" id="editPageSubmitBtn">
                                <span id="editPageBtnTxt"><i class="bi bi-pencil-fill"></i> Update Ad Space</span>
                                <span id="editPageSpinner" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div>
            {{-- Ad Info --}}
            <div class="side-card">
                <div class="side-card-head"><i class="bi bi-info-circle"></i> Ad Info</div>
                <div class="side-card-body">
                    <div class="meta-row">
                        <span class="meta-label">Ad ID</span>
                        <span class="meta-val">#{{ $ad->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Status</span>
                        <span class="meta-val {{ $ad->status ? 'green' : 'red' }}">
                            {{ $ad->status ? '● Active' : '○ Inactive' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Header Ads</span>
                        <span class="meta-val {{ $ad->header_ads ? 'green' : '' }}">
                            {{ $ad->header_ads ? ucfirst($ad->header_ads_type) : '—' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Sidebar Ads</span>
                        <span class="meta-val {{ $ad->sidebar_ads ? 'green' : '' }}">
                            {{ $ad->sidebar_ads ? ucfirst($ad->sidebar_ads_type) : '—' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Before Post</span>
                        <span class="meta-val {{ $ad->before_post_ads ? 'green' : '' }}">
                            {{ $ad->before_post_ads ? ucfirst($ad->before_post_ads_type) : '—' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">After Post</span>
                        <span class="meta-val {{ $ad->after_post_ads ? 'green' : '' }}">
                            {{ $ad->after_post_ads ? ucfirst($ad->after_post_ads_type) : '—' }}
                        </span>
                    </div>
                    @if($ad->created_at)
                    <div class="meta-row">
                        <span class="meta-label">Created</span>
                        <span class="meta-val">{{ $ad->created_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Warning --}}
            <div class="side-card">
                <div class="side-card-head"><i class="bi bi-exclamation-triangle"></i> Important</div>
                <div class="side-card-body">
                    <div class="warn-box">
                        <div class="warn-box-icon">⚠️</div>
                        <div class="warn-box-text">
                            Changing an ad type from <strong>Image</strong> to <strong>Code</strong> will remove the existing image. Make sure to save your changes carefully.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="side-card">
                <div class="side-card-head"><i class="bi bi-lightbulb"></i> Edit Tips</div>
                <div class="side-card-body">
                    <ul class="tips-list">
                        <li><i class="bi bi-check-circle-fill"></i> Leave image field empty to keep the existing image</li>
                        <li><i class="bi bi-check-circle-fill"></i> Switching type will overwrite previous data</li>
                        <li><i class="bi bi-check-circle-fill"></i> Ad code changes take effect immediately</li>
                        <li><i class="bi bi-check-circle-fill"></i> Use the toggle on the list to enable/disable</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="adm-toast"><span class="t-icon"></span><span class="t-msg"></span></div>

<script>
/* ── Toggle slot open/close ── */
function toggleSlot(pfx) {
    document.getElementById('slotCard_' + pfx).classList.toggle('collapsed');
}

/* ── Toggle code / image ── */
function ptoggle(pfx, type) {
    document.getElementById(pfx + '_code_wrap').style.display = type === 'code'  ? '' : 'none';
    document.getElementById(pfx + '_img_wrap').style.display  = type === 'image' ? '' : 'none';
    const radios = document.getElementById('radios_' + pfx);
    radios.querySelectorAll('.slot-radio-opt').forEach(opt => {
        opt.classList.toggle('selected', opt.querySelector('input').value === type);
        opt.querySelector('input').checked = opt.querySelector('input').value === type;
    });
    updateDot(pfx, type);
}

/* ── Update slot indicator dot ── */
function updateDot(pfx, type) {
    const dot = document.getElementById('dot_' + pfx);
    if (!dot) return;
    if (type === 'code') {
        const ta = document.querySelector('#' + pfx + '_code_wrap textarea');
        dot.classList.toggle('filled', !!(ta && ta.value.trim()));
    } else {
        const fi  = document.getElementById('file_' + pfx);
        const cur = document.getElementById('curImg_' + pfx);
        dot.classList.toggle('filled', (fi && fi.files && fi.files.length > 0) || !!(cur && cur.style.display !== 'none'));
    }
}

document.addEventListener('input', function(e) {
    if (e.target.tagName === 'TEXTAREA') {
        const wrap = e.target.closest('[id$="_code_wrap"]');
        if (wrap) updateDot(wrap.id.replace('_code_wrap',''), 'code');
    }
});

/* ── Image preview (new file) ── */
function previewImage(input, prevId, dotId) {
    const box = document.getElementById(prevId);
    if (!box) return;
    const img = box.querySelector('img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; box.style.display = 'inline-block'; };
        reader.readAsDataURL(input.files[0]);
        const dot = document.getElementById(dotId);
        if (dot) dot.classList.add('filled');
    }
}

/* ── Clear new preview ── */
function clearPreview(prevId, fileId) {
    const box = document.getElementById(prevId);
    if (box) { box.querySelector('img').src = ''; box.style.display = 'none'; }
    const fi = document.getElementById(fileId);
    if (fi) fi.value = '';
}

/* ── Remove current image ── */
function removeCurrent(pfx) {
    const box = document.getElementById('curImg_' + pfx);
    if (box) { box.style.opacity='0'; box.style.transition='.2s'; setTimeout(()=>box.style.display='none',200); }
    const dot = document.getElementById('dot_' + pfx);
    const fi  = document.getElementById('file_' + pfx);
    if (!fi || !fi.files || fi.files.length === 0) {
        if (dot) dot.classList.remove('filled');
    }
}

/* ── Toast ── */
function toast(msg, type = 'success') {
    const el = document.getElementById('adm-toast');
    el.querySelector('.t-icon').textContent = type === 'success' ? '✅' : '❌';
    el.querySelector('.t-msg').textContent  = msg;
    el.className = `t-${type}`;
    el.classList.add('show');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.remove('show'), 3000);
}

/* ── Form submit ── */
document.getElementById('editAdPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn  = document.getElementById('editPageSubmitBtn');
    const txt  = document.getElementById('editPageBtnTxt');
    const spin = document.getElementById('editPageSpinner');
    btn.disabled = true;
    txt.innerHTML = 'Updating...';
    spin.classList.remove('d-none');

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: new FormData(this),
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        txt.innerHTML = '<i class="bi bi-pencil-fill"></i> Update Ad Space';
        spin.classList.add('d-none');
        if (d.success) {
            toast('Ad updated successfully!');
            setTimeout(() => window.location.href = '{{ route("admin.admanager.index") }}', 900);
        } else {
            const errs = d.errors ? Object.values(d.errors).flat().join(' | ') : (d.message || 'Error');
            toast(errs, 'error');
        }
    })
    .catch(() => {
        btn.disabled = false;
        txt.innerHTML = '<i class="bi bi-pencil-fill"></i> Update Ad Space';
        spin.classList.add('d-none');
        toast('Something went wrong.', 'error');
    });
});
</script>
@endsection
