<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        abort_unless($booking->customer_id === auth()->id() && $booking->status === 'completed' && $booking->provider_id, 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking->review()->updateOrCreate(
            ['customer_id' => auth()->id()],
            [...$data, 'provider_id' => $booking->provider_id]
        );

        $booking->provider->update(['rating' => $booking->provider->reviews()->avg('rating') ?: 0]);

        return back()->with('success', 'Review submitted.');
    }
}
