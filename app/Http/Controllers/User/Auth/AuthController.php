<?php

namespace App\Http\Controllers\User\Auth;

use App\Domain\User\Request\UserLoginRequest;
use App\Domain\User\Request\UserRequest;
use App\Domain\User\Request\VerifyOtpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('user.auth.register');
    }

    public function register(UserRequest $request)
    {
        $validated = $request->persist();

        if ($request->hasFile('UserImage')) {
            $imagePath = $request->file('UserImage')->store('users', 'public');
            $validated['image'] = $imagePath;
        }
        $validated['password'] = Hash::make($validated['password']);

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
        return view('user.auth.verifyOtp', compact('email'));
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $validated = $request->persist();

        $user = User::where('email', session('otp_email'))->first();

        if (!$user || $user->otp !== $validated['otp'] || $user->otp_expires_at < now()) {
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
        return view('user.auth.login');
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->persist();

        $user = User::where('email', $credentials['email'])->first();

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

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.home');
    }
}
