<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\domain\Admin\Request\MultiDeleteRequest;
use App\domain\Datatables\BookingDataTable;
use App\domain\Admin\Request\BookingRequest;
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
        return view('admin.booking.index', [
            'html' => $datatable->html(),
        ]);
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('admin.booking.create', compact('users', 'events'));
    }

    public function store(BookingRequest $request)
    {
        $validated = $request->persist();
        $validated['status'] = 'confirmed';
        $userId = $validated['user_id'];
        $eventId = $validated['event_id'];

        $event = Event::find($validated['event_id']);

        $existingTickets = booking::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->sum('tickets_booked');

        if ($existingTickets + $validated['tickets_booked'] > 5) {
            return redirect()->back()->withErrors([
                'tickets_booked' => 'You cannot book more than 5 tickets for this event in total.'
            ]);
        }

        // Check tickets are available 
        if ($event && $event->total_tickets >= $validated['tickets_booked']) {
            $event->total_tickets -= $validated['tickets_booked'];

            $event->save();

            $booking = booking::create($validated);
            // Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));

            return redirect()->route('booking.index')
                ->with('success', 'Booking Created Successfully!');
        }

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

    public function MultiDelete(MultiDeleteRequest $request)
    {
        $ids = $request->ids;

        Booking::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected bookings deleted successfully',
        ]);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully.',
        ]);
    }
}
