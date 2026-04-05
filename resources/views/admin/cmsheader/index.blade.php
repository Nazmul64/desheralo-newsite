@extends('admin.master')
<style>
    /* ── CMS Header Index ── */
    .cmsh-page-title {
        font-family: 'Nunito', sans-serif;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.3px;
        color: #1a2236;
    }
    .cmsh-add-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 9px 22px;
        font-size: .875rem;
        font-weight: 700;
        letter-spacing: .2px;
        box-shadow: 0 4px 14px rgba(37,99,235,.35);
        transition: all .22s ease;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .cmsh-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,.45);
        color: #fff;
    }
    .cmsh-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(30,41,59,.07);
        overflow: hidden;
    }
    /* Toolbar */
    .cmsh-toolbar {
        background: #f8fafc;
        border-bottom: 1px solid #e8edf5;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cmsh-show-select {
        border: 1.5px solid #d1d9e6;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: .82rem;
        font-weight: 600;
        color: #374151;
        background: #fff;
        cursor: pointer;
        outline: none;
        transition: border-color .18s;
    }
    .cmsh-show-select:focus { border-color: #2563eb; }
    .cmsh-search-wrap {
        display: flex;
        gap: 0;
        margin-left: auto;
    }
    .cmsh-search-input {
        border: 1.5px solid #d1d9e6;
        border-right: none;
        border-radius: 8px 0 0 8px;
        padding: 7px 14px;
        font-size: .84rem;
        outline: none;
        transition: border-color .18s;
        width: 220px;
    }
    .cmsh-search-input:focus { border-color: #2563eb; }
    .cmsh-search-btn {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: none;
        border-radius: 0 8px 8px 0;
        padding: 7px 16px;
        color: #fff;
        cursor: pointer;
        transition: opacity .18s;
    }
    .cmsh-search-btn:hover { opacity: .88; }
    /* Table */
    .cmsh-table { margin: 0; }
    .cmsh-table thead tr th {
        background: #f1f5f9;
        color: #64748b;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .6px;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        padding: 13px 16px;
        white-space: nowrap;
    }
    .cmsh-table tbody tr {
        border-bottom: 1px solid #f0f4f8;
        transition: background .15s;
    }
    .cmsh-table tbody tr:hover { background: #f8fbff; }
    .cmsh-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: .875rem;
        color: #374151;
    }
    /* Image cell */
    .cmsh-img {
        width: 320px;
        height: 88px;
        object-fit: cover;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        transition: transform .22s, box-shadow .22s;
    }
    .cmsh-img:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(0,0,0,.12);
    }
    /* Name badge */
    .cmsh-name-badge {
        font-weight: 700;
        font-size: .88rem;
        color: #1e293b;
        background: #f1f5f9;
        border-radius: 7px;
        padding: 5px 12px;
        display: inline-block;
    }
    /* Toggle */
    .cmsh-switch .form-check-input {
        width: 42px;
        height: 22px;
        cursor: pointer;
        border-radius: 20px;
        transition: background .2s;
    }
    .cmsh-switch .form-check-input:checked { background-color: #2563eb; border-color: #2563eb; }
    /* Action btn */
    .cmsh-action-btn {
        background: #f1f5f9;
        border: none;
        border-radius: 8px;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .18s, transform .15s;
        color: #64748b;
        font-size: 1.1rem;
    }
    .cmsh-action-btn:hover {
        background: #e2e8f0;
        transform: scale(1.08);
        color: #1e293b;
    }
    .cmsh-dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,.12);
        padding: 6px;
        min-width: 150px;
    }
    .cmsh-dropdown-item {
        border-radius: 8px;
        padding: 8px 14px;
        font-size: .84rem;
        font-weight: 600;
        transition: background .15s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cmsh-dropdown-item:hover { background: #f1f5f9; }
    /* Bulk trash */
    .cmsh-bulk-trash {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 1.25rem;
        cursor: pointer;
        transition: transform .15s;
        padding: 0;
    }
    .cmsh-bulk-trash:hover { transform: scale(1.15); }
    /* SL number */
    .cmsh-sl {
        font-size: .82rem;
        font-weight: 700;
        color: #94a3b8;
        background: #f8fafc;
        border-radius: 6px;
        padding: 4px 9px;
        display: inline-block;
    }
    /* Pagination */
    .cmsh-pagination { padding: 14px 20px; }
    .cmsh-pagination .page-link {
        border-radius: 7px !important;
        border: 1.5px solid #e2e8f0;
        color: #374151;
        font-size: .82rem;
        font-weight: 600;
        margin: 0 2px;
        transition: all .15s;
    }
    .cmsh-pagination .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }
    .cmsh-pagination .page-link:hover { background: #eff6ff; border-color: #2563eb; color: #2563eb; }
    /* Alert */
    .cmsh-alert {
        border: none;
        border-left: 4px solid #22c55e;
        background: #f0fdf4;
        border-radius: 10px;
        font-size: .875rem;
        color: #166534;
        font-weight: 600;
    }
</style>


@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="cmsh-page-title">Header List</span>
        </div>
        <a href="{{ route('cmsheader.create') }}" class="cmsh-add-btn">
            <i class="bi bi-plus-lg"></i> Add Header
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert cmsh-alert alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="cmsh-card card">
        <div class="card-body p-0">

            {{-- Toolbar --}}
            <div class="cmsh-toolbar">
                {{-- Bulk trash --}}
                <button id="headerBulkDeleteBtn" class="cmsh-bulk-trash d-none" title="Delete selected">
                    <i class="bi bi-trash3-fill"></i>
                </button>

                {{-- Show per page --}}
                <form method="GET" action="{{ route('cmsheader.index') }}" class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="show" class="cmsh-show-select" onchange="this.form.submit()">
                        @foreach([10,25,50,100] as $n)
                            <option value="{{ $n }}" @selected($perPage==$n)>Show- {{ $n }}</option>
                        @endforeach
                    </select>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('cmsheader.index') }}" class="cmsh-search-wrap">
                    <input type="hidden" name="show" value="{{ $perPage }}">
                    <input type="text" name="search" class="cmsh-search-input" placeholder="Search..." value="{{ $search }}">
                    <button class="cmsh-search-btn" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table cmsh-table mb-0">
                    <thead>
                        <tr>
                            <th width="44">
                                <input type="checkbox" id="checkAll" class="form-check-input" style="width:17px;height:17px;cursor:pointer;">
                            </th>
                            <th width="52">SL.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Is_Active</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cmsheaders as $i => $header)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-check"
                                       value="{{ $header->id }}"
                                       style="width:17px;height:17px;cursor:pointer;">
                            </td>
                            <td><span class="cmsh-sl">{{ $cmsheaders->firstItem() + $i }}</span></td>
                            <td>
                                @if($header->image)
                                    <img src="{{ asset($header->image) }}"
                                         alt="{{ $header->name }}"
                                         class="cmsh-img">
                                @else
                                    <div style="width:320px;height:88px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-image text-muted fs-3"></i>
                                    </div>
                                @endif
                            </td>
                            <td><span class="cmsh-name-badge">{{ $header->name }}</span></td>

                            <td>
                                <div class="form-check form-switch cmsh-switch" style="padding-left:0;">
                                    <input class="form-check-input toggle-switch ms-0"
                                           type="checkbox"
                                           data-id="{{ $header->id }}"
                                           data-field="is_active"
                                           {{ $header->is_active ? 'checked' : '' }}>
                                </div>
                            </td>

                            <td>
                                <div class="form-check form-switch cmsh-switch" style="padding-left:0;">
                                    <input class="form-check-input toggle-switch ms-0"
                                           type="checkbox"
                                           data-id="{{ $header->id }}"
                                           data-field="status"
                                           {{ $header->status ? 'checked' : '' }}>
                                </div>
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="cmsh-action-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu cmsh-dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item cmsh-dropdown-item"
                                               href="{{ route('cmsheader.edit', $header->id) }}">
                                                <i class="bi bi-pencil-square text-primary"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('cmsheader.destroy', $header->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this header?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="dropdown-item cmsh-dropdown-item text-danger"
                                                        style="width:100%;border:none;background:none;text-align:left;">
                                                    <i class="bi bi-trash3"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <span class="text-muted fw-600">No headers found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end cmsh-pagination">
                {{ $cmsheaders->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Bulk Delete Form --}}
<form id="bulkDeleteForm" action="{{ route('cmsheader.bulkDestroy') }}" method="POST">
    @csrf @method('DELETE')
    <input type="hidden" name="ids" id="bulkIds">
</form>


<script>
// Toggle Switch
document.querySelectorAll('.toggle-switch').forEach(function(toggle) {
    toggle.addEventListener('change', function() {
        fetch(`/admin/cmsheader/${this.dataset.id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ field: this.dataset.field })
        });
    });
});

// Check All
const checkAll  = document.getElementById('checkAll');
const trashIcon = document.getElementById('headerBulkDeleteBtn');

checkAll.addEventListener('change', function() {
    document.querySelectorAll('.row-check').forEach(c => c.checked = this.checked);
    trashIcon.classList.toggle('d-none', !this.checked);
});

document.querySelectorAll('.row-check').forEach(function(c) {
    c.addEventListener('change', function() {
        const anyChecked = [...document.querySelectorAll('.row-check')].some(x => x.checked);
        trashIcon.classList.toggle('d-none', !anyChecked);
        checkAll.checked = document.querySelectorAll('.row-check').length ===
                           document.querySelectorAll('.row-check:checked').length;
    });
});

// Bulk Delete
trashIcon.addEventListener('click', function() {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(x => x.value);
    if (!ids.length) return;
    if (!confirm('Delete selected headers?')) return;
    document.getElementById('bulkIds').value = ids.join(',');
    document.getElementById('bulkDeleteForm').submit();
});
</script>

@endsection
