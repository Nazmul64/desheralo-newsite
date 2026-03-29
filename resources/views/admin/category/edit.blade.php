@extends('admin.master')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="cf-wrap">

    {{-- Header --}}
    <div class="cf-header">
        <div class="cf-title-block">
            <div class="cf-icon-badge">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <h4 class="cf-title">Edit Category</h4>
                <p class="cf-subtitle">Update: <strong>{{ $category->name }}</strong></p>
            </div>
        </div>
        <a href="{{ route('newscategories.index') }}" class="cf-btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"/></svg>
            Back to List
        </a>
    </div>

    <div class="cf-layout">

        {{-- Form Card --}}
        <div class="cf-card">
            <div class="cf-card-header">
                <span class="cf-card-title">Edit Details</span>
                <span class="cf-card-id"># ID: {{ $category->id }}</span>
            </div>
            <div class="cf-card-body">

                <form action="{{ route('newscategories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="cf-field">
                        <label class="cf-label">Category Name <span class="cf-required">*</span></label>
                        <input type="text" name="name" id="nameInput"
                               value="{{ old('name', $category->name) }}"
                               class="cf-input @error('name') cf-input-err @enderror"
                               placeholder="Enter category name"
                               oninput="liveSlug(this.value)">
                        @error('name')
                            <span class="cf-err-msg">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="cf-field">
                        <label class="cf-label">
                            Slug
                            <span class="cf-badge-auto">Auto-generated</span>
                        </label>
                        <div class="cf-input-slug-wrap">
                            <span class="cf-slug-prefix">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            </span>
                            <input type="text" value="{{ $category->slug }}" class="cf-input cf-input-slug" readonly>
                        </div>
                        <small class="cf-hint">Slug will update automatically when you save.</small>
                    </div>

                    {{-- Image --}}
                    <div class="cf-field">
                        <label class="cf-label">Category Image <span class="cf-optional">Optional</span></label>

                        <div class="cf-upload-area" id="uploadArea" onclick="document.getElementById('imageInput').click()">
                            @if($category->image)
                                <div class="cf-upload-preview" id="uploadPreview">
                                    <img id="imagePreview" src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="cf-preview-img">
                                    <div class="cf-preview-overlay">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                                        Change Image
                                    </div>
                                </div>
                                <div class="cf-upload-placeholder" id="uploadPlaceholder" style="display:none;">
                            @else
                                <div class="cf-upload-preview" id="uploadPreview" style="display:none;">
                                    <img id="imagePreview" src="" alt="Preview" class="cf-preview-img">
                                    <div class="cf-preview-overlay">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                                        Change Image
                                    </div>
                                </div>
                                <div class="cf-upload-placeholder" id="uploadPlaceholder">
                            @endif
                                    <div class="cf-upload-icon">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                    <p class="cf-upload-text">Click to upload new image</p>
                                    <p class="cf-upload-hint">JPG, PNG, WEBP — Max 2MB</p>
                                </div>
                        </div>

                        <input type="file" name="image" id="imageInput" accept="image/*"
                               class="cf-file-hidden @error('image') cf-input-err @enderror"
                               onchange="previewImage(this)">
                        @error('image')
                            <span class="cf-err-msg">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                        <small class="cf-hint">Leave empty to keep the current image.</small>
                    </div>

                    {{-- Menu Publish --}}
                    <div class="cf-field">
                        <label class="cf-label">Menu Publish</label>
                        <div class="cf-toggle-row">
                            <label class="cf-toggle">
                                <input type="checkbox" name="menu_publish" id="menuPublish"
                                       {{ $category->menu_publish ? 'checked' : '' }}>
                                <span class="cf-toggle-track"><span class="cf-toggle-thumb"></span></span>
                            </label>
                            <div class="cf-toggle-text">
                                <span class="cf-toggle-status" id="toggleStatus"
                                      style="color: {{ $category->menu_publish ? '#2563eb' : '#9ca3af' }}">
                                    {{ $category->menu_publish ? 'Published' : 'Hidden' }}
                                </span>
                                <span class="cf-toggle-desc">Category will appear in the navigation menu</span>
                            </div>
                        </div>
                    </div>

                    <div class="cf-divider"></div>

                    {{-- Actions --}}
                    <div class="cf-actions">
                        <button type="submit" class="cf-btn-primary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Update Category
                        </button>
                        <a href="{{ route('newscategories.index') }}" class="cf-btn-cancel">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

        {{-- Info + Danger Zone --}}
        <div class="cf-sidebar">
            <div class="cf-tips-card">
                <div class="cf-tips-header">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Tips
                </div>
                <ul class="cf-tips-list">
                    <li>Use a short, descriptive name for the category.</li>
                    <li>Slug will auto-update when you save.</li>
                    <li>Recommended image: <strong>400×400px</strong>.</li>
                    <li>Disable Menu Publish to hide from navigation.</li>
                </ul>
            </div>

            {{-- Danger Zone --}}
            <div class="cf-danger-card">
                <div class="cf-danger-header">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Danger Zone
                </div>
                <p class="cf-danger-text">Deleting this category is permanent and cannot be undone.</p>
                <form action="{{ route('newscategories.destroy', $category->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this category? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="cf-btn-delete">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Delete Category
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
* { box-sizing: border-box; }

