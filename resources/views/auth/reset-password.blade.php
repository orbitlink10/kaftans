@extends('storefront.auth')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-md-5"><div class="card"><div class="card-body p-4">
<h1 class="h3">Set New Password</h1><form method="post" action="{{ route('password.update') }}">@csrf
<input type="hidden" name="token" value="{{ $token }}"><label class="form-label">Email</label><input class="form-control mb-3" type="email" name="email" required>
<label class="form-label">Password</label><input class="form-control mb-3" type="password" name="password" required>
<label class="form-label">Confirm password</label><input class="form-control mb-3" type="password" name="password_confirmation" required><button class="btn btn-brand w-100">Update password</button>
</form></div></div></div></div></div>
@endsection
