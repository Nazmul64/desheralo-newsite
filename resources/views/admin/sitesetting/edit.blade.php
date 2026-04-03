@extends('admin.master')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --bg-deep:       #0b0f1a;
        --bg-card:       #111827;
        --bg-input:      #0f172a;
        --bg-glass:      rgba(255,255,255,0.04);
        --bg-glass-hov:  rgba(255,255,255,0.07);
        --border:        rgba(255,255,255,0.08);
        --border-focus:  rgba(99,102,241,0.6);
        --accent:        #6366f1;
        --accent-light:  #818cf8;
        --accent-soft:   rgba(99,102,241,0.12);
        --warning:       #f59e0b;
        --danger:        #f43f5e;
        --danger-soft:   rgba(244,63,94,0.12);
        --success:       #10b981;
        --text-primary:  #f1f5f9;
        --text-secondary:#94a3b8;
        --text-muted:    #475569;
        --shadow-glow:   0 0 40px rgba(99,102,241,0.12);
        --radius:        14px;
        --radius-sm:     8px;
    }

    body { font-family: 'Sora', sans-serif; background: var(--bg-deep); color: var(--text-primary); }
    .ss-page { padding: 32px 24px; }

    .ss-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.4), var(--shadow-glow); }
    .ss-card-header { display: flex; align-items: center; justify-content: space-between; padding: 22px 28px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, transparent 60%); }
    .ss-card-header-left { display: flex; align-items: center; gap: 14px; }
    .ss-header-icon { width: 42px; height: 42px; border-radius: 10px; background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3); display: grid; place-items: center; color: var(--warning); font-size: 18px; }
    .ss-card-title { font-size: 17px; font-weight: 600; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 10px; }
    .ss-card-subtitle { font-size: 12px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; margin: 2px 0 0; }
    .ss-card-body { padding: 28px; }

    .ss-id-badge { display: inline-flex; align-items: center; background: var(--accent-soft); border: 1px solid rgba(99,102,241,0.25); color: var(--accent-light); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-family: 'JetBrains Mono', monospace; }
    .ss-btn-back { display: inline-flex; align-items: center; gap: 8px; background: var(--bg-glass); border: 1px solid var(--border); color: var(--text-secondary); padding: 9px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s; }
    .ss-btn-back:hover { border-color: rgba(255,255,255,0.15); color: var(--text-primary); background: var(--bg-glass-hov); }

    .ss-error-alert { background: var(--danger-soft); border: 1px solid rgba(244,63,94,0.3); border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 24px; animation: slideDown .3s ease; }
    .ss-error-alert ul { margin: 0; padding-left: 18px; font-size: 13.5px; color: #fda4af; }
    @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }

    .ss-tabs { display: flex; gap: 4px; margin-bottom: 28px; background: var(--bg-glass); border-radius: var(--radius-sm); padding: 4px; width: fit-content; }
    .ss-tab-btn { display: flex; align-items: center; gap: 8px; padding: 9px 20px; border-radius: 6px; border: none; background: transparent; color: var(--text-secondary); font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: all .2s; }
    .ss-tab-btn .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: 0.4; }
    .ss-tab-btn.active { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
    .ss-tab-btn.active .dot { opacity: 1; background: rgba(255,255,255,0.7); }
    .ss-tab-btn:not(.active):hover { background: var(--bg-glass-hov); color: var(--text-primary); }
    .ss-tab-pane { display: none; }
    .ss-tab-pane.active { display: block; animation: fadeUp .25s ease; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }

    .ss-section-label { font-size: 10.5px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 20px; font-family: 'JetBrains Mono', monospace; display: flex; align-items: center; gap: 8px; }
    .ss-section-label::after { content:''; flex: 1; height: 1px; background: var(--border); }

    .ss-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .ss-grid .full { grid-column: 1 / -1; }
    @media (max-width: 640px) { .ss-grid { grid-template-columns: 1fr; } .ss-grid .full { grid-column: 1; } }

    .ss-form-group { display: flex; flex-direction: column; gap: 6px; }
    .ss-label { font-size: 12.5px; font-weight: 600; color: var(--text-secondary); display: flex; align-items: center; gap: 5px; }
    .ss-label .req { color: var(--danger); font-size: 14px; line-height: 1; }
    .ss-input, .ss-textarea { background: var(--bg-input); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 11px 14px; font-family: 'Sora', sans-serif; font-size: 13.5px; color: var(--text-primary); transition: border-color .2s, box-shadow .2s; outline: none; width: 100%; }
    .ss-input::placeholder, .ss-textarea::placeholder { color: var(--text-muted); }
    .ss-input:focus, .ss-textarea:focus { border-color: var(--border-focus); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
    .ss-input.is-invalid, .ss-textarea.is-invalid { border-color: rgba(244,63,94,0.5); }
    .ss-textarea { resize: vertical; min-height: 110px; }
    .ss-invalid-msg { font-size: 12px; color: var(--danger); }

    /* Current image box */
    .ss-current-img { display: flex; align-items: center; gap: 12px; background: var(--bg-input); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; margin-bottom: 10px; }
    .ss-current-img img { height: 44px; border-radius: 6px; object-fit: contain; background: rgba(255,255,255,0.04); }
    .ss-current-img-info { flex: 1; }
    .ss-current-img-label { font-size: 10px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 2px; }
    .ss-current-img-status { font-size: 12px; color: var(--success); display: flex; align-items: center; gap: 4px; }
    .ss-current-img-status::before { content: '●'; font-size: 8px; }

    /* File zone */
    .ss-file-zone { border: 2px dashed var(--border); border-radius: var(--radius-sm); background: var(--bg-input); padding: 18px; text-align: center; cursor: pointer; transition: all .2s; position: relative; }
    .ss-file-zone:hover, .ss-file-zone.drag { border-color: rgba(99,102,241,0.4); background: var(--accent-soft); }
    .ss-file-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .ss-file-zone-icon { font-size: 22px; color: var(--text-muted); margin-bottom: 6px; }
    .ss-file-zone-text { font-size: 12.5px; color: var(--text-secondary); }
    .ss-file-zone-hint { font-size: 11px; color: var(--text-muted); margin-top: 3px; font-family: 'JetBrains Mono', monospace; }

    /* New preview */
    .ss-preview-box { margin-top: 10px; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid rgba(99,102,241,0.25); background: var(--accent-soft); display: none; align-items: center; gap: 12px; }
    .ss-preview-box.show { display: flex; animation: fadeUp .2s ease; }
    .ss-preview-box img { height: 50px; border-radius: 6px; object-fit: contain; }
    .ss-preview-box-info { flex: 1; overflow: hidden; }
    .ss-preview-box-label { font-size: 10px; color: var(--accent-light); font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 2px; }
    .ss-preview-box-name { font-size: 12px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .ss-divider { height: 1px; background: var(--border); margin: 28px 0; }

    .ss-actions { display: flex; gap: 12px; align-items: center; }
    .ss-btn-save { display: inline-flex; align-items: center; gap: 8px; background: var(--warning); color: #000; padding: 11px 22px; border-radius: var(--radius-sm); font-family: 'Sora', sans-serif; font-size: 13.5px; font-weight: 700; border: none; cursor: pointer; transition: all .2s; box-shadow: 0 4px 14px rgba(245,158,11,0.3); }
    .ss-btn-save:hover { background: #fbbf24; transform: translateY(-1px); }
    .ss-btn-cancel { display: inline-flex; align-items: center; gap: 8px; background: transparent; border: 1px solid var(--border); color: var(--text-secondary); padding: 11px 20px; border-radius: var(--radius-sm); font-family: 'Sora', sans-serif; font-size: 13.5px; font-weight: 500; text-decoration: none; transition: all .2s; }
    .ss-btn-cancel:hover { border-color: rgba(255,255,255,0.15); color: var(--text-primary); background: var(--bg-glass); }

    @media (max-width: 768px) {
        .ss-card-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .ss-tabs { flex-wrap: wrap; width: 100%; }
        .ss-tab-btn { flex: 1; justify-content: center; }
    }
</style>

@section('content')
<div class="ss-page">
<div class="ss-card">

    <div class="ss-card-header">
        <div class="ss-card-header-left">
            <div class="ss-header-icon">✎</div>
            <div>
                <div class="ss-card-title">
                    Edit Site Setting
                    <span class="ss-id-badge">ID #{{ $sitesetting->id }}</span>
                </div>
                {{-- File saves to: public/uploads/settings/ --}}
                <div class="ss-card-subtitle">public/uploads/settings/ · PUT</div>
            </div>
        </div>
        <a href="{{ route('sitesetting.index') }}" class="ss-btn-back">
            <i class="fas fa-arrow-left" style="font-size:11px"></i> Back
        </a>
    </div>

    <div class="ss-card-body">

        @if($errors->any())
        <div class="ss-error-alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('sitesetting.update', $sitesetting->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="ss-tabs">
                <button type="button" class="ss-tab-btn active" data-tab="e-appname"><span class="dot"></span> App Name</button>
                <button type="button" class="ss-tab-btn" data-tab="e-appicon"><span class="dot"></span> App Icon</button>
                <button type="button" class="ss-tab-btn" data-tab="e-applogo"><span class="dot"></span> App Logo</button>
            </div>

            {{-- TAB 1: App Name --}}
            <div class="ss-tab-pane active" id="e-appname">
                <div class="ss-section-label">app metadata</div>
                <div class="ss-grid">

                    <div class="ss-form-group">
                        <label class="ss-label">Title <span class="req">*</span></label>
                        <input type="text" name="title" class="ss-input @error('title') is-invalid @enderror"
                               value="{{ old('title', $sitesetting->title) }}" placeholder="e.g. Maan News">
                        @error('title')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="ss-form-group">
                        <label class="ss-label">Name <span class="req">*</span></label>
                        <input type="text" name="name" class="ss-input @error('name') is-invalid @enderror"
                               value="{{ old('name', $sitesetting->name) }}" placeholder="e.g. Lois Moore">
                        @error('name')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="ss-form-group">
                        <label class="ss-label">Short Name <span class="req">*</span></label>
                        <input type="text" name="short_name" class="ss-input @error('short_name') is-invalid @enderror"
                               value="{{ old('short_name', $sitesetting->short_name) }}" placeholder="e.g. MN">
                        @error('short_name')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="ss-form-group">
                        <label class="ss-label">Play Store URL</label>
                        <input type="url" name="play_store_url" class="ss-input @error('play_store_url') is-invalid @enderror"
                               value="{{ old('play_store_url', $sitesetting->play_store_url) }}"
                               placeholder="https://play.google.com/...">
                        @error('play_store_url')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="ss-form-group">
                        <label class="ss-label">App Store URL</label>
                        <input type="url" name="app_store_url" class="ss-input @error('app_store_url') is-invalid @enderror"
                               value="{{ old('app_store_url', $sitesetting->app_store_url) }}"
                               placeholder="https://apps.apple.com/...">
                        @error('app_store_url')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="ss-form-group full">
                        <label class="ss-label">Footer Content</label>
                        <textarea name="footer_content" class="ss-textarea @error('footer_content') is-invalid @enderror"
                                  placeholder="Enter footer content…">{{ old('footer_content', $sitesetting->footer_content) }}</textarea>
                        @error('footer_content')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>

            {{-- TAB 2: App Icon --}}
            <div class="ss-tab-pane" id="e-appicon">
                <div class="ss-section-label">favicon & icon — public/uploads/settings/</div>
                <div class="ss-grid">

                    {{-- Favicon --}}
                    <div class="ss-form-group">
                        <label class="ss-label">Favicon</label>
                        @if($sitesetting->favicon)
                        <div class="ss-current-img">
                            {{-- DB: uploads/settings/xxx.png → asset() → /uploads/settings/xxx.png --}}
                            <img src="{{ asset($sitesetting->favicon) }}" alt="Current Favicon">
                            <div class="ss-current-img-info">
                                <div class="ss-current-img-label">Current Favicon</div>
                                <div class="ss-current-img-status">Active</div>
                            </div>
                        </div>
                        @endif
                        <div class="ss-file-zone @error('favicon') is-invalid @enderror">
                            <div class="ss-file-zone-icon">🖼</div>
                            <div class="ss-file-zone-text">{{ $sitesetting->favicon ? 'Upload new to replace' : 'Drop file or browse' }}</div>
                            <div class="ss-file-zone-hint">PNG / ICO · 32×32px · Leave blank to keep</div>
                            <input type="file" name="favicon" id="e-faviconInput" accept="image/*">
                        </div>
                        @error('favicon')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                        <div class="ss-preview-box" id="e-faviconPreview">
                            <img id="e-faviconImg" src="" alt="">
                            <div class="ss-preview-box-info">
                                <div class="ss-preview-box-label">New Favicon</div>
                                <div class="ss-preview-box-name" id="e-faviconName"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Icon --}}
                    <div class="ss-form-group">
                        <label class="ss-label">Icon</label>
                        @if($sitesetting->icon)
                        <div class="ss-current-img">
                            <img src="{{ asset($sitesetting->icon) }}" alt="Current Icon">
                            <div class="ss-current-img-info">
                                <div class="ss-current-img-label">Current Icon</div>
                                <div class="ss-current-img-status">Active</div>
                            </div>
                        </div>
                        @endif
                        <div class="ss-file-zone @error('icon') is-invalid @enderror">
                            <div class="ss-file-zone-icon">◈</div>
                            <div class="ss-file-zone-text">{{ $sitesetting->icon ? 'Upload new to replace' : 'Drop file or browse' }}</div>
                            <div class="ss-file-zone-hint">PNG / SVG · Leave blank to keep</div>
                            <input type="file" name="icon" id="e-iconInput" accept="image/*">
                        </div>
                        @error('icon')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                        <div class="ss-preview-box" id="e-iconPreview">
                            <img id="e-iconImg" src="" alt="">
                            <div class="ss-preview-box-info">
                                <div class="ss-preview-box-label">New Icon</div>
                                <div class="ss-preview-box-name" id="e-iconName"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- TAB 3: App Logo --}}
            <div class="ss-tab-pane" id="e-applogo">
                <div class="ss-section-label">logo assets — public/uploads/settings/</div>
                <div class="ss-grid">

                    {{-- Logo --}}
                    <div class="ss-form-group">
                        <label class="ss-label">Logo</label>
                        @if($sitesetting->logo)
                        <div class="ss-current-img">
                            <img src="{{ asset($sitesetting->logo) }}" alt="Current Logo">
                            <div class="ss-current-img-info">
                                <div class="ss-current-img-label">Current Logo</div>
                                <div class="ss-current-img-status">Active</div>
                            </div>
                        </div>
                        @endif
                        <div class="ss-file-zone @error('logo') is-invalid @enderror">
                            <div class="ss-file-zone-icon">◉</div>
                            <div class="ss-file-zone-text">{{ $sitesetting->logo ? 'Upload new to replace' : 'Drop file or browse' }}</div>
                            <div class="ss-file-zone-hint">PNG / SVG · Transparent · Leave blank to keep</div>
                            <input type="file" name="logo" id="e-logoInput" accept="image/*">
                        </div>
                        @error('logo')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                        <div class="ss-preview-box" id="e-logoPreview">
                            <img id="e-logoImg" src="" alt="">
                            <div class="ss-preview-box-info">
                                <div class="ss-preview-box-label">New Logo</div>
                                <div class="ss-preview-box-name" id="e-logoName"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Logo --}}
                    <div class="ss-form-group">
                        <label class="ss-label">Footer Logo</label>
                        @if($sitesetting->footer_logo)
                        <div class="ss-current-img">
                            <img src="{{ asset($sitesetting->footer_logo) }}" alt="Current Footer Logo">
                            <div class="ss-current-img-info">
                                <div class="ss-current-img-label">Current Footer Logo</div>
                                <div class="ss-current-img-status">Active</div>
                            </div>
                        </div>
                        @endif
                        <div class="ss-file-zone @error('footer_logo') is-invalid @enderror">
                            <div class="ss-file-zone-icon">◉</div>
                            <div class="ss-file-zone-text">{{ $sitesetting->footer_logo ? 'Upload new to replace' : 'Drop file or browse' }}</div>
                            <div class="ss-file-zone-hint">PNG / SVG · Dark variant · Leave blank to keep</div>
                            <input type="file" name="footer_logo" id="e-footerLogoInput" accept="image/*">
                        </div>
                        @error('footer_logo')<div class="ss-invalid-msg">{{ $message }}</div>@enderror
                        <div class="ss-preview-box" id="e-footerLogoPreview">
                            <img id="e-footerLogoImg" src="" alt="">
                            <div class="ss-preview-box-info">
                                <div class="ss-preview-box-label">New Footer Logo</div>
                                <div class="ss-preview-box-name" id="e-footerLogoName"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="ss-divider"></div>

            <div class="ss-actions">
                <button type="submit" class="ss-btn-save"><i class="fas fa-save"></i> Update Setting</button>
                <a href="{{ route('sitesetting.index') }}" class="ss-btn-cancel">Cancel</a>
            </div>

        </form>
    </div>
</div>
</div>

<script>
    document.querySelectorAll('.ss-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.ss-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.ss-tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');
        });
    });

    function bindFilePreview(inputId, imgId, nameId, previewId) {
        document.getElementById(inputId).addEventListener('change', function() {
            const file = this.files[0];
            const box = document.getElementById(previewId);
            if (file) {
                document.getElementById(imgId).src = URL.createObjectURL(file);
                document.getElementById(nameId).textContent = file.name;
                box.classList.add('show');
            } else { box.classList.remove('show'); }
        });
    }
    bindFilePreview('e-faviconInput',    'e-faviconImg',    'e-faviconName',    'e-faviconPreview');
    bindFilePreview('e-iconInput',       'e-iconImg',       'e-iconName',       'e-iconPreview');
    bindFilePreview('e-logoInput',       'e-logoImg',       'e-logoName',       'e-logoPreview');
    bindFilePreview('e-footerLogoInput', 'e-footerLogoImg', 'e-footerLogoName', 'e-footerLogoPreview');

    document.querySelectorAll('.ss-file-zone').forEach(zone => {
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag'));
        zone.addEventListener('drop', () => zone.classList.remove('drag'));
    });
</script>
@endsection
