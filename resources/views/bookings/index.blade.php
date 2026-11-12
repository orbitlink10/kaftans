@extends('layouts.app')
@section('title', 'Bookings')
@section('content')
<div class="container section"><div class="d-flex justify-content-between mb-3"><h1 class="h3">Bookings</h1><a class="btn btn-brand" href="{{ route('bookings.create') }}">New Booking</a></div>
<div class="card"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>No.</th><th>Service</th><th>Customer</th><th>Status</th><th>Payment</th><th></th></tr></thead><tbody>
@foreach($bookings as $booking)<tr><td>{{ $booking->booking_number }}</td><td>{{ $booking->service->name }}</td><td>{{ $booking->customer->name }}</td><td>{{ $booking->status }}</td><td>{{ $booking->payments->last()->status ?? 'unpaid' }}</td><td><a href="{{ route('bookings.show',$booking) }}">View</a></td></tr>@endforeach
</tbody></table></div></div><div class="mt-3">{{ $bookings->links() }}</div></div>
@endsection
