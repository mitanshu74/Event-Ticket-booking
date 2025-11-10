@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add event')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add Event</h4>
                        <a href="{{ route('event.index') }}" id="backButton"
                            class="btn btn-success rounded text-white">Back</a>
                    </div>

                    <div class="card-body">

                        <form class="g-3 needs-validation" id="eventform" method="POST" action="{{ route('event.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @include('admin.events.form')
                            <div class="row">
                                <div class="col-12 m-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        $('#backButton').on('click', function() {
            localStorage.removeItem('event_images');
        });

        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            const dropzoneId = "#dropzoneArea";
            const localKey = "event_images";

            const dataURLToFile = (dataUrl, filename) => {
                const [meta, base64] = dataUrl.split(',');
                const mime = meta.match(/:(.*?);/)[1];
                const bin = atob(base64);
                const arr = new Uint8Array(bin.length);
                for (let i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
                return new File([arr], filename, {
                    type: mime
                });
            };

            const savedImages = JSON.parse(localStorage.getItem(localKey) || "[]");

            const mydropzone = new Dropzone(dropzoneId, {
                url: "#",
                autoProcessQueue: false,
                addRemoveLinks: true,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5,
                acceptedFiles: ".jpg,.jpeg,.png,.gif",
                dictDefaultMessage: "Drag & drop or click to upload images",
            });

            savedImages.forEach((dataUrl, index) => {
                const mockFile = {
                    name: `saved-${index}.png`,
                    size: 12345,
                    dataUrl
                };
                mydropzone.emit("addedfile", mockFile);
                mydropzone.emit("thumbnail", mockFile, dataUrl);
                mydropzone.emit("complete", mockFile);
                mydropzone.files.push(mockFile);
            });

            mydropzone.on("thumbnail", function(file, dataUrl) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64 = e.target.result;
                    let existing = JSON.parse(localStorage.getItem(localKey) || "[]");

                    existing.push(base64);

                    localStorage.setItem(localKey, JSON.stringify(existing));
                    file.dataUrl = base64;
                };
                reader.readAsDataURL(file);
            });

            mydropzone.on("removedfile", function(file) {
                let existing = JSON.parse(localStorage.getItem(localKey) || "[]");

                if (file.dataUrl) {
                    existing = existing.filter(img => img !== file.dataUrl);
                    localStorage.setItem(localKey, JSON.stringify(existing));
                    // console.log("LocalStorage updated ", existing);
                }
            });

            $("#eventform").on("submit", function() {
                const dropzonefile = new DataTransfer();
                const acceptedFiles = mydropzone.getAcceptedFiles();

                if (acceptedFiles.length > 0) {
                    acceptedFiles.forEach(file => dropzonefile.items.add(file));
                } else {
                    const storedImages = JSON.parse(localStorage.getItem(localKey) || "[]");
                    storedImages.forEach((dataUrl, index) => {
                        const file = dataURLToFile(dataUrl, `restored-${index}.png`);
                        dropzonefile.items.add(file);
                    });
                }

                const input = document.createElement("input");
                input.type = "file";
                input.name = "image[]";
                input.multiple = true;
                input.hidden = true;
                input.files = dropzonefile.files;

                document.getElementById("eventform").appendChild(input);
            });
        });
    </script>
@endpush
