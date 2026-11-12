<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Provider;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['service.category', 'provider', 'payments'])
            ->when($request->date_from, fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->category_id, fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->provider_id, fn ($q) => $q->where('provider_id', $request->provider_id))
            ->when($request->booking_status, fn ($q) => $q->where('status', $request->booking_status))
            ->when($request->payment_status, fn ($q) => $q->whereHas('payments', fn ($payments) => $payments->where('status', $request->payment_status)))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $paymentQuery = Payment::whereIn('booking_id', $bookings->pluck('id'));

        return view('admin.reports.index', [
            'bookings' => $bookings,
            'categories' => Category::orderBy('name')->get(),
            'providers' => Provider::orderBy('name')->get(),
            'revenue' => (clone $paymentQuery)->where('status', 'paid')->sum('amount'),
            'paymentStatus' => $request->payment_status,
        ]);
    }
}
