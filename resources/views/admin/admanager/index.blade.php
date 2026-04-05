@extends('admin.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
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
.adm-wrap { font-family: var(--font); background: var(--bg); min-height: 100vh; padding: 28px 24px 48px; }
.stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
@media(max-width:900px){ .stat-grid{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:540px){ .stat-grid{ grid-template-columns:1fr; } }
.stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; display: flex; align-items: center; gap: 14px; box-shadow: var(--shadow-xs); transition: box-shadow .2s, transform .2s; }
.stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-icon { width: 46px; height: 46px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.stat-icon.blue  { background: var(--primary-soft); }
.stat-icon.green { background: var(--success-soft); }
.stat-icon.amber { background: var(--warn-soft); }
.stat-icon.red   { background: var(--danger-soft); }
.stat-val { font-size: 22px; font-weight: 800; color: var(--text-primary); line-height: 1.1; }
.stat-lbl { font-size: 12px; color: var(--text-secondary); font-weight: 500; margin-top: 2px; }
.tab-bar { display: flex; align-items: center; gap: 2px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 5px; width: fit-content; margin-bottom: 22px; box-shadow: var(--shadow-xs); }
.tab-bar a { display: flex; align-items: center; gap: 7px; padding: 8px 18px; border-radius: var(--radius-md); font-size: 13px; font-weight: 600; color: var(--text-secondary); text-decoration: none; transition: all .18s; white-space: nowrap; }
.tab-bar a:hover { color: var(--text-primary); background: var(--bg); }
.tab-bar a.active { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(79,70,229,.35); }
.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; gap: 12px; flex-wrap: wrap; }
.page-title { font-size: 20px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 10px; margin: 0; }
.page-title-badge { font-size: 11px; font-weight: 700; background: var(--primary-soft); color: var(--primary); border: 1px solid var(--primary-mid); border-radius: 20px; padding: 2px 10px; }
.page-sub { font-size: 13px; color: var(--text-muted); margin-top: 3px; }
.page-header-right { display: flex; align-items: center; gap: 8px; }
.btn-adm { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-md); font-size: 13px; font-weight: 600; border: 1px solid transparent; cursor: pointer; transition: all .18s; font-family: var(--font); line-height: 1; text-decoration: none; }
.btn-primary-adm { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 2px 8px rgba(79,70,229,.3); }
.btn-primary-adm:hover { background: #4338ca; color: #fff; }
.btn-danger-adm { background: var(--danger-soft); color: var(--danger); border-color: #fecaca; }
.btn-danger-adm:hover { background: var(--danger); color: #fff; border-color: var(--danger); }
.table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-sm); }
.table-card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; background: #fcfcfe; flex-wrap: wrap; }
.search-box { position: relative; flex: 1; max-width: 280px; }
.search-box i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 13px; pointer-events: none; }
.search-box input { width: 100%; padding: 7px 12px 7px 32px; border: 1px solid var(--border-dark); border-radius: var(--radius-md); font-size: 13px; font-family: var(--font); color: var(--text-primary); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; }
.search-box input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.adm-table { width: 100%; border-collapse: collapse; }
.adm-table thead th { background: #f8f9fc; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .6px; padding: 12px 16px; border-bottom: 1px solid var(--border); white-space: nowrap; }
.adm-table tbody td { padding: 14px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; border-bottom: 1px solid #f3f4f8; }
.adm-table tbody tr:last-child td { border-bottom: none; }
.adm-table tbody tr:hover td { background: #f9faff; }
.sl-chip { width: 28px; height: 28px; background: var(--primary-soft); color: var(--primary); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; }
.ad-img-thumb { width: 100px; height: 48px; object-fit: cover; border-radius: 7px; border: 1px solid var(--border); display: block; }
.ad-code-pill { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#f8f9fc,#f0f2f8); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 6px 10px; max-width: 170px; }
.acp-size { font-size: 11px; font-weight: 800; color: var(--primary); white-space: nowrap; }
.acp-body { flex: 1; min-width: 0; }
.acp-line1 { font-size: 10px; color: var(--text-muted); }
.acp-tag { display: inline-block; background: var(--text-primary); color: #fff; font-size: 8px; font-weight: 700; border-radius: 20px; padding: 2px 7px; margin-top: 3px; }
.ad-empty { display: inline-flex; align-items: center; gap: 4px; color: var(--text-muted); font-size: 12px; font-style: italic; }
.status-wrap { display: flex; align-items: center; gap: 8px; }
.status-label { font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
.status-label.active   { background: var(--success-soft); color: var(--success); }
.status-label.inactive { background: #f3f4f6; color: var(--text-muted); }
.adm-toggle { position: relative; display: inline-block; width: 36px; height: 20px; }
.adm-toggle input { opacity: 0; width: 0; height: 0; }
.adm-toggle-slider { position: absolute; inset: 0; background: #d1d5db; border-radius: 20px; cursor: pointer; transition: .2s; }
.adm-toggle-slider:before { content: ''; position: absolute; width: 14px; height: 14px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
.adm-toggle input:checked + .adm-toggle-slider { background: var(--success); }
.adm-toggle input:checked + .adm-toggle-slider:before { transform: translateX(16px); }
.act-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: var(--radius-sm); font-size: 14px; border: 1px solid; cursor: pointer; background: transparent; transition: all .15s; }
.act-edit { color: var(--primary); border-color: var(--primary-mid); }
.act-edit:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
.act-del  { color: var(--danger); border-color: #fecaca; }
.act-del:hover  { background: var(--danger); color: #fff; border-color: var(--danger); }

/* LIKE BUTTON */
.act-like { color: #ec4899; border-color: #fbcfe8; position: relative; overflow: visible; }
.act-like:hover { background: #ec4899; color: #fff; border-color: #ec4899; }
.act-like.liked { background: #ec4899; color: #fff; border-color: #ec4899; }
.like-badge { position: absolute; top: -6px; right: -6px; background: #ef4444; color: #fff; font-size: 8px; font-weight: 800; border-radius: 20px; padding: 1px 4px; min-width: 14px; text-align: center; line-height: 1.5; display: none; }
.act-like.has-likes .like-badge { display: block; }
@keyframes likePop { 0%{transform:scale(1)} 40%{transform:scale(1.5)} 70%{transform:scale(.88)} 100%{transform:scale(1)} }
.act-like.pop i { animation: likePop .35s ease; }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-icon { width: 72px; height: 72px; background: var(--primary-soft); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 16px; }
.empty-state h6 { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
.empty-state p  { font-size: 13px; color: var(--text-secondary); margin-bottom: 20px; }
.table-footer { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: #fcfcfe; flex-wrap: wrap; gap: 10px; }
.tfoot-info { font-size: 12px; color: var(--text-muted); font-weight: 500; }
.adm-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); font-family: var(--font); overflow: hidden; }
.adm-modal .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg,#f0f2ff,#fafbff); }
.adm-modal .modal-title { font-size: 16px; font-weight: 800; color: var(--text-primary); }
.modal-title-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.adm-modal .modal-body { padding: 20px 24px 24px; background: var(--bg); }
.slot-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 16px 18px; margin-bottom: 12px; transition: box-shadow .15s; }
.slot-card:last-child { margin-bottom: 0; }
.slot-card-head { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.slot-icon { width: 32px; height: 32px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 15px; }
.slot-title { font-size: 13px; font-weight: 700; color: var(--text-primary); }
.slot-subtitle { font-size: 11px; color: var(--text-muted); }
.slot-radios { display: flex; gap: 16px; margin-bottom: 12px; }
.slot-radio { display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; font-weight: 600; color: var(--text-secondary); }
.slot-radio input[type=radio] { accent-color: var(--primary); width: 14px; height: 14px; }
.slot-radio:has(input:checked) { color: var(--primary); }
.slot-textarea { width: 100%; padding: 9px 12px; border: 1px solid var(--border-dark); border-radius: var(--radius-md); font-size: 12px; font-family: var(--font); color: var(--text-primary); resize: vertical; min-height: 72px; outline: none; background: var(--bg); transition: border-color .15s, box-shadow .15s; }
.slot-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,.1); background: var(--surface); }
.slot-file { width: 100%; padding: 8px 12px; border: 1px solid var(--border-dark); border-radius: var(--radius-md); font-size: 12px; font-family: var(--font); background: var(--surface); cursor: pointer; }
.modal-footer-btns { display: flex; gap: 10px; padding-top: 16px; border-top: 1px solid var(--border); }
.btn-modal-cancel { flex: 1; padding: 10px; background: var(--surface); border: 1px solid var(--border-dark); border-radius: var(--radius-md); font-size: 13px; font-weight: 600; color: var(--text-secondary); cursor: pointer; font-family: var(--font); transition: all .15s; }
.btn-modal-cancel:hover { background: var(--danger-soft); color: var(--danger); }
.btn-modal-save { flex: 1; padding: 10px; background: var(--primary); border: 1px solid var(--primary); border-radius: var(--radius-md); font-size: 13px; font-weight: 700; color: #fff; cursor: pointer; font-family: var(--font); box-shadow: 0 2px 8px rgba(79,70,229,.3); transition: all .15s; display: flex; align-items: center; justify-content: center; gap: 6px; }
.btn-modal-save:hover { background: #4338ca; }
.del-modal .modal-content { border-radius: var(--radius-xl); border: 1px solid var(--border); box-shadow: var(--shadow-lg); font-family: var(--font); }
.del-modal-body { padding: 32px 28px 28px; text-align: center; }
.del-icon-wrap { width: 64px; height: 64px; background: var(--danger-soft); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; }
.del-modal-title { font-size: 16px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
.del-modal-sub { font-size: 13px; color: var(--text-secondary); margin-bottom: 22px; }
.del-modal-btns { display: flex; gap: 10px; }
.del-modal-btns button { flex: 1; padding: 10px; border-radius: var(--radius-md); font-size: 13px; font-weight: 600; font-family: var(--font); cursor: pointer; border: 1px solid; transition: all .15s; }
.btn-del-cancel  { background: var(--surface); color: var(--text-secondary); border-color: var(--border-dark); }
.btn-del-confirm { background: var(--danger); color: #fff; border-color: var(--danger); }
.btn-del-confirm:hover { background: #dc2626; }
#adm-toast { position: fixed; bottom: 28px; right: 28px; z-index: 99999; display: flex; align-items: center; gap: 10px; padding: 12px 20px; border-radius: var(--radius-lg); font-size: 13px; font-weight: 600; font-family: var(--font); color: #fff; min-width: 220px; opacity: 0; pointer-events: none; transform: translateY(16px); transition: opacity .3s, transform .3s; box-shadow: var(--shadow-lg); }
#adm-toast.show { opacity: 1; transform: translateY(0); pointer-events: auto; }
#adm-toast.t-success { background: linear-gradient(135deg,#059669,#10b981); }
#adm-toast.t-error   { background: linear-gradient(135deg,#dc2626,#ef4444); }
#adm-toast.t-info    { background: linear-gradient(135deg,#4f46e5,#6366f1); }
#adm-toast.t-like    { background: linear-gradient(135deg,#be185d,#ec4899); }
@keyframes rowIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
.adm-table tbody tr { animation: rowIn .25s ease both; }
</style>

<div class="adm-wrap">
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon blue">📢</div>
            <div><div class="stat-val">{{ $ads->count() }}</div><div class="stat-lbl">Total Ad Spaces</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div><div class="stat-val">{{ $ads->where('status',1)->count() }}</div><div class="stat-lbl">Active Ads</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">🖼</div>
            <div>
                <div class="stat-val">{{ $ads->filter(fn($a)=> $a->header_ads_type==='image'||$a->sidebar_ads_type==='image'||$a->before_post_ads_type==='image'||$a->after_post_ads_type==='image')->count() }}</div>
                <div class="stat-lbl">Image Ads</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">💤</div>
            <div><div class="stat-val">{{ $ads->where('status',0)->count() }}</div><div class="stat-lbl">Inactive Ads</div></div>
        </div>
    </div>

    <div class="tab-bar">
        <a href="{{ route('admanager.index') }}" class="active"><i class="bi bi-layout-wtf"></i> Ads Settings</a>
        <a href="{{ route('headercode.index') }}"><i class="bi bi-code-slash"></i> Header Code</a>
    </div>

    <div class="page-header">
        <div>
            <h5 class="page-title">Ad Spaces <span class="page-title-badge">{{ $ads->count() }} total</span></h5>
            <div class="page-sub">Manage your advertisement slots across the site</div>
        </div>
        <div class="page-header-right">
            <button class="btn-adm btn-danger-adm d-none" id="bulkDeleteBtn" type="button">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
            <button class="btn-adm btn-primary-adm" type="button" data-bs-toggle="modal" data-bs-target="#createAdModal">
                <i class="bi bi-plus-lg"></i> Add New Ad
            </button>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-head">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search ads..." id="adSearch">
            </div>
            <select id="statusFilter" style="font-size:12px;font-family:var(--font);border:1px solid var(--border-dark);border-radius:var(--radius-md);padding:6px 10px;background:var(--surface);color:var(--text-primary);outline:none;cursor:pointer;">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div style="overflow-x:auto;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="width:42px;padding-left:20px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                    <th style="width:46px;"><i class="bi bi-hash"></i></th>
                    <th>🗞 Header Ads</th>
                    <th>📐 Sidebar Ads</th>
                    <th>⬆ Before Post</th>
                    <th>⬇ After Post</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:130px;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="adsTbody">
                @forelse($ads as $i => $ad)
                <tr id="row-{{ $ad->id }}" data-status="{{ $ad->status }}" style="animation-delay:{{ $i * 0.04 }}s">
                    <td style="padding-left:20px;">
                        <input type="checkbox" class="form-check-input row-check" value="{{ $ad->id }}">
                    </td>
                    <td><span class="sl-chip">{{ $i + 1 }}</span></td>

                    <td>
                        @if($ad->header_ads_type==='image' && $ad->header_ads)
                            <img src="{{ asset('uploads/ads/'.basename($ad->header_ads)) }}" class="ad-img-thumb" alt="">
                        @elseif($ad->header_ads)
                            <div class="ad-code-pill"><span class="acp-size">728×90</span><div class="acp-body"><div class="acp-line1">Smart &amp; Responsive</div><span class="acp-tag">AD CODE</span></div></div>
                        @else
                            <span class="ad-empty"><i class="bi bi-dash-circle"></i> None</span>
                        @endif
                    </td>
                    <td>
                        @if($ad->sidebar_ads_type==='image' && $ad->sidebar_ads)
                            <img src="{{ asset('uploads/ads/'.basename($ad->sidebar_ads)) }}" class="ad-img-thumb" alt="">
                        @elseif($ad->sidebar_ads)
                            <div class="ad-code-pill"><span class="acp-size">300×250</span><div class="acp-body"><div class="acp-line1">Smart &amp; Responsive</div><span class="acp-tag">AD CODE</span></div></div>
                        @else
                            <span class="ad-empty"><i class="bi bi-dash-circle"></i> None</span>
                        @endif
                    </td>
                    <td>
                        @if($ad->before_post_ads_type==='image' && $ad->before_post_ads)
                            <img src="{{ asset('uploads/ads/'.basename($ad->before_post_ads)) }}" class="ad-img-thumb" alt="">
                        @elseif($ad->before_post_ads)
                            <div class="ad-code-pill"><span class="acp-size">728×90</span><div class="acp-body"><div class="acp-line1">Smart &amp; Responsive</div><span class="acp-tag">AD CODE</span></div></div>
                        @else
                            <span class="ad-empty"><i class="bi bi-dash-circle"></i> None</span>
                        @endif
                    </td>
                    <td>
                        @if($ad->after_post_ads_type==='image' && $ad->after_post_ads)
                            <img src="{{ asset('uploads/ads/'.basename($ad->after_post_ads)) }}" class="ad-img-thumb" alt="">
                        @elseif($ad->after_post_ads)
                            <div class="ad-code-pill"><span class="acp-size">728×90</span><div class="acp-body"><div class="acp-line1">Smart &amp; Responsive</div><span class="acp-tag">AD CODE</span></div></div>
                        @else
                            <span class="ad-empty"><i class="bi bi-dash-circle"></i> None</span>
                        @endif
                    </td>

                    <td>
                        <div class="status-wrap">
                            <label class="adm-toggle">
                                <input type="checkbox" {{ $ad->status ? 'checked' : '' }} data-id="{{ $ad->id }}" class="status-toggle-input">
                                <span class="adm-toggle-slider"></span>
                            </label>
                            <span class="status-label {{ $ad->status ? 'active' : 'inactive' }}" id="slbl-{{ $ad->id }}">
                                {{ $ad->status ? 'Active' : 'Off' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:5px;">
                            <button type="button" class="act-btn act-like" title="Like" data-id="{{ $ad->id }}" data-likes="0">
                                <i class="bi bi-heart-fill"></i>
                                <span class="like-badge">0</span>
                            </button>
                            <button type="button" class="act-btn act-edit" title="Edit" data-id="{{ $ad->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="act-btn act-del" title="Delete" data-id="{{ $ad->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon">📢</div>
                        <h6>No Ad Spaces Yet</h6>
                        <p>Start by adding your first advertisement slot.</p>
                        <button class="btn-adm btn-primary-adm" type="button" data-bs-toggle="modal" data-bs-target="#createAdModal">
                            <i class="bi bi-plus-lg"></i> Create First Ad
                        </button>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="table-footer">
            <span class="tfoot-info" id="tableInfo">Showing {{ $ads->count() }} record(s)</span>
            <div>@if(method_exists($ads,'links')){{ $ads->links() }}@endif</div>
        </div>
    </div>
</div>


{{-- CREATE MODAL --}}
<div class="modal fade" id="createAdModal" tabindex="-1" aria-labelledby="createAdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable adm-modal" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="createAdModalLabel">✦ Create New Ad Space</h5>
                    <div class="modal-title-sub">Fill in one or more ad slots below</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createAdForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    @php
                        $cslots = [
                            ['key'=>'header_ads',      'label'=>'Header Ads',      'icon'=>'🗞',  'pfx'=>'c_ha', 'color'=>'#eef2ff'],
                            ['key'=>'sidebar_ads',     'label'=>'Sidebar Ads',     'icon'=>'📐', 'pfx'=>'c_sa', 'color'=>'#ecfdf5'],
                            ['key'=>'before_post_ads', 'label'=>'Before Post Ads', 'icon'=>'⬆',  'pfx'=>'c_bp', 'color'=>'#fffbeb'],
                            ['key'=>'after_post_ads',  'label'=>'After Post Ads',  'icon'=>'⬇',  'pfx'=>'c_ap', 'color'=>'#fff1f1'],
                        ];
                    @endphp
                    @foreach($cslots as $s)
                    <div class="slot-card">
                        <div class="slot-card-head">
                            <div class="slot-icon" style="background:{{ $s['color'] }};">{{ $s['icon'] }}</div>
                            <div><div class="slot-title">{{ $s['label'] }}</div><div class="slot-subtitle">Choose ad type for this position</div></div>
                        </div>
                        <div class="slot-radios">
                            <label class="slot-radio"><input type="radio" name="{{ $s['key'] }}_type" value="code" checked data-pfx="{{ $s['pfx'] }}" class="slot-type-radio"><i class="bi bi-code-square"></i> Ad Code</label>
                            <label class="slot-radio"><input type="radio" name="{{ $s['key'] }}_type" value="image" data-pfx="{{ $s['pfx'] }}" class="slot-type-radio"><i class="bi bi-image"></i> Image Upload</label>
                        </div>
                        <div id="{{ $s['pfx'] }}_code_wrap">
                            <textarea class="slot-textarea" name="{{ $s['key'] }}" placeholder="Paste your ad code here..."></textarea>
                        </div>
                        <div id="{{ $s['pfx'] }}_img_wrap" style="display:none;">
                            <input type="file" class="slot-file" name="{{ $s['key'] }}_image" accept="image/*">
                        </div>
                    </div>
                    @endforeach
                    <div class="modal-footer-btns">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-modal-save" id="createSubmitBtn">
                            <span id="createBtnTxt">Save Ad Space</span>
                            <span id="createSpinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editAdModal" tabindex="-1" aria-labelledby="editAdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable adm-modal" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editAdModalLabel">✎ Edit Ad Space</h5>
                    <div class="modal-title-sub">Update your advertisement configuration</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editAdBody">
                <div style="text-align:center;padding:40px 20px;">
                    <div class="spinner-border text-primary" style="width:2rem;height:2rem;"></div>
                    <div style="margin-top:12px;font-size:13px;color:var(--text-muted);">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal fade del-modal" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="del-modal-body">
                <div class="del-icon-wrap">🗑</div>
                <div class="del-modal-title" id="delModalLabel">Delete this Ad?</div>
                <div class="del-modal-sub">This action is permanent and cannot be undone.</div>
                <div class="del-modal-btns">
                    <button type="button" class="btn-del-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-del-confirm" id="doDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BULK DELETE MODAL --}}
<div class="modal fade del-modal" id="bulkDelModal" tabindex="-1" aria-labelledby="bulkDelLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="del-modal-body">
                <div class="del-icon-wrap">⚠️</div>
                <div class="del-modal-title" id="bulkDelLabel">Delete Selected Ads?</div>
                <div class="del-modal-sub" id="bulkDelMsg"></div>
                <div class="del-modal-btns">
                    <button type="button" class="btn-del-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-del-confirm" id="doBulkDelBtn">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="adm-toast" role="alert" aria-live="polite"><span class="t-icon"></span><span class="t-msg"></span></div>



{{--
    ═══════════════════════════════════════════════════════════════
    master.blade.php এ Bootstrap include এর পরে এটা লাগাও:
        @stack('scripts')
    ═══════════════════════════════════════════════════════════════
--}}

<script>
(function () {
    'use strict';

    /* ── Bootstrap ready হওয়ার জন্য wait করে
       master layout এ Bootstrap defer/async থাকলেও কাজ করবে ── */
    function whenReady(fn) {
        if (typeof bootstrap !== 'undefined') { fn(); return; }
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof bootstrap !== 'undefined') { fn(); return; }
            var t = setInterval(function () {
                if (typeof bootstrap !== 'undefined') { clearInterval(t); fn(); }
            }, 30);
        });
    }

    /* CSRF — meta tag অথবা Blade fallback */
    var CSRF = (document.querySelector('meta[name="csrf-token"]') || {}).content
               || '{{ csrf_token() }}';

    /* ── TOAST ── */
    function toast(msg, type) {
        type = type || 'success';
        var el = document.getElementById('adm-toast');
        if (!el) return;
        var icons = { success: '✅', error: '❌', info: 'ℹ️', like: '💗' };
        el.querySelector('.t-icon').textContent = icons[type] || '✅';
        el.querySelector('.t-msg').textContent  = msg;
        el.className = 't-' + type + ' show';
        clearTimeout(el._t);
        el._t = setTimeout(function () { el.classList.remove('show'); }, 3000);
    }

    /* ── SLOT TOGGLE ── */
    function slotToggle(pfx, type) {
        var cw = document.getElementById(pfx + '_code_wrap');
        var iw = document.getElementById(pfx + '_img_wrap');
        if (cw) cw.style.display = type === 'code'  ? '' : 'none';
        if (iw) iw.style.display = type === 'image' ? '' : 'none';
    }

    /* ── BTN STATE ── */
    function setBtnState(btnId, txtId, spinId, loading, label) {
        var btn  = document.getElementById(btnId);
        var txt  = document.getElementById(txtId);
        var spin = document.getElementById(spinId);
        if (!btn) return;
        btn.disabled = loading;
        if (txt)  txt.textContent = label;
        if (spin) spin.classList.toggle('d-none', !loading);
    }

    /* ── ROW REMOVE ── */
    function removeRow(id) {
        var row = document.getElementById('row-' + id);
        if (!row) return;
        row.style.transition = 'opacity .3s, transform .3s';
        row.style.opacity = '0';
        row.style.transform = 'translateX(24px)';
        setTimeout(function () {
            row.remove();
            var n = document.querySelectorAll('#adsTbody tr[id^="row-"]').length;
            var el = document.getElementById('tableInfo');
            if (el) el.textContent = 'Showing ' + n + ' record(s)';
            updateBulkBtn();
        }, 320);
    }

    /* ════════════════════════════════
       CREATE FORM
    ════════════════════════════════ */
    var createForm  = document.getElementById('createAdForm');
    var createModal = document.getElementById('createAdModal');

    if (createForm) {
        createForm.addEventListener('change', function (e) {
            if (e.target.classList.contains('slot-type-radio'))
                slotToggle(e.target.dataset.pfx, e.target.value);
        });
        createForm.addEventListener('submit', function (e) {
            e.preventDefault();
            setBtnState('createSubmitBtn', 'createBtnTxt', 'createSpinner', true, 'Saving...');
            fetch('{{ route("admanager.store") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new FormData(this),
            })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                setBtnState('createSubmitBtn', 'createBtnTxt', 'createSpinner', false, 'Save Ad Space');
                if (d.success) {
                    bootstrap.Modal.getInstance(createModal).hide();
                    toast('Ad space created!');
                    setTimeout(function () { location.reload(); }, 800);
                } else { toast(JSON.stringify(d.errors || d.message), 'error'); }
            })
            .catch(function () {
                setBtnState('createSubmitBtn', 'createBtnTxt', 'createSpinner', false, 'Save Ad Space');
                toast('Something went wrong.', 'error');
            });
        });
    }

    if (createModal) {
        createModal.addEventListener('hidden.bs.modal', function () {
            if (createForm) createForm.reset();
            ['c_ha','c_sa','c_bp','c_ap'].forEach(function (p) { slotToggle(p, 'code'); });
        });
    }

    /* ════════════════════════════════
       TABLE BODY — event delegation
    ════════════════════════════════ */
    var tbody = document.getElementById('adsTbody');
    if (tbody) {
        tbody.addEventListener('click', function (e) {
            var edit = e.target.closest('.act-edit');
            var del  = e.target.closest('.act-del');
            var like = e.target.closest('.act-like');
            if (edit) { edit.blur(); openEditModal(edit.dataset.id); }
            if (del)  { del.blur();  openDelModal(del.dataset.id); }
            if (like) { doLike(like); }
        });
        tbody.addEventListener('change', function (e) {
            if (e.target.classList.contains('status-toggle-input')) doStatusToggle(e.target);
            if (e.target.classList.contains('row-check')) updateBulkBtn();
        });
    }

    /* ════════════════════════════════
       EDIT MODAL
    ════════════════════════════════ */
    var editAdBody  = document.getElementById('editAdBody');
    var editModalEl = document.getElementById('editAdModal');

    function openEditModal(id) {
        if (!editAdBody || !editModalEl) return;
        editAdBody.innerHTML = '<div style="text-align:center;padding:40px 20px;"><div class="spinner-border text-primary" style="width:2rem;height:2rem;"></div><div style="margin-top:12px;font-size:13px;color:var(--text-muted);">Loading...</div></div>';
        bootstrap.Modal.getOrCreateInstance(editModalEl).show();
        fetch('/admin/admanager/' + id + '/edit', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function (r) { return r.json(); })
        .then(function (d) { editAdBody.innerHTML = buildEditForm(d.ad); })
        .catch(function () {
            editAdBody.innerHTML = '<p style="color:var(--danger);text-align:center;padding:24px;">Failed to load. Try again.</p>';
        });
    }

    function buildEditForm(ad) {
        var slots = [
            { key:'header_ads',      label:'Header Ads',      icon:'🗞',  pfx:'e_ha', color:'#eef2ff' },
            { key:'sidebar_ads',     label:'Sidebar Ads',     icon:'📐', pfx:'e_sa', color:'#ecfdf5' },
            { key:'before_post_ads', label:'Before Post Ads', icon:'⬆',  pfx:'e_bp', color:'#fffbeb' },
            { key:'after_post_ads',  label:'After Post Ads',  icon:'⬇',  pfx:'e_ap', color:'#fff1f1' },
        ];
        var rows = slots.map(function (s) {
            var isImg = ad[s.key + '_type'] === 'image';
            var val   = (ad[s.key] || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
            var thumb = (isImg && ad[s.key])
                ? '<img src="/uploads/ads/' + ad[s.key] + '" style="max-height:56px;border-radius:8px;border:1px solid var(--border);margin-top:8px;display:block;" onerror="this.style.display=\'none\'">'
                : '';
            return '<div class="slot-card">'
                + '<div class="slot-card-head"><div class="slot-icon" style="background:' + s.color + ';">' + s.icon + '</div>'
                + '<div><div class="slot-title">' + s.label + '</div><div class="slot-subtitle">Choose ad type</div></div></div>'
                + '<div class="slot-radios">'
                + '<label class="slot-radio"><input type="radio" name="' + s.key + '_type" value="code" ' + (!isImg?'checked':'') + ' data-pfx="' + s.pfx + '" class="slot-type-radio"><i class="bi bi-code-square"></i> Ad Code</label>'
                + '<label class="slot-radio"><input type="radio" name="' + s.key + '_type" value="image" ' + (isImg?'checked':'') + ' data-pfx="' + s.pfx + '" class="slot-type-radio"><i class="bi bi-image"></i> Image Upload</label>'
                + '</div>'
                + '<div id="' + s.pfx + '_code_wrap" style="display:' + (isImg?'none':'') + ';">'
                + '<textarea class="slot-textarea" name="' + s.key + '" placeholder="Paste your ad code here...">' + val + '</textarea></div>'
                + '<div id="' + s.pfx + '_img_wrap" style="display:' + (isImg?'':'none') + ';">'
                + '<input type="file" class="slot-file" name="' + s.key + '_image" accept="image/*">' + thumb + '</div>'
                + '</div>';
        }).join('');
        return '<form id="editAdForm" enctype="multipart/form-data" novalidate>'
            + '<input type="hidden" name="_method" value="PUT">'
            + '<input type="hidden" name="ad_id" value="' + ad.id + '">'
            + rows
            + '<div class="modal-footer-btns">'
            + '<button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>'
            + '<button type="submit" class="btn-modal-save" id="editSubmitBtn">'
            + '<span id="editBtnTxt">Update Ad Space</span>'
            + '<span id="editSpinner" class="spinner-border spinner-border-sm d-none"></span>'
            + '</button></div></form>';
    }

    if (editAdBody) {
        editAdBody.addEventListener('change', function (e) {
            if (e.target.classList.contains('slot-type-radio'))
                slotToggle(e.target.dataset.pfx, e.target.value);
        });
        editAdBody.addEventListener('submit', function (e) {
            if (!e.target.matches('#editAdForm')) return;
            e.preventDefault();
            var form = e.target;
            var id   = form.querySelector('[name="ad_id"]').value;
            setBtnState('editSubmitBtn', 'editBtnTxt', 'editSpinner', true, 'Updating...');
            fetch('/admin/admanager/' + id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new FormData(form),
            })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                setBtnState('editSubmitBtn', 'editBtnTxt', 'editSpinner', false, 'Update Ad Space');
                if (d.success) {
                    bootstrap.Modal.getInstance(editModalEl).hide();
                    toast('Ad updated!');
                    setTimeout(function () { location.reload(); }, 800);
                } else { toast(JSON.stringify(d.errors || d.message), 'error'); }
            })
            .catch(function () {
                setBtnState('editSubmitBtn', 'editBtnTxt', 'editSpinner', false, 'Update Ad Space');
                toast('Something went wrong.', 'error');
            });
        });
    }

    /* ════════════════════════════════
       DELETE
       FIX কী ছিল:
       1. route prefix ছিল না → /admin/ prefix add
       2. Accept: application/json header ছিল না
          → Laravel CSRF mismatch বা route miss হলে
            redirect HTML ফেরত দেয়, JSON parse fail হয়
       3. r.ok check ছিল না → 404/500 silent fail হত
    ════════════════════════════════ */
    var _delId    = null;
    var delModal  = document.getElementById('delModal');
    var doDelBtn  = document.getElementById('doDeleteBtn');

    function openDelModal(id) {
        _delId = id;
        if (delModal) bootstrap.Modal.getOrCreateInstance(delModal).show();
    }

    if (doDelBtn) {
        doDelBtn.addEventListener('click', function () {
            if (!_delId) return;
            var self = this;
            self.disabled = true; self.textContent = 'Deleting...';

            fetch('/admin/admanager/' + _delId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',   // ← KEY FIX
                },
            })
            .then(function (r) {
                if (!r.ok) return r.text().then(function (t) { throw new Error('Server error ' + r.status + ': ' + t.substring(0,120)); });
                return r.json();
            })
            .then(function (d) {
                bootstrap.Modal.getInstance(delModal).hide();
                self.disabled = false; self.textContent = 'Yes, Delete';
                if (d.success) { removeRow(_delId); toast('Ad deleted.'); _delId = null; }
                else toast(d.message || 'Delete failed.', 'error');
            })
            .catch(function (err) {
                var m = bootstrap.Modal.getInstance(delModal);
                if (m) m.hide();
                self.disabled = false; self.textContent = 'Yes, Delete';
                toast(err.message || 'Delete failed.', 'error');
                console.error('[AdManager delete]', err);
            });
        });
    }

    /* ════════════════════════════════
       BULK DELETE
    ════════════════════════════════ */
    var bulkBtn      = document.getElementById('bulkDeleteBtn');
    var bulkDelModal = document.getElementById('bulkDelModal');
    var doBulkBtn    = document.getElementById('doBulkDelBtn');

    if (bulkBtn) {
        bulkBtn.addEventListener('click', function () {
            var ids = checkedIds();
            if (!ids.length) return;
            var msg = document.getElementById('bulkDelMsg');
            if (msg) msg.textContent = ids.length + ' item(s) will be permanently removed.';
            if (bulkDelModal) bootstrap.Modal.getOrCreateInstance(bulkDelModal).show();
        });
    }

    if (doBulkBtn) {
        doBulkBtn.addEventListener('click', function () {
            var ids = checkedIds();
            if (!ids.length) return;
            var self = this;
            self.disabled = true; self.textContent = 'Deleting...';
            fetch('{{ route("admanager.bulkDestroy") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ids: ids }),
            })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                var m = bootstrap.Modal.getInstance(bulkDelModal);
                if (m) m.hide();
                self.disabled = false; self.textContent = 'Delete All';
                if (d.success) { ids.forEach(removeRow); toast('Selected ads deleted.', 'info'); updateBulkBtn(); }
                else toast(d.message || 'Failed.', 'error');
            })
            .catch(function () {
                self.disabled = false; self.textContent = 'Delete All';
                toast('Something went wrong.', 'error');
            });
        });
    }

    /* ════════════════════════════════
       STATUS TOGGLE
    ════════════════════════════════ */
    function doStatusToggle(el) {
        var id   = el.dataset.id;
        var prev = el.checked;
        fetch('/admin/admanager/' + id + '/toggle-status', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            el.checked = d.status;
            var lbl = document.getElementById('slbl-' + id);
            if (lbl) { lbl.textContent = d.status ? 'Active' : 'Off'; lbl.className = 'status-label ' + (d.status ? 'active' : 'inactive'); }
            var row = document.getElementById('row-' + id);
            if (row) row.dataset.status = d.status ? '1' : '0';
            toast(d.status ? 'Ad activated' : 'Ad deactivated', d.status ? 'success' : 'info');
        })
        .catch(function () { el.checked = prev; toast('Status update failed.', 'error'); });
    }

    /* ════════════════════════════════
       LIKE — jQuery-style interaction
    ════════════════════════════════ */
    function doLike(btn) {
        var likes   = parseInt(btn.dataset.likes || '0', 10);
        var isLiked = btn.classList.contains('liked');
        likes = isLiked ? Math.max(0, likes - 1) : likes + 1;
        btn.dataset.likes = likes;
        btn.classList.toggle('liked', !isLiked);
        var badge = btn.querySelector('.like-badge');
        if (badge) { badge.textContent = likes; btn.classList.toggle('has-likes', likes > 0); }
        // pop animation
        var icon = btn.querySelector('i');
        if (icon) { icon.style.animation = 'none'; void icon.offsetWidth; icon.style.animation = 'likePop .35s ease'; }
        toast(isLiked ? 'Unliked 💔' : 'Liked! 💗', 'like');
    }

    /* ════════════════════════════════
       SEARCH + FILTER
    ════════════════════════════════ */
    var srch = document.getElementById('adSearch');
    var filt = document.getElementById('statusFilter');
    if (srch) srch.addEventListener('input',  applyFilters);
    if (filt) filt.addEventListener('change', applyFilters);

    function applyFilters() {
        var q  = srch ? srch.value.toLowerCase() : '';
        var st = filt ? filt.value : '';
        var n  = 0;
        document.querySelectorAll('#adsTbody tr[id^="row-"]').forEach(function (row) {
            var ok = (!q || row.textContent.toLowerCase().includes(q)) && (!st || row.dataset.status === st);
            row.style.display = ok ? '' : 'none';
            if (ok) n++;
        });
        var info = document.getElementById('tableInfo');
        if (info) info.textContent = 'Showing ' + n + ' record(s)';
    }

    /* ════════════════════════════════
       CHECKBOXES
    ════════════════════════════════ */
    var checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(function (c) { c.checked = checkAll.checked; });
            updateBulkBtn();
        });
    }

    function updateBulkBtn() {
        var all = document.querySelectorAll('.row-check').length;
        var cnt = checkedIds().length;
        var btn = document.getElementById('bulkDeleteBtn');
        var ca  = document.getElementById('checkAll');
        if (btn) { btn.classList.toggle('d-none', cnt === 0); if (cnt) btn.innerHTML = '<i class="bi bi-trash"></i> Delete (' + cnt + ')'; }
        if (ca)  { ca.indeterminate = cnt > 0 && cnt < all; ca.checked = cnt > 0 && cnt === all; }
    }

    function checkedIds() {
        return Array.from(document.querySelectorAll('.row-check:checked')).map(function (c) { return c.value; });
    }

    /* ════════════════════════════════
       aria-hidden fix — Bootstrap ready হলে init
    ════════════════════════════════ */
    whenReady(function () {
        ['createAdModal','editAdModal','delModal','bulkDelModal'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('hide.bs.modal', function () {
                if (document.activeElement && el.contains(document.activeElement))
                    document.activeElement.blur();
            });
        });
    });

})();
</script>
@endsection
