@extends('admin.master')

@section('content')
<style>
.adm-tabs {
    border-bottom: 2px solid #e5e7eb;
    padding: 0; list-style: none; display: flex;
}
.adm-tabs .nav-link {
    display: block; padding: 12px 22px; font-size: 14px; font-weight: 500;
    color: #6b7280; border: none; border-bottom: 2px solid transparent;
    margin-bottom: -2px; background: transparent; text-decoration: none;
    transition: color .2s, border-color .2s;
}
.adm-tabs .nav-link:hover { color: #374151; }
.adm-tabs .nav-link.active { color: #2563eb; border-bottom-color: #2563eb; font-weight: 600; }

.create-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 28px 28px 24px; max-width: 520px;
}
.create-card h5 { font-size: 16px; font-weight: 700; margin-bottom: 22px; }

#adm-toast {
    position: fixed; bottom: 24px; right: 24px; z-index: 9999;
    background: #111827; color: #fff; padding: 10px 20px;
    border-radius: 8px; font-size: 13px; opacity: 0; pointer-events: none;
    transition: opacity .3s;
}
#adm-toast.show { opacity: 1; }
</style>


@section('content')
<div class="container-fluid px-3 px-md-4">

    {{-- ── Tabs ──────────────────────────────────────────────────────── --}}
    <ul class="adm-tabs mb-4">
        <li><a class="nav-link" href="{{ route('admin.admanager.index') }}">Ads Settings</a></li>
        <li><a class="nav-link active" href="{{ route('admin.headercode.index') }}">Header code</a></li>
    </ul>

    {{-- ── Breadcrumb ─────────────────────────────────────────────────── --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0" style="font-size:13px;">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.headercode.index') }}" class="text-decoration-none">Header Code</a>
            </li>
            <li class="breadcrumb-item active">Create Header</li>
        </ol>
    </nav>

    <div class="create-card">
        <h5>Create Header</h5>

        <form id="createHeaderPageForm"
            action="{{ route('admin.headercode.store') }}"
            method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:13px;">Google Analytics</label>
                <input type="text"
                    class="form-control @error('google_analytics') is-invalid @enderror"
                    name="google_analytics"
                    value="{{ old('google_analytics') }}"
                    placeholder="Enter Analytics"
                    autocomplete="off">
                @error('google_analytics')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted mt-1" style="font-size:11px;">
                    Paste your Google Analytics tracking script or Measurement ID (e.g., <code>G-XXXXXXXXXX</code>).
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.headercode.index') }}"
                    class="btn btn-outline-danger w-50">Cancel</a>
                <button type="submit" class="btn btn-primary w-50" id="pageSubmitBtn">
                    <span id="pageBtnTxt">Save</span>
                    <span id="pageSpinner" class="spinner-border spinner-border-sm ms-1 d-none"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="adm-toast"></div>

<script>
function toast(msg, err = false) {
    const t = document.getElementById('adm-toast');
    t.textContent = msg;
    t.style.background = err ? '#dc2626' : '#111827';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 2800);
}

document.getElementById('createHeaderPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn  = document.getElementById('pageSubmitBtn');
    const txt  = document.getElementById('pageBtnTxt');
    const spin = document.getElementById('pageSpinner');
    btn.disabled = true; txt.textContent = 'Saving...'; spin.classList.remove('d-none');

    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: new FormData(this),
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false; txt.textContent = 'Save'; spin.classList.add('d-none');
        if (d.success) {
            toast('Header code saved successfully!');
            setTimeout(() => window.location.href = '{{ route("admin.headercode.index") }}', 800);
        } else {
            const errs = d.errors ? Object.values(d.errors).flat().join(' | ') : (d.message || 'Error');
            toast(errs, true);
        }
    })
    .catch(() => {
        btn.disabled = false; txt.textContent = 'Save'; spin.classList.add('d-none');
        toast('Something went wrong.', true);
    });
});
</script>
@endsection
