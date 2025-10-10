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

        // Add tickets back to event
        $event = Event::find($booking->event_id);
        if ($event) {
            $event->total_tickets += $booking->tickets_booked;
            $event->save();
        }

        Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));
        $booking->update(['status' => 'Cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
