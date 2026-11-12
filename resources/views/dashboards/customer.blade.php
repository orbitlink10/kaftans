@extends('layouts.dashboard')
@section('title', 'Customer Dashboard')
@section('dashboard-title', 'My Bookings')
@section('dashboard-subtitle', 'Review bookings, payment status and completed service reviews.')
@section('dashboard-actions')
<a class="btn btn-brand" href="{{ route('bookings.create') }}">Book a Service</a>
@endsection
@section('content')
<div class="row g-3">
@forelse($bookings as $booking)
<div class="col-lg-6"><div class="card h-100"><div class="card-body">
<div class="d-flex justify-content-between"><h2 class="h5">{{ $booking->service->name }}</h2><span class="badge text-bg-light status">{{ $booking->status }}</span></div>
<p class="mb-1">{{ $booking->location }} on {{ $booking->preferred_date->format('d M Y') }} at {{ substr($booking->preferred_time,0,5) }}</p>
<p class="mb-2">Payment: {{ $booking->payments->last()->status ?? 'unpaid' }}</p>
<div class="d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('bookings.show',$booking) }}">Details</a><a class="btn btn-sm btn-outline-success" href="{{ route('bookings.create') }}">Rebook service</a>
@if($booking->status === 'pending')<form method="post" action="{{ route('bookings.destroy',$booking) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Cancel</button></form>@endif</div>
</div></div></div>
@empty <div class="col"><div class="alert alert-info">No bookings yet.</div></div>@endforelse
</div>
@endsection
