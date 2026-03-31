@extends('admin.master')

@section('content')
<style>
.nb-wrap { padding: 24px; background: #f5f6fa; min-height: 100vh; }

.nb-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 4px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.nb-topbar h5 { margin: 0; font-size: 16px; font-weight: 700; color: #111; }

.nb-btn-list {
    background: #2563eb; color: #fff; border: none; border-radius: 5px;
    padding: 8px 18px; font-size: 13px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
    transition: background .18s;
}
.nb-btn-list:hover { background: #1d4ed8; color: #fff; }

.nb-form-card {
    background: #fff; border-radius: 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 28px 24px;
}

.nb-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }

.nb-field {
    border: 1px solid #e5e7eb;
    padding: 0;
    position: relative;
}
.nb-field-label {
    font-size: 12px; font-weight: 500; color: #6b7280;
    padding: 8px 14px 0;
    display: block;
}
.nb-field-label .req { color: #dc2626; }
.nb-field input,
.nb-field select,
.nb-field textarea {
    width: 100%; border: none; outline: none;
    padding: 4px 14px 10px; font-size: 13.5px; color: #111;
    background: transparent; resize: none;
    appearance: none; -webkit-appearance: none;
}
.nb-field select {
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236b7280' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 12px center;
    background-color: transparent; cursor: pointer; padding-right: 32px;
}
.nb-field textarea { min-height: 80px; }
.nb-field.is-invalid { border-color: #dc2626; }
.nb-invalid-msg { font-size: 11.5px; color: #dc2626; padding: 3px 14px 6px; }

/* Image field */
.nb-image-row { display: grid; grid-template-columns: 1fr 40px; }
.nb-upload-icon {
    display: flex; align-items: center; justify-content: center;
    border-left: 1px solid #e5e7eb; cursor: pointer; color: #374151;
    transition: background .15s;
}
.nb-upload-icon:hover { background: #f3f4f6; }

/* Preview */
.nb-img-preview-wrap { padding: 10px 14px 14px; }
.nb-img-preview { max-height: 160px; border-radius: 6px; border: 1px solid #e5e7eb; display: none; }

/* Buttons */
.nb-btn-row { display: flex; justify-content: center; gap: 16px; padding: 28px 0 8px; }
.btn-cancel {
    background: #fff; color: #dc2626; border: 1.5px solid #dc2626; border-radius: 6px;
    padding: 9px 32px; font-size: 13.5px; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center;
    transition: background .18s;
}
.btn-cancel:hover { background: #fef2f2; color: #dc2626; }
.btn-save-blog {
    background: #2563eb; color: #fff; border: none; border-radius: 6px;
    padding: 9px 32px; font-size: 13.5px; font-weight: 500; cursor: pointer;
    transition: background .18s;
}
.btn-save-blog:hover { background: #1d4ed8; }
</style>

<div class="nb-wrap">

    <div class="nb-topbar">
        <h5>Add New Blog</h5>
        <a href="{{ route('newblog.index') }}" class="nb-btn-list">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                <line x1="8" y1="18" x2="21" y2="18"/>
                <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
                <line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
            Blog List
        </a>
    </div>

    <div class="nb-form-card">
        <form method="POST" action="{{ route('newblog.store') }}" enctype="multipart/form-data" id="blogForm">
            @csrf

            {{-- Row 1: Title | Summary --}}
            <div class="nb-row">
                <div class="nb-field @error('title') is-invalid @enderror">
                    <label class="nb-field-label">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter title">
                    @error('title')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
                <div class="nb-field @error('summary') is-invalid @enderror" style="border-left:none;">
                    <label class="nb-field-label">Summary</label>
                    <textarea name="summary" placeholder="Enter Summary" rows="3">{{ old('summary') }}</textarea>
                    @error('summary')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Row 2: Description | Blog Category --}}
            <div class="nb-row" style="border-top:none;">
                <div class="nb-field @error('description') is-invalid @enderror" style="border-top:none;">
                    <label class="nb-field-label">Description</label>
                    <textarea name="description" placeholder="Enter description" rows="4">{{ old('description') }}</textarea>
                    @error('description')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
                <div class="nb-field @error('newsblogcategory_id') is-invalid @enderror" style="border-top:none; border-left:none;">
                    <label class="nb-field-label">Blog Category</label>
                    <select name="newsblogcategory_id" id="categorySelect">
                        <option value="">Select</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('newsblogcategory_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('newsblogcategory_id')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Row 3: Blog Sub-category | Date --}}
            <div class="nb-row">
                <div class="nb-field @error('newssubblogcategory_id') is-invalid @enderror" style="border-top:none;">
                    <label class="nb-field-label">Blog Sub-category</label>
                    <select name="newssubblogcategory_id" id="subcategorySelect">
                        <option value="">Select</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('newssubblogcategory_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('newssubblogcategory_id')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
                <div class="nb-field @error('date') is-invalid @enderror" style="border-top:none; border-left:none;">
                    <label class="nb-field-label">Date</label>
                    <input type="date" name="date" value="{{ old('date') }}">
                    @error('date')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Row 4: Tags | Publish/Unpublish --}}
            <div class="nb-row">
                <div class="nb-field @error('tags') is-invalid @enderror" style="border-top:none;">
                    <label class="nb-field-label">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Enter Tags">
                    @error('tags')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
                <div class="nb-field @error('status') is-invalid @enderror" style="border-top:none; border-left:none;">
                    <label class="nb-field-label">Publish / Unpublish</label>
                    <select name="status">
                        <option value="">Select a status</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Unpublished</option>
                    </select>
                    @error('status')<div class="nb-invalid-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Row 5: Image --}}
            <div style="border:1px solid #e5e7eb; border-top:none;">
                <div class="nb-image-row">
                    <div class="nb-field" style="border:none;">
                        <label class="nb-field-label">Image</label>
                        <input type="file" name="image" id="imageInput" accept="image/*"
                               style="padding-top:6px; padding-bottom:10px;">
                    </div>
                    <label for="imageInput" class="nb-upload-icon" title="Upload image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 16 12 12 8 16"/>
                            <line x1="12" y1="12" x2="12" y2="21"/>
                            <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                        </svg>
                    </label>
                </div>
                @error('image')
                    <div class="nb-invalid-msg">{{ $message }}</div>
                @enderror
                <div class="nb-img-preview-wrap">
                    <img id="imagePreview" class="nb-img-preview" src="#" alt="Preview">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="nb-btn-row">
                <a href="{{ route('newblog.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save-blog">Save</button>
            </div>

        </form>
    </div>
</div>

<script>
// ── Image Preview ──────────────────────────────────────────────────────────────
document.getElementById('imageInput').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var preview = document.getElementById('imagePreview');
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
});

// ── Dynamic Sub-category Load ──────────────────────────────────────────────────
document.getElementById('categorySelect').addEventListener('change', function () {
    var catId      = this.value;
    var subSelect  = document.getElementById('subcategorySelect');
    var subUrl     = "{{ route('newblog.subcategories') }}";
    var oldSubId   = "{{ old('newssubblogcategory_id') }}";

    subSelect.innerHTML = '<option value="">Select</option>';
    if (!catId) return;

    fetch(subUrl + '?category_id=' + catId)
        .then(function(res){ return res.json(); })
        .then(function(data){
            data.forEach(function(sub){
                var opt      = document.createElement('option');
                opt.value    = sub.id;
                opt.textContent = sub.name;
                if (oldSubId && oldSubId == sub.id) opt.selected = true;
                subSelect.appendChild(opt);
            });
        })
        .catch(function(err){ console.error(err); });
});
</script>
@endsection
