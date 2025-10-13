<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\UpdateProfileRequest;
use App\Domain\Api\Request\LoginRequest;
use App\Domain\Datatables\UserDataTable;
use App\Models\Admin;
use App\Models\booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function show_login()
    {
        return view('Admin.login');
    }

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

    public function home(UserDataTable $datatable)
    {
        if (request()->ajax()) {
            return $datatable->query();
        }

        $totalUser = User::count();
        $totalSubAdmin = Admin::where('role', 2)->count();
        $totalevent = Event::count();
        $totalbooking = booking::count();
        return view('Admin.home', ['html' => $datatable->html()], compact('totalSubAdmin', 'totalevent', 'totalbooking', 'totalUser'));
    }

    public function profile()
    {
        return view('Admin.profile');
    }

    public function ProfileUpdate(UpdateProfileRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        $admin->name = $request->name;
        $admin->email = $request->email;

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->back()->with('profile-updated', 'Profile updated successfully!');
    }

    public function logout()
    {
        // dd('d');
        Auth::guard('admin')->logout();
        return redirect('/admin/login')->with('logout_message', 'You have been successfully logged out.');
    }

    // guard define karelu hase to J logout kam karse
    // guard required for logout
    public function guard()
    {
        return Auth::guard('admin');
    }

    // user delete
    public function destroy(User $id)
    {
        // Delete user image if exists
        if ($id->image && file_exists(storage_path('app/public/' . $id->image))) {
            unlink(storage_path('app/public/' . $id->image));
        }

        $id->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}