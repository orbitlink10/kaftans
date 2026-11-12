<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProviderRequest;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;

class ProviderController extends Controller
{
    public function index()
    {
        return view('admin.providers.index', [
            'providers' => Provider::with(['category', 'services', 'user'])->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.providers.form', [
            'provider' => new Provider(),
            'categories' => Category::orderBy('name')->get(),
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
            'users' => User::whereHas('role', fn ($q) => $q->where('name', 'provider'))->orderBy('name')->get(),
        ]);
    }

    public function store(StoreProviderRequest $request)
    {
        $data = $request->validated();
        $serviceIds = $data['service_ids'] ?? [];
        unset($data['service_ids'], $data['document']);

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('provider-documents', 'public');
        }

        $provider = Provider::create($data);
        $provider->services()->sync($serviceIds);

        return redirect()->route('admin.providers.index')->with('success', 'Provider saved.');
    }

    public function edit(Provider $provider)
    {
        return view('admin.providers.form', [
            'provider' => $provider->load('services'),
            'categories' => Category::orderBy('name')->get(),
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
            'users' => User::whereHas('role', fn ($q) => $q->where('name', 'provider'))->orderBy('name')->get(),
        ]);
    }

    public function update(StoreProviderRequest $request, Provider $provider)
    {
        $data = $request->validated();
        $serviceIds = $data['service_ids'] ?? [];
        unset($data['service_ids'], $data['document']);

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('provider-documents', 'public');
        }

        $provider->update($data);
        $provider->services()->sync($serviceIds);

        return redirect()->route('admin.providers.index')->with('success', 'Provider updated.');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();

        return back()->with('success', 'Provider deleted.');
    }
}
