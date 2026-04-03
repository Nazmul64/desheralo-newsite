@extends('admin.master')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --bg-deep:       #0b0f1a;
        --bg-card:       #111827;
        --bg-glass:      rgba(255,255,255,0.04);
        --bg-glass-hov:  rgba(255,255,255,0.07);
        --border:        rgba(255,255,255,0.08);
        --accent:        #6366f1;
        --accent-light:  #818cf8;
        --accent-soft:   rgba(99,102,241,0.12);
        --danger:        #f43f5e;
        --danger-soft:   rgba(244,63,94,0.12);
        --success:       #10b981;
        --success-soft:  rgba(16,185,129,0.12);
        --text-primary:  #f1f5f9;
        --text-secondary:#94a3b8;
        --text-muted:    #475569;
        --shadow-glow:   0 0 40px rgba(99,102,241,0.15);
        --radius:        14px;
        --radius-sm:     8px;
    }

    body { font-family: 'Sora', sans-serif; background: var(--bg-deep); color: var(--text-primary); }
    .ss-page { padding: 32px 24px; }

    .ss-alert { display: flex; align-items: center; gap: 12px; background: var(--success-soft); border: 1px solid rgba(16,185,129,0.3); color: var(--success); border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 24px; font-size: 14px; animation: slideDown .35s ease; }
    .ss-alert .btn-close { margin-left: auto; filter: invert(1) opacity(.5); }
    @keyframes slideDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

    .ss-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.4), var(--shadow-glow); }
    .ss-card-header { display: flex; align-items: center; justify-content: space-between; padding: 22px 28px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, transparent 60%); }
    .ss-card-header-left { display: flex; align-items: center; gap: 14px; }
    .ss-header-icon { width: 42px; height: 42px; border-radius: 10px; background: var(--accent-soft); border: 1px solid rgba(99,102,241,0.3); display: grid; place-items: center; color: var(--accent-light); font-size: 18px; }
    .ss-card-title { font-size: 17px; font-weight: 600; color: var(--text-primary); margin: 0; }
    .ss-card-subtitle { font-size: 12px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; margin: 2px 0 0; }
    .ss-card-body { padding: 28px; }

    .ss-btn-add { display: inline-flex; align-items: center; gap: 8px; background: var(--accent); color: #fff; padding: 9px 18px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; box-shadow: 0 4px 14px rgba(99,102,241,0.35); }
    .ss-btn-add:hover { background: var(--accent-light); color: #fff; transform: translateY(-1px); }

    .ss-tabs { display: flex; gap: 4px; margin-bottom: 24px; background: var(--bg-glass); border-radius: var(--radius-sm); padding: 4px; width: fit-content; }
    .ss-tab-btn { display: flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 6px; border: none; background: transparent; color: var(--text-secondary); font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: all .2s; }
    .ss-tab-btn.active { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
    .ss-tab-btn:not(.active):hover { background: var(--bg-glass-hov); color: var(--text-primary); }
    .ss-tab-pane { display: none; }
    .ss-tab-pane.active { display: block; animation: fadeIn .25s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(4px); } to { opacity:1; transform:translateY(0); } }

    .ss-section-title { font-size: 11px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 16px; font-family: 'JetBrains Mono', monospace; }

    .ss-table-wrap { overflow-x: auto; border-radius: var(--radius-sm); border: 1px solid var(--border); }
    .ss-table { width: 100%; border-collapse: collapse; }
    .ss-table thead tr { background: rgba(99,102,241,0.06); border-bottom: 1px solid var(--border); }
    .ss-table thead th { padding: 13px 16px; font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); white-space: nowrap; font-family: 'JetBrains Mono', monospace; }
    .ss-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .ss-table tbody tr:last-child { border-bottom: none; }
    .ss-table tbody tr:hover { background: var(--bg-glass-hov); }
    .ss-table td { padding: 14px 16px; font-size: 13.5px; color: var(--text-secondary); vertical-align: middle; }
    .ss-table td:first-child { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--text-muted); }

    .ss-chip { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; font-family: 'JetBrains Mono', monospace; background: var(--accent-soft); color: var(--accent-light); border: 1px solid rgba(99,102,241,0.2); }
    .ss-thumb { height: 44px; border-radius: 6px; border: 1px solid var(--border); object-fit: contain; background: rgba(255,255,255,0.04); padding: 4px; }
    .ss-thumb-lg { height: 60px; }
    .ss-no-img { color: var(--text-muted); }
    .ss-url { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--text-muted); max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

    .ss-dropdown { position: relative; }
    .ss-action-btn { width: 34px; height: 34px; border-radius: 8px; background: var(--bg-glass); border: 1px solid var(--border); color: var(--text-secondary); display: grid; place-items: center; cursor: pointer; transition: all .2s; font-size: 14px; }
    .ss-action-btn:hover { background: var(--accent-soft); border-color: rgba(99,102,241,0.3); color: var(--accent-light); }
    .ss-dropdown-menu { position: absolute; right: 0; top: calc(100% + 6px); z-index: 100; background: #1a2035; border: 1px solid var(--border); border-radius: var(--radius-sm); min-width: 160px; box-shadow: 0 12px 40px rgba(0,0,0,0.5); display: none; overflow: hidden; }
    .ss-dropdown.open .ss-dropdown-menu { display: block; animation: fadeIn .15s ease; }
    .ss-dd-item { display: flex; align-items: center; gap: 10px; padding: 11px 16px; font-size: 13px; color: var(--text-secondary); text-decoration: none; cursor: pointer; width: 100%; background: none; border: none; font-family: 'Sora', sans-serif; transition: all .15s; }
    .ss-dd-item:hover { background: var(--bg-glass-hov); color: var(--text-primary); }
    .ss-dd-item.danger { color: var(--danger); }
    .ss-dd-item.danger:hover { background: var(--danger-soft); }
    .ss-dd-divider { height: 1px; background: var(--border); margin: 4px 0; }

    .ss-empty { text-align: center; padding: 56px 24px; color: var(--text-muted); }
    .ss-empty-icon { font-size: 42px; margin-bottom: 12px; opacity: .4; }
    .ss-empty-text { font-size: 14px; }

    @media (max-width: 768px) {
        .ss-card-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .ss-tabs { flex-wrap: wrap; width: 100%; }
        .ss-tab-btn { flex: 1; justify-content: center; }
    }
</style>

@section('content')
<div class="ss-page">

    @if(session('success'))
    <div class="ss-alert alert-dismissible">
        <span>✓</span>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="ss-card">
        <div class="ss-card-header">
            <div class="ss-card-header-left">
                <div class="ss-header-icon">⚙</div>
                <div>
                    <div class="ss-card-title">Site Settings</div>
                    {{-- DB stores: uploads/settings/filename.ext  →  asset() = /uploads/settings/filename.ext --}}
                    <div class="ss-card-subtitle">public/uploads/settings/</div>
                </div>
            </div>
            <a href="{{ route('sitesetting.create') }}" class="ss-btn-add">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>

        <div class="ss-card-body">

            <div class="ss-tabs">
                <button class="ss-tab-btn active" data-tab="appname">Ⓐ App Name</button>
                <button class="ss-tab-btn" data-tab="appicon">◈ App Icon</button>
                <button class="ss-tab-btn" data-tab="applogo">◉ App Logo</button>
            </div>

            {{-- TAB 1 --}}
            <div class="ss-tab-pane active" id="tab-appname">
                <div class="ss-section-title">// app name & metadata</div>
                <div class="ss-table-wrap">
                    <table class="ss-table">
                        <thead>
                            <tr>
                                <th>#</th><th>Title</th><th>Name</th><th>Short Name</th>
                                <th>Footer Content</th><th>Play Store</th><th>App Store</th><th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sitesettings as $index => $setting)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong style="color:var(--text-primary)">{{ $setting->title }}</strong></td>
                                <td>{{ $setting->name }}</td>
                                <td><span class="ss-chip">{{ $setting->short_name }}</span></td>
                                <td style="color:var(--text-muted);font-size:12px;">{{ Str::limit($setting->footer_content, 35) }}</td>
                                <td><span class="ss-url">{{ $setting->play_store_url ? Str::limit($setting->play_store_url, 24) : '—' }}</span></td>
                                <td><span class="ss-url">{{ $setting->app_store_url ? Str::limit($setting->app_store_url, 24) : '—' }}</span></td>
                                <td>
                                    <div class="ss-dropdown">
                                        <button class="ss-action-btn" onclick="toggleDd(this)">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="ss-dropdown-menu">
                                            <a class="ss-dd-item" href="{{ route('sitesetting.edit', $setting->id) }}">
                                                <i class="fas fa-pen" style="width:14px"></i> Edit
                                            </a>
                                            <div class="ss-dd-divider"></div>
                                            <form action="{{ route('sitesetting.destroy', $setting->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete this setting?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="ss-dd-item danger">
                                                    <i class="fas fa-trash" style="width:14px"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8">
                                <div class="ss-empty"><div class="ss-empty-icon">⚙</div><div class="ss-empty-text">No settings found.</div></div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAB 2 --}}
            <div class="ss-tab-pane" id="tab-appicon">
                <div class="ss-section-title">// favicon & icon assets</div>
                <div class="ss-table-wrap">
                    <table class="ss-table">
                        <thead><tr><th>#</th><th>Favicon</th><th>Icon</th></tr></thead>
                        <tbody>
                            @forelse($sitesettings as $index => $setting)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($setting->favicon)
                                        {{-- DB: uploads/settings/xxx.png → asset() → /uploads/settings/xxx.png --}}
                                        <img src="{{ asset($setting->favicon) }}" alt="Favicon" class="ss-thumb">
                                    @else <span class="ss-no-img">—</span> @endif
                                </td>
                                <td>
                                    @if($setting->icon)
                                        <img src="{{ asset($setting->icon) }}" alt="Icon" class="ss-thumb ss-thumb-lg">
                                    @else <span class="ss-no-img">—</span> @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3">
                                <div class="ss-empty"><div class="ss-empty-icon">◈</div><div class="ss-empty-text">No icon assets found.</div></div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAB 3 --}}
            <div class="ss-tab-pane" id="tab-applogo">
                <div class="ss-section-title">// logo assets</div>
                <div class="ss-table-wrap">
                    <table class="ss-table">
                        <thead><tr><th>#</th><th>Logo</th><th>Footer Logo</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($sitesettings as $index => $setting)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($setting->logo)
                                        <img src="{{ asset($setting->logo) }}" alt="Logo" class="ss-thumb ss-thumb-lg">
                                    @else <span class="ss-no-img">—</span> @endif
                                </td>
                                <td>
                                    @if($setting->footer_logo)
                                        <img src="{{ asset($setting->footer_logo) }}" alt="Footer Logo" class="ss-thumb ss-thumb-lg">
                                    @else <span class="ss-no-img">—</span> @endif
                                </td>
                                <td>
                                    <div class="ss-dropdown">
                                        <button class="ss-action-btn" onclick="toggleDd(this)">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="ss-dropdown-menu">
                                            <a class="ss-dd-item" href="{{ route('sitesetting.edit', $setting->id) }}">
                                                <i class="fas fa-pen" style="width:14px"></i> Edit
                                            </a>
                                            <div class="ss-dd-divider"></div>
                                            <form action="{{ route('sitesetting.destroy', $setting->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete this setting?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="ss-dd-item danger">
                                                    <i class="fas fa-trash" style="width:14px"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4">
                                <div class="ss-empty"><div class="ss-empty-icon">◉</div><div class="ss-empty-text">No logo assets found.</div></div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.ss-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.ss-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.ss-tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });
    function toggleDd(btn) {
        const dd = btn.closest('.ss-dropdown');
        const isOpen = dd.classList.contains('open');
        document.querySelectorAll('.ss-dropdown.open').forEach(d => d.classList.remove('open'));
        if (!isOpen) dd.classList.add('open');
    }
    document.addEventListener('click', e => {
        if (!e.target.closest('.ss-dropdown')) {
            document.querySelectorAll('.ss-dropdown.open').forEach(d => d.classList.remove('open'));
        }
    });
</script>
@endsection
