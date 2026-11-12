@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('dashboard-title', 'Dashboard')
@section('dashboard-subtitle', 'Track bookings, providers, payments and service activity.')
@section('dashboard-actions')
<div class="d-flex gap-2 flex-wrap">
    <a class="btn btn-outline-primary" href="{{ route('admin.products.list') }}">Products</a>
    <a class="btn btn-outline-primary" href="{{ route('admin.categories.index') }}">Categories</a>
    <a class="btn btn-outline-primary" href="{{ route('admin.services.index') }}">Services</a>
    <a class="btn btn-outline-primary" href="{{ route('admin.providers.index') }}">Providers</a>
    <a class="btn btn-brand" href="{{ route('admin.reports.index') }}">Reports</a>
</div>
@endsection
@section('content')
<div class="row g-3 mb-4">
@foreach([['Total bookings',$totalBookings],['Pending',$pendingBookings],['Completed',$completedBookings],['Revenue','KES '.number_format($totalRevenue)],['Customers',$totalCustomers],['Providers',$totalProviders]] as $metric)
<div class="col-6 col-lg-2"><div class="card metric"><div class="card-body"><small class="text-muted">{{ $metric[0] }}</small><div class="h4 mb-0">{{ $metric[1] }}</div></div></div></div>
@endforeach
</div>
<div class="card"><div class="card-body"><h2 class="h5">Recent Bookings</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>No.</th><th>Customer</th><th>Service</th><th>Provider</th><th>Status</th><th></th></tr></thead><tbody>
@foreach($recentBookings as $booking)<tr><td>{{ $booking->booking_number }}</td><td>{{ $booking->customer->name }}</td><td>{{ $booking->service->name }}</td><td>{{ $booking->provider->name ?? 'Unassigned' }}</td><td class="status">{{ $booking->status }}</td><td><a href="{{ route('bookings.show',$booking) }}">View</a></td></tr>@endforeach
</tbody></table></div></div></div>
@endsection
