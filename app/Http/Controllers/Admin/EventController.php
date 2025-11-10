<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Admin\Request\EventRequest;
use App\Domain\Datatables\EventDataTable;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EventDataTable $datatable)
    {
        if (request()->ajax()) {
            return $datatable->query();
        }
        return view('admin.events.index', [
            'html' => $datatable->html(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $validated = $request->persist();

        $imageNames = $request->UploadImage($request->images);

        $validated['image'] = json_encode($imageNames);

        Event::create($validated);

        return redirect()->route('event.index')->with('success', 'Event created successfully !');
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
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('admin.deshboard')->with('success', 'Event Not Found.');
        }

        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(EventRequest $request,  $id)
    // {
    //     // dd($request->all());
    //     $event = Event::findOrFail($id);
    //     $validated = $request->persist();

    //     $validated['start_time'] = date('h:i A', strtotime($validated['start_time']));
    //     $validated['end_time']   = date('h:i A', strtotime($validated['end_time']));

    //     $oldImages = $event->image ? json_decode($event->image) : null;
    //     $existingImages = json_decode($request->existing_images ?? null);


    //     $finalImages = [];

    //     foreach ($oldImages as $oldPath) {
    //         if (in_array($oldPath, $existingImages)) {
    //             $finalImages[] = $oldPath;
    //         } else {
    //             Storage::disk('public')->delete($oldPath);
    //         }
    //     }

    //     if ($request->hasFile('image')) {
    //         foreach ($request->file('image') as $file) {
    //             if (!$file->isValid()) continue;

    //             $extension = $file->getClientOriginalExtension();
    //             $eventname = Str::slug($event->name);
    //             $filename = $eventname . '_' . Str::random(10) . '.' . $extension;

    //             $path = $file->storeAs('events', $filename, 'public');


    //             $image = Image::read($file)
    //                 ->resize(800, 600, fn($c) => $c->aspectRatio()->upsize());

    //             file_put_contents(
    //                 storage_path('app/public/events') . '/' . $filename,
    //                 $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 70))
    //             );

    //             $finalImages[] = $path;
    //         }
    //     }

    //     $validated['image'] = $finalImages;

    //     $event->update($validated);

    //     return redirect()->route('event.index')->with('success', 'Event Updated Successfully');
    // }


    public function update(EventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $validated = $request->persist();

        $oldImages = $event->image ? json_decode($event->image) : null;
        $existingImages = $request->existing_images ? json_decode($request->existing_images) : null;

        $finalImages = [];

        foreach ($oldImages as $oldPath) {
            if (in_array($oldPath, $existingImages, true)) {
                $finalImages[] = $oldPath;
            } else {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $imageNames = $request->UploadImage();
        $merged = array_merge($finalImages, $imageNames);

        $validated['image'] = $merged;

        $event->update($validated);

        return redirect()->route('event.index')->with('success', 'Event Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);
        if ($event->image) {
            $images = json_decode($event->image, true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        }
        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully.'
        ]);
    }
}
