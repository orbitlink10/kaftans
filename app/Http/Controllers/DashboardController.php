<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->isRole(['admin', 'dispatcher'])) {
            return view('dashboards.admin', [
                'totalBookings' => Booking::count(),
                'pendingBookings' => Booking::where('status', 'pending')->count(),
                'completedBookings' => Booking::where('status', 'completed')->count(),
                'totalRevenue' => Payment::where('status', 'paid')->sum('amount'),
                'totalCustomers' => User::whereHas('role', fn ($q) => $q->where('name', 'customer'))->count(),
                'totalProviders' => Provider::count(),
                'recentBookings' => Booking::with(['customer', 'service', 'provider'])->latest()->take(8)->get(),
                'payments' => Payment::with('booking')->latest()->take(8)->get(),
            ]);
        }

        if ($user->isRole('provider')) {
            $provider = $user->provider;

            return view('dashboards.provider', [
                'provider' => $provider,
                'assignedJobs' => $provider?->bookings()->with(['customer', 'service'])->latest()->get() ?? collect(),
                'acceptedJobs' => $provider?->bookings()->where('provider_status', 'accepted')->count() ?? 0,
                'completedJobs' => $provider?->bookings()->where('status', 'completed')->count() ?? 0,
                'earnings' => Payment::whereHas('booking', fn ($q) => $q->where('provider_id', $provider?->id))->where('status', 'paid')->sum('amount'),
            ]);
        }

        return view('dashboards.customer', [
            'bookings' => $user->bookings()->with(['service', 'provider', 'payments', 'review'])->latest()->get(),
        ]);
    }
}
