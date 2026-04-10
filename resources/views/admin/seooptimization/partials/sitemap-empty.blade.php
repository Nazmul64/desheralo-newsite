{{-- resources/views/admin/seooptimization/partials/sitemap-empty.blade.php --}}

<div class="sitemap-empty">
    <div class="sitemap-empty-icon">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
            <rect x="7" y="4" width="20" height="26" rx="3" fill="#f1f5f9" stroke="#cbd5e1" stroke-width="1.5"/>
            <rect x="13" y="4" width="14" height="8" rx="2" fill="#e2e8f0"/>
            <path d="M11 17h18M11 22h12M11 27h7" stroke="#cbd5e1" stroke-width="1.2" stroke-linecap="round"/>
            <circle cx="31" cy="31" r="8" fill="#fee2e2" stroke="#fca5a5" stroke-width="1.5"/>
            <path d="M28 31h6M31 28v6" stroke="#f87171" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </div>
    <h3 class="sitemap-empty-title">No sitemap generated yet</h3>
    <p class="sitemap-empty-sub">
        Click <strong>Generate Sitemap</strong> above to create your XML sitemap.
        It will be saved to <code>/public/sitemap.xml</code>.
    </p>
    <div class="sitemap-empty-steps">
        <div class="step-item">
            <div class="step-num">1</div>
            <div class="step-text">Click <strong>Generate Sitemap</strong></div>
        </div>
        <div class="step-arrow">→</div>
        <div class="step-item">
            <div class="step-num">2</div>
            <div class="step-text">Download the file</div>
        </div>
        <div class="step-arrow">→</div>
        <div class="step-item">
            <div class="step-num">3</div>
            <div class="step-text">Submit to Search Console</div>
        </div>
    </div>
</div>
