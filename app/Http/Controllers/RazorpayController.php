<?php

namespace App\Http\Controllers;

use App\Domain\Api\Request\UserBookingRequest;
use App\Domain\Api\Request\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\Event;
use App\Models\booking;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('razorpay.index');
    }

    public function payment(UserBookingRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();
        $event = Event::find($data['event_id']);

        if (!$event) {
            return redirect()->back()->withErrors(['event_id' => 'Event not found']);
        }

        if ($event->date->isPast()) {
            return redirect()->back()->withErrors(['date' => 'This event has already occurred.']);
        }

        $existingTickets = booking::where('user_id', $user->id)
            ->where('event_id', $event->id)->where('status', 'confirmed')
            ->sum('tickets_booked');

        if ($existingTickets + $data['tickets_booked'] > 5) {
            return redirect()->back()->withErrors([
                'tickets_booked' => 'You cannot book more than 5 tickets for this event in total.'
            ]);
        }

        if ($event->total_tickets < $data['tickets_booked']) {
            return redirect()->back()->withErrors(['tickets_booked' => 'Tickets not available']);
        }

        $booking = booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'tickets_booked' => $data['tickets_booked'],
            'total_price' => $data['tickets_booked'] * $event->price,
            'status' => 'pending'
        ]);

        $event->total_tickets -= $data['tickets_booked'];
        $event->save();

        $amount = $booking->total_price; // total amount in ₹
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $amount * 100, // in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'name' => $user->username,
            'email' => $user->email,
            'phone' => $user->number,
            'amount' => $amount,
            'order_id' => $order['id'],
            'status' => 0
        ]);


        return view('razorpay.payment', [
            'orderId' => $order['id'],
            'name' => $payment->name,
            'email' => $payment->email,
            'phone' => $payment->phone,
            'amount' => $amount,
            'razorpayKey' => env('RAZORPAY_KEY'),
            //send event-id payment.blade file
            'event' => $event,
            'from_page' => request('from', 'event_details'), // page request handel

        ]);
    }

    public function success(PaymentRequest $request)
    {
        $validated = $request->validated();
        $payment = Payment::where('order_id', $validated['razorpay_order_id'])->first();

        if (!$payment) {
            return back()->with('error', 'Invalid payment record');
        }

        $payment->update([
            'razorpay_payment_id' => $validated['razorpay_payment_id'],
            'status' => 1
        ]);

        $booking = booking::find($payment->booking_id);
        if ($booking) {
            $booking->update(['status' => 'confirmed']);

            Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));
        }

        $fromPage = $request->input('from_page', 'event_details');

        if ($fromPage === 'ticket_booked') {
            return redirect()
                ->route('booked_ticket')
                ->with('success', 'Payment successfully ! Your booking has been confirmed.');
        }

        return redirect()
            ->route('user.home')
            ->with('success', 'Payment successfully! Your booking has been confirmed.');
    }

    public function redirectToPayment($bookingId)
    {
        $booking = booking::find($bookingId);

        if (!$booking) {
            return redirect()->back()->with(['error' => 'Event not found']);
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Booking is already paid or cancelled.');
        }

        $event = $booking->event; // Related event
        $user = $booking->user;   // Related user

        if (!$event) {
            return redirect()->back()->with(['error' => 'Event not found']);
        }

        if ($event->date->isPast()) {
            return redirect()->back()->with(['error' => 'This event has already occurred.']);
        }

        $existingTickets = booking::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->sum('tickets_booked');

        if ($existingTickets + $booking->tickets_booked > 5) {
            return redirect()->back()->with('error', 'You cannot book more than 5 tickets for this event in total.');
        }

        if ($event->total_tickets < $booking->tickets_booked) {
            return redirect()->back()->with('error', 'Tickets not available');
        }

        $amount = $booking->total_price;
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $amount * 100, // in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $payment = Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id' => $user->id,
                'name' => $user->username,
                'email' => $user->email,
                'phone' => $user->number,
                'amount' => $amount,
                'order_id' => $order['id'],
                'status' => 0
            ]
        );
        $event->total_tickets -= $booking->tickets_booked;
        $event->save();

        return view('razorpay.payment', [
            'orderId' => $order['id'],
            'name' => $payment->name, // Fixed typo here
            'email' => $payment->email,
            'phone' => $payment->phone,
            'amount' => $amount,
            'razorpayKey' => env('RAZORPAY_KEY'),
            'event' => $event,
            'from_page' => request('from', 'ticket_booked'), // page request handel
        ]);
    }
}
