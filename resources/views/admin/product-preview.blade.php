@extends('layouts.dashboard')
@section('title', 'Product Preview')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')
@section('content')
@include('admin.catalog-style')
<div class="catalog-screen"><div class="catalog-header"><h1>{{ $product->name }}</h1><a class="catalog-btn" href="{{ route('admin.products.edit', $product) }}">Update Product</a></div>
<div class="catalog-panel catalog-form">
@if($product->image)<img style="max-width:100%;max-height:400px" src="{{ $product->image }}" alt="{{ $product->name }}">@endif
<p class="h4 mt-3">KES {{ number_format($product->price, 2) }}</p>
<p>{{ $collections[$product->collection] ?? $product->collection }} · {{ $product->active ? 'Published' : 'Draft' }}</p>
@if($product->description_html)<div>{!! $product->description_html !!}</div>@else<p>{{ $product->description }}</p>@endif<p>{{ $product->care }}</p>
<table class="table"><thead><tr><th>Size</th><th>Colour</th><th>Stock</th></tr></thead><tbody>@foreach($product->variants as $variant)<tr><td>{{ $variant->size }}</td><td>{{ $variant->color }}</td><td>{{ $variant->stock }}</td></tr>@endforeach</tbody></table>
<a href="{{ route('admin.products.list') }}">Back to products</a>
</div></div>
@endsection
