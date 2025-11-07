<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Request\UpdateProfileRequest;
use App\Domain\Datatables\UserDataTable;
use App\Models\Admin;
use App\Models\booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function deshboard(UserDataTable $datatable)
    {
        if (request()->ajax()) {
            return $datatable->query();
        }

        $totalUser = User::count();
        $totalSubAdmin = Admin::where('role', 2)->count();
        $totalevent = Event::count();
        $totalbooking = booking::count();
        return view('admin.user.deshboard', ['html' => $datatable->html()], compact('totalSubAdmin', 'totalevent', 'totalbooking', 'totalUser'));
    }

    public function profile()
    {
        return view('admin.auth.profile');
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



    public function destroy(User $id)
    {
        if ($id->image && file_exists(storage_path('app/public/' . $id->image))) {
            unlink(storage_path('app/public/' . $id->image));
        }

        $id->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
