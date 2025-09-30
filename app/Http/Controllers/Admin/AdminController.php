<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\LoginRequest;
use App\Domain\Api\Request\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Invalid email.'])
                ->withInput();
        }

        // Attempt login
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home')
                ->with('login', 'Successfully logged in!');
        }

        return redirect()->route('admin.login')
            ->withErrors(['password' => 'Invalid password.'])
            ->withInput();
    }

    public function profile()
    {
        return view('Admin.profile');
    }


    public function ProfileUpdate(UpdateProfileRequest $request)
    {
        $admin = auth('admin')->user();

        $admin->name = $request->name;
        $admin->email = $request->email;

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->back()->with('profile-updated', 'Profile updated successfully!');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/admin/login')->with('logout_message', 'You have been successfully logged out.');
    }
    // guard define karelu hase to J logout kam karse
    // guard required for logout
    public function guard()
    {
        return Auth::guard('admin');
    }
}
