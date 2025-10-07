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

        // Check event date
        if ($event->date->isPast()) {
            return redirect()->back()->withErrors(['date' => 'This event has already occurred.']);
        }

        // Check total tickets already booked by this user
        $existingTickets = booking::where('user_id', $user->id)
            ->where('event_id', $event->id)->where('status', 'confirmed')
            ->sum('tickets_booked');

        if ($existingTickets + $data['tickets_booked'] > 5) {
            return redirect()->back()->withErrors([
                'tickets_booked' => 'You cannot book more than 5 tickets for this event in total.'
            ]);
        }

        // Check if tickets are available
        if ($event->total_tickets < $data['tickets_booked']) {
            return redirect()->back()->withErrors(['tickets_booked' => 'Tickets not available']);
        }

        // --- Create  booking with panding data  ---
        $booking = booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'tickets_booked' => $data['tickets_booked'],
            'total_price' => $data['tickets_booked'] * $event->price,
            'status' => 'pending'
        ]);

        // Decrement available tickets
        $event->total_tickets -= $data['tickets_booked'];
        $event->save();

        // Razorpay Order 
        $amount = $booking->total_price; // total amount in ₹
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $amount * 100, // in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // Create Payment  
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


        // Open Razorpay Payment Page 
        return view('razorpay.payment', [
            'orderId' => $order['id'],
            'name' => $payment->name,
            'email' => $payment->email,
            'phone' => $payment->phone,
            'amount' => $amount,
            'razorpayKey' => env('RAZORPAY_KEY'),
            // // send event-id payment.blade file
            'event' => $event,
        ]);
    }

    public function success(PaymentRequest $request)
    {
        $validated = $request->validated();
        // Find payment record
        $payment = Payment::where('order_id', $validated['razorpay_order_id'])->first();

        if (!$payment) {
            return back()->with('error', 'Invalid payment record');
        }

        // Update payment
        $payment->update([
            'razorpay_payment_id' => $validated['razorpay_payment_id'],
            'status' => 1
        ]);

        // Confirm booking
        $booking = booking::find($payment->booking_id);
        if ($booking) {
            $booking->update(['status' => 'confirmed']);

            // Send booking confirmation email
            Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));
        }

        // 5️⃣ Redirect with success message
        return view('razorpay.success', [
            'payment' => $payment,
            'booking' => $booking,
            'event' => $booking->event
        ]);
    }
}
