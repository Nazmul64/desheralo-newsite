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
        --border-strong: #d1cde8;
        --accent: #5b4fcf;
        --accent-glow: rgba(91,79,207,0.12);
        --accent-hover: #4a3fbe;
        --danger: #e03e3e;
        --danger-soft: rgba(224,62,62,0.1);
        --success: #059669;
        --warning: #d97706;
        --radius-card: 16px;
        --radius-btn: 10px;
        --shadow-card: 0 4px 24px rgba(91,79,207,0.08), 0 1px 4px rgba(0,0,0,0.04);
        --shadow-hover: 0 12px 40px rgba(91,79,207,0.15), 0 2px 8px rgba(0,0,0,0.06);
        --font-display: 'Syne', sans-serif;
        --font-body: 'DM Sans', sans-serif;
        --transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { font-family: var(--font-body); box-sizing: border-box; }

    .tc-page { background: var(--surface); min-height: 100vh; padding: 2rem 2.5rem; }

    /* ── Header ── */
    .tc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--border);
    }
    .tc-header-left {}
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
        font-size: 28px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.5px;
        margin: 0;
    }
    .tc-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: var(--accent);
        color: #fff;
        border-radius: var(--radius-btn);
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 16px rgba(91,79,207,0.3);
    }
    .tc-btn-add:hover {
        background: var(--accent-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(91,79,207,0.38);
        color: #fff;
    }
    .tc-btn-add svg { width:16px; height:16px; }

    /* ── Alert ── */
    .tc-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 18px;
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        border-radius: 10px;
        font-size: 14px;
        color: var(--success);
        font-weight: 500;
        margin-bottom: 1.5rem;
        animation: slideDown 0.3s ease;
    }
    @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
    .tc-alert-close {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--success);
        opacity: 0.7;
        font-size: 18px;
        line-height: 1;
        padding: 0;
    }

    /* ── Bulk Bar ── */
    .bulk-bar {
        display: none;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        background: var(--danger-soft);
        border: 1px solid rgba(224,62,62,0.2);
        border-radius: 10px;
        margin-bottom: 1rem;
        animation: slideDown 0.25s ease;
    }
    .bulk-bar.visible { display: flex; }
    .bulk-bar-text { font-size: 13px; font-weight: 600; color: var(--danger); }
    .bulk-bar-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }
    .bulk-bar-btn:hover { background: #c02b2b; transform: scale(1.02); }

    /* ── Card Table ── */
    .tc-card {
        background: var(--surface-card);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .tc-table { width: 100%; border-collapse: collapse; }
    .tc-table thead tr {
        background: var(--ink-soft);
    }
    .tc-table thead th {
        padding: 14px 16px;
        font-family: var(--font-display);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.6);
        border: none;
        white-space: nowrap;
    }
    .tc-table thead th:first-child { border-radius: 0; padding-left: 20px; }
    .tc-table thead th.text-center { text-align: center; }

    .tc-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }
    .tc-table tbody tr:last-child { border-bottom: none; }
    .tc-table tbody tr:hover { background: var(--accent-glow); }

    .tc-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: var(--ink-soft);
        vertical-align: middle;
    }
    .tc-table tbody td:first-child { padding-left: 20px; }

    /* Checkbox */
    .tc-check {
        width: 17px;
        height: 17px;
        accent-color: var(--accent);
        cursor: pointer;
    }

    /* Row number */
    .row-num {
        font-size: 12px;
        color: var(--ink-muted);
        font-weight: 600;
        font-family: var(--font-display);
    }

    /* Theme name */
    .theme-name {
        font-weight: 700;
        color: var(--ink);
        font-size: 14px;
    }

    /* Color swatches */
    .swatch-group { display: flex; gap: 5px; align-items: center; }
    .swatch-pill {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.9);
        box-shadow: 0 0 0 1px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }
    .swatch-pill:hover { transform: scale(1.25); z-index: 2; }
    .swatch-pill[data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        background: var(--ink);
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 5px;
        white-space: nowrap;
        letter-spacing: 0.04em;
        pointer-events: none;
    }

    /* Default badge */
    .badge-default {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.04em;
        border: 1px solid #f59e0b40;
    }

    /* Toggle Switch */
    .tc-toggle {
        position: relative;
        display: inline-block;
        width: 42px;
        height: 22px;
    }
    .tc-toggle input { opacity: 0; width: 0; height: 0; }
    .tc-toggle-slider {
        position: absolute;
        inset: 0;
        background: #d1d5db;
        border-radius: 11px;
        cursor: pointer;
        transition: .25s;
    }
    .tc-toggle-slider::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        left: 3px;
        top: 3px;
        background: white;
        border-radius: 50%;
        transition: .25s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .tc-toggle input:checked + .tc-toggle-slider { background: var(--accent); }
    .tc-toggle input:checked + .tc-toggle-slider::before { transform: translateX(20px); }

    /* Date */
    .date-cell { font-size: 12px; color: var(--ink-muted); font-weight: 500; }

    /* Action Buttons */
    .actions-cell { display: flex; gap: 6px; justify-content: center; align-items: center; }
    .act-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1.5px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
        background: transparent;
        font-size: 13px;
    }
    .act-btn.view { border-color: #60a5fa40; color: #3b82f6; background: #eff6ff; }
    .act-btn.view:hover { background: #3b82f6; color: #fff; border-color: #3b82f6; transform: scale(1.08); }
    .act-btn.edit { border-color: #fbbf2440; color: #d97706; background: #fffbeb; }
    .act-btn.edit:hover { background: #d97706; color: #fff; border-color: #d97706; transform: scale(1.08); }
    .act-btn.del { border-color: #f8717140; color: #dc2626; background: #fef2f2; }
    .act-btn.del:hover { background: #dc2626; color: #fff; border-color: #dc2626; transform: scale(1.08); }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--accent-glow);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-icon svg { width: 30px; height: 30px; color: var(--accent); }
    .empty-title { font-family: var(--font-display); font-weight: 700; font-size: 18px; color: var(--ink); margin-bottom: 6px; }
    .empty-desc { font-size: 14px; color: var(--ink-muted); }

    /* Pagination */
    .tc-pagination {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        background: #fafaf8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tc-page { padding: 1rem; }
        .tc-page-title { font-size: 22px; }
        .tc-table thead th:nth-child(7),
        .tc-table tbody td:nth-child(7) { display: none; }
    }
</style>

<div class="tc-page">

    {{-- Header --}}
    <div class="tc-header">
        <div class="tc-header-left">
            <p class="tc-page-label">Appearance</p>
            <h1 class="tc-page-title">Theme Colors</h1>
        </div>
        <a href="{{ route('themecolor.create') }}" class="tc-btn-add">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Theme
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="tc-alert" id="tcAlert">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
        <button class="tc-alert-close" onclick="document.getElementById('tcAlert').remove()">×</button>
    </div>
    @endif

    {{-- Bulk Bar --}}
    <div class="bulk-bar" id="bulkBar">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <span class="bulk-bar-text" id="bulkCount">0 selected</span>
        <button class="bulk-bar-btn" id="bulkDeleteBtn">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Selected
        </button>
    </div>

    {{-- Table Card --}}
    <div class="tc-card">
        <table class="tc-table">
            <thead>
                <tr>
                    <th width="44">
                        <input type="checkbox" id="selectAll" class="tc-check">
                    </th>
                    <th>#</th>
                    <th>Theme Name</th>
                    <th>Colors</th>
                    <th>Default</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($themecolors as $key => $item)
                <tr id="row-{{ $item->id }}">
                    <td>
                        <input type="checkbox" class="tc-check row-checkbox" value="{{ $item->id }}">
                    </td>
                    <td><span class="row-num">{{ $themecolors->firstItem() + $key }}</span></td>
                    <td><span class="theme-name">{{ $item->name }}</span></td>
                    <td>
                        <div class="swatch-group">
                            <span class="swatch-pill" style="background:{{ $item->primary_color }}"
                                  data-tooltip="Primary {{ $item->primary_color }}"></span>
                            <span class="swatch-pill" style="background:{{ $item->secondary_color }}"
                                  data-tooltip="Secondary {{ $item->secondary_color }}"></span>
                            @if($item->accent_color)
                            <span class="swatch-pill" style="background:{{ $item->accent_color }}"
                                  data-tooltip="Accent {{ $item->accent_color }}"></span>
                            @endif
                            <span class="swatch-pill" style="background:{{ $item->background_color }}"
                                  data-tooltip="BG {{ $item->background_color }}"></span>
                            <span class="swatch-pill" style="background:{{ $item->text_color }}"
                                  data-tooltip="Text {{ $item->text_color }}"></span>
                        </div>
                    </td>
                    <td>
                        @if($item->is_default)
                            <span class="badge-default">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Default
                            </span>
                        @else
                            <span style="color:var(--ink-muted);font-size:18px;line-height:1;">·</span>
                        @endif
                    </td>
                    <td>
                        <label class="tc-toggle">
                            <input type="checkbox" class="toggle-status"
                                   data-id="{{ $item->id }}"
                                   {{ $item->status ? 'checked' : '' }}>
                            <span class="tc-toggle-slider"></span>
                        </label>
                    </td>
                    <td><span class="date-cell">{{ $item->created_at->format('d M Y') }}</span></td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('themecolor.show', $item->id) }}" class="act-btn view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('themecolor.edit', $item->id) }}" class="act-btn edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('themecolor.destroy', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this theme color?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn del" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z"/>
                                </svg>
                            </div>
                            <p class="empty-title">No Theme Colors Yet</p>
                            <p class="empty-desc">Create your first theme to get started.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($themecolors->hasPages())
        <div class="tc-pagination">
            {{ $themecolors->links() }}
        </div>
        @endif
    </div>

</div>

<script>
// ── Select All ──
const selectAll   = document.getElementById('selectAll');
const bulkBar     = document.getElementById('bulkBar');
const bulkCount   = document.getElementById('bulkCount');
const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
const checkboxes  = () => document.querySelectorAll('.row-checkbox');

selectAll.addEventListener('change', function () {
    checkboxes().forEach(cb => cb.checked = this.checked);
    updateBulkBar();
});
document.querySelectorAll('.row-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkBar);
});
function updateBulkBar() {
    const count = document.querySelectorAll('.row-checkbox:checked').length;
    const total = document.querySelectorAll('.row-checkbox').length;
    selectAll.checked = count === total && total > 0;
    selectAll.indeterminate = count > 0 && count < total;
    if (count > 0) {
        bulkBar.classList.add('visible');
        bulkCount.textContent = `${count} item${count > 1 ? 's' : ''} selected`;
    } else {
        bulkBar.classList.remove('visible');
    }
}

// ── Bulk Delete ──
bulkDeleteBtn.addEventListener('click', function () {
    const ids = [...document.querySelectorAll('.row-checkbox:checked')].map(cb => cb.value);
    if (!ids.length) return;
    if (!confirm(`Permanently delete ${ids.length} theme color(s)?`)) return;

    fetch('{{ route('Themecolor.bulkDestroy') }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); });
});

// ── Toggle Status ──
document.querySelectorAll('.toggle-status').forEach(toggle => {
    toggle.addEventListener('change', function () {
        const prev = !this.checked;
        fetch(`/admin/themecolor/${this.dataset.id}/toggle-status`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) this.checked = prev;
        });
    });
});
</script>

@endsection
