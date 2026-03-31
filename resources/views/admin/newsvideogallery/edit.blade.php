@extends('admin.master')

@section('content')

<style>
.vg-wrapper      { padding: 24px; background: #f5f6fa; min-height: 100vh; }
.vg-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
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
.vg-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.vg-label .req { color: #dc2626; }
.vg-label .opt { font-weight: 400; color: #9ca3af; font-size: 12px; }
.vg-input, .vg-select {
    width: 100%; border: 1.5px solid #e5e7eb; border-radius: 7px;
    padding: 9px 13px; font-size: 13.5px; color: #1f2937;
    background: #fff; outline: none; transition: border-color .18s, box-shadow .18s;
}
.vg-input:focus, .vg-select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
.vg-input.is-invalid { border-color: #dc2626; }
.vg-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
.vg-radio-group { display: flex; gap: 10px; flex-wrap: wrap; }
.vg-radio-pill { display: none; }
.vg-radio-pill + label {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 18px; border-radius: 7px; border: 1.5px solid #e5e7eb;
    font-size: 13px; font-weight: 500; color: #374151; cursor: pointer;
    transition: all .18s; background: #fafafa; user-select: none;
}
.vg-radio-pill + label:hover { border-color: #93c5fd; background: #eff6ff; }
.vg-radio-pill:checked + label { border-color: #2563eb; background: #eff6ff; color: #1d4ed8; }
.vg-toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
.vg-toggle input { opacity: 0; width: 0; height: 0; }
.vg-slider {
    position: absolute; inset: 0; background: #d1d5db;
    border-radius: 24px; cursor: pointer; transition: background .22s;
}
.vg-slider::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: transform .22s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.vg-toggle input:checked + .vg-slider { background: #2563eb; }
.vg-toggle input:checked + .vg-slider::before { transform: translateX(20px); }
.vg-preview-box {
    border-radius: 9px; overflow: hidden; border: 1.5px solid #e5e7eb;
    margin-top: 10px; background: #000;
}
.vg-preview-box iframe, .vg-preview-box video {
    width: 100%; height: 220px; display: block; border: none;
}
.vg-preview-box img { width: 100%; max-height: 160px; object-fit: cover; display: block; }
.vg-preview-new { display: none; }
.vg-file-area {
    border: 2px dashed #d1d5db; border-radius: 8px; padding: 18px 16px;
    text-align: center; cursor: pointer; transition: border-color .18s, background .18s;
    position: relative; background: #fafafa;
}
.vg-file-area:hover { border-color: #2563eb; background: #eff6ff; }
.vg-file-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.vg-file-area svg { width: 26px; height: 26px; color: #9ca3af; display: block; margin: 0 auto 5px; }
.vg-file-area p { margin: 0; font-size: 13px; color: #6b7280; }
.vg-file-area span { font-size: 12px; color: #9ca3af; }
.vg-current-label {
    font-size: 11.5px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .04em; color: #9ca3af; margin-bottom: 6px;
}
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

    {{-- Top bar --}}
    <div class="vg-topbar">
        <h5>Edit Video Gallery</h5>
        <a href="{{ route('newsvideogallery.index') }}" class="vg-btn-back">← Back to List</a>
    </div>

    <div class="vg-card">
        <form action="{{ route('newsvideogallery.update', $video->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Row 1: Title + Sort + Status --}}
            <div class="row g-3 mb-4">
                <div class="col-md-7">
                    <label class="vg-label">Title <span class="req">*</span></label>
                    <input type="text" name="title"
                        class="vg-input @error('title') is-invalid @enderror"
                        placeholder="Enter video title"
                        value="{{ old('title', $video->title) }}">
                    @error('title') <div class="vg-error">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="vg-label">Sort Order</label>
                    <input type="number" name="sort_order" class="vg-input" min="0"
                        value="{{ old('sort_order', $video->sort_order) }}">
                </div>
                <div class="col-md-3">
                    <label class="vg-label">Publish Status</label>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <label class="vg-toggle">
                            <input type="checkbox" name="status" value="1"
                                {{ old('status', $video->status) ? 'checked' : '' }}>
                            <span class="vg-slider"></span>
                        </label>
                        <span style="font-size:13px; color:#374151;" id="statusLabel">
                            {{ old('status', $video->status) ? 'Published' : 'Unpublished' }}
                        </span>
                    </div>
                </div>
            </div>

            <hr class="vg-divider">

            {{-- Video Type --}}
            <div class="mb-4">
                <label class="vg-label mb-2">Video Type <span class="req">*</span></label>
                <div class="vg-radio-group">
                    <input type="radio" class="vg-radio-pill" name="video_type" id="typeYoutube"
                        value="youtube" {{ old('video_type', $video->video_type) === 'youtube' ? 'checked' : '' }}>
                    <label for="typeYoutube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#dc2626"><path d="M23.5 6.2a3.02 3.02 0 00-2.12-2.13C19.54 3.6 12 3.6 12 3.6s-7.54 0-9.38.47A3.02 3.02 0 00.5 6.2 31.5 31.5 0 000 12a31.5 31.5 0 00.5 5.8 3.02 3.02 0 002.12 2.13C4.46 20.4 12 20.4 12 20.4s7.54 0 9.38-.47a3.02 3.02 0 002.12-2.13A31.5 31.5 0 0024 12a31.5 31.5 0 00-.5-5.8zM9.75 15.5v-7l6.25 3.5-6.25 3.5z"/></svg>
                        YouTube URL
                    </label>
                    <input type="radio" class="vg-radio-pill" name="video_type" id="typeUpload"
                        value="upload" {{ old('video_type', $video->video_type) === 'upload' ? 'checked' : '' }}>
                    <label for="typeUpload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                        Upload Video
                    </label>
                </div>
            </div>

            {{-- ── YouTube Section ── --}}
            <div id="youtubeSection" class="mb-4">
                <label class="vg-label">YouTube URL <span class="req">*</span></label>
                <input type="url" name="youtube_url" id="youtubeUrlInput"
                    class="vg-input @error('youtube_url') is-invalid @enderror"
                    placeholder="https://www.youtube.com/watch?v=..."
                    value="{{ old('youtube_url', $video->youtube_url) }}">
                @error('youtube_url') <div class="vg-error">{{ $message }}</div> @enderror

                {{-- Current embed --}}
                @if($video->video_type === 'youtube' && $video->youtube_embed_url)
                <div id="currentYoutubeWrap" class="vg-preview-box mt-2">
                    <div class="vg-current-label" style="padding:8px 10px 0; background:#f9fafb;">Current</div>
                    <iframe id="currentYoutubeIframe"
                        src="{{ $video->youtube_embed_url }}"
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>
                @endif

                {{-- New preview --}}
                <div class="vg-preview-box vg-preview-new" id="youtubePreview">
                    <iframe id="youtubeIframe" allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
            </div>

            {{-- ── Upload Section ── --}}
            <div id="uploadSection" class="mb-4" style="display:none;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="vg-label">
                            Upload New Video
                            <span class="opt">(leave blank to keep current)</span>
                        </label>
                        <div class="vg-file-area">
                            <input type="file" name="video_file" id="videoFileInput"
                                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                            <p id="videoFileName">Click or drag video here</p>
                            <span>mp4, mov, avi, mkv, webm — max 200 MB</span>
                        </div>
                        @error('video_file') <div class="vg-error">{{ $message }}</div> @enderror

                        {{-- Current video --}}
                        @if($video->video_type === 'upload' && $video->video_path)
                        <div class="vg-preview-box mt-2" style="background:#000;">
                            <div class="vg-current-label" style="padding:8px 10px 0; background:#111; color:#9ca3af;">Current</div>
                            <video src="{{ asset($video->video_path) }}" controls></video>
                        </div>
                        @endif

                        {{-- New video preview --}}
                        <div class="vg-preview-box vg-preview-new" id="videoPreviewBox">
                            <div class="vg-current-label" style="padding:8px 10px 0; background:#111; color:#9ca3af;">New Selection</div>
                            <video id="videoPreview" controls></video>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="vg-label">
                            Thumbnail
                            <span class="opt">(leave blank to keep current)</span>
                        </label>
                        <div class="vg-file-area">
                            <input type="file" name="thumbnail" id="thumbnailInput"
                                accept="image/jpeg,image/png,image/webp">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p id="thumbFileName">Click or drag image here</p>
                            <span>jpg, jpeg, png, webp — max 2 MB</span>
                        </div>
                        @error('thumbnail') <div class="vg-error">{{ $message }}</div> @enderror

                        {{-- Current thumbnail --}}
                        @if($video->thumbnail)
                        <div class="vg-preview-box mt-2" style="background:#f9fafb;">
                            <div class="vg-current-label" style="padding:8px 10px 0; background:#f9fafb;">Current</div>
                            <img src="{{ asset($video->thumbnail) }}" alt="Current thumbnail">
                        </div>
                        @endif

                        {{-- New thumbnail preview --}}
                        <div class="vg-preview-box vg-preview-new" id="thumbPreviewBox" style="background:#f9fafb;">
                            <div class="vg-current-label" style="padding:8px 10px 0; background:#f9fafb;">New Selection</div>
                            <img id="thumbPreview" src="#" alt="New thumbnail">
                        </div>
                    </div>
                </div>
                <small style="font-size:12px; color:#6b7280; margin-top:6px; display:block;">
                    📁 Upload path: <code>public/uploads/videogallery/</code>
                </small>
            </div>

            {{-- Thumbnail for YouTube --}}
            <div id="youtubeThumbnailSection" class="mb-4">
                <label class="vg-label">Thumbnail <span class="opt">(optional — leave blank to keep current)</span></label>
                <div class="vg-file-area">
                    <input type="file" name="thumbnail" id="ytThumbnailInput"
                        accept="image/jpeg,image/png,image/webp">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Click or drag thumbnail image</p>
                    <span>jpg, jpeg, png, webp — max 2 MB</span>
                </div>
                @if($video->thumbnail && $video->video_type === 'youtube')
                <div class="vg-preview-box mt-2" style="background:#f9fafb;">
                    <div class="vg-current-label" style="padding:8px 10px 0; background:#f9fafb;">Current</div>
                    <img src="{{ asset($video->thumbnail) }}" alt="Current thumbnail">
                </div>
                @endif
                <div class="vg-preview-box vg-preview-new" id="ytThumbPreviewBox" style="background:#f9fafb;">
                    <img id="ytThumbPreview" src="#" alt="New thumbnail">
                </div>
            </div>

            <hr class="vg-divider">

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="vg-btn-save">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update
                </button>
                <a href="{{ route('newsvideogallery.index') }}" class="vg-btn-cancel">Cancel</a>
            </div>

        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(function () {

    // ── Status label ───────────────────────────────────────────────────
    $('input[name="status"]').on('change', function () {
        $('#statusLabel').text(this.checked ? 'Published' : 'Unpublished');
    });

    // ── Toggle type ────────────────────────────────────────────────────
    function toggleType() {
        const type = $('input[name="video_type"]:checked').val();
        if (type === 'youtube') {
            $('#youtubeSection, #youtubeThumbnailSection').show();
            $('#uploadSection').hide();
        } else {
            $('#youtubeSection, #youtubeThumbnailSection').hide();
            $('#uploadSection').show();
        }
    }
    $('input[name="video_type"]').on('change', toggleType);
    toggleType();

    // ── YouTube URL → live preview ─────────────────────────────────────
    $('#youtubeUrlInput').on('input', function () {
        const m = $(this).val().match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/);
        if (m) {
            $('#youtubeIframe').attr('src', 'https://www.youtube.com/embed/' + m[1]);
            $('#youtubePreview').fadeIn(200);
            $('#currentYoutubeWrap').hide();
        } else {
            $('#youtubePreview').hide();
            $('#currentYoutubeWrap').show();
        }
    });

    // ── Video file ─────────────────────────────────────────────────────
    $('#videoFileInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        $('#videoFileName').text(file.name);
        $('#videoPreview').attr('src', URL.createObjectURL(file));
        $('#videoPreviewBox').fadeIn(200);
    });

    // ── Thumbnail (upload type) ────────────────────────────────────────
    $('#thumbnailInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        $('#thumbFileName').text(file.name);
        const r = new FileReader();
        r.onload = e => { $('#thumbPreview').attr('src', e.target.result); $('#thumbPreviewBox').fadeIn(200); };
        r.readAsDataURL(file);
    });

    // ── Thumbnail (youtube type) ───────────────────────────────────────
    $('#ytThumbnailInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        const r = new FileReader();
        r.onload = e => { $('#ytThumbPreview').attr('src', e.target.result); $('#ytThumbPreviewBox').fadeIn(200); };
        r.readAsDataURL(file);
    });

});
</script>
@endpush
