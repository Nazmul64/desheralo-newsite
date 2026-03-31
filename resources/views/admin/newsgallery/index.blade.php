@extends('admin.master')
@section('content')

<style>
/* ─── Base ─────────────────────────────────────────── */
.sc-page-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 14px; flex-wrap: wrap; gap: 10px;
}
.page-title { font-size: 1.05rem; font-weight: 700; color: #1e293b; white-space: nowrap; }

.btn-add-gallery {
    background: #2563eb; color: #fff; border: none; border-radius: 7px;
    padding: 9px 20px; font-size: .85rem; font-weight: 500;
    display: inline-flex; align-items: center; gap: 7px;
    cursor: pointer; transition: background .18s; white-space: nowrap; flex-shrink: 0;
}
.btn-add-gallery:hover { background: #1d4ed8; }

/* ─── Card ──────────────────────────────────────────── */
.gl-card { background: #fff; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.07); overflow: hidden; }

/* ─── Filter bar ─────────────────────────────────────── */
.filter-bar {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap;
}
.show-select {
    border: 1px solid #e2e8f0; border-radius: 7px;
    padding: 7px 30px 7px 11px; font-size: .82rem; color: #475569;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; cursor: pointer;
}
.show-select:focus { outline: none; border-color: #2563eb; }

.search-wrap { position: relative; flex: 1; max-width: 320px; min-width: 160px; }
.search-wrap input {
    width: 100%; border: 1px solid #e2e8f0; border-radius: 7px;
    padding: 7px 42px 7px 13px; font-size: .82rem; color: #334155; box-sizing: border-box;
}
.search-wrap input:focus { outline: none; border-color: #2563eb; }
.search-wrap button {
    position: absolute; right: 0; top: 0; height: 100%; width: 40px;
    background: #2563eb; border: none; border-radius: 0 7px 7px 0;
    color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer;
}
.search-wrap button:hover { background: #1d4ed8; }

.trash-icon-btn {
    background: none; border: none; color: #cbd5e1;
    padding: 5px 7px; cursor: pointer; font-size: .95rem;
    border-radius: 5px; transition: color .15s;
}
.trash-icon-btn:not(:disabled):hover { color: #ef4444; }
.trash-icon-btn.active { color: #ef4444; }
.trash-icon-btn:disabled { opacity: .35; cursor: not-allowed; }

/* ─── Table ──────────────────────────────────────────── */
.gl-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.gl-table thead tr { background: #f8fafc; }
.gl-table thead th {
    padding: 11px 16px; font-weight: 600; font-size: .78rem;
    color: #94a3b8; text-transform: uppercase; letter-spacing: .05em;
    border-bottom: 1px solid #e2e8f0; white-space: nowrap;
}
.gl-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
.gl-table tbody tr:last-child { border-bottom: none; }
.gl-table tbody tr:hover { background: #f8fafc; }
.gl-table tbody td { padding: 10px 16px; color: #334155; vertical-align: middle; }
.sl-num { color: #94a3b8; font-size: .82rem; text-align: center; }
.col-checkbox { width: 44px; }
.col-sl       { width: 60px; text-align: center; }
.col-photo    { width: 90px; text-align: center; }
.col-title    { text-align: center; }
.col-status   { width: 140px; text-align: center; }
.col-action   { width: 160px; text-align: center; }

/* ─── Thumbnail ──────────────────────────────────────── */
.thumb-img {
    width: 46px; height: 46px; object-fit: cover;
    border-radius: 7px; border: 1px solid #e2e8f0;
}
.thumb-placeholder {
    width: 46px; height: 46px; border-radius: 7px;
    background: #f1f5f9; border: 1px solid #e2e8f0;
    display: inline-flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: .7rem;
}

/* ─── Toggle switch ──────────────────────────────────── */
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute; cursor: pointer; inset: 0;
    background: #cbd5e1; border-radius: 24px; transition: .25s;
}
.toggle-slider:before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: .25s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-slider { background: #2563eb; }
.toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

/* ─── Action Buttons ─────────────────────────────────── */
.action-btns { display: flex; align-items: center; justify-content: center; gap: 6px; }
.btn-edit-row {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 13px; font-size: .78rem; font-weight: 500;
    color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: 6px; cursor: pointer; transition: all .15s;
    text-decoration: none; white-space: nowrap;
}
.btn-edit-row:hover { background: #2563eb; color: #fff; border-color: #2563eb; text-decoration: none; }
.btn-delete-row {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 13px; font-size: .78rem; font-weight: 500;
    color: #ef4444; background: #fff5f5; border: 1px solid #fecaca;
    border-radius: 6px; cursor: pointer; transition: all .15s; white-space: nowrap;
}
.btn-delete-row:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

/* ─── Pagination ─────────────────────────────────────── */
.pagination-wrap {
    padding: 13px 18px; display: flex; align-items: center;
    justify-content: space-between; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 8px;
}
.pagination-wrap .page-info { font-size: .8rem; color: #94a3b8; }
.pagination-wrap .pagination { margin: 0; }
.page-link { font-size: .8rem; color: #2563eb; border-color: #e2e8f0; padding: 4px 10px; }
.page-item.active .page-link { background: #2563eb; border-color: #2563eb; }

.form-check-input { cursor: pointer; }
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="sc-page-header">
        <span class="page-title">Gallery List</span>
        <a href="{{ route('newsgallery.create') }}" class="btn-add-gallery">
            <i class="fas fa-plus" style="font-size:.72rem;"></i> Add Gallery
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3"
             style="font-size:.84rem;" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="gl-card">

        {{-- Filter bar --}}
        <div class="filter-bar">
            <form method="GET" action="{{ route('newsgallery.index') }}" id="perPageForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="per_page" class="show-select" id="perPageSelect">
                    @foreach([10,25,50,100] as $pp)
                        <option value="{{ $pp }}" @selected(request('per_page',10)==$pp)>Show-{{ $pp }}</option>
                    @endforeach
                </select>
            </form>

            <form method="GET" action="{{ route('newsgallery.index') }}" class="search-wrap">
                <input type="hidden" name="per_page" value="{{ request('per_page',10) }}">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                <button type="submit"><i class="fas fa-search" style="font-size:.7rem;"></i></button>
            </form>

            <button class="trash-icon-btn ms-auto" id="bulkTrashBtn" title="Delete selected" disabled>
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>

        {{-- Table --}}
        <table class="gl-table">
            <thead>
                <tr>
                    <th class="col-checkbox">
                        <input type="checkbox" class="form-check-input" id="checkAll">
                    </th>
                    <th class="col-sl">SL.</th>
                    <th class="col-photo">Photo</th>
                    <th class="col-title">Title</th>
                    <th class="col-status">Publish Status</th>
                    <th class="col-action">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $item)
                <tr>
                    <td class="col-checkbox">
                        <input type="checkbox" class="form-check-input row-check" value="{{ $item->id }}">
                    </td>
                    <td class="sl-num">
                        {{ ($galleries->currentPage()-1)*$galleries->perPage()+$loop->iteration }}
                    </td>
                   <td class="col-photo">
                        @if($item->photo && file_exists(public_path($item->photo)))
                            <img src="{{ asset($item->photo) }}"
                                alt="photo" class="thumb-img">
                        @else
                            <span class="thumb-placeholder">
                                <i class="fas fa-image"></i>
                            </span>
                        @endif
                    </td>
                    <td class="col-title">
                        {{ Str::limit($item->title, 40) }}
                    </td>
                    <td class="col-status">
                        <label class="toggle-switch">
                            <input type="checkbox" class="status-toggle"
                                   data-id="{{ $item->id }}"
                                   {{ $item->status ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td class="col-action">
                        <div class="action-btns">
                            <a href="{{ route('newsgallery.edit', $item->id) }}"
                               class="btn-edit-row">
                                <i class="fas fa-edit" style="font-size:.7rem;"></i> Edit
                            </a>
                            <button type="button" class="btn-delete-row delete-btn"
                                    data-id="{{ $item->id }}">
                                <i class="fas fa-trash-alt" style="font-size:.7rem;"></i> Delete
                            </button>
                        </div>
                        <form id="del-{{ $item->id }}"
                              action="{{ route('newsgallery.destroy', $item->id) }}"
                              method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#94a3b8;">
                        <i class="fas fa-images mb-2 d-block" style="font-size:1.6rem;"></i>
                        No gallery items found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($galleries->hasPages())
        <div class="pagination-wrap">
            <span class="page-info">
                Showing {{ $galleries->firstItem() }}–{{ $galleries->lastItem() }}
                of {{ $galleries->total() }}
            </span>
            {{ $galleries->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Bulk delete form --}}
<form id="bulkForm" action="{{ route('newsgallery.bulkDestroy') }}" method="POST" class="d-none">
    @csrf @method('DELETE')
    <div id="bulkIds"></div>
</form>

<script>
(function () {
    'use strict';

    /* ─── Delete ─────────────────────────────────────── */
    document.querySelectorAll('.delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (confirm('Delete this gallery item?')) {
                document.getElementById('del-' + this.getAttribute('data-id')).submit();
            }
        });
    });

    /* ─── Status toggle (AJAX) ───────────────────────── */
    document.querySelectorAll('.status-toggle').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            var id  = this.getAttribute('data-id');
            var el  = this;
            fetch('/newsgallery/' + id + '/toggle-status', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) { el.checked = data.status === 1; })
            .catch(function () { el.checked = !el.checked; }); // revert on error
        });
    });

    /* ─── Check-all ──────────────────────────────────── */
    var checkAll = document.getElementById('checkAll');
    checkAll.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(function (c) { c.checked = checkAll.checked; });
        updateBulkBtn();
    });
    document.querySelectorAll('.row-check').forEach(function (c) {
        c.addEventListener('change', function () {
            checkAll.checked = Array.from(document.querySelectorAll('.row-check')).every(function (c) { return c.checked; });
            updateBulkBtn();
        });
    });
    function updateBulkBtn() {
        var count = document.querySelectorAll('.row-check:checked').length;
        var btn   = document.getElementById('bulkTrashBtn');
        btn.disabled = count === 0;
        btn.classList.toggle('active', count > 0);
    }

    /* ─── Bulk delete ────────────────────────────────── */
    document.getElementById('bulkTrashBtn').addEventListener('click', function () {
        var ids = Array.from(document.querySelectorAll('.row-check:checked')).map(function (c) { return c.value; });
        if (!ids.length) return;
        if (!confirm('Delete ' + ids.length + ' item(s)?')) return;
        document.getElementById('bulkIds').innerHTML = ids.map(function (id) {
            return '<input type="hidden" name="ids[]" value="' + id + '">';
        }).join('');
        document.getElementById('bulkForm').submit();
    });

    /* ─── Per-page select ────────────────────────────── */
    document.getElementById('perPageSelect').addEventListener('change', function () {
        document.getElementById('perPageForm').submit();
    });
})();
</script>

@endsection
