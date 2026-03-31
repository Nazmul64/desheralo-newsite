@extends('admin.master')

@section('content')
<style>
.nb-wrap { padding: 24px; background: #f5f6fa; min-height: 100vh; }

.nb-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.nb-topbar h5 { margin: 0; font-size: 15px; font-weight: 600; color: #222; }
.nb-btn-add {
    background: #2563eb; color: #fff; border: none; border-radius: 6px;
    padding: 8px 18px; font-size: 13px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s;
}
.nb-btn-add:hover { background: #1d4ed8; color: #fff; }

.nb-controls { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.nb-show-select {
    border: 1px solid #d1d5db; border-radius: 6px;
    padding: 6px 28px 6px 10px; font-size: 13px; color: #374151;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236b7280' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; cursor: pointer;
}
.nb-search-wrap {
    display: flex; align-items: center;
    border: 1px solid #d1d5db; border-radius: 6px;
    overflow: hidden; background: #fff;
}
.nb-search-wrap input {
    border: none; outline: none; padding: 7px 12px;
    font-size: 13px; width: 220px; background: transparent; color: #374151;
}
.nb-search-wrap input::placeholder { color: #9ca3af; }
.nb-search-btn {
    background: #2563eb; border: none; padding: 7px 12px;
    color: #fff; cursor: pointer; display: flex; align-items: center;
    transition: background .18s;
}
.nb-search-btn:hover { background: #1d4ed8; }

.nb-card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden; }
.nb-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.nb-table thead tr { background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
.nb-table thead th { padding: 11px 14px; font-weight: 600; color: #374151; text-align: left; white-space: nowrap; }
.nb-table tbody tr { border-bottom: 1px solid #f0f1f3; transition: background .12s; }
.nb-table tbody tr:last-child { border-bottom: none; }
.nb-table tbody tr:hover { background: #fafbfc; }
.nb-table td { padding: 10px 14px; color: #374151; vertical-align: middle; }

.nb-check { width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer; }

.nb-trash-btn {
    background: none; border: none; padding: 4px 6px;
    color: #6b7280; cursor: pointer; border-radius: 4px;
    transition: color .15s, background .15s;
    display: none; align-items: center; justify-content: center;
}
.nb-trash-btn:hover { color: #dc2626; background: #fef2f2; }
.nb-trash-btn.show { display: inline-flex; }

.nb-action-btn {
    background: none; border: none; padding: 5px 8px; border-radius: 5px;
    cursor: pointer; color: #6b7280; font-size: 18px; line-height: 1;
    transition: background .15s, color .15s;
}
.nb-action-btn:hover { background: #f3f4f6; color: #111; }
.nb-dropdown { min-width: 130px; font-size: 13px; }
.nb-dropdown .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 8px 14px; color: #374151; cursor: pointer; }
.nb-dropdown .dropdown-item:hover { background: #f3f4f6; }
.nb-dropdown .dropdown-item.del { color: #dc2626; }
.nb-dropdown .dropdown-item.del:hover { background: #fef2f2; }

.nb-badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.nb-badge.published   { background: #dcfce7; color: #16a34a; }
.nb-badge.unpublished { background: #f3f4f6; color: #6b7280; }

.nb-img-thumb { width: 44px; height: 44px; object-fit: cover; border-radius: 5px; border: 1px solid #e5e7eb; }
.nb-img-placeholder { width: 44px; height: 44px; background: #f3f4f6; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #d1d5db; font-size: 18px; }

.nb-empty { text-align: center; padding: 48px 0; color: #9ca3af; font-size: 14px; }
.nb-empty svg { width: 48px; height: 48px; margin-bottom: 10px; display: block; margin-inline: auto; }
.pagination { margin: 0; }
</style>

<div class="nb-wrap">

    <div class="nb-topbar">
        <h5>Blog List</h5>
        <a href="{{ route('newblog.create') }}" class="nb-btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add New Blog
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:7px;font-size:13px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="nb-card">

        <div style="padding:14px 16px; border-bottom:1px solid #f0f1f3;">
            <form method="GET" action="{{ route('newblog.index') }}" class="nb-controls" id="filterForm">

                <input type="checkbox" class="nb-check" id="checkAll">

                <button type="button" id="bulkDeleteBtn" class="nb-trash-btn" title="Delete selected">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                </button>

                <select name="show" class="nb-show-select" onchange="this.form.submit()">
                    @foreach([10,25,50,100] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>Show- {{ $opt }}</option>
                    @endforeach
                </select>

                <div class="nb-search-wrap">
                    <input type="text" name="search" placeholder="Search..." value="{{ $search ?? '' }}">
                    <button type="submit" class="nb-search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>

        <div style="overflow-x:auto;">
            <table class="nb-table">
                <thead>
                    <tr>
                        <th style="width:42px;"><input type="checkbox" class="nb-check" id="checkAllTable"></th>
                        <th style="width:55px;">SL.</th>
                        <th style="width:50px;">Image</th>
                        <th>Title</th>
                        <th style="width:150px;">Category</th>
                        <th style="width:150px;">Sub-Category</th>
                        <th style="width:100px;">Date</th>
                        <th style="width:100px;">Status</th>
                        <th style="width:70px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $index => $blog)
                    <tr id="row-{{ $blog->id }}">

                        <td><input type="checkbox" class="nb-check row-check" value="{{ $blog->id }}"></td>

                        <td style="color:#6b7280; text-align:center;">{{ $blogs->firstItem() + $index }}</td>

                    <td>
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" class="nb-img-thumb" alt="blog">
                        @else
                            <div class="nb-img-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        @endif
                    </td>

                        <td style="font-weight:500; color:#1f2937; max-width:260px;">
                            <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:260px;" title="{{ $blog->title }}">
                                {{ $blog->title }}
                            </div>
                        </td>

                        <td><span style="font-size:12px; color:#6b7280;">{{ $blog->category->name ?? '—' }}</span></td>
                        <td><span style="font-size:12px; color:#6b7280;">{{ $blog->subCategory->name ?? '—' }}</span></td>

                        <td style="font-size:12px; color:#6b7280;">
                            {{ $blog->date ? $blog->date->format('d M Y') : '—' }}
                        </td>

                        <td>
                            <span class="nb-badge {{ $blog->status ? 'published' : 'unpublished' }}">
                                {{ $blog->status ? 'Published' : 'Unpublished' }}
                            </span>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="nb-action-btn" data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                                <ul class="dropdown-menu dropdown-menu-end nb-dropdown shadow-sm">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('newblog.edit', $blog->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                 fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="dropdown-item del delete-single"
                                            data-id="{{ $blog->id }}"
                                            data-url="{{ route('newblog.destroy', $blog->id) }}"
                                            data-title="{{ $blog->title }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                 fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <td colspan="9">
                            <div class="nb-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"/>
                                </svg>
                                No blogs found.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($blogs->hasPages())
        <div style="padding:14px 16px; border-top:1px solid #f0f1f3; display:flex; justify-content:flex-end;">
            {{ $blogs->links() }}
        </div>
        @endif

    </div>
</div>

<form id="deleteSingleForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
<span id="nb-bulk-url" data-url="{{ route('newblog.bulkDestroy') }}" style="display:none;"></span>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
    var CSRF      = csrfMeta ? csrfMeta.getAttribute('content') : '';

    function toast(type, msg) {
        if (window.toastr) toastr[type](msg);
        else alert((type === 'error' ? '❌ ' : '✅ ') + msg);
    }

    function fadeRemoveRow(id) {
        var row = document.getElementById('row-' + id);
        if (!row) return;
        row.style.transition = 'opacity .3s ease';
        row.style.opacity    = '0';
        setTimeout(function () { row.remove(); syncTrash(); }, 320);
    }

    var checkAll      = document.getElementById('checkAll');
    var checkAllTable = document.getElementById('checkAllTable');
    var bulkBtn       = document.getElementById('bulkDeleteBtn');

    function allChecks()     { return document.querySelectorAll('.row-check'); }
    function checkedChecks() { return document.querySelectorAll('.row-check:checked'); }

    function syncTrash() {
        if (bulkBtn) bulkBtn.classList.toggle('show', checkedChecks().length > 0);
    }

    function syncAll(checked) {
        allChecks().forEach(function (cb) { cb.checked = checked; });
        if (checkAll)      { checkAll.checked = checked;      checkAll.indeterminate = false; }
        if (checkAllTable) { checkAllTable.checked = checked; checkAllTable.indeterminate = false; }
        syncTrash();
    }

    if (checkAll)      checkAll.addEventListener('change',      function () { syncAll(this.checked); });
    if (checkAllTable) checkAllTable.addEventListener('change', function () { syncAll(this.checked); });

    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('row-check')) return;
        var all = allChecks(), ch = checkedChecks();
        var s   = all.length > 0 && all.length === ch.length;
        var ind = ch.length > 0 && ch.length < all.length;
        if (checkAll)      { checkAll.checked = s;      checkAll.indeterminate = ind; }
        if (checkAllTable) { checkAllTable.checked = s; checkAllTable.indeterminate = ind; }
        syncTrash();
    });

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.delete-single');
        if (!btn) return;
        var url = btn.getAttribute('data-url'), title = btn.getAttribute('data-title');
        function doDelete() {
            var form = document.getElementById('deleteSingleForm');
            form.action = url; form.submit();
        }
        if (window.Swal) {
            Swal.fire({ title:'Delete Blog?', html:'<b>'+title+'</b> will be permanently removed.', icon:'warning',
                showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#6b7280',
                confirmButtonText:'Yes, delete!', cancelButtonText:'Cancel'
            }).then(function(r){ if(r.isConfirmed) doDelete(); });
        } else { if(confirm('Delete "'+title+'"?')) doDelete(); }
    });

    if (bulkBtn) {
        bulkBtn.addEventListener('click', function () {
            var ids = Array.from(checkedChecks()).map(function(cb){ return cb.value; });
            if (!ids.length) return;
            var bulkUrl = document.getElementById('nb-bulk-url').getAttribute('data-url');
            function doBulk() {
                fetch(bulkUrl, {
                    method:'DELETE',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify({ids:ids})
                })
                .then(function(res){ if(!res.ok) throw new Error('HTTP '+res.status); return res.json(); })
                .then(function(data){
                    if(data.success){ toast('success',data.message); ids.forEach(function(id){ fadeRemoveRow(id); }); syncAll(false); }
                    else toast('error','Bulk delete failed.');
                })
                .catch(function(err){ console.error(err); toast('error','Network error.'); });
            }
            if (window.Swal) {
                Swal.fire({ title:'Delete '+ids.length+' blog(s)?', text:'This cannot be undone.', icon:'warning',
                    showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#6b7280',
                    confirmButtonText:'Yes, delete all!', cancelButtonText:'Cancel'
                }).then(function(r){ if(r.isConfirmed) doBulk(); });
            } else { if(confirm('Delete '+ids.length+' blog(s)?')) doBulk(); }
        });
    }
});
</script>
@endsection
