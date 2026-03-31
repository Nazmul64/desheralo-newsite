@extends('admin.master')
@section('content')

<style>
.sc-page-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 18px; flex-wrap: wrap; gap: 10px;
}
.page-title { font-size: 1.05rem; font-weight: 700; color: #1e293b; }

.form-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,.07); padding: 28px 32px; max-width: 680px;
}

.fc-label {
    display: block; font-size: .82rem; font-weight: 600;
    color: #475569; margin-bottom: 6px;
}
.fc-input {
    width: 100%; border: 1px solid #e2e8f0; border-radius: 7px;
    padding: 9px 13px; font-size: .875rem; color: #334155;
    background: #fff; transition: border .18s; outline: none; box-sizing: border-box;
}
.fc-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
.fc-input.is-invalid { border-color: #ef4444 !important; }

/* Current photo */
.current-photo {
    width: 100px; height: 100px; object-fit: cover;
    border-radius: 8px; border: 1px solid #e2e8f0;
    display: block; margin-bottom: 8px;
}
.current-placeholder {
    width: 100px; height: 100px; border-radius: 8px;
    background: #f1f5f9; border: 1px solid #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 1.4rem; margin-bottom: 8px;
}

/* Image preview */
.img-preview-wrap {
    margin-top: 10px; display: none;
    border: 1px solid #e2e8f0; border-radius: 8px;
    overflow: hidden; max-width: 200px;
}
.img-preview-wrap img { width: 100%; display: block; }

/* Toggle */
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute; cursor: pointer; inset: 0;
    background: #cbd5e1; border-radius: 24px; transition: .25s;
}
.toggle-slider:before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: .25s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-slider { background: #2563eb; }
.toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

.btn-save {
    background: #2563eb; color: #fff; border: none; border-radius: 7px;
    padding: 9px 28px; font-size: .875rem; font-weight: 500;
    cursor: pointer; transition: background .18s;
    display: inline-flex; align-items: center; gap: 7px;
}
.btn-save:hover { background: #1d4ed8; }
.btn-cancel {
    background: none; border: 1.5px solid #e2e8f0; border-radius: 7px;
    padding: 8px 22px; font-size: .85rem; color: #475569;
    cursor: pointer; font-weight: 500; transition: all .15s; text-decoration: none;
    display: inline-flex; align-items: center;
}
.btn-cancel:hover { border-color: #94a3b8; color: #334155; }
</style>

<div class="container-fluid py-4">

    <div class="sc-page-header">
        <span class="page-title">Edit Gallery Item</span>
        <a href="{{ route('newsgallery.index') }}" class="btn-cancel">
            <i class="fas fa-arrow-left me-2" style="font-size:.75rem;"></i> Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:.84rem;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('newsgallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Title --}}
            <div class="mb-4">
                <label class="fc-label">Title <span style="color:#ef4444;">*</span></label>
                <input type="text" name="title"
                       class="fc-input @error('title') is-invalid @enderror"
                       placeholder="Enter gallery title"
                       value="{{ old('title', $gallery->title) }}" autocomplete="off">
                @error('title')
                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Photo --}}
            <div class="mb-4">
                <label class="fc-label">Photo <small style="color:#94a3b8;">(Leave blank to keep current)</small></label>

                {{-- Show current photo --}}
                @if($gallery->photo && file_exists(public_path($gallery->photo)))
                    <img src="{{ asset($gallery->photo) }}"
                        alt="current" class="current-photo">
                @else
                    <div class="current-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                @endif

                <input type="file" name="photo" id="photoInput"
                       class="fc-input @error('photo') is-invalid @enderror"
                       accept="image/*">
                @error('photo')
                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;">{{ $message }}</div>
                @enderror
                <div class="img-preview-wrap" id="previewWrap">
                    <img id="previewImg" src="#" alt="New Preview">
                </div>
            </div>

            {{-- Publish Status --}}
            <div class="mb-4">
                <label class="fc-label">Publish Status</label>
                <div class="d-flex align-items-center gap-3 mt-1">
                    <label class="toggle-switch">
                        <input type="checkbox" name="status" value="1"
                               {{ old('status', $gallery->status) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span style="font-size:.83rem;color:#475569;">Published</span>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex align-items-center gap-3 mt-2">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save" style="font-size:.78rem;"></i> Update
                </button>
                <a href="{{ route('newsgallery.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var wrap = document.getElementById('previewWrap');
    var img  = document.getElementById('previewImg');
    var reader = new FileReader();
    reader.onload = function (e) {
        img.src = e.target.result;
        wrap.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>

@endsection
