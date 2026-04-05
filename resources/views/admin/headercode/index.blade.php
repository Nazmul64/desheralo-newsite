@extends('admin.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════
   BASE & TOKENS
═══════════════════════════════════════════════ */
* { box-sizing: border-box; }

:root {
    --primary:      #4f46e5;
    --primary-soft: #eef2ff;
    --primary-mid:  #c7d2fe;
    --danger:       #ef4444;
    --danger-soft:  #fff1f1;
    --success:      #10b981;
    --success-soft: #ecfdf5;
    --warn:         #f59e0b;
    --warn-soft:    #fffbeb;

    --bg:           #f4f6fb;
    --surface:      #ffffff;
    --border:       #e8eaf0;
    --border-dark:  #d1d5db;

    --text-primary:   #111827;
    --text-secondary: #6b7280;
    --text-muted:     #9ca3af;

    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --radius-xl: 18px;

    --shadow-xs: 0 1px 2px rgba(0,0,0,.05);
    --shadow-sm: 0 2px 8px rgba(0,0,0,.07);
    --shadow-md: 0 4px 20px rgba(0,0,0,.09);
    --shadow-lg: 0 8px 32px rgba(0,0,0,.12);

    --font: 'Plus Jakarta Sans', system-ui, sans-serif;
}

.adm-wrap {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    padding: 28px 24px 48px;
}

/* ═══════════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════════ */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
@media(max-width:900px){ .stat-grid{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:540px){ .stat-grid{ grid-template-columns:1fr; } }

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow-xs);
    transition: box-shadow .2s, transform .2s;
}
.stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-icon {
    width: 46px; height: 46px;
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.stat-icon.blue  { background: var(--primary-soft); }
.stat-icon.green { background: var(--success-soft); }
.stat-icon.amber { background: var(--warn-soft); }
.stat-icon.red   { background: var(--danger-soft); }
.stat-val { font-size: 22px; font-weight: 800; color: var(--text-primary); line-height: 1.1; }
.stat-lbl { font-size: 12px; color: var(--text-secondary); font-weight: 500; margin-top: 2px; }

/* ═══════════════════════════════════════════════
   TAB BAR
═══════════════════════════════════════════════ */
.tab-bar {
    display: flex; align-items: center; gap: 2px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 5px;
    width: fit-content;
    margin-bottom: 22px;
    box-shadow: var(--shadow-xs);
}
.tab-bar a {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 18px;
    border-radius: var(--radius-md);
    font-size: 13px; font-weight: 600;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all .18s;
    white-space: nowrap;
}
.tab-bar a:hover { color: var(--text-primary); background: var(--bg); }
.tab-bar a.active {
    background: var(--primary); color: #fff;
    box-shadow: 0 2px 8px rgba(79,70,229,.35);
}
.tab-bar a i { font-size: 14px; }

/* ═══════════════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════════════ */
.page-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px; gap: 12px; flex-wrap: wrap;
}
.page-title {
    font-size: 20px; font-weight: 800; color: var(--text-primary);
    display: flex; align-items: center; gap: 10px; margin: 0;
}
.page-title-badge {
    font-size: 11px; font-weight: 700;
    background: var(--primary-soft); color: var(--primary);
    border: 1px solid var(--primary-mid);
    border-radius: 20px; padding: 2px 10px;
}
.page-sub { font-size: 13px; color: var(--text-muted); margin-top: 3px; }
.page-header-right { display: flex; align-items: center; gap: 8px; }

