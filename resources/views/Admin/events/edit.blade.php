@extends('Admin.layout.partials.master')
@section('title', 'Admin - Edit Event')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Event</h4>
                        <a href="{{ route('event.index') }}" id="backButton"
                            class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form id="editform" method="POST" action="{{ route('event.update', $event->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.events.form')
                            <div class="row mt-3 mx-3">
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>
                            </div>
                        </form>

                        <div id="loading-overlay">
                            <div class="spinner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function initTimePicker(selector) {
                flatpickr(selector, {
                    enableTime: true,
                    noCalendar: true,
                    altInput: true,
                    altFormat: "h:i K", // Display 12-hour format with AM/PM
                    dateFormat: "H:i", // Submit value in 24-hour format
                    time_24hr: false, // Show AM/PM selector
                    defaultHour: 12, // Default to 12:00
                    defaultMinute: 0
                });
            }

            initTimePicker("#start_time");
            initTimePicker("#end_time");
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        $('#backButton').on('click', function() {
            localStorage.removeItem('event_images');
        });
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            const localKey = "event_images";

            let existingImages = @json(json_decode($event->image ?? '[]'));
            localStorage.setItem(localKey, JSON.stringify(existingImages));

            const myDropzone = new Dropzone("#dropzoneArea", {
                url: "#", // 
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5,
                addRemoveLinks: true,
                acceptedFiles: ".jpg,.jpeg,.png,.gif",
                dictDefaultMessage: "Drag & drop or click to upload images",

                init: function() {
                    const dz = this;

                    existingImages.forEach(path => {
                        const mockFile = {
                            name: path.split("/").pop(),
                            size: 12345,
                            accepted: true,
                            existing: true,
                            path: path
                        };
                        dz.emit("addedfile", mockFile);
                        dz.emit("thumbnail", mockFile, "{{ asset('storage') }}/" + path);
                        dz.emit("complete", mockFile);
                        dz.files.push(mockFile);
                        $(mockFile.previewElement).addClass("dz-success dz-complete");
                    });

                    dz.on("removedfile", file => {
                        let images = JSON.parse(localStorage.getItem(localKey) || "[]");
                        const removeItem = file.path || file.dataUrl;
                        images = images.filter(img => img !== removeItem);
                        localStorage.setItem(localKey, JSON.stringify(images));
                    });
                }
            });

            myDropzone.on("thumbnail", (file, dataUrl) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const base64 = e.target.result;
                    let stored = JSON.parse(localStorage.getItem(localKey) || "[]");

                    stored.push(base64);
                    localStorage.setItem(localKey, JSON.stringify(stored));

                    file.dataUrl = base64;
                };
                reader.readAsDataURL(file);
            });


            $("#editform").on("submit", function(e) {
                // e.preventDefault(); 
                const dropzonefile = new DataTransfer();

                myDropzone.getAcceptedFiles().forEach(file => {
                    if (!file.existing) dropzonefile.items.add(file);
                });

                const storedImages = JSON.parse(localStorage.getItem(localKey) || "[]");

                const existingInput = document.createElement("input");
                existingInput.type = "hidden";
                existingInput.name = "existing_images";
                existingInput.value = JSON.stringify(storedImages);
                this.appendChild(existingInput);

                const input = document.createElement("input");
                input.type = "file";
                input.name = "image[]";
                input.multiple = true;
                input.hidden = true;
                input.files = dropzonefile.files;
                document.getElementById("editform").appendChild(input);

            });
        });
    </script>
@endpush
