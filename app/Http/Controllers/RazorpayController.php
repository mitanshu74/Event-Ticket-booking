<?php

namespace App\Http\Controllers;

use App\Domain\Api\Request\UserBookingRequest;
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

        $userId = Auth::guard('web')->user();
        $eventId = $data['event_id'];

        $event = Event::find($data['event_id']);

        // Check event date
        if ($event->date->isPast()) {
            return redirect()->back()->withErrors(['date' => 'This event has already occurred.']);
        }

        // Check total tickets already booked by this user for this event
        $existingTickets = booking::where('user_id', $userId->id)
            ->where('event_id', $eventId)
            ->sum('tickets_booked');

        if ($existingTickets + $data['tickets_booked'] > 5) {
            return redirect()->back()->withErrors([
                'tickets_booked' => 'You cannot book more than 5 tickets for this event in total.'
            ]);
        }

        // Check if tickets are available 
        if ($event && $event->total_tickets >= $data['tickets_booked']) {

            // Fill additional data
            $data['user_id'] = Auth::guard('web')->id();
            $data['total_price'] = $data['tickets_booked'] * $event->price;
            $data['status'] = 'pending';

            // Save booking
            $booking = booking::create($data);

            // Decrement total tickets
            $event->total_tickets -= $data['tickets_booked'];
            $event->save();


            // Razorpay API Init
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // ✅ FIX: Clean amount (remove ₹ and convert to number)
            $amount = (int) filter_var($request->amount, FILTER_SANITIZE_NUMBER_INT);

            $order = $api->order->create([
                'receipt' => 'order_' . uniqid(),
                'amount' => $amount * 100, // razorpay takes amount in paise
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            // ✅ Taking Logged-in User Details
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::guard('web')->id(),
                'name' => Auth::guard('web')->user()->username,
                'email' => Auth::guard('web')->user()->email,
                'phone' => Auth::guard('web')->user()->number,
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
            ]);
        }

        // Tickets Not available
        return redirect()->back()->withErrors(['tickets_booked' => 'Tickets Not Available.']);
    }

    public function success(Request $request)
    {
        // 1️⃣ Validate Razorpay response
        if (!$request->razorpay_payment_id || !$request->razorpay_order_id) {
            return back()->with('error', 'Payment failed. Please try again.');
        }

        // 2️⃣ Find the payment record
        $payment = Payment::where('order_id', $request->razorpay_order_id)->first();
        if (!$payment) {
            return back()->with('error', 'Invalid payment record.');
        }

        // 3️⃣ Mark payment as successful
        $payment->update([
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'status' => 1
        ]);

        // 4️⃣ Update the booking status if linked
        if ($payment->booking_id) {
            $booking = booking::with('user', 'event')->find($payment->booking_id);
            if ($booking) {
                $booking->update(['status' => 'confirmed']);

                // 5️⃣ Send email to the user who made the booking
                Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));
            }
        }

        // 6️⃣ Redirect with success message
        return redirect('/razorpay')->with([
            'success' => 'Payment Successful!',
            'payment' => $payment
        ]);
    }
}
