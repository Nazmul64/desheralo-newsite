{{-- resources/views/admin/blognewsadd/create.blade.php --}}
@extends('admin.master')

@section('content')
<style>
    :root {
        --nf-primary: #1a56db; --nf-primary-light: #eff6ff; --nf-danger: #e02424;
        --nf-border: #e5e9f2; --nf-text: #1f2937; --nf-muted: #6b7280;
        --nf-bg: #f4f6fb; --nf-radius: 10px;
        --nf-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    }
    .nf-wrap { background:var(--nf-bg); min-height:100vh; padding:28px 0; }
    .nf-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .nf-page-title { font-size:20px; font-weight:700; color:var(--nf-text); }
    .nf-btn-back { display:inline-flex; align-items:center; gap:7px; background:var(--nf-primary); color:#fff; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:background .2s; }
    .nf-btn-back:hover { background:#1648c0; color:#fff; }
    .nf-card { background:#fff; border-radius:var(--nf-radius); box-shadow:var(--nf-shadow); border:1px solid var(--nf-border); }
    .nf-section { padding:14px 22px; border-bottom:1px solid var(--nf-border); background:#fafbfd; display:flex; align-items:center; gap:9px; }
    .nf-section-icon { width:30px; height:30px; background:var(--nf-primary-light); border-radius:7px; display:flex; align-items:center; justify-content:center; color:var(--nf-primary); font-size:13px; }
    .nf-section-title { font-size:13px; font-weight:700; color:var(--nf-text); }
    .nf-body { padding:22px; }
    .nf-field { margin-bottom:18px; }
    .nf-field:last-child { margin-bottom:0; }
    .nf-label { display:block; font-size:12px; font-weight:600; color:var(--nf-muted); margin-bottom:6px; text-transform:uppercase; letter-spacing:.4px; }
    .nf-label .req { color:var(--nf-danger); margin-left:2px; }
    .nf-input, .nf-textarea, .nf-select { width:100%; padding:9px 13px; border:1.5px solid var(--nf-border); border-radius:8px; font-size:13.5px; color:var(--nf-text); background:#fff; outline:none; transition:border-color .2s, box-shadow .2s; font-family:inherit; }
    .nf-input:focus, .nf-textarea:focus, .nf-select:focus { border-color:var(--nf-primary); box-shadow:0 0 0 3px rgba(26,86,219,.1); }
    .nf-input.is-error { border-color:var(--nf-danger); }
    .nf-textarea { resize:vertical; min-height:90px; }
    .nf-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b7280' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; cursor:pointer; }
    .nf-select:disabled { background-color:#f9fafb; color:#9ca3af; cursor:not-allowed; }
    .nf-error-msg { font-size:11.5px; color:var(--nf-danger); margin-top:5px; }
    .sub-loading-text { font-size:12px; color:var(--nf-muted); margin-top:5px; display:none; }
    .sub-loading-text.visible { display:block; }

    /* ── Tag Input ── */
    .tag-input-wrap {
        display:flex; flex-wrap:wrap; align-items:center; gap:6px;
        border:1.5px solid var(--nf-border); border-radius:8px;
        padding:7px 10px; min-height:42px; background:#fff;
        cursor:text; transition:border-color .2s, box-shadow .2s;
    }
    .tag-input-wrap:focus-within { border-color:var(--nf-primary); box-shadow:0 0 0 3px rgba(26,86,219,.1); }
    .tag-chip {
        display:inline-flex; align-items:center; gap:4px;
        background:#fef9c3; color:#854d0e; border:1px solid #fde68a;
        padding:2px 8px 2px 10px; border-radius:20px; font-size:12px; font-weight:600;
    }
    .tag-chip-rm { background:none; border:none; color:#b45309; cursor:pointer; font-size:14px; line-height:1; padding:0; display:flex; align-items:center; }
    .tag-chip-rm:hover { color:#92400e; }
    .tag-real-input { border:none; outline:none; font-size:13px; color:var(--nf-text); min-width:140px; flex:1; background:transparent; padding:2px 4px; }
    .tag-hint { font-size:11.5px; color:#9ca3af; margin-top:5px; }

    /* Upload */
    .nf-upload-zone { border:2px dashed var(--nf-border); border-radius:9px; padding:22px; text-align:center; background:#fafbfd; cursor:pointer; transition:border-color .2s, background .2s; position:relative; }
    .nf-upload-zone:hover, .nf-upload-zone.drag-over { border-color:var(--nf-primary); background:var(--nf-primary-light); }
    .nf-upload-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
    .nf-upload-icon { font-size:26px; color:#d1d5db; margin-bottom:8px; }
    .nf-upload-text { font-size:13px; color:var(--nf-muted); }
    .nf-upload-text strong { color:var(--nf-primary); }
    .nf-upload-hint { font-size:11.5px; color:#9ca3af; margin-top:4px; }
    .nf-preview { margin-top:12px; display:none; }
    .nf-preview.visible { display:block; }
    .nf-preview img { max-height:110px; border-radius:8px; border:1px solid var(--nf-border); object-fit:cover; }
    .nf-preview p { font-size:12px; color:var(--nf-muted); margin-top:5px; }
    .nf-preview-rm { font-size:12px; color:var(--nf-danger); cursor:pointer; background:none; border:none; padding:0; margin-top:4px; }

    .nf-footer { padding:16px 22px; border-top:1px solid var(--nf-border); display:flex; align-items:center; justify-content:flex-end; gap:10px; background:#fafbfd; border-radius:0 0 var(--nf-radius) var(--nf-radius); }
    .nf-btn-cancel { padding:9px 22px; border:1.5px solid var(--nf-border); background:#fff; border-radius:8px; font-size:13px; font-weight:600; color:var(--nf-muted); text-decoration:none; transition:background .2s; }
    .nf-btn-cancel:hover { background:#f3f4f6; color:var(--nf-text); }
    .nf-btn-save { padding:9px 26px; background:var(--nf-primary); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:background .2s; display:flex; align-items:center; gap:7px; }
    .nf-btn-save:hover { background:#1648c0; }
</style>

<div class="nf-wrap container-fluid">

    <div class="nf-header">
        <h4 class="nf-page-title">Create News Article</h4>
        <a href="{{ route('blognewsadd.index') }}" class="nf-btn-back">
            <i class="fas fa-list"></i> News List
        </a>
    </div>

    <form action="{{ route('blognewsadd.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
        @csrf

        {{-- Hidden field: comma-separated keywords string → controller তে array বানাবে --}}
        <input type="hidden" name="meta_keywords_input" id="metaKeywordsInput"
               value="{{ old('meta_keywords_input') }}">

        <div class="row g-3">

            {{-- ── Left Column ── --}}
            <div class="col-lg-8">

                {{-- Basic Info --}}
                <div class="nf-card mb-3">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-pen"></i></div>
                        <span class="nf-section-title">Basic Information</span>
                    </div>
                    <div class="nf-body">
                        <div class="nf-field">
                            <label class="nf-label">Title <span class="req">*</span></label>
                            <input type="text" name="title"
                                   class="nf-input @error('title') is-error @enderror"
                                   placeholder="Enter news title…"
                                   value="{{ old('title') }}">
                            @error('title')<p class="nf-error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Summary</label>
                            <textarea name="summary" class="nf-textarea" rows="3"
                                      placeholder="Short summary…">{{ old('summary') }}</textarea>
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Description</label>
                            <textarea name="description" class="nf-textarea" id="descriptionEditor"
                                      rows="8" placeholder="Full article content…">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Category --}}
                <div class="nf-card mb-3">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-tags"></i></div>
                        <span class="nf-section-title">Category</span>
                    </div>
                    <div class="nf-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="nf-field">
                                    <label class="nf-label">News Category</label>
                                    <select name="newsblogcategory_id" id="cat-select" class="nf-select">
                                        <option value="">— Select Category —</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('newsblogcategory_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="nf-field">
                                    <label class="nf-label">Sub-Category</label>
                                    <select name="newssubblogcategory_id" id="sub-select" class="nf-select" disabled>
                                        <option value="">— Select Sub-Category —</option>
                                    </select>
                                    <p class="sub-loading-text" id="sub-loading">
                                        <i class="fas fa-spinner fa-spin"></i> Loading…
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="nf-card">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-search"></i></div>
                        <span class="nf-section-title">SEO / Meta</span>
                    </div>
                    <div class="nf-body">

                        {{-- ── Meta Keywords Tag Input ── --}}
                        <div class="nf-field">
                            <label class="nf-label">Meta Keywords</label>
                            <div class="tag-input-wrap" id="tagBox" onclick="document.getElementById('tagTyping').focus()">
                                {{-- chips যোগ হবে JS দিয়ে --}}
                                <input type="text" id="tagTyping" class="tag-real-input"
                                       placeholder="Keyword লিখে Enter বা comma চাপুন…"
                                       autocomplete="off">
                            </div>
                            <p class="tag-hint">
                                <i class="fas fa-info-circle"></i>
                                একটা keyword লিখে <kbd>Enter</kbd> বা <kbd>,</kbd> চাপুন। ক্লিক করে রিমুভ করা যাবে।
                            </p>
                            @error('meta_keywords_input')<p class="nf-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="nf-field">
                            <label class="nf-label">Meta Description</label>
                            <textarea name="meta_description" class="nf-textarea" rows="2"
                                      placeholder="Brief description for search engines…">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Right Column ── --}}
            <div class="col-lg-4">

                {{-- Publish Settings --}}
                <div class="nf-card mb-3">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-cog"></i></div>
                        <span class="nf-section-title">Publish Settings</span>
                    </div>
                    <div class="nf-body">
                        <div class="nf-field">
                            <label class="nf-label">Publish Status</label>
                            <select name="status" class="nf-select">
                                <option value="1" {{ old('status','1') == '1' ? 'selected' : '' }}>✅ Published</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>🚫 Unpublished</option>
                            </select>
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Breaking News</label>
                            <select name="breaking_news" class="nf-select">
                                <option value="0" {{ old('breaking_news','0') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('breaking_news') == '1' ? 'selected' : '' }}>🔴 Yes — Breaking</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="nf-card mb-3">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-image"></i></div>
                        <span class="nf-section-title">Featured Image</span>
                    </div>
                    <div class="nf-body">
                        <div class="nf-upload-zone" id="uploadZone">
                            <input type="file" name="image" id="imageInput" accept="image/*">
                            <div class="nf-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="nf-upload-text"><strong>Click to upload</strong> or drag & drop</div>
                            <div class="nf-upload-hint">JPG, PNG, WEBP · max 2MB</div>
                        </div>
                        <div class="nf-preview" id="previewWrap">
                            <img id="previewImg" src="" alt="">
                            <p id="previewName"></p>
                            <button type="button" class="nf-preview-rm" onclick="clearImage()">
                                <i class="fas fa-times me-1"></i>Remove
                            </button>
                        </div>
                        @error('image')<p class="nf-error-msg mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Article Details --}}
                <div class="nf-card">
                    <div class="nf-section">
                        <div class="nf-section-icon"><i class="fas fa-info-circle"></i></div>
                        <span class="nf-section-title">Article Details</span>
                    </div>
                    <div class="nf-body">
                        <div class="nf-field">
                            <label class="nf-label">Publish Date</label>
                            <input type="date" name="date" class="nf-input" value="{{ old('date') }}">
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Reporter</label>
                            <input type="text" name="news_reporter" class="nf-input"
                                   placeholder="Reporter name" value="{{ old('news_reporter') }}">
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Speciality</label>
                            <select name="speciality_id" class="nf-select">
                                <option value="">— Select Speciality —</option>
                                @foreach($specialities as $sp)
                                    <option value="{{ $sp->id }}"
                                        {{ old('speciality_id') == $sp->id ? 'selected' : '' }}>
                                        {{ $sp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="nf-field">
                            <label class="nf-label">Tags</label>
                            <input type="text" name="tags" class="nf-input"
                                   placeholder="politics, bangladesh, economy"
                                   value="{{ old('tags') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nf-footer mt-3 rounded-3">
            <a href="{{ route('blognewsadd.index') }}" class="nf-btn-cancel">Cancel</a>
            <button type="submit" class="nf-btn-save">
                <i class="fas fa-save"></i> Publish Article
            </button>
        </div>
    </form>
</div>

<script>
// ── Tag Input ─────────────────────────────────────────────────────────────────
(function () {
    const tagBox    = document.getElementById('tagBox');
    const typing    = document.getElementById('tagTyping');
    const hiddenIn  = document.getElementById('metaKeywordsInput');
    let tags        = [];

    // validation fail হলে old value restore
    const oldVal = hiddenIn.value.trim();
    if (oldVal) {
        oldVal.split(',').forEach(k => { const t = k.trim(); if (t) addTag(t); });
    }

    function syncHidden() {
        hiddenIn.value = tags.join(',');
    }

    function addTag(text) {
        text = text.trim();
        if (!text || tags.includes(text)) return;
        tags.push(text);

        const chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.innerHTML = `${escHtml(text)}<button type="button" class="tag-chip-rm" title="Remove">&times;</button>`;
        chip.querySelector('.tag-chip-rm').addEventListener('click', () => {
            tags = tags.filter(t => t !== text);
            chip.remove();
            syncHidden();
        });

        tagBox.insertBefore(chip, typing);
        syncHidden();
    }

    function escHtml(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    typing.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(this.value.replace(',',''));
            this.value = '';
        }
        if (e.key === 'Backspace' && this.value === '' && tags.length) {
            const last = tags[tags.length - 1];
            tags.pop();
            tagBox.querySelectorAll('.tag-chip').forEach(c => {
                if (c.textContent.replace('×','').trim() === last) c.remove();
            });
            syncHidden();
        }
    });

    typing.addEventListener('blur', function () {
        if (this.value.trim()) {
            addTag(this.value.replace(',',''));
            this.value = '';
        }
    });

    // paste: "a, b, c" → 3 টা chip
    typing.addEventListener('paste', function (e) {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text');
        pasted.split(',').forEach(k => addTag(k));
        this.value = '';
    });
})();

// ── Image Upload & Preview ────────────────────────────────────────────────────
const imageInput  = document.getElementById('imageInput');
const previewWrap = document.getElementById('previewWrap');
const previewImg  = document.getElementById('previewImg');
const previewName = document.getElementById('previewName');
const uploadZone  = document.getElementById('uploadZone');

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewName.textContent = file.name;
        previewWrap.classList.add('visible');
    };
    reader.readAsDataURL(file);
});
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault(); uploadZone.classList.remove('drag-over');
    if (e.dataTransfer.files.length) { imageInput.files = e.dataTransfer.files; imageInput.dispatchEvent(new Event('change')); }
});
function clearImage() {
    imageInput.value = ''; previewImg.src = ''; previewName.textContent = '';
    previewWrap.classList.remove('visible');
}

// ── AJAX Subcategory ──────────────────────────────────────────────────────────
const catSelect  = document.getElementById('cat-select');
const subSelect  = document.getElementById('sub-select');
const subLoading = document.getElementById('sub-loading');

function loadSubcategories(catId, selectedId = '') {
    subSelect.innerHTML = '<option value="">— Select Sub-Category —</option>';
    subSelect.disabled  = true;
    if (!catId) return;
    subLoading.classList.add('visible');
    fetch(`{{ route('blognewsadd.subcategories') }}?category_id=${catId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        subLoading.classList.remove('visible');
        subSelect.innerHTML = data.length
            ? '<option value="">— Select Sub-Category —</option>'
            : '<option value="">— No Sub-Categories —</option>';
        data.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id; opt.textContent = sub.name;
            if (String(sub.id) === String(selectedId)) opt.selected = true;
            subSelect.appendChild(opt);
        });
        subSelect.disabled = false;
    })
    .catch(() => {
        subLoading.classList.remove('visible');
        subSelect.innerHTML = '<option value="">— Failed to load —</option>';
        subSelect.disabled = false;
    });
}
catSelect.addEventListener('change', function () { loadSubcategories(this.value); });
@if(old('newsblogcategory_id'))
    loadSubcategories('{{ old('newsblogcategory_id') }}', '{{ old('newssubblogcategory_id') }}');
@endif
</script>
@endsection
