@extends('admin.master')

@section('content')
<div class="seo-wrapper">

    {{-- ── Tab Navigation ── --}}
    <div class="seo-tabs">
        <a href="{{ route('seooptimization.index') }}"
           class="seo-tab {{ request('tab', 'seo') === 'seo' ? 'is-active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0">
                <circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.4"/>
                <path d="M10 10L13 13" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
            SEO Settings
        </a>
        <a href="{{ route('seooptimization.index', ['tab' => 'sitemap']) }}"
           class="seo-tab {{ request('tab') === 'sitemap' ? 'is-active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0">
                <rect x="1.5" y="1.5" width="11" height="11" rx="2" stroke="currentColor" stroke-width="1.4"/>
                <path d="M4.5 7h5M7 4.5v5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
            Sitemap
        </a>
    </div>

    {{-- ── Session Flash Messages ── --}}
    @if(session('success'))
        <div class="seo-toast seo-toast--success" id="flashToast">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="8" fill="#16a34a"/>
                <path d="M4.5 8.5L6.5 10.5L11.5 5.5" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flashToast').remove()" class="toast-x">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="seo-toast seo-toast--error" id="flashToast">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="8" fill="#dc2626"/>
                <path d="M5 5L11 11M11 5L5 11" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            {{ session('error') }}
            <button onclick="document.getElementById('flashToast').remove()" class="toast-x">&times;</button>
        </div>
    @endif

    {{-- ── AJAX Toast (sitemap generate feedback) ── --}}
    <div id="ajaxToast" class="seo-toast" style="display:none;margin:16px 0;" role="alert"></div>

    {{-- ════════════════════════════════════════
         TAB 1 : SEO SETTINGS
    ════════════════════════════════════════ --}}
    @if(request('tab', 'seo') === 'seo')

    <div class="seo-card">
        <div class="seo-card__header">
            <div>
                <h2 class="seo-card__title">SEO Optimization</h2>
                <p class="seo-card__subtitle">Manage meta tags, keywords, and analytics tracking</p>
            </div>
            <button class="btn-add" onclick="openCreateModal()">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                    <path d="M6.5 1v11M1 6.5h11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                Add SEO
            </button>
        </div>

        <div class="seo-table-wrap">
            <table class="seo-table">
                <thead>
                    <tr>
                        <th class="col-sl">#</th>
                        <th>Keywords</th>
                        <th>Author</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Google Analytics</th>
                        <th class="col-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seos as $index => $seo)
                        <tr>
                            <td class="col-sl text-center">
                                <span class="row-num">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="cell-truncate" title="{{ $seo->keywords }}">
                                    {{ $seo->keywords ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @if($seo->author)
                                    <div class="author-cell">
                                        <div class="author-avatar">{{ strtoupper(substr($seo->author, 0, 1)) }}</div>
                                        <span>{{ $seo->author }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="cell-truncate" title="{{ $seo->meta_title }}">
                                    {{ $seo->meta_title ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="cell-truncate" title="{{ $seo->meta_description }}">
                                    {{ $seo->meta_description ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @if($seo->google_analytics)
                                    <span class="badge badge--success">Connected</span>
                                @else
                                    <span class="badge badge--muted">Not set</span>
                                @endif
                            </td>
                            <td class="col-action text-center">
                                <div class="action-dropdown" id="dropdown-{{ $seo->id }}">
                                    <button class="action-trigger"
                                        onclick="toggleDropdown(event,'dropdown-{{ $seo->id }}')"
                                        title="More actions">
                                        <svg width="4" height="16" viewBox="0 0 4 16" fill="none">
                                            <circle cx="2" cy="2"  r="1.5" fill="#6b7280"/>
                                            <circle cx="2" cy="8"  r="1.5" fill="#6b7280"/>
                                            <circle cx="2" cy="14" r="1.5" fill="#6b7280"/>
                                        </svg>
                                    </button>
                                    <div class="action-menu">
                                        <button type="button" class="action-item action-item--edit"
                                            onclick="openEditModal(
                                                {{ $seo->id }},
                                                @js($seo->keywords),
                                                @js($seo->author),
                                                @js($seo->meta_title),
                                                @js($seo->meta_description),
                                                @js($seo->google_analytics)
                                            );closeAllDropdowns();">
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                <path d="M9 1.5L11.5 4L4 11.5H1.5V9L9 1.5Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <div class="action-divider"></div>
                                        <form action="{{ route('seooptimization.destroy', $seo->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this SEO record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-item action-item--delete">
                                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                    <path d="M2 3.5h9M5 3.5V2h3v1.5M4 3.5v7h5v-7"
                                                          stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="12" cy="12" r="8.5" stroke="#d1d5db" stroke-width="1.5"/>
                                            <path d="M18.5 18.5L24 24" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <p class="empty-title">No SEO records yet</p>
                                    <p class="empty-sub">Click <strong>+ Add SEO</strong> to configure your first record.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         TAB 2 : SITEMAP
    ════════════════════════════════════════ --}}
    @else

    {{-- Header Card --}}
    <div class="seo-card">
        <div class="seo-card__header">
            <div>
                <h2 class="seo-card__title">XML Sitemap</h2>
                <p class="seo-card__subtitle">Generate and manage your site's XML sitemap for search engines</p>
            </div>

            {{-- AJAX button — no <form> needed --}}
            <button type="button" class="btn-add" id="generateBtn" onclick="generateSitemap()">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" id="generateIcon">
                    <path d="M6.5 1v7M3.5 5L6.5 8 9.5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 10.5h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" id="spinnerIcon"
                     style="display:none;animation:spin 1s linear infinite">
                    <circle cx="6.5" cy="6.5" r="5" stroke="rgba(255,255,255,.8)"
                            stroke-width="1.6" stroke-dasharray="20" stroke-dashoffset="8" stroke-linecap="round"/>
                </svg>
                <span id="generateBtnText">Generate Sitemap</span>
            </button>
        </div>

        {{-- Stats Row --}}
        <div class="sitemap-stats">
            <div class="stat-item">
                <span class="stat-label">Status</span>
                <span class="stat-value" id="statStatus">
                    @if(file_exists(public_path('sitemap.xml')))
                        <span class="status-dot status-dot--green"></span> Available
                    @else
                        <span class="status-dot status-dot--gray"></span> Not generated
                    @endif
                </span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">File</span>
                <span class="stat-value stat-mono">sitemap.xml</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">Location</span>
                <span class="stat-value stat-mono">/public/sitemap.xml</span>
            </div>
            @if(file_exists(public_path('sitemap.xml')))
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">Last modified</span>
                <span class="stat-value" id="statModified">
                    {{ \Carbon\Carbon::createFromTimestamp(filemtime(public_path('sitemap.xml')))->format('d M Y, h:i A') }}
                </span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">File size</span>
                <span class="stat-value" id="statSize">
                    {{ number_format(filesize(public_path('sitemap.xml')) / 1024, 1) }} KB
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- File Section (partial) --}}
    <div class="sitemap-section" id="sitemapSection">
        @if(file_exists(public_path('sitemap.xml')))
            @include('admin.seooptimization.partials.sitemap-exists')
        @else
            @include('admin.seooptimization.partials.sitemap-empty')
        @endif
    </div>

    @endif

</div>{{-- /.seo-wrapper --}}


{{-- ══════════════════════════════════════════════════════════
     CREATE MODAL
══════════════════════════════════════════════════════════ --}}
<div class="seo-modal-overlay" id="createModalOverlay" onclick="closeModal('createModal')">
    <div class="seo-modal" id="createModal" onclick="event.stopPropagation()">
        <div class="seo-modal__head">
            <div class="modal-head-left">
                <div class="modal-icon modal-icon--blue">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="seo-modal__title">Create SEO Record</h3>
            </div>
            <button class="seo-modal__close" onclick="closeModal('createModal')" title="Close">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 2L14 14M14 2L2 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('seooptimization.store') }}" method="POST" id="createForm">
            @csrf
            <div class="seo-modal__body">
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Keywords</label>
                        <textarea name="keywords" class="modal-textarea" rows="2"
                            placeholder="news, technology, updates..."></textarea>
                        <span class="modal-hint">Comma-separated keywords for search engines</span>
                    </div>
                </div>
                <div class="modal-row modal-row--2col">
                    <div class="modal-field">
                        <label class="modal-label">Author</label>
                        <input type="text" name="author" class="modal-input" placeholder="Author name">
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Meta Title</label>
                        <input type="text" name="meta_title" class="modal-input" placeholder="Page title (50–60 chars)">
                    </div>
                </div>
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Meta Description</label>
                        <textarea name="meta_description" class="modal-textarea" rows="2"
                            placeholder="Short description shown in search results (150–160 chars)..."></textarea>
                    </div>
                </div>
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Google Analytics</label>
                        <textarea name="google_analytics" class="modal-textarea modal-textarea--mono" rows="3"
                            placeholder="<!-- Google tag (gtag.js) -->"></textarea>
                        <span class="modal-hint">Paste your full GA4 tracking script here</span>
                    </div>
                </div>
            </div>
            <div class="seo-modal__foot">
                <button type="button" class="btn-cancel" onclick="closeModal('createModal')">Cancel</button>
                <button type="submit" class="btn-save">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M1 6.5L4 9.5L11 2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Save Record
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════
     EDIT MODAL
