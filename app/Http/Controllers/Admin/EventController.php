<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Domain\Api\Request\editEventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

        // Keep MySQL-friendly 24-hour format
        $validated['start_time'] = date('H:i:s', strtotime($validated['start_time']));
        $validated['end_time']   = date('H:i:s', strtotime($validated['end_time']));

        if ($request->hasFile('EventImages')) {
            $imagePaths = [];
            foreach ($request->file('EventImages') as $image) {
                $path = $image->store('events', 'public');
                $imagePaths[] = $path;
            }
            // Save as JSON in database
            $validated['image'] = json_encode($imagePaths);
        }
        Event::create($validated);

        return redirect()->route('admin.manageEvent')
            ->with('success', 'Event added successfully!');
    }

    public function edit(string $id)
    {
        $event = Event::find($id); // fetch the event

        if (!$event) {
            return redirect()->route('admin.manageEvent')->with('success', 'Event Not Found.');
        }

        return view('Admin.edit_Event', compact('event'));
    }


    public function update(editEventRequest $request, string $id)
    {
        $event = Event::find($id);

        $validated = $request->validated();
        $validated['start_time'] = date('H:i:s', strtotime($validated['start_time']));
        $validated['end_time']   = date('H:i:s', strtotime($validated['end_time']));

        $existingImages = $event->image ? json_decode($event->image, true) : [];
        if ($request->hasFile('EventImages')) {
            // Delete old images if you want to replace them
            foreach ($existingImages as $oldImage) {
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $imagePaths = [];
            foreach ($request->file('EventImages') as $image) {
                $imagePaths[] = $image->store('events', 'public');
            }
            $validated['image'] = json_encode($imagePaths);
        } else {
            // Keep old images if no new images uploaded
            $validated['image'] = $event->image;
        }
        $event->update($validated);

        return redirect()->route('admin.manageEvent')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $id)
    {
        // Delete all images if exist
        if ($id->image) {
            $images = json_decode($id->image, true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        }
        $id->delete();
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully.'
        ]);
    }
}
