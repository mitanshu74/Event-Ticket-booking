<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Request\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show_login()
    {
        return view('admin.auth.login');
    }
    public function login(loginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Invalid email.'])
                ->withInput();
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.deshboard')
                ->with('login', 'Successfully logged in!');
        }

        return redirect()->route('admin.login')
            ->withErrors(['password' => 'Invalid password.'])
            ->withInput();
    }

    public function logout()
    {
        // dd('d');
        Auth::guard('admin')->logout();
        return redirect('/admin/login')->with('logout_message', 'You have been successfully logged out.');
    }

    // guard define karelu hase to J logout kam karse
    public function guard()
    {
        return Auth::guard('admin');
    }
}
