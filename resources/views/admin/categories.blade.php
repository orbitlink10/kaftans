@extends('layouts.dashboard')
@section('title', 'Categories')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')
@section('content')
@include('admin.catalog-style')
<div class="catalog-screen">
<div class="catalog-header"><h1>{{ request()->boolean('subcategories') ? 'Sub Categories' : 'Categories' }}</h1><a class="catalog-btn" href="{{ route('admin.categories.create') }}">Create New Category</a></div>
<div class="catalog-panel"><div class="table-responsive"><table class="catalog-table">
<thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Indexable</th><th>Photo</th><th>Actions</th></tr></thead><tbody>
@forelse($categories as $category)
<tr><td>{{ $category->id }}</td><td>{{ $category->name }}</td><td>{{ $category->slug }}</td><td>{{ $category->is_indexable ? 'Yes' : 'No' }}</td><td>@if($category->image)<img class="catalog-photo" src="{{ $category->image }}" alt="{{ $category->name }}">@else<div class="catalog-photo catalog-no-image">No Image</div>@endif</td><td><div class="catalog-actions">
<a class="catalog-btn catalog-preview" href="{{ url('/collections/'.$category->slug) }}">Preview</a>
<a class="catalog-btn catalog-update" href="{{ route('admin.categories.edit', $category) }}">Update</a>
<form action="{{ route('admin.categories.destroy', $category) }}" method="post" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="catalog-btn catalog-delete">Delete</button></form>
</div></td></tr>
@empty<tr><td colspan="6">No categories yet. Create your first category above.</td></tr>@endforelse
</tbody></table></div><div class="catalog-pagination">{{ $categories->links() }}</div></div></div>
@endsection