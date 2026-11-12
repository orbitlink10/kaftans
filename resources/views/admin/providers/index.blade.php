@extends('layouts.app')
@section('title', 'Providers')
@section('content')
<div class="container section"><div class="d-flex justify-content-between mb-3"><h1 class="h3">Providers</h1><a class="btn btn-brand" href="{{ route('admin.providers.create') }}">Add Provider</a></div>
<div class="card"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Name</th><th>Phone</th><th>Category</th><th>Availability</th><th>Verification</th><th>Rating</th><th></th></tr></thead><tbody>
@foreach($providers as $provider)<tr><td>{{ $provider->name }}</td><td>{{ $provider->phone }}</td><td>{{ $provider->category->name ?? '-' }}</td><td>{{ $provider->availability_status }}</td><td>{{ $provider->verification_status }}</td><td>{{ $provider->rating }}</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.providers.edit',$provider) }}">Edit</a><form class="d-inline" method="post" action="{{ route('admin.providers.destroy',$provider) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div></div><div class="mt-3">{{ $providers->links() }}</div></div>
@endsection
