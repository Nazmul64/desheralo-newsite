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

/* PAGE LAYOUT */
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
    background: linear-gradient(135deg, #f0f2ff 0%, #fafbff 100%);
    display: flex; align-items: center; gap: 14px;
}
.form-main-icon {
    width: 42px; height: 42px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-mid);
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
    cursor: pointer;
    user-select: none;
}
.slot-card-head:hover { background: #f9faff; }
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

.slot-body { padding: 16px 18px; }
.slot-radios {
    display: flex; gap: 0; margin-bottom: 14px;
    background: var(--bg);
    border: 1px solid var(--border-dark);
    border-radius: var(--radius-md);
    padding: 3px;
}
.slot-radio-opt {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 7px 10px; border-radius: var(--radius-sm);
    cursor: pointer; font-size: 12px; font-weight: 600;
    color: var(--text-secondary); transition: all .15s;
}
.slot-radio-opt input[type=radio] { display: none; }
.slot-radio-opt.selected {
    background: var(--surface);
    color: var(--primary);
    box-shadow: var(--shadow-xs);
    border: 1px solid var(--primary-mid);
}
.slot-radio-opt i { font-size: 13px; }

.slot-textarea {
    width: 100%; padding: 10px 12px;
    border: 1px solid var(--border-dark); border-radius: var(--radius-md);
    font-size: 12px; font-family: 'Courier New', monospace;
    color: var(--text-primary); resize: vertical; min-height: 80px;
    background: var(--surface); outline: none;
    transition: border-color .15s, box-shadow .15s;
    line-height: 1.6;
}
.slot-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.slot-textarea.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

.slot-file-wrap {
    border: 2px dashed var(--border-dark);
    border-radius: var(--radius-md);
    padding: 14px 16px;
    text-align: center;
    cursor: pointer;
    transition: all .18s;
    background: var(--surface);
}
.slot-file-wrap:hover { border-color: var(--primary); background: var(--primary-soft); }
.slot-file-wrap input[type=file] {
    position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0;
}
.slot-file-icon { font-size: 24px; margin-bottom: 4px; }
.slot-file-text { font-size: 12px; font-weight: 600; color: var(--text-secondary); }
.slot-file-sub  { font-size: 10px; color: var(--text-muted); margin-top: 2px; }

.field-hint {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; color: var(--text-muted); margin-top: 6px;
}
.field-error {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; color: var(--danger); font-weight: 600; margin-top: 6px;
}
.field-error i { font-size: 11px; }

/* SIDEBAR CARD */
.side-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 14px;
}
.side-card-head {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    background: #f8f9fc;
    font-size: 12px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    display: flex; align-items: center; gap: 7px;
}
.side-card-body { padding: 14px 18px; }
.info-row {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 8px 0; border-bottom: 1px solid #f3f4f8;
    font-size: 12px;
}
.info-row:last-child { border-bottom: none; }
.info-row-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }
.info-row-content { flex: 1; }
.info-row-title { font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
.info-row-sub   { color: var(--text-muted); font-size: 11px; line-height: 1.4; }

.tips-list { list-style: none; padding: 0; margin: 0; }
.tips-list li {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12px; color: var(--text-secondary); padding: 6px 0;
    border-bottom: 1px solid #f3f4f8; line-height: 1.5;
}
.tips-list li:last-child { border-bottom: none; }
.tips-list li i { color: var(--success); font-size: 12px; margin-top: 2px; flex-shrink: 0; }

/* PROGRESS INDICATOR */
.slot-progress {
    display: flex; gap: 6px; margin-bottom: 18px;
}
.slot-progress-item {
    flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px;
}
.spi-dot {
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
    border: 2px solid var(--border-dark);
    color: var(--text-muted);
    background: var(--bg);
    transition: all .2s;
}
.spi-dot.filled { background: var(--primary); border-color: var(--primary); color: #fff; }
.spi-line { width: 100%; height: 2px; background: var(--border); border-radius: 1px; margin-top: 6px; }
.spi-label { font-size: 9px; font-weight: 700; color: var(--text-muted); letter-spacing: .5px; text-align: center; margin-top: 2px; }

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
    background: var(--primary); border: 1px solid var(--primary);
    border-radius: var(--radius-md); font-size: 13px; font-weight: 700;
    color: #fff; cursor: pointer; font-family: var(--font);
    box-shadow: 0 2px 8px rgba(79,70,229,.3);
    transition: all .15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-save:hover { background: #4338ca; box-shadow: 0 4px 14px rgba(79,70,229,.4); }
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
        <span class="current">Create New Ad</span>
    </div>

    <div class="create-layout">

        {{-- ── MAIN FORM ── --}}
        <div>
            <div class="form-main-card">
                <div class="form-main-head">
                    <div class="form-main-icon">📢</div>
                    <div>
                        <div class="form-main-title">Create New Ad Space</div>
                        <div class="form-main-sub">Configure advertisement slots for your site</div>
                    </div>
                </div>
                <div class="form-main-body">

                    {{-- Progress dots --}}
                    <div class="slot-progress" id="slotProgress">
                        @foreach([['ha','🗞','Header'],['sa','📐','Sidebar'],['bp','⬆','Before'],['ap','⬇','After']] as $s)
                        <div class="slot-progress-item">
                            <div class="spi-dot" id="dot_{{ $s[0] }}">{{ $s[1] }}</div>
                            <div class="spi-label">{{ $s[2] }}</div>
                        </div>
                        @endforeach
                    </div>

                    <form id="createAdPageForm"
                        action="{{ route('admanager.store') }}"
                        method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        @php
                            $slots = [
                                ['key'=>'header_ads',      'pfx'=>'ha', 'label'=>'Header Ads',      'sub'=>'728×90 — displayed at the top of every page',  'icon'=>'🗞',  'color'=>'#eef2ff'],
                                ['key'=>'sidebar_ads',     'pfx'=>'sa', 'label'=>'Sidebar Ads',     'sub'=>'300×250 — shown in the sidebar widget area',    'icon'=>'📐', 'color'=>'#ecfdf5'],
                                ['key'=>'before_post_ads', 'pfx'=>'bp', 'label'=>'Before Post Ads', 'sub'=>'728×90 — appears just above each article',      'icon'=>'⬆',  'color'=>'#fffbeb'],
                                ['key'=>'after_post_ads',  'pfx'=>'ap', 'label'=>'After Post Ads',  'sub'=>'728×90 — appears just below each article',      'icon'=>'⬇',  'color'=>'#fff1f1'],
                            ];
                        @endphp

                        @foreach($slots as $slot)
                        @php $type = old($slot['key'].'_type', 'code'); @endphp
                        <div class="slot-card" id="slotCard_{{ $slot['pfx'] }}">
                            <div class="slot-card-head" onclick="toggleSlot('{{ $slot['pfx'] }}')">
                                <div class="slot-icon" style="background:{{ $slot['color'] }};">{{ $slot['icon'] }}</div>
                                <div>
                                    <div class="slot-card-title">{{ $slot['label'] }}</div>
                                    <div class="slot-card-sub">{{ $slot['sub'] }}</div>
                                </div>
                                <i class="bi bi-chevron-down slot-chevron"></i>
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
                                        placeholder="Paste your ad code here...&#10;e.g. &lt;script async src=&quot;...&quot;&gt;&lt;/script&gt;">{{ old($slot['key']) }}</textarea>
                                    @error($slot['key'])
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                    <div class="field-hint"><i class="bi bi-info-circle"></i> Paste Google AdSense or any HTML ad code</div>
                                </div>

                                {{-- Image wrap --}}
                                <div id="{{ $slot['pfx'] }}_img_wrap" style="{{ $type !== 'image' ? 'display:none;' : '' }}">
                                    <div class="slot-file-wrap" onclick="document.getElementById('file_{{ $slot['pfx'] }}').click()">
                                        <input type="file" id="file_{{ $slot['pfx'] }}"
                                            name="{{ $slot['key'] }}_image" accept="image/*"
                                            onchange="previewImage(this,'prev_{{ $slot['pfx'] }}')">
                                        <div class="slot-file-icon">🖼</div>
                                        <div class="slot-file-text">Click to upload image</div>
                                        <div class="slot-file-sub">JPG, PNG, GIF, WEBP — Max 2MB</div>
                                    </div>
                                    @error($slot['key'].'_image')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                    <div class="field-hint"><i class="bi bi-folder"></i> Saved to <code style="font-size:10px;background:#f3f4f6;padding:1px 5px;border-radius:3px;">uploads/ads/</code></div>
                                    <div id="prev_{{ $slot['pfx'] }}" style="display:none;margin-top:10px;position:relative;display:inline-block;">
                                        <img src="" alt="Preview" style="max-height:80px;border-radius:8px;border:1px solid var(--border);box-shadow:var(--shadow-xs);">
                                        <button type="button" onclick="clearPreview('prev_{{ $slot['pfx'] }}','file_{{ $slot['pfx'] }}')"
                                            style="position:absolute;top:-7px;right:-7px;width:20px;height:20px;background:var(--danger);color:#fff;border:none;border-radius:50%;font-size:11px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;">×</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="form-actions">
                            <a href="{{ route('admin.admanager.index') }}" class="btn-cancel">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn-save" id="pageSubmitBtn">
                                <span id="pageBtnTxt"><i class="bi bi-check-lg"></i> Save Ad Space</span>
                                <span id="pageSpinner" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div>
            {{-- Ad Positions --}}
            <div class="side-card">
                <div class="side-card-head"><i class="bi bi-map"></i> Ad Positions</div>
                <div class="side-card-body">
                    <div class="info-row">
                        <div class="info-row-icon">🗞</div>
                        <div class="info-row-content">
                            <div class="info-row-title">Header Ads</div>
                            <div class="info-row-sub">Leaderboard — 728×90. Top of every page, high visibility.</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-icon">📐</div>
                        <div class="info-row-content">
                            <div class="info-row-title">Sidebar Ads</div>
                            <div class="info-row-sub">Medium Rectangle — 300×250. Persistent sidebar placement.</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-icon">⬆</div>
                        <div class="info-row-content">
                            <div class="info-row-title">Before Post Ads</div>
                            <div class="info-row-sub">In-content — 728×90. Shown above article content.</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-icon">⬇</div>
                        <div class="info-row-content">
                            <div class="info-row-title">After Post Ads</div>
                            <div class="info-row-sub">In-content — 728×90. Shown below article content.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="side-card">
                <div class="side-card-head"><i class="bi bi-lightbulb"></i> Tips</div>
                <div class="side-card-body">
                    <ul class="tips-list">
                        <li><i class="bi bi-check-circle-fill"></i> Fill only the slots you need — others can stay empty</li>
                        <li><i class="bi bi-check-circle-fill"></i> Use Ad Code for Google AdSense scripts</li>
                        <li><i class="bi bi-check-circle-fill"></i> Images must be under 2MB for fast loading</li>
                        <li><i class="bi bi-check-circle-fill"></i> You can enable/disable each ad from the list</li>
                        <li><i class="bi bi-check-circle-fill"></i> Responsive ad units work best across devices</li>
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
    const card = document.getElementById('slotCard_' + pfx);
    card.classList.toggle('collapsed');
}

/* ── Toggle code / image ── */
function ptoggle(pfx, type) {
    document.getElementById(pfx + '_code_wrap').style.display = type === 'code'  ? '' : 'none';
    document.getElementById(pfx + '_img_wrap').style.display  = type === 'image' ? '' : 'none';
    // update pill UI
    const radios = document.getElementById('radios_' + pfx);
    radios.querySelectorAll('.slot-radio-opt').forEach(opt => {
        opt.classList.toggle('selected', opt.querySelector('input').value === type);
    });
    // also tick the hidden radio
    const input = radios.querySelector(`input[value="${type}"]`);
    if (input) input.checked = true;
    // update progress dot
    updateProgressDot(pfx, type);
}

/* ── Progress dots ── */
function updateProgressDot(pfx, type) {
    const dot = document.getElementById('dot_' + pfx);
    if (!dot) return;
    const codeWrap = document.getElementById(pfx + '_code_wrap');
    const imgWrap  = document.getElementById(pfx + '_img_wrap');
    if (type === 'code') {
        const ta = codeWrap ? codeWrap.querySelector('textarea') : null;
        dot.classList.toggle('filled', !!(ta && ta.value.trim()));
    } else {
        const fi = imgWrap ? imgWrap.querySelector('input[type=file]') : null;
        dot.classList.toggle('filled', !!(fi && fi.files && fi.files.length > 0));
    }
}

/* ── Auto update dots on input ── */
document.addEventListener('input', function(e) {
    if (e.target.tagName === 'TEXTAREA') {
        const wrap = e.target.closest('[id$="_code_wrap"]');
        if (wrap) {
            const pfx = wrap.id.replace('_code_wrap','');
            updateProgressDot(pfx, 'code');
        }
    }
});
document.addEventListener('change', function(e) {
    if (e.target.type === 'file') {
        const wrap = e.target.closest('[id$="_img_wrap"]');
        if (wrap) {
            const pfx = wrap.id.replace('_img_wrap','');
            updateProgressDot(pfx, 'image');
        }
    }
});

/* ── Image preview ── */
function previewImage(input, prevId) {
    const box = document.getElementById(prevId);
    if (!box) return;
    const img = box.querySelector('img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; box.style.display = 'inline-block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearPreview(prevId, fileId) {
    const box = document.getElementById(prevId);
    if (box) { box.querySelector('img').src = ''; box.style.display = 'none'; }
    const fi  = document.getElementById(fileId);
    if (fi) fi.value = '';
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
document.getElementById('createAdPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn  = document.getElementById('pageSubmitBtn');
    const txt  = document.getElementById('pageBtnTxt');
    const spin = document.getElementById('pageSpinner');
    btn.disabled = true;
    txt.innerHTML = 'Saving...';
    spin.classList.remove('d-none');

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: new FormData(this),
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        txt.innerHTML = '<i class="bi bi-check-lg"></i> Save Ad Space';
        spin.classList.add('d-none');
        if (d.success) {
            toast('Ad created successfully!');
            setTimeout(() => window.location.href = '{{ route("admin.admanager.index") }}', 900);
        } else {
            const errs = d.errors ? Object.values(d.errors).flat().join(' | ') : (d.message || 'Error');
            toast(errs, 'error');
        }
    })
    .catch(() => {
        btn.disabled = false;
        txt.innerHTML = '<i class="bi bi-check-lg"></i> Save Ad Space';
        spin.classList.add('d-none');
        toast('Something went wrong.', 'error');
    });
});

/* ── Restore old type on validation error ── */
@if(old('header_ads_type') === 'image')      ptoggle('ha', 'image'); @endif
@if(old('sidebar_ads_type') === 'image')     ptoggle('sa', 'image'); @endif
@if(old('before_post_ads_type') === 'image') ptoggle('bp', 'image'); @endif
@if(old('after_post_ads_type') === 'image')  ptoggle('ap', 'image'); @endif
</script>
@endsection
