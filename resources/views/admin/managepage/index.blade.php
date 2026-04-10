@extends('admin.master')

@section('content')
<div class="container-fluid px-4 py-5">

    @if(session('success'))
        <div class="alert-toast d-flex align-items-center gap-3 mb-4 px-4 py-3">
            <span class="toast-icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="9" fill="#16a34a"/><path d="M5 9.5L7.5 12L13 6.5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <span class="toast-text">{{ session('success') }}</span>
            <button type="button" class="toast-close ms-auto" data-bs-dismiss="alert" aria-label="Close">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 1L13 13M13 1L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header d-flex align-items-center justify-content-between mb-5">
        <div>
            <p class="page-eyebrow mb-1">Configuration</p>
            <h1 class="page-title mb-0">Page Settings</h1>
        </div>
        @if(!$page)
            <a href="{{ route('managepage.create') }}" class="btn-primary-action">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.5 1v13M1 7.5h13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Create Settings
            </a>
        @else
            <a href="{{ route('managepage.edit', $page->id) }}" class="btn-secondary-action">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M10 2L12 4L4 12H2V10L10 2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                Edit Settings
            </a>
        @endif
    </div>

    @if(!$page)
        {{-- Empty State --}}
        <div class="empty-state-card text-center">
            <div class="empty-icon-ring mx-auto mb-4">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><circle cx="14" cy="14" r="13" stroke="currentColor" stroke-width="1.5"/><path d="M9 14h10M14 9v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <h5 class="empty-title mb-2">No settings configured yet</h5>
            <p class="empty-sub mb-4">Set up your page settings to control labels and titles across your site.</p>
            <a href="{{ route('managepage.create') }}" class="btn-primary-action">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.5 1v13M1 7.5h13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Create Settings
            </a>
        </div>

    @else
    <div class="settings-layout">

        {{-- Sidebar Nav --}}
        <aside class="settings-sidebar">
            <nav class="sidebar-nav" id="sectionTabs">
                @php
                    $sections = [
                        'home_one'       => ['label' => 'Home One',       'icon' => 'home'],
                        'home_two'       => ['label' => 'Home Two',       'icon' => 'layers'],
                        'menu_title'     => ['label' => 'Menu Title',     'icon' => 'menu'],
                        'all_pages'      => ['label' => 'All Pages',      'icon' => 'file'],
                        'contact_us'     => ['label' => 'Contact Us',     'icon' => 'mail'],
                        'footer_section' => ['label' => 'Footer Section', 'icon' => 'layout'],
                    ];
                    $active = request('section', 'home_one');
                    $icons = [
                        'home'   => '<path d="M1 9L7 2L13 9V14H9V10H5V14H1V9Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="none"/>',
                        'layers' => '<path d="M1 5L7 2L13 5L7 8L1 5Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="none"/><path d="M1 9L7 12L13 9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" fill="none"/>',
                        'menu'   => '<path d="M1 3h12M1 7h12M1 11h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
                        'file'   => '<path d="M2 1h7l3 3v10H2V1Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="none"/><path d="M9 1v3h3" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="none"/>',
                        'mail'   => '<rect x="1" y="3" width="12" height="9" rx="1.5" stroke="currentColor" stroke-width="1.4" fill="none"/><path d="M1 4L7 8.5L13 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" fill="none"/>',
                        'layout' => '<rect x="1" y="1" width="12" height="12" rx="1.5" stroke="currentColor" stroke-width="1.4" fill="none"/><path d="M1 5h12" stroke="currentColor" stroke-width="1.4"/><path d="M5 5v8" stroke="currentColor" stroke-width="1.4"/>',
                    ];
                @endphp
                @foreach($sections as $key => $info)
                    <a href="#" data-section="{{ $key }}"
                       class="sidebar-link {{ $active === $key ? 'is-active' : '' }}">
                        <span class="sidebar-link-icon">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">{!! $icons[$info['icon']] !!}</svg>
                        </span>
                        <span>{{ $info['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Content Panels --}}
        <main class="settings-content">

            {{-- ── Home One ── --}}
            <div class="section-panel" id="panel-home_one" style="{{ $active !== 'home_one' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">Home One</h2>
                    <p class="panel-desc">Labels and titles used on the first home page layout.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $homeOneFields = [
                            'top_category'        => 'Top Category',
                            'most_popular_title'  => 'Most Popular Title',
                            'stay_connected_title'=> 'Stay Connected Title',
                            'follower_text_one'   => 'Follower Text One',
                            'follower_text_two'   => 'Follower Text Two',
                            'follower_text_three' => 'Follower Text Three',
                            'follower_text_four'  => 'Follower Text Four',
                            'dont_miss_title'     => "Don't Miss Title",
                        ];
                    @endphp
                    @foreach($homeOneFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Home Two ── --}}
            <div class="section-panel" id="panel-home_two" style="{{ $active !== 'home_two' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">Home Two</h2>
                    <p class="panel-desc">Labels and titles used on the second home page layout.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $homeTwoFields = [
                            'breaking_news_title' => 'Breaking News Title',
                            'trending_news_title' => 'Trending News Title',
                            'weekly_reviews'      => 'Weekly Reviews',
                            'editors_picks'       => "Editor's Picks",
                            'button_text'         => 'Button Text',
                            'feature_post'        => 'Feature Post',
                            'feature_video_title' => 'Feature Video Title',
                        ];
                    @endphp
                    @foreach($homeTwoFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Menu Title ── --}}
            <div class="section-panel" id="panel-menu_title" style="{{ $active !== 'menu_title' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">Menu Title</h2>
                    <p class="panel-desc">Navigation menu display titles.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $menuFields = [
                            'menu_title_one' => 'Menu Title One',
                            'menu_title_two' => 'Menu Title Two',
                        ];
                    @endphp
                    @foreach($menuFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── All Pages ── --}}
            <div class="section-panel" id="panel-all_pages" style="{{ $active !== 'all_pages' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">All Pages</h2>
                    <p class="panel-desc">Common titles and labels shared across all pages.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $allPageFields = [
                            'home_title'         => 'Home Title',
                            'popular_post_title' => 'Popular Post Title',
                            'gallery_title'      => 'Gallery Title',
                            'recent_post_title'  => 'Recent Post Title',
                            'tag_title'          => 'Tag Title',
                        ];
                    @endphp
                    @foreach($allPageFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Contact Us ── --}}
            <div class="section-panel" id="panel-contact_us" style="{{ $active !== 'contact_us' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">Contact Us</h2>
                    <p class="panel-desc">Text and labels for the contact page.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $contactFields = [
                            'get_in_touch'     => 'Get In Touch',
                            'address'          => 'Address',
                            'phone_text'       => 'Phone Text',
                            'email_text'       => 'Email Text',
                            'form_button_text' => 'Form Button Text',
                        ];
                    @endphp
                    @foreach($contactFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Footer Section ── --}}
            <div class="section-panel" id="panel-footer_section" style="{{ $active !== 'footer_section' ? 'display:none' : '' }}">
                <div class="panel-header mb-4">
                    <h2 class="panel-heading">Footer Section</h2>
                    <p class="panel-desc">Labels and titles used in the site footer.</p>
                </div>
                <div class="fields-grid">
                    @php
                        $footerFields = [
                            'post_title'      => 'Post Title',
                            'news'            => 'News',
                            'about'           => 'About',
                            'news_tags_title' => 'News Tags Title',
                            'subscribe_text'  => 'Subscribe Text',
                        ];
                    @endphp
                    @foreach($footerFields as $field => $label)
                        <div class="field-item">
                            <label class="field-label">{{ $label }}</label>
                            <div class="field-value">{{ $page->$field ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
    @endif
</div>

<style>
/* ──────────────────────────────────────────────
   Toast
────────────────────────────────────────────── */
.alert-toast {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    color: #15803d;
    font-size: 14px;
}
.toast-close {
    background: none; border: none; cursor: pointer;
    color: #16a34a; padding: 0; line-height: 1;
}

/* ──────────────────────────────────────────────
   Page Header
────────────────────────────────────────────── */
.page-eyebrow {
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #6b7280;
}
.page-title {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    letter-spacing: -.02em;
}

/* ──────────────────────────────────────────────
   Buttons
────────────────────────────────────────────── */
.btn-primary-action {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    background: #1d4ed8;
    color: #fff;
    font-size: 13.5px;
    font-weight: 500;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s;
}
.btn-primary-action:hover { background: #1e40af; color: #fff; }

.btn-secondary-action {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    background: #fff;
    color: #374151;
    font-size: 13.5px;
    font-weight: 500;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s, border-color .15s;
}
.btn-secondary-action:hover { background: #f9fafb; color: #111; border-color: #9ca3af; }

/* ──────────────────────────────────────────────
   Empty State
────────────────────────────────────────────── */
.empty-state-card {
    background: #fff;
    border: 1px dashed #d1d5db;
    border-radius: 16px;
    padding: 64px 40px;
    max-width: 480px;
    margin: 0 auto;
}
.empty-icon-ring {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    display: flex; align-items: center; justify-content: center;
    color: #3b82f6;
}
.empty-title { font-size: 16px; font-weight: 600; color: #111827; }
.empty-sub { font-size: 14px; color: #6b7280; }

/* ──────────────────────────────────────────────
   Layout
────────────────────────────────────────────── */
.settings-layout {
    display: grid;
    grid-template-columns: 210px 1fr;
    gap: 24px;
    align-items: start;
}

/* ──────────────────────────────────────────────
   Sidebar
────────────────────────────────────────────── */
.settings-sidebar {
    position: sticky;
    top: 80px;
}
.sidebar-nav {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    padding: 6px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 500;
    color: #4b5563;
    text-decoration: none;
    transition: background .12s, color .12s;
}
.sidebar-link:hover { background: #f3f4f6; color: #111827; }
.sidebar-link.is-active {
    background: #eff6ff;
    color: #1d4ed8;
}
.sidebar-link-icon {
    display: flex; align-items: center;
    color: inherit;
    flex-shrink: 0;
}

/* ──────────────────────────────────────────────
   Content Panel
────────────────────────────────────────────── */
.settings-content {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px;
    min-height: 400px;
}
.panel-header { border-bottom: 1px solid #f3f4f6; padding-bottom: 16px; }
.panel-heading { font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 4px; }
.panel-desc { font-size: 13px; color: #6b7280; margin: 0; }

/* ──────────────────────────────────────────────
   Fields Grid
────────────────────────────────────────────── */
.fields-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 16px;
}
.field-item {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 16px;
}
.field-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: #9ca3af;
    margin-bottom: 6px;
}
.field-value {
    font-size: 14.5px;
    font-weight: 500;
    color: #111827;
    word-break: break-word;
}
</style>

<script>
document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const section = this.dataset.section;
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('is-active'));
        this.classList.add('is-active');
        document.querySelectorAll('.section-panel').forEach(p => p.style.display = 'none');
        document.getElementById('panel-' + section).style.display = 'block';
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        window.history.pushState({}, '', url);
    });
});
</script>
@endsection
