{{-- resources/views/admin/seooptimization/partials/sitemap-exists.blade.php --}}

{{-- File Detail Card --}}
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
        <p class="sitemap-file-meta">
            {{ number_format(filesize(public_path('sitemap.xml')) / 1024, 1) }} KB
            &nbsp;·&nbsp;
            Last updated {{ \Carbon\Carbon::createFromTimestamp(filemtime(public_path('sitemap.xml')))->diffForHumans() }}
        </p>
        <p class="sitemap-file-path">
            <a href="/sitemap.xml" target="_blank" class="sitemap-url-link">
                {{ url('/sitemap.xml') }}
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" style="margin-left:3px">
                    <path d="M2 9L9 2M9 2H4.5M9 2V6.5" stroke="currentColor" stroke-width="1.3"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </p>
    </div>

    <div class="sitemap-file-actions">
        <a href="{{ route('seooptimization.download-sitemap') }}"
           class="btn-download" title="Download sitemap.xml">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7 1.5v8M3.5 6.5L7 10l3.5-3.5" stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1.5 11.5h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            Download
        </a>
        <button type="button" class="btn-regenerate" onclick="generateSitemap()" title="Regenerate sitemap">
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

{{-- Info Box --}}
<div class="sitemap-info-box">
    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" style="flex-shrink:0;margin-top:1px">
        <circle cx="7.5" cy="7.5" r="6.5" stroke="#3b82f6" stroke-width="1.3"/>
        <path d="M7.5 6.5v4" stroke="#3b82f6" stroke-width="1.4" stroke-linecap="round"/>
        <circle cx="7.5" cy="4.5" r=".8" fill="#3b82f6"/>
    </svg>
    <p>
        Submit this sitemap URL to <strong>Google Search Console</strong> and
        <strong>Bing Webmaster Tools</strong> to improve your site's indexing speed and visibility.
    </p>
</div>
