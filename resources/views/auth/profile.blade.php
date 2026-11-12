@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-7"><div class="card"><div class="card-body p-4">
<h1 class="h3 mb-3">Profile</h1>
<form method="post" action="{{ route('profile.update') }}">@csrf @method('put')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}" required></div>
<div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="{{ auth()->user()->email }}" disabled></div>
<div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone" value="{{ old('phone', auth()->user()->phone) }}"></div>
<div class="col-md-4"><label class="form-label">County</label><input class="form-control" name="county" value="{{ old('county', auth()->user()->county) }}"></div>
<div class="col-md-4"><label class="form-label">Location</label><input class="form-control" name="location" value="{{ old('location', auth()->user()->location) }}"></div>
</div><button class="btn btn-brand mt-3">Save</button>
</form></div></div></div></div></div>
@endsection
