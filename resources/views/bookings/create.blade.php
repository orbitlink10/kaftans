@extends('layouts.app')
@section('title', 'Book a Service')
@section('content')
<div class="container section"><div class="row justify-content-center"><div class="col-lg-9"><div class="card"><div class="card-body p-4">
<h1 class="h3 mb-3">Book a Service</h1>
<form method="post" action="{{ route('bookings.store') }}" enctype="multipart/form-data">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Category</label><select class="form-select" name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Service</label><select class="form-select" name="service_id" required>@foreach($services as $service)<option value="{{ $service->id }}">{{ $service->name }} - KES {{ number_format($service->base_price) }}</option>@endforeach</select></div>
<div class="col-md-12"><label class="form-label">Location</label><input class="form-control" name="location" value="{{ old('location', auth()->user()->location) }}" required></div>
<div class="col-md-4"><label class="form-label">Preferred date</label><input class="form-control" type="date" name="preferred_date" required></div>
<div class="col-md-4"><label class="form-label">Preferred time</label><input class="form-control" type="time" name="preferred_time" required></div>
<div class="col-md-4"><label class="form-label">Urgency</label><select class="form-select" name="urgency"><option value="normal">Normal</option><option value="same-day">Same-day</option><option value="emergency">Emergency</option></select></div>
<div class="col-md-6"><label class="form-label">Estimated price</label><input class="form-control" type="number" name="estimated_price" min="0" step="1"></div>
<div class="col-md-6"><label class="form-label">Images</label><input class="form-control" type="file" name="images[]" multiple accept="image/*"></div>
<div class="col-12">
    <label class="form-label">Upload video</label>
    <input class="form-control" type="file" name="video" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm">
    <div class="form-text">Optional. Upload one video up to 50 MB to show the work area or service details.</div>
</div>
<div class="col-12"><label class="form-label">Description of work</label><textarea class="form-control" name="description" rows="4"></textarea></div>
</div><button class="btn btn-brand mt-3">Submit Booking</button>
</form></div></div></div></div></div>
@endsection
