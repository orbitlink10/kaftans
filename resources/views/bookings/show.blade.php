@extends('layouts.app')
@section('title', $booking->booking_number)
@section('content')
<div class="container section"><div class="row g-4"><div class="col-lg-8"><div class="card"><div class="card-body p-4">
<div class="d-flex justify-content-between"><h1 class="h3">{{ $booking->booking_number }}</h1><span class="badge text-bg-success status">{{ $booking->status }}</span></div>
<p class="lead">{{ $booking->service->name }} in {{ $booking->location }}</p>
<dl class="row"><dt class="col-sm-4">Customer</dt><dd class="col-sm-8">{{ $booking->customer->name }}</dd><dt class="col-sm-4">Provider</dt><dd class="col-sm-8">{{ $booking->provider->name ?? 'Unassigned' }}</dd><dt class="col-sm-4">Schedule</dt><dd class="col-sm-8">{{ $booking->preferred_date->format('d M Y') }} {{ substr($booking->preferred_time,0,5) }}</dd><dt class="col-sm-4">Urgency</dt><dd class="col-sm-8">{{ $booking->urgency }}</dd><dt class="col-sm-4">Estimate</dt><dd class="col-sm-8">KES {{ number_format($booking->estimated_price) }}</dd></dl>
<p>{{ $booking->description }}</p>
@if($booking->video_path)
    <div class="mt-4">
        <h2 class="h5">Uploaded Video</h2>
        <video class="w-100 rounded" controls preload="metadata">
            <source src="{{ asset('storage/'.$booking->video_path) }}">
            Your browser does not support the video tag.
        </video>
    </div>
@endif
@auth @if(auth()->user()->isRole(['admin','dispatcher']))<a class="btn btn-outline-primary" href="{{ route('admin.assignments.edit',$booking) }}">Assign Provider</a>@endif @endauth
</div></div></div>
<div class="col-lg-4"><div class="card mb-3"><div class="card-body"><h2 class="h5">M-Pesa Payment</h2><form method="post" action="{{ route('payments.mpesa',$booking) }}">@csrf <input class="form-control mb-2" name="phone_number" value="{{ auth()->user()->phone }}" placeholder="2547..."><input class="form-control mb-2" name="amount" value="{{ $booking->estimated_price }}"><button class="btn btn-brand w-100">Send STK Push</button></form></div></div>
@if($booking->status === 'completed' && $booking->customer_id === auth()->id() && ! $booking->review)<div class="card"><div class="card-body"><h2 class="h5">Review Provider</h2><form method="post" action="{{ route('reviews.store',$booking) }}">@csrf <select class="form-select mb-2" name="rating">@for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }}</option>@endfor</select><textarea class="form-control mb-2" name="comment" rows="3"></textarea><button class="btn btn-brand w-100">Submit Review</button></form></div></div>@endif
</div></div></div>
@endsection
