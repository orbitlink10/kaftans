@extends('layouts.app')
@section('title', $provider->exists ? 'Edit Provider' : 'Add Provider')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-9"><div class="card"><div class="card-body p-4">
<h1 class="h3">{{ $provider->exists ? 'Edit Provider' : 'Add Provider' }}</h1>
<form method="post" action="{{ $provider->exists ? route('admin.providers.update',$provider) : route('admin.providers.store') }}" enctype="multipart/form-data">@csrf @if($provider->exists) @method('put') @endif
<div class="row g-3"><div class="col-md-6"><label class="form-label">Linked user</label><select class="form-select" name="user_id"><option value="">None</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected(old('user_id',$provider->user_id)==$user->id)>{{ $user->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Category</label><select class="form-select" name="category_id"><option value="">None</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$provider->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Full/company name</label><input class="form-control" name="name" value="{{ old('name',$provider->name) }}" required></div>
<div class="col-md-3"><label class="form-label">Phone</label><input class="form-control" name="phone" value="{{ old('phone',$provider->phone) }}" required></div>
<div class="col-md-3"><label class="form-label">Email</label><input class="form-control" name="email" value="{{ old('email',$provider->email) }}"></div>
<div class="col-md-4"><label class="form-label">County</label><input class="form-control" name="county" value="{{ old('county',$provider->county) }}"></div>
<div class="col-md-4"><label class="form-label">Location</label><input class="form-control" name="location" value="{{ old('location',$provider->location) }}"></div>
<div class="col-md-4"><label class="form-label">Document</label><input class="form-control" type="file" name="document"></div>
<div class="col-md-6"><label class="form-label">Availability</label><select class="form-select" name="availability_status">@foreach(['available','busy','offline'] as $status)<option value="{{ $status }}" @selected(old('availability_status',$provider->availability_status)===$status)>{{ $status }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Verification</label><select class="form-select" name="verification_status">@foreach(['pending','approved','rejected'] as $status)<option value="{{ $status }}" @selected(old('verification_status',$provider->verification_status)===$status)>{{ $status }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Services</label><select class="form-select" name="service_ids[]" multiple size="6">@foreach($services as $service)<option value="{{ $service->id }}" @selected($provider->services->contains($service))>{{ $service->name }}</option>@endforeach</select></div></div>
<button class="btn btn-brand mt-3">Save Provider</button></form></div></div></div></div></div>
@endsection