/* ═══════════════════════════════════════════════
   BUTTONS
═══════════════════════════════════════════════ */
.btn-adm {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--radius-md);
    font-size: 13px; font-weight: 600;
    border: 1px solid transparent; cursor: pointer;
    transition: all .18s; font-family: var(--font);
    line-height: 1; text-decoration: none;
}
.btn-adm i { font-size: 14px; }
.btn-primary-adm {
    background: var(--primary); color: #fff; border-color: var(--primary);
    box-shadow: 0 2px 8px rgba(79,70,229,.3);
}
.btn-primary-adm:hover { background: #4338ca; box-shadow: 0 4px 14px rgba(79,70,229,.4); transform: translateY(-1px); }
.btn-danger-adm {
    background: var(--danger-soft); color: var(--danger); border-color: #fecaca;
}
.btn-danger-adm:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

/* ═══════════════════════════════════════════════
   TABLE CARD
═══════════════════════════════════════════════ */
.table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.table-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    background: #fcfcfe; flex-wrap: wrap;
}
.search-box { position: relative; flex: 1; max-width: 300px; }
.search-box i {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    color: var(--text-muted); font-size: 13px; pointer-events: none;
}
.search-box input {
    width: 100%; padding: 7px 12px 7px 32px;
    border: 1px solid var(--border-dark); border-radius: var(--radius-md);
    font-size: 13px; font-family: var(--font); color: var(--text-primary);
    background: var(--surface); outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.search-box input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
}

