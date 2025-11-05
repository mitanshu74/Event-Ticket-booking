<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Api\Request\AddSubAdminRequest;
use App\Domain\Api\Request\EditSubAdminRequest;
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
        return view('admin.manageSubAdmin', [
            'html' => $datatable->html(),
        ]);
    }

    public function create()
    {
        return view('admin.add_subadmin');
    }

    public function store(AddSubAdminRequest $request)
    {
        $validated = $request->validated();

        $randomPassword = Str::random(10);

        $subAdmin = Admin::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($randomPassword),
        ]);

        Mail::to($subAdmin->email)->send(new SubAdminPasswordMail($subAdmin, $randomPassword));

        return redirect()->route('admin.manageSubAdmin')
            ->with('success', 'SubAdmin created successfully ! Password has been sent to email.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->route('admin.manageSubAdmin')->with('success', 'SubAdmin Not Found.');
        }

        return view('admin.edit_SubAdmin', compact('admin'));
    }

    public function update(EditSubAdminRequest $request, string $id)
    {
        $admin = Admin::find($id);

        $validated = $request->validated();

        $admin->update($validated);

        return redirect()->route('admin.manageSubAdmin')
            ->with('success', 'SubAdmin updated successfully!');
    }

    public function destroy(Admin $id)
    {
        $id->delete();
        return response()->json(['success' => true, 'message' => 'SubAdmin deleted successfully.']);
    }
}
