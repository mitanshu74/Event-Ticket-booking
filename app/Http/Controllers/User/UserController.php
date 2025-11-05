<?php

namespace App\Http\Controllers\User;

use App\Domain\Api\Request\UpdateUserProfileRequest;
use App\Domain\Api\Request\UserRegisterRequest;
use App\Domain\Api\Request\UserLoginRequest;
use App\Domain\Api\Request\VerifyOtpRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use App\Models\Event;
use App\Models\booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Client\Request as ClientRequest;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $events = Event::orderBy('id', 'asc')->get();

        return view('user.home', compact('events'));
    }

    public function eventDetails($id)
    {
        $event = Event::find($id);
        if ($event) {
            return view('user.event-details', compact('event'));
        } else {
            return redirect()->to(route('user.home') . '#events')->with('success', 'Event not Found');
        }
    }

    public function showRegisterForm()
    {
        return view('user.register');
    }

    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('UserImage')) {
            $imagePath = $request->file('UserImage')->store('users', 'public');
            $validated['image'] = $imagePath;
        }
        $validated['password'] = Hash::make($request->password);

        $otp = rand(100000, 999999);
        $validated['otp'] = $otp;
        $validated['otp_expires_at'] = Carbon::now()->addMinutes(10);

        $user = User::create($validated);

        Mail::to($user->email)->send(new WelcomeMail($user->username, $otp));

        session(['otp_email' => $user->email]);

        return redirect()->route('verify-otp')->with('success', 'Registration successful. Check your email for OTP.');
    }

    public function showVerifyForm()
    {
        $email = session('otp_email');
        return view('user.verifyOtp', compact('email'));
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::where('email', session('otp_email'))->first();

        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::guard('web')->login($user);

        return redirect()->route('user.home')->with('verify-otp', 'Otp Verify Successfully.');
    }



    public function resendOtp()
    {
        $user = User::where('email', session('otp_email'))->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinute(10);
            $user->save();

            Mail::to($user->email)->send(new WelcomeMail($user->username, $otp));

            return back()->with('success', 'OTP resent successfully.');
        }

        return back()->withErrors(['email' => 'No user found with this email.']);
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('user.login')
                ->withErrors(['email' => 'Invalid email.'])
                ->withInput();
        }


        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('user.home')
                ->with('login', 'Successfully logged in!');
        }

        return redirect()->route('user.login')
            ->withErrors(['password' => 'Invalid password.'])
            ->withInput();
    }

    public function booked_ticket(Request $request)
    {
        $userId = Auth::guard('web')->id();

        $bookings = booking::with('event')->where('user_id', $userId)->latest()->get();

        return view('user.ticket_booked', compact('bookings'));
    }

    public function view_profile()
    {
        return view('user.update_profile');
    }

    public function User_profile(UpdateUserProfileRequest $request)
    {
        $user = Auth::guard('web')->user();

        $user->username = $request->username;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->gender = $request->gender;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('UserImage')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $user->image = $request->file('UserImage')->store('users', 'public');
        }

        $user->save();

        return redirect()->back()->with('user_profile_update', 'Profile updated successfully!');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.home');
    }
}