.adm-table { width: 100%; border-collapse: collapse; }
.adm-table thead th {
    background: #f8f9fc;
    font-size: 11px; font-weight: 700; color: var(--text-muted);
    text-transform: uppercase; letter-spacing: .6px;
    padding: 12px 16px; border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
.adm-table tbody td {
    padding: 14px 16px; font-size: 13px; color: var(--text-primary);
    vertical-align: middle; border-bottom: 1px solid #f3f4f8;
    font-family: var(--font);
}
.adm-table tbody tr:last-child td { border-bottom: none; }
.adm-table tbody tr { transition: background .12s; }
.adm-table tbody tr:hover td { background: #f9faff; }

/* SL chip */
.sl-chip {
    width: 28px; height: 28px;
    background: var(--primary-soft); color: var(--primary);
    border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
}

/* ── Code preview cell ── */
.code-cell {
    display: flex; align-items: center; gap: 10px;
}
.code-icon-wrap {
    width: 36px; height: 36px; flex-shrink: 0;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border: 1px solid var(--primary-mid);
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
}
.code-content { flex: 1; min-width: 0; }
.code-snippet {
    font-size: 12px; font-family: 'Courier New', monospace;
    color: #374151;
    background: #f8f9fc;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 5px 10px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 420px;
    display: block;
}
.code-length-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 600; color: var(--text-muted);
    margin-top: 3px;
}
.code-length-badge i { font-size: 10px; }

/* copy button */
.btn-copy {
    width: 28px; height: 28px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: var(--radius-sm); font-size: 12px;
    border: 1px solid var(--border-dark);
    cursor: pointer; background: var(--surface);
    color: var(--text-secondary); transition: all .15s;
    flex-shrink: 0;
}
.btn-copy:hover { background: var(--primary-soft); color: var(--primary); border-color: var(--primary-mid); }
.btn-copy.copied { background: var(--success-soft); color: var(--success); border-color: #a7f3d0; }

/* ── Status toggle ── */
.status-wrap { display: flex; align-items: center; gap: 8px; }
.status-label {
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 20px;
}
.status-label.active   { background: var(--success-soft); color: var(--success); }
.status-label.inactive { background: #f3f4f6; color: var(--text-muted); }

.adm-toggle { position: relative; display: inline-block; width: 36px; height: 20px; }
.adm-toggle input { opacity: 0; width: 0; height: 0; }
.adm-toggle-slider {
    position: absolute; inset: 0; background: #d1d5db;
    border-radius: 20px; cursor: pointer; transition: .2s;
}
.adm-toggle-slider:before {
    content: ''; position: absolute;
    width: 14px; height: 14px; left: 3px; top: 3px;
    background: #fff; border-radius: 50%;
    transition: .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.adm-toggle input:checked + .adm-toggle-slider { background: var(--success); }
.adm-toggle input:checked + .adm-toggle-slider:before { transform: translateX(16px); }

/* ── Action buttons ── */
.act-btn {
    width: 32px; height: 32px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: var(--radius-sm); font-size: 13px; border: 1px solid;
    cursor: pointer; background: transparent; transition: all .15s; line-height: 1;
}
.act-edit { color: var(--primary); border-color: var(--primary-mid); }
.act-edit:hover { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 2px 8px rgba(79,70,229,.3); }
.act-del  { color: var(--danger); border-color: #fecaca; }
.act-del:hover  { background: var(--danger); color: #fff; border-color: var(--danger); box-shadow: 0 2px 8px rgba(239,68,68,.3); }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 64px 20px; }
.empty-icon {
    width: 72px; height: 72px;
    background: var(--primary-soft); border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 32px; margin-bottom: 16px;
}
.empty-state h6 { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
.empty-state p  { font-size: 13px; color: var(--text-secondary); margin-bottom: 20px; }

/* ── Table footer ── */
.table-footer {
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: #fcfcfe; flex-wrap: wrap; gap: 10px;
}
.tfoot-info { font-size: 12px; color: var(--text-muted); font-weight: 500; }

/* ── Row animation ── */
@keyframes rowIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.adm-table tbody tr { animation: rowIn .25s ease both; }

/* ═══════════════════════════════════════════════
   MODAL
═══════════════════════════════════════════════ */
.adm-modal .modal-content {
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    font-family: var(--font);
    overflow: hidden;
}
.adm-modal .modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #f0f2ff 0%, #fafbff 100%);
}
.adm-modal .modal-title  { font-size: 16px; font-weight: 800; color: var(--text-primary); }
.modal-title-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.adm-modal .modal-body   { padding: 20px 24px 24px; background: var(--bg); }

.form-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 18px 20px;
    margin-bottom: 4px;
}
.form-card-head {
    display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
}
.form-card-icon {
    width: 34px; height: 34px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-mid);
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
}
.form-card-title  { font-size: 13px; font-weight: 700; color: var(--text-primary); }
.form-card-sub    { font-size: 11px; color: var(--text-muted); }

.adm-label {
    font-size: 12px; font-weight: 600; color: var(--text-secondary);
    display: block; margin-bottom: 6px;
}
.adm-input {
    width: 100%; padding: 9px 12px;
    border: 1px solid var(--border-dark);
    border-radius: var(--radius-md);
    font-size: 13px; font-family: var(--font); color: var(--text-primary);
    background: var(--bg); outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.adm-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
    background: var(--surface);
}
.adm-input.is-invalid {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(239,68,68,.1);
}
.adm-error {
    font-size: 11px; color: var(--danger); font-weight: 500;
    margin-top: 5px; display: flex; align-items: center; gap: 4px;
}
.adm-hint {
    font-size: 11px; color: var(--text-muted);
    margin-top: 5px; display: flex; align-items: center; gap: 4px;
}

.modal-footer-btns {
    display: flex; gap: 10px; margin-top: 16px;
    padding-top: 16px; border-top: 1px solid var(--border);
}
.btn-modal-cancel {
    flex: 1; padding: 10px;
    background: var(--surface); border: 1px solid var(--border-dark);
    border-radius: var(--radius-md); font-size: 13px; font-weight: 600;
    color: var(--text-secondary); cursor: pointer; font-family: var(--font);
    transition: all .15s;
}
.btn-modal-cancel:hover { background: var(--danger-soft); color: var(--danger); border-color: #fecaca; }
.btn-modal-save {
    flex: 1; padding: 10px;
    background: var(--primary); border: 1px solid var(--primary);
    border-radius: var(--radius-md); font-size: 13px; font-weight: 700;
    color: #fff; cursor: pointer; font-family: var(--font);
    box-shadow: 0 2px 8px rgba(79,70,229,.3);
    transition: all .15s;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-modal-save:hover { background: #4338ca; box-shadow: 0 4px 14px rgba(79,70,229,.4); }

/* ═══════════════════════════════════════════════
   DELETE MODAL
═══════════════════════════════════════════════ */
.del-modal .modal-content {
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
    font-family: var(--font);
}
.del-modal-body { padding: 32px 28px 28px; text-align: center; }
.del-icon-wrap {
    width: 64px; height: 64px;
    background: var(--danger-soft); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; font-size: 28px;
}
.del-modal-title { font-size: 16px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
.del-modal-sub   { font-size: 13px; color: var(--text-secondary); margin-bottom: 22px; }
.del-modal-btns  { display: flex; gap: 10px; }
.del-modal-btns button {
    flex: 1; padding: 10px; border-radius: var(--radius-md);
    font-size: 13px; font-weight: 600; font-family: var(--font);
    cursor: pointer; border: 1px solid; transition: all .15s;
}
.btn-del-cancel  { background: var(--surface); color: var(--text-secondary); border-color: var(--border-dark); }
.btn-del-cancel:hover { background: var(--bg); }
.btn-del-confirm { background: var(--danger); color: #fff; border-color: var(--danger); box-shadow: 0 2px 8px rgba(239,68,68,.3); }
.btn-del-confirm:hover { background: #dc2626; box-shadow: 0 4px 14px rgba(239,68,68,.4); }

/* ═══════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════ */
#adm-toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 99999;
    display: flex; align-items: center; gap: 10px;
    padding: 12px 20px; border-radius: var(--radius-lg);
    font-size: 13px; font-weight: 600; font-family: var(--font);
    color: #fff; min-width: 220px;
    opacity: 0; pointer-events: none;
    transform: translateY(16px);
    transition: opacity .3s, transform .3s;
    box-shadow: var(--shadow-lg);
}
#adm-toast.show { opacity: 1; transform: translateY(0); pointer-events: auto; }
#adm-toast .t-icon { font-size: 16px; }
#adm-toast.t-success { background: linear-gradient(135deg,#059669,#10b981); }
#adm-toast.t-error   { background: linear-gradient(135deg,#dc2626,#ef4444); }
#adm-toast.t-info    { background: linear-gradient(135deg,#4f46e5,#6366f1); }
</style>

{{-- ─────────────────────────────────────────────
     MAIN WRAP
───────────────────────────────────────────── --}}
<div class="adm-wrap">

    {{-- STAT CARDS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon blue">🧩</div>
            <div>
                <div class="stat-val">{{ $headers->count() }}</div>
                <div class="stat-lbl">Total Header Codes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div>
                <div class="stat-val">{{ $headers->where('status',1)->count() }}</div>
                <div class="stat-lbl">Active Codes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">📊</div>
            <div>
                <div class="stat-val">
                    {{ $headers->filter(fn($h)=>str_contains(strtolower($h->google_analytics??''),'gtag')||str_contains(strtolower($h->google_analytics??''),'analytics'))->count() }}
                </div>
                <div class="stat-lbl">Analytics Scripts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">💤</div>
            <div>
                <div class="stat-val">{{ $headers->where('status',0)->count() }}</div>
                <div class="stat-lbl">Inactive Codes</div>
            </div>
        </div>
    </div>

    {{-- TAB BAR --}}
    <div class="tab-bar">
        <a href="{{ route('admanager.index') }}">
            <i class="bi bi-layout-wtf"></i> Ads Settings
        </a>
        <a href="{{ route('headercode.index') }}" class="active">
            <i class="bi bi-code-slash"></i> Header Code
        </a>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h5 class="page-title">
                Header Codes
                <span class="page-title-badge">{{ $headers->count() }} total</span>
            </h5>
            <div class="page-sub">Manage Google Analytics &amp; custom header scripts</div>
        </div>
        <div class="page-header-right">
            <button class="btn-adm btn-danger-adm d-none" id="bulkDeleteBtn" onclick="confirmBulkDelete()">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
            <button class="btn-adm btn-primary-adm"
                data-bs-toggle="modal" data-bs-target="#createHeaderModal">
                <i class="bi bi-plus-lg"></i> Add Header Code
            </button>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        {{-- card top bar --}}
        <div class="table-card-head">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search header codes..." id="hSearch" oninput="searchRows(this.value)">
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <select onchange="filterStatus(this.value)"
                    style="font-size:12px;font-family:var(--font);border:1px solid var(--border-dark);border-radius:var(--radius-md);padding:6px 10px;background:var(--surface);color:var(--text-primary);outline:none;cursor:pointer;">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div style="overflow-x:auto;">
        <table class="adm-table" id="headersTable">
            <thead>
                <tr>
                    <th style="width:46px;padding-left:20px;">
                        <input type="checkbox" class="form-check-input" id="checkAll" onchange="toggleAll(this)">
                    </th>
                    <th style="width:46px;">#</th>
                    <th>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span style="font-size:14px;">⚙</span> Google Analytics / Header Script
                        </div>
                    </th>
                    <th style="width:120px;">Status</th>
                    <th style="width:90px;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="headersTbody">
                @forelse($headers as $i => $header)
                <tr id="hrow-{{ $header->id }}" data-status="{{ $header->status }}" style="animation-delay:{{ $i * 0.04 }}s">
                    {{-- Checkbox --}}
                    <td style="padding-left:20px;">
                        <input type="checkbox" class="form-check-input row-check"
                            value="{{ $header->id }}" onchange="updateBulkBtn()">
                    </td>

                    {{-- SL --}}
                    <td><span class="sl-chip">{{ $i + 1 }}</span></td>

                    {{-- Code preview --}}
                    <td>
                        <div class="code-cell">
                            <div class="code-icon-wrap">
                                @if(str_contains(strtolower($header->google_analytics ?? ''), 'gtag') || str_contains(strtolower($header->google_analytics ?? ''), 'analytics'))
                                    📊
                                @elseif(str_contains(strtolower($header->google_analytics ?? ''), 'pixel') || str_contains(strtolower($header->google_analytics ?? ''), 'facebook'))
                                    📘
                                @elseif(str_contains(strtolower($header->google_analytics ?? ''), 'script'))
                                    📜
                                @else
                                    🧩
                                @endif
                            </div>
                            <div class="code-content">
                                <span class="code-snippet" title="{{ $header->google_analytics }}">
                                    {{ Str::limit($header->google_analytics, 90) }}
                                </span>
                                <div class="code-length-badge">
                                    <i class="bi bi-braces"></i>
                                    {{ strlen($header->google_analytics ?? '') }} characters
                                </div>
                            </div>
                            <button class="btn-copy" title="Copy code"
                                onclick="copyCode(this, {{ json_encode($header->google_analytics) }})">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td>
                        <div class="status-wrap">
                            <label class="adm-toggle">
                                <input type="checkbox" {{ $header->status ? 'checked' : '' }}
                                    onchange="toggleStatus({{ $header->id }}, this)">
                                <span class="adm-toggle-slider"></span>
                            </label>
                            <span class="status-label {{ $header->status ? 'active' : 'inactive' }}"
                                id="slbl-{{ $header->id }}">
                                {{ $header->status ? 'Active' : 'Off' }}
                            </span>
                        </div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <button class="act-btn act-edit" title="Edit"
                                onclick="openEditModal({{ $header->id }}, this)"
                                data-analytics="{{ addslashes($header->google_analytics) }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="act-btn act-del" title="Delete"
                                onclick="confirmDelete({{ $header->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🧩</div>
                            <h6>No Header Codes Yet</h6>
                            <p>Add Google Analytics or custom scripts to your site's &lt;head&gt;.</p>
                            <button class="btn-adm btn-primary-adm"
                                data-bs-toggle="modal" data-bs-target="#createHeaderModal">
                                <i class="bi bi-plus-lg"></i> Add First Header Code
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Footer --}}
        <div class="table-footer">
            <span class="tfoot-info" id="tableInfo">
                Showing {{ $headers->count() }} record(s)
            </span>
            @if(method_exists($headers,'links'))
                {{ $headers->links() }}
            @endif
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     CREATE HEADER MODAL
═══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="createHeaderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog adm-modal" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">✦ Add Header Code</h5>
                    <div class="modal-title-sub">Insert Google Analytics or any custom script</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createHeaderForm" novalidate>
                    @csrf
                    <div class="form-card">
                        <div class="form-card-head">
                            <div class="form-card-icon">📊</div>
                            <div>
                                <div class="form-card-title">Header Script</div>
                                <div class="form-card-sub">Paste your tracking or analytics code</div>
                            </div>
                        </div>
                        <label class="adm-label" for="createAnalyticsInput">
                            Google Analytics / Script Code
                        </label>
                        <input type="text" class="adm-input" id="createAnalyticsInput"
                            name="google_analytics"
                            placeholder="e.g. G-XXXXXXXXXX or full &lt;script&gt; tag"
                            autocomplete="off">
                        <div class="adm-error d-none" id="createAnalyticsError">
                            <i class="bi bi-exclamation-circle"></i> <span></span>
                        </div>
                        <div class="adm-hint">
                            <i class="bi bi-info-circle"></i>
                            Enter a Measurement ID like <code style="font-size:10px;background:#f3f4f6;padding:1px 5px;border-radius:3px;">G-XXXXXXXXXX</code> or full script
                        </div>
                    </div>

                    <div class="modal-footer-btns">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn-modal-save" id="createHeaderBtn">
                            <span id="createHeaderTxt">Save Code</span>
                            <span id="createHeaderSpin" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     EDIT HEADER MODAL
═══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editHeaderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog adm-modal" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">✎ Edit Header Code</h5>
                    <div class="modal-title-sub">Update your analytics or script configuration</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editHeaderForm" novalidate>
                    @csrf
                    <input type="hidden" id="editHeaderId">
                    <div class="form-card">
                        <div class="form-card-head">
                            <div class="form-card-icon">📊</div>
                            <div>
                                <div class="form-card-title">Header Script</div>
                                <div class="form-card-sub">Update your tracking or analytics code</div>
                            </div>
                        </div>
                        <label class="adm-label" for="editAnalyticsInput">
                            Google Analytics / Script Code
                        </label>
                        <input type="text" class="adm-input" id="editAnalyticsInput"
                            name="google_analytics"
                            placeholder="e.g. G-XXXXXXXXXX or full &lt;script&gt; tag"
                            autocomplete="off">
                        <div class="adm-error d-none" id="editAnalyticsError">
                            <i class="bi bi-exclamation-circle"></i> <span></span>
                        </div>
                        <div class="adm-hint">
                            <i class="bi bi-info-circle"></i>
                            Enter a Measurement ID or full script tag
                        </div>
                    </div>

                    <div class="modal-footer-btns">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn-modal-save" id="editHeaderBtn">
                            <span id="editHeaderTxt">Update Code</span>
                            <span id="editHeaderSpin" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     DELETE CONFIRM MODAL
═══════════════════════════════════════════════════════════════ --}}
<div class="modal fade del-modal" id="delModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="del-modal-body">
                <div class="del-icon-wrap">🗑</div>
                <div class="del-modal-title">Delete Header Code?</div>
                <div class="del-modal-sub">This script will be permanently removed and no longer injected into your site's &lt;head&gt;.</div>
                <div class="del-modal-btns">
                    <button class="btn-del-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn-del-confirm" id="doDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     BULK DELETE MODAL
═══════════════════════════════════════════════════════════════ --}}
<div class="modal fade del-modal" id="bulkDelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="del-modal-body">
                <div class="del-icon-wrap">⚠️</div>
                <div class="del-modal-title">Delete Selected Codes?</div>
                <div class="del-modal-sub" id="bulkDelMsg"></div>
                <div class="del-modal-btns">
                    <button class="btn-del-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn-del-confirm" id="doBulkDelBtn">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TOAST --}}
<div id="adm-toast"><span class="t-icon"></span><span class="t-msg"></span></div>


<script>
const CSRF = '{{ csrf_token() }}';

/* ── Toast ── */
function toast(msg, type = 'success') {
    const el = document.getElementById('adm-toast');
    const icons = { success:'✅', error:'❌', info:'ℹ️' };
    el.querySelector('.t-icon').textContent = icons[type] || '✅';
    el.querySelector('.t-msg').textContent  = msg;
    el.className = `t-${type}`;
    el.classList.add('show');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.remove('show'), 3000);
}

/* ── Reset create modal ── */
document.getElementById('createHeaderModal').addEventListener('hidden.bs.modal', () => {
    document.getElementById('createHeaderForm').reset();
    resetField('createAnalyticsInput','createAnalyticsError');
});

/* ── CREATE ── */
document.getElementById('createHeaderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('createAnalyticsInput');
    if (!input.value.trim()) {
        showFieldError('createAnalyticsInput','createAnalyticsError','This field is required.');
        return;
    }
    clearFieldError('createAnalyticsInput','createAnalyticsError');
    setBtnState('createHeaderBtn','createHeaderTxt','createHeaderSpin', true, 'Saving...');

    fetch('{{ route("headercode.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        body: new FormData(this),
    })
    .then(r => r.json())
    .then(d => {
        setBtnState('createHeaderBtn','createHeaderTxt','createHeaderSpin', false, 'Save Code');
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('createHeaderModal')).hide();
            toast('Header code saved successfully!');
            setTimeout(() => location.reload(), 800);
        } else {
            const errs = d.errors ? Object.values(d.errors).flat().join(' ') : (d.message || 'Error');
            showFieldError('createAnalyticsInput','createAnalyticsError', errs);
        }
    })
    .catch(() => {
        setBtnState('createHeaderBtn','createHeaderTxt','createHeaderSpin', false, 'Save Code');
        toast('Something went wrong.', 'error');
    });
});

