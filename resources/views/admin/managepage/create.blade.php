@extends('admin.master')

@section('content')
<div class="container-fluid px-4 py-5">

    {{-- Page Header --}}
    <div class="page-header d-flex align-items-center justify-content-between mb-5">
        <div>
            <p class="page-eyebrow mb-1">Configuration</p>
            <h1 class="page-title mb-0">Create Page Settings</h1>
        </div>
        <a href="{{ route('managepage.index') }}" class="btn-back-action">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 1L3 7L9 13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Overview
        </a>
    </div>

    {{-- Progress Indicator --}}
    <div class="progress-bar-wrap mb-5">
        <div class="progress-steps" id="progressSteps">
            @php
                $stepLabels = ['Home One', 'Home Two', 'Menu Title', 'All Pages', 'Contact Us', 'Footer'];
                $stepKeys   = ['home_one', 'home_two', 'menu_title', 'all_pages', 'contact_us', 'footer_section'];
            @endphp
            @foreach($stepLabels as $i => $label)
                <div class="progress-step {{ $i === 0 ? 'is-active' : '' }}" data-step="{{ $i }}" data-section="{{ $stepKeys[$i] }}">
                    <span class="step-dot">{{ $i + 1 }}</span>
                    <span class="step-label">{{ $label }}</span>
                </div>
                @if($i < count($stepLabels) - 1)
                    <div class="step-line"></div>
                @endif
            @endforeach
        </div>
    </div>

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
                       class="sidebar-link {{ $key === 'home_one' ? 'is-active' : '' }}">
                        <span class="sidebar-link-icon">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">{!! $icons[$info['icon']] !!}</svg>
                        </span>
                        <span>{{ $info['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="sidebar-notice mt-3">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><circle cx="6.5" cy="6.5" r="6" stroke="#3b82f6" stroke-width="1"/><path d="M6.5 5.5v4M6.5 3.5v.5" stroke="#3b82f6" stroke-width="1.2" stroke-linecap="round"/></svg>
                All fields are saved together on submit.
            </div>
        </aside>

        {{-- Single Form wrapping all panels --}}
        <main class="settings-content">
            <form action="{{ route('managepage.store') }}" method="POST" id="createForm">
                @csrf

                {{-- ── Home One ── --}}
                <div class="section-panel" id="panel-home_one">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">Home One</h2>
                        <p class="panel-desc">Labels and titles used on the first home page layout.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $homeOneFields = [
                                'top_category'        => ['label' => 'Top Category',        'default' => 'Top Categories'],
                                'most_popular_title'  => ['label' => 'Most Popular Title',  'default' => 'Most Popular'],
                                'stay_connected_title'=> ['label' => 'Stay Connected Title','default' => 'Stay Connected'],
                                'follower_text_one'   => ['label' => 'Follower Text One',   'default' => 'Facebook Follower'],
                                'follower_text_two'   => ['label' => 'Follower Text Two',   'default' => 'Instagram Follower'],
                                'follower_text_three' => ['label' => 'Follower Text Three', 'default' => 'Twitter Follower'],
                                'follower_text_four'  => ['label' => 'Follower Text Four',  'default' => 'Youtube Follower'],
                                'dont_miss_title'     => ['label' => "Don't Miss Title",    'default' => "Don't Miss"],
                            ];
                        @endphp
                        @foreach($homeOneFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Home Two ── --}}
                <div class="section-panel" id="panel-home_two" style="display:none">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">Home Two</h2>
                        <p class="panel-desc">Labels and titles used on the second home page layout.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $homeTwoFields = [
                                'breaking_news_title' => ['label' => 'Breaking News Title', 'default' => 'Breaking News'],
                                'trending_news_title' => ['label' => 'Trending News Title', 'default' => 'Trending News'],
                                'weekly_reviews'      => ['label' => 'Weekly Reviews',      'default' => 'Weekly Review'],
                                'editors_picks'       => ['label' => "Editor's Picks",      'default' => "Editor's Picks"],
                                'button_text'         => ['label' => 'Button Text',         'default' => 'Show All'],
                                'feature_post'        => ['label' => 'Feature Post',        'default' => 'Featured Posts'],
                                'feature_video_title' => ['label' => 'Feature Video Title', 'default' => 'Featured Video'],
                            ];
                        @endphp
                        @foreach($homeTwoFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Menu Title ── --}}
                <div class="section-panel" id="panel-menu_title" style="display:none">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">Menu Title</h2>
                        <p class="panel-desc">Navigation menu display titles.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $menuFields = [
                                'menu_title_one' => ['label' => 'Menu Title One', 'default' => 'Home Menu One'],
                                'menu_title_two' => ['label' => 'Menu Title Two', 'default' => 'Home Menu Two'],
                            ];
                        @endphp
                        @foreach($menuFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── All Pages ── --}}
                <div class="section-panel" id="panel-all_pages" style="display:none">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">All Pages</h2>
                        <p class="panel-desc">Common titles and labels shared across all pages.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $allPageFields = [
                                'home_title'         => ['label' => 'Home Title',         'default' => 'Home'],
                                'popular_post_title' => ['label' => 'Popular Post Title', 'default' => 'Popular Post'],
                                'gallery_title'      => ['label' => 'Gallery Title',      'default' => 'Gallery'],
                                'recent_post_title'  => ['label' => 'Recent Post Title',  'default' => 'Recent Post'],
                                'tag_title'          => ['label' => 'Tag Title',           'default' => 'Tags'],
                            ];
                        @endphp
                        @foreach($allPageFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Contact Us ── --}}
                <div class="section-panel" id="panel-contact_us" style="display:none">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">Contact Us</h2>
                        <p class="panel-desc">Text and labels for the contact page.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $contactFields = [
                                'get_in_touch'     => ['label' => 'Get In Touch',     'default' => 'Get in touch'],
                                'address'          => ['label' => 'Address',          'default' => 'Address'],
                                'phone_text'       => ['label' => 'Phone Text',       'default' => 'Phone'],
                                'email_text'       => ['label' => 'Email Text',       'default' => 'Email'],
                                'form_button_text' => ['label' => 'Form Button Text', 'default' => 'Send Message'],
                            ];
                        @endphp
                        @foreach($contactFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Footer Section ── --}}
                <div class="section-panel" id="panel-footer_section" style="display:none">
                    <div class="panel-header mb-4">
                        <h2 class="panel-heading">Footer Section</h2>
                        <p class="panel-desc">Labels and titles used in the site footer.</p>
                    </div>
                    <div class="form-grid">
                        @php
                            $footerFields = [
                                'post_title'      => ['label' => 'Post Title',      'default' => 'Most Viewed Post'],
                                'news'            => ['label' => 'News',            'default' => 'News'],
                                'about'           => ['label' => 'About',           'default' => 'About'],
                                'news_tags_title' => ['label' => 'News Tags Title', 'default' => "News Tag's"],
                                'subscribe_text'  => ['label' => 'Subscribe Text',  'default' => 'Subscribe Now'],
                            ];
                        @endphp
                        @foreach($footerFields as $field => $meta)
                            <div class="form-field {{ $errors->has($field) ? 'has-error' : '' }}">
                                <label class="field-label" for="{{ $field }}">{{ $meta['label'] }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="field-input"
                                    value="{{ old($field, $meta['default']) }}"
                                    placeholder="{{ $meta['default'] }}">
                                @error($field)
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Navigation + Submit --}}
                <div class="form-footer mt-5">
                    <div class="footer-nav-btns">
                        <button type="button" class="btn-nav" id="btnPrev" style="display:none" onclick="navigate(-1)">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M8 2L4 6.5L8 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Previous
                        </button>
                        <button type="button" class="btn-nav-next" id="btnNext" onclick="navigate(1)">
                            Next
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M5 2L9 6.5L5 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    <button type="submit" class="btn-submit" id="btnSubmit" style="display:none">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7L5.5 10.5L12 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Save All Settings
                    </button>
                </div>

            </form>
        </main>
    </div>
