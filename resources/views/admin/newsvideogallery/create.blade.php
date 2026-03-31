@extends('admin.master')

@section('content')

<style>
.vg-wrapper      { padding: 24px; background: #f5f6fa; min-height: 100vh; }

.vg-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px;
    padding: 14px 20px; margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.vg-topbar h5 { margin: 0; font-size: 15px; font-weight: 600; color: #222; }
.vg-btn-back {
    background: #6b7280; color: #fff; border: none; border-radius: 6px;
    padding: 7px 16px; font-size: 13px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s;
}
.vg-btn-back:hover { background: #4b5563; color: #fff; }

.vg-card {
    background: #fff; border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    padding: 28px 28px 32px;
}

.vg-label {
    display: block; font-size: 13px; font-weight: 600;
    color: #374151; margin-bottom: 6px;
}
.vg-label .req { color: #dc2626; }
.vg-label .opt { font-weight: 400; color: #9ca3af; font-size: 12px; }

.vg-input {
    width: 100%; border: 1.5px solid #e5e7eb; border-radius: 7px;
    padding: 9px 13px; font-size: 13.5px; color: #1f2937;
    background: #fff; outline: none; transition: border-color .18s, box-shadow .18s;
    box-sizing: border-box;
}
.vg-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
.vg-input.is-invalid { border-color: #dc2626; }
.vg-error { font-size: 12px; color: #dc2626; margin-top: 4px; }

/* ── Radio pills ──────────────────────────────────────────────────── */
.vg-radio-group { display: flex; gap: 10px; flex-wrap: wrap; }
.vg-radio-pill { display: none; }
.vg-radio-pill + label {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 18px; border-radius: 7px; border: 1.5px solid #e5e7eb;
    font-size: 13px; font-weight: 500; color: #374151;
    cursor: pointer; transition: all .18s; background: #fafafa; user-select: none;
}
.vg-radio-pill + label:hover { border-color: #93c5fd; background: #eff6ff; }
.vg-radio-pill:checked + label { border-color: #2563eb; background: #eff6ff; color: #1d4ed8; }

/* ── Toggle switch ────────────────────────────────────────────────── */
.vg-toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
.vg-toggle input { opacity: 0; width: 0; height: 0; }
.vg-slider {
    position: absolute; inset: 0; background: #d1d5db;
    border-radius: 24px; cursor: pointer; transition: background .22s;
}
.vg-slider::before {
    content: ''; position: absolute; width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: transform .22s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.vg-toggle input:checked + .vg-slider { background: #2563eb; }
.vg-toggle input:checked + .vg-slider::before { transform: translateX(20px); }

/* ── Preview box ──────────────────────────────────────────────────── */
.vg-preview-box {
    border-radius: 9px; overflow: hidden; border: 1.5px solid #e5e7eb;
    margin-top: 10px; background: #000;
}
.vg-preview-box iframe, .vg-preview-box video {
    width: 100%; height: 220px; display: block; border: none;
}
.vg-preview-box img { width: 100%; max-height: 160px; object-fit: cover; display: block; }

/* ── File drop area ───────────────────────────────────────────────── */
.vg-file-area {
    border: 2px dashed #d1d5db; border-radius: 8px;
    padding: 24px 16px; text-align: center;
    cursor: pointer; transition: border-color .18s, background .18s;
    position: relative; background: #fafafa;
}
.vg-file-area:hover { border-color: #2563eb; background: #eff6ff; }
.vg-file-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
    width: 100%; height: 100%; z-index: 2;
}
.vg-file-area svg { width: 28px; height: 28px; color: #9ca3af; display: block; margin: 0 auto 8px; }
.vg-file-area p { margin: 0; font-size: 13px; color: #6b7280; }
.vg-file-area small { font-size: 12px; color: #9ca3af; }

.vg-divider { border: none; border-top: 1px solid #f0f1f3; margin: 24px 0; }

.vg-btn-save {
    background: #2563eb; color: #fff; border: none; border-radius: 7px;
    padding: 9px 28px; font-size: 14px; font-weight: 500; cursor: pointer;
    transition: background .18s; display: inline-flex; align-items: center; gap: 7px;
}
.vg-btn-save:hover { background: #1d4ed8; }
.vg-btn-cancel {
    background: #f3f4f6; color: #374151; border: 1.5px solid #e5e7eb;
    border-radius: 7px; padding: 9px 22px; font-size: 14px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
    transition: background .18s;
}
.vg-btn-cancel:hover { background: #e5e7eb; color: #111; }
</style>

<div class="vg-wrapper">

    <div class="vg-topbar">
        <h5>Add Video Gallery</h5>
        <a href="{{ route('newsvideogallery.index') }}" class="vg-btn-back">← Back to List</a>
    </div>

    <div class="vg-card">
        <form action="{{ route('newsvideogallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label class="vg-label">Title <span class="req">*</span></label>
                <input type="text" name="title"
                    class="vg-input @error('title') is-invalid @enderror"
                    placeholder="Enter video title"
                    value="{{ old('title') }}">
                @error('title') <div class="vg-error">{{ $message }}</div> @enderror
            </div>

            {{-- Sort Order --}}
            <div class="mb-3" style="max-width:160px;">
                <label class="vg-label">Sort Order</label>
                <input type="number" name="sort_order" class="vg-input" min="0" value="{{ old('sort_order', 0) }}">
            </div>

            {{-- Publish Status --}}
            <div class="mb-4">
                <label class="vg-label">Publish Status</label>
                <div class="d-flex align-items-center gap-2">
                    <label class="vg-toggle">
                        <input type="checkbox" name="status" value="1" id="statusToggle"
                            {{ old('status', 1) ? 'checked' : '' }}>
                        <span class="vg-slider"></span>
                    </label>
                    <span id="statusLabel" style="font-size:13px; color:#374151;">
                        {{ old('status', 1) ? 'Published' : 'Unpublished' }}
                    </span>
                </div>
            </div>

            <hr class="vg-divider">

            {{-- Video Type --}}
            <div class="mb-4">
                <label class="vg-label">Video Type <span class="req">*</span></label>
                <div class="vg-radio-group">
                    <input type="radio" class="vg-radio-pill" name="video_type" id="typeYoutube"
                        value="youtube" {{ old('video_type', 'youtube') === 'youtube' ? 'checked' : '' }}>
                    <label for="typeYoutube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#dc2626">
                            <path d="M23.5 6.2a3.02 3.02 0 00-2.12-2.13C19.54 3.6 12 3.6 12 3.6s-7.54 0-9.38.47A3.02 3.02 0 00.5 6.2 31.5 31.5 0 000 12a31.5 31.5 0 00.5 5.8 3.02 3.02 0 002.12 2.13C4.46 20.4 12 20.4 12 20.4s7.54 0 9.38-.47a3.02 3.02 0 002.12-2.13A31.5 31.5 0 0024 12a31.5 31.5 0 00-.5-5.8zM9.75 15.5v-7l6.25 3.5-6.25 3.5z"/>
                        </svg>
                        YouTube URL
                    </label>

                    <input type="radio" class="vg-radio-pill" name="video_type" id="typeUpload"
                        value="upload" {{ old('video_type') === 'upload' ? 'checked' : '' }}>
                    <label for="typeUpload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                            <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                        </svg>
                        Upload Video
                    </label>
                </div>
            </div>

            {{-- ════════════════════════════════
                 SECTION A — YouTube
            ════════════════════════════════ --}}
            <div id="section-youtube">

                <div class="mb-3">
                    <label class="vg-label">YouTube URL <span class="req">*</span></label>
                    <input type="url" name="youtube_url" id="youtubeUrlInput"
                        class="vg-input @error('youtube_url') is-invalid @enderror"
                        placeholder="https://www.youtube.com/watch?v=..."
                        value="{{ old('youtube_url') }}">
                    @error('youtube_url') <div class="vg-error">{{ $message }}</div> @enderror

                    <div id="youtubePreview" style="display:none;" class="vg-preview-box">
                        <iframe id="youtubeIframe" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                        </iframe>
                    </div>
                </div>

                {{-- Thumbnail (YouTube) --}}
                <div class="mb-3">
                    <label class="vg-label">Thumbnail <span class="opt">(optional)</span></label>
                    <div class="vg-file-area">
                        <input type="file" name="thumbnail" id="ytThumbInput"
                            accept="image/jpeg,image/png,image/webp">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p id="ytThumbName">Click or drag thumbnail image</p>
                        <small>jpg, jpeg, png, webp — max 2 MB</small>
                    </div>
                    <div id="ytThumbBox" style="display:none;" class="vg-preview-box" style="background:#f9fafb;">
                        <img id="ytThumbImg" src="#" alt="Thumbnail">
                    </div>
                </div>

            </div>{{-- end section-youtube --}}


            {{-- ════════════════════════════════
                 SECTION B — Upload Video
                 (hidden by default)
            ════════════════════════════════ --}}
            <div id="section-upload" style="display:none;">

                <div class="row g-3 mb-2">
                    {{-- Video file --}}
                    <div class="col-md-6">
                        <label class="vg-label">Upload Video <span class="req">*</span></label>
                        <div class="vg-file-area">
                            <input type="file" name="video_file" id="videoFileInput"
                                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                            </svg>
                            <p id="videoFileName">Click or drag video here</p>
                            <small>mp4, mov, avi, mkv, webm — max 200 MB</small>
                        </div>
                        @error('video_file') <div class="vg-error">{{ $message }}</div> @enderror

                        <div id="videoPreviewBox" style="display:none;" class="vg-preview-box">
                            <video id="videoPreview" controls></video>
                        </div>
                    </div>

                    {{-- Thumbnail (upload) --}}
                    <div class="col-md-6">
                        <label class="vg-label">Thumbnail <span class="opt">(optional)</span></label>
                        <div class="vg-file-area">
                            <input type="file" name="thumbnail" id="uploadThumbInput"
                                accept="image/jpeg,image/png,image/webp">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p id="uploadThumbName">Click or drag image here</p>
                            <small>jpg, jpeg, png, webp — max 2 MB</small>
                        </div>

                        <div id="uploadThumbBox" style="display:none;" class="vg-preview-box" style="background:#f9fafb;">
                            <img id="uploadThumbImg" src="#" alt="Thumbnail">
                        </div>
                    </div>
                </div>

                <small style="font-size:12px; color:#6b7280;">
                    📁 Upload path: <code>public/uploads/videogallery/</code>
                </small>

            </div>{{-- end section-upload --}}

            <hr class="vg-divider">

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="vg-btn-save">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save
                </button>
                <a href="{{ route('newsvideogallery.index') }}" class="vg-btn-cancel">Cancel</a>
            </div>

        </form>
    </div>
</div>


{{-- ─────────────────────────────────────────────────────────────────
     Pure Vanilla JS — zero jQuery dependency
     Fixes:
       1. "$ is not defined"  → removed all $ usage
       2. canvas getContext   → unrelated to this file; caused by
          something in custom.js running before the canvas element
          exists. We guard our own code with DOMContentLoaded.
───────────────────────────────────────────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Helper: fade in an element ─────────────────────────────────────
    function fadeIn(el) {
        el.style.display = 'block';
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.2s ease';
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                el.style.opacity = '1';
            });
        });
    }

    // ── Status toggle label ────────────────────────────────────────────
    var statusToggle = document.getElementById('statusToggle');
    var statusLabel  = document.getElementById('statusLabel');

    if (statusToggle && statusLabel) {
        statusToggle.addEventListener('change', function () {
            statusLabel.textContent = this.checked ? 'Published' : 'Unpublished';
        });
    }

    // ══════════════════════════════════════════════════════════════════
    //  Show / hide sections + disable inactive file inputs
    // ══════════════════════════════════════════════════════════════════
    var radioYoutube       = document.getElementById('typeYoutube');
    var radioUpload        = document.getElementById('typeUpload');
    var sectionYoutube     = document.getElementById('section-youtube');
    var sectionUpload      = document.getElementById('section-upload');
    var videoFileInput     = document.getElementById('videoFileInput');
    var uploadThumbInput   = document.getElementById('uploadThumbInput');
    var ytThumbInput       = document.getElementById('ytThumbInput');

    function toggleType() {
        var isYoutube = radioYoutube && radioYoutube.checked;

        if (isYoutube) {
            if (sectionYoutube) sectionYoutube.style.display = 'block';
            if (sectionUpload)  sectionUpload.style.display  = 'none';

            // Disable upload section inputs so they are NOT submitted
            if (videoFileInput)   videoFileInput.disabled   = true;
            if (uploadThumbInput) uploadThumbInput.disabled = true;
            // Enable YouTube section inputs
            if (ytThumbInput)     ytThumbInput.disabled     = false;

        } else {
            if (sectionYoutube) sectionYoutube.style.display = 'none';
            if (sectionUpload)  sectionUpload.style.display  = 'block';

            // Disable YouTube section inputs
            if (ytThumbInput)     ytThumbInput.disabled     = true;
            // Enable upload section inputs
            if (videoFileInput)   videoFileInput.disabled   = false;
            if (uploadThumbInput) uploadThumbInput.disabled = false;
        }
    }

    // Bind change events
    if (radioYoutube) radioYoutube.addEventListener('change', toggleType);
    if (radioUpload)  radioUpload.addEventListener('change', toggleType);

    // Run immediately on page load
    toggleType();

    // ── YouTube URL → live iframe preview ─────────────────────────────
    var youtubeUrlInput = document.getElementById('youtubeUrlInput');
    var youtubePreview  = document.getElementById('youtubePreview');
    var youtubeIframe   = document.getElementById('youtubeIframe');

    if (youtubeUrlInput) {
        youtubeUrlInput.addEventListener('input', function () {
            var val = this.value;
            var match = val.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/);
            if (match) {
                youtubeIframe.src = 'https://www.youtube.com/embed/' + match[1];
                fadeIn(youtubePreview);
            } else {
                youtubePreview.style.display = 'none';
                youtubeIframe.src = '';
            }
        });
    }

    // ── Video file → preview ───────────────────────────────────────────
    var videoPreview    = document.getElementById('videoPreview');
    var videoPreviewBox = document.getElementById('videoPreviewBox');
    var videoFileName   = document.getElementById('videoFileName');

    if (videoFileInput) {
        videoFileInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            if (videoFileName)   videoFileName.textContent = file.name;
            if (videoPreview)    videoPreview.src = URL.createObjectURL(file);
            if (videoPreviewBox) fadeIn(videoPreviewBox);
        });
    }

    // ── Thumbnail — upload section ─────────────────────────────────────
    var uploadThumbBox  = document.getElementById('uploadThumbBox');
    var uploadThumbImg  = document.getElementById('uploadThumbImg');
    var uploadThumbName = document.getElementById('uploadThumbName');

    if (uploadThumbInput) {
        uploadThumbInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            if (uploadThumbName) uploadThumbName.textContent = file.name;
            var reader = new FileReader();
            reader.onload = function (e) {
                if (uploadThumbImg) uploadThumbImg.src = e.target.result;
                if (uploadThumbBox) fadeIn(uploadThumbBox);
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Thumbnail — YouTube section ────────────────────────────────────
    var ytThumbBox  = document.getElementById('ytThumbBox');
    var ytThumbImg  = document.getElementById('ytThumbImg');
    var ytThumbName = document.getElementById('ytThumbName');

    if (ytThumbInput) {
        ytThumbInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            if (ytThumbName) ytThumbName.textContent = file.name;
            var reader = new FileReader();
            reader.onload = function (e) {
                if (ytThumbImg) ytThumbImg.src = e.target.result;
                if (ytThumbBox) fadeIn(ytThumbBox);
            };
            reader.readAsDataURL(file);
        });
    }

});
</script>
@endsection
