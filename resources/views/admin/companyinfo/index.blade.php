@extends('admin.master')

@section('content')
<style>
.ci-header { display:flex; align-items:center; justify-content:space-between; padding:1.5rem 1.75rem 1rem; border-bottom:1px solid #f0f0f0; }
.ci-title { font-size:1.1rem; font-weight:600; color:#111; letter-spacing:-0.02em; }
.ci-btn-add {
    display:inline-flex; align-items:center; gap:6px;
    background:#2563eb; color:#fff; border:none;
    padding:8px 18px; border-radius:8px; font-size:13.5px; font-weight:500;
    cursor:pointer; transition:background .15s;
}
.ci-btn-add:hover { background:#1d4ed8; }
.ci-toolbar { display:flex; align-items:center; gap:10px; padding:.9rem 1.75rem; background:#fafafa; border-bottom:1px solid #f0f0f0; flex-wrap:wrap; }
.ci-select {
    border:1px solid #e5e7eb; border-radius:7px; padding:6px 10px;
    font-size:13px; color:#374151; background:#fff; outline:none;
    cursor:pointer; transition:border .15s;
}
.ci-select:focus { border-color:#2563eb; }
.ci-search-wrap { display:flex; gap:6px; }
.ci-search-input {
    border:1px solid #e5e7eb; border-radius:7px; padding:6px 12px;
    font-size:13px; width:210px; outline:none; transition:border .15s;
}
.ci-search-input:focus { border-color:#2563eb; }
.ci-search-btn {
    background:#2563eb; color:#fff; border:none;
    border-radius:7px; padding:6px 14px; cursor:pointer;
    display:flex; align-items:center; font-size:13px; transition:background .15s;
}
.ci-search-btn:hover { background:#1d4ed8; }
.ci-bulk-btn {
    margin-left:auto; background:#fff; border:1px solid #e5e7eb;
    border-radius:7px; padding:6px 12px; cursor:pointer; color:#6b7280;
    transition:border .15s, color .15s;
}
.ci-bulk-btn:hover { border-color:#ef4444; color:#ef4444; }
.ci-table-wrap { overflow-x:auto; }
.ci-table { width:100%; border-collapse:collapse; font-size:13.5px; }
.ci-table thead tr { background:#f8f9fb; }
.ci-table thead th {
    padding:11px 14px; text-align:left; font-weight:600;
    color:#6b7280; font-size:12px; text-transform:uppercase;
    letter-spacing:.04em; white-space:nowrap; border-bottom:1px solid #f0f0f0;
}
.ci-table tbody tr { border-bottom:1px solid #f7f7f7; transition:background .12s; }
.ci-table tbody tr:hover { background:#f9fafb; }
.ci-table tbody td { padding:11px 14px; color:#374151; vertical-align:middle; }
.ci-badge-name {
    font-weight:600; color:#111; background:#f0f4ff;
    padding:3px 10px; border-radius:20px; font-size:12.5px; display:inline-block;
}
.ci-email { color:#2563eb; font-size:13px; }
.ci-phone { color:#374151; font-size:13px; font-weight:500; }
.ci-msg { color:#9ca3af; font-size:12.5px; max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ci-toggle { position:relative; display:inline-block; width:40px; height:22px; }
.ci-toggle input { opacity:0; width:0; height:0; }
.ci-slider {
    position:absolute; inset:0; background:#d1d5db; border-radius:22px; cursor:pointer; transition:.3s;
}
.ci-slider:before {
    content:""; position:absolute; height:16px; width:16px; left:3px; bottom:3px;
    background:#fff; border-radius:50%; transition:.3s;
}
input:checked + .ci-slider { background:#2563eb; }
input:checked + .ci-slider:before { transform:translateX(18px); }
.ci-action-btn {
    background:none; border:none; cursor:pointer; color:#9ca3af;
    padding:4px 8px; border-radius:6px; transition:background .12s, color .12s;
    font-size:16px;
}
.ci-action-btn:hover { background:#f3f4f6; color:#111; }
.ci-dropdown { position:relative; display:inline-block; }
.ci-dropdown-menu {
    display:none; position:absolute; right:0; top:calc(100% + 4px);
    background:#fff; border:1px solid #e5e7eb; border-radius:10px;
    box-shadow:0 8px 24px rgba(0,0,0,.08); min-width:140px; z-index:999; overflow:hidden;
}
.ci-dropdown:hover .ci-dropdown-menu,
.ci-dropdown.open .ci-dropdown-menu { display:block; }
.ci-dropdown-item {
    display:flex; align-items:center; gap:8px; padding:9px 14px;
    font-size:13px; color:#374151; cursor:pointer; transition:background .12s;
    text-decoration:none; background:none; border:none; width:100%;
}
.ci-dropdown-item:hover { background:#f3f4f6; }
.ci-dropdown-item.danger { color:#ef4444; }
.ci-dropdown-item.danger:hover { background:#fef2f2; }
.ci-del-btn { background:none; border:none; cursor:pointer; color:#d1d5db; padding:3px; transition:color .12s; }
.ci-del-btn:hover { color:#ef4444; }
.ci-empty { text-align:center; color:#9ca3af; padding:3rem; font-size:14px; }
.ci-pagination { padding:.75rem 1.75rem; border-top:1px solid #f0f0f0; }
.ci-check { accent-color:#2563eb; width:15px; height:15px; cursor:pointer; }
.ci-card { background:#fff; border-radius:14px; border:1px solid #f0f0f0; overflow:hidden; }
.ci-sl { color:#9ca3af; font-size:12px; font-weight:600; }
.ci-alert {
    margin:1rem 1.75rem 0; padding:10px 16px; border-radius:8px;
    background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; font-size:13.5px;
}
</style>

<div style="padding:1.5rem 1.75rem 1.75rem; max-width:1400px;">

    {{-- Alert --}}
    @if(session('success'))
    <div class="ci-alert">✓ {{ session('success') }}</div>
    @endif

    {{-- Card --}}
    <div class="ci-card" style="margin-top:1rem;">

        {{-- Header --}}
        <div class="ci-header">
            <span class="ci-title">Company Info</span>
            <button class="ci-btn-add" data-bs-toggle="modal" data-bs-target="#createModal">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Add Info
            </button>
        </div>

        {{-- Toolbar --}}
        <div class="ci-toolbar">
            <form method="GET" action="{{ route('companyinfo.index') }}" id="showForm">
                <input type="hidden" name="search" value="{{ $search }}">
                <select name="show" class="ci-select" onchange="document.getElementById('showForm').submit()">
                    @foreach([10,25,50,100] as $n)
                        <option value="{{ $n }}" {{ $show==$n?'selected':'' }}>Show {{ $n }}</option>
                    @endforeach
                </select>
            </form>

            <form method="GET" action="{{ route('companyinfo.index') }}" class="ci-search-wrap">
                <input type="hidden" name="show" value="{{ $show }}">
                <input type="text" name="search" value="{{ $search }}" class="ci-search-input" placeholder="Search name, email, phone…">
                <button type="submit" class="ci-search-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </button>
            </form>

            <form method="POST" action="{{ route('companyinfo.bulkDestroy') }}" id="bulkDeleteForm" style="margin-left:auto;">
                @csrf @method('DELETE')
                <input type="hidden" name="ids" id="bulkIds">
                <button type="button" onclick="confirmBulkDelete()" class="ci-bulk-btn" title="Delete selected">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="ci-table-wrap">
            <table class="ci-table">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="selectAll" class="ci-check"></th>
                        <th style="width:36px;"></th>
                        <th>SL.</th>
                        <th>Name</th>
                        <th>Address Line 1</th>
                        <th>Address Line 2</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companyinfos as $i => $item)
                    <tr>
                        <td><input type="checkbox" class="ci-check row-check" value="{{ $item->id }}"></td>
                        <td>
                            <form method="POST" action="{{ route('companyinfo.destroy', $item->id) }}"
                                  onsubmit="return confirm('Delete this record?')">
                                @csrf @method('DELETE')
                                <button class="ci-del-btn" title="Delete">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </td>
                        <td><span class="ci-sl">{{ $companyinfos->firstItem() + $i }}</span></td>
                        <td><span class="ci-badge-name">{{ $item->name }}</span></td>
                        <td>{{ $item->address_line1 }}</td>
                        <td>{{ $item->address_line2 }}</td>
                        <td><span class="ci-email">{{ $item->email }}</span></td>
                        <td><span class="ci-phone">{{ $item->phone }}</span></td>
                        <td><span class="ci-msg" title="{{ $item->message }}">{{ \Str::limit($item->message, 22) }}</span></td>
                        <td>
                            <label class="ci-toggle">
                                <input type="checkbox" class="toggle-status"
                                       data-id="{{ $item->id }}" {{ $item->status?'checked':'' }}>
                                <span class="ci-slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="ci-dropdown">
                                <button class="ci-action-btn">⋮</button>
                                <div class="ci-dropdown-menu">
                                    <a class="ci-dropdown-item" href="{{ route('companyinfo.edit', $item->id) }}">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('companyinfo.destroy', $item->id) }}"
                                          onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="ci-dropdown-item danger">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="ci-empty">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($companyinfos->hasPages())
        <div class="ci-pagination">{{ $companyinfos->links() }}</div>
        @endif
    </div>
</div>

{{-- ===== CREATE MODAL ===== --}}
<style>
.ci-modal-backdrop { display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:1050; align-items:center; justify-content:center; }
.ci-modal-backdrop.show { display:flex; }
.ci-modal {
    background:#fff; border-radius:16px; width:90%; max-width:720px;
    max-height:90vh; overflow-y:auto; box-shadow:0 24px 64px rgba(0,0,0,.18);
    animation:modalIn .2s ease;
}
@keyframes modalIn { from{transform:translateY(18px);opacity:0} to{transform:none;opacity:1} }
.ci-modal-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:1.25rem 1.5rem .75rem; border-bottom:1px solid #f0f0f0;
}
.ci-modal-title { font-size:1rem; font-weight:600; color:#111; }
.ci-modal-close {
    background:none; border:none; cursor:pointer; color:#9ca3af;
    font-size:20px; line-height:1; padding:2px 6px; border-radius:6px; transition:background .12s;
}
.ci-modal-close:hover { background:#f3f4f6; color:#111; }
.ci-modal-body { padding:1.25rem 1.5rem; }
.ci-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.ci-form-group { display:flex; flex-direction:column; gap:5px; }
.ci-form-group label { font-size:12px; font-weight:600; color:#6b7280; letter-spacing:.04em; text-transform:uppercase; }
.ci-form-control {
    border:1.5px solid #e5e7eb; border-radius:8px; padding:9px 12px;
    font-size:13.5px; color:#111; background:#fff; outline:none;
    transition:border .15s, box-shadow .15s; width:100%; box-sizing:border-box;
}
.ci-form-control:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.ci-form-control::placeholder { color:#c4c9d4; }
textarea.ci-form-control { resize:vertical; min-height:80px; }
.ci-modal-foot { display:flex; justify-content:center; gap:12px; padding:.75rem 1.5rem 1.25rem; }
.ci-btn-cancel {
    padding:9px 28px; border-radius:8px; font-size:13.5px; font-weight:500;
    border:1.5px solid #fca5a5; color:#ef4444; background:#fff;
    cursor:pointer; transition:background .15s, color .15s;
}
.ci-btn-cancel:hover { background:#fef2f2; }
.ci-btn-save {
    padding:9px 32px; border-radius:8px; font-size:13.5px; font-weight:500;
    border:none; background:#2563eb; color:#fff; cursor:pointer; transition:background .15s;
}
.ci-btn-save:hover { background:#1d4ed8; }
@media(max-width:600px){ .ci-form-grid{grid-template-columns:1fr;} }
</style>

<div class="ci-modal-backdrop" id="createModal">
    <div class="ci-modal">
        <div class="ci-modal-head">
            <span class="ci-modal-title">Create Company</span>
            <button class="ci-modal-close" onclick="closeModal()">×</button>
        </div>
        <form method="POST" action="{{ route('companyinfo.store') }}">
            @csrf
            <div class="ci-modal-body">
                <div class="ci-form-grid">
                    <div class="ci-form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="ci-form-control" placeholder="Enter name" required>
                    </div>
                    <div class="ci-form-group">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line1" class="ci-form-control" placeholder="Enter address">
                    </div>
                    <div class="ci-form-group">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line2" class="ci-form-control" placeholder="Enter address">
                    </div>
                    <div class="ci-form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="ci-form-control" placeholder="Enter phone">
                    </div>
                    <div class="ci-form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="ci-form-control" placeholder="Enter email">
                    </div>
                    <div class="ci-form-group">
                        <label>Location Map</label>
                        <textarea name="location_map" class="ci-form-control" placeholder="map url"></textarea>
                    </div>
                    <div class="ci-form-group">
                        <label>Message</label>
                        <textarea name="message" class="ci-form-control"></textarea>
                    </div>
                    <div class="ci-form-group">
                        <label>Copyright</label>
                        <textarea name="copyright" class="ci-form-control"></textarea>
                    </div>
                    <div class="ci-form-group">
                        <label>Version</label>
                        <input type="text" name="version" class="ci-form-control">
                    </div>
                </div>
            </div>
            <div class="ci-modal-foot">
                <button type="button" class="ci-btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="ci-btn-save">Save</button>
            </div>
        </form>
    </div>
</div>


<script>
// Modal open/close (Bootstrap-free fallback)
function openModal() { document.getElementById('createModal').classList.add('show'); }
function closeModal() { document.getElementById('createModal').classList.remove('show'); }
document.getElementById('createModal').addEventListener('click', function(e) {
    if(e.target === this) closeModal();
});

// Wire "Add Info" button if Bootstrap data-bs attributes aren't used
document.querySelectorAll('[data-bs-target="#createModal"]').forEach(btn => {
    btn.addEventListener('click', openModal);
});

// Select All
document.getElementById('selectAll').addEventListener('change', function(){
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});

// Bulk Delete
function confirmBulkDelete() {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(cb => cb.value);
    if(!ids.length){ alert('Please select at least one record.'); return; }
    if(!confirm('Delete selected records?')) return;
    document.getElementById('bulkIds').value = ids.join(',');
    document.getElementById('bulkDeleteForm').submit();
}

// Dropdown toggle
document.querySelectorAll('.ci-dropdown').forEach(dd => {
    dd.querySelector('.ci-action-btn').addEventListener('click', function(e){
        e.stopPropagation();
        dd.classList.toggle('open');
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.ci-dropdown.open').forEach(dd => dd.classList.remove('open'));
});

// Toggle status AJAX
document.querySelectorAll('.toggle-status').forEach(toggle => {
    toggle.addEventListener('change', function(){
        fetch(`/admin/companyinfo/${this.dataset.id}/toggle-status`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        });
    });
});
</script>

@endsection
