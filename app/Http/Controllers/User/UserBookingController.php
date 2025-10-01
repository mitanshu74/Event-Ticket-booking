<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\UserBookingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\booking;
use App\Models\Event;

class UserBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(UserBookingRequest $request)
    {
        // Get validated data
        $data = $request->validated();

        $event = Event::find($data['event_id']);

        // Fill additional data
        $data['user_id'] = Auth::id();
        $data['total_price'] = $data['tickets_booked'] * $event->price;
        $data['status'] = 'pending';

        // Save booking
        booking::create($data);


        return redirect()->route('home')
            ->with('confirm-order', 'order Confirm!');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Optional: Refund logic or seat reversal here
        $booking->update(['status' => 'Cancelled']);

        return back()->with('user-booking-cansel', 'Booking cancelled successfully.');
    }
}
