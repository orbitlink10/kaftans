@extends('layouts.app')
@section('title', 'Assign Provider')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-7"><div class="card"><div class="card-body p-4">
<h1 class="h3">Assign Provider</h1><p>{{ $booking->booking_number }} - {{ $booking->service->name }} for {{ $booking->customer->name }}</p>
<form method="post" action="{{ route('admin.assignments.update',$booking) }}">@csrf @method('patch')
<label class="form-label">Provider</label><select class="form-select mb-3" name="provider_id">@foreach($providers as $provider)<option value="{{ $provider->id }}">{{ $provider->name }} - {{ $provider->location }} - {{ $provider->rating }}</option>@endforeach</select>
<button class="btn btn-brand">Assign</button></form></div></div></div></div></div>
@endsection
