<?php

namespace App\Http\Controllers\User;

use App\Domain\Api\Request\UpdateUserProfileRequest;
use App\Domain\Api\Request\UserRegisterRequest;
use App\Domain\Api\Request\UserLoginRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('User.register');
    }


    public function eventDetails($id)
    {
        $event = Event::findOrFail($id);
        return view('User.event-details', compact('event'));
    }


    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        // $imagePath = null;

        // Handle image upload
        if ($request->hasFile('UserImage')) {
            $imagePath = $request->file('UserImage')->store('users', 'public');
            $validated['image'] = $imagePath;
        }
        $validated['password'] = Hash::make($request->password);

        // Generate OTP and expiry
        $otp = rand(100000, 999999);
        $validated['otp'] = $otp;
        $validated['otp_expires_at'] = Carbon::now()->addMinutes(10);

        $user = User::create($validated);

        // Send OTP via email
        Mail::to($user->email)->send(new WelcomeMail($user->username, $otp));

        session(['otp_email' => $user->email]);

        return redirect()->route('verify-otp')->with('success', 'Registration successful. Check your email for OTP.');
    }


    public function showVerifyForm()
    {
        $email = session('otp_email'); // get from session
        return view('User.verifyOtp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', session('otp_email'))->first();

        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('home');
    }

    public function showLoginForm()
    {
        return view('User.login');
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

        // Attempt login
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')
                ->with('login', 'Successfully logged in!');
        }

        return redirect()->route('user.login')
            ->withErrors(['password' => 'Invalid password.'])
            ->withInput();
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

    public function home(Request $request)
    {
        $events = Event::orderBy('date', 'asc')->get();

        return view('User.home', compact('events'));
    }

    public function User_profile(Request $request)
    {
        $user = Auth::user()->load('bookings.event');
        return view('User.user_profile', compact('user'));
    }
    public function Update_User_profile(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();

        $user->username = $request->username;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->gender = $request->gender;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update image if uploaded
        if ($request->hasFile('UserImage')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Corrected assignment
            $user->image = $request->file('UserImage')->store('users', 'public');
        }

        $user->save();

        return redirect()->back()->with('user_profile_update', 'Profile updated successfully!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function show_profile(Request $request)
    {
        return view('User.update_profile');
    }
}
