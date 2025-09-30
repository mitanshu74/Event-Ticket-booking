<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Domain\Api\Request\editEventRequest;
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
            $imagePath = $request->file('EventImage')->store('events', 'public');
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
        $event = Event::findOrFail($id);
        return view('Admin.edit_Event', compact('event'));
    }

    public function update(editEventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);
        $validated = $request->validated();

        // Handle image
        if ($request->hasFile('EventImage')) {
            if ($event->image && file_exists(storage_path('app/public/' . $event->image))) {
                unlink(storage_path('app/public/' . $event->image));
            }
            $validated['image'] = $request->file('EventImage')->store('events', 'public');
        } else {
            $validated['image'] = $event->image;
        }

        $event->update($validated);

        return redirect()->route('admin.manageEvent')
            ->with('Add-Event', 'Event updated successfully!');
    }



    public function destroy(Event $id)
    {
        if ($id) {
            $id->delete();
            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        } else {
            return response()->json(['success' => true, 'message' => 'Event not found.']);
        }
    }
}