.cf-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px;
    background: #f5f6fa;
    min-height: 100vh;
}

.cf-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
}
.cf-title-block { display: flex; align-items: center; gap: 12px; }
.cf-icon-badge {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; box-shadow: 0 4px 12px rgba(124,58,237,.28); flex-shrink: 0;
}
.cf-title { font-size: 17px; font-weight: 700; color: #111827; margin: 0; line-height: 1.2; }
.cf-subtitle { font-size: 12px; color: #9ca3af; margin: 0; margin-top: 2px; }
.cf-subtitle strong { color: #7c3aed; }

.cf-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500; color: #374151;
    background: #fff; border: 1px solid #e5e7eb;
    padding: 8px 14px; border-radius: 8px; text-decoration: none;
    transition: all .15s; box-shadow: 0 1px 2px rgba(0,0,0,.05);
}
.cf-btn-back:hover { background: #f9fafb; color: #111827; text-decoration:none; }

.cf-layout { display: grid; grid-template-columns: 1fr 260px; gap: 20px; align-items: start; }
@media(max-width:768px) { .cf-layout { grid-template-columns: 1fr; } }

.cf-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
}
.cf-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px;
    border-bottom: 1px solid #f3f4f6; background: #fafafa;
}
.cf-card-title { font-size: 13px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .05em; }
.cf-card-id { font-size: 12px; font-weight: 500; color: #9ca3af; background: #f3f4f6; padding: 3px 9px; border-radius: 10px; }
.cf-card-body { padding: 24px 22px; }

.cf-field { margin-bottom: 22px; }
.cf-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px;
}
.cf-required { color: #ef4444; }
.cf-optional { font-size: 11px; font-weight: 500; color: #9ca3af; background: #f3f4f6; padding: 2px 7px; border-radius: 10px; }
.cf-badge-auto { font-size: 11px; font-weight: 500; color: #7c3aed; background: #f5f3ff; padding: 2px 8px; border-radius: 10px; }

.cf-input {
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 100%; font-size: 13.5px; color: #111827;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    padding: 10px 13px; outline: none;
    transition: border-color .15s, box-shadow .15s; background: #fff;
}
.cf-input:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,.10); }
.cf-input::placeholder { color: #c0c4ce; }
.cf-input-err { border-color: #fca5a5 !important; }
.cf-input-slug-wrap { position: relative; }
.cf-slug-prefix {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; pointer-events: none;
}
.cf-input-slug { padding-left: 32px; background: #f9fafb; color: #9ca3af; cursor: not-allowed; }
.cf-hint { font-size: 12px; color: #9ca3af; display: block; margin-top: 4px; }
.cf-err-msg { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #dc2626; margin-top: 5px; }

.cf-upload-area {
    border: 2px dashed #e5e7eb; border-radius: 10px;
    cursor: pointer; transition: all .2s; overflow: hidden; background: #fafafa;
}
.cf-upload-area:hover { border-color: #c4b5fd; background: #faf5ff; }
.cf-upload-placeholder { display: flex; flex-direction: column; align-items: center; padding: 28px 20px; gap: 6px; }
.cf-upload-icon { color: #d1d5db; }
.cf-upload-area:hover .cf-upload-icon { color: #7c3aed; }
.cf-upload-text { font-size: 13px; font-weight: 600; color: #6b7280; margin: 0; }
.cf-upload-hint { font-size: 11.5px; color: #9ca3af; margin: 0; }
.cf-file-hidden { display: none; }
.cf-upload-preview { position: relative; width: 100%; }
.cf-preview-img { width: 100%; height: 140px; object-fit: cover; display: block; }
.cf-preview-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.4); color: #fff;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    font-size: 13px; font-weight: 600; opacity: 0; transition: opacity .2s;
}
.cf-upload-area:hover .cf-preview-overlay { opacity: 1; }

.cf-toggle-row { display: flex; align-items: center; gap: 12px; }
.cf-toggle { display: inline-flex; cursor: pointer; }
.cf-toggle input { display: none; }
.cf-toggle-track { width: 44px; height: 24px; background: #e5e7eb; border-radius: 20px; position: relative; transition: background .2s; flex-shrink: 0; }
.cf-toggle input:checked ~ .cf-toggle-track { background: #7c3aed; }
.cf-toggle-thumb { width: 17px; height: 17px; background: #fff; border-radius: 50%; position: absolute; top: 3.5px; left: 3.5px; transition: transform .2s; box-shadow: 0 1px 4px rgba(0,0,0,.2); }
.cf-toggle input:checked ~ .cf-toggle-track .cf-toggle-thumb { transform: translateX(20px); }
.cf-toggle-status { display: block; font-size: 13px; font-weight: 600; }
.cf-toggle-desc { display: block; font-size: 12px; color: #9ca3af; margin-top: 1px; }

.cf-divider { height: 1px; background: #f3f4f6; margin: 4px 0 22px; }

.cf-actions { display: flex; align-items: center; gap: 10px; }
.cf-btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px; font-weight: 600;
    padding: 10px 22px; border-radius: 8px; border: none; cursor: pointer;
    box-shadow: 0 4px 12px rgba(124,58,237,.30); transition: all .2s;
}
.cf-btn-primary:hover { background: linear-gradient(135deg, #6d28d9, #7c3aed); transform: translateY(-1px); }
.cf-btn-cancel {
    font-size: 13px; font-weight: 500; color: #6b7280; text-decoration: none;
    padding: 10px 18px; border: 1px solid #e5e7eb; border-radius: 8px;
    background: #fff; transition: all .15s;
}
.cf-btn-cancel:hover { background: #f9fafb; color: #374151; text-decoration:none; }

/* Sidebar */
.cf-sidebar { display: flex; flex-direction: column; gap: 16px; }

.cf-tips-card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,.06); overflow: hidden; }
.cf-tips-header { display: flex; align-items: center; gap: 7px; padding: 14px 18px; background: #f5f3ff; font-size: 13px; font-weight: 700; color: #7c3aed; border-bottom: 1px solid #ede9fe; }
.cf-tips-list { padding: 16px 18px; margin: 0; list-style: none; display: flex; flex-direction: column; gap: 10px; }
.cf-tips-list li { font-size: 12.5px; color: #6b7280; padding-left: 14px; position: relative; line-height: 1.5; }
.cf-tips-list li::before { content: '·'; position: absolute; left: 0; color: #7c3aed; font-size: 18px; line-height: 1; }
.cf-tips-list strong { color: #374151; }

.cf-danger-card { background: #fff; border-radius: 12px; border: 1px solid #fecaca; overflow: hidden; }
.cf-danger-header { display: flex; align-items: center; gap: 7px; padding: 14px 18px; background: #fef2f2; font-size: 13px; font-weight: 700; color: #dc2626; border-bottom: 1px solid #fecaca; }
.cf-danger-text { font-size: 12.5px; color: #6b7280; padding: 14px 18px 10px; margin: 0; line-height: 1.5; }
.cf-btn-delete {
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: inline-flex; align-items: center; gap: 7px;
    background: #fef2f2; color: #dc2626;
    border: 1.5px solid #fecaca; font-size: 13px; font-weight: 600;
    padding: 9px 16px; border-radius: 7px; cursor: pointer;
    margin: 0 18px 16px; transition: all .15s; width: calc(100% - 36px);
    justify-content: center;
}
.cf-btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }
</style>

<script>
function previewImage(input) {
    const placeholder = document.getElementById('uploadPlaceholder');
    const preview = document.getElementById('uploadPreview');
    const img = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            placeholder.style.display = 'none';
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('menuPublish').addEventListener('change', function() {
    const status = document.getElementById('toggleStatus');
    status.textContent = this.checked ? 'Published' : 'Hidden';
    status.style.color = this.checked ? '#7c3aed' : '#9ca3af';
});
</script>

@endsection