══════════════════════════════════════════════════════════ --}}
<div class="seo-modal-overlay" id="editModalOverlay" onclick="closeModal('editModal')">
    <div class="seo-modal" id="editModal" onclick="event.stopPropagation()">
        <div class="seo-modal__head">
            <div class="modal-head-left">
                <div class="modal-icon modal-icon--indigo">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M10 1.5L12.5 4L5 11.5H2.5V9L10 1.5Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="seo-modal__title">Edit SEO Record</h3>
            </div>
            <button class="seo-modal__close" onclick="closeModal('editModal')" title="Close">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 2L14 14M14 2L2 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="seo-modal__body">
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Keywords</label>
                        <textarea name="keywords" id="edit_keywords" class="modal-textarea" rows="2"></textarea>
                        <span class="modal-hint">Comma-separated keywords for search engines</span>
                    </div>
                </div>
                <div class="modal-row modal-row--2col">
                    <div class="modal-field">
                        <label class="modal-label">Author</label>
                        <input type="text" name="author" id="edit_author" class="modal-input">
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Meta Title</label>
                        <input type="text" name="meta_title" id="edit_meta_title" class="modal-input">
                    </div>
                </div>
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Meta Description</label>
                        <textarea name="meta_description" id="edit_meta_description" class="modal-textarea" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-row">
                    <div class="modal-field">
                        <label class="modal-label">Google Analytics</label>
                        <textarea name="google_analytics" id="edit_google_analytics"
                                  class="modal-textarea modal-textarea--mono" rows="3"></textarea>
                        <span class="modal-hint">Paste your full GA4 tracking script here</span>
                    </div>
                </div>
            </div>
            <div class="seo-modal__foot">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn-save">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M1 6.5L4 9.5L11 2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Update Record
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════
     STYLES
