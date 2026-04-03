@extends('admin.master')

@section('content')
<style>
.ci-edit-wrap { padding:1.75rem; max-width:900px; }
.ci-edit-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
.ci-edit-heading { font-size:1.1rem; font-weight:600; color:#111; letter-spacing:-0.02em; }
.ci-back-btn {
    display:inline-flex; align-items:center; gap:6px;
    font-size:13px; color:#6b7280; text-decoration:none;
    border:1px solid #e5e7eb; border-radius:7px; padding:6px 14px;
    transition:border .15s, color .15s; background:#fff;
}
.ci-back-btn:hover { border-color:#2563eb; color:#2563eb; }
.ci-edit-card {
    background:#fff; border:1px solid #f0f0f0; border-radius:14px;
    padding:1.75rem 2rem; box-shadow:0 2px 12px rgba(0,0,0,.04);
}
.ci-edit-section-label {
    font-size:11.5px; font-weight:700; color:#9ca3af; letter-spacing:.08em;
    text-transform:uppercase; margin-bottom:1rem; padding-bottom:.5rem;
    border-bottom:1px dashed #f0f0f0;
}
.ci-edit-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.1rem; }
.ci-fg { display:flex; flex-direction:column; gap:5px; }
.ci-fg label { font-size:12px; font-weight:600; color:#6b7280; letter-spacing:.04em; text-transform:uppercase; }
.ci-fc {
    border:1.5px solid #e5e7eb; border-radius:8px; padding:9px 13px;
    font-size:13.5px; color:#111; background:#fff; outline:none;
    transition:border .15s, box-shadow .15s; width:100%; box-sizing:border-box;
}
.ci-fc:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.ci-fc::placeholder { color:#d1d5db; }
textarea.ci-fc { resize:vertical; min-height:86px; }
.ci-edit-actions {
    display:flex; justify-content:center; gap:12px; margin-top:1.75rem;
    padding-top:1.25rem; border-top:1px solid #f7f7f7;
}
.ci-act-cancel {
    padding:10px 32px; border-radius:8px; font-size:13.5px; font-weight:500;
    border:1.5px solid #fca5a5; color:#ef4444; background:#fff;
    cursor:pointer; transition:background .15s; text-decoration:none;
    display:inline-flex; align-items:center;
}
.ci-act-cancel:hover { background:#fef2f2; }
.ci-act-save {
    padding:10px 36px; border-radius:8px; font-size:13.5px; font-weight:500;
    border:none; background:#2563eb; color:#fff; cursor:pointer; transition:background .15s;
}
.ci-act-save:hover { background:#1d4ed8; }
.ci-error-box {
    background:#fef2f2; border:1px solid #fecaca; border-radius:8px;
    padding:10px 14px; margin-bottom:1rem;
}
.ci-error-box ul { margin:0; padding-left:1.1rem; }
.ci-error-box li { font-size:13px; color:#b91c1c; }
@media(max-width:600px){ .ci-edit-grid{grid-template-columns:1fr;} .ci-edit-card{padding:1.25rem;} }
</style>

<div class="ci-edit-wrap">
    {{-- Topbar --}}
    <div class="ci-edit-topbar">
        <span class="ci-edit-heading">Edit Company Info</span>
        <a href="{{ route('companyinfo.index') }}" class="ci-back-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back
        </a>
    </div>

    <div class="ci-edit-card">

        @if($errors->any())
        <div class="ci-error-box">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('companyinfo.update', $companyinfo->id) }}">
            @csrf @method('PUT')

            <div class="ci-edit-section-label">Basic Information</div>
            <div class="ci-edit-grid">
                <div class="ci-fg">
                    <label>Name</label>
                    <input type="text" name="name" class="ci-fc"
                           value="{{ old('name', $companyinfo->name) }}" required>
                </div>
                <div class="ci-fg">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="ci-fc"
                           value="{{ old('phone', $companyinfo->phone) }}" placeholder="Enter phone">
                </div>
                <div class="ci-fg">
                    <label>Email</label>
                    <input type="email" name="email" class="ci-fc"
                           value="{{ old('email', $companyinfo->email) }}" placeholder="Enter email">
                </div>
                <div class="ci-fg">
                    <label>Version</label>
                    <input type="text" name="version" class="ci-fc"
                           value="{{ old('version', $companyinfo->version) }}">
                </div>
            </div>

            <div class="ci-edit-section-label" style="margin-top:1.5rem;">Address</div>
            <div class="ci-edit-grid">
                <div class="ci-fg">
                    <label>Address Line 1</label>
                    <input type="text" name="address_line1" class="ci-fc"
                           value="{{ old('address_line1', $companyinfo->address_line1) }}" placeholder="Enter address">
                </div>
                <div class="ci-fg">
                    <label>Address Line 2</label>
                    <input type="text" name="address_line2" class="ci-fc"
                           value="{{ old('address_line2', $companyinfo->address_line2) }}" placeholder="Enter address">
                </div>
            </div>

            <div class="ci-edit-section-label" style="margin-top:1.5rem;">Additional Details</div>
            <div class="ci-edit-grid">
                <div class="ci-fg">
                    <label>Location Map</label>
                    <textarea name="location_map" class="ci-fc" placeholder="map url">{{ old('location_map', $companyinfo->location_map) }}</textarea>
                </div>
                <div class="ci-fg">
                    <label>Message</label>
                    <textarea name="message" class="ci-fc">{{ old('message', $companyinfo->message) }}</textarea>
                </div>
                <div class="ci-fg">
                    <label>Copyright</label>
                    <textarea name="copyright" class="ci-fc">{{ old('copyright', $companyinfo->copyright) }}</textarea>
                </div>
            </div>

            <div class="ci-edit-actions">
                <a href="{{ route('companyinfo.index') }}" class="ci-act-cancel">Cancel</a>
                <button type="submit" class="ci-act-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
