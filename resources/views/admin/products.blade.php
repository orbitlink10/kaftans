@extends('layouts.dashboard')
@section('title', 'Products')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')
@section('content')
@include('admin.catalog-style')
<div class="catalog-screen"><div class="catalog-header"><div><h1>Products</h1><p>Manage and view all products available in the system</p></div><a class="catalog-btn" href="{{ route('admin.products.create') }}">+ Add Product</a></div>
<div class="catalog-panel"><div class="catalog-search"><h2 class="h5 mb-0">Product List</h2><form method="get"><input type="search" name="q" value="{{ request('q') }}" placeholder="Search by product name..." aria-label="Search by product name">@if(request('collection'))<input type="hidden" name="collection" value="{{ request('collection') }}">@endif<button class="catalog-btn">Search</button></form></div>
<div class="table-responsive"><table class="catalog-table"><thead><tr><th>#</th><th>Image</th><th>Name</th><th>Price (KES)</th><th>Published</th><th>Category</th><th>Actions</th></tr></thead><tbody>
@forelse($products as $product)<tr><td>{{ $products->firstItem() + $loop->index }}</td><td>@if($product->image)<img class="catalog-photo" src="{{ $product->image }}" alt="{{ $product->name }}">@else<div class="catalog-photo catalog-no-image">No Image</div>@endif</td><td>{{ $product->name }}</td><td>{{ number_format($product->price, 2) }}</td><td>{{ $product->active ? 'Yes' : 'No' }}</td><td>{{ $collections[$product->collection] ?? $product->collection }}</td><td><div class="catalog-actions"><a class="catalog-btn catalog-preview" href="{{ url('/admin/products/'.$product->id.'/preview') }}">Preview</a><a class="catalog-btn catalog-update" href="{{ route('admin.products.edit', $product) }}">Update</a><form method="post" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="catalog-btn catalog-delete">Delete</button></form></div></td></tr>@empty<tr><td colspan="7">No products found. Add a product to get started.</td></tr>@endforelse
</tbody></table></div><div class="catalog-pagination">{{ $products->links() }}</div></div></div>
@endsection