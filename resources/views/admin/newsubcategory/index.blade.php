@extends('admin.master')
@section('content')

<style>
/* ─── Base ─────────────────────────────────────────── */
.sc-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    flex-wrap: wrap;
    gap: 10px;
}
.page-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
}
.btn-add-sub {
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 9px 20px;
    font-size: .85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    transition: background .18s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-add-sub:hover { background: #1d4ed8; }

/* ─── Card ──────────────────────────────────────────── */
.sub-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,.07);
    overflow: hidden;
}

/* ─── Filter bar ─────────────────────────────────────── */
.filter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
}
.show-select {
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    padding: 7px 30px 7px 11px;
    font-size: .82rem;
    color: #475569;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none;
    cursor: pointer;
}
.show-select:focus { outline: none; border-color: #2563eb; }

.search-wrap {
    position: relative;
    flex: 1;
    max-width: 320px;
    min-width: 160px;
}
.search-wrap input {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    padding: 7px 42px 7px 13px;
    font-size: .82rem;
    color: #334155;
    box-sizing: border-box;
}
.search-wrap input:focus { outline: none; border-color: #2563eb; }
.search-wrap button {
    position: absolute;
    right: 0; top: 0;
    height: 100%; width: 40px;
    background: #2563eb;
    border: none;
    border-radius: 0 7px 7px 0;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.search-wrap button:hover { background: #1d4ed8; }

.trash-icon-btn {
    background: none;
    border: none;
    color: #cbd5e1;
    padding: 5px 7px;
    cursor: pointer;
    font-size: .95rem;
    border-radius: 5px;
    transition: color .15s;
}
.trash-icon-btn:not(:disabled):hover { color: #ef4444; }
.trash-icon-btn.active { color: #ef4444; }
.trash-icon-btn:disabled { opacity: .35; cursor: not-allowed; }

/* ─── Table ──────────────────────────────────────────── */
.sub-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.sub-table thead tr { background: #f8fafc; }
.sub-table thead th {
    padding: 11px 16px;
    font-weight: 600;
    font-size: .78rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .05em;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.sub-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
.sub-table tbody tr:last-child { border-bottom: none; }
.sub-table tbody tr:hover { background: #f8fafc; }
.sub-table tbody td { padding: 11px 16px; color: #334155; vertical-align: middle; }
.sl-num { color: #94a3b8; font-size: .82rem; text-align: center; }
.col-checkbox { width: 44px; }
.col-sl       { width: 64px; text-align: center; }
.col-cat, .col-sub { text-align: center; }
.col-action   { width: 160px; text-align: center; }

/* ─── Action Buttons ─────────────────────────────────── */
.action-btns {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-edit-row {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 13px;
    font-size: .78rem;
    font-weight: 500;
    color: #2563eb;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    cursor: pointer;
    transition: all .15s;
    text-decoration: none;
    white-space: nowrap;
}
.btn-edit-row:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}
.btn-delete-row {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 13px;
    font-size: .78rem;
    font-weight: 500;
    color: #ef4444;
    background: #fff5f5;
    border: 1px solid #fecaca;
    border-radius: 6px;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.btn-delete-row:hover {
    background: #ef4444;
    color: #fff;
    border-color: #ef4444;
}

/* ─── Pagination ─────────────────────────────────────── */
.pagination-wrap {
    padding: 13px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #f1f5f9;
    flex-wrap: wrap;
    gap: 8px;
}
.pagination-wrap .page-info { font-size: .8rem; color: #94a3b8; }
.pagination-wrap .pagination { margin: 0; }
.page-link { font-size: .8rem; color: #2563eb; border-color: #e2e8f0; padding: 4px 10px; }
.page-item.active .page-link { background: #2563eb; border-color: #2563eb; }

/* ─── Modal ──────────────────────────────────────────── */
.sc-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,.45);
    backdrop-filter: blur(2px);
    z-index: 1055;
    align-items: center;
    justify-content: center;
}
.sc-modal-backdrop.open { display: flex; animation: bdFade .18s ease; }
@keyframes bdFade { from{opacity:0} to{opacity:1} }

.sc-modal {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    width: 100%;
    max-width: 460px;
    animation: mdSlide .2s ease;
}
@keyframes mdSlide { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }

.sc-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.sc-modal-header h6 { font-size: .95rem; font-weight: 700; color: #1e293b; margin: 0; }
.sc-modal-close {
    background: none;
    border: none;
    color: #94a3b8;
    font-size: 1rem;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 5px;
    line-height: 1;
    transition: color .15s;
}
.sc-modal-close:hover { color: #334155; background: #f1f5f9; }

.sc-modal-body { padding: 22px 24px 10px; }

.sc-label {
    display: block;
    font-size: .82rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}
.sc-input, .sc-select {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    padding: 9px 13px;
    font-size: .875rem;
    color: #334155;
    background: #fff;
    transition: border .18s;
    outline: none;
    box-sizing: border-box;
}
.sc-input:focus, .sc-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.08);
}
.sc-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    appearance: none;
    padding-right: 32px;
}
.sc-input.is-invalid, .sc-select.is-invalid { border-color: #ef4444 !important; }
.sc-error { font-size: .78rem; color: #ef4444; margin-top: 4px; display: none; }
.sc-error.show { display: block; }

.sc-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px 20px;
}
.btn-sc-cancel {
    background: none;
    border: 1.5px solid #e2e8f0;
    border-radius: 7px;
    padding: 8px 22px;
    font-size: .85rem;
    color: #475569;
    cursor: pointer;
    font-weight: 500;
    transition: all .15s;
}
.btn-sc-cancel:hover { border-color: #94a3b8; color: #334155; }
.btn-sc-save {
    background: #2563eb;
    border: none;
    border-radius: 7px;
    padding: 8px 24px;
    font-size: .85rem;
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-sc-save:hover { background: #1d4ed8; }

.form-check-input { cursor: pointer; }
</style>

<div class="container-fluid py-4">

    {{-- ✅ Header: Title LEFT — Button RIGHT --}}
    <div class="sc-page-header">
        <span class="page-title">Sub Category List</span>
        <button class="btn-add-sub" id="btnOpenCreate">
            <i class="fas fa-plus" style="font-size:.72rem;"></i> Add Sub-category
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3"
             style="font-size:.84rem;" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="sub-card">

        {{-- Filter bar --}}
        <div class="filter-bar">
            <form method="GET" action="{{ route('newssubcategories.index') }}" id="perPageForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="per_page" class="show-select" id="perPageSelect">
                    @foreach([10,25,50,100] as $pp)
                        <option value="{{ $pp }}" @selected(request('per_page',10)==$pp)>
                            Show-{{ $pp }}
                        </option>
                    @endforeach
                </select>
            </form>

            <form method="GET" action="{{ route('newssubcategories.index') }}" class="search-wrap">
                <input type="hidden" name="per_page" value="{{ request('per_page',10) }}">
                <input type="text" name="search" placeholder="Search..."
                       value="{{ request('search') }}">
                <button type="submit">
                    <i class="fas fa-search" style="font-size:.7rem;"></i>
                </button>
            </form>

            <button class="trash-icon-btn ms-auto" id="bulkTrashBtn"
                    title="Delete selected" disabled>
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>

        {{-- Table --}}
        <table class="sub-table">
            <thead>
                <tr>
                    <th class="col-checkbox">
                        <input type="checkbox" class="form-check-input" id="checkAll">
                    </th>
                    <th class="col-sl">SL.</th>
                    <th class="col-cat">Category</th>
                    <th class="col-sub">Sub-Category</th>
                    <th class="col-action">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subcategories as $sub)
                <tr>
                    <td class="col-checkbox">
                        <input type="checkbox" class="form-check-input row-check"
                               value="{{ $sub->id }}">
                    </td>
                    <td class="sl-num">
                        {{ ($subcategories->currentPage()-1)*$subcategories->perPage()+$loop->iteration }}
                    </td>
                    <td class="col-cat">{{ $sub->category->name ?? '—' }}</td>
                    <td class="col-sub">{{ $sub->name }}</td>
                    <td class="col-action">
                        {{-- ✅ Edit & Delete always visible --}}
                        <div class="action-btns">
                            <a href="javascript:void(0)"
                               class="btn-edit-row edit-btn"
                               data-id="{{ $sub->id }}"
                               data-name="{{ $sub->name }}"
                               data-cat="{{ $sub->newscategory_id }}">
                                <i class="fas fa-edit" style="font-size:.7rem;"></i> Edit
                            </a>
                            <button type="button"
                                    class="btn-delete-row delete-btn"
                                    data-id="{{ $sub->id }}">
                                <i class="fas fa-trash-alt" style="font-size:.7rem;"></i> Delete
                            </button>
                        </div>

                        <form id="del-{{ $sub->id }}"
                              action="{{ route('newssubcategories.destroy', $sub->id) }}"
                              method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5" style="color:#94a3b8;">
                        <i class="fas fa-folder-open mb-2 d-block" style="font-size:1.6rem;"></i>
                        No subcategories found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($subcategories->hasPages())
        <div class="pagination-wrap">
            <span class="page-info">
                Showing {{ $subcategories->firstItem() }}–{{ $subcategories->lastItem() }}
                of {{ $subcategories->total() }}
            </span>
            {{ $subcategories->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ══════════════ CREATE MODAL ══════════════ --}}
<div class="sc-modal-backdrop" id="createModalBackdrop">
    <div class="sc-modal">
        <div class="sc-modal-header">
            <h6>
                <i class="fas fa-folder-plus me-2" style="color:#2563eb;font-size:.85rem;"></i>
                Create Sub Category
            </h6>
            <button class="sc-modal-close" id="closeCreateModal">&#10005;</button>
        </div>
        <form id="createForm" action="{{ route('newssubcategories.store') }}" method="POST">
            @csrf
            <div class="sc-modal-body">
                <div class="mb-4">
                    <label class="sc-label">Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" id="create_name"
                           class="sc-input" placeholder="Enter sub-category name" autocomplete="off">
                    <div class="sc-error" id="create_name_err"></div>
                </div>
                <div class="mb-3">
                    <label class="sc-label">Category <span style="color:#ef4444;">*</span></label>
                    <select name="newscategory_id" id="create_cat" class="sc-select">
                        <option value="">Select One</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="sc-error" id="create_cat_err"></div>
                </div>
            </div>
            <div class="sc-modal-footer">
                <button type="button" class="btn-sc-cancel" id="cancelCreateModal">Cancel</button>
                <button type="submit" class="btn-sc-save">
                    <i class="fas fa-save" style="font-size:.78rem;"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT MODAL ══════════════ --}}
<div class="sc-modal-backdrop" id="editModalBackdrop">
    <div class="sc-modal">
        <div class="sc-modal-header">
            <h6>
                <i class="fas fa-edit me-2" style="color:#2563eb;font-size:.85rem;"></i>
                Edit Sub Category
            </h6>
            <button class="sc-modal-close" id="closeEditModal">&#10005;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="sc-modal-body">
                <div class="mb-4">
                    <label class="sc-label">Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" id="edit_name"
                           class="sc-input" placeholder="Enter sub-category name" autocomplete="off">
                    <div class="sc-error" id="edit_name_err"></div>
                </div>
                <div class="mb-3">
                    <label class="sc-label">Category <span style="color:#ef4444;">*</span></label>
                    <select name="newscategory_id" id="edit_cat" class="sc-select">
                        <option value="">Select One</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="sc-error" id="edit_cat_err"></div>
                </div>
            </div>
            <div class="sc-modal-footer">
                <button type="button" class="btn-sc-cancel" id="cancelEditModal">Cancel</button>
                <button type="submit" class="btn-sc-save">
                    <i class="fas fa-save" style="font-size:.78rem;"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Bulk delete form --}}
<form id="bulkForm" action="{{ route('newssubcategories.bulkDestroy') }}"
      method="POST" class="d-none">
    @csrf @method('DELETE')
    <div id="bulkIds"></div>
</form>

<script>
if (typeof jQuery === 'undefined') {
    document.write('<scr' + 'ipt src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"><\/scr' + 'ipt>');
}
</script>

<script>
(function () {
    'use strict';

    /* ─── Modal helpers ──────────────────────────────── */
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }

    /* ─── Create modal ───────────────────────────────── */
    document.getElementById('btnOpenCreate').addEventListener('click', function () {
        clearForm('create');
        openModal('createModalBackdrop');
        setTimeout(function () { document.getElementById('create_name').focus(); }, 180);
    });
    document.getElementById('closeCreateModal').addEventListener('click',  function () { closeModal('createModalBackdrop'); });
    document.getElementById('cancelCreateModal').addEventListener('click', function () { closeModal('createModalBackdrop'); });

    /* ─── Edit modal ─────────────────────────────────── */
    document.getElementById('closeEditModal').addEventListener('click',  function () { closeModal('editModalBackdrop'); });
    document.getElementById('cancelEditModal').addEventListener('click', function () { closeModal('editModalBackdrop'); });

    /* ─── Backdrop click closes ──────────────────────── */
    ['createModalBackdrop', 'editModalBackdrop'].forEach(function (id) {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) closeModal(id);
        });
    });

    /* ─── ESC key ────────────────────────────────────── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal('createModalBackdrop');
            closeModal('editModalBackdrop');
        }
    });

    /* ─── Edit button click ──────────────────────────── */
    document.querySelectorAll('.edit-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id   = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            var cat  = this.getAttribute('data-cat');

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_cat').value  = cat;
            document.getElementById('editForm').action = '/newssubcategories/' + id;

            clearErrors('edit');
            openModal('editModalBackdrop');
            setTimeout(function () { document.getElementById('edit_name').focus(); }, 180);
        });
    });

    /* ─── Delete button click ────────────────────────── */
    document.querySelectorAll('.delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            if (confirm('Delete this subcategory?')) {
                document.getElementById('del-' + id).submit();
            }
        });
    });

    /* ─── Validation ─────────────────────────────────── */
    function validateForm(prefix) {
        var valid = true;
        clearErrors(prefix);
        var name = document.getElementById(prefix + '_name').value.trim();
        var cat  = document.getElementById(prefix + '_cat').value;
        if (!name) { showError(prefix + '_name', prefix + '_name_err', 'Name is required.'); valid = false; }
        if (!cat)  { showError(prefix + '_cat',  prefix + '_cat_err',  'Please select a category.'); valid = false; }
        return valid;
    }
    function showError(inputId, errId, msg) {
        document.getElementById(inputId).classList.add('is-invalid');
        var el = document.getElementById(errId);
        el.textContent = msg;
        el.classList.add('show');
    }
    function clearErrors(prefix) {
        [prefix + '_name', prefix + '_cat'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.classList.remove('is-invalid');
        });
        [prefix + '_name_err', prefix + '_cat_err'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) { el.textContent = ''; el.classList.remove('show'); }
        });
    }
    function clearForm(prefix) {
        document.getElementById(prefix + '_name').value = '';
        document.getElementById(prefix + '_cat').value  = '';
        clearErrors(prefix);
    }

    document.getElementById('createForm').addEventListener('submit', function (e) {
        if (!validateForm('create')) e.preventDefault();
    });
    document.getElementById('editForm').addEventListener('submit', function (e) {
        if (!validateForm('edit')) e.preventDefault();
    });

    /* ─── Check-all ──────────────────────────────────── */
    var checkAll = document.getElementById('checkAll');
    checkAll.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(function (c) { c.checked = checkAll.checked; });
        updateBulkBtn();
    });
    document.querySelectorAll('.row-check').forEach(function (c) {
        c.addEventListener('change', function () {
            var all = document.querySelectorAll('.row-check');
            checkAll.checked = Array.from(all).every(function (c) { return c.checked; });
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
        if (!confirm('Delete ' + ids.length + ' subcategory(ies)?')) return;
        var container = document.getElementById('bulkIds');
        container.innerHTML = ids.map(function (id) {
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
