<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Admin\Request\SubAdminRequest;
use App\Http\Controllers\Controller;
use App\Domain\Datatables\SubAdminDataTable;
use Illuminate\Support\Str;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubAdminPasswordMail;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubAdminDataTable $datatable)
    {
        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('admin.subAdmin.index', [
            'html' => $datatable->html(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subAdmin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubAdminRequest $request)
    {
        $validated = $request->persist();

        $randomPassword = Str::random(10);

        $subAdmin = Admin::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($randomPassword),
        ]);

        Mail::to($subAdmin->email)->send(new SubAdminPasswordMail($subAdmin, $randomPassword));

        return redirect()->route('subadmin.index')
            ->with('success', 'SubAdmin created successfully ! Password has been sent to email.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->route('subadmin.index')->with('success', 'SubAdmin Not Found.');
        }

        return view('admin.subAdmin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubAdminRequest $request, string $id)
    {
        $admin = Admin::find($id);

        $validated = $request->persist();

        $admin->update($validated);

        return redirect()->route('subadmin.index')
            ->with('success', 'SubAdmin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $subadmin)
    {
        $subadmin->delete();
        return response()->json(['success' => true, 'message' => 'SubAdmin deleted successfully.']);
    }
}
