<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\domain\Api\Request\bookingRequest;
use App\domain\Datatables\BookingDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Event;
use App\Models\booking;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(bookingdatatable $datatable)
    {

        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('Admin.Manage_booking', [
            'html' => $datatable->html(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('Admin.booking', compact('users', 'events'));
    }

    public function store(bookingRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'confirmed';

        // Find the event
        $event = Event::find($validated['event_id']);

        // Check if tickets are available 
        if ($event && $event->total_tickets >= $validated['tickets_booked']) {
            // Decrement total tickets
            $event->total_tickets -= $validated['tickets_booked'];
            $event->save();

            // Create booking
            booking::create($validated);

            return redirect()->route('booking.index')
                ->with('booking', 'Booking Created Successfully!');
        }

        // tickets Not available
        return redirect()->back()->withErrors(['tickets_booked' => 'tickets Not available.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function cancel($id)
    {
        $booking = booking::findOrFail($id);

        if ($booking->status === 'confirmed') {
            $booking->status = 'cancelled';
            $booking->save();

            // Optionally: add tickets back to event
            $event = Event::find($booking->event_id);
            if ($event) {
                $event->total_tickets += $booking->tickets_booked;
                $event->save();
            }

            return redirect()->back()->with('booking', 'Booking cancelled successfully!');
        }

        return redirect()->back()->with('error', 'Booking cannot be cancelled.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = booking::find($id);

        $booking->delete();
        return redirect()->back()->with('delete-booking', 'Booking deleted successfully.');
    }
}
