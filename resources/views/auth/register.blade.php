@extends('storefront.auth')
@section('title', 'Register')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-7"><div class="card"><div class="card-body p-4">
<h1 class="h3 mb-3">Create Customer Account</h1>
<form method="post" action="{{ route('register') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Full name</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
<div class="col-md-6"><label class="form-label">Email</label><input class="form-control" name="email" type="email" value="{{ old('email') }}" required></div>
<div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
<div class="col-md-4"><label class="form-label">County</label><input class="form-control" name="county" value="{{ old('county') }}"></div>
<div class="col-md-4"><label class="form-label">Location</label><input class="form-control" name="location" value="{{ old('location') }}"></div>
<div class="col-md-6"><label class="form-label">Password</label><input class="form-control" name="password" type="password" required></div>
<div class="col-md-6"><label class="form-label">Confirm password</label><input class="form-control" name="password_confirmation" type="password" required></div>
</div><button class="btn btn-brand mt-3">Register</button>
</form></div></div></div></div></div>
@endsection
