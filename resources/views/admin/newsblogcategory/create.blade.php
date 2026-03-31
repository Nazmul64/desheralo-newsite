@extends('admin.master')

@section('content')
<style>
.form-wrap { padding: 24px; background: #f5f6fa; min-height: 100vh; }
.form-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; border-radius: 8px; padding: 14px 20px;
    margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.form-topbar h5 { margin: 0; font-size: 15px; font-weight: 600; color: #222; }
.form-card {
    background: #fff; border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 24px;
    max-width: 600px;
}
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.form-control-c {
    width: 100%; border: 1px solid #d1d5db; border-radius: 6px;
    padding: 9px 12px; font-size: 13px; color: #374151;
    outline: none; transition: border-color .18s, box-shadow .18s; background: #fff;
}
.form-control-c:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.form-control-c.is-invalid { border-color: #dc2626; }
.invalid-msg { font-size: 12px; color: #dc2626; margin-top: 4px; }

.btn-save {
    background: #2563eb; color: #fff; border: none; border-radius: 6px;
    padding: 9px 22px; font-size: 13px; font-weight: 500; cursor: pointer;
    transition: background .18s;
}
.btn-save:hover { background: #1d4ed8; }
.btn-back {
    background: #f3f4f6; color: #374151; border: none; border-radius: 6px;
    padding: 9px 22px; font-size: 13px; font-weight: 500; cursor: pointer;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s;
}
.btn-back:hover { background: #e5e7eb; color: #111; }
</style>

<div class="form-wrap">
    <div class="form-topbar">
        <h5>Add Category</h5>
        <a href="{{ route('newsblogcategory.index') }}" class="btn-back">
            ← Back to List
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('newsblogcategory.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Category Name <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" class="form-control-c @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Enter category name">
                @error('name')
                    <div class="invalid-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control-c">
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control-c @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', 0) }}" min="0">
                @error('sort_order')
                    <div class="invalid-msg">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-save">Save Category</button>
                <a href="{{ route('newsblogcategory.index') }}" class="btn-back">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
