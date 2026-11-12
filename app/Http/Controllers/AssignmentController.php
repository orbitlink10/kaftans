<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Provider;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function edit(Booking $booking)
    {
        return view('admin.assignments.edit', [
            'booking' => $booking->load(['customer', 'service']),
            'providers' => Provider::where('verification_status', 'approved')->where('availability_status', 'available')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate(['provider_id' => ['required', 'exists:providers,id']]);

        $booking->update([
            'provider_id' => $data['provider_id'],
            'status' => 'assigned',
            'provider_status' => 'pending',
            'assigned_at' => now(),
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Provider assigned.');
    }

    public function providerAction(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $data = $request->validate([
            'action' => ['required', 'in:accepted,rejected,on_the_way,started,completed'],
        ]);

        $status = match ($data['action']) {
            'started' => 'in_progress',
            'completed' => 'completed',
            default => $booking->status,
        };

        $booking->update([
            'provider_status' => $data['action'],
            'status' => $status,
            'completed_at' => $data['action'] === 'completed' ? now() : $booking->completed_at,
        ]);

        return back()->with('success', 'Job status updated.');
    }
}
