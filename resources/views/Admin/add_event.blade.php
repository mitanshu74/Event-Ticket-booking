@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add event')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" id="backButton"
                            class="btn btn-success rounded text-white">Back</a>
                    </div>

                    <div class="card-body">

                        <form class="g-3 needs-validation" id="eventform" method="POST"
                            action="{{ route('admin.storeEvent') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label class="form-label"><b>Name</b></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" placeholder="Enter Event Name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label class="form-label"><b>Date</b></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" value="{{ old('date', date('Y-m-d')) }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                        name="start_time" id="start_time" value="{{ old('start_time') }}"
                                        placeholder="Enter Start Time">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3 mx-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                        name="end_time" id="end_time" value="{{ old('end_time') }}"
                                        placeholder="Enter End Time">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label class="form-label"><b>Location</b></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        name="location" value="{{ old('location') }}" placeholder="Enter Event Location">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label class="form-label"><b>Price</b></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price') }}" placeholder="Enter Event Price">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mx-2 mb-3">
                                <div class="col-md-6 mt-3">
                                    <label class="form-label"><b>Tickets</b></label>
                                    <input type="number" class="form-control @error('total_tickets') is-invalid @enderror"
                                        name="total_tickets" value="{{ old('total_tickets') }}"
                                        placeholder="Enter Total Tickets">
                                    @error('total_tickets')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mx-3 mb-3">
                                <label class="form-label"><b>Images</b></label>
                                <div class="dropzone border rounded  @error('image') is-invalid @enderror"
                                    id="dropzoneArea">
                                </div>

                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

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

    {{-- <script>
            const imageList = []; // 🔹 store files temporarily in memory

        Dropzone.autoDiscover = false;

        $(function() {
            const mydropzone = new Dropzone("#dropzoneArea", {
                url: "#", // No direct upload (handled via form submit)
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5, // in MB
                addRemoveLinks: true,
                acceptedFiles: ".jpg,.jpeg,.png,.gif",
                dictDefaultMessage: "Drag & drop or click to upload images",
                paramName: "image[]"
            });

            // Form submit: attach Dropzone files to form
            $("#eventform").on("submit", function(e) {
                // Create a DataTransfer to append files to form
                const dropzonefile = new DataTransfer();
                mydropzone.getAcceptedFiles().forEach(file => dropzonefile.items.add(file));

                // Create hidden file input and append
                const input = document.createElement("input");
                input.type = "file";
                input.name = "image[]";
                input.multiple = true;
                input.files = dropzonefile.files;
                input.hidden = true;

                this.appendChild(input);
            });
        });
    </script> --}}
    <script>
        const form = document.getElementById('eventform');
        const overlay = document.getElementById('loading-overlay');

        form.addEventListener('submit', function() {
            overlay.style.display = 'flex';
        });

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
