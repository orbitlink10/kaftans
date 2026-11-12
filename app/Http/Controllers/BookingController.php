<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $query = Booking::with(['customer', 'service', 'provider', 'payments'])->latest();

        if (auth()->user()->isRole('customer')) {
            $query->where('customer_id', auth()->id());
        }

        return view('bookings.index', ['bookings' => $query->paginate(20)]);
    }

    public function create()
    {
        return view('bookings.create', [
            'categories' => Category::where('is_active', true)->with('services')->orderBy('name')->get(),
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $service = Service::findOrFail($request->integer('service_id'));
        $bookingData = $request->safe()->except(['images', 'video']);

        if ($request->hasFile('video')) {
            $bookingData['video_path'] = $request->file('video')->store('booking-videos', 'public');
        }

        $booking = Booking::create([
            ...$bookingData,
            'customer_id' => auth()->id(),
            'booking_number' => 'LAS-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
            'estimated_price' => $request->input('estimated_price') ?: $service->base_price,
        ]);

        foreach ($request->file('images', []) as $image) {
            $booking->images()->create(['path' => $image->store('booking-images', 'public')]);
        }

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking submitted.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('bookings.show', [
            'booking' => $booking->load(['customer', 'category', 'service', 'provider', 'images', 'payments', 'review']),
        ]);
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }
}
