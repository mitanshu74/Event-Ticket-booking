@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add event')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="g-3 needs-validation demoform" id="demoform" method="POST"
                            action="{{ route('admin.storeEvent') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            {{-- Event Name --}}
                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Name" class="form-label"><b>Name</b></label>
                                    <input type="text" class="form-control" name="name" id="Name"
                                        placeholder="Enter Event Name" value="{{ old('name') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            {{-- Event Date --}}
                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Date" class="form-label"><b>Date</b></label>
                                    <input type="date" class="form-control" name="date" id="Date"
                                        value="{{ old('date') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            {{-- Start & End Time --}}
                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="time" class="form-control" name="start_time" id="start_time"
                                        value="{{ old('start_time') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="time" class="form-control" name="end_time" id="end_time"
                                        value="{{ old('end_time') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Location" class="form-label"><b>Location</b></label>
                                    <input type="text" class="form-control" name="location" id="Location"
                                        placeholder="Enter Event Location" value="{{ old('location') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Price" class="form-label"><b>Price</b></label>
                                    <input type="number" class="form-control" name="price" id="Price"
                                        placeholder="Enter Event Price" value="{{ old('price') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            {{-- Tickets --}}
                            <div class="row mx-2 mb-3">
                                <div class="col-md-6 mt-3">
                                    <label for="total_tickets" class="form-label"><b>Tickets</b></label>
                                    <input type="number" class="form-control" name="total_tickets" id="total_tickets"
                                        placeholder="Enter Event Tickets" value="{{ old('total_tickets') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <input type="hidden" class="event_id" name="event_id" id="event_id" value="">

                            {{-- Image Dropzone --}}
                            <div class="row mx-3">
                                <label for="Image" class="form-label"><b>Image</b></label>
                                <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                    <span>Drag & drop or click to upload</span>
                                    <div class="dropzone-previews"></div>
                                </div>
                                <p class="error-image text-danger"></p>
                            </div>

                            {{-- Submit --}}
                            <div class="row">
                                <div class="col-12 m-3">
                                    <button class="btn btn-primary" id="submitBtn" type="submit">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- 
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        $(function() {
            let dz = new Dropzone("#dropzoneDragArea", {
                url: "{{ route('store_file') }}",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5, // file max 2 MB
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                addRemoveLinks: true,
                dictRemoveFile: "Remove"
            });

            dz.on("sending", (file, xhr, formData) => {
                formData.append("event_id", $("#event_id").val());
                $("form#demoform").serializeArray().forEach(f => formData.append(f.name, f.value));
            });

            dz.on("queuecomplete", () => {
                Swal.fire("Success", "Event & images saved!", "success")
                    .then(() => window.location.href = "{{ route('admin.manageEvent') }}");
            });

            $("#demoform").submit(function(e) {
                e.preventDefault();
                let form = this;

                // Clear previous errors
                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback.ajax-error").text('');
                $('.error-image').text('');
                // Check if any image is uploaded
                if (dz.getQueuedFiles().length === 0) {
                    $('.error-image').text('The image field is required.');
                    $('#dropzoneDragArea').addClass('is-invalid');
                    return false; // Stop here, don't insert event
                }
                // Collect form data
                let formData = new FormData(form);

                // AJAX validation for fields first
                $.ajax({
                    url: form.action,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: res => {
                        // Insert event ID from response
                        $("#event_id").val(res.event_id);

                        // Count total images: existing + queued
                        let totalImages = dz.files.filter(file => file.existing).length + dz
                            .getQueuedFiles().length;

                        if (totalImages < 1) {
                            $('.error-image').text('The image field is required.');
                            $('#dropzoneDragArea').addClass('is-invalid');
                            return false; // stop if no images
                        }

                        // ✅ Process Dropzone files
                        dz.processQueue();
                    },
                    error: xhr => {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Show validation errors for all fields
                            Object.keys(errors).forEach(key => {
                                let field = $("[name='" + key + "']");
                                if (field.length) {
                                    field.addClass("is-invalid")
                                        .next(".invalid-feedback.ajax-error")
                                        .text(errors[key][0]);
                                }
                            });

                            // Still check images
                            let totalImages = dz.files.filter(f => f.existing).length + dz
                                .getQueuedFiles().length;
                            if (totalImages < 1) {
                                $('.error-image').text('The image field is required.');
                                $('#dropzoneDragArea').addClass('is-invalid');
                            }
                        } else {
                            Swal.fire("Error", "Something went wrong", "error");
                        }
                    }
                });
            });


        });
    </script>
@endpush --}}

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        $(function() {
            let dz = new Dropzone("#dropzoneDragArea", {
                url: "{{ route('store_file') }}",
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                addRemoveLinks: true,
                dictRemoveFile: "Remove",
                acceptedFiles: ".jpeg,.jpg,.png,.gif" // ✅ allow images + docs
            });


            // When sending each file, include event_id
            dz.on("sending", function(file, xhr, formData) { //  xhr -> XMLHttpRequest object used for this upload.
                formData.append("event_id", $("#event_id").val());
            });

            // After all files finish uploading
            dz.on("queuecomplete", function() {
                Swal.fire("Success", "Event & images saved successfully!", "success")
                    .then(() => window.location.href = "{{ route('admin.manageEvent') }}");
            });

            // On form submit — first save event, then upload images
            $("#demoform").submit(function(e) {
                e.preventDefault();
                let form = this;

                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback.ajax-error").text('');
                $('.error-image').text('');

                if (dz.getQueuedFiles().length === 0) {
                    $('.error-image').text('The image field is required.');
                    $('#dropzoneDragArea').addClass('is-invalid');
                    return false;
                }

                let formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.status === "success") {
                            $("#event_id").val(res.event_id);

                            // Now process Dropzone uploads
                            dz.processQueue();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            Object.keys(errors).forEach(key => {
                                let field = $("[name='" + key + "']");
                                if (field.length) {
                                    field.addClass("is-invalid")
                                        .next(".invalid-feedback.ajax-error")
                                        .text(errors[key][0]);
                                }
                            });

                            if (dz.getQueuedFiles().length === 0) {
                                $('.error-image').text('The image field is required.');
                                $('#dropzoneDragArea').addClass('is-invalid');
                            }
                        } else {
                            Swal.fire("Error", "Something went wrong", "error");
                        }
                    }
                });
            });
        });
    </script>
@endpush
