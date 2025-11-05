<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Domain\Api\Request\EditEventRequest;
use App\Domain\Api\Request\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

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
        // dd($request->all());
        $validated = $request->validated();

        $validated['start_time'] = date('h:i A', strtotime($validated['start_time']));
        $validated['end_time']   = date('h:i A', strtotime($validated['end_time']));

        $imageNames = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {

                $extension = $file->getClientOriginalExtension();
                $eventname = Str::slug($validated['name']);
                $filename = $eventname . '_' . Str::random(10) . '.' . $extension;

                $path = $file->storeAs('events', $filename, 'public');

                $image = Image::read($file)
                    ->resize(800, 600, fn($c) => $c->aspectRatio()->upsize());

                file_put_contents(
                    storage_path('app/public/events') . '/' . $filename,
                    $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 70))
                );

                $imageNames[] = $path;
            }
        }

        $validated['image'] = json_encode($imageNames);

        Event::create($validated);

        return redirect()->route('admin.manageEvent')->with('success', 'Event created successfully !');
    }

    public function edit(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('admin.manageEvent')->with('success', 'Event Not Found.');
        }

        return view('admin.edit_Event', compact('event'));
    }

    public function update(EditEventRequest $request, $id)
    {
        // dd($request->all());
        $event = Event::findOrFail($id);
        $validated = $request->validated();


        $validated['start_time'] = date('h:i A', strtotime($validated['start_time']));
        $validated['end_time']   = date('h:i A', strtotime($validated['end_time']));

        $oldImages = $event->image ? json_decode($event->image) : null;
        $existingImages = json_decode($request->existing_images ?? null);


        $finalImages = [];

        foreach ($oldImages as $oldPath) {
            if (in_array($oldPath, $existingImages)) {
                $finalImages[] = $oldPath;
            } else {
                Storage::disk('public')->delete($oldPath);
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                if (!$file->isValid()) continue;

                $extension = $file->getClientOriginalExtension();
                $eventname = Str::slug($event->name);
                $filename = $eventname . '_' . Str::random(10) . '.' . $extension;

                $path = $file->storeAs('events', $filename, 'public');


                $image = Image::read($file)
                    ->resize(800, 600, fn($c) => $c->aspectRatio()->upsize());

                file_put_contents(
                    storage_path('app/public/events') . '/' . $filename,
                    $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 70))
                );

                $finalImages[] = $path;
            }
        }

        $validated['image'] = $finalImages;

        $event->update($validated);

        // return response()->json(['status' => 'success']);
        return redirect()->route('admin.manageEvent')->with('success', 'Event Updated Successfully');
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
