
<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Domain\Api\Request\EditEventRequest;
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
        return view('admin.manage_event', [
            'html' => $datatable->html(),
        ]);
    }

    public function create()
    {
        return view('admin.add_event');
    }

    public function store(AddEventRequest $request)
    {
        $validated = $request->validated();

        $validated['start_time'] = date('H:i:s', strtotime($validated['start_time']));
        $validated['end_time']   = date('H:i:s', strtotime($validated['end_time']));

        if ($request->hasFile('EventImages')) {
            $imagePaths = [];
            foreach ($request->file('EventImages') as $image) {
                $path = $image->store('events', 'public');
                $imagePaths[] = $path;
            }
            $validated['image'] = json_encode($imagePaths);
        }
        Event::create($validated);

        return redirect()->route('admin.manageEvent')
            ->with('success', 'Event added successfully!');
    }

    public function edit(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('admin.manageEvent')->with('success', 'Event Not Found.');
        }

        return view('admin.edit_Event', compact('event'));
    }


    public function update(EditEventRequest $request, string $id)
    {
        $event = Event::find($id);

        $validated = $request->validated();
        $validated['start_time'] = date('H:i:s', strtotime($validated['start_time']));
        $validated['end_time']   = date('H:i:s', strtotime($validated['end_time']));

        $existingImages = $event->image ? json_decode($event->image, true) : [];
        if ($request->hasFile('EventImages')) {

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
            $validated['image'] = $event->image;
        }
        $event->update($validated);

        return redirect()->route('admin.manageEvent')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $id)
    {
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
