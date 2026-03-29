@extends('admin.master')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="cat-wrap">

    {{-- Page Header --}}
    <div class="cat-header">
        <div class="cat-header-left">
            <div class="cat-title-block">
                <div class="cat-icon-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                </div>
                <div>
                    <h4 class="cat-title">Category List</h4>
                    <p class="cat-subtitle">Manage your news categories</p>
                </div>
            </div>
        </div>
        <a href="{{ route('newscategories.create') }}" class="cat-btn-add">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="cat-alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()" class="cat-alert-close">&times;</button>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="cat-card">

        {{-- Toolbar --}}
        <div class="cat-toolbar">
            <div class="cat-toolbar-left">
                <select class="cat-select"
                        onchange="window.location.href='?per_page='+this.value+'&search={{ request('search') }}'">
                    @foreach([10, 25, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                            Show {{ $size }}
                        </option>
                    @endforeach
                </select>
                <span class="cat-count-badge">
                    {{ $categories->total() }} total
                </span>

                {{-- Bulk Delete Button (hidden by default) --}}
                <button type="button" id="bulkDeleteBtn" class="cat-btn-bulk-delete" style="display:none;" onclick="confirmBulkDelete()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            </div>

            <form action="{{ route('newscategories.index') }}" method="GET" class="cat-search-form">
                <div class="cat-search-wrap">
                    <svg class="cat-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="cat-search-input" placeholder="Search categories...">
                    <button type="submit" class="cat-search-btn">Search</button>
                </div>
            </form>
        </div>

        {{-- Bulk Delete Form (hidden) --}}
        <form id="bulkDeleteForm" action="{{ route('newscategories.bulkDestroy') }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
            <div id="bulkIdsContainer"></div>
        </form>

        {{-- Table --}}
        <div class="cat-table-wrap">
            <table class="cat-table">
                <thead>
                    <tr>
                        <th style="width:44px;">
                            <input type="checkbox" class="cat-check" id="selectAll">
                        </th>
                        <th style="width:56px;">SL.</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="width:90px;">Image</th>
                        <th style="width:130px;">Menu Publish</th>
                        <th style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr class="cat-row">
                        <td>
                            <input type="checkbox" class="cat-check row-check" value="{{ $category->id }}">
                        </td>
                        <td>
                            <span class="cat-sl">{{ $categories->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <span class="cat-name">{{ $category->name }}</span>
                        </td>
                        <td>
                            <code class="cat-slug">{{ $category->slug }}</code>
                        </td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="cat-img">
                            @else
                                <div class="cat-no-img">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <label class="cat-toggle">
                                <input class="toggle-publish" type="checkbox" data-id="{{ $category->id }}"
                                       {{ $category->menu_publish ? 'checked' : '' }}>
                                <span class="cat-toggle-track">
                                    <span class="cat-toggle-thumb"></span>
                                </span>
                                <span class="cat-toggle-label">{{ $category->menu_publish ? 'Published' : 'Hidden' }}</span>
                            </label>
                        </td>
                        <td>
                            <div class="cat-actions">
                                <a href="{{ route('newscategories.edit', $category->id) }}" class="cat-action-btn cat-edit-btn" title="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('newscategories.destroy', $category->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this category?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="cat-action-btn cat-del-btn" title="Delete">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="cat-empty">
                                <div class="cat-empty-icon">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                </div>
                                <p class="cat-empty-text">No categories found</p>
                                <a href="{{ route('newscategories.create') }}" class="cat-btn-add" style="margin-top:12px;">Create first category</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($categories->hasPages())
        <div class="cat-pagination">
            {{ $categories->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>

{{-- Confirm Modal --}}
<div id="bulkDeleteModal" class="cat-modal-overlay" style="display:none;">
    <div class="cat-modal">
        <div class="cat-modal-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
        </div>
        <h3 class="cat-modal-title">Delete Selected Categories?</h3>
        <p class="cat-modal-msg">You are about to delete <strong id="modalCount">0</strong> selected categories. This action cannot be undone.</p>
        <div class="cat-modal-actions">
            <button type="button" class="cat-modal-cancel" onclick="closeModal()">Cancel</button>
            <button type="button" class="cat-modal-confirm" onclick="submitBulkDelete()">Yes, Delete All</button>
        </div>
    </div>
</div>

<style>
* { box-sizing: border-box; }

.cat-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 28px;
    background: #f5f6fa;
    min-height: 100vh;
}

/* Header */
.cat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}
.cat-header-left { display: flex; align-items: center; }
.cat-title-block { display: flex; align-items: center; gap: 12px; }
.cat-icon-badge {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    box-shadow: 0 4px 12px rgba(37,99,235,.28);
    flex-shrink: 0;
}
.cat-title { font-size: 17px; font-weight: 700; color: #111827; margin: 0; line-height: 1.2; }
.cat-subtitle { font-size: 12px; color: #9ca3af; margin: 0; margin-top: 2px; }

.cat-btn-add {
    display: inline-flex; align-items: center; gap: 7px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff; font-size: 13px; font-weight: 600;
    padding: 9px 18px; border-radius: 8px; text-decoration: none;
    box-shadow: 0 4px 12px rgba(37,99,235,.30);
    transition: all .2s;
    border: none; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cat-btn-add:hover { background: linear-gradient(135deg, #1d4ed8, #2563eb); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,.38); color:#fff; text-decoration:none; }

/* Alert */
.cat-alert {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    color: #16a34a; font-size: 13px; font-weight: 500;
    padding: 12px 16px; border-radius: 8px; margin-bottom: 18px;
}
.cat-alert svg { flex-shrink: 0; }
.cat-alert-close { margin-left: auto; background: none; border: none; font-size: 18px; cursor: pointer; color: #16a34a; line-height: 1; padding: 0; }

/* Card */
.cat-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
}

/* Toolbar */
.cat-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
    gap: 12px;
    flex-wrap: wrap;
}
.cat-toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.cat-select {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; color: #374151; font-weight: 500;
    border: 1px solid #e5e7eb; border-radius: 7px;
    padding: 7px 10px; background: #f9fafb; cursor: pointer;
    outline: none;
}
.cat-select:focus { border-color: #3b82f6; }

.cat-count-badge {
    font-size: 12px; color: #6b7280; font-weight: 500;
    background: #f3f4f6; border-radius: 20px;
    padding: 4px 10px;
}

/* Bulk Delete Button */
.cat-btn-bulk-delete {
    display: inline-flex; align-items: center; gap: 7px;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff; font-size: 13px; font-weight: 600;
    padding: 8px 16px; border-radius: 8px;
    border: none; cursor: pointer;
    box-shadow: 0 4px 12px rgba(220,38,38,.28);
    transition: all .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    animation: fadeInScale .2s ease;
}
.cat-btn-bulk-delete:hover {
    background: linear-gradient(135deg, #b91c1c, #dc2626);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(220,38,38,.38);
}
@keyframes fadeInScale {
    from { opacity: 0; transform: scale(.92); }
    to   { opacity: 1; transform: scale(1); }
}

.cat-search-form {}
.cat-search-wrap {
    display: flex; align-items: center;
    border: 1px solid #e5e7eb; border-radius: 8px;
    background: #f9fafb; overflow: hidden;
    transition: border-color .2s;
    width: 260px;
}
.cat-search-wrap:focus-within { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
.cat-search-icon { margin: 0 10px; color: #9ca3af; flex-shrink: 0; }
.cat-search-input {
    flex: 1; border: none; background: transparent;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; color: #374151; outline: none;
    padding: 8px 0;
}
.cat-search-input::placeholder { color: #c0c4ce; }
.cat-search-btn {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #2563eb; color: #fff;
    border: none; font-size: 12.5px; font-weight: 600;
    padding: 9px 14px; cursor: pointer;
    transition: background .2s;
}
.cat-search-btn:hover { background: #1d4ed8; }

/* Table */
.cat-table-wrap { overflow-x: auto; }
.cat-table { width: 100%; border-collapse: collapse; }
.cat-table thead tr { border-bottom: 1px solid #f0f1f3; }
.cat-table thead th {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11.5px; font-weight: 700;
    color: #6b7280; text-transform: uppercase; letter-spacing: .06em;
    padding: 12px 16px; text-align: left;
    background: #fafafa; white-space: nowrap;
}
.cat-table thead th:nth-child(n+3) { text-align: center; }

.cat-row { transition: background .15s; }
.cat-row:hover { background: #f8faff; }
.cat-row.selected-row { background: #eff6ff; }
.cat-row td {
    font-size: 13px; color: #374151;
    padding: 11px 16px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.cat-row:last-child td { border-bottom: none; }
.cat-row td:nth-child(n+3) { text-align: center; }

.cat-check {
    width: 15px; height: 15px; cursor: pointer;
    accent-color: #2563eb; border-radius: 4px;
}

.cat-sl {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px;
    background: #f3f4f6; border-radius: 6px;
    font-size: 12px; font-weight: 600; color: #6b7280;
}

.cat-name { font-weight: 600; color: #111827; font-size: 13.5px; }

.cat-slug {
    font-family: 'Courier New', monospace;
    font-size: 11.5px; color: #6b7280;
    background: #f3f4f6; padding: 3px 8px; border-radius: 5px;
    border: none; display: inline-block;
}

.cat-img {
    width: 40px; height: 40px; object-fit: cover;
    border-radius: 8px; border: 1.5px solid #e5e7eb;
    display: inline-block;
}
.cat-no-img {
    width: 40px; height: 40px;
    background: #f3f4f6; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    color: #d1d5db;
    margin: 0 auto;
}

/* Toggle */
.cat-toggle { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; }
.cat-toggle input { display: none; }
.cat-toggle-track {
    width: 38px; height: 21px;
    background: #e5e7eb; border-radius: 20px;
    position: relative; transition: background .2s;
    flex-shrink: 0;
}
.cat-toggle input:checked ~ .cat-toggle-track { background: #2563eb; }
.cat-toggle-thumb {
    width: 15px; height: 15px;
    background: #fff; border-radius: 50%;
    position: absolute; top: 3px; left: 3px;
    transition: transform .2s;
    box-shadow: 0 1px 4px rgba(0,0,0,.18);
}
.cat-toggle input:checked ~ .cat-toggle-track .cat-toggle-thumb { transform: translateX(17px); }
.cat-toggle-label { font-size: 12px; font-weight: 500; color: #6b7280; }
.cat-toggle input:checked ~ .cat-toggle-label { color: #2563eb; }

/* Actions */
.cat-actions { display: inline-flex; align-items: center; gap: 5px; }
.cat-action-btn {
    width: 32px; height: 32px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid #e5e7eb; background: #fff;
    cursor: pointer; transition: all .15s; text-decoration: none;
    color: #6b7280;
}
.cat-edit-btn:hover { background: #eff6ff; border-color: #bfdbfe; color: #2563eb; }
.cat-del-btn:hover { background: #fef2f2; border-color: #fecaca; color: #dc2626; }

/* Empty */
.cat-empty {
    display: flex; flex-direction: column; align-items: center;
    padding: 56px 20px; color: #9ca3af;
}
.cat-empty-icon {
    width: 68px; height: 68px; border-radius: 16px;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px;
    color: #d1d5db;
}
.cat-empty-text { font-size: 14px; font-weight: 500; color: #9ca3af; margin: 0; }

/* Pagination */
.cat-pagination {
    padding: 14px 20px;
    border-top: 1px solid #f3f4f6;
}
.cat-pagination .pagination { margin: 0; }

/* Modal Overlay */
.cat-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    display: flex; align-items: center; justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
    animation: overlayIn .2s ease;
}
@keyframes overlayIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
.cat-modal {
    background: #fff;
    border-radius: 16px;
    padding: 32px 28px;
    width: 100%; max-width: 400px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    animation: modalIn .25s cubic-bezier(.34,1.56,.64,1);
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(.88) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.cat-modal-icon {
    width: 60px; height: 60px;
    background: #fef2f2; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    color: #dc2626;
}
.cat-modal-title {
    font-size: 16px; font-weight: 700; color: #111827;
    margin: 0 0 8px;
}
.cat-modal-msg {
    font-size: 13.5px; color: #6b7280;
    margin: 0 0 24px; line-height: 1.6;
}
.cat-modal-actions { display: flex; gap: 10px; justify-content: center; }
.cat-modal-cancel {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: #374151;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    padding: 9px 22px; border-radius: 8px;
    cursor: pointer; transition: all .15s;
}
.cat-modal-cancel:hover { background: #e5e7eb; }
.cat-modal-confirm {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: #fff;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    border: none; padding: 9px 22px; border-radius: 8px;
    cursor: pointer; transition: all .15s;
    box-shadow: 0 4px 12px rgba(220,38,38,.28);
}
.cat-modal-confirm:hover { background: linear-gradient(135deg, #b91c1c, #dc2626); }
</style>

<script>
// ── Select All ──────────────────────────────────────────────
document.getElementById('selectAll').addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.checked = this.checked;
        cb.closest('tr').classList.toggle('selected-row', this.checked);
    });
    updateBulkBtn();
});

// ── Individual row checkboxes ────────────────────────────────
document.querySelectorAll('.row-check').forEach(function (cb) {
    cb.addEventListener('change', function () {
        this.closest('tr').classList.toggle('selected-row', this.checked);
        updateBulkBtn();

        // Update "select all" indeterminate/checked state
        const all   = document.querySelectorAll('.row-check');
        const checked = document.querySelectorAll('.row-check:checked');
        const selectAll = document.getElementById('selectAll');
        selectAll.checked       = checked.length === all.length;
        selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
    });
});

// ── Show / hide bulk delete button ──────────────────────────
function updateBulkBtn() {
    const count = document.querySelectorAll('.row-check:checked').length;
    const btn   = document.getElementById('bulkDeleteBtn');
    if (count > 0) {
        btn.style.display = 'inline-flex';
        document.getElementById('selectedCount').textContent = count;
    } else {
        btn.style.display = 'none';
    }
}

// ── Open confirm modal ───────────────────────────────────────
function confirmBulkDelete() {
    const count = document.querySelectorAll('.row-check:checked').length;
    if (count === 0) return;
    document.getElementById('modalCount').textContent = count;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

// ── Close modal ──────────────────────────────────────────────
function closeModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

// Close modal on overlay click
document.getElementById('bulkDeleteModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});

// Close modal on Escape key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
});

// ── Submit bulk delete ───────────────────────────────────────
function submitBulkDelete() {
    const ids       = [...document.querySelectorAll('.row-check:checked')].map(cb => cb.value);
    const container = document.getElementById('bulkIdsContainer');
    container.innerHTML = '';
    ids.forEach(id => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'ids[]';
        input.value = id;
        container.appendChild(input);
    });
    document.getElementById('bulkDeleteForm').submit();
}

// ── Toggle Publish (AJAX) ────────────────────────────────────
document.querySelectorAll('.toggle-publish').forEach(function (toggle) {
    toggle.addEventListener('change', function () {
        const id     = this.dataset.id;
        const status = this.checked ? 1 : 0;
        const self   = this;
        const label  = this.parentElement.querySelector('.cat-toggle-label');
        fetch(`/admin/category/${id}/toggle-publish`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) { self.checked = !self.checked; }
            else { label.textContent = self.checked ? 'Published' : 'Hidden'; }
        })
        .catch(() => { self.checked = !self.checked; });
    });
});
</script>

@endsection
