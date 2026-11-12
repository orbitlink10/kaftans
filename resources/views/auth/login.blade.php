@extends('storefront.auth')
@section('title', 'Login')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-md-5"><div class="card"><div class="card-body p-4">
<h1 class="h3 mb-3">Login</h1>
<form method="post" action="{{ route('login') }}">@csrf
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" name="email" type="email" value="{{ old('email') }}" required></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control" name="password" type="password" required></div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
<button class="btn btn-brand w-100">Login</button>
<div class="d-flex justify-content-between mt-3"><a href="{{ route('password.request') }}">Forgot password?</a><a href="{{ route('register') }}">Create account</a></div>
</form></div></div></div></div></div>
@endsection
