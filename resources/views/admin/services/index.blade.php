@extends('layouts.app')
@section('title', 'Services')
@section('content')
<div class="container section"><div class="d-flex justify-content-between mb-3"><h1 class="h3">Services</h1><a class="btn btn-brand" href="{{ route('admin.services.create') }}">Add Service</a></div>
<div class="card"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Unit</th><th>Status</th><th></th></tr></thead><tbody>
@foreach($services as $service)<tr><td>{{ $service->name }}</td><td>{{ $service->category->name }}</td><td>KES {{ number_format($service->base_price) }}</td><td>{{ $service->unit_type }}</td><td>{{ $service->is_active ? 'Active' : 'Inactive' }}</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.services.edit',$service) }}">Edit</a><form class="d-inline" method="post" action="{{ route('admin.services.destroy',$service) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div></div><div class="mt-3">{{ $services->links() }}</div></div>
@endsection
