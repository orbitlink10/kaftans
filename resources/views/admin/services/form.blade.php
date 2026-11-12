@extends('layouts.app')
@section('title', $service->exists ? 'Edit Service' : 'Add Service')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-8"><div class="card"><div class="card-body p-4">
<h1 class="h3">{{ $service->exists ? 'Edit Service' : 'Add Service' }}</h1>
<form method="post" action="{{ $service->exists ? route('admin.services.update',$service) : route('admin.services.store') }}" enctype="multipart/form-data">@csrf @if($service->exists) @method('put') @endif
<div class="row g-3"><div class="col-md-6"><label class="form-label">Category</label><select class="form-select" name="category_id">@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$service->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="{{ old('name',$service->name) }}" required></div>
<div class="col-md-6"><label class="form-label">Base price</label><input class="form-control" name="base_price" type="number" min="0" value="{{ old('base_price',$service->base_price) }}"></div>
<div class="col-md-6"><label class="form-label">Unit type</label><select class="form-select" name="unit_type">@foreach(['fixed','hourly','per room','per item','per km'] as $unit)<option value="{{ $unit }}" @selected(old('unit_type',$service->unit_type)===$unit)>{{ $unit }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4">{{ old('description',$service->description) }}</textarea></div>
<div class="col-md-8"><label class="form-label">Image</label><input class="form-control" type="file" name="image" accept="image/*"></div>
<div class="col-md-4 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" @checked(old('is_active',$service->is_active))><label class="form-check-label" for="active">Active</label></div></div></div>
<button class="btn btn-brand mt-3">Save Service</button></form></div></div></div></div></div>
@endsection
