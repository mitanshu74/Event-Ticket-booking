<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(EventDataTable $datatable)
    {

        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('Admin.manage_event', [
            'html' => $datatable->html(),
        ]);
    }

    public function create()
    {
        return view('Admin.add_event');
    }

    public function store(AddEventRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('EventImage')) {
            $imagePath = $request->file('EventImage')->store('events');
            $validated['image'] = $imagePath;
        }

        Event::create($validated);

        return redirect()->route('admin.manageEvent')
            ->with('Add-Event', 'Event added successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
