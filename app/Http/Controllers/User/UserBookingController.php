<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\UserBookingRequest;
use App\Mail\BookingCancelledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\booking;
use App\Models\Event;

class UserBookingController extends Controller
{
    public function store(UserBookingRequest $request)
    {
        //  event booking no code razorpay  controller in payment method maa che  
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);


        // Optionally: add tickets back to event
        $event = Event::find($booking->event_id);
        if ($event) {
            $event->total_tickets += $booking->tickets_booked;
            // booking tbl mathi tickets_booked minus this aatle user pachi ticket book kari sake
            // $booking->tickets_booked -= $booking->tickets_booked;
            $event->save();
        }

        Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));

        // Optional: Refund logic or seat reversal here
        $booking->update(['status' => 'Cancelled']);

        return back()->with('user-booking-cansel', 'Booking cancelled successfully.');
    }
}
