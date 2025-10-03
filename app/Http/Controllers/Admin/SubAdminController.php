<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\AddSubAdminRequest;
use App\Domain\Api\Request\editSubAdminRequest;
use App\Domain\Datatables\SubAdminDataTable;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubAdminPasswordMail;

class SubAdminController extends Controller
{
    public function index(SubAdminDataTable $datatable)
    {
        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('Admin.ManageSubAdmin', [
            'html' => $datatable->html(),
        ]);
    }

    public function create()
    {
        return view('Admin.add_subadmin');
    }

    public function store(AddSubAdminRequest $request)
    {
        $validated = $request->validated();

        // Generate random password
        $randomPassword = Str::random(10);

        $subAdmin = Admin::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($randomPassword),
        ]);

        // Send email with password
        Mail::to($subAdmin->email)->send(new SubAdminPasswordMail($subAdmin, $randomPassword));

        return redirect()->route('admin.manageSubAdmin')
            ->with('add_subAdmin', 'SubAdmin created successfully! Password has been sent to email.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('Admin.edit_SubAdmin', compact('admin'));
    }

    public function update(editSubAdminRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validated();

        $admin->update($validated);

        return redirect()->route('admin.manageSubAdmin')
            ->with('Update-SubAdmin', 'SubAdmin updated successfully!');
    }

    public function destroy(Admin $id)
    {
        if ($id) {
            $id->delete();
            return response()->json(['success' => true, 'message' => 'SubAdmin deleted successfully.']);
        } else {
            return response()->json(['success' => true, 'message' => 'Event not found.']);
        }
    }
}
