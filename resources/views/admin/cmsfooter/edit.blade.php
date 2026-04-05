@extends('admin.master')

<style>
    .cmsh-form-page-title {
        font-family: 'Nunito', sans-serif;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.3px;
        color: #1a2236;
    }
    .cmsh-list-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        border-radius: 10px;
        padding: 9px 22px;
        font-size: .875rem;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(37,99,235,.35);
        transition: all .22s ease;
    }
    .cmsh-list-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,.45);
        color: #fff;
    }
    .cmsh-form-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 2px 24px rgba(30,41,59,.08);
        overflow: hidden;
    }
    .cmsh-form-card .card-body { padding: 36px 40px; }
    .cmsh-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        background: #f8fafc;
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .22s, background .22s;
    }
    .cmsh-upload-zone:hover, .cmsh-upload-zone.dragover {
        border-color: #2563eb;
        background: #eff6ff;
    }
    .cmsh-upload-icon {
        font-size: 2.2rem;
        color: #93c5fd;
        margin-bottom: 8px;
        display: block;
        transition: transform .22s, color .22s;
    }
    .cmsh-upload-zone:hover .cmsh-upload-icon { transform: translateY(-4px); color: #2563eb; }
    .cmsh-upload-label { font-size: .88rem; font-weight: 700; color: #374151; }
    .cmsh-upload-sub { font-size: .78rem; color: #94a3b8; margin-top: 3px; }
    .cmsh-file-chosen { margin-top: 8px; font-size: .80rem; font-weight: 600; color: #2563eb; display: none; }
    .cmsh-current-img {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 14px;
        position: relative;
    }
    .cmsh-current-img img { width: 100%; max-height: 160px; object-fit: cover; display: block; }
    .cmsh-current-img-label {
        position: absolute;
        top: 8px; left: 8px;
        background: rgba(0,0,0,.55);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 6px;
        letter-spacing: .4px;
    }
    #imagePreview { display:none; margin-top: 12px; border-radius: 10px; overflow: hidden; border: 2px solid #e2e8f0; }
    #imagePreview img { width: 100%; max-height: 160px; object-fit: cover; display: block; }
    .cmsh-label {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }
    .cmsh-select {
        border: 1.5px solid #d1d9e6;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: .9rem;
        font-weight: 600;
        color: #1e293b;
        width: 100%;
        outline: none;
        background: #fff;
        appearance: none;
        transition: border-color .2s, box-shadow .2s;
        cursor: pointer;
    }
    .cmsh-select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
    .cmsh-select-wrap { position: relative; }
    .cmsh-select-wrap::after {
        content: '\F282';
        font-family: 'Bootstrap-icons';
        position: absolute;
        right: 14px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }
    .cmsh-form-divider { height:1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent); margin: 32px 0; }
    .cmsh-cancel-btn {
        border: 2px solid #ef4444;
        border-radius: 10px;
        padding: 10px 36px;
        font-size: .88rem;
        font-weight: 700;
        color: #ef4444;
        background: transparent;
        text-decoration: none;
        transition: all .2s;
        display: inline-block;
    }
    .cmsh-cancel-btn:hover { background: #fef2f2; color: #dc2626; border-color: #dc2626; }
    .cmsh-save-btn {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: none;
        border-radius: 10px;
        padding: 11px 40px;
        font-size: .88rem;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(37,99,235,.35);
        transition: all .22s;
    }
    .cmsh-save-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,.45); }
    .cmsh-field-error { font-size: .78rem; font-weight: 600; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 5px; }
</style>


@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="cmsh-form-page-title">Edit Footer</span>
        <a href="{{ route('cmsfooter.index') }}" class="cmsh-list-btn">
            <i class="bi bi-list-ul"></i> Footer List
        </a>
    </div>

    <div class="cmsh-form-card card">
        <div class="card-body">
            <form action="{{ route('cmsfooter.update', $cmsfooter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row g-5 align-items-start">

                    {{-- Image --}}
                    <div class="col-lg-6">
                        <label class="cmsh-label">Image</label>

                        @if($cmsfooter->image)
                            <div class="cmsh-current-img">
                                <span class="cmsh-current-img-label">Current</span>
                                <img src="{{ asset($cmsfooter->image) }}" alt="{{ $cmsfooter->name }}">
                            </div>
                        @endif

                        <div class="cmsh-upload-zone" id="dropZone"
                             onclick="document.getElementById('imageInput').click()"
                             ondragover="event.preventDefault();this.classList.add('dragover')"
                             ondragleave="this.classList.remove('dragover')"
                             ondrop="handleDrop(event)">
                            <i class="bi bi-cloud-arrow-up cmsh-upload-icon"></i>
                            <div class="cmsh-upload-label">Click to replace or drag & drop</div>
                            <div class="cmsh-upload-sub">PNG, JPG, JPEG, WEBP · Max 5MB</div>
                            <div class="cmsh-file-chosen" id="fileChosenText">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                <span id="fileNameSpan"></span>
                            </div>
                            <input type="file" id="imageInput" name="image" class="d-none"
                                   accept="image/*" onchange="previewImage(this)">
                        </div>

                        <div id="imagePreview">
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                    </div>

                    {{-- Footer Name --}}
                    <div class="col-lg-6">
                        <label class="cmsh-label">Footer Name</label>
                        <div class="cmsh-select-wrap">
                            <select class="cmsh-select" name="name" required>
                                <option value="">Select footer</option>
                                @for($i = 1; $i <= 7; $i++)
                                    <option value="Footer {{ $i }}"
                                        {{ $cmsfooter->name == "Footer $i" ? 'selected' : '' }}>
                                        Footer {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        @error('name')
                            <div class="cmsh-field-error">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="cmsh-form-divider"></div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('cmsfooter.index') }}" class="cmsh-cancel-btn">Cancel</a>
                    <button type="submit" class="cmsh-save-btn">
                        <i class="bi bi-pencil-square me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('fileNameSpan').textContent = file.name;
        document.getElementById('fileChosenText').style.display = 'block';
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropZone').classList.remove('dragover');
    const input = document.getElementById('imageInput');
    input.files = e.dataTransfer.files;
    previewImage(input);
}
</script>

@endsection