/* ── OPEN EDIT ── */
function openEditModal(id, btn) {
    const analytics = btn.getAttribute('data-analytics');
    document.getElementById('editHeaderId').value          = id;
    document.getElementById('editAnalyticsInput').value    = analytics;
    clearFieldError('editAnalyticsInput','editAnalyticsError');
    bootstrap.Modal.getOrCreateInstance(document.getElementById('editHeaderModal')).show();
}

/* ── SUBMIT EDIT ── */
document.getElementById('editHeaderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id    = document.getElementById('editHeaderId').value;
    const input = document.getElementById('editAnalyticsInput');
    if (!input.value.trim()) {
        showFieldError('editAnalyticsInput','editAnalyticsError','This field is required.');
        return;
    }
    clearFieldError('editAnalyticsInput','editAnalyticsError');
    setBtnState('editHeaderBtn','editHeaderTxt','editHeaderSpin', true, 'Updating...');

    const fd = new FormData(this);
    fd.append('_method', 'PUT');
    fetch(`/admin/headercode/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        body: fd,
    })
    .then(r => r.json())
    .then(d => {
        setBtnState('editHeaderBtn','editHeaderTxt','editHeaderSpin', false, 'Update Code');
        if (d.success) {
            bootstrap.Modal.getInstance(document.getElementById('editHeaderModal')).hide();
            toast('Header code updated successfully!');
            setTimeout(() => location.reload(), 800);
        } else {
            const errs = d.errors ? Object.values(d.errors).flat().join(' ') : (d.message || 'Error');
            showFieldError('editAnalyticsInput','editAnalyticsError', errs);
        }
    })
    .catch(() => {
        setBtnState('editHeaderBtn','editHeaderTxt','editHeaderSpin', false, 'Update Code');
        toast('Something went wrong.', 'error');
    });
});

/* ── DELETE SINGLE ── */
let _delId = null;
function confirmDelete(id) {
    _delId = id;
    bootstrap.Modal.getOrCreateInstance(document.getElementById('delModal')).show();
}
document.getElementById('doDeleteBtn').addEventListener('click', function() {
    if (!_delId) return;
    this.disabled = true; this.textContent = 'Deleting...';
    fetch(`/admin/headercode/${_delId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
    })
    .then(r => r.json())
    .then(d => {
        bootstrap.Modal.getInstance(document.getElementById('delModal')).hide();
        this.disabled = false; this.textContent = 'Yes, Delete';
        if (d.success) {
            const row = document.getElementById('hrow-' + _delId);
            if (row) {
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                row.style.transition = '.3s';
                setTimeout(() => row.remove(), 300);
            }
            toast('Header code deleted.');
            _delId = null;
        }
    });
});

