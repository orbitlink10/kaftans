@extends('layouts.dashboard')

@section('title', 'Pages')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')

@section('content')
@php
    $imageUrl = function (?string $image) {
        if (! $image) {
            return 'https://via.placeholder.com/260x150?text=No+Image';
        }

        return str_starts_with($image, 'http') || str_starts_with($image, '//')
            ? $image
            : route('pages.image', ['path' => ltrim($image, '/')]);
    };
@endphp
<style>
    .pages-screen, .pages-screen button, .pages-screen input, .pages-screen select { font-family:'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; letter-spacing:normal; }
    .pages-screen { min-height:100vh; padding:36px 24px 57px; background:#f4f6fb; color:#212529; font-size:16px; line-height:24px; font-weight:400; overflow:hidden; }
    .pages-heading h1 { margin:0 0 4px; font-size:28.8px; line-height:34.56px; font-weight:600; letter-spacing:normal; color:#0f172a; }
    .pages-heading p { margin:0 0 24px; font-size:16px; line-height:24px; font-weight:400; color:#6c757d; }
    .pages-card { background:#fff; border-radius:4.8px; overflow:hidden; box-shadow:0 16px 48px rgba(0,0,0,.176); margin-bottom:16px; }
    .pages-card-head { display:flex; align-items:center; justify-content:space-between; min-height:56px; padding:12px 20px; border-bottom:1px solid rgba(0,0,0,.125); }
    .pages-card-title { margin:0; font-size:17.6px; line-height:21.12px; font-weight:600; color:#0f172a; }
    .pages-add-btn { display:inline-flex; align-items:center; gap:6px; border:0; border-radius:999px; padding:4px 12px; color:#007bff; background:#f8f9fa; font-size:14px; line-height:21px; font-weight:700; text-decoration:none; }
    .pages-toolbar { display:flex; align-items:center; gap:8px; padding:20px 20px 16px; background:#fff; }
    .pages-select { width:102px; height:31px; border:1px solid #ced4da; border-radius:4px; padding:4px 28px 4px 8px; font-size:12px; line-height:18px; font-weight:400; color:#495057; background:#fff; box-shadow:inset 0 1px 2px rgba(0,0,0,.075); }
    .pages-apply { height:31px; border:0; border-radius:999px; padding:4px 12px; background:#007bff; color:#fff; font-size:14px; line-height:21px; font-weight:600; }
    .pages-table-wrap { padding:0 20px 20px; background:#fff; overflow-x:auto; }
    .pages-table { width:100%; border-collapse:collapse; table-layout:fixed; color:#001438; }
    .pages-table thead tr { background:#f8fafc; border:0; }
    .pages-table th { padding:12px; color:#64748b; font-size:11.52px; line-height:17.28px; letter-spacing:1.3824px; text-transform:uppercase; font-weight:700; background:#f8fafc; }
    .pages-table td { padding:12px; font-size:16px; line-height:24px; font-weight:400; color:#1f2937; vertical-align:middle; border-bottom:1px solid #dee2e6; background:transparent; overflow-wrap:anywhere; }
    .pages-table tbody tr:nth-child(odd) { background:rgba(0,0,0,.05); }
    .pages-table tbody tr:nth-child(even) { background:#fff; }
    .pages-check { width:18px; height:18px; border:1px solid #7b8794; border-radius:4px; }
    .pages-no { width:88px; color:#002d68; }
    .pages-image { width:150px; max-width:100%; height:auto; max-height:100px; object-fit:cover; display:block; }
    .pages-action { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px; }
    .pages-pill { width:134px; min-width:134px; height:31px; display:inline-flex; align-items:center; justify-content:center; gap:6px; border-radius:999px; background:transparent; font-size:14px; line-height:21px; font-weight:600; padding:4px 12px; text-decoration:none; white-space:nowrap; overflow:hidden; }
    .pages-pill.preview { color:#0798bd; border:1px solid #08a7ce; }
    .pages-pill.update { color:#ffb000; border:1px solid #ffbf19; }
    .pages-pill.delete { color:#ff2434; border:1px solid #ff2434; }
    .pages-delete-form { margin:0; }
    .pages-pagination { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:0 20px 20px; background:#fff; color:#64748b; font-size:14px; line-height:21px; }
    .pages-pagination .pagination { margin:0; flex-wrap:wrap; gap:4px; }
    .pages-pagination .page-link { border-radius:999px; color:#007bff; border-color:#dee2e6; }
    .pages-pagination .page-item.active .page-link { background:#007bff; border-color:#007bff; color:#fff; }
    .pages-pagination .page-item.disabled .page-link { color:#94a3b8; }
    @media (max-width: 991.98px) {
        .pages-screen { padding:20px 16px; }
        .pages-card-head, .pages-toolbar, .pages-table-wrap, .pages-pagination { padding-left:16px; padding-right:16px; }
        .pages-pagination { align-items:flex-start; flex-direction:column; }
    }
</style>
<div class="pages-screen">
    <div class="pages-heading">
        <h1>Pages</h1>
        <p>Manage site pages and published content.</p>
    </div>

    <section class="pages-card">
        <div class="pages-card-head">
            <h2 class="pages-card-title">Post List</h2>
            <a class="pages-add-btn" href="{{ route('admin.pages.create') }}"><i class="bi bi-plus-lg"></i> Add Page</a>
        </div>

        <div class="pages-toolbar">
            <select class="pages-select" aria-label="Bulk actions">
                <option>Bulk actions</option>
                <option>Delete</option>
                <option>Publish</option>
            </select>
            <button class="pages-apply" type="button">Apply</button>
        </div>

        <div class="pages-table-wrap">
            <table class="pages-table">
                <thead>
                    <tr>
                        <th style="width:5%;"><input class="pages-check" type="checkbox"></th>
                        <th style="width:7%;">No.</th>
                        <th style="width:19%;">Image</th>
                        <th style="width:24%;">Title</th>
                        <th style="width:24%;">Alt Text</th>
                        <th style="width:9%;">Type</th>
                        <th style="width:13%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td><input class="pages-check" type="checkbox" name="selected[]" value="{{ $post['id'] }}"></td>
                            <td class="pages-no">{{ $post['id'] }}</td>
                            <td><img class="pages-image" src="{{ $imageUrl($post['image'] ?? null) }}" alt="{{ $post['alt'] ?? $post['title'] }}"></td>
                            <td>{{ $post['title'] }}</td>
                            <td>{{ $post['alt'] ?? $post['title'] }}</td>
                            <td>{{ $post['type'] ?? 'Post' }}</td>
                            <td>
                                <div class="pages-action">
                                    <a class="pages-pill preview" href="{{ route('pages.preview', $post['slug']) }}" target="_blank"><i class="bi bi-eye-fill"></i> Preview</a>
                                    <a class="pages-pill update" href="{{ route('admin.pages.edit', $post['id']) }}"><i class="bi bi-pencil-square"></i> Update</a>
                                    <form class="pages-delete-form" method="post" action="{{ route('admin.pages.destroy', $post['id']) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="pages-pill delete" type="submit" onclick="return confirm('Delete this page?')"><i class="bi bi-trash3-fill"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="pages-pagination">
                <div>
                    Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} pages
                </div>
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</div>
@endsection
