<?php

namespace App\Http\Controllers\User;

use App\Domain\User\Request\UserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\booking;


class UserController extends Controller
{
    public function home(Request $request)
    {
        $events = Event::orderBy('id', 'asc')->get();

        return view('user.home.index', compact('events'));
    }

    public function eventDetails($id)
    {
        $event = Event::find($id);
        if ($event) {
            return view('user.event.event-details', compact('event'));
        } else {
            return redirect()->to(route('user.home') . '#events')->with('success', 'Event not Found');
        }
    }



    public function booked_ticket(Request $request)
    {
        $userId = Auth::guard('web')->id();

        $bookings = booking::with('event')->where('user_id', $userId)->latest()->get();

        return view('user.event.ticket_booked', compact('bookings'));
    }

    public function view_profile()
    {
        return view('user.home.update_profile');
    }

    public function User_profile(UserRequest $request)
    {
        $user = Auth::guard('web')->user();

        $validated = $request->persist();
        // dd($request->all());
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('UserImage')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = $request->file('UserImage')->store('users', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('user_profile_update', 'Profile updated successfully!');
    }
}