/* ── BULK DELETE ── */
function confirmBulkDelete() {
    const ids = checkedIds();
    if (!ids.length) return;
    document.getElementById('bulkDelMsg').textContent = `${ids.length} item(s) will be permanently removed.`;
    bootstrap.Modal.getOrCreateInstance(document.getElementById('bulkDelModal')).show();
}
document.getElementById('doBulkDelBtn').addEventListener('click', function() {
    const ids = checkedIds();
    if (!ids.length) return;
    this.disabled = true; this.textContent = 'Deleting...';
    fetch('{{ route("headercode.bulkDestroy") }}', {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids }),
    })
    .then(r => r.json())
    .then(d => {
        bootstrap.Modal.getInstance(document.getElementById('bulkDelModal')).hide();
        this.disabled = false; this.textContent = 'Delete All';
        if (d.success) {
            ids.forEach(id => {
                const row = document.getElementById('hrow-' + id);
                if (row) { row.style.opacity='0'; row.style.transition='.3s'; setTimeout(()=>row.remove(),300); }
            });
            toast('Selected codes deleted.', 'info');
            updateBulkBtn();
        }
    });
});

/* ── STATUS TOGGLE ── */
function toggleStatus(id, el) {
    const prev = el.checked;
    const lbl  = document.getElementById('slbl-' + id);
    fetch(`/admin/headercode/${id}/toggle-status`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
    })
    .then(r => r.json())
    .then(d => {
        el.checked = d.status;
        if (lbl) {
            lbl.textContent = d.status ? 'Active' : 'Off';
            lbl.className = 'status-label ' + (d.status ? 'active' : 'inactive');
        }
        toast(d.status ? 'Code activated' : 'Code deactivated', d.status ? 'success' : 'info');
    })
    .catch(() => { el.checked = prev; toast('Failed to update status.', 'error'); });
}