</div>

<style>
/* ── Page Header ── */
.page-eyebrow { font-size:12px; font-weight:500; letter-spacing:.06em; text-transform:uppercase; color:#6b7280; }
.page-title { font-size:24px; font-weight:700; color:#111827; letter-spacing:-.02em; }
.btn-back-action {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; background:#fff; color:#374151;
    font-size:13.5px; font-weight:500; border:1px solid #d1d5db;
    border-radius:8px; text-decoration:none; transition:background .15s, border-color .15s;
}
.btn-back-action:hover { background:#f9fafb; border-color:#9ca3af; color:#111; }

/* ── Progress ── */
.progress-bar-wrap { overflow-x:auto; }
.progress-steps {
    display:flex; align-items:center; gap:0;
    min-width:560px;
}
.progress-step {
    display:flex; flex-direction:column; align-items:center; gap:6px;
    flex-shrink:0; cursor:pointer;
}
.step-dot {
    width:30px; height:30px; border-radius:50%;
    background:#f3f4f6; border:1.5px solid #e5e7eb;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:600; color:#9ca3af;
    transition:all .2s;
}
.step-label { font-size:11px; font-weight:500; color:#9ca3af; white-space:nowrap; transition:color .2s; }
.progress-step.is-active .step-dot { background:#1d4ed8; border-color:#1d4ed8; color:#fff; }
.progress-step.is-active .step-label { color:#1d4ed8; }
.progress-step.is-done .step-dot { background:#16a34a; border-color:#16a34a; color:#fff; }
.progress-step.is-done .step-label { color:#16a34a; }
.step-line { flex:1; height:1.5px; background:#e5e7eb; min-width:20px; }

/* ── Layout ── */
.settings-layout { display:grid; grid-template-columns:210px 1fr; gap:24px; align-items:start; }

/* ── Sidebar ── */
.settings-sidebar { position:sticky; top:80px; }
.sidebar-nav {
    background:#fff; border:1px solid #e5e7eb; border-radius:12px;
    overflow:hidden; padding:6px; display:flex; flex-direction:column; gap:2px;
}
.sidebar-link {
    display:flex; align-items:center; gap:10px; padding:9px 12px;
    border-radius:8px; font-size:13.5px; font-weight:500;
    color:#4b5563; text-decoration:none; transition:background .12s, color .12s;
}
.sidebar-link:hover { background:#f3f4f6; color:#111827; }
.sidebar-link.is-active { background:#eff6ff; color:#1d4ed8; }
.sidebar-link-icon { display:flex; align-items:center; color:inherit; flex-shrink:0; }
.sidebar-notice {
    display:flex; align-items:flex-start; gap:6px;
    background:#eff6ff; border:1px solid #bfdbfe;
    border-radius:8px; padding:10px 12px;
    font-size:11.5px; color:#1e40af; line-height:1.4;
}

/* ── Content Panel ── */
.settings-content { background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:32px; min-height:400px; }
.panel-header { border-bottom:1px solid #f3f4f6; padding-bottom:16px; }
.panel-heading { font-size:18px; font-weight:700; color:#111827; margin:0 0 4px; }
.panel-desc { font-size:13px; color:#6b7280; margin:0; }

/* ── Form Grid ── */
.form-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:20px; }
.form-field { display:flex; flex-direction:column; gap:6px; }
.field-label { font-size:12px; font-weight:600; letter-spacing:.04em; text-transform:uppercase; color:#6b7280; }
.field-input {
    width:100%; padding:10px 13px;
    background:#fff; border:1px solid #d1d5db; border-radius:8px;
    font-size:14px; color:#111827; outline:none;
    transition:border-color .15s, box-shadow .15s;
}
.field-input::placeholder { color:#9ca3af; }
.field-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12); }
.has-error .field-input { border-color:#ef4444; }
.field-error { font-size:12px; color:#ef4444; }

/* ── Footer ── */
.form-footer {
    display:flex; align-items:center; justify-content:space-between;
    border-top:1px solid #f3f4f6; padding-top:20px;
}
.footer-nav-btns { display:flex; gap:10px; }
.btn-nav {
    display:inline-flex; align-items:center; gap:6px;
    padding:9px 16px; background:#fff; color:#374151;
    font-size:13.5px; font-weight:500; border:1px solid #d1d5db;
    border-radius:8px; cursor:pointer; transition:background .15s;
}
.btn-nav:hover { background:#f3f4f6; }
.btn-nav-next {
    display:inline-flex; align-items:center; gap:6px;
    padding:9px 16px; background:#f0f9ff; color:#1d4ed8;
    font-size:13.5px; font-weight:500; border:1px solid #bfdbfe;
    border-radius:8px; cursor:pointer; transition:background .15s;
}
.btn-nav-next:hover { background:#dbeafe; }
.btn-submit {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 24px; background:#1d4ed8; color:#fff;
    font-size:13.5px; font-weight:500; border:none;
    border-radius:8px; cursor:pointer; transition:background .15s;
}
.btn-submit:hover { background:#1e40af; }
.btn-submit:active { transform:scale(.98); }
</style>

<script>
const sectionKeys = ['home_one','home_two','menu_title','all_pages','contact_us','footer_section'];
let currentStep = 0;

function navigate(dir) {
    currentStep = Math.max(0, Math.min(sectionKeys.length - 1, currentStep + dir));
    applyStep();
}

function applyStep() {
    // Panels
    document.querySelectorAll('.section-panel').forEach(p => p.style.display = 'none');
    document.getElementById('panel-' + sectionKeys[currentStep]).style.display = 'block';

    // Sidebar
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('is-active'));
    document.querySelector(`.sidebar-link[data-section="${sectionKeys[currentStep]}"]`).classList.add('is-active');

    // Progress dots
    document.querySelectorAll('.progress-step').forEach((dot, i) => {
        dot.classList.remove('is-active','is-done');
        if (i < currentStep)  dot.classList.add('is-done');
        if (i === currentStep) dot.classList.add('is-active');
    });

    // Buttons
    document.getElementById('btnPrev').style.display = currentStep > 0 ? 'inline-flex' : 'none';
    const isLast = currentStep === sectionKeys.length - 1;
    document.getElementById('btnNext').style.display = isLast ? 'none' : 'inline-flex';
    document.getElementById('btnSubmit').style.display = isLast ? 'inline-flex' : 'none';
}

// Sidebar click
document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        currentStep = sectionKeys.indexOf(this.dataset.section);
        applyStep();
    });
});

// Progress dot click
document.querySelectorAll('.progress-step').forEach(dot => {
    dot.addEventListener('click', function() {
        currentStep = parseInt(this.dataset.step);
        applyStep();
    });
});

applyStep();
</script>
@endsection
