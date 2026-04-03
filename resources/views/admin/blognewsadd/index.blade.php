{{-- resources/views/admin/blognewsadd/index.blade.php --}}
@extends('admin.master')

@section('content')
<style>
    :root {
        --nw-primary: #1a56db;
        --nw-primary-light: #e8f0fe;
        --nw-danger: #e02424;
        --nw-success: #057a55;
        --nw-surface: #ffffff;
        --nw-bg: #f4f6fb;
        --nw-border: #e5e9f2;
        --nw-text: #1f2937;
        --nw-muted: #6b7280;
        --nw-radius: 10px;
        --nw-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    }
    .nw-wrap { background:var(--nw-bg); min-height:100vh; padding:28px 0; }
    .nw-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .nw-title { font-size:20px; font-weight:700; color:var(--nw-text); }
    .nw-title span { color:var(--nw-primary); }
    .nw-btn-add {
        display:inline-flex; align-items:center; gap:7px;
        background:var(--nw-primary); color:#fff;
        padding:9px 18px; border-radius:8px; font-size:13px; font-weight:600;
        text-decoration:none; transition:background .2s;
        box-shadow:0 2px 8px rgba(26,86,219,.25);
    }
    .nw-btn-add:hover { background:#1648c0; color:#fff; }
    .nw-alert {
        display:flex; align-items:center; gap:10px;
        background:#ecfdf5; border:1px solid #6ee7b7; color:#065f46;
        padding:11px 16px; border-radius:8px; font-size:13.5px; font-weight:500; margin-bottom:18px;
    }
    .nw-alert-close { margin-left:auto; background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; }
    .nw-card { background:var(--nw-surface); border-radius:var(--nw-radius); box-shadow:var(--nw-shadow); border:1px solid var(--nw-border); overflow:hidden; }
    .nw-card-body { padding:20px 22px; }
    .nw-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:18px; }
    .nw-toolbar-left { display:flex; align-items:center; gap:10px; }
    .nw-show-wrap { display:flex; align-items:center; }
    .nw-show-label { padding:7px 12px; background:#f9fafb; border:1px solid var(--nw-border); border-right:none; border-radius:7px 0 0 7px; font-size:12px; color:var(--nw-muted); white-space:nowrap; }
    .nw-show-select { padding:7px 10px; border:1px solid var(--nw-border); background:#fff; border-radius:0 7px 7px 0; font-size:13px; color:var(--nw-text); outline:none; cursor:pointer; }
    .nw-bulk-btn { display:none; align-items:center; gap:6px; background:#fff3f3; color:var(--nw-danger); border:1px solid #fecaca; padding:7px 14px; border-radius:7px; font-size:12.5px; font-weight:600; cursor:pointer; transition:background .2s; }
    .nw-bulk-btn:hover { background:#fee2e2; }
    .nw-bulk-btn.visible { display:inline-flex; }
    .nw-search-form { display:flex; align-items:center; gap:8px; }
    .nw-search-input { padding:8px 14px; border:1px solid var(--nw-border); border-radius:7px; font-size:13px; color:var(--nw-text); width:220px; outline:none; transition:border-color .2s, box-shadow .2s; }
    .nw-search-input:focus { border-color:var(--nw-primary); box-shadow:0 0 0 3px rgba(26,86,219,.1); }
    .nw-search-btn { padding:8px 16px; background:var(--nw-primary); color:#fff; border:none; border-radius:7px; font-size:13px; cursor:pointer; transition:background .2s; }
    .nw-search-btn:hover { background:#1648c0; }
    .nw-table-wrap { overflow-x:auto; }
    .nw-table { width:100%; border-collapse:collapse; font-size:13px; color:var(--nw-text); min-width:1500px; }
    .nw-table thead tr { border-bottom:2px solid var(--nw-border); }
    .nw-table thead th { padding:11px 12px; text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:var(--nw-muted); white-space:nowrap; background:#fafbfd; }
    .nw-table thead th.center { text-align:center; }
    .nw-table tbody tr { border-bottom:1px solid var(--nw-border); transition:background .15s; }
    .nw-table tbody tr:last-child { border-bottom:none; }
    .nw-table tbody tr:hover { background:#fafcff; }
    .nw-table tbody tr.selected-row { background:#eff6ff; }
    .nw-table td { padding:11px 12px; vertical-align:middle; }
    .nw-table td.center { text-align:center; }
    .nw-check { width:15px; height:15px; cursor:pointer; accent-color:var(--nw-primary); }
    .nw-sl { color:var(--nw-muted); font-size:12px; font-weight:600; }
    .nw-thumb { width:52px; height:40px; object-fit:cover; border-radius:6px; border:1px solid var(--nw-border); }
    .nw-thumb-ph { width:52px; height:40px; background:#f3f4f6; border-radius:6px; border:1px solid var(--nw-border); display:flex; align-items:center; justify-content:center; color:#d1d5db; }
    .nw-title-cell { font-weight:600; color:var(--nw-text); line-height:1.4; font-size:13px; }
    .nw-title-id { font-size:11px; color:#9ca3af; margin-top:2px; }
    .nw-truncate { max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:12px; color:var(--nw-muted); }
    .nw-none { color:#d1d5db; font-size:12px; }
    .nw-badge { display:inline-block; padding:2px 9px; border-radius:20px; font-size:11px; font-weight:600; }
    .nw-badge-cat { background:#e8f0fe; color:var(--nw-primary); }
    .nw-badge-sub { background:#f0fdf4; color:#166534; }
    .nw-badge-sp { background:#fdf4ff; color:#7e22ce; }
    .nw-badge-rep { background:#fff7ed; color:#c2410c; }
    .nw-tags-wrap { display:flex; flex-wrap:wrap; gap:3px; max-width:140px; }
    .nw-tag-item { display:inline-block; padding:1px 6px; background:#f1f5f9; color:#475569; border-radius:20px; font-size:10.5px; }
    /* meta keyword badge - আলাদা রঙ */
    .nw-kw-item { display:inline-block; padding:1px 6px; background:#fef9c3; color:#854d0e; border-radius:20px; font-size:10.5px; border:1px solid #fde68a; }
    .nw-toggle-wrap { display:flex; justify-content:center; }
    .nw-toggle { position:relative; width:40px; height:21px; }
    .nw-toggle input { display:none; }
    .nw-slider { position:absolute; inset:0; background:#e5e7eb; border-radius:21px; cursor:pointer; transition:background .25s; }
    .nw-slider::before { content:''; position:absolute; left:3px; top:3px; width:15px; height:15px; background:#fff; border-radius:50%; transition:transform .25s; box-shadow:0 1px 4px rgba(0,0,0,.15); }
    .nw-toggle input:checked + .nw-slider { background:#10b981; }
    .nw-toggle input:checked + .nw-slider::before { transform:translateX(19px); }
    .nw-toggle input:checked + .nw-slider.breaking { background:#f59e0b; }
    .nw-actions { display:flex; align-items:center; justify-content:center; gap:5px; }
    .nw-btn { display:inline-flex; align-items:center; gap:4px; padding:5px 10px; border-radius:6px; font-size:11.5px; font-weight:600; text-decoration:none; white-space:nowrap; transition:background .15s; cursor:pointer; border:none; font-family:inherit; }
    .nw-btn-view { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .nw-btn-view:hover { background:#dbeafe; color:#1d4ed8; }
    .nw-btn-edit { background:#fffbeb; color:#b45309; border:1px solid #fde68a; }
    .nw-btn-edit:hover { background:#fef3c7; color:#b45309; }
    .nw-btn-del { background:#fff5f5; color:var(--nw-danger); border:1px solid #fecaca; }
    .nw-btn-del:hover { background:#fee2e2; }
    .nw-empty { text-align:center; padding:52px 20px; }
    .nw-empty-icon { font-size:40px; color:#e5e7eb; margin-bottom:12px; }
    .nw-empty p { color:var(--nw-muted); font-size:14px; }
    .nw-pagination { display:flex; justify-content:flex-end; padding-top:16px; }
    .nw-date { font-size:12px; color:var(--nw-muted); white-space:nowrap; }
</style>

<div class="nw-wrap container-fluid">

    <div class="nw-header">
        <h4 class="nw-title">News <span>Articles</span></h4>
        <a href="{{ route('blognewsadd.create') }}" class="nw-btn-add">
            <i class="fas fa-plus"></i> Add News
        </a>
    </div>

    @if(session('success'))
        <div class="nw-alert" id="nw-alert">
            <i class="fas fa-check-circle" style="color:#059669"></i>
            {{ session('success') }}
            <button class="nw-alert-close" onclick="document.getElementById('nw-alert').remove()">&times;</button>
        </div>
    @endif

    <div class="nw-card">
        <div class="nw-card-body">

            <div class="nw-toolbar">
                <div class="nw-toolbar-left">
                    <form method="GET" action="{{ route('blognewsadd.index') }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <div class="nw-show-wrap">
                            <span class="nw-show-label">Show</span>
                            <select name="show" class="nw-show-select" onchange="this.form.submit()">
                                @foreach([10, 25, 50, 100] as $val)
                                    <option value="{{ $val }}" {{ $perPage == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button class="nw-bulk-btn" id="bulkDeleteBtn" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash-alt"></i>
                        <span id="bulkCount">0</span> Delete Selected
                    </button>
                </div>
                <form method="GET" action="{{ route('blognewsadd.index') }}" class="nw-search-form">
                    <input type="hidden" name="show" value="{{ $perPage }}">
                    <input type="text" name="search" value="{{ $search }}"
                           class="nw-search-input" placeholder="Search title, tags, reporter…">
                    <button type="submit" class="nw-search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="nw-table-wrap">
                <table class="nw-table">
                    <thead>
                        <tr>
                            <th style="width:36px"><input type="checkbox" class="nw-check" id="checkAll"></th>
                            <th style="width:42px" class="center">SL</th>
                            <th style="width:64px" class="center">Image</th>
                            <th style="min-width:180px">Title</th>
                            <th style="min-width:130px">Summary</th>
                            <th style="min-width:120px">Category</th>
                            <th style="min-width:120px">Sub-Category</th>
                            <th style="min-width:110px">Speciality</th>
                            <th style="min-width:110px">Reporter</th>
                            <th style="min-width:120px">Tags</th>
                            <th style="min-width:100px" class="center">Date</th>
                            <th style="min-width:160px">Meta Keywords</th>
                            <th style="min-width:150px">Meta Description</th>
                            <th style="width:90px" class="center">Publish</th>
                            <th style="width:90px" class="center">Breaking</th>
                            <th style="min-width:200px" class="center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $i => $item)
                        <tr id="row-{{ $item->id }}">
                            <td><input type="checkbox" class="nw-check row-check" value="{{ $item->id }}" onchange="updateBulk()"></td>
                            <td class="center nw-sl">{{ $news->firstItem() + $i }}</td>
                            <td class="center">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" class="nw-thumb" alt="">
                                @else
                                    <div class="nw-thumb-ph"><i class="fas fa-image" style="font-size:13px"></i></div>
                                @endif
                            </td>
                            <td>
                                <div class="nw-title-cell">{{ Str::limit($item->title, 50) }}</div>
                                <div class="nw-title-id">ID: {{ $item->id }}</div>
                            </td>
                            <td>
                                @if($item->summary)
                                    <div class="nw-truncate" title="{{ $item->summary }}">{{ $item->summary }}</div>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->category)
                                    <span class="nw-badge nw-badge-cat">{{ $item->category->name }}</span>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->subCategory)
                                    <span class="nw-badge nw-badge-sub">{{ $item->subCategory->name }}</span>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->speciality)
                                    <span class="nw-badge nw-badge-sp">{{ $item->speciality->name }}</span>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->news_reporter)
                                    <span class="nw-badge nw-badge-rep">
                                        <i class="fas fa-user" style="font-size:9px"></i> {{ $item->news_reporter }}
                                    </span>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->tags)
                                    @php $tagArr = array_map('trim', explode(',', $item->tags)); @endphp
                                    <div class="nw-tags-wrap">
                                        @foreach(array_slice($tagArr, 0, 3) as $tag)
                                            <span class="nw-tag-item">{{ $tag }}</span>
                                        @endforeach
                                        @if(count($tagArr) > 3)
                                            <span class="nw-tag-item">+{{ count($tagArr) - 3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td class="center">
                                @if($item->date)
                                    <span class="nw-date">
                                        <i class="far fa-calendar-alt" style="margin-right:3px"></i>
                                        {{ $item->date->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>

                            {{-- ── Meta Keywords (JSON array → badge) ── --}}
                            <td>
                                @if(!empty($item->meta_keywords))
                                    <div class="nw-tags-wrap">
                                        @foreach(array_slice($item->meta_keywords, 0, 3) as $kw)
                                            <span class="nw-kw-item">{{ $kw }}</span>
                                        @endforeach
                                        @if(count($item->meta_keywords) > 3)
                                            <span class="nw-kw-item">+{{ count($item->meta_keywords) - 3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>

                            <td>
                                @if($item->meta_description)
                                    <div class="nw-truncate" title="{{ $item->meta_description }}">{{ $item->meta_description }}</div>
                                @else
                                    <span class="nw-none">—</span>
                                @endif
                            </td>
                            <td class="center">
                                <div class="nw-toggle-wrap">
                                    <label class="nw-toggle">
                                        <input type="checkbox" class="toggle-switch"
                                               data-id="{{ $item->id }}" data-type="status"
                                               {{ $item->status ? 'checked' : '' }}>
                                        <span class="nw-slider"></span>
                                    </label>
                                </div>
                            </td>
                            <td class="center">
                                <div class="nw-toggle-wrap">
                                    <label class="nw-toggle">
                                        <input type="checkbox" class="toggle-switch"
                                               data-id="{{ $item->id }}" data-type="breaking"
                                               {{ $item->breaking_news ? 'checked' : '' }}>
                                        <span class="nw-slider breaking"></span>
                                    </label>
                                </div>
                            </td>
                            <td class="center">
                                <div class="nw-actions">
                                    <a href="{{ route('blognewsadd.show', $item->id) }}" class="nw-btn nw-btn-view">
                                        <i class="fas fa-eye" style="font-size:11px"></i> View
                                    </a>
                                    <a href="{{ route('blognewsadd.edit', $item->id) }}" class="nw-btn nw-btn-edit">
                                        <i class="fas fa-pencil-alt" style="font-size:11px"></i> Edit
                                    </a>
                                    <button class="nw-btn nw-btn-del btn-delete" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash" style="font-size:11px"></i> Delete
                                    </button>
                                    <form id="del-form-{{ $item->id }}"
                                          action="{{ route('blognewsadd.destroy', $item->id) }}"
                                          method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16">
                                <div class="nw-empty">
                                    <div class="nw-empty-icon"><i class="fas fa-newspaper"></i></div>
                                    <p>No news articles found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="nw-pagination">
                {{ $news->appends(['show' => $perPage, 'search' => $search])->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-switch').forEach(function (el) {
    el.addEventListener('change', function () {
        const id   = this.dataset.id;
        const type = this.dataset.type;
        const self = this;
        const url  = type === 'breaking'
            ? `/admin/blognewsadd/${id}/toggle-breaking`
            : `/admin/blognewsadd/${id}/toggle-status`;
        fetch(url, { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'} })
        .then(r => r.json())
        .then(data => { if (!data.success) self.checked = !self.checked; })
        .catch(() => { self.checked = !self.checked; });
    });
});

document.querySelectorAll('.btn-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
        if (confirm('এই আর্টিকেলটি ডিলিট করবেন? এটি আর ফেরত আনা যাবে না।')) {
            document.getElementById('del-form-' + this.dataset.id).submit();
        }
    });
});

const checkAll = document.getElementById('checkAll');
checkAll.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(c => {
        c.checked = this.checked;
        c.closest('tr').classList.toggle('selected-row', this.checked);
    });
    updateBulk();
});

function updateBulk() {
    const checked = document.querySelectorAll('.row-check:checked');
    document.getElementById('bulkCount').textContent = checked.length;
    document.getElementById('bulkDeleteBtn').classList.toggle('visible', checked.length > 0);
    document.querySelectorAll('.row-check').forEach(c => {
        c.closest('tr').classList.toggle('selected-row', c.checked);
    });
}

function confirmBulkDelete() {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
    if (!ids.length) return;
    if (!confirm(`${ids.length}টি আর্টিকেল ডিলিট করবেন? এটি আর ফেরত আনা যাবে না।`)) return;
    fetch('{{ route('blognewsadd.bulkDestroy') }}', {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json' },
        body: JSON.stringify({ ids })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            ids.forEach(id => { const row = document.getElementById('row-' + id); if (row) row.remove(); });
            document.getElementById('bulkDeleteBtn').classList.remove('visible');
            document.getElementById('bulkCount').textContent = '0';
            checkAll.checked = false;
        }
    })
    .catch(() => alert('কিছু একটা ভুল হয়েছে। আবার চেষ্টা করুন।'));
}
</script>
@endsection
