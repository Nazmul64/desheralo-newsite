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
        --card:       #ffffff;
        --radius:     12px;
        --shadow:     0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
        --shadow-md:  0 4px 16px rgba(0,0,0,.10);
    }

    .ts-page { padding: 28px 32px; background: var(--bg); min-height: 100vh; }

    .ts-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px;
    }
    .ts-header h1 {
        font-size: 1.5rem; font-weight: 700; color: #111827;
        display: flex; align-items: center; gap: 8px;
    }
    .ts-header h1 span.accent {
        background: var(--brand); color: #fff;
        padding: 2px 10px; border-radius: 6px;
    }
    .btn-add {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--brand); color: #fff;
        padding: 10px 20px; border-radius: 8px; font-weight: 600;
        font-size: .9rem; border: none; cursor: pointer;
        transition: background .2s, transform .15s; text-decoration: none;
    }
    .btn-add:hover { background: var(--brand-dark); transform: translateY(-1px); color: #fff; }

    .ts-toolbar {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .ts-select {
        padding: 9px 14px; border: 1px solid var(--border);
        border-radius: 8px; background: #fff; font-size: .9rem;
        color: #374151; cursor: pointer; outline: none; transition: border-color .2s;
    }
    .ts-select:focus { border-color: var(--brand); }
    .ts-search-wrap {
        flex: 1; display: flex; align-items: center;
        background: #fff; border: 1px solid var(--border);
        border-radius: 8px; overflow: hidden; max-width: 420px;
    }
    .ts-search-wrap input {
        flex: 1; padding: 9px 14px; border: none; outline: none;
        font-size: .9rem; color: #374151;
    }
    .ts-search-wrap button {
        padding: 9px 14px; background: var(--brand); border: none;
        color: #fff; cursor: pointer; transition: background .2s;
    }
    .ts-search-wrap button:hover { background: var(--brand-dark); }

    .bulk-bar {
        display: none; align-items: center; gap: 10px;
        background: #fef3c7; border: 1px solid #fde68a;
        border-radius: 8px; padding: 10px 16px; margin-bottom: 16px;
    }
    .bulk-bar.show { display: flex; }
    .bulk-bar span { font-size: .9rem; font-weight: 600; color: #92400e; }
    .btn-bulk-del {
        padding: 6px 14px; background: var(--danger); color: #fff;
        border: none; border-radius: 6px; font-size: .85rem;
        font-weight: 600; cursor: pointer; transition: opacity .2s;
    }
    .btn-bulk-del:hover { opacity: .85; }

    .ts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .theme-card {
        background: var(--card); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
        transition: box-shadow .25s, transform .2s; position: relative;
    }
    .theme-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }

    .card-check {
        position: absolute; top: 12px; left: 12px; z-index: 10;
        width: 18px; height: 18px; cursor: pointer; accent-color: var(--brand);
    }

    .card-preview {
        height: 180px; overflow: hidden; background: #f3f4f6; position: relative;
    }
    .card-preview img {
        width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease;
    }
    .theme-card:hover .card-preview img { transform: scale(1.04); }
    .card-preview .no-img {
        width: 100%; height: 100%; display: flex; align-items: center;
        justify-content: center; background: linear-gradient(135deg,#e0e7ff,#dbeafe);
        color: var(--brand); font-size: 3rem;
    }

    .status-badge {
        position: absolute; top: 12px; right: 12px;
        padding: 4px 10px; border-radius: 20px; font-size: .75rem;
        font-weight: 700; letter-spacing: .4px; text-transform: uppercase;
    }
    .status-badge.activated   { background:#dcfce7; color:#15803d; }
    .status-badge.deactivated { background:#fee2e2; color:#b91c1c; }

    .card-body { padding: 18px 20px 20px; }
    .card-body h3 { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 6px; }
    .card-meta { font-size: .82rem; color: var(--muted); margin-bottom: 4px; }
    .card-meta span { font-weight: 600; color: #374151; }
    .card-desc {
        font-size: .83rem; color: #6b7280; margin: 10px 0 16px;
        line-height: 1.5; display: -webkit-box;
        -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    .card-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-status {
        flex: 1; padding: 9px 0; border: none; border-radius: 7px;
        font-weight: 700; font-size: .85rem; cursor: pointer;
        transition: opacity .2s, transform .15s; text-align: center;
    }
    .btn-status:hover { opacity: .85; transform: translateY(-1px); }
    .btn-status.activated   { background: var(--success); color: #fff; }
    .btn-status.deactivated { background: var(--danger);  color: #fff; }
    .btn-edit {
        flex: 1; padding: 9px 0; border-radius: 7px;
        background: #eff6ff; color: var(--brand); font-weight: 700;
        font-size: .85rem; text-align: center; text-decoration: none;
        border: 1.5px solid #bfdbfe; transition: background .2s, transform .15s;
        display: inline-block;
    }
    .btn-edit:hover { background: #dbeafe; color: var(--brand); transform: translateY(-1px); }
    .btn-del {
        padding: 9px 14px; border-radius: 7px; background: #fef2f2;
        color: var(--danger); border: 1.5px solid #fecaca; cursor: pointer;
        font-size: .85rem; font-weight: 700; transition: background .2s, transform .15s;
    }
    .btn-del:hover { background: #fee2e2; transform: translateY(-1px); }

    .ts-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 28px; flex-wrap: wrap; gap: 12px;
    }
    .ts-footer .info { font-size: .85rem; color: var(--muted); }
    .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; }
    .pagination .page-item .page-link {
        padding: 7px 13px; border-radius: 7px; font-size: .85rem;
        font-weight: 600; color: var(--brand); background: #fff;
        border: 1.5px solid var(--border); text-decoration: none; transition: all .18s;
    }
    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover {
        background: var(--brand); color: #fff; border-color: var(--brand);
    }

    .ts-alert {
        padding: 12px 18px; border-radius: 8px; margin-bottom: 18px;
        font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: 8px;
    }
    .ts-alert.success { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
    .ts-alert.error   { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }

    .ts-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.45);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; opacity: 0; pointer-events: none; transition: opacity .25s;
    }
    .ts-modal-overlay.open { opacity: 1; pointer-events: all; }
    .ts-modal {
        background: #fff; border-radius: 14px; width: 100%;
        max-width: 680px; box-shadow: 0 20px 60px rgba(0,0,0,.2);
        transform: scale(.95) translateY(20px);
        transition: transform .25s ease, opacity .25s;
        max-height: 90vh; overflow-y: auto;
    }
    .ts-modal-overlay.open .ts-modal { transform: scale(1) translateY(0); }
    .modal-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px 18px; border-bottom: 1px solid var(--border);
        position: sticky; top: 0; background: #fff; z-index: 1;
    }
    .modal-head h2 { font-size: 1.15rem; font-weight: 700; color: #111827; }
    .modal-close {
        width: 32px; height: 32px; display: flex; align-items: center;
        justify-content: center; border-radius: 50%; border: none;
        background: #f3f4f6; cursor: pointer; font-size: 1.1rem;
        color: #6b7280; transition: background .2s;
    }
    .modal-close:hover { background: #e5e7eb; }
    .modal-body { padding: 24px; }
    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: .82rem; font-weight: 600; color: #374151; }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px 13px; border: 1.5px solid var(--border);
        border-radius: 8px; font-size: .9rem; color: #111827;
        outline: none; transition: border-color .2s, box-shadow .2s;
        background: #fff; width: 100%; box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .form-group textarea { resize: vertical; min-height: 90px; }
    .form-error { font-size: .78rem; color: var(--danger); margin-top: 2px; }

    /* Custom select arrow */
    .select-wrap {
        position: relative;
    }
    .select-wrap select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 36px !important;
        cursor: pointer;
    }
    .select-wrap::after {
        content: '';
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%); pointer-events: none;
        width: 0; height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #6b7280;
    }

    .file-wrap {
        display: flex; align-items: center; gap: 10px;
        border: 1.5px solid var(--border); border-radius: 8px;
        overflow: hidden; background: #fff;
    }
    .file-wrap label {
        padding: 9px 14px; background: #f3f4f6; font-size: .85rem;
        font-weight: 600; color: #374151; cursor: pointer; white-space: nowrap;
        border-right: 1.5px solid var(--border); margin: 0;
    }
    .file-wrap label:hover { background: #e5e7eb; }
    .file-wrap input[type="file"] { display: none; }
    .file-name { font-size: .83rem; color: var(--muted); padding: 0 10px; }

    .modal-foot {
        display: flex; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border);
        position: sticky; bottom: 0; background: #fff;
    }
    .btn-cancel {
        padding: 10px 22px; border-radius: 8px; font-weight: 600;
        font-size: .9rem; cursor: pointer;
        border: 1.5px solid var(--danger); color: var(--danger);
        background: #fff; transition: background .2s;
    }
    .btn-cancel:hover { background: #fef2f2; }
    .btn-save {
        padding: 10px 28px; border-radius: 8px; font-weight: 700;
        font-size: .9rem; cursor: pointer; border: none;
        background: var(--brand); color: #fff; transition: background .2s, transform .15s;
    }
    .btn-save:hover { background: var(--brand-dark); transform: translateY(-1px); }

    .ts-empty { text-align: center; padding: 60px 20px; color: var(--muted); }
    .ts-empty .icon { font-size: 3.5rem; margin-bottom: 12px; }
    .ts-empty p { font-size: 1rem; font-weight: 500; }
</style>

<div class="ts-page">

    {{-- Header --}}
    <div class="ts-header">
        <h1><span class="accent">Theme</span> List</h1>
        <button class="btn-add" onclick="openCreateModal()">＋ Add</button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="ts-alert success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ts-alert error">✕ {{ session('error') }}</div>
    @endif

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('themesettings.index') }}" class="ts-toolbar">
        <select name="show" class="ts-select" onchange="this.form.submit()">
            @foreach([5, 10, 25, 50] as $n)
                <option value="{{ $n }}" @selected($perPage == $n)>Show — {{ $n }}</option>
            @endforeach
        </select>
        <div class="ts-search-wrap">
            <input type="text" name="search" placeholder="Search themes…"
                   value="{{ $search }}" autocomplete="off">
            <button type="submit">🔍</button>
        </div>
    </form>

    {{-- Bulk form wraps grid --}}
    <form method="POST" action="{{ route('Themesetting.bulkDestroy') }}" id="bulkForm">
        @csrf @method('DELETE')
        <input type="hidden" name="ids" id="bulkIds">

        <div class="bulk-bar" id="bulkBar">
            <span id="bulkCount">0 selected</span>
            <button type="submit" class="btn-bulk-del"
                    onclick="return confirm('Delete selected themes?')">
                🗑 Delete Selected
            </button>
        </div>

        @if($themes->count())
        <div class="ts-grid">
            @foreach($themes as $theme)
            <div class="theme-card">
                <input type="checkbox" class="card-check bulk-chk"
                       value="{{ $theme->id }}" onchange="syncBulk()">

                <div class="card-preview">
                    @if($theme->image)
                        <img src="{{ asset('uploads/themesettings/' . $theme->image) }}"
                             alt="{{ $theme->title }}">
                    @else
                        <div class="no-img">🎨</div>
                    @endif
                    <span class="status-badge {{ $theme->status }}">
                        {{ ucfirst($theme->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <h3>{{ $theme->title }}</h3>
                    <p class="card-meta">Author: <span>{{ $theme->author }}</span></p>
                    <p class="card-meta">Version: <span>{{ $theme->version }}</span></p>
                    @if($theme->description)
                        <p class="card-desc">{{ $theme->description }}</p>
                    @endif

                    <div class="card-actions">
                        <form method="POST"
                              action="{{ route('Themesetting.toggleStatus', $theme->id) }}"
                              style="flex:1">
                            @csrf
                            <button type="submit"
                                    class="btn-status {{ $theme->status }} w-100">
                                {{ $theme->isActivated() ? '✓ Activated' : '✕ Deactivated' }}
                            </button>
                        </form>

                        <a href="{{ route('themesettings.edit', $theme->id) }}"
                           class="btn-edit">✏ Edit</a>

                        <form method="POST"
                              action="{{ route('themesettings.destroy', $theme->id) }}"
                              onsubmit="return confirm('Delete this theme?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del">🗑</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="ts-empty">
            <div class="icon">🎨</div>
            <p>No themes found. Add your first theme!</p>
        </div>
        @endif
    </form>

    {{-- Pagination --}}
    @if($themes->hasPages())
    <div class="ts-footer">
        <span class="info">
            Showing {{ $themes->firstItem() }}–{{ $themes->lastItem() }}
            of {{ $themes->total() }} themes
        </span>
        {{ $themes->links() }}
    </div>
    @endif

</div>

{{-- ══════════════ CREATE MODAL ══════════════ --}}
<div class="ts-modal-overlay" id="createModal">
    <div class="ts-modal">
        <div class="modal-head">
            <h2>Create Theme</h2>
            <button class="modal-close" onclick="closeCreateModal()">✕</button>
        </div>

        <form method="POST" action="{{ route('themesettings.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="modal-grid">

                    {{-- Title --}}
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Enter title">
                        @error('title')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Author --}}
                    <div class="form-group">
                        <label>Author *</label>
                        <input type="text" name="author" value="{{ old('author') }}"
                               placeholder="Enter author">
                        @error('author')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Version --}}
                    <div class="form-group">
                        <label>Version *</label>
                        <input type="text" name="version" value="{{ old('version') }}"
                               placeholder="e.g. 1.0.0">
                        @error('version')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- ✅ Footer Dropdown (Home Page সরানো হয়েছে) --}}
                    <div class="form-group">
                        <label>Choose Footer</label>
                        <div class="select-wrap">
                            <select name="footer_name">
                                <option value="">Select footer</option>
                                @foreach(['Footer 1','Footer 2','Footer 3','Footer 4','Footer 5','Footer 6','Footer 7'] as $footer)
                                    <option value="{{ $footer }}"
                                        {{ old('footer_name') == $footer ? 'selected' : '' }}>
                                        {{ $footer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('footer_name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Image --}}
                    <div class="form-group full">
                        <label>Image</label>
                        <div class="file-wrap">
                            <label for="createImage">Choose file</label>
                            <input type="file" id="createImage" name="image"
                                   accept="image/*"
                                   onchange="showFileName(this,'createFileName')">
                            <span class="file-name" id="createFileName">No file chosen</span>
                        </div>
                        @error('image')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label>Description</label>
                        <textarea name="description"
                                  placeholder="Theme description…">{{ old('description') }}</textarea>
                    </div>

                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="btn-save">💾 Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal
    function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
    function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }
    document.getElementById('createModal').addEventListener('click', function(e) {
        if (e.target === this) closeCreateModal();
    });

    // Auto-open on validation error
    @if($errors->any())
        openCreateModal();
    @endif

    // File name
    function showFileName(input, spanId) {
        document.getElementById(spanId).textContent =
            input.files[0] ? input.files[0].name : 'No file chosen';
    }

    // Bulk select — ✅ JSON array পাঠানো হচ্ছে string না
    function syncBulk() {
        const checked = Array.from(document.querySelectorAll('.bulk-chk:checked'));
        document.getElementById('bulkIds').value = JSON.stringify(checked.map(c => c.value));
        document.getElementById('bulkCount').textContent = checked.length + ' selected';
        document.getElementById('bulkBar').classList.toggle('show', checked.length > 0);
    }

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.ts-alert').forEach(el => {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
</script>
@endsection