/* ── COPY CODE ── */
function copyCode(btn, text) {
    navigator.clipboard.writeText(text).then(() => {
        btn.classList.add('copied');
        btn.innerHTML = '<i class="bi bi-clipboard-check"></i>';
        toast('Code copied to clipboard!', 'info');
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = '<i class="bi bi-clipboard"></i>';
        }, 2000);
    }).catch(() => toast('Copy failed.','error'));
}

/* ── SEARCH ── */
function searchRows(q) {
    const rows = document.querySelectorAll('#headersTbody tr[id^="hrow-"]');
    const term = q.toLowerCase();
    let visible = 0;
    rows.forEach(row => {
        const show = !term || row.textContent.toLowerCase().includes(term);
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('tableInfo').textContent = `Showing ${visible} record(s)`;
}

/* ── FILTER STATUS ── */
function filterStatus(val) {
    const rows = document.querySelectorAll('#headersTbody tr[id^="hrow-"]');
    let visible = 0;
    rows.forEach(row => {
        const show = val === '' || row.dataset.status === val;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('tableInfo').textContent = `Showing ${visible} record(s)`;
}

/* ── CHECKBOXES ── */
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = master.checked);
    updateBulkBtn();
}
function updateBulkBtn() {
    const all = document.querySelectorAll('.row-check').length;
    const cnt = checkedIds().length;
    const btn = document.getElementById('bulkDeleteBtn');
    const ca  = document.getElementById('checkAll');
    btn.classList.toggle('d-none', cnt === 0);
    ca.indeterminate = cnt > 0 && cnt < all;
    ca.checked = cnt === all && all > 0;
    if (cnt) btn.innerHTML = `<i class="bi bi-trash"></i> Delete (${cnt})`;
}
function checkedIds() {
    return [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
}

/* ── Field error helpers ── */
function showFieldError(inputId, errId, msg) {
    const input = document.getElementById(inputId);
    const errEl = document.getElementById(errId);
    input.classList.add('is-invalid');
    if (errEl) { errEl.classList.remove('d-none'); errEl.querySelector('span').textContent = msg; }
}
function clearFieldError(inputId, errId) {
    const input = document.getElementById(inputId);
    const errEl = document.getElementById(errId);
    input.classList.remove('is-invalid');
    if (errEl) { errEl.classList.add('d-none'); errEl.querySelector('span').textContent = ''; }
}
function resetField(inputId, errId) {
    document.getElementById(inputId).value = '';
    clearFieldError(inputId, errId);
}

/* ── Btn state ── */
function setBtnState(btnId, txtId, spinId, loading, label) {
    const b = document.getElementById(btnId);
    const t = document.getElementById(txtId);
    const s = document.getElementById(spinId);
    if (b) b.disabled = loading;
    if (t) t.textContent = label;
    if (s) s.classList.toggle('d-none', !loading);
}
</script>

@endsection
