<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\domain\Api\Request\MultiDeleteRequest;
use App\domain\Datatables\BookingDataTable;
use App\domain\Api\Request\bookingRequest;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelledMail;
use Illuminate\Http\Request;
use App\Models\booking;
use App\Models\Event;
use App\Models\User;

class BookingController extends Controller
{

    public function index(bookingdatatable $datatable)
    {

        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('Admin.Manage_booking', [
            'html' => $datatable->html(),
        ]);
    }

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
        $userId = $validated['user_id'];
        $eventId = $validated['event_id'];
        // Find the event
        $event = Event::find($validated['event_id']);

        // Check total tickets already booked by this user for this event
        $existingTickets = booking::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->sum('tickets_booked');

        if ($existingTickets + $validated['tickets_booked'] > 5) {
            return redirect()->back()->withErrors([
                'tickets_booked' => 'You cannot book more than 5 tickets for this event in total.'
            ]);
        }
        // Check if tickets are available 
        if ($event && $event->total_tickets >= $validated['tickets_booked']) {
            // Decrement total tickets
            $event->total_tickets -= $validated['tickets_booked'];
            $event->save();

            // Create booking
            $booking = booking::create($validated);
            // send mail
            Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));

            return redirect()->route('booking.index')
                ->with('success', 'Booking Created Successfully!');
        }

        // tickets Not available
        return redirect()->back()->withErrors(['tickets_booked' => 'tickets Not available.']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function cancel($id)
    {
        $booking = booking::find($id);

        if (!$booking) {
            return redirect()->route('booking.index')->with('Error', 'Booked Ticket Not Found.');
        }
        if ($booking->status === 'confirmed') {
            $booking->status = 'cancelled';
            $booking->save();

            // Optionally: add tickets back to event
            $event = Event::find($booking->event_id);
            if ($event) {
                $event->total_tickets += $booking->tickets_booked;
                $event->save();
            }
            Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));

            return redirect()->back()->with('success', 'Booking cancelled successfully!');
        }

        return redirect()->back()->with('error', 'Booking cannot be cancelled.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }

    public function MultiDelete(MultiDeleteRequest $request)
    {
        $ids = $request->ids;

        
        Booking::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected bookings deleted successfully',
        ]);
    }
}
