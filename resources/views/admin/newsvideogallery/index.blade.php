@extends('admin.master')

@section('content')

{{-- ✅ CSRF meta tag — toggleStatus AJAX এর জন্য অপরিহার্য --}}
@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<style>
.vg-wrapper { padding: 24px; background: #f5f6fa; min-height: 100vh; }

.vg-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.vg-topbar h5 { margin: 0; font-size: 15px; font-weight: 600; color: #222; }
.vg-btn-add {
    background: #2563eb; color: #fff; border: none; border-radius: 6px;
    padding: 8px 18px; font-size: 13px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s;
}
.vg-btn-add:hover { background: #1d4ed8; color: #fff; }

.vg-controls {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 0; flex-wrap: wrap;
}
.vg-show-select {
    border: 1px solid #d1d5db; border-radius: 6px;
    padding: 6px 28px 6px 10px; font-size: 13px; color: #374151;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236b7280' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; cursor: pointer;
}
.vg-search-wrap {
    display: flex; align-items: center;
    border: 1px solid #d1d5db; border-radius: 6px;
    overflow: hidden; background: #fff;
}
.vg-search-wrap input {
    border: none; outline: none; padding: 7px 12px;
    font-size: 13px; width: 220px; background: transparent; color: #374151;
}
.vg-search-wrap input::placeholder { color: #9ca3af; }
.vg-search-btn {
    background: #2563eb; border: none; padding: 7px 12px;
    color: #fff; cursor: pointer; display: flex; align-items: center;
    transition: background .18s;
}
.vg-search-btn:hover { background: #1d4ed8; }

.vg-card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden; }
.vg-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.vg-table thead tr { background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
.vg-table thead th { padding: 11px 14px; font-weight: 600; color: #374151; text-align: left; white-space: nowrap; }
.vg-table tbody tr { border-bottom: 1px solid #f0f1f3; transition: background .12s; }
.vg-table tbody tr:last-child { border-bottom: none; }
.vg-table tbody tr:hover { background: #fafbfc; }
.vg-table td { padding: 10px 14px; color: #374151; vertical-align: middle; }

.vg-check { width: 15px; height: 15px; accent-color: #2563eb; cursor: pointer; }

.vg-trash-btn {
    background: none; border: none; padding: 4px 6px;
    color: #6b7280; cursor: pointer; border-radius: 4px;
    transition: color .15s, background .15s;
    display: none; align-items: center; justify-content: center;
}
.vg-trash-btn:hover { color: #dc2626; background: #fef2f2; }
.vg-trash-btn.show { display: inline-flex; }

.vg-thumb-wrap {
    width: 220px; height: 120px; border-radius: 7px;
    overflow: hidden; background: #f1f2f4;
    display: flex; align-items: center; justify-content: center;
}
.vg-thumb-wrap iframe,
.vg-thumb-wrap video { width: 100%; height: 100%; display: block; object-fit: cover; border: none; }
.vg-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; }
.vg-no-thumb {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: #9ca3af; gap: 4px; font-size: 12px;
}
.vg-no-thumb svg { width: 30px; height: 30px; }

/* ── Toggle switch ── */
.vg-toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
.vg-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
.vg-slider {
    position: absolute; inset: 0; background: #d1d5db;
    border-radius: 24px; cursor: pointer; transition: background .22s;
}
.vg-slider::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%;
    transition: transform .22s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.vg-toggle input:checked + .vg-slider { background: #2563eb; }
.vg-toggle input:checked + .vg-slider::before { transform: translateX(20px); }

.vg-status-text { font-size: 12px; color: #6b7280; margin-left: 8px; min-width: 72px; }

.vg-action-btn {
    background: none; border: none; padding: 5px 8px; border-radius: 5px;
    cursor: pointer; color: #6b7280; font-size: 18px; line-height: 1;
    transition: background .15s, color .15s;
}
.vg-action-btn:hover { background: #f3f4f6; color: #111; }
.vg-dropdown { min-width: 130px; font-size: 13px; }
.vg-dropdown .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 8px 14px; color: #374151; cursor: pointer; }
.vg-dropdown .dropdown-item:hover { background: #f3f4f6; }
.vg-dropdown .dropdown-item.del { color: #dc2626; }
.vg-dropdown .dropdown-item.del:hover { background: #fef2f2; }

.vg-empty { text-align: center; padding: 48px 0; color: #9ca3af; font-size: 14px; }
.vg-empty svg { width: 48px; height: 48px; margin-bottom: 10px; display: block; margin-inline: auto; }

.pagination { margin: 0; }
</style>

<div class="vg-wrapper">

    <div class="vg-topbar">
        <h5>Video Gallery List</h5>
        <a href="{{ route('newsvideogallery.create') }}" class="vg-btn-add">+ Add Video Gallery</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:7px;font-size:13px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="vg-card">

        <div style="padding: 14px 16px; border-bottom: 1px solid #f0f1f3;">
            <form method="GET" action="{{ route('newsvideogallery.index') }}" class="vg-controls" id="filterForm">

                <button type="button" id="bulkDeleteBtn" class="vg-trash-btn" title="Delete selected">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                </button>

                <select name="show" class="vg-show-select" onchange="this.form.submit()">
                    @foreach([10,25,50,100] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>Show - {{ $opt }}</option>
                    @endforeach
                </select>

                <div class="vg-search-wrap">
                    <input type="text" name="search" placeholder="Search..." value="{{ $search ?? '' }}">
                    <button type="submit" class="vg-search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table class="vg-table">
                <thead>
                    <tr>
                        <th style="width:42px;"><input type="checkbox" class="vg-check" id="checkAll"></th>
                        <th style="width:52px;">SL.</th>
                        <th style="width:260px;">Video</th>
                        <th>Title</th>
                        <th style="width:200px;">Publish Status</th>
                        <th style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $index => $video)
                    <tr id="row-{{ $video->id }}">

                        <td><input type="checkbox" class="vg-check row-check" value="{{ $video->id }}"></td>

                        <td style="color:#6b7280;">{{ $videos->firstItem() + $index }}</td>

                        <td>
                            <div class="vg-thumb-wrap">
                                @if($video->video_type === 'youtube' && $video->youtube_embed_url)
                                    <iframe src="{{ $video->youtube_embed_url }}"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @elseif($video->video_type === 'upload' && $video->video_path)
                                    @if($video->thumbnail)
                                        <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}">
                                    @else
                                        <video src="{{ asset($video->video_path) }}" preload="metadata"></video>
                                    @endif
                                @else
                                    <div class="vg-no-thumb">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5l5 5v13a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>No preview</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td>
                            <span style="font-weight:500; color:#1f2937;" title="{{ $video->title }}">
                                {{ Str::limit($video->title, 40) }}
                            </span>
                        </td>

                        <td>
                            <div style="display:flex; align-items:center;">
                                <label class="vg-toggle">
                                    <input
                                        type="checkbox"
                                        class="toggle-status"
                                        data-id="{{ $video->id }}"
                                        data-url="{{ route('newsvideogallery.toggleStatus', $video->id) }}"
                                        {{ $video->status ? 'checked' : '' }}>
                                    <span class="vg-slider"></span>
                                </label>
                                <span class="vg-status-text" id="status-label-{{ $video->id }}">
                                    {{ $video->status ? 'Published' : 'Unpublished' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="vg-action-btn" data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                                <ul class="dropdown-menu dropdown-menu-end vg-dropdown shadow-sm">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('newsvideogallery.edit', $video->id) }}">
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
                                            data-id="{{ $video->id }}"
                                            data-url="{{ route('newsvideogallery.destroy', $video->id) }}"
                                            data-title="{{ $video->title }}">
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
                        <td colspan="6">
                            <div class="vg-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                                </svg>
                                No videos found.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
        <div style="padding: 14px 16px; border-top: 1px solid #f0f1f3; display:flex; justify-content:flex-end;">
            {{ $videos->links() }}
        </div>
        @endif

    </div>
</div>

{{-- Hidden single-delete form --}}
<form id="deleteSingleForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- Bulk destroy URL --}}
<span id="vg-bulk-url" data-url="{{ route('newsvideogallery.bulkDestroy') }}" style="display:none;"></span>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── CSRF token ─────────────────────────────────────────────────────────────
    // ✅ FIX: meta tag থেকে না পেলে deleteSingleForm থেকে নেওয়া হচ্ছে fallback হিসেবে
    var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
    var csrfInput = document.querySelector('#deleteSingleForm input[name="_token"]');
    var CSRF      = (csrfMeta  ? csrfMeta.getAttribute('content')  : null)
                 || (csrfInput ? csrfInput.value                    : '');

    // ── Toast ──────────────────────────────────────────────────────────────────
    function toast(type, msg) {
        if (window.toastr) {
            toastr[type](msg);
        } else {
            alert((type === 'error' ? '❌ ' : '✅ ') + msg);
        }
    }

    // ── Fade-remove row ────────────────────────────────────────────────────────
    function fadeRemoveRow(id) {
        var row = document.getElementById('row-' + id);
        if (!row) return;
        row.style.transition = 'opacity 0.3s ease';
        row.style.opacity    = '0';
        setTimeout(function () { row.remove(); syncTrash(); }, 320);
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  Checkboxes
    // ══════════════════════════════════════════════════════════════════════════
    var checkAll = document.getElementById('checkAll');
    var bulkBtn  = document.getElementById('bulkDeleteBtn');

    function allChecks()     { return document.querySelectorAll('.row-check'); }
    function checkedChecks() { return document.querySelectorAll('.row-check:checked'); }

    function syncTrash() {
        var any = checkedChecks().length > 0;
        if (bulkBtn) bulkBtn.classList.toggle('show', any);
    }

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            allChecks().forEach(function (cb) { cb.checked = checkAll.checked; });
            syncTrash();
        });
    }

    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('row-check')) return;
        var all     = allChecks();
        var checked = checkedChecks();
        if (checkAll) {
            checkAll.checked       = all.length > 0 && all.length === checked.length;
            checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
        }
        syncTrash();
    });

    // ══════════════════════════════════════════════════════════════════════════
    //  Toggle Status
    // ══════════════════════════════════════════════════════════════════════════
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('toggle-status')) return;

        var checkbox = e.target;
        var id       = checkbox.getAttribute('data-id');
        var url      = checkbox.getAttribute('data-url');
        var label    = document.getElementById('status-label-' + id);

        // Optimistic UI update
        if (label) label.textContent = checkbox.checked ? 'Published' : 'Unpublished';

        // ✅ FIX: CSRF token টা header এ পাঠানো হচ্ছে — body তে নয়
        fetch(url, {
            method  : 'POST',
            headers : {
                'Content-Type' : 'application/json',
                'X-CSRF-TOKEN' : CSRF,
                'Accept'       : 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({})
        })
        .then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function (data) {
            if (data.success) {
                toast('success', data.message);
                if (label) label.textContent = data.status ? 'Published' : 'Unpublished';
                checkbox.checked = !!data.status;
            } else {
                throw new Error('success false');
            }
        })
        .catch(function (err) {
            console.error('Toggle error:', err);
            // Revert on failure
            checkbox.checked = !checkbox.checked;
            if (label) label.textContent = checkbox.checked ? 'Published' : 'Unpublished';
            toast('error', 'Status update failed. Please try again.');
        });
    });

    // ══════════════════════════════════════════════════════════════════════════
    //  Delete Single
    // ══════════════════════════════════════════════════════════════════════════
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
                title: 'Delete Video?',
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

    // ══════════════════════════════════════════════════════════════════════════
    //  Bulk Delete
    // ══════════════════════════════════════════════════════════════════════════
    if (bulkBtn) {
        bulkBtn.addEventListener('click', function () {
            var ids = Array.from(checkedChecks()).map(function (cb) { return cb.value; });
            if (!ids.length) return;

            var bulkUrl = document.getElementById('vg-bulk-url').getAttribute('data-url');

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
                .then(function (res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function (data) {
                    if (data.success) {
                        toast('success', data.message);
                        ids.forEach(function (id) { fadeRemoveRow(id); });
                        if (checkAll) { checkAll.checked = false; checkAll.indeterminate = false; }
                    } else {
                        toast('error', 'Bulk delete failed.');
                    }
                })
                .catch(function (err) {
                    console.error('Bulk delete error:', err);
                    toast('error', 'Network error. Please try again.');
                });
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