══════════════════════════════════ --}}
<style>
*, *::before, *::after { box-sizing: border-box; }

.seo-wrapper { max-width: 1200px; margin: 0 auto; padding: 0; }

/* ── Tabs ─────────────────────────── */
.seo-tabs {
    display: flex;
    border-bottom: 1.5px solid #e5e7eb;
    background: #f9fafb;
    gap: 2px;
    padding: 0 4px;
}
.seo-tab {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 12px 20px;
    font-size: 13.5px;
    font-weight: 500;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1.5px;
    transition: color .15s, border-color .15s;
}
.seo-tab:hover { color: #111827; }
.seo-tab.is-active { color: #1d4ed8; border-bottom-color: #1d4ed8; }

/* ── Toast ────────────────────────── */
.seo-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 500;
    margin: 16px 0;
}
.seo-toast--success { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
.seo-toast--error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
.toast-x { background:none; border:none; cursor:pointer; font-size:18px; color:inherit; margin-left:auto; line-height:1; padding:0; }

/* ── Card ─────────────────────────── */
.seo-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 12px 12px;
    margin-bottom: 0;
}
.seo-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #f3f4f6;
    gap: 16px;
}
.seo-card__title    { font-size:17px; font-weight:700; color:#111827; margin:0 0 2px; }
.seo-card__subtitle { font-size:13px; color:#9ca3af; margin:0; }

/* ── Buttons ──────────────────────── */
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    background: #1d4ed8;
    color: #fff;
    font-size: 13.5px;
    font-weight: 500;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .1s, opacity .15s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-add:hover  { background: #1e40af; }
.btn-add:active { transform: scale(.98); }
.btn-add:disabled { opacity: .65; cursor: not-allowed; transform: none; }

@keyframes spin { to { transform: rotate(360deg); } }

/* ── Table ────────────────────────── */
.seo-table-wrap { overflow-x: auto; }
.seo-table { width:100%; border-collapse:collapse; font-size:14px; }
.seo-table thead tr { background:#f9fafb; border-bottom:1px solid #e5e7eb; }
.seo-table th {
    padding: 11px 16px;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-align: left;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.seo-table tbody tr { border-bottom:1px solid #f3f4f6; transition:background .1s; }
.seo-table tbody tr:hover { background:#fafafa; }
.seo-table tbody tr:last-child { border-bottom:none; }
.seo-table td { padding:13px 16px; color:#374151; vertical-align:middle; }
.col-sl     { width:56px; }
.col-action { width:70px; }
.text-center { text-align:center !important; }
.text-muted  { color:#d1d5db; }
.row-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px;
    background: #f3f4f6; border-radius: 6px;
    font-size: 12px; font-weight: 600; color: #6b7280;
}
.cell-truncate {
    display: inline-block; max-width: 180px;
    overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
    vertical-align: middle;
}

/* Author */
.author-cell { display:flex; align-items:center; gap:8px; }
.author-avatar {
    width:28px; height:28px; border-radius:50%;
    background:#eff6ff; color:#1d4ed8;
    font-size:11px; font-weight:700;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}

/* Badges */
.badge { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; font-size:11.5px; font-weight:500; }
.badge--success { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
.badge--muted   { background:#f9fafb; color:#9ca3af; border:1px solid #e5e7eb; }

/* Empty state */
.empty-row { padding:56px 16px !important; }
.empty-state { display:flex; flex-direction:column; align-items:center; gap:8px; }
.empty-icon {
    width:52px; height:52px; background:#f9fafb; border:1px solid #e5e7eb;
    border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:4px;
}
.empty-title { font-size:15px; font-weight:600; color:#374151; margin:0; }
.empty-sub   { font-size:13.5px; color:#9ca3af; margin:0; }
.empty-sub strong { color:#374151; }

/* Dropdown */
.action-dropdown { position:relative; display:inline-block; }
.action-trigger  { background:none; border:none; cursor:pointer; padding:5px 9px; border-radius:6px; transition:background .12s; }
.action-trigger:hover { background:#f3f4f6; }
.action-menu {
    display: none;
    position: absolute; right:0; top:calc(100% + 4px);
    background: #fff; border:1px solid #e5e7eb; border-radius:9px;
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
    min-width: 130px; z-index:200; padding:4px;
    animation: menuIn .12s ease;
}
@keyframes menuIn { from{opacity:0;transform:translateY(-4px)} to{opacity:1;transform:translateY(0)} }
.action-dropdown.is-open .action-menu { display:block; }
.action-item {
    display:flex; align-items:center; gap:8px;
    width:100%; padding:8px 12px;
    border:none; background:none;
    font-size:13px; font-weight:500;
    border-radius:6px; cursor:pointer; text-align:left;
    transition:background .1s;
}
.action-item--edit   { color:#1d4ed8; }
.action-item--edit:hover   { background:#eff6ff; }
.action-item--delete { color:#dc2626; }
.action-item--delete:hover { background:#fef2f2; }
.action-divider { height:1px; background:#f3f4f6; margin:3px 0; }

/* ── Sitemap Stats ────────────────── */
.sitemap-stats {
    display:flex; align-items:center; flex-wrap:wrap; gap:0;
    padding:14px 24px; background:#fafafa;
    border-top:1px solid #f3f4f6; border-radius:0 0 12px 12px;
}
.stat-item { display:flex; flex-direction:column; gap:2px; padding:0 20px 0 0; }
.stat-item:first-child { padding-left:0; }
.stat-label { font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.04em; }
.stat-value { font-size:13px; color:#374151; font-weight:500; display:flex; align-items:center; gap:6px; }
.stat-mono  { font-family:'SF Mono','Fira Code',monospace; font-size:12px; color:#4b5563; }
.stat-divider { width:1px; height:32px; background:#e5e7eb; margin:0 20px 0 0; flex-shrink:0; }

.status-dot { width:7px; height:7px; border-radius:50%; display:inline-block; }
.status-dot--green { background:#22c55e; box-shadow:0 0 0 2px #dcfce7; }
.status-dot--gray  { background:#d1d5db; }

/* Sitemap section */
.sitemap-section { padding:24px; }

/* File card */
.sitemap-file-card {
    display:flex; align-items:center; gap:18px;
    padding:20px 24px; background:#fff;
    border:1.5px solid #e5e7eb; border-radius:12px; margin-bottom:14px;
}
.sitemap-file-icon {
    width:52px; height:52px; background:#eff6ff; border-radius:10px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.sitemap-file-info   { flex:1; min-width:0; }
.sitemap-file-name   { font-size:15px; font-weight:700; color:#111827; margin:0 0 3px; font-family:'SF Mono','Fira Code',monospace; }
.sitemap-file-meta   { font-size:12.5px; color:#9ca3af; margin:0 0 4px; }
.sitemap-file-path   { margin:0; }
.sitemap-url-link    {
    display:inline-flex; align-items:center;
    font-size:12.5px; color:#3b82f6; text-decoration:none;
    font-family:'SF Mono','Fira Code',monospace; transition:color .15s;
}
.sitemap-url-link:hover { color:#1d4ed8; text-decoration:underline; }
.sitemap-file-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }

.btn-download {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; background:#1d4ed8; color:#fff;
    font-size:13.5px; font-weight:500; border:none; border-radius:8px;
    cursor:pointer; text-decoration:none; transition:background .15s,transform .1s;
}
.btn-download:hover  { background:#1e40af; }
.btn-download:active { transform:scale(.98); }

.btn-regenerate {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 16px; background:#fff; color:#374151;
    font-size:13.5px; font-weight:500; border:1.5px solid #e5e7eb; border-radius:8px;
    cursor:pointer; text-decoration:none; transition:background .15s,border-color .15s,opacity .15s;
}
.btn-regenerate:hover { background:#f9fafb; border-color:#d1d5db; }
.btn-regenerate:disabled { opacity:.65; cursor:not-allowed; }

.sitemap-info-box {
    display:flex; align-items:flex-start; gap:10px;
    padding:12px 16px; background:#eff6ff; border:1px solid #bfdbfe;
    border-radius:8px; font-size:13px; color:#1e40af; line-height:1.5;
}
.sitemap-info-box p { margin:0; }
.sitemap-info-box strong { color:#1e3a8a; }

/* Sitemap empty */
.sitemap-empty {
    display:flex; flex-direction:column; align-items:center; text-align:center;
    padding:52px 24px; gap:10px;
}
.sitemap-empty-icon {
    width:68px; height:68px; background:#f8fafc;
    border:1.5px dashed #cbd5e1; border-radius:16px;
    display:flex; align-items:center; justify-content:center; margin-bottom:4px;
}
.sitemap-empty-title { font-size:17px; font-weight:700; color:#374151; margin:0; }
.sitemap-empty-sub { font-size:14px; color:#9ca3af; margin:0; max-width:420px; line-height:1.6; }
.sitemap-empty-sub strong { color:#374151; }
.sitemap-empty-sub code { background:#f3f4f6; padding:1px 5px; border-radius:4px; font-family:monospace; font-size:12.5px; color:#374151; }
.sitemap-empty-steps {
    display:flex; align-items:center; gap:12px; margin-top:16px;
    flex-wrap:wrap; justify-content:center;
}
.step-item  { display:flex; align-items:center; gap:8px; }
.step-num {
    width:26px; height:26px; background:#1d4ed8; color:#fff;
    font-size:12px; font-weight:700; border-radius:50%;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.step-text  { font-size:13px; color:#6b7280; }
.step-text strong { color:#374151; }
.step-arrow { font-size:14px; color:#d1d5db; }

/* ── Modal ────────────────────────── */
.seo-modal-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(17,24,39,.5); z-index:1000;
    align-items:center; justify-content:center; padding:24px;
    backdrop-filter:blur(2px);
}
.seo-modal-overlay.is-open { display:flex; }
.seo-modal {
    background:#fff; border-radius:16px; width:100%; max-width:540px; max-height:90vh;
    display:flex; flex-direction:column;
    box-shadow:0 24px 64px rgba(0,0,0,.18); animation:modalIn .18s ease;
}
@keyframes modalIn { from{opacity:0;transform:scale(.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
.seo-modal__head {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px 16px; border-bottom:1px solid #f3f4f6;
}
.modal-head-left { display:flex; align-items:center; gap:10px; }
.modal-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.modal-icon--blue   { background:#eff6ff; color:#1d4ed8; }
.modal-icon--indigo { background:#eef2ff; color:#4338ca; }
.seo-modal__title { font-size:15px; font-weight:700; color:#111827; margin:0; }
.seo-modal__close {
    background:none; border:none; cursor:pointer; padding:4px;
    border-radius:6px; color:#9ca3af; transition:background .12s,color .12s;
}
.seo-modal__close:hover { background:#f3f4f6; color:#374151; }
.seo-modal__body {
    padding:22px 24px; overflow-y:auto; flex:1;
    display:flex; flex-direction:column; gap:16px;
}
.seo-modal__foot {
    padding:16px 24px 20px; border-top:1px solid #f3f4f6;
    display:flex; justify-content:flex-end; gap:10px;
}
.modal-row { display:flex; flex-direction:column; }
.modal-row--2col { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.modal-field { display:flex; flex-direction:column; gap:5px; }
.modal-label { font-size:12.5px; font-weight:600; color:#374151; }
.modal-hint  { font-size:11.5px; color:#9ca3af; }
.modal-input, .modal-textarea {
    width:100%; padding:9px 12px;
    border:1.5px solid #e5e7eb; border-radius:8px;
    font-size:13.5px; color:#111827; outline:none; font-family:inherit;
    transition:border-color .15s,box-shadow .15s; resize:vertical; background:#fff;
}
.modal-input:focus, .modal-textarea:focus {
    border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12);
}
.modal-textarea { min-height:72px; }
.modal-textarea--mono { font-family:'SF Mono','Fira Code',monospace; font-size:12.5px; }
.btn-cancel {
    display:inline-flex; align-items:center; padding:9px 20px;
    background:#fff; color:#6b7280; font-size:14px; font-weight:500;
    border:1.5px solid #e5e7eb; border-radius:8px; cursor:pointer;
    transition:background .15s,border-color .15s;
}
.btn-cancel:hover { background:#f9fafb; border-color:#d1d5db; }
.btn-save {
    display:inline-flex; align-items:center; gap:7px; padding:9px 22px;
    background:#1d4ed8; color:#fff; font-size:14px; font-weight:500;
    border:none; border-radius:8px; cursor:pointer;
    transition:background .15s,transform .1s;
}
.btn-save:hover  { background:#1e40af; }
.btn-save:active { transform:scale(.98); }
</style>


{{-- ══════════════════════════════════
     SCRIPTS
══════════════════════════════════ --}}
<script>
const SEO_BASE    = "{{ rtrim(url('admin/seooptimization'), '/') }}";
const CSRF_TOKEN  = "{{ csrf_token() }}";
const SITEMAP_URL = "{{ url('/sitemap.xml') }}";
const DOWNLOAD_URL= "{{ route('seooptimization.download-sitemap') }}";
const GENERATE_URL= "{{ route('seooptimization.generate-sitemap') }}";

/* ══════════════════════════════════
   SITEMAP AJAX GENERATE
══════════════════════════════════ */
async function generateSitemap() {
    const btn     = document.getElementById('generateBtn');
    const btnText = document.getElementById('generateBtnText');
    const icon    = document.getElementById('generateIcon');
    const spinner = document.getElementById('spinnerIcon');
    const section = document.getElementById('sitemapSection');

    if (!btn || btn.disabled) return;

    // Loading state
    btn.disabled          = true;
    btnText.textContent   = 'Generating...';
    icon.style.display    = 'none';
    spinner.style.display = 'block';

    try {
        const res  = await fetch(GENERATE_URL, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept'      : 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await res.json().catch(() => ({}));

        if (res.ok && data.success !== false) {
            // Update status dot in stats bar
            const statStatus = document.getElementById('statStatus');
            if (statStatus) {
                statStatus.innerHTML = '<span class="status-dot status-dot--green"></span> Available';
            }
            // Update file card area
            if (section) {
                section.innerHTML = buildFileCard(data);
            }
            showToast('success', '✓ Sitemap generated with ' + (data.url_count || 1) + ' URL(s).');
        } else {
            showToast('error', data.message || 'Generation failed. Check server permissions.');
        }

    } catch (err) {
        showToast('error', 'Network error: ' + err.message);
    } finally {
        btn.disabled          = false;
        btnText.textContent   = 'Generate Sitemap';
        icon.style.display    = 'block';
        spinner.style.display = 'none';
    }
}

/* Build the file card HTML after successful generation */
function buildFileCard(data) {
    const size     = data.size     ? data.size + ' KB' : '—';
    const modified = data.modified ? data.modified       : 'just now';

    return `
    <div class="sitemap-file-card">
        <div class="sitemap-file-icon">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                <rect x="5" y="2" width="14" height="18" rx="2" fill="#dbeafe" stroke="#3b82f6" stroke-width="1.2"/>
                <rect x="9" y="2" width="10" height="6" rx="1" fill="#bfdbfe"/>
                <path d="M8 12h12M8 15h8M8 18h5" stroke="#3b82f6" stroke-width="1" stroke-linecap="round" opacity=".6"/>
                <path d="M17 17l4 4" stroke="#3b82f6" stroke-width="1.4" stroke-linecap="round"/>
                <circle cx="21" cy="21" r="4" fill="#3b82f6"/>
                <path d="M21 18.5v2.5M21 21l1.2 1.2" stroke="#fff" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="sitemap-file-info">
            <p class="sitemap-file-name">sitemap.xml</p>
            <p class="sitemap-file-meta">${size} &nbsp;·&nbsp; Last updated ${modified}</p>
            <p class="sitemap-file-path">
                <a href="/sitemap.xml" target="_blank" class="sitemap-url-link">
                    ${SITEMAP_URL}
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none" style="margin-left:3px">
                        <path d="M2 9L9 2M9 2H4.5M9 2V6.5" stroke="currentColor" stroke-width="1.3"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </p>
        </div>
        <div class="sitemap-file-actions">
            <a href="${DOWNLOAD_URL}" class="btn-download">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M7 1.5v8M3.5 6.5L7 10l3.5-3.5" stroke="currentColor" stroke-width="1.6"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 11.5h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                Download
            </a>
            <button type="button" class="btn-regenerate" onclick="generateSitemap()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M12 7A5 5 0 1 1 7 2a5 5 0 0 1 3.54 1.46" stroke="currentColor"
                          stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M10 1v3h3" stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Regenerate
            </button>
        </div>
    </div>
    <div class="sitemap-info-box">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" style="flex-shrink:0;margin-top:1px">
            <circle cx="7.5" cy="7.5" r="6.5" stroke="#3b82f6" stroke-width="1.3"/>
            <path d="M7.5 6.5v4" stroke="#3b82f6" stroke-width="1.4" stroke-linecap="round"/>
            <circle cx="7.5" cy="4.5" r=".8" fill="#3b82f6"/>
        </svg>
        <p>Submit this sitemap URL to <strong>Google Search Console</strong> and
           <strong>Bing Webmaster Tools</strong> to improve indexing speed and visibility.</p>
    </div>`;
}

/* ══════════════════════════════════
   AJAX TOAST
══════════════════════════════════ */
let _toastTimer;
function showToast(type, message) {
    const toast = document.getElementById('ajaxToast');
    if (!toast) return;
    clearTimeout(_toastTimer);

    toast.className = 'seo-toast seo-toast--' + type;
    const icon = type === 'success'
        ? `<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#16a34a"/><path d="M4.5 8.5L6.5 10.5L11.5 5.5" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>`
        : `<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#dc2626"/><path d="M5 5L11 11M11 5L5 11" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>`;
    toast.innerHTML = icon + message +
        `<button onclick="this.parentElement.style.display='none'" class="toast-x">&times;</button>`;
    toast.style.display   = 'flex';
    toast.style.opacity   = '1';
    toast.style.transition= '';

    _toastTimer = setTimeout(() => {
        toast.style.transition = 'opacity .5s';
        toast.style.opacity    = '0';
        setTimeout(() => { toast.style.display = 'none'; }, 500);
    }, 5000);
}

/* ── Create Modal ── */
function openCreateModal() {
    document.getElementById('createForm').reset();
    document.getElementById('createModalOverlay').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

/* ── Edit Modal ── */
function openEditModal(id, keywords, author, metaTitle, metaDesc, analytics) {
    const form = document.getElementById('editForm');
    form.action = SEO_BASE + '/' + id;
    document.getElementById('edit_keywords').value          = keywords  ?? '';
    document.getElementById('edit_author').value            = author    ?? '';
    document.getElementById('edit_meta_title').value        = metaTitle ?? '';
    document.getElementById('edit_meta_description').value  = metaDesc  ?? '';
    document.getElementById('edit_google_analytics').value  = analytics ?? '';
    document.getElementById('editModalOverlay').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

/* ── Close Modal ── */
function closeModal(modalId) {
    document.getElementById(modalId + 'Overlay').classList.remove('is-open');
    document.body.style.overflow = '';
}

/* ESC closes modals */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal('createModal'); closeModal('editModal'); }
});

/* ── Dropdown ── */
function toggleDropdown(event, id) {
    event.stopPropagation();
    const el     = document.getElementById(id);
    const isOpen = el.classList.contains('is-open');
    closeAllDropdowns();
    if (!isOpen) el.classList.add('is-open');
}
function closeAllDropdowns() {
    document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('is-open'));
}
document.addEventListener('click', closeAllDropdowns);

/* Auto-dismiss session flash */
setTimeout(() => {
    const t = document.getElementById('flashToast');
    if (t) {
        t.style.transition = 'opacity .5s';
        t.style.opacity    = '0';
        setTimeout(() => t.remove(), 500);
    }
}, 4000);
</script>
@endsection
