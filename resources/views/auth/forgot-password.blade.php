@extends('storefront.auth')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-md-5"><div class="card"><div class="card-body p-4">
<h1 class="h3">Reset Password</h1><form method="post" action="{{ route('password.email') }}">@csrf
<label class="form-label">Email</label><input class="form-control mb-3" type="email" name="email" required><button class="btn btn-brand w-100">Send reset link</button>
</form></div></div></div></div></div>
@endsection
