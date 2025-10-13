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

    public function cancel(Booking $id)
    {
        // Add tickets back to event
        $event = Event::find($id->event_id);
        if ($event) {
            $event->total_tickets += $id->tickets_booked;
            $event->save();
        }

        Mail::to($id->user->email)->send(new BookingCancelledMail($id));
        $id->update(['status' => 'Cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
