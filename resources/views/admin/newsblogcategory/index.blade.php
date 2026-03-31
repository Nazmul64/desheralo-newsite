@extends('admin.master')

@section('content')
<style>
.cat-wrap { padding: 24px; background: #f5f6fa; min-height: 100vh; }

.cat-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.cat-topbar h5 { margin: 0; font-size: 15px; font-weight: 600; color: #222; }
.cat-btn-add {
    background: #2563eb; color: #fff; border: none; border-radius: 6px;
    padding: 8px 18px; font-size: 13px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s;
}
.cat-btn-add:hover { background: #1d4ed8; color: #fff; }

.cat-controls {
    display: flex; align-items: center; gap: 10px;
    flex-wrap: wrap;
}
.cat-show-select {
    border: 1px solid #d1d5db; border-radius: 6px;
    padding: 6px 28px 6px 10px; font-size: 13px; color: #374151;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236b7280' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; cursor: pointer;
}
.cat-search-wrap {
    display: flex; align-items: center;
    border: 1px solid #d1d5db; border-radius: 6px;
    overflow: hidden; background: #fff;
}
.cat-search-wrap input {
    border: none; outline: none; padding: 7px 12px;
    font-size: 13px; width: 220px; background: transparent; color: #374151;
}
.cat-search-wrap input::placeholder { color: #9ca3af; }
.cat-search-btn {
    background: #2563eb; border: none; padding: 7px 12px;
    color: #fff; cursor: pointer; display: flex; align-items: center;
    transition: background .18s;
}
.cat-search-btn:hover { background: #1d4ed8; }

.cat-card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden; }
.cat-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.cat-table thead tr { background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
.cat-table thead th { padding: 11px 14px; font-weight: 600; color: #374151; text-align: left; white-space: nowrap; }
.cat-table tbody tr { border-bottom: 1px solid #f0f1f3; transition: background .12s; }
.cat-table tbody tr:last-child { border-bottom: none; }
.cat-table tbody tr:hover { background: #fafbfc; }
.cat-table td { padding: 10px 14px; color: #374151; vertical-align: middle; }

.cat-check { width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer; }

.cat-trash-btn {
    background: none; border: none; padding: 4px 6px;
    color: #6b7280; cursor: pointer; border-radius: 4px;
    transition: color .15s, background .15s;
    display: none; align-items: center; justify-content: center;
}
.cat-trash-btn:hover { color: #dc2626; background: #fef2f2; }
.cat-trash-btn.show { display: inline-flex; }

.cat-action-btn {
    background: none; border: none; padding: 5px 8px; border-radius: 5px;
    cursor: pointer; color: #6b7280; font-size: 18px; line-height: 1;
    transition: background .15s, color .15s;
}
.cat-action-btn:hover { background: #f3f4f6; color: #111; }
.cat-dropdown { min-width: 130px; font-size: 13px; }
.cat-dropdown .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 8px 14px; color: #374151; cursor: pointer; }
.cat-dropdown .dropdown-item:hover { background: #f3f4f6; }
.cat-dropdown .dropdown-item.del { color: #dc2626; }
.cat-dropdown .dropdown-item.del:hover { background: #fef2f2; }

.cat-empty { text-align: center; padding: 48px 0; color: #9ca3af; font-size: 14px; }
.cat-empty svg { width: 48px; height: 48px; margin-bottom: 10px; display: block; margin-inline: auto; }

.pagination { margin: 0; }
</style>

<div class="cat-wrap">

    <div class="cat-topbar">
        <h5>Category List</h5>
        <a href="{{ route('newsblogcategory.create') }}" class="cat-btn-add">+ Add Category</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:7px;font-size:13px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="cat-card">

        <div style="padding: 14px 16px; border-bottom: 1px solid #f0f1f3;">
            <form method="GET" action="{{ route('newsblogcategory.index') }}" class="cat-controls" id="filterForm">

                <input type="checkbox" class="cat-check" id="checkAll" style="width:15px;height:15px;">

                <button type="button" id="bulkDeleteBtn" class="cat-trash-btn" title="Delete selected">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                </button>

                <select name="show" class="cat-show-select" onchange="this.form.submit()">
                    @foreach([10,25,50,100] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>Show- {{ $opt }}</option>
                    @endforeach
                </select>

                <div class="cat-search-wrap">
                    <input type="text" name="search" placeholder="Search..." value="{{ $search ?? '' }}">
                    <button type="submit" class="cat-search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table class="cat-table">
                <thead>
                    <tr>
                        <th style="width:42px;"><input type="checkbox" class="cat-check" id="checkAllTable"></th>
                        <th style="width:80px;">SL.</th>
                        <th>Name</th>
                        <th style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr id="row-{{ $category->id }}">

                        <td><input type="checkbox" class="cat-check row-check" value="{{ $category->id }}"></td>

                        <td style="color:#6b7280; text-align:center;">{{ $categories->firstItem() + $index }}</td>

                        <td style="font-weight:500; color:#1f2937;">{{ $category->name }}</td>

                        <td>
                            <div class="dropdown">
                                <button class="cat-action-btn" data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                                <ul class="dropdown-menu dropdown-menu-end cat-dropdown shadow-sm">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('newsblogcategory.edit', $category->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="dropdown-item del delete-single"
                                            data-id="{{ $category->id }}"
                                            data-url="{{ route('newsblogcategory.destroy', $category->id) }}"
                                            data-title="{{ $category->name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="cat-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                                No categories found.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div style="padding: 14px 16px; border-top: 1px solid #f0f1f3; display:flex; justify-content:flex-end;">
            {{ $categories->links() }}
        </div>
        @endif

    </div>
</div>

{{-- Hidden single-delete form --}}
<form id="deleteSingleForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<span id="cat-bulk-url" data-url="{{ route('newsblogcategory.bulkDestroy') }}" style="display:none;"></span>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var csrfInput = document.querySelector('#deleteSingleForm input[name="_token"]');
    var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
    var CSRF      = (csrfMeta ? csrfMeta.getAttribute('content') : null) || (csrfInput ? csrfInput.value : '');

    function toast(type, msg) {
        if (window.toastr) { toastr[type](msg); }
        else { alert((type === 'error' ? '❌ ' : '✅ ') + msg); }
    }

    function fadeRemoveRow(id) {
        var row = document.getElementById('row-' + id);
        if (!row) return;
        row.style.transition = 'opacity 0.3s ease';
        row.style.opacity    = '0';
        setTimeout(function () { row.remove(); syncTrash(); }, 320);
    }

    // ── Checkboxes ─────────────────────────────────────────────────────────────
    var checkAllTop   = document.getElementById('checkAll');
    var checkAllTable = document.getElementById('checkAllTable');
    var bulkBtn       = document.getElementById('bulkDeleteBtn');

    function allChecks()     { return document.querySelectorAll('.row-check'); }
    function checkedChecks() { return document.querySelectorAll('.row-check:checked'); }

    function syncTrash() {
        var any = checkedChecks().length > 0;
        if (bulkBtn) bulkBtn.classList.toggle('show', any);
    }

    function syncAllCheckboxes(checked) {
        allChecks().forEach(function (cb) { cb.checked = checked; });
        if (checkAllTop)   checkAllTop.checked   = checked;
        if (checkAllTable) checkAllTable.checked = checked;
        syncTrash();
    }

    if (checkAllTop)   checkAllTop.addEventListener('change',   function () { syncAllCheckboxes(this.checked); });
    if (checkAllTable) checkAllTable.addEventListener('change', function () { syncAllCheckboxes(this.checked); });

    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('row-check')) return;
        var all     = allChecks();
        var checked = checkedChecks();
        var state   = all.length > 0 && all.length === checked.length;
        var indet   = checked.length > 0 && checked.length < all.length;
        if (checkAllTop)   { checkAllTop.checked = state;   checkAllTop.indeterminate = indet; }
        if (checkAllTable) { checkAllTable.checked = state; checkAllTable.indeterminate = indet; }
        syncTrash();
    });

    // ── Delete Single ──────────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.delete-single');
        if (!btn) return;

        var url   = btn.getAttribute('data-url');
        var title = btn.getAttribute('data-title');

        function doDelete() {
            var form    = document.getElementById('deleteSingleForm');
            form.action = url;
            form.submit();
        }

        if (window.Swal) {
            Swal.fire({
                title: 'Delete Category?',
                html : '<b>' + title + '</b> will be permanently removed.',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor : '#6b7280',
                confirmButtonText : 'Yes, delete!',
                cancelButtonText  : 'Cancel',
            }).then(function (r) { if (r.isConfirmed) doDelete(); });
        } else {
            if (confirm('Delete "' + title + '"? This cannot be undone.')) doDelete();
        }
    });

    // ── Bulk Delete ────────────────────────────────────────────────────────────
    if (bulkBtn) {
        bulkBtn.addEventListener('click', function () {
            var ids     = Array.from(checkedChecks()).map(function (cb) { return cb.value; });
            if (!ids.length) return;
            var bulkUrl = document.getElementById('cat-bulk-url').getAttribute('data-url');

            function doBulk() {
                fetch(bulkUrl, {
                    method  : 'DELETE',
                    headers : {
                        'Content-Type'    : 'application/json',
                        'X-CSRF-TOKEN'    : CSRF,
                        'Accept'          : 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(function (res) { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        toast('success', data.message);
                        ids.forEach(function (id) { fadeRemoveRow(id); });
                        if (checkAllTop)   { checkAllTop.checked = false;   checkAllTop.indeterminate = false; }
                        if (checkAllTable) { checkAllTable.checked = false; checkAllTable.indeterminate = false; }
                    } else { toast('error', 'Bulk delete failed.'); }
                })
                .catch(function (err) { console.error(err); toast('error', 'Network error.'); });
            }

            if (window.Swal) {
                Swal.fire({
                    title: 'Delete ' + ids.length + ' item(s)?',
                    text : 'This action cannot be undone.',
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor : '#6b7280',
                    confirmButtonText : 'Yes, delete all!',
                    cancelButtonText  : 'Cancel',
                }).then(function (r) { if (r.isConfirmed) doBulk(); });
            } else {
                if (confirm('Delete ' + ids.length + ' item(s)?')) doBulk();
            }
        });
    }

});
</script>

@endsection
