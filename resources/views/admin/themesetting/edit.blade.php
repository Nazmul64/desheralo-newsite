@extends('admin.master')
@section('content')
<style>
    :root {
        --brand:      #2563eb;
        --brand-dark: #1d4ed8;
        --success:    #16a34a;
        --danger:     #dc2626;
        --muted:      #6b7280;
        --border:     #e5e7eb;
        --bg:         #f9fafb;
        --radius:     12px;
        --shadow:     0 1px 3px rgba(0,0,0,.08);
        --shadow-md:  0 4px 20px rgba(0,0,0,.10);
    }

    .ts-page { padding: 28px 32px; background: var(--bg); min-height: 100vh; }

    /* breadcrumb */
    .ts-breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: .84rem; color: var(--muted); margin-bottom: 20px;
    }
    .ts-breadcrumb a { color: var(--brand); text-decoration: none; font-weight: 600; }
    .ts-breadcrumb a:hover { text-decoration: underline; }
    .ts-breadcrumb span { color: #9ca3af; }

    /* header */
    .ts-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 28px;
    }
    .ts-header h1 {
        font-size: 1.4rem; font-weight: 700; color: #111827;
        display: flex; align-items: center; gap: 8px;
    }
    .ts-header h1 .accent {
        background: var(--brand); color: #fff;
        padding: 2px 10px; border-radius: 6px;
    }
    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; border-radius: 8px; font-weight: 600;
        font-size: .88rem; text-decoration: none;
        border: 1.5px solid var(--border); color: #374151;
        background: #fff; transition: background .2s, border-color .2s;
    }
    .btn-back:hover { background: #f3f4f6; color: #111827; border-color: #d1d5db; }

    /* card */
    .edit-card {
        background: #fff; border-radius: var(--radius);
        box-shadow: var(--shadow-md); overflow: hidden;
        max-width: 860px; margin: 0 auto;
    }
    .card-band {
        height: 5px;
        background: linear-gradient(90deg, var(--brand), #818cf8);
    }
    .card-inner { padding: 32px 36px; }

    /* form grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: .82rem; font-weight: 700; color: #374151; }
    .form-group label .req { color: var(--danger); margin-left: 2px; }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 11px 14px; border: 1.5px solid var(--border);
        border-radius: 9px; font-size: .9rem; color: #111827;
        outline: none; transition: border-color .2s, box-shadow .2s;
        background: #fff; width: 100%; box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .form-group textarea { resize: vertical; min-height: 110px; }
    .form-error { font-size: .78rem; color: var(--danger); }

    /* image section */
    .img-section {
        display: flex; gap: 20px; align-items: flex-start;
        padding: 18px; background: #f8faff;
        border: 1.5px dashed #bfdbfe; border-radius: 10px;
    }
    .current-img {
        width: 110px; height: 80px; border-radius: 8px;
        object-fit: cover; border: 2px solid var(--border);
        flex-shrink: 0;
    }
    .no-img-box {
        width: 110px; height: 80px; border-radius: 8px;
        background: linear-gradient(135deg,#e0e7ff,#dbeafe);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; flex-shrink: 0;
    }
    .img-upload { flex: 1; }
    .img-upload p { font-size: .82rem; color: var(--muted); margin-bottom: 8px; }
    .file-wrap {
        display: flex; align-items: center; gap: 0;
        border: 1.5px solid var(--border); border-radius: 8px; overflow: hidden;
    }
    .file-wrap label {
        padding: 9px 14px; background: #f3f4f6; font-size: .84rem;
        font-weight: 600; color: #374151; cursor: pointer;
        border-right: 1.5px solid var(--border); margin: 0;
        white-space: nowrap;
    }
    .file-wrap label:hover { background: #e5e7eb; }
    .file-wrap input[type="file"] { display: none; }
    .file-name { font-size: .82rem; color: var(--muted); padding: 0 12px; }

    /* status toggle */
    .status-row { display: flex; align-items: center; gap: 14px; }
    .status-toggle {
        display: flex; gap: 0; border-radius: 8px; overflow: hidden;
        border: 1.5px solid var(--border);
    }
    .status-toggle input { display: none; }
    .status-toggle label {
        padding: 9px 20px; font-size: .85rem; font-weight: 700;
        cursor: pointer; transition: background .2s, color .2s; margin: 0;
        background: #fff; color: var(--muted);
    }
    .status-toggle input:checked + label.activate   { background: var(--success); color: #fff; }
    .status-toggle input:checked + label.deactivate { background: var(--danger);  color: #fff; }

    /* footer actions */
    .card-foot {
        display: flex; justify-content: flex-end; gap: 12px;
        padding: 20px 36px; border-top: 1px solid var(--border);
        background: #f9fafb;
    }
    .btn-cancel {
        padding: 11px 24px; border-radius: 8px; font-weight: 600;
        font-size: .9rem; cursor: pointer;
        border: 1.5px solid var(--danger); color: var(--danger);
        background: #fff; text-decoration: none;
        transition: background .2s;
    }
    .btn-cancel:hover { background: #fef2f2; color: var(--danger); }
    .btn-save {
        padding: 11px 32px; border-radius: 8px; font-weight: 700;
        font-size: .9rem; cursor: pointer; border: none;
        background: var(--brand); color: #fff;
        transition: background .2s, transform .15s;
    }
    .btn-save:hover { background: var(--brand-dark); transform: translateY(-1px); }

    /* alert */
    .ts-alert {
        padding: 12px 18px; border-radius: 8px; margin-bottom: 18px;
        font-size: .9rem; font-weight: 600;
    }
    .ts-alert.success { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
    .ts-alert.error   { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }
</style>


@section('content')
<div class="ts-page">

    {{-- Breadcrumb --}}
    <nav class="ts-breadcrumb">
        <a href="{{ route('themesettings.index') }}">Theme List</a>
        <span>/</span>
        <span>Edit Theme</span>
    </nav>

    {{-- Header --}}
    <div class="ts-header">
        <h1><span class="accent">Edit</span> Theme</h1>
        <a href="{{ route('themesettings.index') }}" class="btn-back">← Back</a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="ts-alert success">✓ {{ session('success') }}</div>
    @endif

    {{-- Form Card --}}
    <div class="edit-card">
        <div class="card-band"></div>

        <form method="POST" action="{{ route('themesettings.update', $theme->id) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="card-inner">
                <div class="form-grid">

                    <div class="form-group">
                        <label>Title <span class="req">*</span></label>
                        <input type="text" name="title"
                               value="{{ old('title', $theme->title) }}"
                               placeholder="Enter title">
                        @error('title')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Author <span class="req">*</span></label>
                        <input type="text" name="author"
                               value="{{ old('author', $theme->author) }}"
                               placeholder="Enter author">
                        @error('author')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Version <span class="req">*</span></label>
                        <input type="text" name="version"
                               value="{{ old('version', $theme->version) }}"
                               placeholder="e.g. 1.0.0">
                        @error('version')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Choose Home Page</label>
                        <select name="home_page_id">
                            <option value="">Select page</option>
                            {{-- @foreach($pages as $page)
                            <option value="{{ $page->id }}"
                                {{ $theme->home_page_id == $page->id ? 'selected' : '' }}>
                                {{ $page->name }}
                            </option>
                            @endforeach --}}
                        </select>
                    </div>

                    {{-- Image --}}
                    <div class="form-group full">
                        <label>Image</label>
                        <div class="img-section">
                            @if($theme->image)
                                <img class="current-img"
                                     src="{{ asset('uploads/themesettings/' . $theme->image) }}"
                                     alt="Current image" id="previewImg">
                            @else
                                <div class="no-img-box" id="previewBox">🎨</div>
                            @endif

                            <div class="img-upload">
                                <p>Current image kept unless you choose a new one.</p>
                                <div class="file-wrap">
                                    <label for="editImage">Choose file</label>
                                    <input type="file" id="editImage" name="image"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <span class="file-name" id="editFileName">No file chosen</span>
                                </div>
                                @error('image')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group full">
                        <label>Status</label>
                        <div class="status-row">
                            <div class="status-toggle">
                                <input type="radio" name="status" id="st_activated"
                                       value="activated"
                                       {{ old('status', $theme->status) === 'activated' ? 'checked' : '' }}>
                                <label for="st_activated" class="activate">✓ Activated</label>

                                <input type="radio" name="status" id="st_deactivated"
                                       value="deactivated"
                                       {{ old('status', $theme->status) === 'deactivated' ? 'checked' : '' }}>
                                <label for="st_deactivated" class="deactivate">✕ Deactivated</label>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label>Description</label>
                        <textarea name="description"
                                  placeholder="Theme description…">{{ old('description', $theme->description) }}</textarea>
                    </div>

                </div>
            </div>

            <div class="card-foot">
                <a href="{{ route('themesettings.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">💾 Update Theme</button>
            </div>
        </form>
    </div>

</div>



<script>
    function previewImage(input) {
        if (!input.files[0]) return;
        document.getElementById('editFileName').textContent = input.files[0].name;

        const reader = new FileReader();
        reader.onload = function(e) {
            let img = document.getElementById('previewImg');
            const box = document.getElementById('previewBox');
            if (!img) {
                img = document.createElement('img');
                img.id = 'previewImg';
                img.className = 'current-img';
                if (box) box.replaceWith(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
