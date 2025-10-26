<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Datatables\EventDataTable;
use App\Domain\Api\Request\AddEventRequest;
use App\Domain\Api\Request\editEventRequest;
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

        $event = Event::create($validated);

        return response()->json(['status' => "success", 'event_id' => $event->id]);
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'file'   => 'required',
            'file.*' => 'mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'file.required' => 'Please upload at least one file.',
            'file.*.file'   => 'Only valid files are allowed.',
            'file.*.max'    => 'Each file must be less than 5MB.',
        ]);

        $event = Event::findOrFail($request->event_id);

        $imagePaths = $event->image ? json_decode($event->image, true) : [];

        $files = $request->file('file');
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $filename  = Str::random(20) . '.' . $extension;
            $InsertPath = 'events/' . $filename;

            // Resize & compress image
            $image = Image::read($file)
                ->resize(800, 600, fn($c) => $c->aspectRatio()->upsize());
            // aspectRatio() → using image size ochi karava end  stretched noo thai 800×600 aatli zise maa
            // upsize()      → using image size ochi hoi to vadharva mate 

            // file_put_contents(...) → saves the compressed image 
            file_put_contents(storage_path('app/public/events') . '/' . $filename, $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 70)));

            $imagePaths[] = $InsertPath;
        }

        // ✅ Save JSON in database
        $event->image = json_encode($imagePaths);
        $event->save();

        return response()->json(['status' => 'success']);
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
        $event = Event::findOrFail($id);

        $validated = $request->validated();
        $validated['start_time'] = date('H:i:s', strtotime($validated['start_time']));
        $validated['end_time']   = date('H:i:s', strtotime($validated['end_time']));

        // don't touch images here (handled by Dropzone separately)
        $validated['image'] = $event->image;

        $event->update($validated);

        return response()->json(['status' => 'success', 'event_id' => $event->id]);
    }

    // public function updateFile(Request $request)
    // {
    //     // dd($request->file);
    //     $request->validate([
    //         'file'   => 'required',
    //         'file.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
    //     ]);

    //     $event = Event::findOrFail($request->event_id);

    //     // Keep existing images
    //     $imagePaths = $event->image ? json_decode($event->image, true) : [];

    //     $imageMatch  = [] ;
    //     foreach($event->image as $value){
    //         if($request->file == $value){
    //             $imageMatch = $value;
    //         }
    //     }

    //     // Store new files
    //     foreach ($imageMatch as $file) {
    //         $imagePaths[] = $file->store('events', 'public');
    //     }

    //     $event->image = json_encode($imagePaths);
    //     $event->save();

    //     return response()->json([
    //         'status'  => 'success',
    //         'message' => 'Images updated successfully',
    //         'images'  => $imagePaths
    //     ]);
    // }

    public function updateFile(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'file.*'   => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $event = Event::findOrFail($request->event_id);

        $oldImages = $event->image ? json_decode($event->image, true) : [];

        $existingImages = $request->input('existing_images', []);

        $finalImages = [];

        // ✅ Keep only those old images that are still in existing_images
        foreach ($oldImages as $oldPath) {
            if (in_array($oldPath, $existingImages)) {
                $finalImages[] = $oldPath;
            } else {
                // Delete image file from storage if it's removed by user
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
        }

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {

                if ($file && $file->isValid()) {

                    $extension = strtolower($file->getClientOriginalExtension());
                    $filename  = Str::random(20) . '.' . $extension;
                    $relativePath = 'events/' . $filename;

                    // Resize & compress using Intervention Image
                    $image = Image::read($file)
                        ->resize(800, 600, fn($c) => $c->aspectRatio()->upsize());
                    // aspectRatio() → using image size ochi karava end  stretched noo thai 800×600 aatli zise maa
                    // upsize()      → using image size ochi hoi to vadharva mate 

                    // file_put_contents(...) → saves the compressed image 
                    file_put_contents(
                        storage_path('app/public/events') . '/' . $filename,
                        $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 70))
                    );

                    // ✅ Add compressed image path to finalImages array
                    $finalImages[] = $relativePath;
                }
            }
        }

        // Save updated images list to DB
        $event->image = json_encode($finalImages);
        $event->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Images updated successfully',
            'images'  => $finalImages
        ]);
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
