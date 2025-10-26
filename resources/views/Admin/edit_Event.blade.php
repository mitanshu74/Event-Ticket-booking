@extends('Admin.layout.partials.master')
@section('title', 'Admin - Edit Event')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form id="demoform" method="POST" action="{{ route('admin.UpdateEvent', $event->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="col-md-6 mt-3 mx-3">
                                <label for="Name" class="form-label"><b>Name</b></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="Name" placeholder="Enter Event Name"
                                    value="{{ old('name', $event->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3 mx-3">
                                <label for="Date" class="form-label"><b>Date</b></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" id="Date" value="{{ old('date', $event->date->format('Y-m-d')) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                        name="start_time" id="start_time"
                                        value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('h:i')) }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3 mx-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                        name="end_time" id="end_time"
                                        value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('h:i')) }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-3 mx-3">
                                <label for="Location" class="form-label"><b>Location</b></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" id="Location" placeholder="Enter Event Location"
                                    value="{{ old('location', $event->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3 mx-3">
                                <label for="total_tickets" class="form-label"><b>Tickets</b></label>
                                <input type="number" class="form-control @error('total_tickets') is-invalid @enderror"
                                    name="total_tickets" id="total_tickets" placeholder="Enter Event Tickets"
                                    value="{{ old('total_tickets', $event->total_tickets) }}">
                                @error('total_tickets')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3 mx-3">
                                <label for="price" class="form-label"><b>Price</b></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    name="price" id="price" placeholder="Enter Event Price"
                                    value="{{ old('price', $event->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="row mx-3">
                                    <label for="Image" class="form-label"><b>Image</b></label>
                                    <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                        <span>Drag & drop or click to upload</span>
                                        <div class="dropzone-previews"></div>
                                    </div>
                                    <p class="error-image text-danger"></p>
                                </div>

                                {{-- Hidden input to store event id --}}
                                <input type="hidden" id="event_id" value="{{ $event->id }}">
                                <div id="removedImagesContainer"></div>

                            </div>

                            <div class="row mt-3 mx-3">
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(function() {
            const csrfToken = $('input[name="_token"]').val();
            const eventIdField = $("#event_id");
            const eventForm = $("#demoform");

            // Initialize Dropzone for event images
            const showImageDropzone = new Dropzone("#dropzoneDragArea", {
                url: "{{ route('update_File') }}",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5, // MB
                paramName: "file",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                addRemoveLinks: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif"

            });

            // Existing images for the event
            let existingEventImages = @json(json_decode($event->image ?? '[]', true));
            // @-json converts the PHP array into a JavaScript array

            //  show existing images in Dropzone
            existingEventImages.forEach(imagePath => {
                const showfile = {
                    name: imagePath.split('/').pop(),
                    size: 12345,
                    accepted: true,
                    existing: true,
                    path: imagePath
                };
                showImageDropzone.emit("addedfile", showfile);
                showImageDropzone.emit("thumbnail", showfile, "{{ asset('storage') }}/" + imagePath);
                showImageDropzone.emit("complete", showfile);
                showImageDropzone.files.push(showfile);
            });

            // Only remove files that were already uploaded before
            showImageDropzone.on("removedfile", function(file) {
                if (file.existing) {
                    existingEventImages = existingEventImages.filter(function(path) {
                        return path !== file.path; // keep all paths except the removed one
                    });
                }
            });

            // Append event ID and existing images before upload

            // file      → the file that is currently being uploaded.
            // xhr       → the XMLHttpRequest object for this upload.
            // formData  → the FormData object that will be sent to the server.
            showImageDropzone.on("sending", (file, xhr, formData) => {
                formData.append("event_id", eventIdField.val());
                existingEventImages.forEach(image => formData.append("existing_images[]", image));
            });

            // Handle event form submission
            eventForm.on("submit", event => {
                event.preventDefault();

                const newImagesCount = showImageDropzone.getQueuedFiles().length;
                const oldImagesCount = showImageDropzone.files.filter(file => file.existing).length;

                if (newImagesCount + oldImagesCount < 1) {
                    $(".error-image").text("Please select at least 1 image.");
                    return;
                }
                $(".error-image").text("");

                const formData = new FormData(eventForm[0]);
                existingEventImages.forEach(image => formData.append("existing_images[]", image));

                $.ajax({
                    url: eventForm.attr("action"),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: response => {
                        eventIdField.val(response.event_id);

                        if (newImagesCount) {
                            eventForm.data("submitted", true);
                            showImageDropzone.processQueue();
                        } else {
                            $.post("{{ route('update_File') }}", {
                                _token: csrfToken,
                                event_id: response.event_id,
                                existing_images: existingEventImages
                            }).done(() => {
                                Swal.fire("Success", "Event updated successfully!",
                                        "success")
                                    .then(() => location.href =
                                        "{{ route('admin.manageEvent') }}");
                            });
                        }
                    },
                    error: () => Swal.fire("Error", "Something went wrong", "error")
                });
            });

            // After all uploads complete
            showImageDropzone.on("queuecomplete", () => {
                if (eventForm.data("submitted")) {
                    Swal.fire("Success", "Event updated successfully!", "success")
                        .then(() => location.href = "{{ route('admin.manageEvent') }}");
                }
            });
        });
    </script>
@endpush
