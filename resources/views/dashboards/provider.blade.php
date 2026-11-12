@extends('layouts.dashboard')
@section('title', 'Provider Dashboard')
@section('dashboard-title', 'Provider Dashboard')
@section('dashboard-subtitle', 'Manage assigned jobs, progress updates, earnings and ratings.')
@section('content')
<div class="row g-3 mb-4">
@foreach([['Accepted jobs',$acceptedJobs],['Completed jobs',$completedJobs],['Earnings','KES '.number_format($earnings)],['Rating',$provider?->rating ?? 'N/A']] as $metric)
<div class="col-6 col-lg-3"><div class="card metric"><div class="card-body"><small class="text-muted">{{ $metric[0] }}</small><div class="h4 mb-0">{{ $metric[1] }}</div></div></div></div>
@endforeach
</div>
<div class="card"><div class="card-body"><h2 class="h5">Assigned Jobs</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>No.</th><th>Customer</th><th>Service</th><th>Status</th><th>Actions</th></tr></thead><tbody>
@foreach($assignedJobs as $booking)<tr><td><a href="{{ route('bookings.show',$booking) }}">{{ $booking->booking_number }}</a></td><td>{{ $booking->customer->name }}</td><td>{{ $booking->service->name }}</td><td>{{ $booking->provider_status }}</td><td><form method="post" action="{{ route('provider.jobs.update',$booking) }}" class="d-flex gap-1 flex-wrap">@csrf @method('patch')<select class="form-select form-select-sm" name="action"><option value="accepted">Accept</option><option value="rejected">Reject</option><option value="on_the_way">On the way</option><option value="started">Started</option><option value="completed">Completed</option></select><button class="btn btn-sm btn-brand">Update</button></form></td></tr>@endforeach
</tbody></table></div></div></div>
@endsection
