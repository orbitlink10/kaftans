@extends('layouts.dashboard')

@section('title', $page ? 'Update Page' : 'Create Page')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')

@section('content')
<style>
    .page-form-screen, .page-form-screen button, .page-form-screen input, .page-form-screen select, .page-form-screen textarea { font-family:'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; letter-spacing:normal; }
    .page-form-screen { min-height:100vh; padding:36px 24px 57px; background:#f4f6fb; color:#212529; font-size:16px; line-height:24px; font-weight:400; overflow:hidden; }
    .page-form-wrap { width:100%; max-width:none; }
    .page-form-title { margin:0 0 24px; font-size:28.8px; line-height:34.56px; font-weight:600; color:#0f172a; }
    .page-form-card { background:#fff; border-radius:4.8px; box-shadow:0 16px 48px rgba(0,0,0,.176); overflow:hidden; margin-bottom:16px; }
    .page-form-card-head { background:#fff; min-height:56px; display:flex; align-items:center; justify-content:space-between; padding:12px 20px; border-bottom:1px solid rgba(0,0,0,.125); }
    .page-form-card-head h2 { margin:0; font-size:17.6px; line-height:21.12px; font-weight:600; color:#0f172a; }
    .page-form-back { color:#007bff; text-decoration:none; font-size:14px; line-height:21px; font-weight:700; }
    .page-form-body { padding:20px; }
    .page-field { margin-bottom:16px; }
    .page-label { display:block; margin-bottom:8px; font-size:16px; line-height:24px; font-weight:600; color:#212529; }
    .page-input, .page-select, .page-textarea { width:100%; border:1px solid #ced4da; border-radius:4px; color:#495057; background:#fff; font-size:16px; line-height:24px; font-weight:400; outline:none; box-shadow:inset 0 1px 2px rgba(0,0,0,.075); }
    .page-input, .page-select { height:38px; padding:6px 12px; }
    .page-select { appearance:auto; }
    .page-textarea { min-height:360px; padding:12px; }
    .page-input::placeholder, .page-textarea::placeholder { color:#8794a3; font-weight:400; }
    .page-input:focus, .page-select:focus, .page-textarea:focus { border-color:#9bc9fb; box-shadow:0 0 0 3px rgba(13,128,247,.12); }
    .page-actions { display:flex; gap:12px; align-items:center; margin-top:26px; }
    .page-save { border:0; border-radius:999px; padding:6px 12px; background:#007bff; color:#fff; font-size:14px; line-height:21px; font-weight:600; }
    .page-cancel { border:1px solid #6c757d; border-radius:999px; padding:5px 12px; background:#fff; color:#6c757d; font-size:14px; line-height:21px; font-weight:600; text-decoration:none; }
    .tox.tox-tinymce { border-radius:4px; border-color:#ced4da; min-height:430px; font-family:'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
    .tox .tox-menubar, .tox .tox-toolbar, .tox .tox-toolbar__primary, .tox .tox-tbtn, .tox .tox-mbtn, .tox .tox-statusbar { font-family:'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
    .invalid-feedback { display:block; font-size:1rem; }
    @media (max-width: 991.98px) {
        .page-form-screen { padding:20px 16px; }
        .page-form-title { font-size:28.8px; }
        .page-form-body, .page-form-card-head { padding-left:20px; padding-right:20px; }
    }
</style>
<div class="page-form-screen">
    <div class="page-form-wrap">
        <h1 class="page-form-title">Manage Pages</h1>

        <form class="page-form-card" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif

            <div class="page-form-card-head">
                <h2>{{ $page ? 'Update Post' : 'Add New Post' }}</h2>
                <a class="page-form-back" href="{{ route('admin.pages') }}">Back</a>
            </div>

            <div class="page-form-body">
                <div class="page-field">
                    <label class="page-label" for="meta_title">Meta Title</label>
                    <input class="page-input" id="meta_title" name="meta_title" value="{{ old('meta_title', $page['meta_title'] ?? '') }}" placeholder="Enter Meta Title" maxlength="160" required>
                    @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="meta_description">Meta Description</label>
                    <input class="page-input" id="meta_description" name="meta_description" value="{{ old('meta_description', $page['meta_description'] ?? '') }}" placeholder="Enter Meta Description" maxlength="255">
                    @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="title">Page Title</label>
                    <input class="page-input" id="title" name="title" value="{{ old('title', $page['title'] ?? '') }}" placeholder="Enter Keyword Title" maxlength="180" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="alt">Image Alt Text</label>
                    <input class="page-input" id="alt" name="alt" value="{{ old('alt', $page['alt'] ?? '') }}" placeholder="Enter Image Alt Text" maxlength="160">
                    @error('alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="heading_2">Heading 2</label>
                    <input class="page-input" id="heading_2" name="heading_2" value="{{ old('heading_2', $page['heading_2'] ?? '') }}" placeholder="Enter Heading 2" maxlength="180">
                    @error('heading_2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="type">Type</label>
                    <select class="page-select" id="type" name="type" required>
                        @foreach(['Post', 'Page'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $page['type'] ?? 'Post') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="image">Image</label>
                    <input class="page-input" id="image" name="image" type="file" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-field">
                    <label class="page-label" for="description">Page Description:</label>
                    <textarea class="page-textarea" id="description" name="description">{{ old('description', $page['description'] ?? '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="page-actions">
                    <button class="page-save" type="submit">{{ $page ? 'Update' : 'Save' }}</button>
                    <a class="page-cancel" href="{{ route('admin.pages') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.tinymce) {
            return;
        }

        tinymce.init({
            selector: '#description',
            menubar: 'file edit view insert format tools table',
            plugins: 'link image media table code fullscreen lists',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
            height: 430,
            branding: false,
            promotion: false,
            content_style: "body { font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 16px; font-weight: 400; color: #495057; }"
        });
    });
</script>
@endpush
